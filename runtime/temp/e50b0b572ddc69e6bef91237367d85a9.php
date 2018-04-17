<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:41:"./template/mobile/mobile1/user\index.html";i:1517208525;s:48:"./template/mobile/mobile1/public\new_header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\footer_nav.html";i:1517208521;s:46:"./template/mobile/mobile1/public\wx_share.html";i:1517208522;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection"content="telephone=no, email=no" />
    <title>个人中心--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
    <script src="__STATIC__/js/jquery-3.1.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__STATIC__/js/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/global.js"></script>
    <script src="__STATIC__/js/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="__STATIC__/js/swipeSlide.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/mobile_common.js"></script>
    <link rel='stylesheet' href="__STATIC__/newskin/css/base.css">
	<link rel='stylesheet' href="__STATIC__/newskin/css/mobile.css">
	<style>
		.classlist{background-color:#f8f8f8;overflow:hidden}.classlist .fl{width:3.24267rem;background-color:#fff}.classlist .fl ul li{text-align:center;position:relative}.classlist .fl ul li:before{content:'';height:3.92533rem;width:.02133rem;position:absolute;left:auto;top:0;right:0;bottom:auto;background-color:#e5e5e5;border:0 solid transparent;border-radius:0;-webkit-border-radius:0;transform:scale(.5);-webkit-transform:scale(.5);-moz-transform:scale(.5);-ms-transform:scale(.5);-o-transform:scale(.5);transform-origin:top left;-webkit-transform-origin:top left;-moz-transform-origin:top left;-ms-transform-origin:top left;-o-transform-origin:top left}.classlist .fl ul li:after{content:'';height:.02133rem;width:200%;position:absolute;left:0;top:auto;right:auto;bottom:0;background-color:#e5e5e5;border:0 solid transparent;border-radius:0;-webkit-border-radius:0;transform:scale(.5);-webkit-transform:scale(.5);-moz-transform:scale(.5);-ms-transform:scale(.5);-o-transform:scale(.5);transform-origin:top left;-webkit-transform-origin:top left;-moz-transform-origin:top left;-ms-transform-origin:top left;-o-transform-origin:top left}.classlist .fl ul li a{display:block;width:100%;height:1.96267rem;line-height:1.96267rem;text-decoration:none;font-size:.59733rem;color:#232326;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.classlist .fl ul .red a{color:#ee5b03}.classlist .fr{width:12.75733rem}.classlist .fr .branchList .tp-bann img{width:100%}.classlist .fr .branchList .tp-class-list h4{font-size:.59733rem;color:#232326;font-weight:400}.classlist .fr .branchList .tp-class-list ul{margin-top:.384rem;background-color:#fff}.classlist .fr .branchList .tp-class-list ul li{float:left;width:33.33333%;text-align:center}.classlist .fr .branchList .tp-class-list ul li a{display:block}.classlist .fr .branchList .tp-class-list ul li a img{width:80%;height:1rem}.classlist .fr .branchList .tp-class-list ul li a p{overflow:hidden;text-overflow:ellipsis;width:100%;margin:.2rem 0;font-size:.24rem;height:auto}.tp-category{padding:.2rem;overflow:hidden}.classlist .fl{width:32%;border-top:1px solid #eaeaea;position:absolute;top:.88rem;bottom:1rem;left:0;overflow-y:scroll;-webkit-overflow-scrolling:touch}.classlist .fl ul li a{height:.88rem;line-height:.88rem;font-size:.24rem}.classlist .fr{width:68%;border-top:1px solid #eaeaea;background-color:#f8f8f8;position:absolute;top:.88rem;bottom:1rem;right:0;overflow-y:scroll;-webkit-overflow-scrolling:touch}.classlist .fr .branchList .tp-class-list h4{font-size:.36rem;line-height:.6rem;color:#262626;padding-left:.1rem}.classlist .fr .branchList .tp-class-list ul li{height:2rem;overflow:hidden}.tp-class-list{margin:0 .1rem 0 .1rem}.classlist .fr .branchList .tp-class-list ul{margin:.1rem 0}
		header{
			background: #fff;margin-left: 0;
		}
	</style>
	<script>
	    function resize(originSize,type) {
	        var type=type||"x";
	        var widths=document.documentElement.clientWidth;
	        var heights=document.documentElement.clientHeight;
	        if(type=="x"){
	            var scalex=widths/originSize*100;
	            document.querySelector("html").style.fontSize=scalex+"px";
	        }else if(type=="y"){
	            var scaley=heights/originSize*100;
	            document.querySelector("html").style.fontSize=scaley+"px";
	        }
	    }
	    resize(750);
	</script>
</head>
<body class="[body]">


<style>
    div{ cursor: pointer; }
</style>
<div class="main main-bg" style="padding-top: 0px; min-height: 667px;">
    <div class="f-home-head">
        <div class="m-top">
            <div class="a-left">
                <a href="<?php echo U('User/message_notice'); ?>">
                    <i><?php echo $user_message_count; ?></i>
                </a>
            </div>
            <div class="a-right">
                <a href="<?php echo U('Mobile/User/sign'); ?>">签到</a>
                <a href="<?php echo U('Mobile/User/userinfo'); ?>"></a>
            </div>
        </div>
        <div class="m-info">
            <div class="a-left">
                <div class="p-tx" style="background-image: url(<?php echo (isset($user[head_pic]) && ($user[head_pic] !== '')?$user[head_pic]:"__STATIC__/images/user68.jpg"); ?>);border-radius: 50%;"></div>
                <div class="p-name">
                    <span><?php echo $user['nickname']; ?></span>
                    <?php if($first_nickname != ''): ?>
                        <br />
                        <i >由(<?php echo $first_nickname; ?>)推荐</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="a-right">
                <div class="p-box" onclick="location.href='<?php echo U('Mobile/User/visit_log'); ?>'">
                    <span>20</span><i>足迹</i>
                </div>
                <div class="p-box" onclick="location.href='<?php echo U('User/myfocus'); ?>'">
                    <span><?php echo $user['collect_count']; ?></span><i>收藏</i>
                </div>
            </div>
        </div>
    </div>
    <div class="f-myinfo">
        <!--优惠券+余额+积分-->
        <div class="m-money">
            <div class="a-fl">
                <div class="fl-list" onclick="location.href='<?php echo U('Mobile/User/coupon'); ?>'">
                    <span><?php echo $user['coupon_count']; ?></span>
                    <div class="list-name">优惠券</div>
                </div>
                <div class="fl-list" onclick="location.href='<?php echo U('Mobile/User/account'); ?>'">
                    <span><?php echo $user['user_money']; ?></span>
                    <div class="list-name"><i></i>余额</div>
                </div>
                <div class="fl-list" onclick="location.href='<?php echo U('Mobile/User/points_list'); ?>'">
                    <span><?php echo $user['pay_points']; ?></span>
                    <div class="list-name">积分</div>
                </div>
            </div>
            <a href="<?php echo U('Mobile/User/account'); ?>" class="gocapital">资金管理</a>
        </div>
        <!--全部订单-->
        <div class="m-order">
            <div class="a-fl">
                <a class="fl-list" href="<?php echo U('Mobile/Order/order_list',array('type'=>'WAITPAY')); ?>">
                    <span><i><?php echo $user['waitPay']; ?></i></span>
                    <div class="list-name">待付款</div>
                </a>
                <a class="fl-list" href="<?php echo U('Mobile/Order/order_list',array('type'=>'WAITSEND')); ?>">
                    <span><i><?php echo $user['waitSend']; ?></i></span>
                    <div class="list-name">待发货</div>
                </a>
                <a class="fl-list" href="<?php echo U('Mobile/Order/order_list',array('type'=>'WAITRECEIVE')); ?>">
                    <span><i><?php echo $user['waitReceive']; ?></i></span>
                    <div class="list-name">待收货</div>
                </a>
                <a class="fl-list" href="<?php echo U('Mobile/Order/comment',array('status'=>0)); ?>">
                    <span><i><?php echo $user['waitReceive']; ?></i></span>
                    <div class="list-name">待评价</div>
                </a>
                <a class="fl-list" href="<?php echo U('Mobile/Order/return_goods_list'); ?>">
                    <span><i><?php echo $user['return_count']; ?></i></span>
                    <div class="list-name">退款/退货</div>
                </a>
            </div>
            <a href="<?php echo U('Mobile/Order/order_list'); ?>" class="gocapital">全部订单</a>
        </div>
        <!--二级入口--> 
        <div class="m-warp">
            <div class="a-warp">
                <a class="a-list" href="<?php echo U('Distribut/index'); ?>">
                    <div class="a-img" style="background-image: url(__STATIC__/newskin/images/home/ico-1@2x.png)"></div>
                    <span>我的分销</span>
                </a>
                <a class="a-list" href="<?php echo U('Virtual/virtual_list'); ?>">
                    <div class="a-img" style="background-image: url(__STATIC__/newskin/images/home/ico-2@2x.png)"></div>
                    <span>虚拟订单</span>
                </a>
                <a class="a-list" href="<?php echo U('Order/team_list'); ?>">
                    <div class="a-img" style="background-image: url(__STATIC__/newskin/images/home/ico-3@2x.png)"></div>
                    <span>拼团订单</span>
                </a>
                <a class="a-list" href="<?php echo U('Mobile/Order/comment',array('status'=>1)); ?>">
                    <div class="a-img" style="background-image: url(__STATIC__/newskin/images/home/ico-4@2x.png)"></div>
                    <span>我的评价</span>
                </a>
                <a class="a-list" href="<?php echo U('Mobile/Goods/integralMall'); ?>">
                    <div class="a-img" style="background-image: url(__STATIC__/newskin/images/home/ico-5@2x.png)"></div>
                    <span>积分兑换</span>
                </a>
                <a class="a-list" href="<?php echo U('Mobile/Activity/coupon_list'); ?>">
                    <div class="a-img" style="background-image: url(__STATIC__/newskin/images/home/ico-6@2x.png)"></div>
                    <span>领券中心</span>
                </a>
                <a class="a-list" href="<?php echo U('Mobile/User/address_list'); ?>">
                    <div class="a-img" style="background-image: url(__STATIC__/newskin/images/home/ico-7@2x.png)"></div>
                    <span>地址管理</span>
                </a>
                <a class="a-list" href="<?php echo U('Mobile/Newjoin/guidance'); ?>">
                    <div class="a-img" style="background-image: url(__STATIC__/newskin/images/home/ico-8@2x.png)"></div>
                    <span>我要开店</span>
                </a>
            </div>
        </div>
    </div>
    <a href="<?php echo U('Mobile/User/logout'); ?>" id="logout" style="width: 80%;display: block;height: .6rem;line-height: .6rem;text-align: center;background-color: #fd6600;color: #fff;font-size: .3rem;margin:.3rem auto .1rem;border-radius: 5px;">安全退出</a>
    <div style="height: 1rem;"></div> 
</div>

<script>
  $(".main-bg").css("min-height",$(window).height());
</script>

<!--
<div class="myorder p">
    <div class="content30">
        <a href="">
            <div class="order">
                <div class="fl">
                    <img src="__STATIC__/images/w6.png"/>
                    <span>帮助中心</span>
                </div>
                <div class="fr">
                    <i class="Mright"></i>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="myorder p">
    <div class="content30">
        <a href="">
            <div class="order">
                <div class="fl">
                    <img src="__STATIC__/images/w7.png"/>
                    <span>意见反馈</span>
                </div>
                <div class="fr">
                    <i class="Mright"></i>
                </div>
            </div>
        </a>
    </div>
</div>
-->
    <button class="guide" onclick="follow_wx()">关注公众号</button>
    <!--底部导航-start-->
    <style type="text/css">
  footer {
    width: 100%;
    height: 1rem;
    background-color: #fff;
    border-top: 1px solid #f2f2f2;
    position: fixed;
    bottom: -1px;
    left: 0;
    z-index: 999;
  }
  footer ul {
    width: 100%;
    height: 100%;
  }
  footer ul li {
    width: 25%;
    height: 100%;
    float: left;
  }
  footer ul li .b-icon {
    width: .42rem;
    height: .42rem;
    margin: .1rem auto 0;
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
  }
  footer ul li .b-wen {
    width: 100%;
    font-size: .24rem;
    color: #989898;
    text-align: center;
  }
  footer ul li:nth-child(1) .b-icon {
    background-image: url(__STATIC__/images/icon_home.png);
  }
  footer ul li:nth-child(2) .b-icon {
    background-image: url(__STATIC__/images/icon_position.png);
  }
  footer ul li:nth-child(3) .b-icon {
    background-image: url(__STATIC__/images/icon_zhushou.png);
  }
  footer ul li:nth-child(4) .b-icon {
    background-image: url(__STATIC__/images/icon_wode.png);
  }
  footer ul .active .b-icon1 {
    background-image: url(__STATIC__/images/ico_home.png) !important;
  }
  footer ul .active .b-icon2 {
    background-image: url(__STATIC__/images/ico_position.png) !important;
  }
  footer ul .active .b-icon3 {
    background-image: url(__STATIC__/images/ico_zhushou.png) !important;
  }
  footer ul .active .b-icon4 {
    background-image: url(__STATIC__/images/ico_wode.png) !important;
  }
  footer ul .active .b-wen {
    color: #fe6601;
  }
</style>
<footer>
    <ul class="clear">
        <li class="[icon1]">
            <a <?php if(CONTROLLER_NAME == 'Index'): ?>class="yello" <?php endif; ?>  href="<?php echo U('Index/index'); ?>">
                <div class="b-icon b-icon1"></div>
                <div class="b-wen">首页</div>
            </a>
        </li>
        <li class="[icon2]">
            <a href="<?php echo U('Goods/categoryList'); ?>">
                <div class="b-icon b-icon2"></div>
                <div class="b-wen">分类</div>
            </a>
        </li>
        <li class="[icon3]">
           <a href="<?php echo U('Cart/index'); ?>">
                <div class="b-icon b-icon3"></div>
                <div class="b-wen">购物车</div>
            </a>
        </li>
        <li class="active">
            <a <?php if(CONTROLLER_NAME == 'User'): ?>class="yello" <?php endif; ?> href="<?php echo U('User/index'); ?>">
                <div class="b-icon b-icon4"></div>
                <div class="b-wen">我的</div>
            </a>
        </li>
    </ul>
</footer>
<script type="text/javascript">
$(document).ready(function(){
	  var cart_cn = getCookie('cn');
	  if(cart_cn == ''){
		$.ajax({
			type : "GET",
			url:"/index.php?m=Home&c=Cart&a=header_cart_list",//+tab,
			success: function(data){								 
				cart_cn = getCookie('cn');
				$('#cart_quantity').html(cart_cn);						
			}
		});	
	  }
	  $('#cart_quantity').html(cart_cn);
});
</script>
<!-- 微信浏览器 调用微信 分享js-->
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script src="__PUBLIC__/js/global.js"></script>
<script type="text/javascript">
<?php if(ACTION_NAME == 'goodsInfo'): ?>
   var ShareLink = "<?php echo U('Mobile/Goods/goodsInfo',['id'=>$goods[goods_id]],'',true); ?>"; //默认分享链接
   var ShareImgUrl = "http://<?php echo \think\Request::instance()->server('SERVER_NAME'); ?><?php echo goods_thum_images($goods[goods_id],400,400); ?>"; // 分享图标
   var ShareTitle = "<?php echo (isset($goods['goods_name']) && ($goods['goods_name'] !== '')?$goods['goods_name']:$tpshop_config['shop_info_store_title']); ?>"; // 分享标题
   var ShareDesc = "<?php echo (isset($goods['goods_remark']) && ($goods['goods_remark'] !== '')?$goods['goods_remark']:$tpshop_config['shop_info_store_desc']); ?>"; // 分享描述
<?php elseif(ACTION_NAME == 'info'): ?>
	var ShareLink = "<?php echo U('Mobile/Team/info',['goods_id'=>$team[goods_id],'team_id'=>$team[team_id]]); ?>"; //默认分享链接
	var ShareImgUrl = "http://<?php echo \think\Request::instance()->server('SERVER_NAME'); ?><?php echo $team[share_img]; ?>"; //分享图标
	var ShareTitle = "<?php echo $team[share_title]; ?>"; //分享标题
	var ShareDesc = "<?php echo $team[share_desc]; ?>"; //分享描述
<?php elseif(ACTION_NAME == 'my_store'): ?>
	var ShareLink = "http://<?php echo \think\Request::instance()->server('SERVER_NAME'); ?>/index.php?m=Mobile&c=Distribut&a=my_store"; 
	var ShareImgUrl = "http://<?php echo \think\Request::instance()->server('SERVER_NAME'); ?><?php echo $tpshop_config['shop_info_store_logo']; ?>"; 
	var ShareTitle = "<?php echo $share_title; ?>"; 
	var ShareDesc = "http://<?php echo \think\Request::instance()->server('SERVER_NAME'); ?><?php echo U('Mobile/Distribut/my_store'); ?>"; 
<?php elseif(ACTION_NAME == 'found'): ?>
	var ShareLink = "<?php echo U('Mobile/Team/found',['id'=>$teamFound[found_id]],'',true); ?>"; //默认分享链接
	var ShareImgUrl = "http://<?php echo \think\Request::instance()->server('SERVER_NAME'); ?><?php echo $team[share_img]; ?>"; //分享图标
	var ShareTitle = "<?php echo $team[share_title]; ?>"; //分享标题
	var ShareDesc = "<?php echo $team[share_desc]; ?>"; //分享描述
<?php else: ?>
   var ShareLink = "http://<?php echo $_SERVER[HTTP_HOST]; ?>/index.php?m=Mobile&c=Index&a=index"; //默认分享链接
   var ShareImgUrl = "http://<?php echo \think\Request::instance()->server('SERVER_NAME'); ?><?php echo $tpshop_config['shop_info_store_logo']; ?>"; //分享图标
   var ShareTitle = "<?php echo $tpshop_config['shop_info_store_title']; ?>"; //分享标题
   var ShareDesc = "<?php echo $tpshop_config['shop_info_store_desc']; ?>"; //分享描述
<?php endif; ?>

var is_distribut = getCookie('is_distribut'); // 是否分销代理
var user_id = getCookie('user_id'); // 当前用户id
var subscribe = getCookie('subscribe'); // 当前用户是否关注了公众号
//alert(is_distribut+'=='+user_id);
// 如果已经登录了, 并且是分销商
if(parseInt(is_distribut) == 1 && parseInt(user_id) > 0)
{									
	ShareLink = ShareLink + "&first_leader="+user_id;									
}

$(function() {
	if(isWeiXin() && parseInt(user_id)>0){
		$.ajax({
			type : "POST",
			url:"/index.php?m=Mobile&c=Index&a=ajaxGetWxConfig&t="+Math.random(),
			data:{'askUrl':encodeURIComponent(location.href.split('#')[0])},		
			dataType:'JSON',
			success: function(res)
			{
				//微信配置
				wx.config({
				    debug: false, 
				    appId: res.appId,
				    timestamp: res.timestamp, 
				    nonceStr: res.nonceStr, 
				    signature: res.signature,
				    jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage','onMenuShareQQ','onMenuShareQZone','hideOptionMenu'] // 功能列表，我们要使用JS-SDK的什么功能
				});
			},
			error:function(){
				return false;
			}
		}); 

		// config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在 页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready 函数中。
		wx.ready(function(){
		    // 获取"分享到朋友圈"按钮点击状态及自定义分享内容接口
		    wx.onMenuShareTimeline({
		        title: ShareTitle, // 分享标题
		        link:ShareLink,
		        desc: ShareDesc,
		        imgUrl:ShareImgUrl // 分享图标
		    });

		    // 获取"分享给朋友"按钮点击状态及自定义分享内容接口
		    wx.onMenuShareAppMessage({
		        title: ShareTitle, // 分享标题
		        desc: ShareDesc, // 分享描述
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
		    });
			// 分享到QQ
			wx.onMenuShareQQ({
		        title: ShareTitle, // 分享标题
		        desc: ShareDesc, // 分享描述
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
			});	
			// 分享到QQ空间
			wx.onMenuShareQZone({
		        title: ShareTitle, // 分享标题
		        desc: ShareDesc, // 分享描述
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
			});

		   <?php if(CONTROLLER_NAME == 'User'): ?> 
				wx.hideOptionMenu();  // 用户中心 隐藏微信菜单
		   <?php endif; ?>	
		});
	} 
	
	isWeiXin() || $('.guide').hide(); // 非微信浏览 不提示关注公众号		
		
});

function isWeiXin(){
    var ua = window.navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i) == 'micromessenger'){
        return true;
    }else{
        return false;
    }
}
</script>
<!--微信关注提醒 start-->
<?php if(\think\Session::get('subscribe') == 0): ?>
<button class="guide" onclick="follow_wx()">关注公众号</button>
<style type="text/css">
.guide{width:20px;height:100px;text-align: center;border-radius: 8px ;font-size:12px;padding:8px 0;border:1px solid #adadab;color:#000000;background-color: #fff;position: fixed;right: 6px;bottom: 200px;z-index: 99;}
#cover{display:none;position:absolute;left:0;top:0;z-index:18888;background-color:#000000;opacity:0.7;}
#guide{display:none;position:absolute;top:5px;z-index:19999;}
#guide img{width: 70%;height: auto;display: block;margin: 0 auto;margin-top: 10px;}
</style>
<script type="text/javascript">
  //关注微信公众号二维码	 
function follow_wx()
{
	layer.open({
		type : 1,  
		title: '关注公众号',
		content: '<img src="<?php echo $wx_qr; ?>" width="200">',
		style: ''
	});
}
</script> 
<?php endif; ?>
<!--微信关注提醒  end-->
<!-- 微信浏览器 调用微信 分享js  end-->
    <!--底部导航-end-->
    <script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>
