<?php
	namespace app\common\logic;
	
	use think\Model;
 class Teacomment extends Model
 {
     
     //每个茶艺师的评论等级统计
     public function getcomment($teartId)
     {
         //1先获取所有的茶艺师
         //2获取每个茶艺师的订单
         //3获取每个订单的评价
         $order = \think\Db::name("teart_order")->field("order_id,teart_id")->whereIn("teart_id",$teartId)->select();
         
         $orderId = [];
         foreach ($order as $k=>$v){
             //得到指定茶艺师所有的订单
             $orderId[] = $v['order_id'];
         }
         
         $star = \think\Db::name("tea_comment")->whereIn("order_id",$orderId)->select();
         $orderStar = [];
         foreach ($star as $k=>$v){
             //得到每个订单的评星
             $orderStar[$v['order_id']] = $v['star'];
         }
        
         $allstar = [];
         foreach ($order as $k=>$v){
             //这个茶艺师目前所有订单的评论星级指数
             if($orderStar[$v['order_id']]){
                 $allstar[$v['teart_id']][] = $orderStar[$v['order_id']];
             }
             
         }
         $end = [];
         foreach ($allstar as $k=>$v){
             $end[$k] = round((array_sum($v))/count($v),0);
         }
         
         return $end;
         
     }
     
     //计算每个茶艺师和当前用户的距离
     /**
      * @param array $teartId 茶艺师id
      * @param string $x 用户经度
      * @param string $y 用户纬度
      * @return json　返回每个茶艺师的距离　单位是米
      * **/
     public function gettea_distance($teartId,$x,$y)
     {
         $location = \think\Db::name("tea_art")->whereIn("teart_id",$teartId)->select();
         $distance = [];
         foreach ($location as $k=>$v){
             $temp = caldistance($x, $y, $v['longitude'], $v['latitude']);
             $distance[$v['teart_id']] = $temp['results'][0]['distance'];
         }
         return $distance;
     }
 }
?>