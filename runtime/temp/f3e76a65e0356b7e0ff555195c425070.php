<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:49:"./template/mobile/mobile1/goods\categoryList.html";i:1517208521;s:48:"./template/mobile/mobile1/public\new_header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\footer_nav.html";i:1517208521;s:46:"./template/mobile/mobile1/public\wx_share.html";i:1517208522;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection"content="telephone=no, email=no" />
    <title>分类--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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


<header>
    <label>
        <input type="text" placeholder="请输入关键词" onfocus="location.href='<?php echo U('Goods/ajaxSearch'); ?>'">
    </label>
</header>
<div class="flool classlist">
    <div class="fl category1">
        <ul>
            <?php $m = '0'; if(is_array($goods_category_tree) || $goods_category_tree instanceof \think\Collection || $goods_category_tree instanceof \think\Paginator): if( count($goods_category_tree)==0 ) : echo "" ;else: foreach($goods_category_tree as $k=>$vo): if($vo[level] == 1): ?>
                    <li >
                       <a href="javascript:void(0);" <?php if($m == 0): endif; ?> data-id="<?php echo $m++; ?>"><?php echo getSubstr($vo['mobile_name'],0,12); ?></a>
                    </li>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div> 
    <div class="fr category2">
        <?php $j = '0'; if(is_array($goods_category_tree) || $goods_category_tree instanceof \think\Collection || $goods_category_tree instanceof \think\Paginator): if( count($goods_category_tree)==0 ) : echo "" ;else: foreach($goods_category_tree as $kk=>$vo): ?>
            <div class="branchList" >
                <!--广告图-s-->
                <div class="tp-bann"  data-id="<?php echo $j++; ?>">
                    <?php $pid =401;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1522648800 and end_time > 1522648800 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
if(is_array($ad_position) && !in_array($pid,array_keys($ad_position)) && $pid)
{
  M("ad_position")->insert(array(
         "position_id"=>$pid,
         "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ",
         "is_open"=>1,
         "position_desc"=>CONTROLLER_NAME."页面",
  ));
  delFile(RUNTIME_PATH); // 删除缓存  
  \think\Cache::clear();
}


$c = 1- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
if($c > 0 && I("get.edit_ad"))
{
    for($i = 0; $i < $c; $i++) // 还没有添加广告的时候
    {
      $result[] = array(
          "ad_code" => "/public/images/not_adv.jpg",
          "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid",
          "title"   =>"暂无广告图片",
          "not_adv" => 1,
          "target" => 0,
      );  
    }
}
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>
                        <a href="<?php echo $v['ad_link']; ?>" <?php if($v['target'] == 1): ?>target="_blank"<?php endif; ?> >
                            <img src="<?php echo $v[ad_code]; ?>" title="<?php echo $v[title]; ?>" style="<?php echo $v[style]; ?>">
                        </a>
                    <?php endforeach; ?>
                </div>
                <!--广告图-e-->
                <!--分类-s-->
                <div class="tp-class-list">
                    <?php if(is_array($vo['tmenu']) || $vo['tmenu'] instanceof \think\Collection || $vo['tmenu'] instanceof \think\Paginator): if( count($vo['tmenu'])==0 ) : echo "" ;else: foreach($vo['tmenu'] as $k2=>$v2): ?>
                            <h4><a href="<?php echo U('Mobile/Goods/goodsList',array('id'=>$v2[id])); ?>" ><?php echo $v2['name']; ?></a></h4>
                            <ul class="tp-category">
                                <?php if(is_array($v2['sub_menu']) || $v2['sub_menu'] instanceof \think\Collection || $v2['sub_menu'] instanceof \think\Paginator): if( count($v2['sub_menu'])==0 ) : echo "" ;else: foreach($v2['sub_menu'] as $key=>$v3): ?>
                                        <li>
                                            <a href="<?php echo U('Mobile/Goods/goodsList',array('id'=>$v3[id])); ?>">
                                                <img src="<?php echo (isset($v3['image']) && ($v3['image'] !== '')?$v3['image']:'__STATIC__/images/zy.png'); ?>"/>
                                                <p><?php echo $v3['name']; ?></p>
                                            </a>
                                        </li>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <!--分类-e-->
            </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>
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
        <li class="active">
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
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
<script>
    $(function () {
        //点击切换2 3级分类
        var array=new Array();
        $('.category1 li').each(function(){
            array.push($(this).position().top-0);
        });
        $('.branchList').eq(0).show().siblings().hide();
        $('.category1 li').click(function() {
            var index = $(this).index() ;
            $('.category1').delay(200).animate({scrollTop:array[index]},300);
            $(this).addClass('cur').siblings().removeClass();
            $('.branchList').eq(index).show().siblings().hide();
            $('.category2').scrollTop(0);
        });
    });
</script>
</body>
</html>
