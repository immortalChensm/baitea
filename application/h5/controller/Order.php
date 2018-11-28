<?php
	namespace app\h5\controller;
	
	class Order extends Base
	{
	    //订单详情　　店铺
	    public function details()
	    {
	        $order['id'] = I("order_id");
	        $order['sn'] = I("order_sn");
	        $orders = $this->get_api_data(C("ORDER_DETAILS"),'post',$order);
	        //print_r($orders['result']);
	        $this->assign("order",$orders['result']);
	        return $this->fetch("no-pay");
	        
	    }
	    
	    //取消订单
	    public function cancel()
	    {
	        if($this->request->isPost()){
	            $order['id'] = I("orderid");
	            $result = $this->get_api_data(C("CANCEL_ORDER"),'post',$order);
	            ajaxReturn($result['result']);
	        }
	        
	    }
	    
	    //查看物流
	    public function delivery()
	    {
	        $order_express = $this->get_api_data(C("EXPRESS_VIEW"),'post',[
	            'order_id'=>$this->request->param("order_id"),
	            'is_json'=>1
	        ]);
	        $this->assign("order",$order_express['result']);
	        return $this->fetch("logistics");
	    }
	    
	    //加载物流信息
	    public function express()
	    {
	        if($this->request->isPost()){
	            if($this->request->param("code")&&$this->request->param("invoice")){
	                
	                //先验证物流订单
	                $invoice = $this->request->param("invoice");
	                $url = "http://www.kuaidi100.com/autonumber/autoComNum?resultv2=1&text=$invoice";
	                $ret = file_get_contents($url);
	                $ret = json_decode($ret,true);
	                if(count($ret['auto'])==0){
	                    ajaxReturn(['status'=>0,'msg'=>'此订单没有物流信息']);
	                }
	                $order_express = $this->get_api_data(C("QUERY_EXPRESS"),'post',[
	                    'shipping_code'=>$this->request->param("code"),
	                    'invoice_no'=>$this->request->param("invoice")
	                ]);
	                $tea_express =[];
	                foreach ($order_express['data'] as $k=>$v){
	                    $tea_express[$k]['month'] = date("m-d",strtotime($v['time']));
	                    $tea_express[$k]['hour'] = date("H:i",strtotime($v['time']));
	                    $tea_express[$k]['context'] = $v['context'];
	                }
	               ajaxReturn(['status'=>1,'msg'=>'获取成功'.$ret,'data'=>$tea_express]);
	               
	            }else{
	                ajaxReturn(['status'=>0,'msg'=>'此订单没有物流信息']);
	            }
	           
	        }
	    }
	    
	    //确认收货
	    public function order_confirm()
	    {
	        if($this->request->isPost()){
	                $order = $this->get_api_data(C("ORDER_CONFIRM"),'post',[
	                    'id'=>$this->request->param("order_id"),
	                    'isajax'=>1
	                ]);
	                ajaxReturn($order);
	        }
	    }
	    
	    //申请退款
	    public function refund()
	    {
	        $rec_id = $this->request->param("rec_id");
	        $info = $this->get_api_data(C("RETURN_GOODS"),"post",['rec_id'=>$rec_id]);
	        //print_r($info);
	        $this->assign("info",$info['result']);
	        return $this->fetch();
	    }
	    
	    public function uploadimg(){
	        $files = array_values($_FILES);
	        $result = $this->get_api_data(C('UPLOAD_IMAGE'),"post",array(
	            'img'=>base64_encode(file_get_contents($files[0]['tmp_name'][0])),
	            'name'=>$files[0]['name'],
	            'type'=>$files[0]['type'],
	            'size'=>$files[0]['size'],
	            'type'=>'shopimgs'
	        ));
	        if($result['status'] == '1'){
	            exit(json_encode($result));
	        }else {
	            exit(json_encode(array('status'=>'0','info'=>$result['msg'])));
	        }
	    }
	    
	    public function getrandid()
	    {
			if($this->request->isPost()){

			    $randid = mt_rand(1, 99999).time();
			    $pic = '/public/static/h5/images/add_image.png';
			    $html = <<<html
<label style="background-image: url({$pic})">            			       
<input type="file" id="img{$randid}" name="zheng[]" accept="image/*"  onchange="upload_img(this.id,'imgslist')">
<div class="a-close"></div></label>
html;
			     
			    echo $html;
	        }
			                    
			                    
	    }
	    
	    public function refund_detials()
	    {
	        $order['is_json'] = I("is_json","1");
	        $order['id'] = I("id");
	        $orders = $this->get_api_data(C("REFUND_DETAILS"),'post',$order);
	        //print_r($orders['result']);
	        $this->assign("info",$orders['result']);
	        return $this->fetch("refund_details");
	         
	    }
	}
?>