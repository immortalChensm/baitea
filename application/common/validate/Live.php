<?php
	namespace app\common\validate;
	
	use think\Validate;
 class Live extends Validate
 {
     protected $rule = [
         'title'=>'require|min:2',
         'live_cover'=>'require',
     ];
     
     protected $message = [
         'title.require'=>'直播标题写一个吧',
         'title.min'=>'直播标题最少两个字符',
         'live_cover'=>'请上传直播封面'
     ];
 }
?>