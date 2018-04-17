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
use app\common\logic\OrderLogic;
use app\common\logic\StoreLogic;
use app\common\logic\UsersLogic;
use app\common\logic\CommentLogic;
use app\common\logic\CouponLogic;
use think\Page;

class User extends Base {
    public $userLogic;
    
    /**
     * 析构流函数
     */
    public function  __construct() {   
        parent::__construct();
        $this->userLogic = new UsersLogic();
    } 

    /**
     *  登录
     */
    public function login()
    {
        $username = I('username', '');
        $password = I('password', '');
        $capache = I('capache', '');
        $unique_id = I("unique_id"); // 唯一id  类似于 pc 端的session id
        $push_id = I('push_id', '');

        $device = input('terminal', '');
        $return = $this->userLogic->checkLoginForSaas($device);
        if ($return['status'] != 1) {
            $this->ajaxReturn($return);
        }

        $data = $this->userLogic->app_login($username, $password, $capache, $push_id);
        if($data['status'] != 1){
            $this->ajaxReturn($data);
        }
        
        $cartLogic = new CartLogic();
        $cartLogic->setUserId($data['result']['user_id']);
        $cartLogic->setUniqueId($unique_id);
        $cartLogic->doUserLoginHandle();  // 用户登录后 需要对购物车 一些操作
        $this->ajaxReturn($data);
    }
    
    /**
     * 登出
     */
    public function logout()
    {
        $token = I("post.token", ''); 
        $data = $this->userLogic->app_logout($token);
        $this->ajaxReturn($data);
    }
    
    /**
     * 第三方登录
     */
    public function thirdLogin()
    {
        $unique_id = I("unique_id"); // 唯一id  类似于 pc 端的session id
        $map['openid'] = I('openid','');
        $map['nickname'] = I('nickname','');
        $map['head_pic'] = I('head_pic','');        
        $map['unionid'] = I('unionid','');
        $map['push_id'] = I('push_id','');
        $map['sex'] = I('sex', 0);
        $map['oauth'] = I('oauth','');

        $device = input('terminal', '');
        $return = $this->userLogic->checkLoginForSaas($device);
        if ($return['status'] != 1) {
            $this->ajaxReturn($return);
        }

        if ($map['oauth'] == 'miniapp') {
            $code = I('post.code', '');
            if (!$code) {
                $this->ajaxReturn(['status' => -1, 'msg' => 'code值非空','result'=>'']);
            }
            $miniapp = new \app\common\logic\MiniAppLogic;
            $session = $miniapp->getSessionInfo($code);
            if ($session === false) {
                $this->ajaxReturn(['status' => -1, 'msg' => $miniapp->getError()]);
            }
            $map['openid'] = $session['openid'];
            $map['unionid'] = $session['unionid'];
        }
        
        $is_bind_account = tpCache('basic.is_bind_account');
        if($is_bind_account == 1){
            if((empty($map['openid']) && empty($map['unionid'])) || empty($map['oauth'])){
                $this->ajaxReturn(['status' => -1, 'msg' => '参数错误, openid,unionid或oauth为空','result'=>'']);
            }
            if($map['unionid']){
                $thirdUser = M('OauthUsers')->where(['unionid'=>$map['unionid'], 'oauth'=>$map['oauth']])->find();
            }else{
                $thirdUser = M('OauthUsers')->where(['openid'=>$map['openid'], 'oauth'=>$map['oauth']])->find();
            }
            
            if(empty($thirdUser)){
                //用户未关联账号, 跳到关联账号页
                session("third_oauth" , $map);
                $this->ajaxReturn(['status' => -1, 'msg' => '请绑定账号' , 'result'=>'100'] );
            }else{
                $data = $this->userLogic->thirdLogin_new($map);
            }
        }else{
            $data = $this->userLogic->thirdLogin($map);
        }
            
        if($data['status'] == 1){
            $cartLogic = new CartLogic();
            $cartLogic->setUserId($data['result']['user_id']);
            $cartLogic->setUniqueId($unique_id);
            $cartLogic->doUserLoginHandle();// 用户登录后 需要对购物车 一些操作
            //重新获取用户信息，补全数据
            $data = $this->userLogic->getApiUserInfo($data['result']['user_id']);
        }
        $this->ajaxReturn($data);
    }

    /**
     * 用户注册
     */
    public function reg(){
        
        $nickname = I('post.nickname','');
        $username = I('post.username','');
        $password = I('post.password','');
        
        $password2 = I('post.password2','');
        
        $code = I('post.code');   
             
        $type = I('type','phone');
        
        $session_id = I('unique_id', session_id());// 唯一id  类似于 pc 端的session id
        $scene = I('scene' , 1);
        $push_id = I('post.push_id' , '');
         
        $invite_code = I('post.invite_code','');
        
        
        //是否开启注册验证码机制
        if(check_mobile($username)){
           $res = $this->userLogic->check_validate_code($code, $username  , $type , $session_id , $scene);
            if($res['status'] != 1) exit(json_encode($res));
        } 
     
        
        
        $is_bind_account = tpCache('basic.is_bind_account');
        $wxuser = session('third_oauth');
        if($is_bind_account && $wxuser){
            $head_pic = $wxuser['head_pic'];
            $nickname = $nickname ?: $wxuser['nickname'];
            $data = $this->userLogic->reg($username,$password , $password, $push_id,$nickname,$head_pic);
            if($data['status'] == -1)$this->ajaxReturn($data);
            $data = $this->userLogic->oauth_bind_new($data['result']);
        }else{
            $data = $this->userLogic->reg($username,$password ,$password2, $push_id,$invite_code);
        }
        
        if($data['status'] == 1){
            $cartLogic = new CartLogic();
            $cartLogic->setUserId($data['result']['user_id']);
            $cartLogic->setUniqueId($session_id);
            $cartLogic->doUserLoginHandle(); // 用户登录后 需要对购物车 一些操作
        }        
        exit(json_encode($data));
    }

    /**
     * 绑定已有账号
     * @return \think\mixed
     */
    public function bind_account()
    {
        if(IS_POST){
            $data = I('post.');
            $userLogic = new UsersLogic();
            $user['mobile'] = $data['mobile'];
            $user['password'] = $data['password'];
            $res = $userLogic->oauth_bind_new($user);
            if ($res['status'] == 1) {
                //重新更新用户token信息
                $user = $res['result']; 
                $res['result']['nickname'] = empty($res['result']['nickname']) ? $res['result']['mobile'] : $res['result']['nickname'];
                $cartLogic = new CartLogic();
                $cartLogic->setUserId($res['result']['user_id']);
                $cartLogic->doUserLoginHandle();  //用户登录后 需要对购物车 一些操作
                $orderLogic = new OrderLogic();//登录后将超时未支付订单给取消掉
                $orderLogic->setUserId($res['result']['user_id']);
                $orderLogic->abolishOrder();
                $this->ajaxReturn(array('status'=>1,'msg'=>'绑定成功','result'=>$res['result']));
            }else{
                $this->ajaxReturn(array('status'=>-1,'msg'=>'绑定失败,失败原因'.$res['msg'],'result'=>''));
            }
        } 
    }
    
    /**
     * 实名认证
     * **/
    public function validateUser()
    {
        if($this->request->isPost()){
            
        }
    }
    
    
    /*
     * 获取用户信息
     */
    public function userInfo(){
        //$user_id = I('user_id/d');
        $data = $this->userLogic->getApiUserInfo($this->user_id);
        exit(json_encode($data));
    }
     
    /*
     *更新用户信息
     */
    public function updateUserInfo()
    {
        if (!IS_POST) {
            $this->ajaxReturn(['status'=>-1, 'msg'=>"请求方式错误"]);
        }
        if (!$this->user_id) {
            $this->ajaxReturn(['status'=>-1,'msg'=>'缺少参数','result'=>'']);
        }

        I('post.nickname') ? $post['nickname'] = I('post.nickname') : false; //昵称
        I('post.qq') ? $post['qq'] = I('post.qq') : false;  //QQ号码
        I('post.head_pic') ? $post['head_pic'] = I('post.head_pic') : false; //头像地址
        I('post.sex') ? $post['sex'] = I('post.sex') : false;  // 性别
        I('post.birthday') ? $post['birthday'] = strtotime(I('post.birthday')) : false;  // 生日
        I('post.province') ? $post['province'] = I('post.province') : false;  //省份
        I('post.city') ? $post['city'] = I('post.city') : false;  // 城市
        I('post.district') ? $post['district'] = I('post.district') : false;  //地区
        I('post.email') ? $post['email'] = I('post.email') : false;  
        I('post.mobile') ? $post['mobile'] = I('post.mobile') : false;  

        $email = $post['email'];
        $mobile = $post['mobile'];
        $code = I('post.mobile_code', '');
        $scene = I('post.scene', 6);

        if (!empty($email)) {
            $c = M('users')->where(['email' => $email, 'user_id' => ['<>', $this->user_id]])->find();
            $c && $this->ajaxReturn(['status'=>-1,'msg'=>"邮箱已被使用"]);
        }
        if (!empty($mobile)) {
            $c = M('users')->where(['mobile' => $mobile, 'user_id' => ['<>', $this->user_id]])->count();
            $c && $this->ajaxReturn(['status'=>-1,'msg'=>"手机已被使用"]);
            (!$code) && $this->ajaxReturn(['status'=>-1,'msg'=>'请输入验证码']);
            $check_code = $this->userLogic->check_validate_code($code, $mobile, 'mobile', SESSION_ID, $scene);
            if ($check_code['status'] != 1) {
                $this->ajaxReturn($check_code);
            }
        }

        if (!$this->userLogic->update_info($this->user_id,$post)) {
            $this->ajaxReturn(['status'=>-1,'msg'=>'更新失败','result'=>'']);
        }
        $this->ajaxReturn(['status'=>1,'msg'=>'更新成功','result'=>'']);
    }

    /*
     * 修改用户密码
     */
    public function password(){
        if(IS_POST){
            if(!$this->user_id){
                exit(json_encode(array('status'=>-1,'msg'=>'缺少参数','result'=>'')));
            }
            $data = $this->userLogic->passwordForApp($this->user_id,encrypt(I('post.old_password')),encrypt(I('post.new_password'))); // 修改密码
            exit(json_encode($data));
        }
    }
    
    public function forgetPasswordInfo()
    {
        $account = I('post.account', '');
        $capache = I('post.capache' , '');
        if (!capache([], SESSION_ID, $capache)) {
            $this->ajaxReturn(['status'=>-1,'msg'=>'验证码错误！']);
        }
        if (($user = M('users')->field('mobile, nickname')->where(['mobile' => $account])->find()) 
            || ($user = M('users')->field('mobile, nickname')->where(['email' => $account])->find())
            || ($user = M('users')->field('mobile, nickname')->where(['nickname' => $account])->find())) {
            $this->ajaxReturn(['status'=>1, 'msg'=>'获取成功', 'result' => $user]);
        }
        if (!$user) {
            $this->ajaxReturn(['status'=>-1, 'msg'=>'该账户不存在']);
        }
    }
    
    /**
     * 短信验证
     */
    public function check_sms()
    {
        $mobile = I('post.mobile');
        $unique_id = I('unique_id');
        $code = I('post.check_code');   //验证码
        $scene = I('post.scene/d', 2);   //验证码
        if (!check_mobile($mobile)) {
            $this->ajaxReturn(['status'=>-1,'msg'=>'手机号码格式不正确','result'=>'']);
        }

        $res = $this->userLogic->check_validate_code($code, $mobile, 'phone', $unique_id , $scene);
        if ($res['status'] != 1) {
            $this->ajaxReturn($res);
        }
       
        $this->ajaxReturn(['status'=>1, 'msg'=>'验证成功']);
    }
    
    /**
     * 修改手机验证
     */
    public function change_mobile()
    {
        $mobile = I('post.mobile');
        $unique_id = I('unique_id');
        $code = I('post.check_code');   //验证码
        $scene = I('post.scene/d', 0);   //验证码
        $capache = I('post.capache' , '');
        if (!check_mobile($mobile)) {
            $this->ajaxReturn(['status'=>-1,'msg'=>'手机号码格式不正确','result'=>'']);
        }

        $res = $this->userLogic->check_validate_code($code, $mobile, 'phone', $unique_id , $scene);
        if ($res['status'] != 1) {
            $this->ajaxReturn($res);
        }

        /* if (!capache([], SESSION_ID, $capache)) {
            $this->ajaxReturn(['status'=>-1,'msg'=>'图形验证码错误！']);
        } */
        
        if ($scene != 6) {
            $this->ajaxReturn(['status'=>-1,'msg'=>'场景码错误！']);
        }
        
        $data['mobile'] = $mobile;  
        if (!$this->userLogic->update_info($this->user_id, $data)) {
           $this->ajaxReturn(['status' => -1, 'msg' => '手机号码更新失败']);
        }

        $this->ajaxReturn(['status'=>1, 'msg'=>'更改成功']);
    }
    
    /**
     * @add by wangqh APP端忘记密码
     * 忘记密码
     */
    public function forgetPassword()
    {
        $password = I('password');
        $mobile = I('mobile', 'invalid');
        $consignee = I('consignee', '');
        
        $user = M('users')->where("mobile",$mobile)->find();
        if (!$user) {
            $this->ajaxReturn(['status'=>-1,'msg'=>'该手机号码没有关联账户']);
        } else {
            $consignees = M('order')->where('user_id', $user['user_id'])->column('consignee');
            if ($consignees) {
                if (!in_array($consignee, $consignees)) {
                    $this->ajaxReturn(['status'=>-1, 'msg'=>'历史收货人错误！']);
                }
            }
            //修改密码
            M('users')->where("user_id",$user['user_id'])->save(array('password'=>$password));
            $this->ajaxReturn(['status'=>1,'msg'=>'密码已重置,请重新登录']);
        }
    }

    /**
     * 忘记密码　　
     * 参数主要有
     * mobile 的
     * **/
    public function forgotpwd()
    {
        //先验证手机号码
        if (check_mobile($this->request->param("username"))) {
            
            $res = $this->userLogic->check_validate_code($this->request->param("code"), $this->request->param("username"), 'phone',0,0,0);
            if($res['status'] != 1) exit(json_encode($res));
            
            //$this->ajaxReturn(['status'=>-1,'msg'=>'手机号码格式错误']);
        }else{
            $this->ajaxReturn(['status'=>-1,'msg'=>'手机号码格式错误']);
        }
        
        $mobile = \think\Db::name("User")->where("mobile",$this->request->param("mobile"))->getField("mobile");
        empty($mobile) && $this->ajaxReturn(['status'=>-1,'msg'=>'这个账号不存在']);
        
        if (!$this->request->param("username") || !$this->request->param("password"))
            $this->ajaxReturn(['status' => -1, 'msg' => '请输入用户名或密码']);
        
        if ($this->request->param("password") != $this->request->param("password2"))
            $this->ajaxReturn(['status' => -1, 'msg' => '两次输入密码不一致']);
        
        
        print_r($this->request->param());
        
    }
    /**
     * 获取收货地址
     */
    public function getAddressList()
    {
        if (!$this->user_id) {
            $this->ajaxReturn(array('status'=>-1,'msg'=>'缺少参数'));
        }
        
        $address = M('user_address')->where(array('user_id'=>$this->user_id))->select();
        if(!$address) {
            $this->ajaxReturn(array('status'=>1,'msg'=>'没有数据','result'=>[]));
        }

        $regions = M('region')->cache(true)->getField('id,name');
        foreach ($address as &$addr) {
            $addr['province_name'] = $regions[$addr['province']] ?: '';
            $addr['city_name']     = $regions[$addr['city']] ?: '';
            $addr['district_name'] = $regions[$addr['district']] ?: '';
            $addr['twon_name']     = $regions[$addr['twon']] ?: '';
            $addr['address']       = $addr['address'] ?: '';
        }
        
        $this->ajaxReturn(array('status'=>1,'msg'=>'获取成功','result'=>$address));
    }

    /*
     * 添加地址
     */
    public function addAddress(){
        //$user_id = I('user_id/d',0);
        if(!$this->user_id) exit(json_encode(array('status'=>-1,'msg'=>'缺少参数','result'=>'')));
        $address_id = I('address_id/d',0);
        $data = $this->userLogic->add_address($this->user_id,$address_id,I('post.')); // 获取用户信息
        exit(json_encode($data));
    }
    /*
     * 地址删除
     */
    public function del_address(){
        $id = I('id/d');
        if(!$this->user_id) exit(json_encode(array('status'=>-1,'msg'=>'缺少参数','result'=>'')));
        $address = M('user_address')->where("address_id" ,$id)->find();
        $row = M('user_address')->where(array('user_id'=>$this->user_id,'address_id'=>$id))->delete();      
      
        // 如果删除的是默认收货地址 则要把第一个地址设置为默认收货地址
        if($address['is_default'] == 1)
        {
            $address = M('user_address')->where("user_id",$this->user_id)->find();    
            
            //@mobify by wangqh {
            if($address) {    
                M('user_address')->where("address_id",$address['address_id'])->save(array('is_default'=>1));
            }//@}
            
        }      

        //@mobify by wangqh 
        if ($row)
           exit(json_encode(array('status'=>1,'msg'=>'删除成功','result'=>''))); 
        else
           exit(json_encode(array('status'=>1,'msg'=>'删除失败','result'=>''))); 
    }
    
    /*
     * 设置默认收货地址
     */
    public function setDefaultAddress() {
//        $user_id = I('user_id/d',0);
        if(!$this->user_id) exit(json_encode(array('status'=>-1,'msg'=>'缺少参数','result'=>'')));
        $address_id = I('address_id/d',0);
        $data = $this->userLogic->set_default($this->user_id,$address_id); // 获取用户信息
        if(!$data)
            exit(json_encode(array('status'=>-1,'msg'=>'操作失败','result'=>'')));
        exit(json_encode(array('status'=>1,'msg'=>'操作成功','result'=>'')));
    }

    /*
     * 获取优惠券列表
     */
    public function getCouponList()
    {
        if (!$this->user_id) {
            $this->ajaxReturn(['status'=>-1, 'msg'=>'还没登录', 'result'=>'']);
        }
        
        $store_id = I('get.store_id', 0);//指定店铺，如果不指定店铺　　则可能会产生所有商家发布的优惠卷都被使用的情况
        empty($store_id) &&$this->ajaxReturn(['status' => -1, 'msg' => '请指定店铺id']);
        $type = I('get.type', 0);//获取该用户未使用的优惠卷
        $order_money = I('get.order_money', 0);
        
        $data = $this->userLogic->get_coupon($this->user_id, $type, null, 0, $store_id, $order_money);
     
        unset($data['show']);
        
        /* 获取各个优惠券的平台 */
        $coupon_list = &$data['result'];
        $store_id_arr = get_arr_column($coupon_list, 'store_id');
        $store_arr = M('store')->where('store_id', 'in', $store_id_arr)->getField('store_id,store_name,store_logo');
        foreach ($coupon_list as &$coupon) {
            if ($coupon['store_id'] > 0) {
                $coupon['limit_store'] = $store_arr[$coupon['store_id']]['store_name'];
            } else {
                $coupon['limit_store'] = '全平台';
            }
        }
        
        $this->ajaxReturn($data);
    }
 
    /**
     * 获取购物车指定店铺的优惠券(cart2没调这个接口，好像废了)
     */
    public function cart_coupons()
    {
        $store_id = I('store_id/d' , 0);    //限制店铺
        $money = I('money/f' , 0);        //限制金额
        
        $cartLogic = new CartLogic();
        $couponLogic = new CouponLogic();
        $cartLogic->setUserId($this->user_id);
        if ($cartLogic->getUserCartOrderCount() == 0){
            $this->ajaxReturn(['status' => -1, 'msg' => '你的购物车没有选中商品']);
        }
        $cartList = $cartLogic->getCartList(1); // 获取用户选中的购物车商品
        $cartGoodsList = get_arr_column($cartList,'goods');
        $cartGoodsId = get_arr_column($cartGoodsList,'goods_id');
        $cartGoodsCatId = get_arr_column($cartGoodsList,'cat_id3');
        $storeCartList = $cartLogic->getStoreCartList($cartList);//转换成带店铺数据的购物车商品
        $userCouponList = $couponLogic->getUserAbleCouponList($this->user_id, $cartGoodsId, $cartGoodsCatId);//用户可用的优惠券列表
        $userCartCouponList = $cartLogic->getCouponCartList($storeCartList, $userCouponList);

        foreach ($storeCartList as &$store) {
            if ($store['store_id'] == $store_id) {
                break;
            }
        }
        
        $returnCouponList = [];  
        foreach ($userCartCouponList as $v) { 
            $coupon = $v['coupon'];
            if ($v['store_id'] == $store_id && $coupon['able']) {
                //if($money == 0  || ($money > 0 && $coupon['condition'] <  $money)){      //金额限制
                    $limit_store = $store['store_name'];
                    //0全店通用1指定商品可用2指定分类商品可用
                    switch ($coupon['use_type']){
                        case 0 :
                            $returnCoupon['limit_store'] = $limit_store.'全店通用';
                            break;
                        case 1 :
                            $returnCoupon['limit_store'] = $limit_store.'指定商品可用';
                            break;
                        case 2 :
                            $returnCoupon['limit_store'] = $limit_store.'指定分类商品可用';
                            break;
                        case 3 :
                            $returnCoupon['limit_store'] = '全平台可用';
                            break;
                    }  
                    $returnCoupon['id'] = $v['id'];
                    $returnCoupon['name'] = $coupon['name'];
                    $returnCoupon['money'] = $coupon['money'];
                    $returnCoupon['condition'] = $coupon['condition'];
                    $returnCoupon['use_start_time'] = $coupon['use_start_time'];
                    $returnCoupon['use_end_time'] = $coupon['use_end_time'];
                    $returnCoupon['store_id'] = $v['store_id'];
                    $returnCouponList[] = $returnCoupon;
                //}
            }
        } 
        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $returnCouponList]);
    }
    
    /*
     * 获取商品收藏列表
     */
    public function getGoodsCollect()
    {
        $data = $this->userLogic->get_goods_collect($this->user_id);
        unset($data['show']);
        unset($data['page']);
        $this->ajaxReturn($data);
    }

    /*
     * 用户订单列表
     */
    public function getOrderList()
    {
        $type = I('type','');
        $p = I('p', 1);
        if (!$this->user_id) {
            $this->ajaxReturn(['status'=>-1, 'msg'=>'缺少参数', 'result'=>'']);
        } 
        //删除的订单, 作废订单 ,虚拟订单 不列出来
        $map = " deleted = 0 and order_status <> 5 and order_prom_type < 5 AND user_id = :user_id";
        $map = $type ? $map.C($type) : $map;   
        
        $order_list = [];
        $order_obj = new \app\common\model\Order();
        $order_list_obj = $order_obj->order("order_id DESC")->where($map)->bind(['user_id'=>$this->user_id])->page($p, 10)->select();
        if ($order_list_obj) {
            //转为数字，并获取订单状态，订单状态显示按钮，订单商品
            $order_list=collection($order_list_obj)->append(['order_status_detail','order_button','order_goods','store'])->toArray();
        } 
        //添加订单商品的图片
        $GoodsId = [];
        foreach ($order_list as $k=>$v){
            //print_r($v['order_goods'][0]);
            $GoodsId[$v['order_goods'][0]['goods_id']] = $v['order_goods'][0]['goods_id'];
        }
        $goodsImg = $this->getGoodsImg($GoodsId);
        foreach ($order_list as $k=>$v){
            //print_r($v['order_goods'][0]);
            //$GoodsId[$v['order_goods'][0]['goods_id']] = $v['order_goods'][0]['goods_id'];
            $order_list[$k]['order_goods'][0]['goods_img'] = $goodsImg[$v['order_goods'][0]['goods_id']];
        }
        $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result'=>$order_list]);
    }
    
    //获取订单商品的图片
    private function getGoodsImg($goodsid)
    {
        $list = \think\Db::name("goods")->field("goods_id,original_img")->where("goods_id","in",$goodsid)->select();
        $goodsImg = [];
        foreach ($list as $k=>$v){
            $goodsImg[$v['goods_id']] = $v['original_img'];
        }
        return $goodsImg;
    }

    /**
     * 取消订单
     */
    public function cancelOrder(){
        $id = I('order_id/d');
//        $user_id = I('user_id/d',0);
        $logic = new OrderLogic();
        if(!$this->user_id > 0 || !$id > 0)
            exit(json_encode(array('status'=>-1,'msg'=>'参数有误','result'=>'')));
        $data = $logic->cancel_order($this->user_id,$id);
        exit(json_encode($data));
    }
     
    /**
     *  收货确认
     */
    public function orderConfirm(){
        $id = I('order_id/d',0);
        //$user_id = I('user_id/d',0);
        if(!$this->user_id || !$id)
            exit(json_encode(array('status'=>-1,'msg'=>'参数有误','result'=>'')));
        $data = confirm_order($id,$this->user_id);            
        exit(json_encode($data));
    }
    
    
    /*
     *添加评论
     */
    public function add_comment()
    {
        $data['order_id']         = input('post.order_id/d', 0);
        $data['rec_id']           = input('post.rec_id/d', 0);
        $data['goods_id']         = input('post.goods_id/d', 0);
        $data['seller_score']     = input('post.service_rank', 0);   //卖家服务分数（0~5）(order_comment表)
        $data['logistics_score']  = input('post.deliver_rank', 0); //物流服务分数（0~5）(order_comment表)
        $data['describe_score']   = input('post.goods_rank', 0);  //描述服务分数（0~5）(order_comment表)
        $data['goods_rank']       = input('post.goods_score/d', 0);   //商品评价等级
        $data['is_anonymous']     = input('post.is_anonymous/d', 0);
        $data['content']          = input('post.content', '');
        $data['img']              = input('post.img/a', ''); //小程序需要
        $data['user_id']          = $this->user_id;
        
        $commentLogic = new CommentLogic;
        $return = $commentLogic->addGoodsAndServiceComment($data);
        
        $this->ajaxReturn($return);
    }  
    
    /**
     * 提交服务评论
     */
    public function add_service_comment()
    {
        $order_id = I('post.order_id/d', 0);
        $service_rank = I('post.service_rank', 0);
        $deliver_rank = I('post.deliver_rank', 0);
        $goods_rank = I('post.goods_rank', 0);

        $store_id = M('order')->where(array('order_id' => $order_id))->getField('store_id');
        
        $commentLogic = new CommentLogic;
        $return = $commentLogic->addServiceComment($this->user_id, $order_id, $store_id, $service_rank, $deliver_rank, $goods_rank);
        
        $this->ajaxReturn($return);
    }
    
    /**
     * 上传头像
     */
    public function upload_headpic()
    {
        $userLogic = new UsersLogic();

        $return = $userLogic->upload_headpic(true);
        if ($return['status'] !== 1) {
            $this->ajaxReturn($return);
        }
        $post['head_pic'] = $return['result'];
        
        if (!$userLogic->update_info($this->user_id, $post)) {
            $this->ajaxReturn(['status' => -1, 'msg' => '保存失败']);
        }
        $this->ajaxReturn(['status' => 1, 'msg' => '操作成功', 'result' => $post['head_pic']]);
    }
    
    /**
     * 实名认证
     * **/
    
    public function idcard_recognize()
    {
        if($this->request->isPost()){
            
            //先查询是否已经认证过
            $ret = \think\Db::name("Users")->where("user_id",$this->user_id)->getField("idcard_isvalidate");
            if($ret){
                $this->ajaxReturn(['status' => -1, 'msg' => '您已经认证过']);
            }
            /*
            $options = [
                // 缓存类型为File
                'type'  =>  'File', 
                // 缓存有效期为永久有效
                'expire'=>  30, //30秒以内
                //缓存前缀
                'prefix'=>  'think',
                 // 指定缓存目录
                'path'  =>  APP_PATH.'runtime/cache/',
            ];
           
            \think\Cache::connect($options);


            $request_count = 10;
            $count = \think\Cache::get("request_count",0);
           
            if($count>=10){
                
                $this->ajaxReturn(['status' => -1, 'msg' => '您的请求次数太高了休息一伙儿吧']);
            }
            
            //统计请求次数　　防止请求过高
            \think\Cache::inc("request_count");
            */
            
            
            if(empty($this->request->param("realname"))){
                $this->ajaxReturn(['status' => -1, 'msg' => '真实姓名必须填写']);
            }
            if(empty($this->request->param("idcard"))){
                $this->ajaxReturn(['status' => -1, 'msg' => '身份证号码必须填写']);
            }
            if(strlen($this->request->param("idcard"))<18){
                $this->ajaxReturn(['status' => -1, 'msg' => '身份证号码不对']);
            }
            
            if(empty($this->request->param("idcard_f"))){
                $this->ajaxReturn(['status' => -1, 'msg' => '身份证照片必须上传']);
            }
            if(empty($this->request->param("idcard_b"))){
                $this->ajaxReturn(['status' => -1, 'msg' => '身份证照片必须上传']);
            }
            
            if(!config("AREAS")[substr($this->request->param("idcard"),0,6)]){
                $this->ajaxReturn(['status' => -1, 'msg' => '身份证号码不对']);
            }
           //等候时间比较长　原因是图片内容[base64]的内容太大导致
            $idcard_info = idcard_reconginze($this->request->param("idcard_f"));
            
            //return $idcard_info;
            //print_r($idcard_info);
            $sex = ['1'=>'男','2'=>'女'];
            if($idcard_info['error_code']==0){
                if($this->request->param("realname")!=$idcard_info['result']['realname']){
                    $this->ajaxReturn(['status' => -1, 'msg' => '您的姓名和身份证上的不一致']);
                }
                if($sex[$this->request->param("sex")]!=$idcard_info['result']['sex']){
                    $this->ajaxReturn(['status' => -1, 'msg' => '您的性别和身份证上的不一致']);
                }
                if($this->request->param("idcard")!=$idcard_info['result']['idcard']){
                    $this->ajaxReturn(['status' => -1, 'msg' => '您的身份证号和身份证上的不一致']);
                }
            }else{
                $this->ajaxReturn(['status' => -1, 'msg' => '聚合平台请求异常'.$idcard_info]);
            }
            
            $idcard_query = idcard_query($this->request->param("idcard"), $this->request->param("realname"));
            
            if($idcard_query['error_code']==0){
                if($idcard_query['result']['res']!=1){
                    $this->ajaxReturn(['status' => -1, 'msg' => '身份证系统不存在此人']);
                }
            }else{
                $this->ajaxReturn(['status' => -1, 'msg' => '聚合平台请求异常'.json_encode($idcard_query,JSON_UNESCAPED_UNICODE)]);
            }
            
            $idcardfpic = "./public/upload/idcard/".date("Ymdhis").mt_rand(0, 99999)."fpic.png";
            $idcardbpic = "./public/upload/idcard/".date("Ymdhis").mt_rand(0, 99999)."bpic.png";
            if(!file_put_contents($idcardfpic, base64_decode($this->request->param("idcard_f")))){
                $this->ajaxReturn(['status' => -1, 'msg' => '身份证保存错误']);
            }
            if(!file_put_contents($idcardbpic, base64_decode($this->request->param("idcard_b")))){
                $this->ajaxReturn(['status' => -1, 'msg' => '身份证保存错误']);
            }
            
            //运行到此说明认证通过
            $data['realname']    = $this->request->param("realname");
            $data['sex']         = $this->request->param("sex");
            $data['idcard']      = $this->request->param("idcard");
            $data['idcard_fpic'] = $idcardfpic;
            $data['idcard_bpic'] = $idcardbpic;
            $data['idcard_isvalidate'] = 1;
            
            if(\think\Db::name("Users")->where("user_id",$this->user_id)->update($data)){
                $this->ajaxReturn(['status' => 1, 'msg' => '恭喜认证通过']);
            }else{
                $this->ajaxReturn(['status' => -1, 'msg' => '认证失败']);
            }
            
        }
    }
    /*
     * 账户资金
     */
    public function account(){
        
        $unique_id = I("unique_id"); // 唯一id  类似于 pc 端的session id
       // $user_id = I('user_id/d'); // 用户id
        //获取账户资金记录
        
        $data = $this->userLogic->get_account_log($this->user_id,I('get.type'));
        $account_log = $data['result'];
        exit(json_encode(array('status'=>1,'msg'=>'获取成功','result'=>$account_log)));
    }    

    /**
     * 申请退货状态
     */
    public function return_goods_status()
    {
        $rec_id = I('rec_id','');
        
        $return_goods = M('return_goods')
            ->where(['rec_id'=>$rec_id])
            ->find();
        
        //判断是否超过退货期
        $order = M('order')->where('order_id',$return_goods['order_id'])->find();
        $confirm_time_config = tpCache('shopping.auto_service_date');//后台设置多少天内可申请售后
        $confirm_time = $confirm_time_config * 24 * 60 * 60;
        if ($order && (time() - $order['confirm_time']) > $confirm_time && !empty($order['confirm_time'])) {
            return ['result'=>-1,'msg'=>'已经超过' . ($confirm_time_config ?: 0) . "天内退货时间"];
        }
        
        $return_id = $return_goods ? $return_goods['id'] : 0; //1代表可以退换货
        $this->ajaxReturn(['status'=>1, 'msg'=>'获取成功',  'result' => $return_id]);
    }
     
    /**
     * 获取收藏店铺列表集合, 只用于查询用户收藏的店铺, 页面判断用, 区别于getUserCollectStore
     */
    public function getCollectStoreData()
    {
        $where = array('user_id' => $this->user_id);
        $storeCollects = M('store_collect')->where($where)->select();
        $json_arr = array('status' => 1, 'msg' => '获取成功', 'result' => $storeCollects);
        exit(json_encode($json_arr));
    }

    /**
     * @author dyr
     * 获取用户收藏店铺列表
     */
    public function getUserCollectStore()
    {
        $page = I('page', 1);
        $storeLogic = new StoreLogic();
        $store_list = $storeLogic->getUserCollectStore($this->user_id,$page,10);
        $json_arr = array('status' => 1, 'msg' => '获取成功', 'result' => $store_list);
        exit(json_encode($json_arr));
    }
    
    /**
     * 申请提现记录列表网页
     * @return type
     */
    public function withdrawals_list()
    {
        $is_json = I('is_json', 0); //json数据请求
        $withdrawals_where['user_id'] = $this->user_id;
        $count = M('withdrawals')->where($withdrawals_where)->count();
        $pagesize = C('PAGESIZE') == 0 ? 10 : C('PAGESIZE');
        $page = new Page($count, $pagesize);
        $list = M('withdrawals')->where($withdrawals_where)->order("id desc")->limit("{$page->firstRow},{$page->listRows}")->select();

        if ($is_json) {
            $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $list]);
        }
        
        $this->assign('page', $page->show());// 赋值分页输出
        $this->assign('list', $list); // 下线
        if (I('is_ajax')) {
            return $this->fetch('ajax_withdrawals_list');
        }
        return $this->fetch();
    }
    
    /**
     * 申请提现
     */
    public function withdrawals()
    {
        $data = I('post.');
        if (!capache([], SESSION_ID, $data['verify_code'])) {
            $this->ajaxReturn(['status' => -1, 'msg' => "验证码错误"]);
        }
        if(isset($_POST['paypwd']) && encrypt($data['paypwd']) != $this->user['paypwd']){
            $this->ajaxReturn(['status' => -1, 'msg' => "支付密码错误"]);
        }
        $data['user_id'] = $this->user_id;    		    		
        $data['create_time'] = time();                
        $distribut_min = tpCache('basic.min'); // 最少提现额度
        $distribut_need  = tpCache('basic.need'); //满多少才能提
        if ($data['money'] < $distribut_min) {
            $this->ajaxReturn(['status' => -1, 'msg' => '每次最少提现额度'.$distribut_min]);
        }
        if ($data['money'] > $this->user['user_money']) {
            $this->ajaxReturn(['status' => -1, 'msg' => "你最多可提现{$this->user['user_money']}账户余额."]);
        } 
        if ($this->user['user_money']<$distribut_need) {
            $this->ajaxReturn(['status' => -1, 'msg' => '账户余额最少达到'.$distribut_need.'才能提现']);
        }    

        $withdrawal = M('withdrawals')->where(array('user_id'=>$this->user_id,'status'=>0))->sum('money');
        if ($this->user['user_money'] < ($withdrawal+$data['money'])){
            $this->ajaxReturn(['status' => -1, 'msg' => '您有提现申请待处理，本次提现余额不足']);
        }
        if (M('withdrawals')->add($data)) {
            $bank['bank_name'] = $data['bank_name'];
            $bank['bank_card'] = $data['account_bank'];
            $bank['realname'] = $data['account_name'];
            M('users')->where(array('user_id'=>$this->user_id))->save($bank);
            $json_arr = array('status' => 1, 'msg' => '提交成功');
        } else {
            $json_arr = array('status' => -1, 'msg' => '提交失败,联系客服!');
        }
        $this->ajaxReturn($json_arr);
    }
    
    /**
     * 账户明细
     */
    public function points()
    {
        $type = I('type','all');
        $usersLogic = new UsersLogic;
    	$result = $usersLogic->points($this->user_id, $type);
        
        $json_arr = ['status' => 1, 'msg' => '获取成功', 'result' => $result['account_log']];
        exit(json_encode($json_arr));
    }
    
    /**
     * 图形验证码获取
     */
    public function verify()
    {
        $type = I('get.type') ?: SESSION_ID;
        $is_image = I('get.is_image', 0);
        if (!$is_image) {
            $result = capache([], $type);
            $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $result]);
        }

        $config = array(
            'fontSize' => 30,
            'length' => 4,
            'imageH' =>  60,
            'imageW' =>  300,
            'fontttf' => '5.ttf',
            'useCurve' => true,
            'useNoise' => false,
            'length'   => 4,
        );
        $Verify = new \think\Verify($config);
        $Verify->entry($type);
        exit;
    }
    
    /**
     * 评论列表
     */
    public function comment()
    {
        $status = I('get.status', 0);
        $logic = new CommentLogic;
        $result = $logic->getComment($this->user_id, $status);
        
        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $result['result']]);
    }
    
    /**
     * 服务评论列表
     */
    public function service_comment()
    {
        $p = input('p', 1);
        $logic = new CommentLogic;
        $result = $logic->getServiceComment($this->user_id, $p);
        
        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $result]);
    }
    
    public function comment_num()
    {
        $logic = new CommentLogic;
        $result = $logic->getAllTypeCommentNum($this->user_id);
        
        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $result]);
    }
    
    /**
     * 浏览记录
     */
    public function visit_log()
    {
        $p = I('get.p', 1);

        $user_logic = new UsersLogic;
        $visit_list = $user_logic->visit_log($this->user_id, $p);
        
        $list = [];
        foreach ($visit_list as $k => $v) {
            $list[] = ['date' => $k, 'visit' => $v];
        }
        
        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $list]);
    }

    /**
     * 删除浏览记录
     */
    public function del_visit_log()
    {
        $visit_ids = I('visit_ids', 0);
        $row = M('goods_visit')->where('visit_id','IN', $visit_ids)->delete();
        if (!$row) {
            $this->ajaxReturn(['status' => -1, 'msg' => '删除失败']);
        }
        $this->ajaxReturn(['status' => 1, 'msg' => '删除成功']);
    }
    
    /**
     * 清空浏览记录
     */
    public function clear_visit_log()
    {
        $row = M('goods_visit')->where('user_id', $this->user_id)->delete();
        if(!$row) {
            $this->ajaxReturn(['status' => -1, 'msg' => '删除失败']);
        }
        $this->ajaxReturn(['status' => 1, 'msg' => '删除成功']);
    }
    
    /**
     *  获取用户消息通知
     */
    public function message_notice()
    {
        $messageModel = new \app\common\logic\MessageLogic;
        $messages = $messageModel->getUserPerTypeLastMessage();

        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $messages]);
    }
    
    /**
     * 获取消息
     */
    public function message()
    {
        $p = I('get.p', 1);
        $category = I('get.category', 0);
        
        $messageModel = new \app\common\logic\MessageLogic;
        $message = $messageModel->getUserMessageList($this->user_id, $category, $p);

        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $message]);
    }
    
    /**
     * 消息开关
     */
    public function message_switch()
    {
        if (!$this->user) {
            $this->ajaxReturn(['status' => -1, 'msg' => '用户不存在']);
        }
        
        $messageModel = new \app\common\logic\MessageLogic;
        
        if (request()->isGet()) {
            /* 获取消息开关 */
            $notice = $messageModel->getMessageSwitch($this->user['message_mask']);
            $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $notice]);
        } elseif (request()->isPost()) {
            /* 设置消息开关 */
            $type = I('post.type/d', 0); //开关类型
            $val = I('post.val', 0); //开关值
            $return = $messageModel->setMessageSwitch($type, $val, $this->user);
            $this->ajaxReturn($return);
        }

        $this->ajaxReturn(['status' => -1, 'msg' => '请求方式错误']);
    }

    /**
     * 清除消息
     */
    public function clear_message()
    {
        if (!$this->user_id) {
            $this->ajaxReturn(['status' => -1, 'msg' => '用户不存在']);
        }
        
        $messageModel = new \app\common\logic\MessageLogic;
        $messageModel->setMessageRead($this->user_id);
        
        $this->ajaxReturn(['status' => 1, 'msg' => '清除成功']);
    }
    
    /**
     * 账户明细列表网页
     * @return type
     */
    public function account_list()
    {
    	$type = I('type','all');
        $is_json = I('is_json', 0); //json数据请求
    	$usersLogic = new UsersLogic;
    	$result = $usersLogic->account($this->user_id, $type);
        
        if ($is_json) {
            $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $result['account_log']]);
        }
        
    	$this->assign('type', $type);
    	$showpage = $result['page']->show();
    	$this->assign('account_log', $result['account_log']);
    	$this->assign('page', $showpage);
    	if (I('is_ajax')) {
    		return $this->fetch('ajax_acount_list');
    	}
    	return $this->fetch();
    }
    
    /**
     * 积分类别网络
     * @return type
     */
    public function points_list()
    {
        $type = I('type','all');
        $is_json = I('is_json', 0); //json数据请求
    	$usersLogic = new UsersLogic;
    	$result = $usersLogic->points($this->user_id, $type);
        
        if ($is_json) {
            $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $result['account_log']]);
        }
        
        $this->assign('type', $type);
		$showpage = $result['page']->show();
        $this->assign('account_log', $result['account_log']);
        $this->assign('page', $showpage);
        if (I('is_ajax')) {
            return $this->fetch('ajax_points');
        }
        return $this->fetch();
    }
    
    /**
     * 充值记录网页
     * @return type
     */
    public function recharge_list()
    {
        $is_json = I('is_json', 0); //json数据请求
    	$usersLogic = new UsersLogic;
    	$result= $usersLogic->get_recharge_log($this->user_id);  //充值记录
    	
        if ($is_json) {
            $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $result['result']]);
        }
        
        $this->assign('page', $result['show']);
    	$this->assign('lists', $result['result']);
    	if (I('is_ajax')) {
    		return $this->fetch('ajax_recharge_list');
    	}
    	return $this->fetch();
    }
    
    /**
     * 物流网页
     * @return type
     */
    public function express()
    {
        $is_json = I('is_json', 0);
        $order_id = I('get.order_id/d', 0);
        $order_goods = M('order_goods')->where("order_id" , $order_id)->select();
        $delivery = M('delivery_doc')->where("order_id" , $order_id)->limit(1)->find();
        if ($is_json) {
            $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $delivery]);
        }
        $this->assign('order_goods', $order_goods);
        $this->assign('delivery', $delivery);
        return $this->fetch();
    }
    
    /**
     * 获取全部地址信息, 从BaseController移入到UserController @modify by wangqh.
     */
    public function allAddress(){
        $data =  M('region')->where('level < 4')->select();
        $json_arr = array('status'=>1,'msg'=>'成功!','result'=>$data);
        $json_str = json_encode($json_arr);
        exit($json_str);
    }
    
    /**
     * 关于我们页面
     */
    public function about_us()
    {
        return $this->fetch();
    }
    
    /**
     * 检查token状态
     */
    public function token_status()
    {
        $token = I('token/s', '');
        $return = $this->getUserByToken($token);
        if ($return['status'] == 1) {
            $return['result'] = '';
        }
        $this->ajaxReturn($return);
    }
    
    /**
     * 上传评论图片，小程序图片只能一张一张传
     */
    public function upload_comment_img()
    {
        $logic = new \app\common\logic\CommentLogic;
        $img = $logic->uploadCommentImgFile('comment_img_file');
        
        if ($img['status'] === 1) {
            $img['result'] = implode(',', $img['result']);
        }

        $this->ajaxReturn($img);
    }
    
    /**
     * 消息列表（小程序临时接口by lhb）
     * @author dyr
     * @time 2016/09/01
     */
    public function message_list()
    {
        $type = I('type', 0);
        $user_logic = new UsersLogic();
        $message_model = new \app\common\logic\MessageLogic();
        if ($type == 1) {
            //系统消息
            $user_sys_message = $message_model->getUserMessageNotice();
            //$user_logic->setSysMessageForRead();
        } else if ($type == 2) {
            //活动消息：后续开发
            $user_sys_message = array();
        } else {
            //全部消息：后续完善
            $user_sys_message = $message_model->getUserMessageNotice();
        }
        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $user_sys_message]);
    }
 
    
    
    /**
     * 支付密码
     */
    public function paypwd()
    {
        $code = I('post.paypwd_code');
        $mobile = trim(I('mobile'));

        $session_id = SESSION_ID;
        $scene = 6; //身份验证场景

        $logic = new UsersLogic();
        $res = $logic->check_validate_code($code, $mobile, 'mobile' ,$session_id, $scene);
        if ($res['status'] !== 1) {
            $this->ajaxReturn($res);
        }

        //检查是否第三方登录用户
        $user = M('users')->where('user_id', $this->user_id)->find();;
        if ($user['mobile'] == '' && $user['email'] == '') {
            $this->ajaxReturn(['status'=>-1, 'msg'=>'请先绑定手机号或者邮箱']);
        }

        $new_password = trim(I('new_password'));
        $data = $logic->payPwdForApp($this->user_id, $new_password);
        $this->ajaxReturn($data);
    }
    
    //会员注册茶馆图片上传
    //imgs base64位的图片源
    //type 图片保存的路径　　shopimgs 保存入驻茶商茶馆的图片路径
    //                  tea_arts 保存入驻茶艺师的图片路径　
    public function imgs_upload()
    {
        $this->ajaxReturn($this->upload_base64img());
    }
    
    //会员注册茶馆
    public function teamerchant_add()
    {
        if($this->request->isPost()){
            
            $exits_app_shop=\think\Db::name('store_apply')
                                ->where(['user_id'=>['eq',$this->user_id]])
                                ->find();
            
            //if(!empty($exits_app_shop['apply_state'])){
                if($exits_app_shop['apply_state']==0){
                    $this->ajaxReturn(['status'=>-1,'msg'=>'入驻申请已经提交，请等待管理员审核!']);
                }elseif($exits_app_shop['apply_state']==1){
                    $this->ajaxReturn(['status'=>-1,'msg'=>'您的资料已经审核通过，现在您可以去经营您的店铺了，赶紧去商铺发布商品吧!']);
                     
                }elseif($exits_app_shop['apply_state']==2){
                    $this->ajaxReturn(['status'=>-1,'msg'=>'抱歉，您的申请没有通过，系统将导自动导引到入驻页面,请您重新填写入驻信息!']);
                
                }
                
            //}
            
            if(!$this->user['idcard_isvalidate']){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请先实名认证!']);
            }
            
            $postData = input("post.");
            $verify_srore_name=\think\Db::name('store_apply')->where(['store_name'=>$postData['store_name'],'user_id'=>['neq',$this->user_id]])->count(); //检查店铺名称是否重复
            if(empty($postData['shop_logo'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请上传店铺logo!']);
            }
            if(empty($postData['store_name'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请填写店铺名称!']);
            }elseif($verify_srore_name['store_name']){
                $this->ajaxReturn(['status'=>-1,'msg'=>'当前店铺名称已被使用!']);
            }
            if(empty($postData['shop_zy'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请填写主营商品!']);
            }
            if(empty($postData['business_licence_number'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请填写注册号!']);
            }
            if(empty($postData['business_licence_cert'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请上传营业执照!']);
            }
            
            if(empty($postData['shop_address'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请填写详细地址!']);
            }
            
            if(empty($postData['shop_desc'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请填写店铺简介!']);
            }
            /*
            if(empty($postData['shop_bglist'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请上传!']);
            }
          
            if(empty($postData['shop_type'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'店铺类型必传1茶馆2茶商!']);
            }  */
            
            $data['shop_logo']               = $postData['shop_logo'];
            $data['store_name']              = $postData['store_name'];
            $data['shop_zy']                 = $postData['shop_zy'];
            $data['business_licence_number'] = $postData['business_licence_number'];
            $data['business_licence_cert']   = $postData['business_licence_cert'];
            $data['country_cert']            = $postData['country_cert'];
            $data['longtitude']              = $postData['longtitude'];
            $data['latitude']                = $postData['latitude'];
            $data['store_address']           = $postData['shop_address'];
            $data['shop_desc']               = $postData['shop_desc'];
            $data['shop_bglist']             = $postData['shop_bglist'];
            $data['shop_type']               = $postData['shop_type'];
            
            
            $data['user_id']                 = $this->user_id;
            $data['add_time']                = time();
            $data['seller_name']             = $this->user['realname'];
            $data['contacts_name']           = $this->user['realname'];
            $data['store_person_cert']       = $this->user['idcard_fpic'];
            
            $data['store_person_name']       = $this->user['realname'];
            $data['store_person_mobile']     = $this->user['mobile'];
            
            if(\think\Db::name("store_apply")->save($data)){
                $this->ajaxReturn(['status'=>1,'msg'=>'提交成功,请等待审核结果']);
            }else{
                $this->ajaxReturn(['status'=>-1,'msg'=>'提交失败']);
            }
          
        }else{
            $this->ajaxReturn(['status'=>-1,'msg'=>'请求错误']);
        }
    }
    
    //添加茶馆
    public function teashop_add()
    {
        if($this->request->isPost()){
            
            //验证是否已经入驻茶商
            $is_merchant = \think\Db::name("Store")->where(function($query){
                $query->where("user_id",$this->user_id);
            })->find();
            if(!$is_merchant['store_id']){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请先入驻茶商后才可添加线下茶馆']);
            }
            
            $exits_app_shop=\think\Db::name('store_entry')
                                ->where(['store_id'=>['eq',$is_merchant['store_id']]])
                                ->find();
            
            if(!empty($exits_app_shop['shop_state'])){
                if($exits_app_shop['shop_state']==1){
                    $this->ajaxReturn(['status'=>-1,'msg'=>'入驻申请已经提交，请等待管理员审核!']);
                }elseif($exits_app_shop['shop_state']==2){
                    $this->ajaxReturn(['status'=>-1,'msg'=>'您的资料已经审核通过!']);
                     
                }/*elseif($exits_app_shop['apply_state']==2){
                    $this->ajaxReturn(['status'=>-1,'msg'=>'抱歉，您的申请没有通过，系统将导自动导引到入驻页面,请您重新填写入驻信息!']);
                
                }*/
                
            }
            
            if(!$this->user['idcard_isvalidate']){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请先实名认证!']);
            }
            
            $postData = input("post.");
            $verify_srore_name=\think\Db::name('store_entry')->where(['shop_name'=>$postData['shop_name'],'store_id'=>['neq',$this->user['store_id']]])->count(); //检查店铺名称是否重复
            if(empty($postData['shop_logo'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请上传店铺logo!']);
            }
            if(empty($postData['shop_name'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请填写店铺名称!']);
            }elseif($verify_srore_name['shop_name']){
                $this->ajaxReturn(['status'=>-1,'msg'=>'此茶馆已经添加过了!']);
            }
            if(empty($postData['shop_products'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请填写主营商品!']);
            }
            if(empty($postData['shop_licence_cert'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请填写注册号!']);
            }
            if(empty($postData['shop_licence_img'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请上传营业执照!']);
            }
            
            if(empty($postData['shop_address'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请填写详细地址!']);
            }
            
            if(empty($postData['shop_desc'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请填写店铺简介!']);
            }

            $data['shop_logo']               = $postData['shop_logo'];
            $data['shop_name']               = $postData['shop_name'];
            $data['shop_products']           = $postData['shop_products'];
            $data['shop_licence_cert']       = $postData['shop_licence_cert'];
            $data['shop_licence_img']        = $postData['shop_licence_img'];
            $data['shop_cert']               = $postData['shop_cert'];
            $data['shop_longitude']          = $postData['shop_longitude'];
            $data['shop_latitude']           = $postData['shop_latitude'];
            $data['shop_address']            = $postData['shop_address'];
            $data['shop_desc']               = $postData['shop_desc'];
            $data['shop_bglist']             = $postData['shop_bglist'];
            
            $data['store_id']                = $is_merchant['store_id'];
            $data['user_id']                 = $this->user_id;
            $data['add_time']                = time();

            if(\think\Db::name("store_entry")->save($data)){
                $this->ajaxReturn(['status'=>1,'msg'=>'提交成功,请等待审核结果']);
            }else{
                $this->ajaxReturn(['status'=>-1,'msg'=>'提交失败']);
            }
          
        }else{
            $this->ajaxReturn(['status'=>-1,'msg'=>'请求错误']);
        }
    } 
    
    //会员入驻茶艺师
    public function teart_add()
    {
        if($this->request->isPost()){
    
            $exits_app_shop=\think\Db::name('tea_art')
            ->where(['user_id'=>['eq',$this->user_id]])
            ->find();
    
            //if(!empty($exits_app_shop['apply_state'])){
            //如果是更新
            if(!$this->request->param("teart_id")){
                if($exits_app_shop['teart_state']==1){
                    $this->ajaxReturn(['status'=>-1,'msg'=>'入驻申请已经提交，请等待管理员审核!']);
                }elseif($exits_app_shop['teart_state']==2){
                    $this->ajaxReturn(['status'=>-1,'msg'=>'您的资料已经审核通过!']);
                     
                }elseif($exits_app_shop['teart_state']==3){
                    //$this->ajaxReturn(['status'=>-1,'msg'=>'抱歉，您的申请没有通过，请重新申请!']);
        
                }
            }
    
            //}
    
            if(!$this->user['idcard_isvalidate']){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请先实名认证!']);
            }
    
            $postData = input("post.");
            $verify_srore_name=\think\Db::name('tea_art')->where(['teart_name'=>$postData['teart_name'],'user_id'=>['neq',$this->user_id]])->count(); //检查名称是否重复
            if(empty($postData['teart_logo'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请上传logo!']);
            }
            if(empty($postData['teart_name'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请填写茶艺师名称!']);
            }elseif($verify_srore_name['teart_name']){
                $this->ajaxReturn(['status'=>-1,'msg'=>'当前茶艺师名称已被使用!']);
            }

            if(empty($postData['teart_cert_num'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请填写注册号!']);
            }
            if(empty($postData['teart_fcert'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请上传茶艺师正面照!']);
            }
    
            if(empty($postData['teart_bcert'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请上传茶艺师背面照!']);
            }
            
            if(empty($postData['teart_address'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请填写详细地址!']);
            }
    
            if(empty($postData['teart_desc'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请填写茶艺师简介!']);
            }

            /*
             * teart_id
            teart_logo
            teart_name
            teart_cert_num
            teart_fcert
            teart_bcert
            longitude
            latitude
            address
            teart_desc
            teart_pics
            user_id
            add_time
            teart_state
             * **/
    
            $data['teart_logo']      = $postData['teart_logo'];
            $data['teart_name']      = $postData['teart_name'];
            $data['teart_fcert']     = $postData['teart_fcert'];
            $data['teart_cert_num']  = $postData['teart_cert_num'];
            $data['teart_bcert']     = $postData['teart_bcert'];
            $data['longitude']       = $postData['longitude'];
            $data['latitude']        = $postData['latitude'];
            $data['address']         = $postData['teart_address'];
            $data['teart_desc']      = $postData['teart_desc'];
            $data['teart_pics']      = $postData['teart_pics'];
            $data['add_time']        = time();
            $data['user_id']         = $this->user_id;
    
            
            $teart_id = $this->request->param("teart_id");
            if(isset($teart_id)&&!empty($teart_id)){
                //当更新时状态默认为未审核
                $data['teart_state']  = 1;
                $data['update_time']  = time();
                if(\think\Db::name("tea_art")->where("teart_id",$this->request->param("teart_id"))->save($data)){
                    $this->ajaxReturn(['status'=>1,'msg'=>'提交成功,请等待审核结果']);
                }else{
                    $this->ajaxReturn(['status'=>-1,'msg'=>'提交失败']);
                }
            }
            
            if(\think\Db::name("tea_art")->save($data)){
                $this->ajaxReturn(['status'=>1,'msg'=>'提交成功,请等待审核结果']);
            }else{
                $this->ajaxReturn(['status'=>-1,'msg'=>'提交失败']);
            }

        }else{
            $this->ajaxReturn(['status'=>-1,'msg'=>'请求错误']);
        }
    }
    
    //获取会员是否入驻茶艺师的状态信息
    public function userteart_info()
    {
        $teart_status = \think\Db::name("tea_art")->where("user_id",$this->user_id)->getField("teart_state");
        if($teart_status==1){
            $status = ['info'=>'审核中','status'=>'1'];
        }elseif($teart_status==2){
            $status = ['info'=>'已认证','status'=>'2'];
        }else{
            $status = ['info'=>'未通过','status'=>'3'];
        }
        $this->ajaxReturn($status);
    }
    
    //茶艺师发布的服务
    public function addteart_service()
    {
        if($this->request->isPost()){
            $teart_id = \think\DB::name("tea_art")->where("user_id",$this->user_id)->getField("teart_id");
            //获取茶艺师最近发布的服务
            $last_server = \think\Db::name("teart_service")
                                ->where("teart_id",$teart_id)
                                ->order("add_time","desc")
                                ->find();
            if($last_server['end']<I("post.start")){
                $this->ajaxReturn(['status'=>-1,'msg'=>'同一时间段内不可以发布服务']);
            }
            $data['start']  = I("post.start");
            $data['end']    = I("post.end");
            $data['orbit']  = I("post.orbit");
            $data['cost']   = I("post.cost");
            $data['notice'] = I("post.notice");
            $data['add_time'] = time();
            
            $result=$this->validate($data, [
                'start'=>'require|date',
                'end'=>'require|date',
                'orbit'=>'require',
                'cost'=>'require|number',
            
            ],[
                'start.require'=>'开始时间必选',
                'start.date'=>'开始时间格式错误',
                'end.require'=>'结束时间必选',
                'end.date'=>'结束时间格式错误',
                'orbit.require'=>'服务范围不可为空',
                'cost.require'=>'服务费用不可为空',
                'cost.number'=>'服务费用填写错误'
            ]);
            if(!is_bool($result)){
                $this->ajaxReturn(['status'=>-1,'msg'=>$result]);
            }

           
            if(empty($teart_id)){
                $this->ajaxReturn(['status'=>-1,'msg'=>'请先注册茶艺师']);
            }
            
            $data['teart_id'] = $teart_id;
            $data['start'] = strtotime($data['start']);
            $data['end']   = strtotime($data['end']);
            
            $tea_service_id = $this->request->param("id");
            
            if(isset($tea_service_id)){
                if(\think\Db::name("teart_service")->where("id",$tea_service_id)->save($data)){
                    $this->ajaxReturn(['status'=>1,'msg'=>'服务更新成功']);
                }else{
                    $this->ajaxReturn(['status'=>1,'msg'=>'服务发布失败']);
                }
            }
            if(\think\Db::name("teart_service")->save($data)){
                $this->ajaxReturn(['status'=>1,'msg'=>'服务发布成功']);
            }else{
                $this->ajaxReturn(['status'=>1,'msg'=>'服务发布失败']);
            }
            
        }else{
            $this->ajaxReturn(['status'=>-1,'msg'=>'请求错误']);
        } 
    }
    
    //茶艺师发布的服务列表
    //最新发布的排在前面
    //剩余的数据皆为历史服务发布记录
    public function geteart_servicelist()
    {
        $p = I("p");
        $teart_id = \think\Db::name("tea_art")->where("user_id",$this->user_id)->getField("teart_id");
        if(empty($teart_id)){
            $this->ajaxReturn(['status'=>-1,'msg'=>'请先注册茶艺师']);
        }
        $pagesize = C('PAGESIZE') == 0 ? 10 : C('PAGESIZE');
        ///$count = M("teart_service")->where("teart_id",$teart_id)->count();
        //$page = new Page($count,1);
        
        
        $list = M("teart_service")
                    ->where("teart_id",$teart_id)
                    ->page($p,10)
                    ->order("add_time","desc")
                    ->select();
        foreach ($list as $k=>$v){
            $list[$k]['service_time'] = date("Y.m.d",$v['start']).'-'.date("Y.m.d",$v['end']);
            $list[$k]['add_time']     = date("Y-m-d H:i",$v['add_time']);
        }
        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $list]);
    }
    
    //茶艺师关注和取消关注
    public function subscribe_teart()
    {
        $teart_id = I("teart_id");
        empty($teart_id) && $this->ajaxReturn(['status'=>-1,'msg'=>'参数错误']);
        $tea = \think\Db::name("tea_art")->where("teart_id",$teart_id)->getField("teart_id");
        empty($tea) && $this->ajaxReturn(['status'=>-1,'msg'=>'您关注的茶艺师不存在']);
        $subscribe = \think\Db::name("teart_collect")
                            ->where("teart_id",$teart_id)
                            ->where("user_id",$this->user_id)
                            ->find();
        
        if($subscribe['user_id']){
            //存在则取消关注
            if(\think\Db::name("teart_collect")->where(['teart_id'=>$teart_id,'user_id'=>$this->user_id])->delete()){
                $this->ajaxReturn(['status'=>1,'msg'=>'成功取消关注']);
            }
        }else{
            //添加关注
            if(\think\Db::name("teart_collect")->save(['user_id'=>$this->user_id,'teart_id'=>$teart_id,'add_time'=>time()])){
                $this->ajaxReturn(['status'=>1,'msg'=>'成功关注']);
            }
        }
    }
    
    //茶艺师列表获取
    public function teart_list()
    {
        //排序　
        //距离计算　　未完成
        //评分计算　　未完成
        $p = I("p")?:1;
        $list = M("tea_art")->order("add_time")->page($p,10)->select();
        $sub = $this->get_teart_subnum();
        foreach ($list as $k=>$v){
            $list[$k]['subscribe'] = count($sub[$v['user_id']]);
        }
        $json = ['status' => 1, 'msg' => '获取成功', 'result' => $list];
        $this->ajaxReturn($json);
    }
    
    //茶艺师搜索列表
    public function teart_list_serach()
    {
        $p = I("p")?:1;
        $keyword = I("keyword");
        empty($keyword) && $this->ajaxReturn(['status'=>-1,'msg'=>'搜索关键字不可为空']);
        $list = \think\Db::name("tea_art")->whereLike("teart_name","%{$keyword}%")->order("add_time")->page($p,10)->fetchSql(false)->select();
        $sub = $this->get_teart_subnum();
        foreach ($list as $k=>$v){
            $list[$k]['subscribe'] = count($sub[$v['user_id']]);
        }
        $json = ['status' => 1, 'msg' => '获取成功', 'result' => $list];
        $this->ajaxReturn($json);
    }
    
    //获取每个茶艺师的关注人数
    private function get_teart_subnum()
    {
        $list = \think\Db::name("teart_collect")->field("user_id,teart_id")->select();
        $user_sub = [];
        foreach ($list as $k=>$v){
            $user_sub[$v['user_id']][] = $v['teart_id'];
        }
        return $user_sub;
    }
    
    //获取茶艺师详情
    public function get_teart_info()
    {
        $teart_id = I("teart_id");
        $longitude = I("longitude");
        $latitude = I("latitude");
        
        empty($teart_id) && $this->ajaxReturn(['status'=>-1,'msg'=>'参数错误']);
        $info = \think\Db::name("tea_art")->where("teart_id",$teart_id)->find();
        
        $info['bglist'] = explode(",", $info['teart_pics']);
        $info['subscribe'] = \think\Db::name("teart_collect")->where("teart_id",$info['teart_id'])->count("user_id");
        //距离计算
        $info['distance'] = '';
        //综合评价
        $info['score']  = '';
        
        //获取当前茶艺师最新的服务数据
        $info['last_service'] = \think\Db::name("teart_service")->where("teart_id",$teart_id)->order("add_time","desc")->select();
        foreach ($info['last_service'] as $k=>$v){
            $info['last_service'][$k]['service_period'] = date("Y.m.d",$v['start']).'-'.date("Y.m.d",$v['end']);
        }
        $json = ['status' => 1, 'msg' => '获取成功', 'result' => $info];
        $this->ajaxReturn($json);
    }
    
    //茶艺师预约结算
    public function addteart_order()
    {
        $teart_id = I("teart_id");
        
        $start    = I("start");//服务时间段
        $end      = I("end");
        $longitude = I("longitude");//服务范围
        $latitude  = I("latitude");
        
        
        empty($teart_id) && $this->ajaxReturn(['status'=>-1,'msg'=>'参数错误']);
        //获取该茶艺师的最新服务
        $info = \think\Db::name("teart_service")->where("teart_id",$teart_id)->order("add_time","desc")->find();
        
        //茶艺师服务时间段
        $info['start_service'] = date("Y-m-d H:i",$info['start']);
        $info['end_service']   = date("Y-m-d H:i",$info['end']);
        
        //茶艺师信息
        $info['tea_artinfo'] = \think\Db::name("tea_art")->where("teart_id",$teart_id)->find();
        //计算服务费用
        $info['pay'] = round(((strtotime($end)-strtotime($start))/3600)*$info['cost'],2);
        
        $json = ['status' => 1, 'msg' => '获取成功', 'result' => $info];
        $this->ajaxReturn($json);
    }
    
    //茶艺师服务订单添加
    public function submit_tea_order()
    {
        //判断服务时间是否在２小时以内
        //判断服务范围是否在指定范围内
        //判断服务详细地址是否填写

        $data['teart_id']  = I("teart_id");
        $data['start']     = I("start");//服务时间段
        $data['end']       = I("end");
        $data['longitude'] = I("longitude");//服务范围
        $data['latitude']  = I("latitude");
        $data['address']   = I("address");
        
        $result = $this->validate($data, [
            'teart_id'=>'require|number',
            'start'=>'require|date',
            'end'=>'require|date',
            'longitude'=>'require|number',
            'latitude'=>'require|number',
            'address'=>'require'
        ],[
            'teart_id.require'=>'预约的茶艺师id不可为空',
            'start.require'=>'服务开始时间必选',
            'start.date'=>'服务开始时间格式错误',
            'end.require'=>'服务结束时间必选',
            'end.date'=>'服务结束时间格式错误',
            'longitude.require'=>'服务位置经纬度必传',
            'longitude.number'=>'服务位置经纬度必传',
            'latitude.require'=>'服务位置经纬度必传',
            'latitude.number'=>'服务位置经纬度必传',
            'address.require'=>'服务具体位置不得为空'
        ]);
        if(!is_bool($result)){
            $this->ajaxReturn(['status'=>-1,'msg'=>$result]);
        }
        
        //服务时间范围验证
        $service_period = (strtotime($data['end'])-strtotime($data['start']))/3600;
        
        if($service_period<2){
            $this->ajaxReturn(['status'=>-1,'msg'=>'服务时间范围最少2H']);
        }
        
        //服务范围判断
        $tea_xy = \think\Db::name("tea_art")
                            ->field("longitude,latitude,address")
                            ->where("teart_id",$data['teart_id'])
                            ->find();
        
        //计算客户到茶艺师的距离
        $distance = caldistance($data['longitude'], $data['latitude'], $tea_xy['longitude'], $tea_xy['latitude']);
     
        $service_distance = \think\Db::name("teart_service")->where("teart_id",$data['teart_id'])->find();
        if($distance['results'][0]['distance']>$service_distance['orbit']){
            $this->ajaxReturn(['status'=>-1,'msg'=>'您所在的位置不在服务区域']);
        }
        //print_r($distance);
        
        //提交的服务时间段必须在指定的范围内
        if(strtotime($data['start'])<$service_distance['start']||strtotime($data['start'])>$service_distance['end']){
            $this->ajaxReturn(['status'=>-1,'msg'=>'服务的起始时间错误']);
        }
        if(strtotime($data['end'])<$service_distance['start']||strtotime($data['end'])>$service_distance['end']){
            $this->ajaxReturn(['status'=>-1,'msg'=>'服务的结束时间错误']);
        }
        
        //茶艺师不能约自己
        $isMyself = \think\Db::name("tea_art")->where("user_id",$this->user_id)->find();
        if($isMyself['teart_name'])$this->ajaxReturn(['status'=>-1,'msg'=>'不能自己约自己哦']);
        //创建订单
        $order_data = [
            'order_sn'=>$this->get_order_sn(),
            'user_id' =>$this->user_id,
            'user_longitude'=>$data['longitude'],
            'user_latitude'=>$data['latitude'],
            'user_address'=>$data['address'],
            'teart_id'=>$data['teart_id'],
            'cost'=>$service_distance['cost'],
            'service_period'=>$service_period,
            'tea_art_location'=>$tea_xy['address'],
            'service_distance'=>$distance['results'][0]['distance'],
            'service_pay'=>round(((strtotime($data['end'])-strtotime($data['start']))/3600)*$service_distance['cost'],2),
            'pay'=>round(((strtotime($data['end'])-strtotime($data['start']))/3600)*$service_distance['cost'],2),
            'add_time'=>time(),
            'service_date'=>$data['start'].'-'.$data['end'],
        ];
        /*
        if(!!$order_id = \think\Db::name("teart_order")->save($order)){
            $this->ajaxReturn(['status'=>1,'msg'=>'预约成功请支付','result'=>['order_id'=>$order_id]]);
        }*/
        $order = new \app\common\logic\TeaOrderLogic();
        if(!!$orderid=$order->addOrder($order_data)){
            $this->ajaxReturn(['status'=>1,'msg'=>'预约成功请支付','result'=>['order_id'=>$orderid]]);
        }
    }
    
    //获取茶艺师订单号
    public function get_order_sn()
    {
        $order_sn = null;
        // 保证不会有重复订单号存在
        while(true){
            $order_sn = date('YmdHis').rand(1000,9999); // 订单编号
            $order_sn_count = M('teart_order')->where("order_sn",$order_sn)->count();
            if($order_sn_count == 0)
                break;
        }
        return $order_sn;
    }
    
    //预约支付页面
    public function teapayorder()
    {
            $order_id = I("order_id");
            $order = M("teart_order")->where("order_id",$order_id)->sum("pay");
            if(!is_numeric($order)){
                $this->ajaxReturn(['status'=>-1,'msg'=>'订单不存在']);
            }
            $order_info = M("teart_order")->where("order_id",$order_id)->find();
            $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result' => ['order'=>$order_info]]);
    }
    
    //我的预约订单列表
    public function userteaorder_list()
    {
        //pay_status 0　未支付　　１已支付　　２已退款
        //order_state 0 未完成　1用户取消申请　２商家取消　３已完成
        //agree 0 待审核　　１通过　２拒绝
        $p = $this->request->param("p");
        //empty($this->request->param("status")) && $this->ajaxReturn(['status'=>-1,'msg'=>'参数错误']);
        switch ($this->request->param("status")){
            case '1':
                //待付款
                $condition = "pay_status='NULL' and order_state='NULL'";
                
                $list = M("TeartOrder")
                ->where("user_id",$this->user_id)
                ->where('pay_status','NULL')
                ->where('order_state','NULL')
                ->order("add_time","desc")
                ->page($p,10)
                ->fetchSql(false)
                ->select();
                
                break;
            case '2':
                //待评价
                $condition = "pay_status=1 and (order_state=2 or order_state='NULL')";
                $list = M("TeartOrder")
                ->where("user_id",$this->user_id)
                ->where('pay_status','1')
                ->where(function($query){
                    $query->whereOr("order_state","2")->whereOr("order_state",'NULL');
                })
                ->order("add_time","desc")
                ->page($p,10)
                ->fetchSql(false)
                ->select();
                break;
            case '3':
                //待审核
                $condition = "order_state=1 and agree='NULL'";
                $list = M("TeartOrder")
                ->where("user_id",$this->user_id)
                ->where('order_state','1')
                ->where('agree','NULL')
                ->order("add_time","desc")
                ->page($p,10)
                ->fetchSql(false)
                ->select();
                break;
            case '4':
                //已完成
                $condition = "order_state=2 or order_state=3 or (order_state=1 and agree=1)";
                $list = M("TeartOrder")
                ->where("user_id",$this->user_id)
                ->where('order_state','2')
                ->whereOr('order_state','3')
                ->whereOr(function($query){
                    $query->where("order_state",'1')->where("agree","1");
                })
                ->order("add_time","desc")
                ->page($p,10)
                ->fetchSql(false)
                ->select();
                break;
                default:
                    
                     $list = M("TeartOrder")
                     ->where("user_id",$this->user_id)
                     ->order("add_time","desc")
                     ->page($p,10)
                     ->select();
                     
                    
        }
        
        $tea_art = [];
        foreach ($list as $k=>$v){
            $tea_art[] = $v['teart_id'];
            //未付款　未完成
            if(empty($v['pay_status'])&&empty($v['order_state'])){
                $list[$k]['cancelBtn'] = 1;
                $list[$k]['payBtn']    = 1;
                $list[$k]['commentBtn']= 0;
                $list[$k]['status']    = '待付款';
                //已付款　　未完成
            }elseif($v['pay_status']==1&&empty($v['order_state'])){
                $list[$k]['cancelBtn'] = 1;
                $list[$k]['payBtn']    = 0;
                $list[$k]['commentBtn']= 1;
                $list[$k]['status']    = '待评价';
            }elseif($v['order_state']==2){
                $list[$k]['cancelBtn'] = 0;
                $list[$k]['payBtn']    = 0;
                $list[$k]['commentBtn']= 0;
                $list[$k]['status']    = '被商家取消';
            }elseif($v['pay_status']==1&&$v['order_state']==3){
                $list[$k]['cancelBtn'] = 0;
                $list[$k]['payBtn']    = 0;
                $list[$k]['commentBtn']= 0;
                $list[$k]['status']    = '已完成';
            }elseif($v['order_state']==1&&$v['agree']==0){
                $list[$k]['cancelBtn'] = 0;
                $list[$k]['payBtn']    = 0;
                $list[$k]['commentBtn']= 0;
                $list[$k]['status']    = '已取消(待审核)';
            }elseif($v['order_state']==1&&$v['agree']==1){
                $list[$k]['cancelBtn'] = 0;
                $list[$k]['payBtn']    = 0;
                $list[$k]['commentBtn']= 0;
                $list[$k]['status']    = '已取消(同意)';
            }elseif($v['order_state']==1&&$v['agree']==2){
                $list[$k]['cancelBtn'] = 0;
                $list[$k]['payBtn']    = 0;
                $list[$k]['commentBtn']= 0;
                $list[$k]['status']    = '已取消(拒绝)';
            }
        }
        $tea = M("TeaArt")->field("teart_id,teart_logo,teart_name")->whereIn("teart_id",$tea_art)->select();
        $teaInfo = [];
        foreach ($tea as $k=>$v){
            $teaInfo[$v['teart_id']] = ['name'=>$v['teart_name'],'headimg'=>$v['teart_logo']];
        }
        foreach ($list as $k=>$v){
            $list[$k]['tea_art'] = $teaInfo[$v['teart_id']];
        }
        $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result' => $list]);
    }
    
    //获取预约订单详情
    public function getteaorder_details()
    {
        $order_id = I("order_id");
        empty($this->request->param("order_id")) && $this->ajaxReturn(['status'=>-1,'msg'=>'参数错误']);
        
        $info = \think\Db::name("teart_order")->where("order_id",$order_id)->find();
        
        if(empty($info['order_id']))$this->ajaxReturn(['status'=>-1,'msg'=>'订单不存在']);
            //未付款　未完成
            if(empty($info['pay_status'])&&empty($info['order_state'])){
                $info['cancelBtn'] = 1;
                $info['payBtn']    = 1;
                $info['commentBtn']= 0;
                $info['status']    = '待付款';
                //已付款　　未完成
            }elseif($info['pay_status']==1&&empty($info['order_state'])){
                $info['cancelBtn'] = 1;
                $info['payBtn']    = 0;
                $info['commentBtn']= 1;
                $info['status']    = '待评价';
                //$info['pay_time']  = date("Y-m-d H:i:s",$info['pay_time']);
            }elseif($info['order_state']==2){
                $info['cancelBtn'] = 0;
                $info['payBtn']    = 0;
                $info['commentBtn']= 0;
                $info['status']    = '被商家取消';
            }elseif($info['pay_status']==1&&$info['order_state']==3){
                $info['cancelBtn'] = 0;
                $info['payBtn']    = 0;
                $info['commentBtn']= 0;
               
                $info['status']    = '已完成';
            }elseif($info['order_state']==1&&$info['agree']==0){
                $info['cancelBtn'] = 0;
                $info['payBtn']    = 0;
                $info['commentBtn']= 0;
                $info['status']    = '已取消(待审核)';
            }elseif($info['order_state']==1&&$info['agree']==1){
                $info['cancelBtn'] = 0;
                $info['payBtn']    = 0;
                $info['commentBtn']= 0;
                $info['status']    = '已取消(同意)';
            }elseif($info['order_state']==1&&$info['agree']==2){
                $info['cancelBtn'] = 0;
                $info['payBtn']    = 0;
                $info['commentBtn']= 0;
                $info['status']    = '已取消(拒绝)';
            }
            
            $info['tea_art'] = \think\Db::name("tea_art")->field(['teart_name','teart_logo'=>'teart_headimg','qq','user_id'])->where("teart_id",$info['teart_id'])->find();
            $info['tea_art_mobile'] = \think\Db::name("users")->field("mobile")->where("user_id",$info['tea_art']['user_id'])->find();
            $info['add_time'] = date("Y-m-d H:i:s",$info['add_time']);
            $info['pay_time']  = empty($info['pay_time'])?0:date("Y-m-d H:i:s",$info['pay_time']);
            $info['comment_time'] = empty($info['comment_time'])?0:date("Y-m-d H:i:s",$info['comment_time']);
            $info['cancel_time'] = empty($info['cancel_time'])?0:date("Y-m-d H:i:s",$info['cancel_time']);
            $info['user']['username'] = $this->user['realname'];
            $info['user']['mobile']   = $this->user['mobile'];
            $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result' => $info]);
    }
    
    //取消预约订单 会员
    public function cancelteaorder()
    {
        $order_id = $this->request->param("order_id");
        empty($this->request->param("order_id")) && $this->ajaxReturn(['status'=>-1,'msg'=>'参数错误']);
        $order = \think\DB::name("teart_order")->where("order_id",$order_id)->find();
        if(empty($order['order_id']))$this->ajaxReturn(['status'=>-1,'msg'=>'订单不存在']);
        if(empty($order['pay_status'])&&empty($order['order_state'])){
            
            //未支付直接取消订单
            if (\think\Db::name("teart_order")->where("order_id",$order_id)->save(['cancel_time'=>time(),'order_state'=>1,'agree'=>1]))$this->ajaxReturn(['status'=>1,'msg'=>'订单取消成功']);
        }elseif($order['pay_status']==1&&empty($order['order_state'])){
            //已支付的取消需要商家审核
            if(\think\Db::name("teart_order")->where("order_id",$order_id)->save(['cancel_time'=>time()]))$this->ajaxReturn(['status'=>1,'msg'=>'订单取消申请成功待商家审核 ']);
        }elseif($order['order_state']==1&&empty($order['agree'])){
            $this->ajaxReturn(['status'=>1,'msg'=>'订单已取消待审核中']);
        }elseif($order['order_state']==1&&$order['agree']==1){
            $this->ajaxReturn(['status'=>1,'msg'=>'订单已取消']);
        }elseif($order['order_state']==1&&$order['agree']==2){
            $this->ajaxReturn(['status'=>1,'msg'=>'订单已取消但商家已经拒绝']);
        }
    }
    
    //预约订单的评价
    public function teaorder_comment()
    {
        $order_id = $this->request->param("order_id");
        $order = \think\DB::name("teart_order")->where("order_id",$order_id)->find();
        if(empty($order['order_id']))$this->ajaxReturn(['status'=>-1,'msg'=>'订单不存在']);
        if(empty($this->request->param("star")))$this->ajaxReturn(['status'=>-1,'msg'=>'给个五星好评吧']);
        if(empty($this->request->param("content")))$this->ajaxReturn(['status'=>-1,'msg'=>'给个评价吧']);
        $comment = \think\Db::name("tea_comment")->where("user_id",$this->user_id)->where("order_id",$order_id)->find();
        if($comment['comment_id'])$this->ajaxReturn(['status'=>-1,'msg'=>'您已经评价']);
        $data['star'] = $this->request->param("star");$data['content'] = $this->request->param("content");
        $data['user_id'] = $this->user_id;$data['order_id'] = $order_id;
        $data['add_time'] = time();
        if($order['pay_status']==1&&empty($order['order_state'])){
            \think\Db::name("tea_comment")->save($data) && $this->ajaxReturn(['status'=>1,'msg'=>'评价成功']);
        }else{
            $this->ajaxReturn(['status'=>-1,'msg'=>'此订单无法评价']);
        }
        
    }
    
    //茶艺师的订单
    public function teart_orderlist()
    {
        $teart_id = \think\Db::name("tea_art")->where("user_id",$this->user_id)->getField("teart_id");
        if(empty($teart_id))$this->ajaxReturn(['status'=>-1,'msg'=>'您还不是茶艺师哦']);
        $order = \think\Db::name("teart_order")->where("teart_id",$teart_id)->select();
        foreach ($order as $k=>$v){
            $tea_art[] = $v['teart_id'];
            //未付款　未完成
            if(empty($v['pay_status'])&&empty($v['order_state'])){
               
                $list[$k]['status']    = '待付款';
                unset($order[$k]);
                //已付款　　未完成
            }elseif($v['pay_status']==1&&empty($v['order_state']&&$v['receive_order']==1)){
                $order[$k]['cancelBtn'] = 0;
                $order[$k]['status']    = '待评价';
            }elseif($v['pay_status']==1&&empty($v['order_state']&&empty($v['receive_order']))){
                $order[$k]['cancelBtn'] = 1;
                $order[$k]['status']    = '接单';
            }elseif($v['order_state']==2){
                
                $list[$k]['status']    = '被商家取消';
                unset($order[$k]);
            }elseif($v['pay_status']==1&&$v['order_state']==3){
               
                $order[$k]['status']    = '已完成';
            }elseif($v['order_state']==1&&$v['agree']==0){
                //$order[$k]['refuseBtn'] = 1;
                //$order[$k]['agreeBtn'] = 1;
                $order[$k]['status']    = '已取消(待审核)';
            }elseif($v['order_state']==1&&$v['agree']==1){
              
                $order[$k]['status']    = '已完成';
            }elseif($v['order_state']==1&&$v['agree']==2){
               
                $order[$k]['status']    = '已完成';
            }
            }
            $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result' => $order]);
    }
    
    //茶艺师取消订单
    public function teart_cancelorder()
    {
        $order_id = $this->request->param("order_id");
        $cancel_desc = $this->request->param("cancel_reason");
        $order = \think\DB::name("teart_order")->where("order_id",$order_id)->find();
        if(empty($order['order_id']))$this->ajaxReturn(['status'=>-1,'msg'=>'订单不存在']);
        empty($cancel_desc) && $this->ajaxReturn(['status'=>-1,'msg'=>'什麼原因取消訂單呢']);
        if($order['pay_status']==1){
            //已经支付的订单取消则要退款返回给用户
            
        }elseif (empty($order['pay_status'])){
            \think\Db::name("teart_order")
            ->where("order_id",$order_id)
            ->save(['cancel_time'=>time(),'cancel_desc'=>$cancel_desc,'order_state'=>2])
            && $this->ajaxReturn(['status'=>1,'msg'=>'訂單取消成功']);
        }
    }
    
    //茶艺师接单详情
    public function teart_receiveorder()
    {
        $order_id = $this->request->param("order_id");
        $teart_id = \think\Db::name("tea_art")->where("user_id",$this->user_id)->getField("teart_id");
        $order = \think\DB::name("teart_order")->where(function($query)use($order_id,$teart_id){
            $query->where("order_id",$order_id)->where("teart_id",$teart_id);
        })->fetchSql(false)->find();
        if(empty($order['order_id']))$this->ajaxReturn(['status'=>-1,'msg'=>'订单不存在']);
        $order['add_time'] = date("Y-m-d H:i:s",$order['add_time']);
        $order['pay_time'] = empty($order['pay_time'])?0:date("Y-m-d H:i:s",$order['pay_time']);
        $order['userinfo'] = \think\Db::name("users")->field("mobile,realname")->where("user_id",$order['user_id'])->find();
        //未付款　未完成
        if(empty($order['pay_status'])&&empty($order['order_state'])){
             
            //$list[$k]['status']    = '待付款';
            //unset($order[$k]);
            //已付款　　未完成
        }elseif($order['pay_status']==1&&empty($order['order_state']&&$order['receive_order']==1)){
            $order['cancelBtn'] = 0;
            $order['status']    = '待评价';
        }elseif($order['pay_status']==1&&empty($order['order_state']&&empty($order['receive_order']))){
            $order['receiveBtn'] = 1;
            $order['status']    = '接单';
        }elseif($order['order_state']==2){
        
            //$list[$k]['status']    = '被商家取消';
            //unset($order[$k]);
        }elseif($order['pay_status']==1&&$order['order_state']==3){
             
            $order['status']    = '已完成';
        }elseif($order['order_state']==1&&$order['agree']==0){
            $order['refuseBtn'] = 1;
            $order['agreeBtn'] = 1;
            $order['status']    = '已取消(待审核)';
        }elseif($order['order_state']==1&&$order['agree']==1){
        
            $order['status']    = '已完成';
        }elseif($order['order_state']==1&&$order['agree']==2){
             
            $order['status']    = '已完成';
        }
        
        $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result' => $order]);
    }
    
    //茶艺师接单
    public function tea_dealorder()
    {
        $order_id = $this->request->param("order_id");
        $teart_id = \think\Db::name("tea_art")->where("user_id",$this->user_id)->getField("teart_id");
        $order = \think\DB::name("teart_order")->where("order_id",$order_id)->where("teart_id",$teart_id)->find();
        if(empty($order['order_id']))$this->ajaxReturn(['status'=>-1,'msg'=>'订单不存在']);
        if($order['pay_status']!=1||!empty($order['order_state']||!empty($order['receive_order'])))$this->ajaxReturn(['status'=>-1,'msg'=>'此订单无法操作']);
        if(\think\Db::name("teart_order")->where("order_id",$order_id)->save(['receive_order'=>1])){
            //接单成功发送一条消息给用户
            $user = \think\Db::name("users")->where("user_id",$order['user_id'])->find();
            $tea_art = \think\Db::name("users")->where("user_id",$this->user_id)->find();
            $msg = $user['realname']."您好!您的订单号为：".$order['order_sn'].'，商家已接单请等待服务,您有任何疑问可联系商家'.$tea_art['mobile'];
            //smsnotice($msg,$user['mobile']);
            smsnotice($msg,$user['mobile']);
            $this->ajaxReturn(['status'=>1,'msg'=>'接单成功','result' => '']);
        }else{
            echo 'error';
        }
    }
    
    //会员取消的订单　茶艺师订单操作　拒绝或同意
    public function dealcancel_order()
    {
        
        $order_id = $this->request->param("order_id");
        $refuse_desc = $this->request->param("refuse_desc");
        $is_agree = $this->request->param("is_agree");
        $teart_id = \think\Db::name("tea_art")->where("user_id",$this->user_id)->getField("teart_id");
        $order = \think\DB::name("teart_order")->where("order_id",$order_id)->where("teart_id",$teart_id)->find();
        if(empty($order['order_id']))$this->ajaxReturn(['status'=>-1,'msg'=>'订单不存在']);
        if($is_agree==1){
            //同意取消
            if($order['pay_status']==1){
                //同意取消并退款
            }
        }elseif($is_agree==2){
            \think\Db::name("teart_order")->where(function($query)use($order_id,$teart_id){
                $query->where("order_id",$order_id)->where("teart_id",$teart_id);
            })->save(['agree'=>2,'refuse_desc'=>$refuse_desc]) && $this->ajaxReturn(['status'=>1,'msg'=>'操作成功']);
        }
    }
    
    //我的发帖
    public function myarticle()
    {
        $article = \think\Db::name("article_tea")->where("user_id",$this->user_id)->select();
        foreach ($article as $k=>$v){
            $article[$k]['add_time'] = date("Y-m-d H:i:s",$v['add_time']);
        }
        $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result' => ['article'=>$article,'userInfo'=>['realname'=>$this->user['realname'],'head_pic'=>$this->user['head_pic']]]]);
    }
    
    //删除帖子
    public function deletearticle()
    {
        $article_id = $this->request->param("article_id");
        empty($article_id) &&$this->ajaxReturn(['status'=>-1,'msg'=>'参数错误']);
        \think\Db::name("article_tea")
        ->where(['id'=>$article_id,'user_id'=>$this->user_id])
        ->delete()
        && $this->ajaxReturn(['status'=>1,'msg'=>'删除成功']);
    }
    
    //我发布的活动列表
    public function myactivity()
    {
        $p = $this->request->param("p")?:1;
        $list = \think\Db::name("active")->where('user_id',$this->user_id)->page($p,10)->select();
        $user = [];
        foreach ($list as $k=>$v){
            $user[] = $v['user_id'];
            $list[$k]['add_time'] = date("Y-m-d H:i:s",$v['add_time']);
            $list[$k]['active_time'] = date("Y-m-d H:i:s",$v['active_time']);
        
            //报名状态处理
            if(time()>strtotime($v['active_time'])){
                $list[$k]['status'] = '1';//报名中
            }else{
                $list[$k]['status'] = '2';//已结束
            }
        }
        $info = \think\Db::name("users")->field("user_id,realname,head_pic")->whereIn("user_id",$user)->select();
        //茶商
        $tea_merchant = \think\Db::name("store")->field("user_id")->whereIn("user_id",$user)->select();
        //茶艺师
        $tea_art      = \think\Db::name("tea_art")->field("user_id")->whereIn("user_id",$user)->select();
        
        $teaArt = [];
        foreach ($tea_art as $k=>$v){
            $teaArt[] = $v['user_id'];
        }
        
        $teaMerchant = [];
        foreach ($tea_merchant as $k=>$v){
            $teaMerchant[] = $v['user_id'];
        }
        
        $userInfo = [];
        foreach ($info as $k=>$v){
            $userInfo[$v['user_id']] = ['realname'=>$v['realname'],'head_pic'=>$v['head_pic']];
        }
        foreach ($list as $k=>$v){
            $list[$k]['userinfo'] = $userInfo[$v['user_id']];
            if(in_array($v['user_id'], $teaMerchant)){
                $list[$k]['role'] = '茶商';
            }elseif(in_array($v['user_id'], $teaArt)){
                $list[$k]['role'] = '茶艺师';
            }else{
                $list[$k]['role'] = '茶友';
            }
        }
        $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result' =>$list]);
    }
    
    //我报名的活动列表
    public function myjoin_activity()
    {
        //先从报名的列表中获取报名活动id
        $activity_listid = \think\Db::name("activity_join")->where("user_id",$this->user_id)->column("active_id");
        
        $p = $this->request->param("p")?:1;
        $list = \think\Db::name("active")->where(function($query)use($activity_listid){
            $query->whereIn("id",$activity_listid);
        })->page($p,10)->select();
        $user = [];
        foreach ($list as $k=>$v){
            $user[] = $v['user_id'];
            $list[$k]['add_time'] = date("Y-m-d H:i:s",$v['add_time']);
            $list[$k]['active_time'] = date("Y-m-d H:i:s",$v['active_time']);
    
            //报名状态处理
            if(time()>strtotime($v['active_time'])){
                $list[$k]['status'] = '1';//报名中
            }else{
                $list[$k]['status'] = '2';//已结束
            }
        }
        $info = \think\Db::name("users")->field("user_id,realname,head_pic")->whereIn("user_id",$user)->select();
        //茶商
        $tea_merchant = \think\Db::name("store")->field("user_id")->whereIn("user_id",$user)->select();
        //茶艺师
        $tea_art      = \think\Db::name("tea_art")->field("user_id")->whereIn("user_id",$user)->select();
    
        $teaArt = [];
        foreach ($tea_art as $k=>$v){
            $teaArt[] = $v['user_id'];
        }
    
        $teaMerchant = [];
        foreach ($tea_merchant as $k=>$v){
            $teaMerchant[] = $v['user_id'];
        }
    
        $userInfo = [];
        foreach ($info as $k=>$v){
            $userInfo[$v['user_id']] = ['realname'=>$v['realname'],'head_pic'=>$v['head_pic']];
        }
        foreach ($list as $k=>$v){
            $list[$k]['userinfo'] = $userInfo[$v['user_id']];
            if(in_array($v['user_id'], $teaMerchant)){
                $list[$k]['role'] = '茶商';
            }elseif(in_array($v['user_id'], $teaArt)){
                $list[$k]['role'] = '茶艺师';
            }else{
                $list[$k]['role'] = '茶友';
            }
        }
        $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result' =>$list]);
    }
}
