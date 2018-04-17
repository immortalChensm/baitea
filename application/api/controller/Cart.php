<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 商业用途务必到官方购买正版授权, 使用盗版将严厉追究您的法律责任。
 * ============================================================================
 * $Author: IT宇宙人 2015-08-10 $
 */ 
namespace app\api\controller; 

use app\common\logic\CartLogic;
use app\common\logic\GoodsLogic;
use app\common\logic\OrderLogic;
use app\common\logic\CouponLogic;
use app\common\logic\IntegralLogic;
use app\common\model\Goods;
use app\common\model\ShippingArea;
use app\common\model\SpecGoodsPrice;
use think\Db;

class Cart extends Base {
    /**
     * 析构流函数
     */
    public function  __construct() {   
        parent::__construct();
        $unique_id = I("unique_id"); // 唯一id  类似于 pc 端的session id
        // 给用户计算会员价 登录前后不一样
        if($this->user_id){
            $user = M('users')->where("user_id", $this->user_id)->find();
            M('Cart')->execute("update `__PREFIX__cart` set member_goods_price = goods_price * {$user[discount]} where (user_id ={$user[user_id]} or session_id = '{$unique_id}') and prom_type = 0");        
        }
    }

    /**
     * 将商品加入购物车
     */
    function addCart()
    {
        $goods_id = I("goods_id/d"); // 商品id
        $goods_num = I("goods_num/d");// 商品数量
        $item_id = I("item_id/d"); // 商品规格id
        $unique_id = I("unique_id"); // 唯一id  类似于 pc 端的session id
        
        if(empty($goods_id)) {
            $this->ajaxReturn(['status'=>0,'msg'=>'请选择要购买的商品','result'=>'']);
        }
        if(empty($goods_num)) {
           $this->ajaxReturn(['status'=>0,'msg'=>'购买商品数量不能为0','result'=>'']);
        }
        
        $cartLogic = new CartLogic();
        $cartLogic->setGoodsModel($goods_id);
        $cartLogic->setUniqueId($unique_id);
        $cartLogic->setUserId($this->user_id);
        if ($item_id) {
            $cartLogic->setSpecGoodsPriceModel($item_id);
        }
        $cartLogic->setGoodsBuyNum($goods_num);
        $result = $cartLogic->addGoodsToCart(); // 将商品加入购物车
        $this->ajaxReturn($result);
    }
    
    /**
     * 删除购物车的商品
     */
    public function delCart()
    {       
        $ids = I("ids"); // 商品 ids        
        $result = M("Cart")->where("id","in", $ids)->delete(); // 删除id为5的用户数据
        
        // 查找购物车数量
        $unique_id = I("unique_id"); // 唯一id  类似于 pc 端的session id
        $cartLogic = new CartLogic();
        $cartLogic->setUniqueId($unique_id);
        $cart_count =  $cartLogic->getUserCartGoodsNum();
        $return_arr = array('status'=>1,'msg'=>'删除成功','result'=>$cart_count); // 返回结果状态       
        $this->ajaxReturn($return_arr);
    }
    
    /*
     * 请求获取购物车列表
     */
    public function cartList()
    {                    
        $cart_form_data = $_POST["cart_form_data"]; // goods_num 购物车商品数量
        $cart_form_data = json_decode($cart_form_data,true); //app 端 json 形式传输过来                
        $unique_id = I("unique_id/s"); // 唯一id  类似于 pc 端的session id
        $unique_id = empty($unique_id) ? -1 : $unique_id;
        $where['session_id'] = $unique_id; // 默认按照 $unique_id 查询
        $store_where = "session_id = '{$unique_id}'";
        // 如果这个用户已经登录则按照用户id查询
        if ($this->user_id) {
            unset($where);
            $where['user_id'] = $this->user_id;
            $store_where  = "user_id = ".$this->user_id;
        } 
        $cartList = M('Cart')->where($where)->getField("id,goods_num,selected"); 
        
        $cartLogic = new CartLogic();
        $cartLogic->setUserId($this->user_id);
        $cartLogic->setUniqueId($unique_id);
        
        if ($cart_form_data) {
            $updateData = [];
            // 修改购物车数量 和勾选状态
            foreach ($cart_form_data as $key => $val) {
                if (!isset($cartList[$val['cartID']])) {
                    continue;
                }
                $updateData[$key]['goods_num'] = $val['goodsNum'];
                $updateData[$key]['selected'] = $val['selected'];
                $updateData[$key]['id'] = $val['cartID'];
                if ($cartList[$val['cartID']]['goods_num'] != $val['goodsNum']) {
                    $changeResult = $cartLogic->changeNum($val['cartID'], $val['goodsNum']);
                    if ($changeResult['status'] != 1) {
                        $this->ajaxReturn($changeResult);
                    }
                    break;
                }
            }
            if ($updateData) {
                $cartLogic->AsyncUpdateCart($updateData);
            }
        } 
        $cartList = $cartLogic->getCartList(1);// 选中的商品
 
        $result['total_price'] = $cartLogic->getCartPriceInfo($cartList);
 
        if($result['total_price']){
            $result['total_price']['cut_fee'] = $result['total_price']['goods_fee'];
            
            unset($result['total_price']['goods_fee']);
            unset($result['total_price']['goods_num']);
        }
        $cartList = $cartLogic->getCartList(0);// 所有的商品
        $cart_count = 0;
        foreach($cartList as $cartKey=>$cart){
            $cart['store_count'] = $cart['goods']['store_count'];
            $cart_count += $cart['goods_num'];//重新计算购物车商品数量
             unset($cart['goods']); 
        }
        
        $storeList = M('store')->where("store_id in(select store_id from ".C('database.prefix')."cart where ( {$store_where})  )")->getField("store_id,store_name,store_logo,is_own_shop"); // 找出商家
        foreach($storeList as $k => $v)
        {
            $store = array("store_id"=>$k,'store_name'=>$v['store_name'],'store_logo'=>$v['store_logo'],'is_own_shop'=>$v['is_own_shop']);
            foreach($cartList as $k2 => $v2)
            {
                if($v2['store_id'] == $k){
                    $store['cartList'][] = $v2;
                }
            }
            $result['storeList'][] = $store;
        }
         
        $result['total_price']['num'] = $cart_count;
        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $result]);
    }

    /**
     * 购物车第二步确定页面
     * 此方法是点击立即购买或是去购物车结算时要显示的页面
     */
    public function cart2(){
        $goods_id = input("goods_id/d"); // 商品id
        $goods_num = input("goods_num/d");// 商品数量
        $item_id = input("item_id/d"); // 商品规格id
        $action = input("action"); // 行为
        if ($this->user_id == 0){
            $this->ajaxReturn(array('status'=>-1,'msg'=>'用户user_id不能为空','result'=>''));
        }
        $address_id = I('address_id/d');
        //获取地址
        if ($address_id) {
            $userAddress = M('UserAddress')->where(['user_id' => $this->user_id, 'address_id' => $address_id])->find();
        }
        if (!$address_id || !$userAddress) {
            $addresslist = M('UserAddress')->where("user_id = {$this->user_id}")->select();
            $userAddress = $addresslist[0];
            foreach ($addresslist as $address) {
                if ($address['is_default'] == 1) {
                    $userAddress = $address;
                    break;
                }
            }
        }

        if(empty($userAddress)){
            $this->ajaxReturn(['status' => -1, 'msg' => '请先添加收货地址', 'result' => null]);// 返回结果状态
        }else{
            $userAddress['total_address'] = getTotalAddress($userAddress['province'], $userAddress['city'], $userAddress['district'], $userAddress['twon'], $userAddress['address']);
        }

        $cartLogic = new CartLogic();
        $couponLogic = new CouponLogic();
        $cartLogic->setUserId($this->user_id);
        //立即购买
        if($action == 'buy_now'){
            if(empty($goods_id)){
                $this->ajaxReturn(['status' => 0, 'msg' => '请选择要购买的商品', 'result' => null]);// 返回结果状态
            }
            if(empty($goods_num)){
                $this->ajaxReturn(['status' => 0, 'msg' => '购买商品数量不能为0', 'result' => null]);// 返回结果状态
            }
            $cartLogic->setGoodsModel($goods_id);
            if($item_id){
                $cartLogic->setSpecGoodsPriceModel($item_id);
            }
            $cartLogic->setGoodsBuyNum($goods_num);
            $result = $cartLogic->buyNow();
            if($result['status'] != 1){
                $this->ajaxReturn(['status' => 0, 'msg' =>$result['msg']]);
            }
            $cartList[0] = $result['result']['buy_goods'];
            $cartGoodsTotalNum = $goods_num;
        }else{
            if ($cartLogic->getUserCartOrderCount() == 0){
                $this->ajaxReturn(['status' => 0, 'msg' => '你的购物车没有选中商品', 'result' => null]);// 返回结果状态
            }
            $cartList = $cartLogic->getCartList(1); // 获取用户选中的购物车商品
            $cartGoodsTotalNum = array_sum(array_map(function($val){return $val['goods_num'];}, $cartList));//购物车购买的商品总数
        }

        $usersInfo = get_user_info($this->user_id);  // 用户

        $cartGoodsList = get_arr_column($cartList,'goods');
        $cartGoodsId = get_arr_column($cartGoodsList,'goods_id');
        $cartGoodsCatId = get_arr_column($cartGoodsList,'cat_id3');
        $storeCartList = $cartLogic->getStoreCartList($cartList);//转换成带店铺数据的购物车商品
        $storeCartTotalPrice= array_sum(array_map(function($val){return $val['store_goods_price'];}, $storeCartList));//商品优惠总价
        $storeShippingCartList = $cartLogic->getShippingCartList($storeCartList);//转换成带物流数据的购物车商品
        $userCouponList = $couponLogic->getUserAbleCouponList($this->user_id, $cartGoodsId, $cartGoodsCatId);//用户可用的优惠券列表
        $userCartCouponList = $cartLogic->getCouponCartList($storeCartList, $userCouponList);
        $UserStoreCouponNum = $cartLogic->getUserStoreCouponNumArr();
        $couponNum = !empty($UserStoreCouponNum) ? $UserStoreCouponNum : [];
        $json_arr = array(
            'status'=>1,
            'msg'=>'获取成功',
            'result'=>array(
                'addressList' =>$userAddress, // 收货地址
                'userCartCouponList'=>$userCartCouponList,  //用户可用的优惠券列表
                'couponNum'=>$couponNum,  //用户可用的优惠券列表
                'cartGoodsTotalNum'=>$cartGoodsTotalNum,   //购物车购买的商品总数
                'storeShippingCartList'=>$storeShippingCartList,//购物车列表
                'storeCartTotalPrice'=>$storeCartTotalPrice,//商品总价
                'userInfo'    =>$usersInfo, // 用户详情
            ));
        $this->ajaxReturn($json_arr) ;
    }

    /**
     * ajax 获取订单商品价格 或者提交 订单
     * 
     * 此方法完成订单生成　即订单保存入库
     * <input type="hidden" name="address_id" value="35">
    <input type="hidden" name="pay_points" value="">
    <input type="hidden" name="user_money" value="">
    <input type="hidden" name="invoice_title" value="个人">
    <input type="hidden" name="paypwd" value="" hidden="">
    <!--立即购买才会用到-s-->
    <input type="hidden" name="action" value="buy_now">
    <input type="hidden" name="goods_id" value="166">
    <input type="hidden" name="item_id" value="">
    <input type="hidden" name="goods_num" value="1">
    <!--立即购买才会用到-e-->
            <input type="hidden" name="shipping_code[1]" value="shentong">
        <input type="hidden" name="user_note[1]" value="">
     */
    public function cart3()
    {
        if ($this->user_id == 0){
            $this->ajaxReturn(['status' => -100, 'msg' => "登录超时请重新登录!", 'result' => null]);// 返回结果状态
        }
        $goods_id = input("goods_id/d"); // 商品id
        $goods_num = input("goods_num/d");// 商品数量
        $item_id = input("item_id/d"); // 商品规格id
        $action = input("action"); // 立即购买
        $address_id = I("address_id/d"); //  收货地址id
        $invoice_title = I('invoice_title'); // 发票
        $pay_points =  I("pay_points/d",0); //  使用积分
        $user_money =  I("user_money/f",0); //  使用余额
        $user_money = $user_money ? $user_money : 0;

        $cart_form_data = $_POST["cart_form_data"]; // goods_num 购物车商品数量
        $cart_form_data = json_decode($cart_form_data,true); //app 端 json 形式传输过来
        //$shipping_code    = $cart_form_data['shipping_code']; // $shipping_code =  I("shipping_code"); //  物流编号  数组形式
        $user_note        = $cart_form_data['user_note'] ?: ''; // $user_note = I('user_note'); // 给卖家留言      数组形式
        $coupon_id        = $cart_form_data['coupon_id'] ?: 0; // $coupon_id =  I("coupon_id/d",0); //  优惠券id  数组形式
//print_r($cart_form_data);
        $user_money = $user_money ? $user_money : 0;
        $cartLogic = new CartLogic();

        $cartLogic->setUserId($this->user_id);
        if($action == 'buy_now'){
            $cartLogic->setGoodsModel($goods_id);
            if($item_id){
                $cartLogic->setSpecGoodsPriceModel($item_id);
            }
            $cartLogic->setGoodsBuyNum($goods_num);
            $result = $cartLogic->buyNow();
            if($result['status'] != 1){
                $this->ajaxReturn($result);
            }
            $order_goods[0] = $result['result']['buy_goods'];
        }else{
            $userCartList = $cartLogic->getCartList(1);
            if($userCartList){
                $order_goods = collection($userCartList)->toArray();
            }else{
                exit(json_encode(array('status'=>-2,'msg'=>'你的购物车没有选中商品','result'=>null))); // 返回结果状态
            }
            foreach ($userCartList as $cartKey => $cartVal) {
                if($cartVal->goods_num > $cartVal->limit_num){
                    exit(json_encode(['status' => 0, 'msg' => $cartVal->goods_name.'购买数量不能大于'.$cartVal->limit_num, 'result' => ['limit_num'=>$cartVal->limit_num]]));
                }
            }
        }
        if (!$address_id) {
            $this->ajaxReturn(['status' => -3, 'msg' => '请先填写收货人信息', 'result' => null]);
        }
        
        //if (!$shipping_code) {
        //    $this->ajaxReturn(['status' => -4, 'msg' => '请选择物流信息', 'result' => null]);
        //}
        
        $address = M('UserAddress')->where("address_id", $address_id)->find();
        $result = calculate_price($this->user_id, $order_goods, $shipping_code, $address['province'], $address['city'], $address['district'], $pay_points, $user_money, $coupon_id);
        if ($result['status'] < 0){
            exit(json_encode($result));
        }
        $car_price = array(
            'postFee' => $result['result']['shipping_price'], // 物流费
            'couponFee' => $result['result']['coupon_price'], // 优惠券
            'balance' => $result['result']['user_money'], // 使用用户余额
            'pointsFee' => $result['result']['integral_money'], // 积分支付
            'payables' => number_format(array_sum($result['result']['store_order_amount']), 2, '.', ''), // 订单总额 减去 积分 减去余额 减去优惠券 优惠活动
            'goodsFee' => $result['result']['goods_price'],// 总商品价格
            'order_prom_amount' => array_sum($result['result']['store_order_prom_amount']), // 总订单优惠活动优惠了多少钱

            'store_order_prom_id' => $result['result']['store_order_prom_id'], // 每个商家订单优惠活动的id号
            'store_order_prom_amount' => $result['result']['store_order_prom_amount'], // 每个商家订单活动优惠了多少钱
            'store_order_prom_money' => $result['result']['store_order_prom_money'], // 每个商家订单活动优惠需满足的金额
            'store_order_amount' => $result['result']['store_order_amount'], // 每个商家订单优惠后多少钱, -- 应付金额
            'store_shipping_price' => $result['result']['store_shipping_price'],  //每个商家的物流费
            'store_coupon_price' => $result['result']['store_coupon_price'],  //每个商家的优惠券抵消金额
            'store_point_count' => $result['result']['store_point_count'], // 每个商家平摊使用了多少积分
            'store_balance' => $result['result']['store_balance'], // 每个商家平摊用了多少余额
            'store_goods_price' => $result['result']['store_goods_price'], // 每个商家的商品总价
            'store_order_prom_title'=>$result['result']['store_order_prom_title'],
            'goods_shipping'=>$result['result']['goods_shipping']
        );
        // 提交订单
        if ($_REQUEST['act'] == 'submit_order') {
            // 排队人数
            $queue = \think\Cache::get('queue');
            if($queue >= 100){
                exit(json_encode(array('status' => -99, 'msg' => "当前人数过多请耐心排队!".$queue, 'result' => null))); // 返回结果状态
            }else{
                \think\Cache::inc('queue',1);
            }
            if($pay_points>0 || $user_money>0){
                if($this->user['is_lock'] == 1){
                    exit(json_encode(array('status'=>-5,'msg'=>"账号异常已被锁定，不能使用积分或余额支付！",'result'=>null))); // 用户被冻结不能使用余额支付
                }
                $paypwd = trim(I('paypwd')); // 支付密码
                if($paypwd != $this->user['paypwd']){
                    exit(json_encode(array('status'=>-5,'msg'=>"支付密码错误！",'result'=>null)));
                }
            }

            $orderLogic = new OrderLogic();
            $orderLogic->setAction($action);
            $orderLogic->setCartList($order_goods);
            
            //print_r($car_price);
            //exit();
           
            $result = $orderLogic->addOrder($this->user_id, $address_id, $shipping_code, $invoice_title, $coupon_id, $car_price, $user_note); // 添加订单
            // 这个人处理完了再减少
            \think\Cache::dec('queue');
            exit(json_encode($result));
        }
        $return_arr = array('status' => 1, 'msg' => '计算成功', 'result' => $car_price); // 返回结果状态
        exit(json_encode($return_arr));
    }
 
    /**
     * 订单支付页面
     */
    public function cart4()
    {
        // 如果是主订单号过来的, 说明可能是合并付款的
        $master_order_sn = I('master_order_sn','');
        $order_sn = I('order_sn','');
        $order_id = I('order_id','');
        $select_order_where = empty($master_order_sn) ? $order_sn : $master_order_sn;
        $select_order_where = empty($select_order_where) ? $order_id : $select_order_where;
        if (!$select_order_where) {
            $this->ajaxReturn(['status'=>-1, 'msg'=>'参数错误']);
        }
        $sum_order_amount = M('order')->where("order_sn|master_order_sn|order_id", $select_order_where)->sum('order_amount');
        if (!is_numeric($sum_order_amount)) {
            $this->ajaxReturn(['status'=>-1, 'msg'=>'订单不存在']);
        }
        $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result' => $sum_order_amount]);
    }    
    
    /**
     * 优惠券兑换
     */
    public function coupon_exchange()
    {
        $coupon_code = input('coupon_code');
        $couponLogic = new \app\common\logic\CouponLogic;
        $return = $couponLogic->exchangeCoupon($this->user_id, $coupon_code);
        if ($return['status'] != 1) {
            $this->ajaxReturn($return);
        }
        $limit_store = '平台';
        $store_id = $return['result']['coupon']['store_id'];
        if ($store_id) {
            $store = \app\common\model\Store::get($store_id);
            $limit_store = $store['store_name'];
        }
        $return['result']['coupon']['limit_store'] = $limit_store;
        $this->ajaxReturn($return);
    }


    /**
     * ajax 获取用户收货地址 用于购物车确认订单页面
     */
    public function ajaxAddress()
    {
        $address_id = I('address_id/d');
        //获取地址
        if ($address_id) {
            $userAddress = M('UserAddress')->where(['user_id' => $this->user_id, 'address_id' => $address_id])->find();
        }
        if (!$address_id || !$userAddress) {
            $addresslist = M('UserAddress')->where(['user_id' => $this->user_id])->select();
            $userAddress = $addresslist[0];
            foreach ($addresslist as $address) {
                if ($address['is_default'] == 1) {
                    $userAddress = $address;
                    break;
                }
            }
        }
        if ($userAddress) {
            $userAddress['total_address'] = getTotalAddress($userAddress['province'], $userAddress['city'], $userAddress['district'], $userAddress['twon'], $userAddress['address']);
        }
        if(empty($userAddress)){
            $this->ajaxReturn(['status' => -1, 'msg' => '请先添加收货地址', 'result' => null]);// 返回结果状态
        }
        $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result'=>$userAddress]);
    }


    /**
     *  积分商品结算页 1
     * @return mixed
     */
    public function integral(){
        if(IS_POST) {
            $goods_id = input('goods_id/d');
            $item_id = input('item_id/d');
            $goods_num = input('goods_num/d');
            $address_id = input('address_id/d');
            if (empty($goods_id)) {
                $this->ajaxReturn(['status' => 0, 'msg' => '非法操作']);
            }
            if (empty($goods_num)) {
                $this->ajaxReturn(['status' => 0, 'msg' => '购买数不能为零']);
            }
            $Goods = new Goods();
            $goods = $Goods->with('store')->where(['goods_id' => $goods_id])->find();
            if (empty($goods)) {
                $this->ajaxReturn(['status' => 0, 'msg' => '该商品不存在']);
            }
            //获取地址
            if ($address_id) {
                $userAddress = M('UserAddress')->where(['user_id' => $this->user_id, 'address_id' => $address_id])->find();
            }
            if (!$address_id || !$userAddress) {
                $addresslist = M('UserAddress')->where(['user_id' => $this->user_id])->select();
                $userAddress = $addresslist[0];
                foreach ($addresslist as $address) {
                    if ($address['is_default'] == 1) {
                        $userAddress = $address;
                        break;
                    }
                }
            }
            if(empty($userAddress)){
                $this->ajaxReturn(['status' => -1, 'msg' => '请先添加收货地址', 'result' => null]);// 返回结果状态
            }else{
                $userAddress['total_address'] = getTotalAddress($userAddress['province'], $userAddress['city'], $userAddress['district'], $userAddress['twon'], $userAddress['address']);
            }

            if (empty($item_id)) {
                $goods_spec_list = SpecGoodsPrice::all(['goods_id' => $goods_id]);
                if (count($goods_spec_list) > 0) {
                    $this->ajaxReturn(['status' => 0, 'msg' => '请传递规格参数']);
                }
                $goods_price = $goods['shop_price'];
                //没有规格
            } else {
                //有规格
                $specGoodsPrice = SpecGoodsPrice::get(['item_id' => $item_id, 'goods_id' => $goods_id]);
                if ($goods_num > $specGoodsPrice['store_count']) {
                    $this->ajaxReturn(['status' => 0, 'msg' => '该商品规格库存不足，剩余' . $specGoodsPrice['store_count'] . '份']);
                }
                $goods_price = $specGoodsPrice['price'];
            }
            $usersInfo = get_user_info($this->user_id);  // 用户
            $ShippingArea = new ShippingArea();
            $shippingAreaList = $ShippingArea->with('plugin')->where(['store_id' => $goods['store_id'], 'is_default' => 1, 'is_close' => 1])->group("shipping_code")->cache(true, TPSHOP_CACHE_TIME)->select();
            $point_rate = tpCache('shopping.point_rate');
            $goods['specGoodsPrice']=$specGoodsPrice;
            $data = [
                'userAddress'=>$userAddress,  //用户地址
                'point_rate' => $point_rate,  //积分比例
                'goods' => $goods,  //商品信息
                'goods_price' => $goods_price,  //商品价格
                'goods_num' => $goods_num,     //商品购买数量
                'shippingAreaList' => $shippingAreaList,   //物流
                'userInfo'    =>$usersInfo, // 用户详情
            ];
            $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $data]);
        }else{
            $this->ajaxReturn(['status' => -100, 'msg' => '请求方式错误！', 'result' => null]);
        }
    }

    /**
     *  积分商品价格提交(计算价格)
     * @return mixed
     */
    public function integral2(){
        if(IS_POST) {
            $goods_id = input('goods_id/d');
            $item_id = input('item_id/d');
            $goods_num = input('goods_num/d');
            $address_id = input("address_id/d"); //  收货地址id
            $shipping_code = input("shipping_code/s"); //  物流编号
            $user_note = input('user_note'); // 给卖家留言
            $invoice_title = input('invoice_title'); // 发票
            $user_money = input("user_money/f", 0); //  使用余额
            $user_money = $user_money ? $user_money : 0;
            if (empty($address_id)){
                $this->ajaxReturn(['status' => -3, 'msg' => '请先填写收货人信息', 'result' => null]);
            }
            if(empty($shipping_code)){
                $this->ajaxReturn(['status' => -4, 'msg' => '请选择物流信息', 'result' => null]);
            }
            $address = Db::name('user_address')->where("address_id", $address_id)->find();
            if(empty($address)){
                $this->ajaxReturn(['status' => -3, 'msg' => '请先填写收货人信息', 'result' => null]);
            }
            $Goods = new Goods();
            $goods = $Goods::get($goods_id);
            $Integral = new IntegralLogic();
            $Integral->setUser($this->user);
            $Integral->setGoods($goods);
            if($item_id){
                $specGoodsPrice = SpecGoodsPrice::get($item_id);
                $Integral->setSpecGoodsPrice($specGoodsPrice);
            }
            $Integral->setAddress($address);
            $Integral->setShippingCode($shipping_code);
            $Integral->setBuyNum($goods_num);
            $Integral->setUserMoney($user_money);
            $result = $Integral->order();
            if ($result['status'] != 1){
                $this->ajaxReturn($result);
            }
            $car_price = array(
                'postFee' => $result['result']['shipping_price'], // 物流费
                'balance' => $result['result']['user_money'], // 使用用户余额
                'payables' => number_format($result['result']['order_amount'], 2, '.', ''), // 订单总额 减去 积分 减去余额 减去优惠券 优惠活动
                'pointsFee' => $result['result']['integral_money'], // 积分抵扣的金额
                'points' => $result['result']['total_integral'], // 积分支付
                'goodsFee' => $result['result']['goods_price'],// 总商品价格
                'goods_shipping'=>$result['result']['goods_shipping']
            );
            // 提交订单
            if ($_REQUEST['act'] == 'submit_order') {
                // 排队人数
                $queue = \think\Cache::get('queue');
                if($queue >= 100){
                    $this->ajaxReturn(['status' => -99, 'msg' => "当前人数过多请耐心排队!".$queue, 'result' => null]);
                }else{
                    \think\Cache::inc('queue',1);
                }
                //购买设置必须使用积分购买，而用户的积分足以支付
                if($this->user['pay_points'] >= $car_price['points'] || $user_money>0){
                    if($this->user['is_lock'] == 1){
                        $this->ajaxReturn(['status'=>-5,'msg'=>"账号异常已被锁定，不能使用积分或余额支付！",'result'=>null]);// 用户被冻结不能使用余额支付
                    }
                    $payPwd =trim(input('pwd'));
                    if($payPwd != $this->user['paypwd'] && ($user_money>0 || $car_price['points']>0)){
                        $this->ajaxReturn(['status'=>-5,'msg'=>"支付密码错误！",'result'=>null]);
                    }
                }
                $result = $Integral->addOrder($invoice_title,$user_note); // 添加订单
                // 这个人处理完了再减少
                \think\Cache::dec('queue');
                $this->ajaxReturn(['status' => 1, 'msg' => '提交订单成功', 'result' => $result['order_sn']]);
            }
            $this->ajaxReturn(['status' => 1, 'msg' => '计算成功', 'result' => $car_price]);
        }else{
            $this->ajaxReturn(['status' => -100, 'msg' => '请求方式错误！', 'result' => null]);
        }
    }
}
