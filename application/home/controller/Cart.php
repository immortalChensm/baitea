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
namespace app\home\controller;

use app\common\logic\CartLogic;
use app\common\logic\CouponLogic;
use app\common\logic\IntegralLogic;
use app\common\logic\OrderLogic;
use app\common\model\Goods;
use app\common\model\ShippingArea;
use app\common\model\SpecGoodsPrice;
use think\Db;

class Cart extends Base
{
    public $user_id = 0;
    public $user = array();
    /**
     * 初始化函数
     */
    public function __construct()
    {
        parent::__construct();
        if (session('?user')) {
            $user = session('user');
            $user = M('users')->cache(true,10)->where("user_id", $user['user_id'])->find();
            session('user', $user);  //覆盖session 中的 user
            $this->user = $user;
            $this->user_id = $user['user_id'];
            $this->assign('user', $user); //存储用户信息
        }
    }

    /**
     * 购物车第一步
     * @return mixed
     */
    public function index(){
        $cartLogic = new CartLogic();
        $cartLogic->setUserId($this->user_id);
        $cartList = $cartLogic->getCartList();//用户购物车
        $storeCartList = $cartLogic->getStoreCartList($cartList);//
        $userCartGoodsTypeNum = $cartLogic->getUserCartGoodsTypeNum();//获取用户购物车商品总数
        $this->assign('userCartGoodsTypeNum', $userCartGoodsTypeNum);
        $this->assign('storeCartList', $storeCartList);//购物车列表
        return $this->fetch();
    }

    /**
     * 更新购物车，并返回计算结果
     */
    public function AsyncUpdateCart()
    {
        $cart = input('cart/a', []);
        $cartLogic = new CartLogic();
        $cartLogic->setUserId($this->user_id);
        $result = $cartLogic->AsyncUpdateCart($cart);
        $this->ajaxReturn($result);
    }

    /**
     *  购物车加减
     */
    public function changeNum(){
        $cart = input('cart/a',[]);
        if (empty($cart)) {
            $this->ajaxReturn(['status' => 0, 'msg' => '请选择要更改的商品', 'result' => '']);
        }
        $cartLogic = new CartLogic();
        $result = $cartLogic->changeNum($cart['id'],$cart['goods_num']);
        $this->ajaxReturn($result);
    }

    /**
     * 删除购物车商品
     */
    public function delete(){
        $cart_ids = input('cart_ids/a',[]);
        $cartLogic = new CartLogic();
        $cartLogic->setUserId($this->user_id);
        $result = $cartLogic->delete($cart_ids);
        if($result !== false){
            $this->ajaxReturn(['status'=>1,'msg'=>'删除成功','result'=>$result]);
        }else{
            $this->ajaxReturn(['status'=>0,'msg'=>'删除失败','result'=>$result]);
        }
    }

    /**
     * 购物车优惠券领取列表
     */
    public function getStoreCoupon()
    {
        $store_ids = input('store_ids/a', []);
        $goods_ids = input('goods_ids/a', []);
        $goods_category_ids = input('goods_category_ids/a', []);
        if (empty($store_ids) && empty($goods_ids) && empty($goods_category_ids)) {
            $this->ajaxReturn(['status' => 0, 'msg' => '获取失败', 'result' => '']);
        }
        $CouponLogic = new CouponLogic();
        $newStoreCoupon = $CouponLogic->getStoreGoodsCoupon($store_ids, $goods_ids, $goods_category_ids);
        if ($newStoreCoupon) {
            $user_coupon = Db::name('coupon_list')->where('uid', $this->user_id)->getField('cid', true);
            foreach ($newStoreCoupon as $key => $val) {
                if (in_array($newStoreCoupon[$key]['id'], $user_coupon)) {
                    $newStoreCoupon[$key]['is_get'] = 1;//已领取
                } else {
                    $newStoreCoupon[$key]['is_get'] = 0;//未领取
                }
            }
        }
        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $newStoreCoupon]);
    }

    /**
     * ajax 将商品加入购物车
     */
    function ajaxAddCart()
    {
        $goods_id = I("goods_id/d"); // 商品id
        $goods_num = I("goods_num/d");// 商品数量
        $item_id = I("item_id/d"); // 商品规格id
        if(empty($goods_id)){
            $this->ajaxReturn(['status'=>0,'msg'=>'请选择要购买的商品','result'=>'']);
        }
        if(empty($goods_num)){
            $this->ajaxReturn(['status'=>0,'msg'=>'购买商品数量不能为0','result'=>'']);
        }
        if($goods_num > 200){
            $this->ajaxReturn(['status'=>0,'msg'=>'购买商品数量大于200','result'=>'']);
        }
        $cartLogic = new CartLogic();
        $cartLogic->setUserId($this->user_id);
        $cartLogic->setGoodsModel($goods_id);
        if($item_id){
            $cartLogic->setSpecGoodsPriceModel($item_id);
        }
        $cartLogic->setGoodsBuyNum($goods_num);
        $result = $cartLogic->addGoodsToCart();
        $this->ajaxReturn($result);
    }

    /**
     * 购物车第二步确定页面
     */
    public function cart2(){
        $goods_id = input("goods_id/d"); // 商品id
        $goods_num = input("goods_num/d");// 商品数量
        $item_id = input("item_id/d"); // 商品规格id
        $action = input("action"); // 行为
        if ($this->user_id == 0){
            $this->error('请先登录', U('Home/User/login'));
        }
        $cartLogic = new CartLogic();
        $couponLogic = new CouponLogic();
        $cartLogic->setUserId($this->user_id);
        //立即购买
        if($action == 'buy_now'){
            if(empty($goods_id)){
                $this->error('请选择要购买的商品');
            }
            if(empty($goods_num)){
                $this->error('购买商品数量不能为0');
            }
            $cartLogic->setGoodsModel($goods_id);
            if($item_id){
                $cartLogic->setSpecGoodsPriceModel($item_id);
            }
            $cartLogic->setGoodsBuyNum($goods_num);
            $result = $cartLogic->buyNow();
            if($result['status'] != 1){
                $this->error($result['msg']);
            }
            $cartList[0] = $result['result']['buy_goods'];
            $cartGoodsTotalNum = $goods_num;
        }else{
            if ($cartLogic->getUserCartOrderCount() == 0){
                $this->error('你的购物车没有选中商品', 'Cart/index');
            }
            $cartList = $cartLogic->getCartList(1); // 获取用户选中的购物车商品
            $cartGoodsTotalNum = array_sum(array_map(function($val){return $val['goods_num'];}, $cartList));//购物车购买的商品总数
        }
        $cartGoodsList = get_arr_column($cartList,'goods');
        $cartGoodsId = get_arr_column($cartGoodsList,'goods_id');
        $cartGoodsCatId = get_arr_column($cartGoodsList,'cat_id3');
        $storeCartList = $cartLogic->getStoreCartList($cartList);//转换成带店铺数据的购物车商品
        $storeCartTotalPrice= array_sum(array_map(function($val){return $val['store_goods_price'];}, $storeCartList));//商品优惠总价
        $storeShippingCartList = $cartLogic->getShippingCartList($storeCartList);//转换成带物流数据的购物车商品
        $userCouponList = $couponLogic->getUserAbleCouponList($this->user_id, $cartGoodsId, $cartGoodsCatId);//用户可用的优惠券列表
        $userCartCouponList = $cartLogic->getCouponCartList($storeCartList, $userCouponList);
        $this->assign('userCartCouponList', $userCartCouponList);
        $this->assign('cartGoodsTotalNum', $cartGoodsTotalNum);
        $this->assign('storeShippingCartList', $storeShippingCartList);//购物车列表
        $this->assign('storeCartTotalPrice', $storeCartTotalPrice);//商品总价
        return $this->fetch();
    }

    /**
     * ajax 获取用户收货地址 用于购物车确认订单页面
     */
    public function ajaxAddress()
    {
        $address_list = M('UserAddress')->where("user_id", $this->user_id)->select();
        if ($address_list) {
            $area_id = array();
            foreach ($address_list as $val) {
                $area_id[] = $val['province'];
                $area_id[] = $val['city'];
                $area_id[] = $val['district'];
                $area_id[] = $val['twon'];
            }
            $area_id = array_filter($area_id);
            $area_id = implode(',', $area_id);
            $regionList = M('region')->where("id", "in", $area_id)->getField('id,name');
            $this->assign('regionList', $regionList);
        }
        $c = M('UserAddress')->where(['user_id' => $this->user_id, 'is_default' => 1])->count(); // 看看有没默认收货地址
        if ((count($address_list) > 0) && ($c == 0)) // 如果没有设置默认收货地址, 则第一条设置为默认收货地址
            $address_list[0]['is_default'] = 1;

        $this->assign('address_list', $address_list);
        return $this->fetch('ajax_address');
    }

    /**
     * 优惠券兑换
     */
    public function cartCouponExchange()
    {
        $coupon_code = input('coupon_code');
        $couponLogic = new CouponLogic;
        $return = $couponLogic->exchangeCoupon($this->user_id, $coupon_code);
        $this->ajaxReturn($return);
    }

    /**
     * ajax 获取订单商品价格 或者提交 订单
     */
    public function cart3()
    {
        if ($this->user_id == 0){
            $this->ajaxReturn(['status' => -100, 'msg' => "登录超时请重新登录!", 'result' => null]);// 返回结果状态
        }
        $address_id = I("address_id/d"); //  收货地址id
        $shipping_code = I("shipping_code/a"); //  物流编号
        $user_note = I('user_note/a'); // 给卖家留言
        $coupon_id = I("coupon_id/a"); //  优惠券id
        $invoice_title = I('invoice_title'); // 发票
        $pay_points = I("pay_points/d", 0); //  使用积分
        $user_money = I("user_money/f", 0); //  使用余额
        $goods_id = input("goods_id/d"); // 商品id
        $goods_num = input("goods_num/d");// 商品数量
        $item_id = input("item_id/d"); // 商品规格id
        $action = input("action"); // 立即购买
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
        if (!$shipping_code) {
            $this->ajaxReturn(['status' => -4, 'msg' => '请选择物流信息', 'result' => null]);
        }
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
                $paypwd =trim(I('pwd'));
                if(encrypt($paypwd) != $this->user['paypwd']){
                    exit(json_encode(array('status'=>-5,'msg'=>"支付密码错误！",'result'=>null)));
                }
            }

            $orderLogic = new OrderLogic();
            $orderLogic->setAction($action);
            $orderLogic->setCartList($order_goods);
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
        $order_id = I('order_id/d', 0);
        $master_order_sn = I('master_order_sn', '');
        if(empty($this->user_id)){
            $this->redirect('"User/login');
        }
        if(empty($master_order_sn) && empty($order_id)){
            $this->error('非法操作！',U("Home/Order/order_list"));
        }
        // 如果是主订单号过来的, 说明可能是合并付款的，只有在提交订单时候才会传主单号来付款
        $order_where['user_id'] = $this->user_id;
        if($master_order_sn){
            $order_where['master_order_sn'] = $master_order_sn;
        }else{
            $order_where['order_id'] = $order_id;
        }
        $order = M('Order')->where($order_where)->find();
        if(empty($order)){
            $this->error('订单不存在！',U("Home/Order/order_list"));
        }
        if($order['order_status'] == 3){
            $this->error('订单已取消',U("Home/Order/order_list"));
        }
        if ($master_order_sn) {
            $order_list = Db::name('order')->where($order_where)->select();
            if (count($order_list) > 0) {
                $sum_order_amount = 0;
                $order_pay_status_arr = get_arr_column($order_list, 'pay_status');
                if (!in_array(0, $order_pay_status_arr)) {
                    $this->redirect('Order/order_list');
                }
                foreach ($order_list as $orderKey => $orderVal) {
                    $sum_order_amount += $orderVal['order_amount'];
                }
            }
        } else {
            // 如果已经支付过的订单直接到订单详情页面. 不再进入支付页面
            if ($order['pay_status'] == 1) {
                $this->redirect('Order/order_detail', ['id' => $order_id]);
            }
        }
        $paymentList = M('Plugin')->where("`type`='payment' and status = 1 and  scene in(0,2)")->select();
        $paymentList = convert_arr_key($paymentList, 'code');

        foreach ($paymentList as $key => $val) {
            $val['config_value'] = unserialize($val['config_value']);
            if ($val['config_value']['is_bank'] == 2) {
                $bankCodeList[$val['code']] = unserialize($val['bank_code']);
            }
        }

        $bank_img = include APP_PATH . 'home/bank.php'; // 银行对应图片
        $this->assign('paymentList', $paymentList);
        $this->assign('bank_img', $bank_img);
        $this->assign('master_order_sn', $master_order_sn); // 主订单号
        $this->assign('sum_order_amount', $sum_order_amount); // 所有订单应付金额        
        $this->assign('order', $order);
        $this->assign('bankCodeList', $bankCodeList);
        $this->assign('pay_date', date('Y-m-d', strtotime("+1 day")));
        return $this->fetch();
    }

    /**
     * ajax 请求购物车列表
     */
    public function header_cart_list()
    {
        $cartLogic = new CartLogic();
        $cartLogic->setUserId($this->user_id);
        $cartList = $cartLogic->getCartList();
        $cartPriceInfo = $cartLogic->getCartPriceInfo($cartList);
        $this->assign('cartList', $cartList); // 购物车的商品
        $this->assign('cartPriceInfo', $cartPriceInfo); // 总计
        $template = I('template','header_cart_list');
        return $this->fetch($template);
    }

    /**
     * 兑换积分商品
     */
    public function buyIntegralGoods(){
        $goods_id = input('goods_id/d');
        $item_id = input('item_id/d');
        $goods_num = input('goods_num');
        if(empty($this->user)){
            $this->ajaxReturn(['status'=>0,'msg'=>'请登录']);
        }
        if(empty($goods_id)){
            $this->ajaxReturn(['status'=>0,'msg'=>'非法操作']);
        }
        if(empty($goods_num)){
            $this->ajaxReturn(['status'=>0,'msg'=>'购买数不能为零']);
        }
        $goods = Goods::get($goods_id);
        if(empty($goods)){
            $this->ajaxReturn(['status'=>0,'msg'=>'该商品不存在']);
        }
        $Integral = new IntegralLogic();
        if(!empty($item_id)){
            $specGoodsPrice = SpecGoodsPrice::get($item_id);
            $Integral->setSpecGoodsPrice($specGoodsPrice);
        }
        $Integral->setUser($this->user);
        $Integral->setGoods($goods);
        $Integral->setBuyNum($goods_num);
        $result = $Integral->buy();
        $this->ajaxReturn($result);
    }

    /**
     *  积分商品结算页
     * @return mixed
     */
    public function integral(){
        $goods_id = input('goods_id/d');
        $item_id = input('item_id/d');
        $goods_num = input('goods_num/d');
        if(empty($this->user)){
            $this->error('请登录');
        }
        if(empty($goods_id)){
            $this->error('非法操作');
        }
        if(empty($goods_num)){
            $this->error('购买数不能为零');
        }
        $Goods = new Goods();
        $goods = $Goods->with('store')->where(['goods_id'=>$goods_id])->find();
        if(empty($goods)){
            $this->error('该商品不存在');
        }
        if (empty($item_id)) {
            $goods_spec_list = SpecGoodsPrice::all(['goods_id' => $goods_id]);
            if (count($goods_spec_list) > 0) {
                $this->error('请传递规格参数');
            }
            $goods_price = $goods['shop_price'];
            //没有规格
        } else {
            //有规格
            $specGoodsPrice = SpecGoodsPrice::get(['item_id'=>$item_id,'goods_id'=>$goods_id]);
            if ($goods_num > $specGoodsPrice['store_count']) {
                $this->error('该商品规格库存不足，剩余' . $specGoodsPrice['store_count'] . '份');
            }
            $goods_price = $specGoodsPrice['price'];
            $this->assign('specGoodsPrice', $specGoodsPrice);
        }
        $ShippingArea = new ShippingArea();
        $shippingAreaList = $ShippingArea->with('plugin')->where(['store_id'=>$goods['store_id'],'is_default' => 1, 'is_close' => 1])->group("shipping_code")->cache(true, TPSHOP_CACHE_TIME)->select();
        $point_rate = tpCache('shopping.point_rate');
        $this->assign('point_rate', $point_rate);
        $this->assign('goods', $goods);
        $this->assign('goods_price', $goods_price);
        $this->assign('goods_num',$goods_num);
        $this->assign('shippingAreaList', $shippingAreaList);
        return $this->fetch();
    }

    /**
     *  积分商品价格提交
     * @return mixed
     */
    public function integral2(){
 
        if ($this->user_id == 0){
            $this->ajaxReturn(['status' => -100, 'msg' => "登录超时请重新登录!", 'result' => null]);
        }
        $goods_id = input('goods_id/d');
        $item_id = input('item_id/d');
        $goods_num = input('goods_num/d');
        $address_id = input("address_id/d"); //  收货地址id
        $shipping_code = input("shipping_code/s"); //  物流编号
        $user_note = input('user_note'); // 给卖家留言
        $invoice_title = input('invoice_title'); // 发票
        $user_money = input("user_money/f", 0); //  使用余额
        
        $pwd = input('pwd');
        
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
                
                $payPwd =trim($pwd);
                if(encrypt($payPwd) != $this->user['paypwd']){
                    $this->ajaxReturn(['status'=>-5,'msg'=>"支付密码错误！",'result'=>null]);
                }
                
            }
            $result = $Integral->addOrder($invoice_title,$user_note); // 添加订单
            // 这个人处理完了再减少
            \think\Cache::dec('queue');
            $this->ajaxReturn($result);
        }
        $this->ajaxReturn(['status' => 1, 'msg' => '计算成功', 'result' => $car_price]);
    }
    
    /**
     *  获取发票信息
     * @date2017/10/19 14:45
     */
    public function invoice(){

        $map = [];
        $map['user_id']=  $this->user_id;
        
        $field=[          
            'invoice_title',
            'taxpayer',
            'invoice_desc',	
        ];
        
        $info = M('user_extend')->field($field)->where($map)->find();
        if(empty($info)){
            $result=['status' => -1, 'msg' => 'N', 'result' =>''];
        }else{
            $result=['status' => 1, 'msg' => 'Y', 'result' => $info];
        }
        $this->ajaxReturn($result);            
    }
     /**
     *  保存发票信息
     * @date2017/10/19 14:45
     */
    public function save_invoice(){     
        
        if(IS_AJAX){
            
            //A.1获取发票信息
            $invoice_title = trim(I("invoice_title"));
            $taxpayer      = trim(I("taxpayer"));
            $invoice_desc  = trim(I("invoice_desc"));
            
            //B.1校验用户是否有历史发票记录
            $map            = [];
            $map['user_id'] =  $this->user_id;
            $info           = M('user_extend')->where($map)->find();
            
           //B.2发票信息
            $data=[];  
            $data['invoice_title'] = $invoice_title;
            $data['taxpayer']      = $taxpayer;  
            $data['invoice_desc']  = $invoice_desc;     
            
            //B.3发票抬头
            if($invoice_title=="个人"){
                $data['invoice_title'] ="个人";
                $data['taxpayer']      = "";
            }                              
            
            
            //是否存贮过发票信息
            if(empty($info)){   
                $data['user_id'] = $this->user_id;
                (M('user_extend')->add($data))?
                $status=1:$status=-1;                
             }else{
                (M('user_extend')->where($map)->save($data))?
                $status=1:$status=-1;                
            }            
            $result = ['status' => $status, 'msg' => '', 'result' =>''];           
            $this->ajaxReturn($result); 
            
        }      
        
    }
    

}
