<?php
	namespace app\common\model;
	
	use think\Model;
 class Active extends Model
 {
     protected $table = "tp_active";
     protected $id = "id";
     public function addActivity($data)
     {
         if($this->validate('Active')){
             print_r($data);
         }else{
             return $this->getError();
         }
     }
 }
?>