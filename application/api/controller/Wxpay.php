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


use think\Db;

class Wxpay extends Base
{
    private $plugin = [];
    
    public function initPlugin()
    {
        $trade_type = input('trade_type', '');
        $code = '';
        if (!$trade_type || $trade_type == "APP") {//默认是app类型
            $code = 'appWeixinPay';
        } elseif ($trade_type == 'JSAPI') {
            $code = 'miniAppPay';
        }
        $wxPay = M('plugin')->where(array('type'=>'payment','code'=>$code))->find();
        if(!$wxPay){
            $res = array('msg'=>'没有配置微信支付插件','status'=>-1);
            $this->ajaxReturn($res);
        }
        $this->plugin = $wxPay;
        $wxPayVal = unserialize($wxPay['config_value']);
        if(!$wxPayVal['appid'] || !$wxPayVal['key'] || !$wxPayVal['mchid']){
            $res = array('msg'=>'没有配置微信支付插件参数','status'=>-1);
            $this->ajaxReturn($res);
        }
        require_once("plugins/payment/weixin/app_notify/Wxpay/WxPayApi.class.php");
        require_once("plugins/payment/weixin/app_notify/Wxpay/WxPayUnifiedOrder.class.php");
    }


    /**
     * 支付通知
     */
    public function  notify()
    {
        //file_put_contents('notify.log', $GLOBALS['HTTP_RAW_POST_DATA']."\n", FILE_APPEND);
        
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		$xml = $xml ?: file_get_contents('php://input');
        $result = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $return_result = 'FAIL';
   
        if($result['return_code'] == 'SUCCESS'){
            $order_sn = substr($result['out_trade_no'],0,18);
            $wx_total_fee = $result['total_fee'];
            //用户在线充值
            if (stripos($order_sn, 'recharge') === 0) {
                $order_amount = M('recharge')->where(['order_sn' => $order_sn, 'pay_status' => 0])->value('account');
            } else {		
                $order_amount = M('order')->where(['master_order_sn'=>"$order_sn"])->whereOr(['order_sn'=>"$order_sn"])->sum('order_amount');
            }
            
            if ((string)($order_amount * 100) == (string)$wx_total_fee) {
                
                //支付的通知结果返回时对订单再次处理　
                //支付成功后，将订单的支付状态修改为已支付，和支付时间修改，以及第三方的交易流水号
                //并将支付结果通过短信发送给商家
                //
                update_pay_status($order_sn);
                $return_result = 'SUCCESS';
                //file_put_contents("微信支付成功", '');
            }
        }

        $test = array('return_code'=>$return_result,'return_msg'=>'OK');
        header('Content-Type:text/xml; charset=utf-8');
        exit(arrayToXml($test));
    }

    /**
     * 支付通知 拍卖品
     */
    public function  auctionnotify()
    {
  
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $xml = $xml ?: file_get_contents('php://input');
        $result = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $return_result = 'FAIL';
         
        if($result['return_code'] == 'SUCCESS'){
            $order_sn = substr($result['out_trade_no'],0,18);
            $wx_total_fee = $result['total_fee'];
            $order_amount = M('auction_competition')->where(['ordersn'=>"$order_sn"])->sum('promise_price');
            if ((string)($order_amount * 100) == (string)$wx_total_fee) {
    
                //支付的通知结果返回时对订单再次处理　
                //支付成功后，将订单的支付状态修改为已支付，和支付时间修改，以及第三方的交易流水号
                //并将支付结果通过短信发送给商家
                //
                M('auction_competition')->where('ordersn', $order_sn)
                 ->save(['pay_status'=>1,'pay_time'=>time()]);
                
                $return_result = 'SUCCESS';
                
            }
        }
        $test = array('return_code'=>$return_result,'return_msg'=>'OK');
        header('Content-Type:text/xml; charset=utf-8');
        exit(arrayToXml($test));
    }
    
    
    /**
     * 统一下单
     * 该接口为微信APP支付
     * 具体流程是：
     * １、先执行初始化方法　　检测微信APP支付参数是否配置完毕
     * ２、根据订单号获取订单的商品名称，订单的支付价格
     * ３、执行wxPayConfig类　　从plugins读取支付配置参数用于构建统一下单时的参数
     * ４、将要传递的数据集进行签名后调用统一下单API接口，此接口返回数据，并再次签名返回
     * ５、返回的数据是签名的数据，app端调用后发起支付请求
     */
    public function dopay()
    {
        $this->initPlugin();
        
        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/plain');
        require_once(PLUGIN_PATH."payment/weixin/app_notify/Wxpay/WxPayConfig.class.php");
        require_once(PLUGIN_PATH."payment/weixin/app_notify/Wxpay/WxPayNotify.class.php");
        require_once(PLUGIN_PATH."payment/weixin/app_notify/Wxpay/WxPayReport.class.php");
        require_once(PLUGIN_PATH."payment/weixin/app_notify/Wxpay/WxPayResults.class.php");
        require_once(PLUGIN_PATH."payment/weixin/app_notify/Wxpay/WxPayUnifiedOrder.class.php");
        require_once(PLUGIN_PATH."payment/weixin/app_notify/Wxpay/WxPayApi.class.php");
        
        $is_rechange = false;
        $user = session('user');
        $order_sn = input('order_sn', '');
        $trade_type = input('trade_type', ''); //支付终端方式app 小程序
        if (strpos($order_sn, 'recharge') === 0 || $order_sn === '') {
            $is_rechange = true;
            //充值流程
            $total = input('account/f', 0);
            if ($total <= 0) {
                $this->ajaxReturn(['status'=>-1, 'msg'=>'充值金额不能为'.$total]);
            }
            if ($order_sn) {
                $order = M('recharge')->where("order_sn", $order_sn)->find();
                if (!$order) {
                    $this->ajaxReturn(['status'=>-1, 'msg'=>'该充值订单不存在']);
                }
                M('recharge')->where(['order_sn'=>$order_sn,'user_id'=>$user['user_id']])->save(['account' => $total]);
            } else {
                $order_sn = 'recharge'.get_rand_str(10,0,1);
                $order['user_id'] = $user['user_id'];
                $order['nickname'] = $user['nickname'];
                $order['account'] = $total;
                $order['order_sn'] = $order_sn;
                $order['pay_name'] = $this->plugin['name'];
                $order['ctime'] = time();
                M('recharge')->add($order);
            }
        } else {
            //支付流程
            $order = M('order')->where('master_order_sn' , $order_sn)->find();
            if ($order) {
                $total = M('order')->where('master_order_sn' , $order_sn)->sum('order_amount');
            } else {
                $order = M('order')->where(array('order_sn'=>$order_sn))->find();
                if(!$order){
                    $res = array('msg'=>'该订单不存在','status'=>-1);
                    $this->ajaxReturn($res);
                }
                // 获取支付金额
                $total = $order['order_amount'];
            } 
            
            //验证是否支付
            if($order['pay_status']!=0){
                $res = array('msg'=>'此订单不可再次支付','status'=>-1);
                $this->ajaxReturn($res);
            }
        }
        
        // 将元转成分
        $total = floatval($total);
        $total = round($total * 100); 
        if (empty($total)) {
            $total = 100;
        }
        
        // 商品名称
        $shop_info = tpCache('shop_info');
        // 订单号，示例代码使用时间值作为唯一的订单ID号
        $unifiedOrder = new \WxPayUnifiedOrder();
        $WxPayApi = new \WxPayApi();
        
        //在此从支付插件数据表plugin读取支付配置参数　并返回配置参数
        //注释时间：2018-3-03-28
        $notify_url = 'http://118.190.204.122/index.php/api/Wxpay/notify';
        $WxPayConfig = \WxPayConfig::getInstance($trade_type,$notify_url);
        
        $payBody = getPayBody($order['order_id']);
        $unifiedOrder->SetBody($payBody);//商品或支付单简要描述
        $unifiedOrder->SetAppid($WxPayConfig::$APPID);//appid
        $unifiedOrder->SetMch_id($WxPayConfig::$MCHID);//商户标识
        $unifiedOrder->SetNonce_str($WxPayApi::getNonceStr($length = 32));//随机字符串
        $unifiedOrder->SetOut_trade_no($order_sn.time());//交易号 $order_sn 不能来个提示存在
        $unifiedOrder->SetTotal_fee($total);//交易金额
        $unifiedOrder->SetSpbill_create_ip($_SERVER['REMOTE_ADDR']);//发起充值的ip
        $unifiedOrder->SetNotify_url($WxPayConfig::$NOTIFY_URL);//交易成功通知url

        if (!$trade_type || $trade_type == "APP") {//默认是app类型
            $unifiedOrder->SetTrade_type("APP");//应用类型
            $unifiedOrder->SetDetail("订单金额");//详情
            $unifiedOrder->SetProduct_id(time());
        } elseif ($trade_type == 'JSAPI') { //小程序
            $unifiedOrder->SetTrade_type($trade_type);
            $unifiedOrder->SetTime_start(date("YmdHis"));
            $unifiedOrder->SetTime_expire(date("YmdHis", time() + 600));
            $oauth = Db::name('oauth_users')->where(['user_id' => $this->user_id, 'oauth' => 'miniapp'])->find();
            !$oauth && $this->ajaxReturn(['status' => -1, 'msg' => '用户第三方信息不存在']);
            $unifiedOrder->SetOpenid($oauth['openid']);
        } else {
            $this->ajaxReturn(['status'=>-1, 'msg'=>'暂不支持该交易类型：'.$trade_type]);
        }

        //此接口完成了调用统一下单，并将返回的数据再次签名返回
        //并将订单数据表的支付方式名称修改为$this->initPlugin()　　此方法执行后得到的支付方式名称
        //返回的消息　　由app端发起支付
        //注释时间：2018-03-28　星期三
        $result = $WxPayApi::unifiedOrder($unifiedOrder);
        if (is_array($result)) {
            if ($is_rechange) {
                M('recharge')->where("order_sn" , $order_sn)->save(['pay_code'=>$this->plugin['code'],'pay_name'=>$this->plugin['name']]);
            } else {
                M('order')->where(['master_order_sn'=>"$order_sn"])->whereOr(['order_sn'=>"$order_sn"])->save(['pay_name'=>$this->plugin['name']]);
            }
            $res = array('msg'=>'获取成功','status'=>1,'result'=>$result);
        } else {
            $res = array('msg'=>'获取失败','status'=>-1,'result'=>$result);
        }
        $this->ajaxReturn($res);

    }

    /**
     * 统一下单 针对拍卖品
     * 该接口为微信APP支付
     * 具体流程是：
     * １、先执行初始化方法　　检测微信APP支付参数是否配置完毕
     * ２、根据订单号获取订单的商品名称，订单的支付价格
     * ３、执行wxPayConfig类　　从plugins读取支付配置参数用于构建统一下单时的参数
     * ４、将要传递的数据集进行签名后调用统一下单API接口，此接口返回数据，并再次签名返回
     * ５、返回的数据是签名的数据，app端调用后发起支付请求
     */
    public function auctiondopay($data)
    {
        $this->initPlugin();
    
        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/plain');
        require_once(PLUGIN_PATH."payment/weixin/app_notify/Wxpay/WxPayConfig.class.php");
        require_once(PLUGIN_PATH."payment/weixin/app_notify/Wxpay/WxPayNotify.class.php");
        require_once(PLUGIN_PATH."payment/weixin/app_notify/Wxpay/WxPayReport.class.php");
        require_once(PLUGIN_PATH."payment/weixin/app_notify/Wxpay/WxPayResults.class.php");
        require_once(PLUGIN_PATH."payment/weixin/app_notify/Wxpay/WxPayUnifiedOrder.class.php");
        require_once(PLUGIN_PATH."payment/weixin/app_notify/Wxpay/WxPayApi.class.php");
        // 将元转成分
        $total = floatval($data['total']);
        $total = round($total * 100);
        if (empty($total)) {
            $total = 100;
        }
    
        // 商品名称
        $shop_info = $data['shop_info'];
        // 订单号，示例代码使用时间值作为唯一的订单ID号
        $unifiedOrder = new \WxPayUnifiedOrder();
        $WxPayApi = new \WxPayApi();
    
        //在此从支付插件数据表plugin读取支付配置参数　并返回配置参数
        //注释时间：2018-3-03-28
        $notify_url = 'http://118.190.204.122/index.php/api/Wxpay/auctionnotify';
        $WxPayConfig = \WxPayConfig::getInstance($trade_type,$notify_url);
    
        $payBody = $data['goodsname'];
        $unifiedOrder->SetBody($payBody);//商品或支付单简要描述
        $unifiedOrder->SetAppid($WxPayConfig::$APPID);//appid
        $unifiedOrder->SetMch_id($WxPayConfig::$MCHID);//商户标识
        $unifiedOrder->SetNonce_str($WxPayApi::getNonceStr($length = 32));//随机字符串
        $unifiedOrder->SetOut_trade_no($data['ordersn'].time());//交易号 $order_sn 不能来个提示存在
        $unifiedOrder->SetTotal_fee($total);//交易金额
        $unifiedOrder->SetSpbill_create_ip($_SERVER['REMOTE_ADDR']);//发起充值的ip
        $unifiedOrder->SetNotify_url($WxPayConfig::$NOTIFY_URL);//交易成功通知url
    
        if (!$trade_type || $trade_type == "APP") {//默认是app类型
            $unifiedOrder->SetTrade_type("APP");//应用类型
            $unifiedOrder->SetDetail("订单金额");//详情
            $unifiedOrder->SetProduct_id(time());
        } 
    
        //此接口完成了调用统一下单，并将返回的数据再次签名返回
        //并将订单数据表的支付方式名称修改为$this->initPlugin()　　此方法执行后得到的支付方式名称
        //返回的消息　　由app端发起支付
        //注释时间：2018-03-28　星期三
        $result = $WxPayApi::unifiedOrder($unifiedOrder);
        if (is_array($result)) {
           
            $res = $result;
        } else {
            $res = '微信支付签名失败';
        }
        //$this->ajaxReturn($res);
        return $res;
    
    }
    
    //获取支付状态
    public function getwxpaystatus()
    {
        $order_sn = I("order_sn");
        $order = \think\Db::name("order")->where(function($query){
            $query->where("master_order_sn",$order_sn)->whereOr("order_sn",$order_sn);
        })->find();
        empty($order) && $this->ajaxReturn(['msg'=>'不存在此订单','status'=>-1]);
        $this->ajaxReturn(['msg'=>'获取成功','status'=>$order]);  }

}

?>