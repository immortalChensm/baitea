<?php
	namespace app\h5\controller;
	
	use think\Controller;
 class Base extends Controller
 {
     /*
      * 初始化操作
      */
     protected $user;
     
     public function _initialize()
     {
             if ($_GET['token']) {
                 $user_info = $this->get_api_data(C('CHECK_TOKEN'),'post',array('token'=>$_GET['token']));
                 //$user_info = json_decode($user_info,true);
                 if($user_info['status'] == '1'){
                     $this->user = $user_info['result'];
                     session('user',$this->user);
                     //$this->assign('user',$this->user);
                 }
             }elseif (session('user')){
                 
                 $this->user = M('Users')->where(array('token'=>session('user.token')))->find();
                 //session('user',null);
                 //$this->assign('user',$this->user);
             }
     }
     
     private function prepare_post_data($param)
     {
         $time = time();
         $data = [
             'time'=>$time,
         ];
         $data = array_merge($data,$param);
         ksort($data);
         foreach ($data as $k=>$v){
             if($k!='time'){
                 $str.=$v;
             }
         }
   
         $data['sign'] = md5($str.$time.config("API_SIGN"));
         $data['token'] = $this->user['token']?:$_GET['token'];
         
         return $data;
     }
     
     /**
      * 
      * 
      * get_api_data 接口调用
      * @param unknown $url 请求的url
      * @param string $method 请求方式
      * @param unknown $data 请求的数据
      * ***/
     public function get_api_data($url,$method='get',$data=array())
     {
         $result = httpRequest($url,$method,$this->prepare_post_data($data));
  
         $ret = json_decode($result,true);
         if($ret['status'] == '200'){
             //$this->error($info['msg']);
         }elseif($ret['status'] == '-100'||$ret['status'] == '-101'||$ret['status'] == '-102'){
             session('prevurl',$_SERVER['HTTP_REFERRER']);
             if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
                 $this->error('nologin');
             //    $this->error("nologin");
             }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
                 echo '<script>window.zhangxin.goLogin();</script>'; exit;
             }
             /*$login = <<<LOGIN
      <script type="text/javascript">
        
        function setupWebViewJavascriptBridge(callback) {  
            if (window.WebViewJavascriptBridge) {  
                callback(WebViewJavascriptBridge)  
            } else {  
                document.addEventListener('WebViewJavascriptBridgeReady' , function() {  
                    callback(WebViewJavascriptBridge)  
                }, false );  
            }  

            // =====以下是iOS必须的特殊处理========  
            if (window.WVJBCallbacks) { return window.WVJBCallbacks.push(callback); }  
            window.WVJBCallbacks = [callback];  
            var WVJBIframe = document.createElement('iframe');  
            WVJBIframe.style.display = 'none';  
            WVJBIframe.src = 'wvjbscheme://__BRIDGE_LOADED__';  
            document.documentElement.appendChild(WVJBIframe);  
            setTimeout(function() { document.documentElement.removeChild(WVJBIframe) }, 0);  
            // =====以上是iOS必须的特殊处理========  
        }

          // 固定写法2 函数名字与1保持一致  
            setupWebViewJavascriptBridge(function(bridge) {  
                // Java 注册回调函数，第一次连接时调用 初始化函数  
                 bridge.init();  
            });
  
WebViewJavascriptBridge.callHandler("goLogin","login",function(data){});
       
       
</script>       
LOGIN;*/
                 
             //}
         }
         return json_decode($result,true);
     }
 }
?>