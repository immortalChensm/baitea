<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:41:"./template/mobile/mobile1/cart\index.html";i:1517208521;s:48:"./template/mobile/mobile1/public\new_header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\footer_nav.html";i:1517208521;s:46:"./template/mobile/mobile1/public\wx_share.html";i:1517208522;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection"content="telephone=no, email=no" />
    <title>购物车--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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


<header class="color-fd6600">
    <div class="h-left"><a href="javascript:;"><img src="__STATIC__/newskin/images/qr-code-icon.png"></a></div>
    <div class="h-con">购物车</div>
    <div class="h-right"><a href="JavaScript:;" id='editcart'><span>编辑</span></a></div>
</header>
<style> 

    .loginlater{height:1.5rem;text-align:center;display:flex;justify-content:center;align-items:center}.loginlater img{width:.5rem;margin-right:.1rem}.loginlater span{color:#bfbfbf;font-size:.24rem}.loginlater a{font-size:.24rem;line-height:.6rem;display:block;color:#fff;text-align:center;background-color:#fd6600;width:.8rem;height:.6rem;border-radius:2px;margin-left:.2rem}.thirdlogin{border-top:1px solid #dedede;text-align:center;margin-top:.5rem;position:relative}.thirdlogin h4{font-size:.32rem;font-weight:400;background-color:#fff;display:block;width:1.5rem;position:absolute;left:0;right:0;margin:auto;top:-.25rem;text-align:center}.thirdlogin ul{display:table;margin:0 auto;margin-top:.5rem}.thirdlogin ul li{float:left;text-align:center;font-size:.24rem;margin:0 .8rem}.thirdlogin ul li img{width:.6rem;height:.6rem}.thirdlogin ul li p{padding-top:.24rem}.hotshop{height:.88rem;overflow:hidden;background-color:#f0f2f5;padding-bottom:1rem}.hotshop .thirdlogin h4{color:#666;background-color:#f0f2f5}.guesslike{margin-bottom:1rem}.guesslike .likeshop{background-color:#f0f2f5;overflow:hidden}.guesslike ul li{float:left;width:50%;padding-bottom:.1rem;position:relative}.guesslike ul li:nth-child(2n+1){padding-right:2px}.guesslike ul li:nth-child(2n){padding-left:2px}.guesslike ul li:nth-child(2n+1) .similer-product{float:right}.guesslike ul li:nth-child(2n) .similer-product{float:left}.guesslike ul li .similer-product{background-color:#fff;clear:both;overflow:hidden;display:block;padding-bottom:.24rem;width:100%}.guesslike ul li .similer-product .simidibl{display:block}.guesslike ul li .similer-product img{width:3.5rem;display:block;margin:0 auto;height:3.5rem}.similar-product-text{padding:0 .1rem;display:block;height:.6rem;font-size:.28rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#232326;line-height:1.2;margin-bottom:.1rem}.similar-product-price{color:#f23030;font-size:.24rem;display:block;padding:0 .1rem;position:relative;top:0;height:.3rem;line-height:.3rem}.guesslike .add{text-align:center;font-size:.28rem;background:#f0f2f5;height:.6rem;line-height:.6rem;cursor:pointer}.floor{overflow:hidden}.newchoosecar{bottom:1rem}.newchoosecar .choose-titr{overflow:hidden}.choose-titr{text-align:center;position:relative;padding:.24rem}.chooseebitcard{display:none;position:fixed;z-index:999;bottom:0;background-color:#fff;overflow:hidden;width:100%}.choose-titr{text-align:center;position:relative;padding:.24rem}.choose-titr span{font-size:.32rem}.get_mp span.disable{cursor:default;color:#e9e9e9}.payallb{position:fixed;z-index:99;width:100%;height:.88rem;left:0;bottom:1rem;background-color:#fff}.payit .fr a{position:absolute;right:0;top:0;background-color:#fd6600;color:#fff;font-size:.24rem;text-align:center;line-height:.88rem;width:1.5rem}.payit .alllef{width:100%;padding:0 .24rem;display:flex;align-items:center;font-size:.24rem}.payit .radio{margin-right:.5rem}.newcarfoo .payallb .youbia p{line-height:.44rem;height:.44rem}.payallb .alllef .radio{display:flex;align-items:center}.payallb .alllef .radio input:checked{background-image:url(__STATIC__/newskin/images/yes-selected@2x.png)}.payallb .alllef .radio input{background-color:transparent;display:block;width:.3rem;height:.3rem;background-image:url(__STATIC__/newskin/images/no-selected@2x.png);background-repeat:no-repeat;background-position:center;background-size:cover;margin-right:.1rem}.shopcart-type input{background-color:transparent;display:block;width:.3rem;height:.3rem;background-image:url(__STATIC__/newskin/images/no-selected@2x.png);background-repeat:no-repeat;background-position:center;background-size:cover;margin-right:.1rem}.shopcart-type input:checked{background-image:url(__STATIC__/newskin/images/yes-selected@2x.png)}.lastime{color:#999}#total_fee{color:#fd6600}.shopcart-type{display:none}.get_mp .disable{cursor:default;color:#e9e9e9;opacity:.3}.chooseebitcard{position:fixed;z-index:999;bottom:1rem;overflow:hidden;width:100%}.choose-titr{text-align:center;position:relative;border-bottom:1px solid #eaeaea;width:100%;height:.6rem;padding:0;display:flex;justify-content:center;align-items:center}em{font-style:normal}.choose-titr span{font-size:.3rem;color:#262626}.closer{background:url(__STATIC__/images/clos.png) no-repeat center;width:.4rem;height:.4rem;background-size:cover;display:inline-block;cursor:pointer;position:absolute;right:.24rem;top:0;bottom:0;margin:auto}.c_uscoupon .canus{font-size:.28rem;color:#333}.soldout_cp{display:flex;align-items:center;justify-content:center;padding:0 .24rem;height:2rem}.soldout_cp img{width:1rem;height:1rem;margin-right:.4rem}.soldout_cp p{font-size:.3rem}
</style>
<div class="main main-bg"> 
    <!-- 判断有没有登录和购物车为空 -->
    <?php if(\think\Cookie::get('uname') == ''): ?>
        <div class="loginlater">
            <img src="__STATIC__/images/small_car.png">
            <span>登录后可同步电脑和手机购物车</span>
            <a href="<?php echo U('Mobile/User/login'); ?>">登录</a>
        </div>
        <?php else: ?>
        <div class="loginlater" style="display: none;">
            <img src="__STATIC__/images/small_car.png">
            <span>购物车空空如也，赶紧逛逛吧~</span>
        </div>
    <?php endif; ?>
    <!-- 编辑操作 -->
    <div class="shopcart-type">
        <div class="m-left"><input type="checkbox" id='all'>全选</div>
        <div class="m-right">
            <a href="javascript:;" class="moveCollect">加入收藏</a><a href="javascript:;"  class="deleteGoods">删除</a>
        </div>
    </div>
    <!-- 购物车内容 -->
    <div class="shopcart-warp">
    <?php if(!(empty($storeCartList) || (($storeCartList instanceof \think\Collection || $storeCartList instanceof \think\Paginator ) && $storeCartList->isEmpty()))): if(is_array($storeCartList) || $storeCartList instanceof \think\Collection || $storeCartList instanceof \think\Paginator): $i = 0; $__LIST__ = $storeCartList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$store): $mod = ($i % 2 );++$i;?>
            <div class="shop-list" data-store-id="<?php echo $store['store_id']; ?>">
                <div class="m-top">
                    <div class="a-left">
                        <input type="checkbox" class="check-box checkShop businall" name="checkShop"  value="<?php echo $store['store_id']; ?>">
                        <img src="__STATIC__/newskin/images/ico_home.png">
                        <a href="<?php echo U('Mobile/Store/index',array('store_id'=>$store[store_id])); ?>"><?php echo $store['store_name']; ?><i></i></a>
                    </div>
                    <a class="a-right coupon_click" data-storeid="<?php echo $store['store_id']; ?>" data-storename="<?php echo $store['store_name']; ?>">优惠券</a> 
                </div>
                <div class="cart-warp">
                    <!--同一家店商品列表-->
                    <?php if(is_array($store[cartList]) || $store[cartList] instanceof \think\Collection || $store[cartList] instanceof \think\Paginator): $i = 0; $__LIST__ = $store[cartList];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cart): $mod = ($i % 2 );++$i;?>
                    <div class="cart-list sc_list   orderlistshpop" id="cart_list_<?php echo $cart['id']; ?>">
                        <div class="a-left">
                            <input type="checkbox"  name="checkItem" value="<?php echo $cart['id']; ?>" class="check-box che" <?php if($cart[selected] == 1): ?>checked='checked'<?php endif; ?>  data-goods-id="<?php echo $cart['goods_id']; ?>">
                            <span data-goods-id="<?php echo $cart['goods_id']; ?>" data-goods-cat-id3="<?php echo $cart['goods']['cat_id3']; ?>" class="che <?php if($cart[selected] == 1): ?>check_t<?php endif; ?> checkItem">
                            <div class="a-img" style="background-image: url(<?php echo goods_thum_images($cart['goods_id'],108,108); ?>);" onclick="location.href='<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$cart[goods_id])); ?>'"></div>
                        </div>
                        <div class="a-right">
                            <div class="a-name"><?php echo $cart['goods_name']; ?></div>
                            <div class="a-info" style="height: .3rem;"><span><?php if(is_array($cart[spec_key_name_arr]) || $cart[spec_key_name_arr] instanceof \think\Collection || $cart[spec_key_name_arr] instanceof \think\Paginator): $i = 0; $__LIST__ = $cart[spec_key_name_arr];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$spec_key_name): $mod = ($i % 2 );++$i;?><?php echo $spec_key_name; ?>&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?></span></div>
                            <div class="a-bottom">
                                <span>￥<?php echo $cart['member_goods_price']; ?></span>
                                <div class="num-box get_mp">
                                    <button class="add mp_plus"></button>
                                    <input type="tel" class="mp_mp" name="changeQuantity_<?php echo $cart['id']; ?>" id="changeQuantity_<?php echo $cart['id']; ?>" value="<?php echo $cart['goods_num']; ?>" onkeyup="this.value=this.value.replace(/[^\d]/g,'')">
                                    <button class="ajj mp_minous"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
        <?php endforeach; endif; else: echo "" ;endif; endif; ?>
    </div>
    <!--看看热卖-start-->
    <?php if(empty($storeCartList) || (($storeCartList instanceof \think\Collection || $storeCartList instanceof \think\Paginator ) && $storeCartList->isEmpty())): ?>
        <div class="hotshop">
            <div class="thirdlogin">
                <h4>看看热卖</h4>
            </div>
        </div>
        <div class="floor guesslike" style="margin-bottom:0px;">
            <div class="likeshop">
                <ul>
                    <?php
                                   
                                $md5_key = md5("select * from __PREFIX__goods where is_recommend=1 and is_on_sale = 1 and goods_state = 1 order by sort desc limit 30");
                                $result_name = $sql_result_goods = S("sql_".$md5_key);
                                if(empty($sql_result_goods))
                                {                            
                                    $result_name = $sql_result_goods = \think\Db::query("select * from __PREFIX__goods where is_recommend=1 and is_on_sale = 1 and goods_state = 1 order by sort desc limit 30"); 
                                    S("sql_".$md5_key,$sql_result_goods,31104000);
                                }    
                              foreach($sql_result_goods as $k=>$goods): ?>
                        <li>
                            <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$goods[goods_id])); ?>">
                                <div class="similer-product">
                                    <img src="<?php echo goods_thum_images($goods[goods_id],192,192); ?>">
                                    <span class="similar-product-text"><?php echo $goods['goods_name']; ?></span>
                                    <span class="similar-product-price">
                                        ¥
                                        <span class="big-price"><?php echo $goods['shop_price']; ?></span>
                                        <span class="small-price">.00</span>
                                    </span>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="add">热卖商品实时更新，常回来看看哟~</div>
        </div>
    <?php endif; ?>
    <!--底部结算-->
    <?php if(!(empty($storeCartList) || (($storeCartList instanceof \think\Collection || $storeCartList instanceof \think\Paginator ) && $storeCartList->isEmpty()))): ?>
        <div class="foohi foohiext newcarfoo">
            <div class="payit ma-to-20 payallb">
                <div class="fl alllef">
                    <div class="radio fl">
                        <input class="check-box" name="checkboxes" type="checkbox" id='moneyall'>
                        <span class="all">全选</span>
                    </div>
                    <div class="youbia">
                        <p><span class="pmo">总价：</span><span>￥</span><span id="total_fee">0.00</span></p>
                        <p class="lastime"><span id="goods_fee">节省：￥0.00</span></p>
                    </div>
                </div>
                <div class="fr">
                    <a href="javascript:void(0);" onclick="return cart_submit()">去结算(<span id="goods_num">0</span>)</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!--优惠券-->
    <div class="chooseebitcard newchoosecar coupongg" >
        <div class="choose-titr">
            <span>店铺：<em id="cl"></em></span>
            <i class="closer"></i>
        </div>
        <div class="soldout_cp p" id="emptyCoupon" style="display: none">
            <img class="nmy" src="__STATIC__/images/nmy.png" alt="" />
            <p class="nzw">暂无可领的优惠券</p>
        </div>
        <div class="c_uscoupon">
            <div class="maleri30">
                <div class="no_get_coupon"><p class="canus" id="no_get_coupon">可领优惠劵<span>（以下是您账户可领的优惠劵）</span></p></div>
                <div class="get_coupon"><p class="canus" id="get_coupon">已领取或不能领取优惠劵<span>（以下是您已领取或不能领取优惠劵）</span></p></div>
            </div>
        </div>
    </div>
</div>
<div style="height: .9rem;"></div>
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
        <li class="active">
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
<script>
    $(".main-bg").css("min-height",$(window).height());
    if($(".shop-list").length>0){
        $(".loginlater").hide();
    }else{
        $(".loginlater").show();
    }
</script>
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    //更改购物车请求事件
    function changeNum(obj){
        var checkall = $(obj).parents('.orderlistshpop').find('.che');
        if(!checkall.hasClass('check_t')){
            checkall.toggleClass('check_t');
            initCheckBox();
        }
        var input = $(obj).parents(".orderlistshpop").find('.get_mp').find('input');
        var cart_id = input.attr('id').replace('changeQuantity_','');
        var goods_num = input.attr('value');
        var cart = new CartItem(cart_id, goods_num, 1);
        $.ajax({
            type: "POST",
            url: "<?php echo U('Mobile/Cart/changeNum'); ?>",//+tab,
            dataType: 'json',
            data: {cart: cart},
            success: function (data) {
                if(data.status == 1){
                    AsyncUpdateCart();
                }else{
                    input.val(data.result.limit_num);
                    input.attr('value',data.result.limit_num);
                    layer.open({
                        content: data.msg
                        ,btn: ['确定']
                    });
                    initDecrement();
                }
            }
        });
    }
    //点击结算
    function cart_submit() {
        //获取选中的商品个数
        var j = 0;
        $('input[name^="checkItem"]:checked').each(function () {
            j++;
        });
        //选择数大于0
        if (j > 0) {
            //跳转订单页面
            window.location.href = "<?php echo U('Mobile/Cart/cart2'); ?>"
        } else {
            layer.open({content: '请选择要结算的商品！', time: 2});
            return false;
        }
    }
    //购物车对象
    function CartItem(id, goods_num,selected) {
        this.id = id;
        this.goods_num = goods_num;
        this.selected = selected;
    }
    //初始化计算订单价格
    function AsyncUpdateCart(){
        var cart = new Array();
        var inputCheckItem = $("input[name^='checkItem']");
        inputCheckItem.each(function(i,o){
            
            var id = $(this).attr("value");
            var goods_num = $(this).parents('.sc_list').find("input[id^='changeQuantity']").attr('value');
            if ($(this).attr("checked")) {
                var cartItemCheck = new CartItem(id,goods_num,1);
                cart.push(cartItemCheck);
            }else{
                var cartItemNoCheck = new CartItem(id,goods_num,0);
                cart.push(cartItemNoCheck);
            }
        })
        $.ajax({
            type : "POST",
            url:"<?php echo U('Mobile/Cart/AsyncUpdateCart'); ?>",
            dataType:'json',
            data: {cart: cart},
            success: function(data){
                if(data.status == 1){
                    $('#goods_num').html(data.result.goods_num);
                    $('#total_fee').html(data.result.total_fee);
                    $('#goods_fee').html('节省：￥'+data.result.goods_fee);
                    var storeCartList =  data.result.storeCartList;
                    var cartList = null;
                    if(storeCartList.length > 0){
                        for(var i = 0; i < storeCartList.length; i++){
                            cartList = storeCartList[i].cartList;
                            $('#store_'+cartList[0].store_id+'_total_price').empty().html('￥'+storeCartList[i].store_total_price);
                            if(storeCartList[i].store_cut_price > 0){
                                $('#store_'+cartList[0].store_id+'_cut_price').empty().html('减：'+storeCartList[i].store_cut_price);
                            }else{
                                $('#store_'+cartList[0].store_id+'_cut_price').empty();
                            }
                            for(var j = 0; j < cartList.length; j++){
                                $('#cart_'+cartList[j].id+'_goods_price').empty().html('￥'+cartList[j].goods_price);
                                $('#cart_'+cartList[j].id+'_total_price').empty().html('￥'+cartList[j].total_fee);
                            }
                        }
                    }
                }else{
                    $('#goods_num').empty().html(data.result.goods_num);
                    $('#total_fee').empty().html(data.result.total_fee);
                    $('#goods_fee').empty().html('节省：￥'+data.result.goods_fee);
                }
            }
        });
    }

    //更改购买数量对减购买数量按钮的操作
    function initDecrement(){
        $("input[id^='changeQuantity']").each(function(i,o){
            if($(o).val() == 1){
                $(o).parents('.get_mp').find('.mp_minous').addClass('disable');
            }
            if($(o).val() > 1){
                $(o).parents('.get_mp').find('.mp_minous').removeClass('disable');
            }
        })
    }
    /**
     * 检测选项框
     */
    function initCheckBox(){
        $("input[name^='checkShop']").each(function(i,o){
            var store_id = $(this).attr('value');
            var isAllCheck = true;
            $('.radio_store_'+store_id).find("input[name^='checkItem']").each(function(i,o){
                if ($(this).attr("checked") != 'checked') {
                    isAllCheck = false;
                }
            })
            if(isAllCheck == false){
                $(this).removeAttr('checked');
                $(this).parent().find('.che').removeClass('check_t');
            }else{
                $(this).attr('checked', 'checked');
                $(this).parent().find('.che').addClass('check_t');
            }
        })
        var checkBoxsFlag = true;
        $("input[name^='checkItem']").each(function(i,o){
            if ($(this).attr("checked") != 'checked') {
                checkBoxsFlag = false;
            }
        })
        if(checkBoxsFlag == false){
            $("input[name^='checkboxes']").each(function(i,o){
                $(this).removeAttr('checked');
                $(this).parent().find('.che').removeClass('check_t');
            })
        }else{
            $("input[name^='checkboxes']").each(function(i,o){
                $(this).attr('checked', 'checked');
                $(this).parent().find('.che').addClass('check_t');
            })
        }
    }
    function getStoreCoupon(){
        var store_ids = new Array();
        var goods_ids = new Array();
        var goods_category_ids = new Array();
        $('.shop-list').each(function(i,o){
            store_ids.push($(this).attr('data-store-id'));
        })
        $('.checkItem').each(function(i,o){
            goods_category_ids.push($(this).attr('data-goods-cat-id3'));
            goods_ids.push($(this).attr('data-goods-id'));
        })
        $.ajax({
            type : "POST",
            url:"<?php echo U('Mobile/Cart/getStoreCoupon'); ?>",//+tab,
            dataType:'json',
            data:{'store_ids':store_ids,goods_ids:goods_ids,goods_category_ids:goods_category_ids},
            success: function(data){
                //获取到优惠券的信息
                var newDate = new Date();
                if(data.status == 1){
                    var coupon_no_get_html = '';
                    var coupon_get_html = '';
                    var send_start_time = '';
                    var send_end_time = '';
                    for(var j = 0;j < data.result.length;j++){
                        newDate.setTime(parseInt(data.result[j].send_start_time)*1000);
                        send_start_time =newDate.toLocaleDateString();
                        newDate.setTime(parseInt(data.result[j].send_end_time)*1000);
                        send_end_time = newDate.toLocaleDateString();
                        //未领取
                        if(data.result[j].is_get == 0){
                            coupon_no_get_html += '<div class="cuptyp storeid_'+data.result[j].store_id+'"> <div class="le_pri"> <h1><em>￥</em>'+data.result[j].money+'</h1> <p>满'+data.result[j].condition+'元可用</p>' +
                                    ' </div> <div class="ri_int"> <div class="to_two canget"> <span class="ba">商城券</span> <span class="foi">'+data.result[j].name+'</span> </div>' +
                                    ' <div class="bo_two"> <span class="cp9">'+send_start_time+'-'+send_end_time+' </span> ' +
                                    '<a href="javascript:;" data-coupon-id="'+data.result[j]['id']+'" onclick="getCoupon(this);">点击领取</a> </div> </div> </div>';
                        }
                    }
                    if(coupon_no_get_html == ''){
                        $('#emptyCoupon').show();
                        $('#no_get_coupon').hide();
                    }else{
                        $('#emptyCoupon').hide();
                        $('#no_get_coupon').show().after(coupon_no_get_html);
                    }
                    if(coupon_get_html == ''){
                        $('#get_coupon').hide();
                    }else{
                        $('#get_coupon').show().after(coupon_get_html);
                    }
                }else{
                    $('#emptyCoupon').show();
                    $('#no_get_coupon').hide();
                    $('#get_coupon').hide();
                }
            }
        });
    }
    //领取优惠券
    function getCoupon(obj){
        var coupon_id = $(obj).attr('data-coupon-id');
        $.ajax({
            type : "POST",
            url:"<?php echo U('Mobile/Activity/getCoupon'); ?>",
            dataType:'json',
            data: {coupon_id: coupon_id},
            success: function(data){
                if(data.status == 1){
                    $(obj).removeAttr('onclick').html('已领取');
                }else{
                    layer.open({
                        content: data.msg
                        ,btn: '确定'
                    });
                }
            }
        });
    }

    //优惠券
    $(function(){
        /*
        *商品数量加减
        */
        //加数量
        $('.mp_minous').click(function(){
            if(!$(this).hasClass('disable')){
                var inputs = $(this).siblings('.mp_mp');
                var val = inputs.val();
                if(val>0){
                    val--;
                }
                inputs.val(val);
                inputs.attr('value',val);
                initDecrement();
                changeNum(this);
            }
        })
        //减数量
        $('.mp_plus').click(function(){
            var inputs = $(this).siblings('.mp_mp');
            var val = inputs.val();
            val++;
            if(val > 200){
                val = 200;
                layer.msg("购买商品数量不能大于200",{icon:2});
            }
            inputs.val(val);
            inputs.attr('value',val);
            initDecrement();
            changeNum(this);
        })
        $(document).on("blur", '.get_mp input', function (e) {
            var changeQuantityNum = parseInt($(this).val());
            if(changeQuantityNum <= 0){
                layer.open({
                    content: '商品数量必须大于0'
                    ,btn: '确定'
                });
                $(this).val($(this).attr('value'));
            }else{
                $(this).attr('value', changeQuantityNum);
            }
            initDecrement();
            changeNum(this);
        })
        $(document).on('click','.coupon_click',function(){
            cover();
            $('.coupongg').show();
            $('html,body').addClass('ovfHiden');
            var storeid = $(this).data('storeid');  //当前店铺ID
            var storename = $(this).data('storename');  //当前店铺名
            $('.cuptyp').hide();
            $('.storeid_'+storeid).show();  //显示当前店铺下的优惠券
            var no_get_coupon_length = $('.no_get_coupon').find(".storeid_"+storeid+":visible").length;
            var get_coupon_length = $('.get_coupon').find(".storeid_"+storeid+":visible").length;
            if(no_get_coupon_length == 0){
                $('#no_get_coupon').hide();
            }else{
                $('#no_get_coupon').show();
            }
            if(get_coupon_length == 0){
                $('#get_coupon').hide();
            }else{
                $('#get_coupon').show();
            }
            $('#cl').html(storename);
        })
        //关闭弹窗
        $(document).on('click','.closer',function(){
            undercover();
            $('.newchoosecar').hide();
            $('html,body').removeClass('ovfHiden');
        })
    })
</script>
<!-- 新js -->
<script>
    $(function(){
        var editflag=true;
        //初始化
        AsyncUpdateCart();
        getStoreCoupon();
        initDecrement();
        initCheckBox()
        //顶部点击编辑
        $("#editcart").click(function(){
            var that=this;
            if(editflag){
                $(".shopcart-type").show().css("display",'flex');
                $(that).children('span').html('完成');
                editflag=false;
            }else{
                $(".shopcart-type").hide();
                $(that).children('span').html('编辑');
                editflag=true;
            }
        });
        //点击上方的全选
        $("#all").click(function(){
            if($(this).is(':checked')){
                $("input[type=checkbox]").prop('checked',true);
            }else{
                $("input[type=checkbox]").prop('checked',false);
            }
            AsyncUpdateCart()
            
        });
        //点击商家的全选
        $(".businall").click(function(){
            if($(this).is(':checked')){
                $(this).parents('.shop-list').find("input[type=checkbox]").prop('checked',true);
            }else{
                $(this).parents('.shop-list').find("input[type=checkbox]").prop('checked',false);
            }
            AsyncUpdateCart()
        })
        //点击结算的全选
        $("#moneyall").click(function(){
            if($(this).is(':checked')){
                $("input[type=checkbox]").prop('checked',true);
            }else{
                $("input[type=checkbox]").prop('checked',false);
            }
            AsyncUpdateCart()        
        });
        //点击选项框
        $('.che').on("click", function (e) {
            if($(this).attr("checked")===''){
                $(this).prop('checked',true);
            }else{
                $(this).removeAttr('checked');
            }
        })
        //删除购物车商品事件
        $(document).on("click", '.deleteGoods', function (e) {
            var cart_ids = new Array();
             $('input[name^="checkItem"]:checked').each(function (i,o) {
                cart_ids.push($('input[name^="checkItem"]:checked').eq(i).val());
            });
            layer.open({
                content: '确定要删除此商品吗'
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    layer.close(index);
                    $.ajax({
                        type : "POST",
                        url:"<?php echo U('Mobile/Cart/delete'); ?>",
                        dataType:'json',
                        data: {cart_ids: cart_ids},
                        success: function(data){
                            if(data.status == 1){
                                for (var i = 0; i < cart_ids.length; i++) {
                                    $('#cart_list_' + cart_ids[i]).remove();
                                }
                                location.reload();
                            }else{
                                layer.msg(data.msg,{icon:2});
                            }
                            AsyncUpdateCart();
                        }
                    });
                }
            });
        })
        //移到我的收藏
        $(document).on("click", '.moveCollect', function (e) {
            if(getCookie('user_id') == ''){
                location.href = "<?php echo U('Mobile/User/login'); ?>";
                return;
            }
            var goods_id = new Array();
             $('input[name^="checkItem"]:checked').each(function (i,o) {
                goods_id.push($('input[name^="checkItem"]:checked').eq(i).attr('data-goods-id'));
            });
            $.ajax({
                type: "POST",
                url: "<?php echo U('Mobile/Goods/collect_goods'); ?>",//+tab,
                data: {goods_id: goods_id},//+tab,
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                    layer.open({
                        content: data.msg,
                        btn: '确定'
                    });
                }
            });
            $('.ui-dialog-close').trigger('click');
        })
    })
</script>
</body>
</html>
