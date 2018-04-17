<?php
	namespace app\common\validate;
	
	use think\Validate;
 class Active extends Validate
 {
     protected $rule = [
         'title'=>'require|min:2',
         'desc'=>'require',
         'active_time'=>'require|date',
         'active_location'=>'require',
         'location_x'=>'require|number',
         'location_y'=>'require|number',
         'address'=>'require',
         'num'=>'require|number',
         'sex'=>'require',
         'consume'=>'require',
         'user_id'=>'require'
     ];
     
     protected $message = [
         'title.require'=>'活动标题写一个吧',
         'title.min'=>'标题最少两个字符',
         'desc.require'=>'活动简介写一下吧',
         'active_time.require'=>'活动时间选一个',
         'active.date'=>'活动时间格式不对',
         'active_location.require'=>'在哪活动填一下',
         'location_x.require'=>'活动经度填一下',
         'location_y.require'=>'活动纬度填一下',
         'address.require'=>'具体位置填一下',
         'num.require'=>'活动人数呢',
         'num.number'=>'活动人数数据不合法',
         'sex.require'=>'活动对象选一个',
         'consume.require'=>'活动消费类型',
         'user_id.require'=>'请您先登录'
     ];
 }
?>