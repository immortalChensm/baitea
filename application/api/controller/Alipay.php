<?php
/**

 */ 
namespace app\api\controller;

class Alipay extends Base 
{
    /**
     * app端发起支付宝,支付宝返回服务器端,  返回到这里
     * http://www.tp-shop.cn/index.php/Api/Payment/alipayNotify
     */
    public function alipayNotify()
    {
        //file_put_contents("alipay_result.txt",json_encode($_POST));
        require_once('vendor/Alipay/aop/AopClient.php');
        $aop = new \AopClient;
        $public_path = "./vendor/Alipay/key/alipay_public_key_sha.pem";//公钥路径
        $aop->alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAsymouNF99FfWOHTv+STYvTX/gKaWvUCk+fi5UWXnm1R9USsZDlJ2ei7ZOo4wjTTZDsziDhyAMsQCAzALbTEMq4gTqil0qp05AdUeJ/MtgSE5pmekf0u3VkIZp9zRzLJoJWIXXwtfuPvGgORTyuIiJ1+nF36SdLPcYweLsz+sMSKs8D7SUQdnk1UaHEec1KqHCCdidFw2RoyB1GihVWpbDL411b2CYS7iwbqKRvY7YVHlfPMMfSZXhxLSXulaQ5mgAiQ9JTa0Czub2tBtkLns5rCI+wDJkSNTtAkTpGW8oepGvqDblVHQeCWa/RoyKCoIbpbgOxfiaAuyN3uUQPxfYQIDAQAB';
        
        //此处验签方式必须与下单时的签名方式一致
        //$public_key = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAsymouNF99FfWOHTv+STYvTX/gKaWvUCk+fi5UWXnm1R9USsZDlJ2ei7ZOo4wjTTZDsziDhyAMsQCAzALbTEMq4gTqil0qp05AdUeJ/MtgSE5pmekf0u3VkIZp9zRzLJoJWIXXwtfuPvGgORTyuIiJ1+nF36SdLPcYweLsz+sMSKs8D7SUQdnk1UaHEec1KqHCCdidFw2RoyB1GihVWpbDL411b2CYS7iwbqKRvY7YVHlfPMMfSZXhxLSXulaQ5mgAiQ9JTa0Czub2tBtkLns5rCI+wDJkSNTtAkTpGW8oepGvqDblVHQeCWa/RoyKCoIbpbgOxfiaAuyN3uUQPxfYQIDAQAB';
        $flag = $aop->rsaCheckV1($_POST, $public_path, "RSA2");
       
        //验签通过后再实现业务逻辑，比如修改订单表中的支付状态。
        /**
         *  ①验签通过后核实如下参数out_trade_no、total_amount、seller_id
         *  ②修改订单表
        **/
        //打印success，应答支付宝。必须保证本界面无错误。只打印了success，否则支付宝将重复请求回调地址。
        
        //验证成功
        if ($flag) {                           
            $order_sn = $out_trade_no = trim($_POST['out_trade_no']); //商户订单号
            $trade_no = $_POST['trade_no'];//支付宝交易号
            $trade_status = $_POST['trade_status'];//交易状态
            
			
		//用户在线充值
		if (stripos($order_sn, 'recharge') !== false)
			$order_amount = M('recharge')->where(['order_sn' => $order_sn, 'pay_status' => 0])->value('account');
		else			
            $order_amount = M('order')->where(['master_order_sn'=>$order_sn])->whereOr(['order_sn'=>$order_sn])->sum('order_amount');
            if($order_amount!=$_POST['total_amount'])
                exit("fail"); //验证失败

            if ($_POST['trade_status'] == 'TRADE_FINISHED') {
                update_pay_status($order_sn); // 修改订单支付状态                
            } elseif ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                update_pay_status($order_sn); // 修改订单支付状态                
            }               
            M('order')->where('order_sn', $order_sn)->whereOr('master_order_sn',$order_sn)->save(array('pay_code'=>'alipay','pay_name'=>'app支付宝'));
            echo "success"; //  告诉支付宝支付成功 请不要修改或删除   
               
        } else {
            echo "fail"; //验证失败         
            
        }
        
    }
 
    //新版支付宝签名
    public function alipay_sign()
    {
            $orderSn = input('post.order_sn', '');
            $user = session('user');
            
            //支付流程
            $order = M('order')->alias('o')->field('o.order_amount')
                        ->where('o.order_sn|o.master_order_sn', $orderSn)->select();
            if (!$order) {
                $this->ajaxReturn(['status' => -1, 'msg' => '订单不存在']);
            }
            // 所有商品单价相加
            $orderAmount = array_reduce($order, function ($sum, $val) {
                return $sum + $val['order_amount'];
            }, 0);
        
        
        require_once 'vendor/Alipay/aop/AopClient.php';
        $private_path =  "./vendor/Alipay/key/rsa_private_key.pem";//私钥路径
        //构造业务请求参数的集合(订单信息)
        $content = array();
        $content['subject'] = I("subject","趣喝茶商城订单");
        $content['out_trade_no'] = $orderSn;
        $content['timeout_express'] = "600";
        $content['total_amount'] = $orderAmount;
        $content['product_code'] = "QUICK_MSECURITY_PAY";
        $con = json_encode($content);//$content是biz_content的值,将之转化成json字符串
        
        //公共参数
        $Client = new \AopClient();//实例化支付宝sdk里面的AopClient类,下单时需要的操作,都在这个类里面
        $param['app_id'] = '2018032702455466';
        $param['method'] = 'alipay.trade.app.pay';//接口名称，固定值
        $param['charset'] = 'utf-8';//请求使用的编码格式
        $param['sign_type'] = 'RSA2';//商户生成签名字符串所使用的签名算法类型
        $param['timestamp'] = date("Y-m-d H:i:s");//发送请求的时间
        $param['version'] = '1.0';//调用的接口版本，固定为：1.0
        $param['notify_url'] = 'http://118.190.204.122/index.php/api/Alipay/alipayNotify';
        $param['biz_content'] = $con;//业务请求参数的集合,长度不限,json格式，即前面一步得到的
        
        $paramStr = $Client->getSignContent($param);//组装请求签名参数
        $sign = $Client->alonersaSign($paramStr, $private_path, 'RSA2', true);//生成签名
        $param['sign'] = $sign;
        $str = $Client->getSignContentUrlencode($param);//最终请求参数
        
        $this->ajaxReturn(['status' => 1, 'msg' => '支付参数签名成功', 'result' => $str]);
    }
    
    //refund pay()
    public function refundpay()
    {
       
        
        require_once './vendor/Alipay/aop/AopClient.php';
        require_once './vendor/Alipay/aop/request/AlipayTradeRefundRequest.php';
        $private_path =  "./vendor/Alipay/key/rsa_private_key.pem";//私钥路径
        
        $aop = new \AopClient();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = '2018032702455466';
        $aop->rsaPrivateKey = "MIIEpQIBAAKCAQEA0cEmXaMkSEJktsmjLQzq8K63vy5AR1gGjB5Z39TESAbJzUX/6TXWiRDpkuoBaMp5/oVz5jeDNeHkJpIFQUXts6CV8MKlFZS5ZR5oOU7zrhr8Jz8MVbBaUXIVqVxPL9lbG5yF+BBoQYl44iBebyf7Hxz+sZ3fhRM9sxoZ/VW3qyld9xtRp6zMa8mAfYxnK/JuGfvxAuB6Eceoo/8x9s9XVU17RpzXVG/l3biDIrOHx0Qs4Ij1s5puuaJxMs0M8QL8PUou0I23Oj2ISwnfoUj3CDGhhUYa19cjlvgrPHBpJE+SPfN5yn4C4H0iJwFf1XwZrn8ko3JL3rBxc2dHPgAorwIDAQABAoIBAEG1EgGvQ4RnWAlyrO1F6Ksw8FqxcG1pA9QNBfZ6PmqZxcnKLdquhOA3LhRZvctH8mNrBt2NcksE0mXKxF6oO0hT++SJ9REHn/QvTFL3ipp11Zutwn1tWz28UVDWm+/PVR0XMVh+O0qceAPORAbqLV6XxKl7XTPgzSk3+gBEQ98X6yd408BpDay+9cDOgxksSVUwcmIi1cOPNcsXs/mdl8s6tznS44CltULP81O4W6TilKsMvll8MGEfOnR4WrD68PqmZes5AHs0Bqg81pGcTgn29SYE4GBDNQEdwweryTDOMF5VPHk9h8vBsutaHMKaETTMecF9OCTHXCT3lBXEM5ECgYEA6uWis2gbqDL9Qr1N6zxAtuAf3XpGPQmD54VZwYf6MV1tEdeS2ouUVzLHfP/xZKNeQTpVmf5svlgmaQTktt7aYoIgQ8TeuR1ebjsWsXLYfVVwI01dMfMCv2UM92bdkLvuqIaH37EPVZv3WkK0QUJwMPeQEEp3Tve1/BjtI3dkBOMCgYEA5JlDzoo5gR9gf35NP8/hKyZJBAOjCwykTT+yZOtoq6gXDDrD5FmdNe2J7IcEe7Vde/OYEeKV/G3CalfrfS8K7GjMMJsFqOStZl9piAgMEyuSywsrMWcRIJS+L4B/Agx18mnqG6bv0tW5cjzfQuB43tPxKt43y0YAqCAZHQzo4sUCgYEAssEYBLFYQrKy2qQW9MnAcaqzdScE5pQkJf7r5AQnmIOBag+EOP35YDZLa0uWlsBgDQFofS0J8fxBFrBboPKMfGSMSyY5W+QGpZof1eAQ8aggEy1fm5BT6fTrXiaQvADYSLVAFzG1+q8bGDwk0njNyeXLYypYCuclPXh2lgPYQIMCgYEA5FcvwwSREih8ZH2NvjrwqQBSGN9lIilbiQoiMOpwoF6DvySH/fWBspd2mLv5P3TXT3PwJ5VUylP8yerOgDnYSHMZ20dOLPlXN5YAvO+E2DVDKOwcFfnkws2w95P7ydkWi7E+NqbWkZwI5FJnlM7SDYpZML/NrY9cIpQFYd4+Vh0CgYEAivsTtKzo0K4B/kT+HJjEXHOZo1mwM9scwG4c1rAbbWBP3ugp1FZGOJ5IWUGSbbC678feaexeAIglvkDti0QhW3atBx5cNSnZ4lwYueFGQlqhPZEzJNP0z/rUxQKM6KWfKRF2HQNi4bUzLELRHicAULG87q3dBT+j+3SdcDOuk5Q=";
        
        
        
        $aop->alipayrsaPublicKey='MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAsymouNF99FfWOHTv+STYvTX/gKaWvUCk+fi5UWXnm1R9USsZDlJ2ei7ZOo4wjTTZDsziDhyAMsQCAzALbTEMq4gTqil0qp05AdUeJ/MtgSE5pmekf0u3VkIZp9zRzLJoJWIXXwtfuPvGgORTyuIiJ1+nF36SdLPcYweLsz+sMSKs8D7SUQdnk1UaHEec1KqHCCdidFw2RoyB1GihVWpbDL411b2CYS7iwbqKRvY7YVHlfPMMfSZXhxLSXulaQ5mgAiQ9JTa0Czub2tBtkLns5rCI+wDJkSNTtAkTpGW8oepGvqDblVHQeCWa/RoyKCoIbpbgOxfiaAuyN3uUQPxfYQIDAQAB';
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset='UTF-8';
        $aop->format='json';
        
        $param = [
            "out_trade_no"=>"201805181302447290",
            "refund_amount"=>0.1,
            "refund_reason"=>"正常退款"
        ];
        $request = new \AlipayTradeRefundRequest();
        $request->setBizContent(json_encode($param));
        $result = $aop->execute ( $request);
        
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        var_dump($result);
        if(!empty($resultCode)&&$resultCode == 10000){
            echo "成功";
        } else {
            echo "失败";
        }
    }
    
    //toaccount
    public function toaccount()
    {

        require_once './vendor/Alipay/aop/AopClient.php';
        require_once './vendor/Alipay/aop/request/AlipayFundTransToaccountTransferRequest.php';
        $private_path =  "./vendor/Alipay/key/rsa_private_key.pem";//私钥路径
        
        $aop = new \AopClient ();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = '2018032702455466';
        $aop->rsaPrivateKey = "MIIEpQIBAAKCAQEA0cEmXaMkSEJktsmjLQzq8K63vy5AR1gGjB5Z39TESAbJzUX/6TXWiRDpkuoBaMp5/oVz5jeDNeHkJpIFQUXts6CV8MKlFZS5ZR5oOU7zrhr8Jz8MVbBaUXIVqVxPL9lbG5yF+BBoQYl44iBebyf7Hxz+sZ3fhRM9sxoZ/VW3qyld9xtRp6zMa8mAfYxnK/JuGfvxAuB6Eceoo/8x9s9XVU17RpzXVG/l3biDIrOHx0Qs4Ij1s5puuaJxMs0M8QL8PUou0I23Oj2ISwnfoUj3CDGhhUYa19cjlvgrPHBpJE+SPfN5yn4C4H0iJwFf1XwZrn8ko3JL3rBxc2dHPgAorwIDAQABAoIBAEG1EgGvQ4RnWAlyrO1F6Ksw8FqxcG1pA9QNBfZ6PmqZxcnKLdquhOA3LhRZvctH8mNrBt2NcksE0mXKxF6oO0hT++SJ9REHn/QvTFL3ipp11Zutwn1tWz28UVDWm+/PVR0XMVh+O0qceAPORAbqLV6XxKl7XTPgzSk3+gBEQ98X6yd408BpDay+9cDOgxksSVUwcmIi1cOPNcsXs/mdl8s6tznS44CltULP81O4W6TilKsMvll8MGEfOnR4WrD68PqmZes5AHs0Bqg81pGcTgn29SYE4GBDNQEdwweryTDOMF5VPHk9h8vBsutaHMKaETTMecF9OCTHXCT3lBXEM5ECgYEA6uWis2gbqDL9Qr1N6zxAtuAf3XpGPQmD54VZwYf6MV1tEdeS2ouUVzLHfP/xZKNeQTpVmf5svlgmaQTktt7aYoIgQ8TeuR1ebjsWsXLYfVVwI01dMfMCv2UM92bdkLvuqIaH37EPVZv3WkK0QUJwMPeQEEp3Tve1/BjtI3dkBOMCgYEA5JlDzoo5gR9gf35NP8/hKyZJBAOjCwykTT+yZOtoq6gXDDrD5FmdNe2J7IcEe7Vde/OYEeKV/G3CalfrfS8K7GjMMJsFqOStZl9piAgMEyuSywsrMWcRIJS+L4B/Agx18mnqG6bv0tW5cjzfQuB43tPxKt43y0YAqCAZHQzo4sUCgYEAssEYBLFYQrKy2qQW9MnAcaqzdScE5pQkJf7r5AQnmIOBag+EOP35YDZLa0uWlsBgDQFofS0J8fxBFrBboPKMfGSMSyY5W+QGpZof1eAQ8aggEy1fm5BT6fTrXiaQvADYSLVAFzG1+q8bGDwk0njNyeXLYypYCuclPXh2lgPYQIMCgYEA5FcvwwSREih8ZH2NvjrwqQBSGN9lIilbiQoiMOpwoF6DvySH/fWBspd2mLv5P3TXT3PwJ5VUylP8yerOgDnYSHMZ20dOLPlXN5YAvO+E2DVDKOwcFfnkws2w95P7ydkWi7E+NqbWkZwI5FJnlM7SDYpZML/NrY9cIpQFYd4+Vh0CgYEAivsTtKzo0K4B/kT+HJjEXHOZo1mwM9scwG4c1rAbbWBP3ugp1FZGOJ5IWUGSbbC678feaexeAIglvkDti0QhW3atBx5cNSnZ4lwYueFGQlqhPZEzJNP0z/rUxQKM6KWfKRF2HQNi4bUzLELRHicAULG87q3dBT+j+3SdcDOuk5Q=";
        
        $aop->alipayrsaPublicKey='MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAsymouNF99FfWOHTv+STYvTX/gKaWvUCk+fi5UWXnm1R9USsZDlJ2ei7ZOo4wjTTZDsziDhyAMsQCAzALbTEMq4gTqil0qp05AdUeJ/MtgSE5pmekf0u3VkIZp9zRzLJoJWIXXwtfuPvGgORTyuIiJ1+nF36SdLPcYweLsz+sMSKs8D7SUQdnk1UaHEec1KqHCCdidFw2RoyB1GihVWpbDL411b2CYS7iwbqKRvY7YVHlfPMMfSZXhxLSXulaQ5mgAiQ9JTa0Czub2tBtkLns5rCI+wDJkSNTtAkTpGW8oepGvqDblVHQeCWa/RoyKCoIbpbgOxfiaAuyN3uUQPxfYQIDAQAB';
        $aop->apiVersion = '1.0';
        
        $aop->signType = 'RSA2';
        $aop->postCharset='UTF-8';
        $aop->format='json';
        $request = new \AlipayFundTransToaccountTransferRequest();
        //https://docs.open.alipay.com/api_28/alipay.fund.trans.toaccount.transfer  
        $out_biz_no = date("YmdHis").md5(mt_rand(0,9999));
        $param = [
            "out_biz_no"=>$out_biz_no,//订单号
            "payee_type"=>'ALIPAY_LOGONID',
            "payee_account"=>'xichen92',
            "amount"=>0.1,
        ];
        
        $request->setBizContent(json_encode($param));
        
        /*
        $request->setBizContent("{" .
            "\"out_biz_no\":\"3142321423432\"," .
            "\"payee_type\":\"ALIPAY_LOGONID\"," .
            "\"payee_account\":\"abc@sina.com\"," .
            "\"amount\":\"12.23\"," .
            "\"payer_show_name\":\"上海交通卡退款\"," .收款方姓名
            "\"payee_real_name\":\"张三\"," .收款人姓名
            "\"remark\":\"转账备注\"" .
            "}");
         */
        
        
        $result = $aop->execute ( $request);
        
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        print_r($result);
        if(!empty($resultCode)&&$resultCode == 10000){
            echo "转账成功";
        } else {
            echo "失败";
        }
    }
}
