<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:35:"./template/pc/web1/index\index.html";i:1517208528;s:37:"./template/pc/web1/public\header.html";i:1517208528;s:44:"./template/pc/web1/public\header_search.html";i:1517208528;s:37:"./template/pc/web1/public\footer.html";i:1517208528;s:43:"./template/pc/web1/public\sidebar_cart.html";i:1517208528;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>首页-<?php echo $tpshop_config['shop_info_store_title']; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="keywords" content="<?php echo $tpshop_config['shop_info_store_keyword']; ?>"/>
	<meta name="description" content="<?php echo $tpshop_config['shop_info_store_desc']; ?>"/>
	<link rel="shortcut  icon" type="image/x-icon" href="<?php echo $tpshop_config['shop_info_store_ico']; ?>" media="screen"/>
	<link rel="stylesheet" type="text/css" href="__STATIC__/css/tpshop.css"/>
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/base.css"/>
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/function.css"/>
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/idangerous.swiper.css"/>
	<script src="__STATIC__/js/jquery-1.11.3.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="__PUBLIC__/js/global.js"></script>
    <script src="__STATIC__/js/idangerous.swiper.min.js"></script>
</head>
<body>
	<!--顶部广告-s-->
<!-- 	<?php $pid =1;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1522119600 and end_time > 1522119600 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
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
		<div class="topic-banner" style="background: #f37c1e;">
			<div class="w1224">
				<a href="<?php echo $v['ad_link']; ?>" <?php if($v['target'] == 1): ?>target="_blank"<?php endif; ?>>
					<img src="<?php echo $v[ad_code]; ?>"/>
				</a>
				<i onclick="$('.topic-banner').hide();"></i>
			</div>
		</div>
	<?php endforeach; ?> -->
	<!--顶部广告-e-->
	<!--header-s-->
	<!-- 新浪获取ip地址 -start-->
<?php if(\think\Cookie::get('province_id') <= 0): ?>
	<script src="http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=<?php echo \think\Request::instance()->ip(); ?>"></script>
	<script type="text/JavaScript">
		doCookieArea(remote_ip_info);
	</script>
<?php endif; ?>
<div class="tpshop-tm-hander p">
	<div class="top-hander p">
		<div class="w1224 pr">
			<link rel="stylesheet" href="__STATIC__/css/location.css" type="text/css"><!-- 收货地址，物流运费 -->
			<div class="fl">
				<div class="ls-dlzc fl nologin">
					<a href="<?php echo U('Home/user/login'); ?>">登录</a>
					<a class="red" href="<?php echo U('Home/user/reg'); ?>">注册</a>
				</div>
				<div class="ls-dlzc fl islogin">
					<a class="red userinfo" href="<?php echo U('Home/user/index'); ?>"></a>
					<a href="<?php echo U('Home/user/logout'); ?>">退出</a>
				</div>
				<div class="fl spc" style="margin-top:10px"></div>
				<div class="sendaddress pr fl">
					<?php if(strtolower(ACTION_NAME) != 'goodsinfo'): ?>
						<!-- 收货地址，物流运费 -start-->
						<ul class="list1" >
							<li class="jaj"><span>配&nbsp;&nbsp;送：</span></li>
							<li class="summary-stock though-line" style="margin-top:-1px">
								<div class="dd" style="border-right:0px;">
									<div class="store-selector add_cj_p">
										<div class="text" style="margin-top:3px;border-left: 0 !important; cursor: pointer;"><div></div><b></b></div>
										<div onclick="$(this).parent().removeClass('hover')" class="close"></div>
									</div>
								</div>
							</li>
						</ul>
						<!--<i class="jt-x"></i>-->
						<!-- 收货地址，物流运费 -end-->
						<!--------收货地址，物流运费-开始-------------->
						<script src="__PUBLIC__/js/locationJson.js"></script>
						<script src="__STATIC__/js/location.js"></script>
						<!--------收货地址，物流运费--结束-------------->
					<?php endif; ?>
				</div>
			</div>
			<div class="top-ri-header fr">
				<ul>
					<li><a target="_blank" href="<?php echo U('Home/Order/order_list'); ?>">我的订单</a></li>
					<li class="spacer"></li>
					<li><a target="_blank" href="<?php echo U('Home/User/account'); ?>">我的积分</a></li>
					<li class="spacer"></li>
					<li><a target="_blank" href="<?php echo U('Home/User/coupon'); ?>">我的优惠券</a></li>
					<li class="spacer"></li>
					<li><a target="_blank" href="<?php echo U('Home/User/goods_collect'); ?>">我的收藏</a></li>
					<li class="spacer"></li>
					<li class="hover-ba-navdh">
						<div class="nav-dh">
							<span>客户服务</span>
							<i class="jt-x"></i>
							<div class="conta-hv-nav">
								<ul>
									<li><a href="<?php echo U('Seller/Index/index'); ?>">商家后台</a></li>
									<li><a href="<?php echo U('Home/Newjoin/index'); ?>">商家帮助</a></li>
								</ul>
							</div>
						</div>
					</li>
					<li class="spacer"></li>
					<li class="navoxth">
						<div class="nav-dh">
							<i class="fl ico"></i>
							<span>掌心</span>
							<i class="jt-x"></i>
						</div>
						<div class="sub-panel m-lst">
							<p>扫一扫，下载掌心客户端</p>
							<dl>
								<dt class="fl mr10"><a target="_blank" href=""><img height="80" width="80" src="__STATIC__/images/qrcode_vmall_app01.png"></a></dt>
								<dd class="fl mb10"><a target="_blank" href=""><i class="andr"></i> Andiord</a></dd>
								<dd class="fl"><a target="_blank" href=""><i class="iph"></i> iPhone</a></dd>
							</dl>
						</div>
					</li>
					<li class="spacer"></li>
					<li class="wxbox-hover">
						<a target="_blank" href="">关注我们：</a>
						<img class="wechat-top" src="__STATIC__/images/wechat.png" alt="">
						<div class="sub-panel wx-box">
							<span class="arrow-b">◆</span>
							<span class="arrow-a">◆</span>
							<p class="n"> 扫描二维码 <br>  关注掌心官方微信 </p>
							<img src="__STATIC__/images/qrcode1.png">
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="nav-middan-z tphsop2_0 p">
		<div class="header w1224">
			<div class="ecsc-logo">
	<a href="/" class="logo" style="width:260px;margin-top:8px;height:80px;">
        <img src="<?php echo $tpshop_config['shop_info_store_logo']; ?>" style="width: 155px;">
        <!-- <img src="__STATIC__/images/new/logo-fs.png" style="width: 105px;"> -->
    </a>
</div>
<style>
	.ecsc-search-form{
		border-color: #eaeaea;width: 460px;height: 40px;border-width: 1px;
	}
	.search-select-h{
		border-width: 1px;
		border-color: #eaeaea;
	}
	body .search-select-h ul{
		border-color: #eaeaea;border-width: 1px;left: -1px;width: 61px;
	}
	body .ecsc-search-button{
		width: 60px;height: 38px;background-image: url(__STATIC__/images/new/search.png);
		background-repeat: no-repeat;background-position: center;
		background-color: #fff;border-left: 1px solid #eaeaea;
	}
	body .ecsc-search-input{
		height: 100%;padding-right: 0;
	}
	body .search-select-h > span{
		height: 38px;line-height: 38px;
	}
	body .search-select-h > span .jt-x{
		top: 17px;
	}
	body .tpshop2_0_nav{
		margin-top: 15px;
	}
	.tphsop2_0 .u-g-cart{
		height: 40px;    border: 1px solid #eaeaea;
	}
	body .tphsop2_0 .u-g-cart .c-num{
		height: 38px;
    	line-height: 38px;color: #666;
	}
	.u-mn-cart{
		top: 38px;
	}
	.tphsop2_0 .count{
		border-radius: 2px;top: 0;width: 20px;text-align: center;height: 20px;line-height: 20px;padding: 0;
	}
	.tphsop2_0 .car2_0{
		width: 21px;
		background-size: contain;
	}
	body .usertpshop .login_index a{
		border-radius: 0;border-color: #fd6600; color: #fd6600;
	}
	.usertpshop .login_index a:hover{
		background-color:#fd6600;color: #fff;
	}
	.top-ri-header ul li>a:hover{
		color: #fd6600;
	}
	.bulletin .content a:hover{
		color: #fd6600;
	}
	.tab-lis-2 .qrcode .qrewm{
		font-size: 12px;
	}
	.dl_login .hinihdk p{
		background-color: #fff;font-size: 12px;width: 100%;text-align: center;
	}
	.dl_login .hinihdk{
		height: 140px;
	}
	.shop-car .tab-cart-tip-warp-box .tab-cart-tip-warp .share-side1{
		left: 0;
	}

</style>
<div class="ecsc-search">
	<form id="sourch_form" name="sourch_form" method="post" action="<?php echo U('Home/Goods/search'); ?>" class="ecsc-search-form">
		<div class="search-select-h">
			<span><em>商品</em><i class="jt-x"></i></span>
			<ul id="select-h">
				<li rel="<?php echo U('Home/Goods/search'); ?>">商品</li>
				<li rel="<?php echo U('Home/Index/street'); ?>">店铺</li>
				<!--<li>服务</li>-->
			</ul>
			<script>
				var select = $('#select-h');
				$('.search-select-h').mouseenter(function(){
					select.show();
				});
				$('.search-select-h').mouseleave(function(){
					select.hide();
				});
				select.find('li').click(function() {
					select.hide();
					$('#sourch_form').attr('action',$(this).attr("rel"));
					$('.search-select-h').find('em').text($(this).text());
				});
			</script>
		</div>
		<input autocomplete="off" name="q" id="q" type="text" value="<?php echo \think\Request::instance()->param('q'); ?>" placeholder="搜索关键字" class="ecsc-search-input">
		<button type="button" class="ecsc-search-button" ></button>
		<div class="candidate p">
			<ul id="search_list"></ul>
		</div>
		<script type="text/javascript">

            $('.ecsc-search-button').on('click',function(){
                if($.trim($('#q').val()) != ''){
                    $('#sourch_form').submit();
                }else{
                    $('#q').css('background-color','#F6D4CB');
                    $('#q').attr('placeholder','请输入关键字');
                }
            })
			;(function($){
				$.fn.extend({
					donetyping: function(callback,timeout){
						timeout = timeout || 1e3;
						var timeoutReference,
								doneTyping = function(el){
									if (!timeoutReference) return;
									timeoutReference = null;
									callback.call(el);
								};
						return this.each(function(i,el){
							var $el = $(el);
							$el.is(':input') && $el.on('keyup keypress',function(e){
								if (e.type=='keyup' && e.keyCode!=8) return;
								if (timeoutReference) clearTimeout(timeoutReference);
								timeoutReference = setTimeout(function(){
									doneTyping(el);
								}, timeout);
							}).on('blur',function(){
								doneTyping(el);
							});
						});
					}
				});
			})(jQuery);

			$('.ecsc-search-input').donetyping(function(){
				search_key();
			},500).focus(function(){
				var search_key = $.trim($('#q').val());
				if(search_key != ''){
					$('.candidate').show();
				}
			});
			$('.candidate').mouseleave(function(){
				$(this).hide();
			});

			function searchWord(words){
				$('#q').val(words);
				$('#sourch_form').submit();
			}
			function search_key(){
				var search_key = $.trim($('#q').val());
				if(search_key != ''){
					$.ajax({
						type:'post',
						dataType:'json',
						data: {key: search_key},
						url:"<?php echo U('Home/Api/searchKey'); ?>",
						success:function(data){
							if(data.status == 1){
								var html = '';
								$.each(data.result, function (n, value) {
									html += '<li onclick="searchWord(\''+value.keywords+'\');"><div class="search-item">'+value.keywords+'</div><div class="search-count">约'+value.goods_num+'个商品</div></li>';
								});
//								html += '<li class="close"><div class="search-count">关闭</div></li>';
								$('#search_list').empty().append(html);
								$('.candidate').show();
							}else{
								$('#search_list').empty();
							}
						}
					});
				}
			}
		</script>
	</form>
	<div class="keyword">
		<ul>
			<?php if(is_array($tpshop_config['hot_keywords']) || $tpshop_config['hot_keywords'] instanceof \think\Collection || $tpshop_config['hot_keywords'] instanceof \think\Paginator): if( count($tpshop_config['hot_keywords'])==0 ) : echo "" ;else: foreach($tpshop_config['hot_keywords'] as $k=>$wd): ?>
				<li>
					<a href="<?php echo U('Home/Goods/search',array('q'=>$wd)); ?>" target="_blank"><?php echo $wd; ?></a>
				</li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
</div>
<div class="shopingcar-index fr">
	<div class="u-g-cart fr fixed" id="hd-my-cart">
		<a href="<?php echo U('Home/Cart/index'); ?>">
			<p class="c-num">
				<i class="car2_0"></i>
				<span>我的购物车</span>
				<span class="count cart_quantity" id="cart_quantity"></span>
			</p>
		</a>
		<div class="u-fn-cart u-mn-cart" id="show_minicart">
			<div class="minicartContent" id="minicart">
			</div>
		</div>
	</div>
</div>
		</div>
	</div>
    <style>
        .categorys .cata-nav .cata-nav-name {
            height: 32px;
        }
        .cata-nav .item-left .navicon {
            vertical-align:0px;
        }
        .categorys .item-left a {
            line-height: 32px;
            height: 32px;
            font-size: 13px;
            vertical-align:middle;
        }
    </style>
	<div class="nav tpshop2_0_nav p">
		<div class="w1224 p">
			<div class="categorys home_categorys">
				<div class="dt">
					<a href="<?php echo U('Home/Goods/goodsList'); ?>" target="_blank">全部商品分类</a>
				</div>
				<!--全部商品分类-s-->
                                <div class="dd" id="catgory-show">
					<div class="cata-nav" id="cata-nav">
						<?php if(is_array($goods_category_tree) || $goods_category_tree instanceof \think\Collection || $goods_category_tree instanceof \think\Paginator): $k = 0; $__LIST__ = $goods_category_tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
							<div class="item fore1">
								<div class="item-left">
									<div class="cata-nav-name">
										<em class="navicon nav-<?php echo $k-1; ?>"></em>
										<a href="<?php echo U('Home/Goods/goodsList',array('id'=>$vo[id])); ?>" title="<?php echo $vo['name']; ?>"><?php echo $vo['name']; ?></a>
									</div>
								</div>
								<div class="cata-nav-layer">
									<div class="cata-nav-left">
										<div class="item-channels">
											<div class="channels">
												<?php if(is_array($vo['hmenu']) || $vo['hmenu'] instanceof \think\Collection || $vo['hmenu'] instanceof \think\Paginator): if( count($vo['hmenu'])==0 ) : echo "" ;else: foreach($vo['hmenu'] as $key=>$hm): ?>
													<a href="<?php echo U('Home/Goods/goodsList',array('id'=>$hm[id])); ?>" target="_blank"><?php echo $hm['name']; ?><i>&gt;</i></a>
												<?php endforeach; endif; else: echo "" ;endif; ?>
											</div>
										</div>
										<div class="subitems">
											<?php if(is_array($vo['tmenu']) || $vo['tmenu'] instanceof \think\Collection || $vo['tmenu'] instanceof \think\Paginator): if( count($vo['tmenu'])==0 ) : echo "" ;else: foreach($vo['tmenu'] as $k2=>$v2): ?>
											<dl>
												<dt><a href="<?php echo U('Home/Goods/goodsList',array('id'=>$v2[id])); ?>" target="_blank"><?php echo $v2['name']; ?><i>&gt;</i></a></dt>
												<?php if(!(empty($v2['sub_menu']) || (($v2['sub_menu'] instanceof \think\Collection || $v2['sub_menu'] instanceof \think\Paginator ) && $v2['sub_menu']->isEmpty()))): ?>
													<dd>
														<?php if(is_array($v2['sub_menu']) || $v2['sub_menu'] instanceof \think\Collection || $v2['sub_menu'] instanceof \think\Paginator): if( count($v2['sub_menu'])==0 ) : echo "" ;else: foreach($v2['sub_menu'] as $key=>$v3): ?>
															<a href="<?php echo U('Home/Goods/goodsList',array('id'=>$v3[id])); ?>" target="_blank"><?php echo $v3['name']; ?></a>
														<?php endforeach; endif; else: echo "" ;endif; ?>
													</dd>
												<?php endif; ?>
											</dl>
											<?php endforeach; endif; else: echo "" ;endif; ?>
											<div class="item-brands">
												<ul>
												</ul>
											</div>
											<div class="item-promotions">
											</div>
										</div>
									</div>
									<div class="cata-nav-rigth">
										<div class="item-brands">
											<ul>
												<?php if(is_array($brand_list) || $brand_list instanceof \think\Collection || $brand_list instanceof \think\Paginator): $i = 0; $__LIST__ = $brand_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;if(($v2[cat_id1] == $vo[id]) AND ($v2[is_hot] == 1)): ?>
														<li>
															<a href="<?php echo U('Home/Goods/goodsList',array('brand_id'=>$v2[id])); ?>" target="_blank" title="<?php echo $v2['name']; ?>">
																<img src="<?php echo $v2['logo']; ?>" width="91" height="40">
															</a>
														</li>
													<?php endif; endforeach; endif; else: echo "" ;endif; ?>
											</ul>
										</div>
										<div class="item-promotions">
											<?php
                                   
                                $md5_key = md5("select * from __PREFIX__goods g inner join __PREFIX__flash_sale as f on g.goods_id = f.goods_id where start_time < $template_now_time and end_time > $template_now_time and status = 1 and cat_id1 = $vo[id] limit 2");
                                $result_name = $sql_result_promote = S("sql_".$md5_key);
                                if(empty($sql_result_promote))
                                {                            
                                    $result_name = $sql_result_promote = \think\Db::query("select * from __PREFIX__goods g inner join __PREFIX__flash_sale as f on g.goods_id = f.goods_id where start_time < $template_now_time and end_time > $template_now_time and status = 1 and cat_id1 = $vo[id] limit 2"); 
                                    S("sql_".$md5_key,$sql_result_promote,31104000);
                                }    
                              foreach($sql_result_promote as $promote_key=>$promote): ?>
												<a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$promote[goods_id])); ?>" target="_blank">
													<img width="181" height="120" src="<?php echo goods_thum_images($promote['goods_id'],181,120); ?>">
												</a>
											<?php endforeach; ?>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
					<script>
						$('#cata-nav').find('.item').hover(function(){
							$(this).addClass('item-left-active').siblings().removeClass('item-left-active');
						},function(){
							$(this).removeClass('item-left-active');
						})
					</script>
				</div>
				<!--全部商品分类-e-->
			</div>
			<div class="navitems" id="nav">
				<ul>
					<li>
						<a href="/" <?php if(CONTROLLER_NAME == 'Index'): ?>class="selected"<?php endif; ?>>首页</a>
					</li>
					<?php
                                   
                                $md5_key = md5("SELECT * FROM `__PREFIX__navigation` where is_show = 1 ORDER BY `sort` DESC");
                                $result_name = $sql_result_v = S("sql_".$md5_key);
                                if(empty($sql_result_v))
                                {                            
                                    $result_name = $sql_result_v = \think\Db::query("SELECT * FROM `__PREFIX__navigation` where is_show = 1 ORDER BY `sort` DESC"); 
                                    S("sql_".$md5_key,$sql_result_v,31104000);
                                }    
                              foreach($sql_result_v as $k=>$v): ?>
						<li>
                            <a href="<?php echo $v[url]; ?>" <?php  if($_SERVER['REQUEST_URI']==str_replace('&amp;','&',$v[url])){ echo "class='selected'";} ?> ><?php echo $v[name]; ?></a>
                        </li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>

	<!--edit-start-->
            
	<div id="myCarousel" class="carousel slide p header-tp tpshop2_0_carousel">
		<ol class="carousel-indicators"></ol>
                <div class="l-f-banner">    
		<div class="carousel-inner">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <?php $pid =10;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1522119600 and end_time > 1522119600 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("6")->select();
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


$c = 6- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
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
                                        <div class="swiper-slide" style="background-image: url(<?php echo $v[ad_code]; ?>)"><a href="<?php echo $v['ad_link']; ?>" style="display: block;width: 100%;height: 100%;"></a></div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="pagination"></div>
                            </div>
<!--				<?php $pid =10;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1522119600 and end_time > 1522119600 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("6")->select();
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


$c = 6- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
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
				<div class="item <?php if($key == 0): ?>active<?php endif; ?>" style="background-color:<?php echo (isset($v['bgcolor']) && ($v['bgcolor'] !== '')?$v['bgcolor']:gray); ?>;" >
					<a class="item-image" href="<?php echo $v['ad_link']; ?>" <?php if($v['target'] == 1): ?>target="_blank"<?php endif; ?> ><img src="<?php echo $v[ad_code]; ?>" alt="" /></a>
				</div>
			<?php endforeach; ?>-->
		</div>
		<div class="right-sidebar p">
			<div class="usertpshop">
				<div class="head_index">
					<a href="<?php echo U('Home/User/index'); ?>" target="_blank">
						<img class="head_pic" src="<?php echo (isset($user['had_pic']) && ($user['had_pic'] !== '')?$user['had_pic']:'__STATIC__/images/default.jpg'); ?>" alt="" />
					</a>
				</div>
				<p class="welcome nologin">您好，欢迎来到掌心商城！</p>
				<p class="welcome islogin">HI，<span class="userinfo"></span></p>
				<div class="login_index">
					<a class="nologin" href="<?php echo U('Home/User/login'); ?>" target="_blank">请登录</a>
					<a class="add_newperson" href="<?php echo U('Home/Activity/coupon_list'); ?>">新人有礼</a>
					<a class="islogin add_newperson" href="<?php echo U('Home/User/index'); ?>" target="_blank">会员中心</a>
				</div>
			</div>
			<div class="bulletin">
				<div class="tit_notice">
					<div class="bn_box">
						<?php
                                   
                                $md5_key = md5("select * from `__PREFIX__article` where cat_id = 6 and is_open=1 limit 4");
                                $box_ad = $sql_result_item = S("sql_".$md5_key);
                                if(empty($sql_result_item))
                                {                            
                                    $box_ad = $sql_result_item = \think\Db::query("select * from `__PREFIX__article` where cat_id = 6 and is_open=1 limit 4"); 
                                    S("sql_".$md5_key,$sql_result_item,31104000);
                                }    
                              foreach($sql_result_item as $key=>$item): endforeach; 
                                   
                                $md5_key = md5("select * from `__PREFIX__article` where cat_id = 20 and is_open=1 limit 4");
                                $box_prom = $sql_result_item = S("sql_".$md5_key);
                                if(empty($sql_result_item))
                                {                            
                                    $box_prom = $sql_result_item = \think\Db::query("select * from `__PREFIX__article` where cat_id = 20 and is_open=1 limit 4"); 
                                    S("sql_".$md5_key,$sql_result_item,31104000);
                                }    
                              foreach($sql_result_item as $key=>$item): endforeach; if(!(empty($box_ad) || (($box_ad instanceof \think\Collection || $box_ad instanceof \think\Paginator ) && $box_ad->isEmpty()))): ?>
							<em class="action box_ad">公告</em>
						<?php endif; if(!(empty($box_prom) || (($box_prom instanceof \think\Collection || $box_prom instanceof \think\Paginator ) && $box_prom->isEmpty()))): ?>
							<em class="box_prom">促销</em>
						<?php endif; ?>
					</div>
				</div>
				<div class="content box_ad_content">
					<?php if(is_array($box_ad) || $box_ad instanceof \think\Collection || $box_ad instanceof \think\Paginator): $i = 0; $__LIST__ = $box_ad;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
						<a href="<?php echo U('Home/Article/detail',array('article_id'=>$v[article_id])); ?>" target="_blank"><?php echo $v[title]; ?></a>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
				<div class="content box_prom_content" style="display: none">
					<?php if(is_array($box_prom) || $box_prom instanceof \think\Collection || $box_prom instanceof \think\Paginator): $i = 0; $__LIST__ = $box_prom;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
						<a href="<?php echo U('Home/Article/detail',array('article_id'=>$v[article_id])); ?>" target="_blank"><?php echo $v[title]; ?></a>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
				<div class="tit_notice">
					<div class="bn_box">
						<em>快捷入口</em>
					</div>
				</div>
				<div class="six_entrance">
					<table border="" cellspacing="0" cellpadding="0">
						<tr>
							<td>
								<div class="access">
									<a href="<?php echo U('Home/User/visit_log'); ?>" target="_blank">
										<i class="mybrowse"></i>
										<span>我的浏览</span>
									</a>
								</div>
							</td>
							<td>
								<div class="access">
									<a href="<?php echo U('Home/User/goods_collect'); ?>" target="_blank">
										<i class="mycollect"></i>
										<span>我的收藏</span>
									</a>
								</div>
							</td>
							<td class="lastcol">
								<div class="access">
									<a href="<?php echo U('Home/Order/order_list'); ?>" target="_blank">
										<i class="myorders"></i>
										<span>我的订单</span>
									</a>
								</div>
							</td>
						</tr>
						<tr class="lastcow">
							<td>
								<div class="access">
									<a href="<?php echo U('Home/User/safety_settings'); ?>" target="_blank">
										<i class="account_security"></i>
										<span>账号安全</span>
									</a>
								</div>
							</td>
							<td>
								<div class="access">
									<a href="<?php echo U('Home/User/recharge'); ?>" target="_blank">
										<i class="myshares"></i>
										<span>账户余额</span>
									</a>
								</div>
							</td>
							<td class="lastcol">
								<div class="access">
									<a href="<?php echo U('Home/Newjoin/index'); ?>" target="_blank">
										<i class="seller_enter"></i>
										<span>商家入驻</span>
									</a>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
        </div>
	    </div>
	</div>
            
           <!-- content_start-->
                <div class="main">
                    <!--品牌活动-->
                    <div class="m-brand">
                        <div class="brand-top clear">
                            <span class="b-title">品牌活动</span>
                            <div class="brand-r clear">
<!--                                    <span><a href="">品牌女装</a> &gt; <a href="">品质家居</a> &gt; <a href="">品牌母婴</a></span>-->
                                <ul class="clear" id="pinpai-active">
                                    <li class="active"></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                            </div>
                            <div class="brand-bottom">
                               <ul class="clear active">
                                 <?php
                                   
                                $md5_key = md5("select  id,title,prom_img,end_time from tp_prom_goods where status=1  limit 0,3");
                                $result_name = $sql_result_prom = S("sql_".$md5_key);
                                if(empty($sql_result_prom))
                                {                            
                                    $result_name = $sql_result_prom = \think\Db::query("select  id,title,prom_img,end_time from tp_prom_goods where status=1  limit 0,3"); 
                                    S("sql_".$md5_key,$sql_result_prom,31104000);
                                }    
                              foreach($sql_result_prom as $promote_key=>$prom): ?>
                                    <li>
                                        <a href="<?php echo U('activity/promoteList'); ?>"><img src="<?php echo $prom['prom_img']; ?>" /></a>
                                        <div class="li-bottom clear">
                                            <span class="prize-ys"><?php echo $prom['title']; ?></span>
                                            <span class="time-ys"><?php echo $prom['endtime']; ?>2天 18时16分34秒 </span>
                                            <a class="go-active" href="<?php echo U('activity/promoteList',['id'=>$prom['id']]); ?>">进入活动</a>
                                        </div>
                                    </li>
                                    <?php endforeach; ?>  
                               </ul>
                                <ul class="clear ">
                                 <?php
                                   
                                $md5_key = md5("select id,title,prom_img,end_time from __PREFIX__prom_goods where status=1  limit 4,3");
                                $result_name = $sql_result_prom = S("sql_".$md5_key);
                                if(empty($sql_result_prom))
                                {                            
                                    $result_name = $sql_result_prom = \think\Db::query("select id,title,prom_img,end_time from __PREFIX__prom_goods where status=1  limit 4,3"); 
                                    S("sql_".$md5_key,$sql_result_prom,31104000);
                                }    
                              foreach($sql_result_prom as $promote_key=>$prom): ?>

                                    <li>
                                        <a href="<?php echo U('activity/promoteList'); ?>"><img src="<?php echo $prom['prom_img']; ?>" /></a>
                                        <div class="li-bottom clear">
                                            <span class="prize-ys"><?php echo $prom['title']; ?></span>
                                            <span class="time-ys"><?php echo $prom['endtime']; ?> </span>
                                            <a class="go-active" href="">进入活动</a>
                                        </div>
                                    </li>
                                 <?php endforeach; ?>  
                               </ul>
                                <ul class="clear">
                                 <?php
                                   
                                $md5_key = md5("select id,title,prom_img,end_time from __PREFIX__prom_goods where status=1  limit 7,3");
                                $result_name = $sql_result_prom = S("sql_".$md5_key);
                                if(empty($sql_result_prom))
                                {                            
                                    $result_name = $sql_result_prom = \think\Db::query("select id,title,prom_img,end_time from __PREFIX__prom_goods where status=1  limit 7,3"); 
                                    S("sql_".$md5_key,$sql_result_prom,31104000);
                                }    
                              foreach($sql_result_prom as $promote_key=>$prom): ?>

                                    <li>
                                        <a href="<?php echo U('activity/promoteList'); ?>"><img src="<?php echo $prom['prom_img']; ?>" /></a>
                                        <div class="li-bottom clear">
                                            <span class="prize-ys"><?php echo $prom['title']; ?></span>
                                            <span class="time-ys"><?php echo $prom['endtime']; ?></span>
                                            <a class="go-active" href="">进入活动</a>
                                        </div>
                                    </li>
                                 <?php endforeach; ?>  
                               </ul>
                            </div>
                        </div>
                    </div>
                    <!--热销商品-->
                    <div class="m-selling clear">
                        <div class="a-left">
                            <dl class="clear selling-top" >
                                <dt>
                                    <span>热销精品榜</span>
                                    <ul class="clear" id="rex-active">
                                        <li class="active"></li>
                                        <li></li>
                                        <li></li>
                                    </ul>
                                </dt>
                            </dl>
                            <div class="m-selling-bottom">
					
                                  <dl class="clear act-show">
                                  <?php
                                   
                                $md5_key = md5("select goods_id,goods_name,original_img,shop_price from __PREFIX__goods where is_hot=1 and is_on_sale=1 limit 0,4");
                                $result_name = $sql_result_goods = S("sql_".$md5_key);
                                if(empty($sql_result_goods))
                                {                            
                                    $result_name = $sql_result_goods = \think\Db::query("select goods_id,goods_name,original_img,shop_price from __PREFIX__goods where is_hot=1 and is_on_sale=1 limit 0,4"); 
                                    S("sql_".$md5_key,$sql_result_goods,31104000);
                                }    
                              foreach($sql_result_goods as $promote_key=>$goods): ?>
                                    <dd style="border: 1px solid #f8f8f8;">
                                        <a  href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$goods[goods_id])); ?>" target="_blank"> <div class="selling-img" style="background-image: url(<?php echo $goods['original_img']; ?>);background-size: cover;background-color: #f8f8f8;width: 228px;"></div></a>
                                        <div class="selling-show">
                                            <p style="padding-top: 5px;"><a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$goods[goods_id])); ?>" target="_blank"><?php echo mb_substr($goods['goods_name'],0,36); ?></a></p>
                                            <i>￥<?php echo $goods['shop_price']; ?></i>
                                        </div>
                                    </dd> <?php endforeach; ?>
                                  </dl>
			 
					
                                  <dl class="clear ">
                                 <?php
                                   
                                $md5_key = md5("select goods_id,goods_name,original_img,shop_price from __PREFIX__goods where is_hot=1 and is_on_sale=1 limit 5,4");
                                $result_name = $sql_result_goods = S("sql_".$md5_key);
                                if(empty($sql_result_goods))
                                {                            
                                    $result_name = $sql_result_goods = \think\Db::query("select goods_id,goods_name,original_img,shop_price from __PREFIX__goods where is_hot=1 and is_on_sale=1 limit 5,4"); 
                                    S("sql_".$md5_key,$sql_result_goods,31104000);
                                }    
                              foreach($sql_result_goods as $promote_key=>$goods): ?>
                                    <dd style="border: 1px solid #f8f8f8;">
                                        <a  href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$goods[goods_id])); ?>" target="_blank"> <div class="selling-img" style="background-image: url(<?php echo $goods['original_img']; ?>);background-size: cover;background-color: #f8f8f8;width: 228px;"></div></a>
                                        <div class="selling-show">
                                            <p style="padding-top: 5px;"><a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$goods[goods_id])); ?>" target="_blank"><?php echo mb_substr($goods['goods_name'],0,36); ?></a></p>
                                            <i>￥<?php echo $goods['shop_price']; ?></i>
                                        </div>
                                    </dd>
                                     <?php endforeach; ?>
                                  </dl>
			 
                                 <dl class="clear ">
                                 <?php
                                   
                                $md5_key = md5("select goods_id,goods_name,original_img,shop_price from __PREFIX__goods where is_hot=1 and is_on_sale=1 limit 9,4");
                                $result_name = $sql_result_goods = S("sql_".$md5_key);
                                if(empty($sql_result_goods))
                                {                            
                                    $result_name = $sql_result_goods = \think\Db::query("select goods_id,goods_name,original_img,shop_price from __PREFIX__goods where is_hot=1 and is_on_sale=1 limit 9,4"); 
                                    S("sql_".$md5_key,$sql_result_goods,31104000);
                                }    
                              foreach($sql_result_goods as $promote_key=>$goods): ?>

                                    <dd style="border: 1px solid #f8f8f8;">
                                        <a  href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$goods[goods_id])); ?>" target="_blank"> <div class="selling-img" style="background-image: url(<?php echo $goods['original_img']; ?>);background-size: cover;background-color: #f8f8f8;width: 228px;"></div></a>
                                        <div class="selling-show">
                                            <p style="padding-top: 5px;"><a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$goods[goods_id])); ?>" target="_blank"><?php echo mb_substr($goods['goods_name'],0,36); ?></a></p>
                                            <i>￥<?php echo $goods['shop_price']; ?></i>
                                        </div>
                                    </dd>
                                     <?php endforeach; ?>
                                  </dl>
                            </div>
                        </div>
                        <div class="selling-right">
                            <div class="sell-r-top">
                                <span class="sell-l"><i style="background-image: url(__STATIC__/images/time.png)"></i>每日必抢</span>
                                <span class="sell-r">8:00场</span>
                            </div>
                            <a href=""><img src="__STATIC__/images/m-selling-right.jpg"></a>
                        </div>
                    </div>
                    <!--广告位-->
                    <div class="m-adsense">
                        <?php $pid =1;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1522119600 and end_time > 1522119600 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
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
				<a href="<?php echo $v['ad_link']; ?>" <?php if($v['target'] == 1): ?>target="_blank"<?php endif; ?>>
					<img src="<?php echo $v[ad_code]; ?>" style="width:1199px;height:110px;"/>
				</a>
	           <?php endforeach; ?>
                  
                    </div>
                    <!--广告位-->
                    <!--楼层一-->
                    <?php $wk=1;if(is_array($web_list) || $web_list instanceof \think\Collection || $web_list instanceof \think\Paginator): if( count($web_list)==0 ) : echo "" ;else: foreach($web_list as $wk=>$wb): ?>
                    <div class="floor-<?php echo $wk; ?> floor-style">
                        <div class="floor-title">
                            <span><?php echo $wb[tit][floor]; ?> <?php echo $wb[tit][title]; ?></span>
                            <ul class="clear">
                                <li class="active"><a href="">精选热卖</a></li>
                                <?php if(is_array($wb[category_list][goods_class]) || $wb[category_list][goods_class] instanceof \think\Collection || $wb[category_list][goods_class] instanceof \think\Paginator): if( count($wb[category_list][goods_class])==0 ) : echo "" ;else: foreach($wb[category_list][goods_class] as $key=>$gc): ?>
                                    <li><a href="<?php echo U('Goods/goodsList',array('id'=>$gc[gc_id])); ?>"><?php echo $gc['gc_name']; ?></a></li>
			    <?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                            <a href="" class="f-more">更多</a>
                        </div>
                        <div class="floor-content clear">
                            <div class="f_l-1">
                                <a href="<?php echo $wb[act][url]; ?>"  target="_blank">
				<img src="<?php echo $wb[act][pic]; ?>" alt="" title="<?php echo $wb[act][title]; ?>">
			    </a>
                            </div>
                            <div class="f_l-2">
                                
                                <div class="f_1-t">
                                    <?php if(is_array($wb[adv]) || $wb[adv] instanceof \think\Collection || $wb[adv] instanceof \think\Paginator): if( count($wb[adv])==0 ) : echo "" ;else: foreach($wb[adv] as $ak=>$ad): if($ad[adv_type] == 'upload_advbig'): if(is_array($ad[adv_info]) || $ad[adv_info] instanceof \think\Collection || $ad[adv_info] instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($ad[adv_info]) ? array_slice($ad[adv_info],0,1, true) : $ad[adv_info]->slice(0,1, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sd): $mod = ($i % 2 );++$i;?>
                                                 <a href="<?php echo $sd['pic_url']; ?>">
                                                 <img src="<?php echo (isset($sd['pic_img']) && ($sd['pic_img'] !== '')?$sd['pic_img']:'/public/images/icon_goods_thumb_empty_300.png'); ?>">
                                                 </a>
                                            
                                            <?php endforeach; endif; else: echo "" ;endif; endif; endforeach; endif; else: echo "" ;endif; ?>
                                </div>
                                <div class="f_1-b clear">
                     
                                    <?php if(is_array($wb[brand_list]) || $wb[brand_list] instanceof \think\Collection || $wb[brand_list] instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($wb[brand_list]) ? array_slice($wb[brand_list],1,3, true) : $wb[brand_list]->slice(1,3, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$bd): $mod = ($i % 2 );++$i;?>
                                        <a href="<?php echo U('Goods/goodsList',array('brand_id'=>$bd[brand_id])); ?>"><img class="lazy" data-original="<?php echo (isset($bd['brand_pic']) && ($bd['brand_pic'] !== '')?$bd['brand_pic']:'/public/images/icon_goods_thumb_empty_300.png'); ?>" src="" title="<?php echo $bd['brand_name']; ?>"/></a>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </div>
                            </div>
                            <div class="f_l-3">
                                <div class="f_1-t clear">
                                    <?php if(is_array($wb[adv]) || $wb[adv] instanceof \think\Collection || $wb[adv] instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($wb[adv]) ? array_slice($wb[adv],0,5, true) : $wb[adv]->slice(0,5, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ad): $mod = ($i % 2 );++$i;if($ad[adv_type] == 'upload_advbig'): else: ?>
                                                    <a href="<?php echo $ad['adv_info'][pic_url]; ?>">
                                                    <img data-original="<?php echo (isset($ad[adv_info][pic_img]) && ($ad[adv_info][pic_img] !== '')?$ad[adv_info][pic_img]:'/public/images/icon_goods_thumb_empty_300.png'); ?>" class="lazy" width="229" height="145"/>
                                             </a>
                                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                
                                </div>
                                <div class="f_1-b clear">
                                     <?php if(is_array($wb[brand_list]) || $wb[brand_list] instanceof \think\Collection || $wb[brand_list] instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($wb[brand_list]) ? array_slice($wb[brand_list],4,3, true) : $wb[brand_list]->slice(4,3, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$bd): $mod = ($i % 2 );++$i;?>
                                        <a href="<?php echo U('Goods/goodsList',array('brand_id'=>$bd[brand_id])); ?>"><img class="lazy" data-original="<?php echo (isset($bd['brand_pic']) && ($bd['brand_pic'] !== '')?$bd['brand_pic']:'/public/images/icon_goods_thumb_empty_300.png'); ?>" src="" title="<?php echo $bd['brand_name']; ?>"/></a>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                  <?php endforeach; endif; else: echo "" ;endif; ?>
                  
                    <!--楼层-->
                </div>
           <!-- content_end-->
            
	<!--左侧边栏-->
	<div class="sideleft-nav" id="sideleft">
		<div class="first-l">楼层导航</div>
		<ul>
			<?php if(is_array($web_list) || $web_list instanceof \think\Collection || $web_list instanceof \think\Paginator): if( count($web_list)==0 ) : echo "" ;else: foreach($web_list as $k=>$vo): ?>
				<li class="<?php if($k == 0): ?>sid-red<?php endif; ?>">
                    <?php if(!empty($vo[tit][title])): ?>
					    <a href="javascript:;"><i></i><?php echo $vo[tit][title]; ?></a>
                    <?php else: ?>
                        <a style="background-image: url(<?php echo $vo['tit']['pic']; ?>);background-size:100% 31px;" href="javascript:;"><i></i></a>
                    <?php endif; ?>
				</li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
<!--左侧边栏-->
<link rel="stylesheet" href="__STATIC__/css/public-footer.css"/>
<div class="footer p">
    <div class="mod_service_inner">
        <div class="w1224">
            <ul>
                <li>
                    <div class="mod_service_unit">
                        <h5 class="mod_service_duo">多</h5>
                        <p>品类齐全，轻松购物</p>
                    </div>
                </li>
                <li>
                    <div class="mod_service_unit">
                        <h5 class="mod_service_kuai">快</h5>
                        <p>多仓直发，极速配送</p>
                    </div>
                </li>
                <li>
                    <div class="mod_service_unit">
                        <h5 class="mod_service_hao">好</h5>
                        <p>正品行货，精致服务</p>
                    </div>
                </li>
                <li>
                    <div class="mod_service_unit">
                        <h5 class="mod_service_sheng">省</h5>
                        <p>天天低价，畅选无忧</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
 <div class="footer-coon">
    <div class="w1224">
        <div class="footer-ewmcode">
		    <div class="foot-list-fl">
                <div class="foot-list-wrap p">
                    <ul>
                            <li class="foot-th">
                                <a href="">帮助中心</a>
                            </li>
                            <li><a href="">账户管理</a></li>
                            <li><a href="">购物指南</a></li>
                            <li><a href="">订单操作</a></li>
                        </ul>
                        <ul>
                            <li class="foot-th">
                                <a href="">服务支持</a>
                            </li>
                            <li><a href="">售后政策</a></li>
                            <li><a href="">退款服务</a></li>
                            <li><a href="">自助服务</a></li>
                        </ul>
                        <ul>
                            <li class="foot-th">
                                <a href="">关于掌心</a>
                            </li>
                            <li><a href="">了解掌心</a></li>
                            <li><a href="">加入掌心</a></li>
                            <li><a href="">联系我们</a></li>
                        </ul>
                        <ul>
                            <li class="foot-th">
                                <a href="">关注掌心</a>
                            </li>
                            <li><a href="">新浪微博</a></li>
                            <li><a href="">官方微信</a></li>
                            <li><a href="">小程序</a></li>
                        </ul>
                        <ul>
                            <li class="foot-th">
                                <a href="">支付方式</a>
                            </li>
                            <li><a href="">微信支付</a></li>
                            <li><a href="">支付宝</a></li>
                            <li><a href="">多种支付</a></li>
                        </ul>
                        <ul>
                            <li class="foot-th">
                                <a href="">促销活动</a>
                            </li>
                            <li><a href="">参与活动</a></li>
                            <li><a href="">往期活动</a></li>
                        </ul>
                </div>

		    </div>

            <div class="right-contact-us">
                    <span class="phone"><?php echo $tpshop_config['shop_info_phone']; ?></span>
                    <p class="tips">周一至周日8:00-18:00<br>(仅收市话费)</p>
                    <a href="" class="go-tel">客服热线</a>
                </div>
            
		  
		</div>
        
                
    </div>
     <div class="footer-boot">
        <div class="w1224">
            <div class="mod_copyright p">
                <div class="s-f-left">
                    <img src="__STATIC__/images/logo_1.png">
                    <div class="grid-top">
                        <a href="javascript:void (0);">关于我们</a><span>|</span>
                        <a href="javascript:void (0);">联系我们</a><span>|</span>
                        <a href="<?php echo U('Home/Newjoin/index'); ?>">商家入驻</a><span>|</span>
                        <a href="<?php echo U('Home/Article/help'); ?>">商家帮助</a><span>|</span>
                    </div>
                    <p>Copyright © 2016-2025 掌心商城 版权所有 保留一切权利 备案号:<?php echo $tpshop_config['shop_info_record_no']; ?></p>
                </div>
                <div class="s-f-right">
                    <p class="mod_copyright_auth">
                        <a class="mod_copyright_auth_ico mod_copyright_auth_ico_1" href="" target="_blank">经营性网站备案中心</a>
                        <a class="mod_copyright_auth_ico mod_copyright_auth_ico_2" href="" target="_blank">可信网站信用评估</a>
                        <a class="mod_copyright_auth_ico mod_copyright_auth_ico_3" href="" target="_blank">网络警察提醒你</a>
                        <a class="mod_copyright_auth_ico mod_copyright_auth_ico_4" href="" target="_blank">诚信网站</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
 </div>
</div>
<div class="soubao-sidebar">
    <div class="soubao-sidebar-bg"></div>
    <div class="sidertabs tab-lis-1">
        <div class="sider-top-stra sider-midd-1">
            <div class="icon-tabe-chan">
                <a href="<?php echo U('Home/User/index'); ?>">
                    <i class="share-side share-side1"></i>
                    <i class="share-side tab-icon-tip triangleshow"></i>
                </a>
                <div class="dl_login">
                    <div class="hinihdk">
                        <img class="head_pic" src="__STATIC__/images/dl.png"/>
                        <p class="loginafter nologin"><span>你好，请先</span><a href="<?php echo U('Home/user/login'); ?>">登录</a>！</p>
                        <!--未登录-e--->
                        <!--登录后-s--->
                        <p class="loginafter islogin"><span class="id_jq userinfo">陈xxxxxxx</span><span>点击</span><a href="<?php echo U('Home/user/logout'); ?>">退出</a>！</p>
                        <!--未登录-s--->
                    </div>
                </div>
            </div>
            <div class="icon-tabe-chan shop-car">
                <a href="javascript:void(0);" onclick="ajax_side_cart_list()">
                    <div class="tab-cart-tip-warp-box">
                        <div class="tab-cart-tip-warp">
                            <i class="share-side share-side1"></i>
                            <i class="share-side tab-icon-tip"></i>
                            <span class="tab-cart-tip">购物车</span>
                            <span class="tab-cart-num J_cart_total_num" id="tab_cart_num">0</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="icon-tabe-chan massage">
                <a href="<?php echo U('Home/User/message_notice'); ?>" target="_blank">
                    <i class="share-side share-side1"></i>
                    <!--<i class="share-side tab-icon-tip"></i>-->
                    <span class="tab-tip">消息</span>
                </a>
            </div>
        </div>
        <div class="sider-top-stra sider-midd-2">
            <div class="icon-tabe-chan mmm">
                <a href="<?php echo U('Home/User/goods_collect'); ?>" target="_blank">
                    <i class="share-side share-side1"></i>
                    <!--<i class="share-side tab-icon-tip"></i>-->
                    <span class="tab-tip">收藏</span>
                </a>
            </div>
            <div class="icon-tabe-chan hostry">
                <a href="<?php echo U('Home/User/visit_log'); ?>" target="_blank">
                    <i class="share-side share-side1"></i>
                    <!--<i class="share-side tab-icon-tip"></i>-->
                    <span class="tab-tip">足迹</span>
                </a>
            </div>
      <!--      <div class="icon-tabe-chan sign">
                <a href="" target="_blank">
                    <i class="share-side share-side1"></i>
                    &lt;!&ndash;<i class="share-side tab-icon-tip"></i>&ndash;&gt;
                    <span class="tab-tip">签到</span>
                </a>
            </div>-->
        </div>
    </div>
    <div class="sidertabs tab-lis-2">
        <div class="icon-tabe-chan advice">
            <a href="tencent://message/?uin=<?php echo $tpshop_config['shop_info_qq']; ?>&amp;Site=<?php echo $tpshop_config['shop_info_store_name']; ?>&amp;Menu=yes">
                <i class="share-side share-side1"></i>
                <!--<i class="share-side tab-icon-tip"></i>-->
                <span class="tab-tip">在线咨询</span>
            </a>
        </div>
       <!-- <div class="icon-tabe-chan request">
            <a href="" target="_blank">
                <i class="share-side share-side1"></i>
                &lt;!&ndash;<i class="share-side tab-icon-tip"></i>&ndash;&gt;
                <span class="tab-tip">意见反馈</span>
            </a>
        </div>-->
        <div class="icon-tabe-chan qrcode">
            <a href="" target="_blank">
                <i class="share-side share-side1"></i>
                <i class="share-side tab-icon-tip triangleshow"></i>
				<span class="tab-tip qrewm">
					<img src="__STATIC__/images/qrcode.png"/>
					扫一扫下载APP
				</span>
            </a>
        </div>
        <div class="icon-tabe-chan comebacktop">
            <a href="" target="_blank">
                <i class="share-side share-side1"></i>
                <!--<i class="share-side tab-icon-tip"></i>-->
                <span class="tab-tip">返回顶部</span>
            </a>
        </div>
    </div>
    <div class="shop-car-sider">

    </div>
</div>
<script src="__STATIC__/js/common.js"></script>
<script>
    //侧边栏
    $(function(){
        $('.shop-car').click(function(){
            //购物车
            if($('.shop-car-sider').hasClass('sh-hi')){
                $('.shop-car-sider').animate({left:'35px',opacity:'hide'},'normal',function(){
                    $('.shop-car-sider').removeClass('sh-hi');
                    $('.shop-car .tab-cart-tip-warp-box').css('background-color','');
                    $('.shop-car .tab-icon-tip').removeClass('jsshow');
                });
            }else{
                $('.shop-car-sider').animate({left:'-280px',opacity:'show'},'normal',function(){
                    $('.shop-car-sider').addClass('sh-hi');
                    $('.shop-car .tab-cart-tip-warp-box').css('background-color','#e23435');
                    $('.shop-car .tab-icon-tip').addClass('jsshow');
                });
            }

        })
        $(".comebacktop").click(function () {
            //回到顶部
            var speed=300;//滑动的速度
            $('body,html').animate({ scrollTop: 0 }, speed);
            return false;
        });
    });
</script>

<script src="__STATIC__/js/lazyload.min.js" type="text/javascript" charset="utf-8"></script>
<script src="__STATIC__/js/headerfooter.js" type="text/javascript" charset="utf-8"></script>
<script src="__STATIC__/js/carousel.js" type="text/javascript" charset="utf-8"></script>
<script>
    $("#catgory-show").show(); 
    var mySwiper = new Swiper('.swiper-container',{
        loop : true,
        autoplay : 3000,
        calculateHeight : true,
        pagination : '.pagination',
        paginationClickable :true
    });
    function sidebarRollChange() {
        //首页侧边栏滚动改变楼层
        var $_floorList=$('.floor-style');
        var $_sidebar=$('#sideleft');
        $_sidebar.find('li').click(function () {
            //点击切换楼层
            $('html,body').animate({'scrollTop':$_floorList.eq($(this).index()).offset().top},500);
        });
        $(window).scroll(function(){
            var scrollTop=$(window).scrollTop();
            //显示左边侧边栏
            if(scrollTop<$_floorList.eq(0).offset().top-$(window).height()/2){
                //还没滚到到楼层或向上滚出楼层隐藏侧边栏
                $_sidebar.hide();
                return;
            }
            $_sidebar.show(); //左边侧边栏显示
            /*滚动改变侧边栏的状态*/
            for(var j=0; j<$_floorList.length;j++){
                if(scrollTop>$_floorList.eq(j).offset().top-$(window).height()/2){
                    $_sidebar.find('li').eq(j).addClass('sid-red').siblings().removeClass('sid-red');
                }
            }
        })
    }
    sidebarRollChange();
    $(function () {
        $("#hd-my-cart").hover(function () {
            $("#show_minicart").show();
        },function () {
            $("#show_minicart").hide();
        });
        $(".search-select-h").mouseover(function () {
            $("#select-h").show();
        });
        $("#select-h").mouseout(function () {
            $("#select-h").hide();
        });

        //品牌活动
        $("#pinpai-active li").mouseover(function () {
            var index=$(this).index();
            $("#pinpai-active li").removeClass("active").eq(index).addClass("active");
            $(".brand-bottom ul").removeClass("active").eq(index).addClass("active");
        });
        //热销活动
        $("#rex-active li").mouseover(function () {
            var index=$(this).index();
            $("#rex-active li").removeClass("active").eq(index).addClass("active");
            $(".m-selling-bottom dl").removeClass("act-show").eq(index).addClass("act-show");
        })
    })
</script>
<script type="text/javascript">
	//品牌logo
	$(function() {
		var op = 500;
		$('.tpshop2_0_brand ul li').hover(function() {
			if(!$(this).hasClass('b')) {
				$(this).stop().animate({
					opacity: "1"
				}, op).siblings().stop().animate({
					opacity: "0.5"
				}, op);
			}
		}, function() {
			if(!$(this).hasClass('b')) {
				$(this).stop().animate({
					opacity: "1"
				}, op).siblings().stop().animate({
					opacity: "1"
				}, op);
			}
		})
	})
	//楼层横向导航
	$(function(){
		$('ul.f-tab li').hover(function(){
			$(this).addClass('z-select').siblings().removeClass('z-select');
			var page_id = $(this).data('id');
			var floot_page = $(this).data('floot');
			$('.'+floot_page).hide();
			$('#'+page_id).show();
		})
	})
	//公告/促销切换
	$(function(){
		$('.bn_box span').hover(function(){
			$(this).addClass('action').siblings().removeClass('action');
			$('.bulletin .content').hide();
			if($(this).hasClass('box_prom')){
				$('.box_prom_content').show();
			}else{
				$('.box_ad_content').show();
			}
		})
	})

	function showul(obj){
		var fid = $(obj).attr('fid');
		var nky = $(obj).attr('rel');
		$('#floor'+fid).find('.content_goods_sh').hide();
		$('#floor'+fid).find('#wbg'+nky).show();
	}
</script>
</body>
</html>