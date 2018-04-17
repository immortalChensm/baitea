<?php
	namespace app\common\logic;
 class TeaOrderLogic
 {
    public function addOrder($data)
    {
        $teartOrder = new \app\common\model\TeartOrder();
        $teartOrder->save($data);
        return $teartOrder->order_id;
    }
 }
	
?> 