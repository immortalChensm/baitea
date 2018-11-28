<?php
	namespace app\h5\controller;
	
	class Auction extends Base
	{
	    //详情
	    public function details()
	    {
	        $order['goods_id'] = I("goods_id");
	        $goods_content = $this->get_api_data(C("AUCTION_CONTENT"),'post',$order);
	        $goods['goods_content'] = $goods_content['ret']['goods_content'];
	        $goods['goods_name'] = $goods_content['ret']['goods_name'];
	        $this->assign("goods",$goods);
	        return $this->fetch("deiles");
	        
	    }
	}
?>