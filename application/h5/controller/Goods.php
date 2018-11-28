<?php
	namespace app\h5\controller;

 class Goods extends Base
	{
	    //商品的评论
	    public function comment()
	    {
	        
	        $cmt = $this->get_api_data(C("GOODS_COMMENTLIST"),'post',['goods_id'=>$this->request->param("goods_id"),'p'=>$this->request->param("page")?:1]);
	        //print_r($cmt);
	        $this->assign("info",$cmt['result']);
	        return $this->fetch("评论");
	        
	    }
	    
	    public function ajaxcomment()
	    {
	        $cmt = $this->get_api_data(C("GOODS_COMMENTLIST"),'post',[
	            'goods_id'=>$this->request->param("goods_id"),
	            'p'=>$this->request->param("page")?:1
	            
	        ]);
	        ajaxReturn($cmt['result']);
	    }
	    
	    //goods desc
	    public function details()
	    {
    	    $goods = $this->get_api_data(C("GOODS_CONTENT"),'post',[
    	        'id'=>$this->request->param("id"),
    	        //'p'=>$this->request->param("page")?:1
    	        'is_json'=>1
    	         
    	    ]);
    	    
    	    $this->assign("goods",[
    	        'goods_content'=>$goods['result']['goods_content']
    	    ]);
	        return $this->fetch("goodsContent");
	    }
	    
	   
	}
?>