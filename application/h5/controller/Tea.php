<?php
	namespace app\h5\controller;
	
	class Tea extends Base
	{
	       //茶艺师的评论
	    public function comment()
	    {
	        
	        $cmt = $this->get_api_data(C("TEART_COMMENT_LIST"),'post',['teartid'=>$this->request->param("teartid"),'p'=>$this->request->param("page")?:1]);
	        $this->assign("info",$cmt['result']);
	        return $this->fetch("评论");
	        
	    }
	    
	    public function ajaxcomment()
	    {
	        $cmt = $this->get_api_data(C("TEART_COMMENT_LIST"),'post',[
	            'teartid'=>$this->request->param("teartid"),
	            'p'=>$this->request->param("page")?:1
	            
	        ]);
	        ajaxReturn($cmt['result']['list']);
	    }
	    
	    public function about()
	    {
	        $cmt = $this->get_api_data(C("TEART_COMMENT_LIST"),'post');
	        $this->assign("info",$cmt['result']);
	        return $this->fetch("评论");
	    }
	    
	    
	}
?>