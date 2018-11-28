<?php
	$config = [
	    'API_SIGN'=>'123456',
	    //获取token
	    'CHECK_TOKEN'=>'http://118.190.204.122/index.php/api/User/token_status',
	    //获取用户信息
	    'GET_USER'=>'http://118.190.204.122/index.php/api/User/userInfo',
	    //订单详情
	    'ORDER_DETAILS'=>'http://118.190.204.122/index.php/api/Order/order_detail',
	    //取消订单
	    'CANCEL_ORDER'=>'http://118.190.204.122/index.php/api/Order/cancel_order',
	    //查看物流
	    'EXPRESS_VIEW'=>'http://118.190.204.122/index.php/api/User/express',
	    //查询物流
	    'QUERY_EXPRESS'=>'http://118.190.204.122/index.php/home/Api/queryExpress',
	    //确认收货　
	    'ORDER_CONFIRM'=>'http://118.190.204.122/index.php/api/Order/order_confirm',
	    //退货退款数据获取
	    'RETURN_GOODS'=>'http://118.190.204.122/index.php/api/Order/return_goods',
	    //图片上传
	    'UPLOAD_IMAGE'=>'http://118.190.204.122/index.php/api/User/imgs_upload',
	    //茶艺师订单详情  预约会员的详情
	    'TEAORDER_DETAILS'=>'http://118.190.204.122/index.php/api/user/getteaorder_details',
	    
	    //预约订单取消
	    'CANCEL_TEAORDER'=>'http://118.190.204.122/index.php/api/user/cancelteaorder',
	    
	    //茶艺师发布的服务列表
	    'TEART_SERVICE'=>'http://118.190.204.122/index.php/api/user/geteart_servicelist',
	    
	    //茶艺师发布服务
	    'TEART_SERVICE_ADD'=>'http://118.190.204.122/index.php/api/user/addteart_service',
	    
	    //商品评论列表
	    'GOODS_COMMENTLIST'=>'http://118.190.204.122/index.php/api/Goods/getGoodsComment',
	    
	    //退款详情
	    'REFUND_DETAILS'=>'http://118.190.204.122/index.php/api/Order/return_goods_info',
	    
	    //茶艺师的订单详情
	    'TEART_ORDER_DETAILS'=>'http://118.190.204.122/index.php/api/User/teart_receiveorder',
	    
	    //茶艺师的评价列表
	    'TEART_COMMENT_LIST'=>'http://118.190.204.122/index.php/api/Tea/getTeartComment',
	    
	    //商品详情[内容页]
	    'GOODS_CONTENT'=>'http://118.190.204.122/index.php/api/Goods/goodsContent',
	    
	    //注册协议
	    'REGAGREEMENT'=>'http://118.190.204.122/index.php/api/User/registNotice',
	    
	    //关于
	    'ABOUT'=>'http://118.190.204.122/index.php/api/User/about',
	    
	    //帮助
	    'HELP'=>'http://118.190.204.122/index.php/api/User/help',
	    
	    //拍卖品[内容页]
	    'AUCTION_CONTENT'=>'http://118.190.204.122/index.php/api/User/help',
	    
	    'FEEDBACK'=>'http://118.190.204.122/api/User/feedback',
	    
	];
	
	return array_merge($config,require_once 'html.php');
?>