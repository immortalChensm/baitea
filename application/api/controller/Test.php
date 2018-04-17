<?php
	namespace app\api\controller;
	
	use think\Controller;
 class Test extends Controller
 {
     //模拟支付完成测试方法
     public function pay()
     {
         $order_sn = "201803291042346877";
         
         update_pay_status($order_sn); // 修改订单支付状态
     }
     
     
     public function request_data()
     {
         
         /*$redis = new \Redis();
         
         $num = $redis->get("num");
         if($num>=10){
             exit("请排队不要挤!");
             
         }else{
             $redis->incr("num");
         }
         
         echo "正在处理数据<br />";
         echo "--------------<br />";
         print_r($_GET);
         $redis->desc("num");
         */
         
         
         $num = \think\Cache::get("a");
         
         if($num>=10){
             exit("人太多了请排队");
         }else{
             \think\Cache::inc("a");
         }
         
         echo "正在处理请求\r\n";
         print_r($_GET);
         
         \think\Cache::dec("a");
         

         $url = "www.liketea.com/index.php/api/User/login";
         $data = [
             'username'=>'18896871476',
             'password'=>'123456'
         ];
         
     }
     public function testc()
     {
         
          
         $request_count = 10;
         $count = \think\Cache::get("request_count",0);
         if($count>=10){
             exit('您的请求次数太高了休息一伙儿吧'.$count);
         }
          
         //统计请求次数　　防止请求过高
         \think\Cache::set("request_count", 1,30);
         \think\Cache::inc("request_count");
         
         echo \think\Cache::get("request_count");
     }
     
 }
?>