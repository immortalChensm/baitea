<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:43:"./template/mobile/mobile1/user\account.html";i:1517208525;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\footer_nav.html";i:1517208521;s:46:"./template/mobile/mobile1/public\wx_share.html";i:1517208522;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>我的钱包--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
    <link rel="stylesheet" href="__STATIC__/css/style.css">
<!--    <link rel='stylesheet' href="__STATIC__/css/base.css">
    <link rel='stylesheet' href="__STATIC__/css/mobile.css">-->
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/iconfont.css"/>
    <script src="__STATIC__/js/jquery-3.1.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__STATIC__/js/mobile-util.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/global.js"></script>
    <script src="__STATIC__/js/layer/layer.js" type="text/javascript" charset="utf-8"></script>
   <script src="__STATIC__/js/swipeSlide.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/mobile_common.js"></script>
    <style>
        body footer {
            height: 2rem;
        }
        body footer ul li .b-icon {
            width: .84rem;
            height: .84rem;
            margin: .2rem auto 0;
        }
        body footer ul li .b-wen {
            margin-top: .2rem; 
            font-size: .48rem;
        }
    </style>
</head>
<body class="g4">

    <div class="myhearder bankhearder">
        <div class="hh">
            <h2>可用余额</h2>
            <h1><?php echo $user['user_money']; ?></h1>
            <h3>冻结余额：<?php echo $user['frozen_money']; ?></h3>
        </div>
        <div class="scgz">
            <ul>
                <li>
                    <a href="<?php echo U('Mobile/User/recharge'); ?>">
                        <img src="__STATIC__/images/cz.png"/>
                        <p>账户充值</p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo U('Mobile/User/withdrawals'); ?>">
                        <img src="__STATIC__/images/tx.png"/>
                        <p>余额提现</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="floor my p">
        <div class="content">
            <div class="floor list7 ma-to-20">
                <div class="myorder p">
                    <div class="content30">
                        <a href="<?php echo U('Mobile/User/account_list'); ?>">
                            <div class="order">
                                <div class="fl">
                                    <span>余额明细</span>
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
                        <a href="<?php echo U('Mobile/User/points_list'); ?>">
                            <div class="order">
                                <div class="fl">
                                    <span>积分明细</span>
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
                        <a href="<?php echo U('Mobile/User/recharge_list'); ?>">
                            <div class="order">
                                <div class="fl">
                                    <span>充值记录</span>
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
                        <a href="<?php echo U('Mobile/User/withdrawals_list'); ?>">
                            <div class="order">
                                <div class="fl">
                                    <span>提现记录</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        <li class="[icon4]">
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
