<?php
	namespace app\h5\controller;
	
	class Teaorder extends Base
	{
	    //订单详情
	    public function details()
	    {
	        $order['order_id'] = I("order_id");
	        $orders = $this->get_api_data(C("TEAORDER_DETAILS"),'post',$order);
	        $orders['result']['serviceDate'] = explode("~", $orders['result']['service_date']);
	        //print_r($orders);
	        $this->assign("order",$orders['result']);
	        return $this->fetch("deiles");
	        
	    }
	    
	    //取消订单
	    public function cancel()
	    {
	        if($this->request->isPost()){
	            $ret = $this->get_api_data(C("CANCEL_TEAORDER"),"post",$this->request->param());
	            ajaxReturn($ret);
	        }else{
	            $order['order_id'] = I("order_id");
	            $orders = $this->get_api_data(C("TEAORDER_DETAILS"),'post',$order);
	            $orders['result']['serviceDate'] = explode("~", $orders['result']['service_date']);
	            //print_r($orders);
	            $this->assign("order",$orders['result']);
	            return $this->fetch("deiles-quxiao");
	        }
	    }
	    
	}
?>