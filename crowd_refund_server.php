<?php
	
	$time = 1000*60;
	
	swoole_timer_tick($time,function(){
	    
	    $result1 = file_get_contents("http://www.quhechacn.com/api/order/crowd_refund");
	    $result2 = file_get_contents("http://www.quhechacn.com/api/order/crowdgoods_notice");
	    $result3 = file_get_contents("http://www.quhechacn.com/api/AuctionGoods/refundMoney");
	});
?>