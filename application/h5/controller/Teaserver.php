<?php
	namespace app\h5\controller;

 class Teaserver extends Base
	{
	    //我发布的服务
	    public function myteaservice()
	    {
	        
	        $service = $this->get_api_data(C("TEART_SERVICE"),'post',['p'=>$this->request->param("page")?:1]);
	        $this->assign("info",$service['result']);
	        return $this->fetch("tea-mage");
	        
	    }
	    
	    //我发布的服务
	    public function myteaservicelist()
	    {
	         
	        $service = $this->get_api_data(C("TEART_SERVICE"),'post',['p'=>$this->request->param("page")?:1]);
	        ajaxReturn($service['result']);
	         
	    }
	    
	    
	    //发布服务
	    public function addteaservice()
	    {
	        if($this->request->isPost()){
	            $ret = $this->get_api_data(C("TEART_SERVICE_ADD"),'post',$this->request->param());
	            ajaxReturn($ret);
	        }
	        return $this->fetch("release");
	    }
	    
	}
?>