<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:42:"./template/mobile/mobile1/index\index.html";i:1517208521;s:48:"./template/mobile/mobile1/public\new_header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\footer_nav.html";i:1517208521;s:46:"./template/mobile/mobile1/public\wx_share.html";i:1517208522;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection"content="telephone=no, email=no" />
    <title>首页--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
    <div class="h-left"><a href="javascript:;"><img src="__STATIC__/images/qr-code-icon.png"></a></div>
    <div class="h-con">掌心全球购</div>
    <div class="h-right"><a href="<?php echo U('Goods/ajaxSearch'); ?>"><img src="__STATIC__/images/search-icon.png"></a></div>
</header> 
<div class="main">
    <!--banner模块-->
    <div class="f-banner">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php $pid =2;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1522058400 and end_time > 1522058400 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("5")->select();
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


$c = 5- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
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
                   <div class="swiper-slide"><a href="<?php echo $v['ad_link']; ?>"> <img src="<?php echo $v[ad_code]; ?>" title="<?php echo $v[title]; ?>" style="<?php echo $v[style]; ?>" alt=""></a></div>

                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!--分类模块-->
    <div class="f-classify">
        <ul class="clear">
            <li><a href="<?php echo U('Activity/coupon_list'); ?>"><img src="__STATIC__/images/icon_1@2x.png"><span>领优惠券</span></a></li>
            <li><a href="<?php echo U('Team/index'); ?>"><img src="__STATIC__/images/icon_2@2x.png"><span>我要拼团</span></a></li>
            <li><a href="<?php echo U('Mobile/Activity/flash_sale_list'); ?>"><img src="__STATIC__/images/icon_3@2x.png"><span>秒杀</span></a></li> 
            <li><a href=""><img src="__STATIC__/images/icon_4@2x.png"><span>热销</span></a></li>
            <li><a href="<?php echo U('Activity/promote_goods'); ?>"><img src="__STATIC__/images/icon_5@2x.png"><span>优惠活动</span></a></li>
            <li><a href="<?php echo U('Index/street'); ?>"><img src="__STATIC__/images/icon_6@2x.png"><span>店铺街</span></a></li>
            <li><a href="<?php echo U('Index/brand'); ?>"><img src="__STATIC__/images/icon_7@2x.png"><span>品牌街</span></a></li>
            <li><a href="<?php echo U('Activity/group_list'); ?>"><img src="__STATIC__/images/icon_8@2x.png"><span>团购</span></a></li>
            <li>  <a href="<?php echo U('Goods/integralMall'); ?>"><img src="__STATIC__/images/icon_9@2x.png"><span>积分商城</span></a></li>
            <li><a href="<?php echo U('Goods/categoryList'); ?>"><img src="__STATIC__/images/icon_10@2x.png"><span>全部分类</span></a></li>
        </ul>
    </div>
    <!--品牌活动模块-->
    <div class="f-brand-activity">
        <div class="brand-top">
            <div class="brand-l">
                <img src="__STATIC__/images/icon_pinpai.png">品牌<span>活动</span>
            </div>
            <a href="<?php echo U('Activity/promote_goods'); ?>" class="brand-r" >
                品牌专区 <img src="__STATIC__/images/icon_next.png">
            </a>
        </div>
        <div class="brand-content">
            <div class="brand-c-warp">
                <div class="swiper-container1">
                    <div class="swiper-wrapper">
                        <?php
                                   
                                $md5_key = md5("select id,title,prom_img,end_time from __PREFIX__prom_goods where status=1  limit 4");
                                $result_name = $sql_result_prom = S("sql_".$md5_key);
                                if(empty($sql_result_prom))
                                {                            
                                    $result_name = $sql_result_prom = \think\Db::query("select id,title,prom_img,end_time from __PREFIX__prom_goods where status=1  limit 4"); 
                                    S("sql_".$md5_key,$sql_result_prom,31104000);
                                }    
                              foreach($sql_result_prom as $promote_key=>$prom): ?>
                               <div class="swiper-slide">
                             <a href="<?php echo U('Activity/promote_goods'); ?>"><img src="<?php echo $prom['prom_img']; ?>" /></a>
                            <div class="slider-bottom">
<!--                                <img src="image/logo_1.png">-->
                                <div class="brand-time"><a class="t_d"></a>天<a class="t_h"></a>时<a class="t_m"></a>分<a class="t_s"></a>秒</div>
                                <span class="slider-r"><?php echo $prom['title']; ?><i>折起</i></span>
                            </div>
                        </div>
                      <?php endforeach; ?>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--每日必抢-->
    <div class="f-daily-robbing">
        <div class="daily-top">
            <div class="daily-l">
                <img src="__STATIC__/images/icon_clock.png">每日必抢&nbsp;<span><?php echo date('H',$start_time); ?>点场</span>&nbsp;&nbsp;&nbsp;
                <span><i id="t_h">00</i><i id='t_m'>00</i><i id="t_s">00</i></span>
            </div>
           <a href="<?php echo U('Mobile/Activity/flash_sale_list'); ?>" class="daily-r">
                进入必抢专场 <img src="__STATIC__/images/icon_next.png">
            </a>
        </div>
        <div class="daily-content">
            <div class="daily-c-warp">
                <div class="swiper-container2">
                    <div class="swiper-wrapper">
                        <?php if(count($flash_sale_list) == nll): ?>
                            <div style="text-align: center;font-size: .3rem;">暂无抢购商品。。。。</div>
                        <?php endif; if(is_array($flash_sale_list) || $flash_sale_list instanceof \think\Collection || $flash_sale_list instanceof \think\Paginator): if( count($flash_sale_list)==0 ) : echo "" ;else: foreach($flash_sale_list as $key=>$v): ?>
                              <div class="swiper-slide">
                            <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id],'item_id'=>$v[item_id])); ?>"><img src="<?php echo goods_thum_images($v[goods_id],136,126); ?>"/></a>
                            <div class="slider-bottom">
                                <div class="daily-money">￥<?php echo $v[price]; ?></div>
                                <div class="no-money">￥<?php echo $v[shop_price]; ?></div>
                            </div>
                        </div>
                     <?php endforeach; endif; else: echo "" ;endif; ?>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--新品上市-->
    <div class="f-new-arrival">
        <div class="arrival-top">
            <img src="__STATIC__/images/arriver.png" class="font-img">
            <a class="arr-top-r" href="<?php echo U('Index/brand'); ?>">
                更多新品 <img src="__STATIC__/images/icon_next.png">
            </a>
        </div>
        <div class="arrival-bottom">
          <div class="arrival">
                <?php
                                   
                                $md5_key = md5("select goods_id,goods_name,original_img,shop_price from __PREFIX__goods where is_new=1 and is_on_sale=1 limit 0,2");
                                $result_name = $sql_result_goods = S("sql_".$md5_key);
                                if(empty($sql_result_goods))
                                {                            
                                    $result_name = $sql_result_goods = \think\Db::query("select goods_id,goods_name,original_img,shop_price from __PREFIX__goods where is_new=1 and is_on_sale=1 limit 0,2"); 
                                    S("sql_".$md5_key,$sql_result_goods,31104000);
                                }    
                              foreach($sql_result_goods as $promote_key=>$goods): ?>
                        <div class="arr-con">
                          <a  href="<?php echo U('mobile/Goods/goodsInfo',array('id'=>$goods[goods_id])); ?>" target="_blank">
                        <div class="arr-name"><?php echo $goods['goods_name']; ?></div>
                        <div class="arr-money">￥<?php echo $goods['shop_price']; ?></div>
                        <img src="<?php echo $goods['original_img']; ?>">
                        </a>
                     </div>
                  <?php endforeach; ?>
            </div>
            <div class="arrival">
                   <?php
                                   
                                $md5_key = md5("select goods_id,goods_name,original_img,shop_price from __PREFIX__goods where is_new=1 and is_on_sale=1 limit 3,2");
                                $result_name = $sql_result_goods = S("sql_".$md5_key);
                                if(empty($sql_result_goods))
                                {                            
                                    $result_name = $sql_result_goods = \think\Db::query("select goods_id,goods_name,original_img,shop_price from __PREFIX__goods where is_new=1 and is_on_sale=1 limit 3,2"); 
                                    S("sql_".$md5_key,$sql_result_goods,31104000);
                                }    
                              foreach($sql_result_goods as $promote_key=>$goods): ?>
                        <div class="arr-con">
                          <a  href="<?php echo U('mobile/Goods/goodsInfo',array('id'=>$goods[goods_id])); ?>" target="_blank">
                        <div class="arr-name"><?php echo $goods['goods_name']; ?></div>
                        <div class="arr-money">￥<?php echo $goods['shop_price']; ?></div>
                        <img src="<?php echo $goods['original_img']; ?>">
                        </a>
                     </div>
                  <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!--广告位-->
    <div class="f-adsense">
        <a href=""><img src="__STATIC__/images/adsense.png"></a>
    </div>
    <!--热销精品-->
    <div class="f-new-arrival">
        <div class="arrival-top">
            <img src="__STATIC__/images/arriver-two.png" class="font-img">
            <a class="arr-top-r">
                更多热销产品 <img src="__STATIC__/images/icon_next.png">
            </a>
        </div>
        <div class="arrival-bottom">
             <div class="arrival">
                <?php
                                   
                                $md5_key = md5("select goods_id,goods_name,original_img,shop_price from __PREFIX__goods where is_hot=1 and is_hot=1 limit 0,2");
                                $result_name = $sql_result_goods = S("sql_".$md5_key);
                                if(empty($sql_result_goods))
                                {                            
                                    $result_name = $sql_result_goods = \think\Db::query("select goods_id,goods_name,original_img,shop_price from __PREFIX__goods where is_hot=1 and is_hot=1 limit 0,2"); 
                                    S("sql_".$md5_key,$sql_result_goods,31104000);
                                }    
                              foreach($sql_result_goods as $promote_key=>$goods): ?>
                        <div class="arr-con">
                          <a  href="<?php echo U('mobile/Goods/goodsInfo',array('id'=>$goods[goods_id])); ?>" target="_blank">
                        <div class="arr-name"><?php echo $goods['goods_name']; ?></div>
                        <div class="arr-money">￥<?php echo $goods['shop_price']; ?></div>
                        <img src="<?php echo $goods['original_img']; ?>">
                        </a>
                     </div>
                  <?php endforeach; ?>
            </div>
            <div class="arrival">
                   <?php
                                   
                                $md5_key = md5("select goods_id,goods_name,original_img,shop_price from __PREFIX__goods where is_hot=1 and is_hot=1 limit 3,2");
                                $result_name = $sql_result_goods = S("sql_".$md5_key);
                                if(empty($sql_result_goods))
                                {                            
                                    $result_name = $sql_result_goods = \think\Db::query("select goods_id,goods_name,original_img,shop_price from __PREFIX__goods where is_hot=1 and is_hot=1 limit 3,2"); 
                                    S("sql_".$md5_key,$sql_result_goods,31104000);
                                }    
                              foreach($sql_result_goods as $promote_key=>$goods): ?>
                        <div class="arr-con">
                          <a  href="<?php echo U('mobile/Goods/goodsInfo',array('id'=>$goods[goods_id])); ?>" target="_blank">
                        <div class="arr-name"><?php echo $goods['goods_name']; ?></div> 
                        <div class="arr-money">￥<?php echo $goods['shop_price']; ?></div>
                        <img src="<?php echo $goods['original_img']; ?>">
                        </a>
                     </div>
                  <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!--猜你喜欢-->
    <div class="f-likegoods">
        <div class="goods-top">
            <div class="title"><span>猜你喜欢</span></div>
        </div>
        <div class="goods-warp clear">
          

        </div>
    </div>
    <div id="scroller">加载中...</div>
    <!--防止底部不足-->
    <div style="height: .88rem;background-color: #f8f8f8;"></div>
</div>
<!--底部-->
<input type="hidden" name="" value="<?php echo date('Y-m-d H:m:s',$end_time); ?>" id='time-end'>

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
        <li class="active">
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
<script type="text/javascript" src="__STATIC__/js/sourch_submit.js"></script>
<link rel="stylesheet" href="__STATIC__/css/swiper.min.css">
<script src="__STATIC__/js/swiper.min.js"></script>
<script>
    //banner图
    $(".swiper-container").swiper({
        autoplay: 3000
    });
    //自适应滚动
    $(".swiper-container1").swiper({
        slidesPerView :'auto'
    });
    $(".swiper-container2").swiper({
        slidesPerView :'auto',
        spaceBetween : '3%'
    });
</script>
<!--按需加载-->
<script>
//    var move = true;
//    var numtime,t;
//    $(document).bind("scroll", function(event){
//        if($(document).scrollTop() >= ($(document).height()-$(window).height()) ){
//            if(move){
//                move = false;
//                GetAjaxData();
//            }
//        }
//    });
        var before_request = 1; // 上一次请求是否已经有返回来, 有才可以进行下一次请求
        var page = 0;
    function GetAjaxData(){
      
        if(before_request == 0)// 上一次请求没回来 不进行下一次请求
             return false;
         before_request = 0;
         ++page;
        $.ajax({
           // async: true,//异步
            type:"get",
           // dataType: "json",//返回json格式的数据
            url:"/index.php?m=Mobile&c=Index&a=ajaxGetMore&p="+page,
            success: function (data) {
               // showLoader();
                if(data){
                    $(".goods-warp").append(data);
                    
                     before_request = 1;
                }
//                setTimeout(function () {
//                    $(".goods-warp").append('<div class="goods-list">\n' +
//                        '                <a href="">\n' +
//                        '                    <div class="goods-img" style="background-image: url(image/img-4.png)"></div>\n' +
//                        '                    <div class="goods-name">苹果6sP4100mAh超长续航多彩金属+1</div>\n' +
//                        '                    <div class="goods-money">￥5999</div>\n' +
//                        '                </a>\n' +
//                        '            </div>\n' +
//                        '            <div class="goods-list">\n' +
//                        '                <a href="">\n' +
//                        '                    <div class="goods-img" style="background-image: url(image/img-5.png)"></div>\n' +
//                        '                    <div class="goods-name">苹果6sP4100mAh超长续航多彩金属+2</div>\n' +
//                        '                    <div class="goods-money">￥5999</div>\n' +
//                        '                </a>\n' +
//                        '            </div>');
//                    hideLoader();
//                    move = true;
//                },2000)
            },

        });
    }
    function showLoader() {
        //显示加载器
        $("#scroller").show();
        numtime=0;
        t=setInterval(function () {
            numtime++;
            switch (numtime){
                case 1 :
                    $("#scroller").html('加载中.');
                    break;
                case 2 :
                    $("#scroller").html('加载中..');
                    break;
                case 3 :
                    $("#scroller").html('加载中...');
                    break;
                case 4 :
                    numtime=0;
                    break;
            }
        },500);
    }
    function hideLoader(){
        //隐藏加载器
        $("#scroller").hide();
        clearInterval(t);
    }
</script>
<!--按需加载-->
<!--滑动倒计时计时器-->
<script>
    var domElement=$(".brand-c-warp").find(".swiper-slide");
    var num=domElement.length;
    console.log('定时器个数='+num);
    //倒计时放置存储
    var timeArr=["2017-12-06 14:16","2017-12-07 15:16","2017-12-08 16:16","2017-12-09 17:16"];
    /*
    * 倒计时器
    * */
    function getRTime(times) {
        for(var i=0;i<num;i++){
            var times = timeArr[i];
            var EndTime = new Date(Date.parse(times.replace(/-/g, "/"))); //截止时间
            var NowTime = new Date();
            var t = EndTime.getTime() - NowTime.getTime();
            var days = parseInt(t / 1000 / 60 / 60 / 24 , 10); //计算剩余的天数
            var h = Math.floor(t / 1000 / 60 / 60 % 24);
            var m = Math.floor(t / 1000 / 60 % 60);
            var s = Math.floor(t / 1000 % 60);
            if(days<=0){
                domElement.eq(i).find(".brand-time .t_d").html("0");
            }else{
                domElement.eq(i).find(".brand-time .t_d").html(days);
            }
            if (t <= 0) {
                domElement.eq(i).find(".brand-time .t_h").html("0" + 0);
                domElement.eq(i).find(".brand-time .t_m").html("0" + 0);
                domElement.eq(i).find(".brand-time .t_s").html("0" + 0);
            } else {
                domElement.eq(i).find(".brand-time .t_h").html(h);
                domElement.eq(i).find(".brand-time .t_m").html(m);
                domElement.eq(i).find(".brand-time .t_s").html(s);
                if (h < 10) {
                    domElement.eq(i).find(".brand-time .t_h").html("0" + h);
                }
                if (m < 10) {
                    domElement.eq(i).find(".brand-time .t_m").html("0" + m);
                }
                if (s < 10) {
                    domElement.eq(i).find(".brand-time .t_s").html("0" + s);
                }
            }
        }

    }
    setInterval(function () {
        getRTime();
    }, 1000);
</script>
<script>
    function getRTime1(times) {
        var times = times;
        var EndTime = new Date(Date.parse(times.replace(/-/g, "/"))); //截止时间
        var NowTime = new Date();
        var t = EndTime.getTime() - NowTime.getTime();
        var h = Math.floor(t / 1000 / 60 / 60 % 24);
        var m = Math.floor(t / 1000 / 60 % 60);
        var s = Math.floor(t / 1000 % 60);
        if (t <= 0) {
            document.getElementById("t_h").innerHTML = 0 + "0";
            document.getElementById("t_m").innerHTML = 0 + "0";
            document.getElementById("t_s").innerHTML = 0 + "0";
        } else {
            document.getElementById("t_h").innerHTML = h + "";
            document.getElementById("t_m").innerHTML = m + "";
            document.getElementById("t_s").innerHTML = s + "";
            if (h < 10) {
                document.getElementById("t_h").innerHTML = "0" + h;
            }
            if (m < 10) {
                document.getElementById("t_m").innerHTML = "0" + m;
            }
            if (s < 10) {
                document.getElementById("t_s").innerHTML = "0" + s;
            }
        }
    }
    console.log($("#time-end").val())
    setInterval(function () {

        getRTime1($("#time-end").val());
    }, 1000);

       function GetRTime2(){
        var text = GetRTime('<?php echo $end_time; ?>');
        if (text== 0){
            $(".daily-l span").text('活动已结束');
        }else{
            $(".daily-l span").text(text);
        }
    }
   /* setInterval(getRTime1,1000);*/
</script>
</body>
</html>