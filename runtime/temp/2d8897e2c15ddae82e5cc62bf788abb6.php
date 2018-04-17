<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:36:"./template/pc/web1/goods\search.html";i:1517208528;s:37:"./template/pc/web1/public\header.html";i:1517208528;s:44:"./template/pc/web1/public\header_search.html";i:1517208528;s:37:"./template/pc/web1/public\footer.html";i:1517208528;s:43:"./template/pc/web1/public\sidebar_cart.html";i:1517208528;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>商品列表</title>
	<link rel="stylesheet" type="text/css" href="__STATIC__/css/tpshop.css" />
	<script src="__STATIC__/js/jquery-1.11.3.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="__PUBLIC__/js/layer/layer-min.js"></script>
	<script src="__PUBLIC__/js/global.js"></script>
	<script src="__PUBLIC__/js/pc_common.js"></script>
	<!-- 新浪获取ip地址 -start-->
	<?php if(\think\Cookie::get('province_id') <= 0): ?>
		<script src="http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=<?php echo \think\Request::instance()->ip(); ?>"></script>
		<script type="text/JavaScript">
			doCookieArea(remote_ip_info);
		</script>
	<?php endif; ?>
	<style>
        @media screen and (max-width: 1260px) {
            .header .ecsc-join{
                display: none;
            }
            .top-ri-header ul li{
                padding: 0 4px;
            }
            .list1 .dd{
                width: 200px !important;
            }
            .footer{
                min-width: inherit;
            }
            .navitems{
                width: 840px;
            }
            .categorys .dt a{
                width: 100px;
            }
            .categorys{
                width: 140px;
            }
            .footer .foot-list-fl{
                width: 608px;
            }
            .footer .foot-list-fl ul{
                width: 120px;
            }
            .categorys .cata-nav-name h3{
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .home_categorys .cata-nav-layer{
                left: 140px !important;
            }
            .categorys .cata-nav-layer{
                width: 840px;
            }
            .categorys .cata-nav-layer .cata-nav-rigth{
                display: none;
            }
            .categorys .dt a:before{
                margin-right: 0;
                width: 0;
            }
            .sendaddress{
                display: none;
            }
        }
    </style>
</head>
<body>
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
		<div class="w1430 pr">
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
		<div class="header w1430">
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
		<div class="w1430 p">
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

<!--header-e-->
<div class="search-box p">
	<div class="w1430">
		<div class="search-path fl">
			<a href="<?php echo U('Home/Goods/search',array('q'=>$filter_param['q'])); ?>">全部结果</a>
			<i class="litt-xyb"></i>
			<a href="<?php echo U('Home/Goods/search',array('q'=>$filter_param['q'])); ?>"><?php echo $filter_param['q']; ?></a>
			<i class="litt-xyb"></i>
            <?php if(is_array($filter_menu) || $filter_menu instanceof \think\Collection || $filter_menu instanceof \think\Paginator): if( count($filter_menu)==0 ) : echo "" ;else: foreach($filter_menu as $k=>$v): ?>
                <a title="<?php echo $v['text']; ?>" href="<?php echo $v['href']; ?>" class="u-av-label">
                    <em><?php echo $v[text]; ?></em>
                    <i>x</i>
                </a>
            <?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<div class="search-clear fr">
			<span><a href="<?php echo U('Home/Goods/search',array('q'=>$filter_param['q'])); ?>">清空筛选条件</a></span>
		</div>
	</div>
</div>
<!-- 筛选 start -->
<div class="search-opt">
    <div class="w1430">
        <div class="opt-list">
            <!-- 品牌筛选 start -->
            <?php if($filter_brand != null): ?>
                <dl class="brand-section m-tr">
                    <dt>品牌</dt>
                    <dd class="ri-section">
                        <div class="lf-list">
                            <div class="brand-box brand-list">
                                <div class="clearfix p">
                                    <?php if(is_array($filter_brand) || $filter_brand instanceof \think\Collection || $filter_brand instanceof \think\Paginator): if( count($filter_brand)==0 ) : echo "" ;else: foreach($filter_brand as $k=>$v): ?>
                                        <a href="<?php echo $v[href]; ?>" data-href="<?php echo $v[href]; ?>"  data-key='brand' data-val='<?php echo $v[id]; ?>'>
                                            <i class="litt-zd"></i>
                                            <img src="<?php echo $v[logo]; ?>"/>
                                            <span><?php echo $v[name]; ?></span>
                                        </a>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </div>
                                <div class="surclofix p">
                                    <a href="javascript:;" class="u-confirm" onClick="submitMoreFilter('brand',this);">确定</a>
                                    <a href="javascript:;" class="u-cancel">取消</a>
                                </div>
                            </div>
                        </div>
                        <div class="lr-more">
                            <a href="javascript:void(0)"><span class="dx_choice">多选</span><i class="litt-pluscr"></i></a>
                            <?php if(count($filter_brand) > 10): ?>
                                <a href="javascript:void(0)"><span class="gd_more">更多</span><i class="litt-tcr"></i></a>
                            <?php endif; ?>
                        </div>
                    </dd>
                </dl>
            <?php endif; ?>
            <!-- 品牌筛选 end -->
            <!-- 规格筛选 start -->
            <?php if($filter_spec != null): if(is_array($filter_spec) || $filter_spec instanceof \think\Collection || $filter_spec instanceof \think\Paginator): if( count($filter_spec)==0 ) : echo "" ;else: foreach($filter_spec as $k=>$v): ?>
                    <dl class="brand-section m-tr">
                        <dt><?php echo $v['name']; ?></dt>
                        <dd class="ri-section">
                            <div class="lf-list">
                                <div class="brand-list">
                                    <div class="clearfix p">
                                        <?php if(is_array($v[item]) || $v[item] instanceof \think\Collection || $v[item] instanceof \think\Paginator): if( count($v[item])==0 ) : echo "" ;else: foreach($v[item] as $k2=>$v2): ?>
                                            <a href="<?php echo $v2[href]; ?>" data-href="<?php echo $v2[href]; ?>" data-key='<?php echo $v2[key]; ?>' data-val='<?php echo $v2[val]; ?>'>
                                                <input class="shaix_la" type="checkbox" style="display: none"/>
                                                <span><?php echo $v2[item]; ?></span>
                                            </a>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </div>
                                    <div class="surclofix p">
                                        <a href="javascript:;" class="u-confirm" onClick="submitMoreFilter('spec',this);">确定</a>
                                        <a href="javascript:;" class="u-cancel">取消</a>
                                    </div>
                                </div>
                            </div>
                            <div class="lr-more">
                                <a href="javascript:void(0)"><span class="dx_choice">多选</span><i class="litt-pluscr"></i></a>
                                <?php if(count($v['item']) > 11): ?>
                                    <a href="javascript:void(0)"><span class="gd_more">更多</span><i class="litt-tcr"></i></a>
                                <?php endif; ?>
                            </div>
                        </dd>
                    </dl>
                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
            <!-- 规格筛选 end -->
            <!-- 属性筛选 start -->
            <?php if($filter_attr != null): if(is_array($filter_attr) || $filter_attr instanceof \think\Collection || $filter_attr instanceof \think\Paginator): if( count($filter_attr)==0 ) : echo "" ;else: foreach($filter_attr as $k=>$v): ?>
                    <dl class="brand-section m-tr">
                        <dt><?php echo $v['attr_name']; ?></dt>
                        <dd class="ri-section">
                            <div class="lf-list">
                                <div class="brand-list">
                                    <div class="clearfix p">
                                        <?php if(is_array($v[attr_value]) || $v[attr_value] instanceof \think\Collection || $v[attr_value] instanceof \think\Paginator): if( count($v[attr_value])==0 ) : echo "" ;else: foreach($v[attr_value] as $k2=>$v2): ?>
                                            <a href="<?php echo $v2[href]; ?>" data-href="<?php echo $v2[href]; ?>" data-key='<?php echo $v2[key]; ?>' data-val='<?php echo $v2[val]; ?>'>
                                                <input class="shaix_la" type="checkbox" style="display: none"/>
                                                <span><?php echo $v2[attr_value]; ?></span>
                                            </a>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </div>
                                    <div class="surclofix p">
                                        <a href="javascript:;" class="u-confirm"  onClick="submitMoreFilter('attr',this);">确定</a>
                                        <a href="javascript:;" class="u-cancel">取消</a>
                                    </div>
                                </div>
                            </div>
                            <div class="lr-more">
                                <a href="javascript:void(0)"><span class="dx_choice">多选</span><i class="litt-pluscr"></i></a>
                                <?php if(count($v['attr_value']) > 11): ?>
                                    <a href="javascript:void(0)"><span class="gd_more">更多</span><i class="litt-tcr"></i></a>
                                <?php endif; ?>
                            </div>
                        </dd>
                    </dl>
                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
            <!-- 属性筛选 end -->
            <!-- 价格筛选 start -->
            <?php if($filter_price != null): ?>
                <dl class="brand-section m-tr">
                    <dt>价格</dt>
                    <dd class="ri-section">
                        <div class="lf-list">
                            <div class="brand-list">
                                <div class="clearfix p">
                                    <?php if(is_array($filter_price) || $filter_price instanceof \think\Collection || $filter_price instanceof \think\Paginator): if( count($filter_price)==0 ) : echo "" ;else: foreach($filter_price as $k=>$v): ?>
                                        <a href="<?php echo $v[href]; ?>" data-href="<?php echo $v[href]; ?>" data-key='<?php echo $v[key]; ?>' data-val='<?php echo $v[val]; ?>'>
                                            <span><?php echo $v[value]; ?></span>
                                        </a>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="lr-more">
                            <!--<a href="javascript:void(0)"><span class="dx_choice">多选</span><i class="litt-pluscr"></i></a>
                            <a href="javascript:void(0)"><span class="gd_more">更多</span><i class="litt-tcr"></i></a>-->
                            <form action="<?php echo urldecode(U('/Home/Goods/search',$filter_param,''));?>" method="post" id="price_form">
                                <input type="text" onpaste="this.value=this.value.replace(/[^\d]/g,'')" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" name="start_price" id="start_price" value=""/>
                                <span>-</span>
                                <input type="text" onpaste="this.value=this.value.replace(/[^\d]/g,'')" onkeyup="this.value=this.value.replace(/[^\d]/g,'')"  name="end_price" id="end_price" value=""/>
                                <input type="submit" value="确定" onClick="if($('#start_price').val() !='' && $('#end_price').val() !='' ) $('#price_form').submit();"/>
                            </form>
                        </div>
                    </dd>
                </dl>
            <?php endif; ?>
            <!-- 价格筛选 end -->
        </div>
        <p class="moreamore"><a href="">浏览更多</a></p>
    </div>
</div>
<!-- 筛选 end -->
<div class="shop-list-tour ma-to-20 p">
	<div class="w1430">
		<div class="tjhot fl">
			<div class="sx_topb"><h3>推荐热卖</h3></div>
			<div class="tjhot-shoplist" id="ajax_hot_goods">
                <?php
                                   
                                $md5_key = md5("select g.*,s.store_name from `__PREFIX__goods` as g left join `__PREFIX__store` as s on s.store_id = g.store_id where g.is_hot = 1 and g.is_on_sale = 1 and g.goods_state = 1 and g.goods_id IN ($filter_goods_id_str) order by g.sort DESC limit 5");
                                $result_name = $sql_result_hot = S("sql_".$md5_key);
                                if(empty($sql_result_hot))
                                {                            
                                    $result_name = $sql_result_hot = \think\Db::query("select g.*,s.store_name from `__PREFIX__goods` as g left join `__PREFIX__store` as s on s.store_id = g.store_id where g.is_hot = 1 and g.is_on_sale = 1 and g.goods_state = 1 and g.goods_id IN ($filter_goods_id_str) order by g.sort DESC limit 5"); 
                                    S("sql_".$md5_key,$sql_result_hot,31104000);
                                }    
                              foreach($sql_result_hot as $key=>$hot): ?>
                    <div class="alone-shop">
                        <a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$hot['goods_id'])); ?>"><img class="lazy" data-original="<?php echo goods_thum_images($hot['goods_id'],180,180); ?>"/></a>
                        <p class="line-two-hidd"><a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$hot['goods_id'])); ?>"><?php echo $hot['goods_name']; ?></a></p>
                        <p class="price-tag"><span class="li_xfo">￥</span><span><?php echo $hot['shop_price']; ?></span></p>
                        <p class="store-alone"><a href="<?php echo U('Home/Store/index',array('store_id'=>$hot['store_id'])); ?>"><?php echo $hot['store_name']; ?></a></p>
                    </div>
                <?php endforeach; ?>
			</div>
			<div class="sx_topb ma-to-20"><h3>销量排行</h3></div>
			<div class="tjhot-shoplist" id="ajax_sales_goods">
                <?php
                                   
                                $md5_key = md5("select g.*,s.store_name from `__PREFIX__goods` as g left join `__PREFIX__store` as s on s.store_id = g.store_id where
                g.is_on_sale = 1 and g.goods_state = 1 and g.goods_id IN ($filter_goods_id_str) order by g.sales_sum desc limit 5");
                                $result_name = $sql_result_sales = S("sql_".$md5_key);
                                if(empty($sql_result_sales))
                                {                            
                                    $result_name = $sql_result_sales = \think\Db::query("select g.*,s.store_name from `__PREFIX__goods` as g left join `__PREFIX__store` as s on s.store_id = g.store_id where
                g.is_on_sale = 1 and g.goods_state = 1 and g.goods_id IN ($filter_goods_id_str) order by g.sales_sum desc limit 5"); 
                                    S("sql_".$md5_key,$sql_result_sales,31104000);
                                }    
                              foreach($sql_result_sales as $key=>$sales): ?>
                    <div class="alone-shop">
                        <a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$sales['goods_id'])); ?>"><img class="lazy" data-original="<?php echo goods_thum_images($sales['goods_id'],180,180); ?>" /></a>
                        <p class="line-two-hidd"><a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$sales['goods_id'])); ?>"><?php echo $sales['goods_name']; ?></a></p>
                        <p class="price-tag"><span class="li_xfo">￥</span><span><?php echo $sales['shop_price']; ?></span></p>
                        <p class="store-alone"><a href="<?php echo U('Home/Store/index',array('store_id'=>$sales['store_id'])); ?>"><?php echo $sales['store_name']; ?></a></p>
                    </div>
                <?php endforeach; ?>
			</div>
		</div>
		<div class="stsho fr">
			<div class="sx_topb ba-dark-bg">
				<div class="f-sort fl">
					<ul>
						<li class="<?php if(\think\Request::instance()->param('sort') == ''): ?>red<?php endif; ?>"><a href="<?php echo urldecode(U("/Home/Goods/search",$filter_param,''));?>">综合</a></li>
						<li class="<?php if(\think\Request::instance()->param('sort') == 'sales_sum'): ?>red<?php endif; ?>"><a href="<?php echo urldecode(U("/Home/Goods/search",array_merge($filter_param,array('sort'=>'sales_sum')),''));?>">销量</a></li>
						<?php if(\think\Request::instance()->param('sort_asc') == 'desc'): ?>
							<li class="<?php if(\think\Request::instance()->param('sort') == 'shop_price'): ?>red<?php endif; ?>"><a href="<?php echo urldecode(U("/Home/Goods/search",array_merge($filter_param,array('sort'=>'shop_price','sort_asc'=>'asc')),''));?>">价格<i class="litt-zzx1"></i></a></li>
						<?php else: ?>
							<li class="<?php if(\think\Request::instance()->param('sort') == 'shop_price'): ?>red<?php endif; ?>"><a href="<?php echo urldecode(U("/Home/Goods/search",array_merge($filter_param,array('sort'=>'shop_price','sort_asc'=>'desc')),''));?>">价格<i class="litt-zzx1"></i></a></li>
						<?php endif; ?>
						<li class="<?php if(\think\Request::instance()->param('sort') == 'comment_count'): ?>red<?php endif; ?>"><a href="<?php echo urldecode(U("/Home/Goods/search",array_merge($filter_param,array('sort'=>'comment_count')),''));?>">评论</a></li>
						<li class="<?php if(\think\Request::instance()->param('sort') == 'is_new'): ?>red<?php endif; ?>"><a href="<?php echo urldecode(U("/Home/Goods/search",array_merge($filter_param,array('sort'=>'is_new')),''));?>">新品</a></li>
					</ul>
				</div>
				<div class="f-total fr">
					<div class="all-sec">共<span><?php echo $page->totalRows; ?></span>个商品</div>
					<div class="all-fy">
						<?php $nowPage = $page->nowPage;$totalPages = $page->totalPages; ?>
						<a <?php if($nowPage > 1): ?>href="<?php echo U('Home/Goods/search',array_merge($filter_param,array('p'=>$nowPage-1))); ?>" <?php endif; ?>>&lt;</a>
						<p class="fy-y"><span class="z-cur"><?php echo $nowPage; ?></span>/<span><?php echo $totalPages; ?></span></p>
						<a <?php if(($nowPage+1) < $totalPages): ?>href="<?php echo U('Home/Goods/search',array_merge($filter_param,array('p'=>$page->nowPage+1))); ?>" <?php endif; ?>>&gt;</a>
					</div>
				</div>
			</div>
			<div class="sx_topb">
				<div class="choice-mo-shop">
                    <ul>
                        <li>
                            <?php if(\think\Request::instance()->param('own_shop') == '1'): ?>
                                <a class="red" href="<?php echo urldecode(U("/Home/Goods/search",array_merge($filter_param,array('own_shop'=>'0')),''));?>">
                                <i class="litt-zzdg1 litt-zzdg2">
                                    <?php else: ?>
                                    <a href="<?php echo urldecode(U("/Home/Goods/search",array_merge($filter_param,array('own_shop'=>'1')),''));?>">
                                    <i class="litt-zzdg1">
                            <?php endif; ?>
                            </i><?php echo $tpshop_config['shop_info_store_name']; ?>自营
                            </a>
                        </li>
                        <li>
                            <?php if(\think\Request::instance()->param('recommend') == '1'): ?>
                                <a class="red" href="<?php echo urldecode(U("/Home/Goods/search",array_merge($filter_param,array('recommend'=>'0')),''));?>">
                                <i class="litt-zzdg1 litt-zzdg2">
                                    <?php else: ?>
                                    <a href="<?php echo urldecode(U("/Home/Goods/search",array_merge($filter_param,array('recommend'=>'1')),''));?>">
                                    <i class="litt-zzdg1">
                            <?php endif; ?>
                            </i>推荐好货
                            </a>
                        </li>
                        <li>
                            <?php if(\think\Request::instance()->param('promotion') == '1'): ?>
                                <a class="red" href="<?php echo urldecode(U("/Home/Goods/search",array_merge($filter_param,array('promotion'=>'0')),''));?>">
                                <i class="litt-zzdg1 litt-zzdg2">
                                    <?php else: ?>
                                    <a href="<?php echo urldecode(U("/Home/Goods/search",array_merge($filter_param,array('promotion'=>'1')),''));?>">
                                    <i class="litt-zzdg1">
                            <?php endif; ?>
                            </i>优惠促销
                            </a>
                        </li>
                        <li>
                            <?php if(\think\Request::instance()->param('stock') == '1'): ?>
                                <a class="red" href="<?php echo urldecode(U("/Home/Goods/search",array_merge($filter_param,array('stock'=>'0')),''));?>">
                                <i class="litt-zzdg1 litt-zzdg2">
                                    <?php else: ?>
                                    <a href="<?php echo urldecode(U("/Home/Goods/search",array_merge($filter_param,array('stock'=>'1')),''));?>">
                                    <i class="litt-zzdg1">
                            <?php endif; ?>
                            </i>仅显示有货
                            </a>
                        </li>
                    </ul>
				</div>
			</div>
			<div class="shop-list-splb p">
				<ul>
                    <?php if(empty($goods_list) || (($goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator ) && $goods_list->isEmpty())): ?>
                        <p class="ncyekjl" style="font-size: 16px;margin:100px auto;text-align: center;">-- 抱歉没找到您要搜索的商品，换个条件试试！--</p>
                    <?php else: if(is_array($goods_list) || $goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator): if( count($goods_list)==0 ) : echo "" ;else: foreach($goods_list as $k=>$v): ?>
						<li>
							<div class="s_xsall">
								<div class="xs_img">
									<a href="<?php echo U('/Home/Goods/goodsInfo',array('id'=>$v[goods_id])); ?>">
										<img class="lazy-list" data-original="<?php echo goods_thum_images($v['goods_id'],236,236); ?>"/>
									</a>
								</div>
								<div class="xs_slide">
									<div class="small-xs-shop">
										<ul>
											<?php if(is_array($goods_images) || $goods_images instanceof \think\Collection || $goods_images instanceof \think\Paginator): if( count($goods_images)==0 ) : echo "" ;else: foreach($goods_images as $k2=>$v2): if($v2[goods_id] == $v[goods_id]): ?>
													<li>
														<a href="javascript:void(0);">
															<img class="lazy-list" data-original="<?php echo get_sub_images($v2,$v[goods_id],236,236); ?>"/>
														</a>
													</li>
												<?php endif; endforeach; endif; else: echo "" ;endif; ?>
										</ul>
									</div>
								</div>
								<div class="price-tag">
									<span class="now"><em class="li_xfo">￥</em><em><?php echo $v[shop_price]; ?></em></span>
									<span class="old"><em>￥</em><em><?php echo $v[market_price]; ?></em></span>
								</div>
								<div class="shop_name2">
									<a href="<?php echo U('/Home/Goods/goodsInfo',array('id'=>$v[goods_id])); ?>">
										<?php echo $v[goods_name]; ?>
									</a>
								</div>
								<div class="shop_name2">
									<a class="co_hchh" href="<?php echo U('/Home/Store/index',array('id'=>$v[store_id])); ?>">
										<?php echo $v[store_name]; ?>
									</a>
								</div>
								<div class="J_btn_statu">
									<div class="p-num">
										<input class="J_input_val" id="number_<?php echo $v['goods_id']; ?>" type="text" value="1">
										<p class="act">
											<a href="javascript:void(0);" onClick="goods_add(<?php echo $v['goods_id']; ?>);" class="litt-zzyl1"></a>
											<a href="javascript:void(0);" onClick="goods_cut(<?php echo $v['goods_id']; ?>);"  class="litt-zzyl2"></a>
										</p>
									</div>
									<div class="p-btn">
                                        <?php if(($v['is_virtual'] == 1)): ?>
                                            <a href="<?php echo U('/Home/Goods/goodsInfo',array('id'=>$v[goods_id])); ?>">查看详情</a>
                                        <?php else: ?>
                                            <a href="javascript:void(0);" onclick="AjaxAddCart(<?php echo $v[goods_id]; ?>,$('#number_'+<?php echo $v['goods_id']; ?>).val());">加入购物车</a>
                                        <?php endif; ?>
									</div>
								</div>
							</div>
						</li>
					<?php endforeach; endif; else: echo "" ;endif; endif; ?>
				</ul>
			</div>
			<div class="page p">
				<?php echo $page->show(); ?>
			</div>
		</div>
	</div>
</div>
<div class="underheader-floor p specilike">
	<div class="w1430">
		<div class="layout-title">
			<span class="fl">猜你喜欢</span>
                <span class="update_h fr" onclick="favourite();">
                    <i class="litt-hyh"></i>
                    换一换
                </span>
		</div>
		<ul class="ul-li-column p" id="favourite_goods">
		</ul>
	</div>
</div>
<div class="footer p">
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

</div>
<!--footer-e-->
<script src="__STATIC__/js/lazyload.min.js" type="text/javascript" charset="utf-8"></script>
<script src="__STATIC__/js/popt.js" type="text/javascript" charset="utf-8"></script>
<script src="__STATIC__/js/headerfooter.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $(document).ready(function(){
        favourite();
    })
    /****猜你喜欢****/
    var favorite_page = 0;
    function favourite()
    {
        favorite_page++;
        $.ajax({
            type: "GET",
            url: "/index.php?m=Home&c=Index&a=ajax_favorite&i=7&p="+favorite_page,//+tab,
            success: function (data) {
                if(data == ''){
                    favorite_page = 0;
                    favourite();
                }else{
                    $('#favourite_goods').html(data);
                    lazy_ajax();
                }

            }
        });
    }

    //更多
    $('.gd_more').parent().click(function(){
        var jed = $(this).parents('.lr-more').siblings();
        jed.toggleClass('ov-inh').find('.brand-box').toggleClass('ov-inh');
        if(jed.toggleClass('ov-inh').find('.brand-list')){
            jed.toggleClass('ov-inh').find('.brand-list').toggleClass('ov-inh');
        }
        if(jed.hasClass('ov-inh')){
            $(this).find('.gd_more').html('收起');
        }else{
            $(this).find('.gd_more').html('更多');
        }
    })
    var cancelBtn = null;
    /***多选 start*****/
    $('.dx_choice').parent().click(function(){
        var _this = this;
        var st = 0;
        var jed = $(_this).parents('.ri-section'); //当前选项层DIV

        //关闭前一个多选框
        if(cancelBtn != null){
            $(cancelBtn).parent().siblings('.clearfix').find('a').each(function(i,o){
                $(o).removeClass('addhover-js').find('.litt-zd').hide(); //针对品牌筛选的红色边框和右下角对勾隐藏
                $(o).removeClass('red_hov_cli')    //针对纯文字型选项
                        .attr('href',$(o).data('href'))  //还原连接
                        .children('input').prop('checked',false).hide(); //隐藏多选框
                $(o).unbind('click');
            });
            $(cancelBtn).parents('.lf-list').siblings('.lr-more').show(); //显示其它多选按钮
            $(cancelBtn).parents('.ri-section').removeClass('sum_ov_inh'); //移除多选样式

        }
        cancelBtn = jed.find('.u-cancel'); //前一个取消按钮

        //打开多选
        jed.addClass('sum_ov_inh'); //添加这一行的样式
        //遍历a标签
        jed.find('.clearfix>a').each(function(i,o){
            $(o).attr('href','javascript:;'); //移除连接
            $(o).children('input').show();  //显示多选框
            $(o).bind('click',function(){
                if($(o).hasClass('red_hov_cli')){
                    //取消选中
                    $(o).find('i').toggle().end().removeClass('addhover-js'); //针对品牌选项，改变筛选的选中状态
                    $(o).removeClass('red_hov_cli').end().children('input').prop('checked',false); //针对纯文字型选项选中状态
                    $(o).parent().siblings('.surclofix').children('.u-confirm').removeClass('u-confirm01');
                    st--;
                }else{
                    $(o).find('i').toggle().end().addClass('addhover-js');
                    $(o).addClass('red_hov_cli').end().children('input').prop('checked',true);
                    $(o).parent().siblings('.surclofix').children('.u-confirm').addClass('u-confirm01');
                    st++;
                }
                //如果没有选中项,确定按钮点不了
                if(st==0){
                    jed.find('.u-confirm').disabled=true;
                }
            });
        });
        //隐藏当前多选按钮
        $(_this).parent().hide();
    });

    /***多选 end*****/
        //############   取消多选        ###########
    $('.surclofix .u-cancel').each(function(){
        $(this).click(function(){
            var jed = $(this).parents('.ri-section');
            //遍历a标签
            jed.find('.clearfix>a').each(function(i,o){
                $(o).removeClass('addhover-js').find('.litt-zd').hide(); //针对品牌筛选的红色边框和右下角对勾隐藏
                $(o).removeClass('red_hov_cli')    //针对纯文字型选项，隐藏筛选的选中状态
                        .attr('href',$(o).data('href'))  //还原连接
                        .children('input').prop('checked',false).hide(); //隐藏多选框
                $(o).unbind('click');
            });
            jed.find('.lr-more').show(); //显示多选按钮
            jed.removeClass('sum_ov_inh') //移除这一行的样式
            $('.u-confirm').removeClass('u-confirm01'); //移除确定按钮可点击标识
        });
    })
    $(function(){
        //############   更多类别属性筛选start       ###########
        $('.moreamore').click(function(){
            $('.m-tr').each(function(i,o){
                if(i >  7){
                    var attrdisplay = $(o).css('display');
                    if(attrdisplay == 'none'){
                        $(o).css('display','block');
                    }
                    if(attrdisplay == 'block'){
                        $(o).css('display','none');
                    }
                }
            });
            if($(this).hasClass('checked')){
                $(this).removeClass('checked').html('<a class="red">收起</a>');
            }else{
                $(this).addClass('checked').html('<a >更多选项</a>');
            }
        })
        $('.moreamore').trigger('click').html('<a >更多选项</a>'); //  默认点击一下
        //############   更多类别属性筛选end       ###########

        /***价格排序 start*****/
        var price_i = 0;
        $('.f-sort ul li').click(function(){
            $(this).addClass('red').siblings().removeClass('red').find('i').removeClass('litt-zzx2').removeClass('litt-zzx3').addClass('litt-zzx1');
            var jd = $(this).find('i');
            price_i++;
            if(price_i>2)price_i=1;
            switch(price_i){
                case 1:jd.addClass('litt-zzx2').removeClass('litt-zzx1').removeClass('litt-zzx3');break;
                case 2:jd.addClass('litt-zzx3').removeClass('litt-zzx2').removeClass('litt-zzx1');break;
            }
        })
        /***价格排序 end*******/
        /***地址选择 start*****/
        $("#city").click(function (e) {
            SelCity(this,e);
        });
        /***地址选择 end*****/
        /***是否自营 start****/
        $('.choice-mo-shop ul li').click(function(){
            $(this).find('.litt-zzdg1').toggleClass('litt-zzdg2');
            $(this).find('a').toggleClass('red');
        })
        /***是否自营 end****/
        /***滑过浏览商品 start***/
        $('.small-xs-shop ul li').hover(function(){
            $(this).addClass('bored').siblings().removeClass('bored');
            var small_src = $(this).find('img').attr('src');
            $(this).parents('.s_xsall').find('.xs_img').find('img').attr('src',small_src);
        },function(){

        })
        /***滑过浏览商品 end***/
    })

    /****加减购物车数额***/
    function goods_cut($val){
        var num_val=document.getElementById('number_'+$val);
        var new_num=num_val.value;
        var Num = parseInt(new_num);
        if(Num>1)Num=Num-1;
        num_val.value=Num;
    }

    function goods_add($val){
        var num_val=document.getElementById('number_'+$val);
        var new_num=num_val.value;
        var Num = parseInt(new_num);
        Num=Num+1;
        num_val.value=Num;
    }
    /****加减购物车数额***/
        //############   点击多选确定按钮      ############
// t 为类型  是品牌 还是 规格 还是 属性
// btn 是点击的确定按钮用于找位置
    get_parment = <?php echo json_encode($_GET); ?>;
    function submitMoreFilter(t,btn)
    {
        // 没有被勾选的时候
        if(!$(btn).hasClass("u-confirm01")){
            return false;
        }

        // 获取现有的get参数
        var key = ''; // 请求的 参数名称
        var val = new Array(); // 请求的参数值
        $(btn).parent().siblings(".clearfix").find(".red_hov_cli").each(function(i,o){
            key = $(o).data('key');
            val.push($(o).data('val'));
        });
        //parment = key+'_'+val.join('_');
//        return false;
        // 品牌
        if(t == 'brand')
        {
            get_parment.brand_id = val.join('_');
        }
        // 规格
        if(t == 'spec')
        {
            if(get_parment.hasOwnProperty('spec'))
            {
                get_parment.spec += '@'+key+'_'+val.join('_');
            }
            else
            {
                get_parment.spec = key+'_'+val.join('_');
            }
        }
        // 属性
        if(t == 'attr')
        {
            if(get_parment.hasOwnProperty('attr'))
            {
                get_parment.attr += '@'+key+'_'+val.join('_');
            }
            else
            {
                get_parment.attr = key+'_'+val.join('_');
            }
        }
        // 组装请求的url
        var url = '';
        for ( var k in get_parment )
        {
            url += "&"+k+'='+get_parment[k];
        }
        //console.log('get_parment',get_parment);
        location.href ="/index.php?m=Home&c=Goods&a=search"+url;
    }
    //媒体查询
	$(function(){
	    window.onresize=resizeauto;
	    resizeauto();
	    function resizeauto(){
	        var windowW = $(window).width();
	        if(windowW > 1447){
	            $('.w1430,.w1224,.w1000').addClass('w1430').removeClass('w1224').removeClass('w1000');
	        }else if(windowW <= 1447 && windowW > 1241){
	            $('.w1430,.w1224,.w1000').addClass('w1224').removeClass('w1430').removeClass('w1000');
	        }else if(windowW <= 1241){
	            $('.w1430,.w1224,.w1000').addClass('w1000').removeClass('w1224').removeClass('w1430');
	        }
	    }
	})
</script>
</body>
</html>