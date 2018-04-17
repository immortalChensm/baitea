<?php
	namespace app\h5\controller;
	
	use think\Controller;
 class Base extends Controller
 {
     public function _initialize()
     {
         
         //$result = httpRequest($url,'post',$data);
         //return json($result); 
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
         return $result;
     }
 }
?>