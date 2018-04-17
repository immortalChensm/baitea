<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:47:"./template/mobile/mobile1/goods\ajaxSearch.html";i:1517208521;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\header_nav.html";i:1517208521;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>搜索--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
<body class="">

<div class="classreturn">
    <div class="content">
        <div class="ds-in-bl return">
            <a href="javascript:history.back(-1);"><img src="__STATIC__/images/return.png" alt="返回"></a>
        </div>
        <div class="ds-in-bl search center">
            <span>搜索</span>
        </div>
        <div class="ds-in-bl menu">
            <a href="javascript:void(0);"><img src="__STATIC__/images/class1.png" alt="菜单"></a>
        </div>
    </div>
</div>
<div class="flool tpnavf">
    <div class="footer">
        <ul>
            <li>
                <a class="yello" href="<?php echo U('Index/index'); ?>">
                    <div class="icon">
                        <i class="icon-shouye iconfont"></i>
                        <p>首页</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('Goods/categoryList'); ?>">
                    <div class="icon">
                        <i class="icon-fenlei iconfont"></i>
                        <p>分类</p>
                    </div>
                </a>
            </li>
            <li>
                <!--<a href="shopcar.html">-->
                <a href="<?php echo U('Cart/index'); ?>">
                    <div class="icon">
                        <i class="icon-gouwuche iconfont"></i>
                        <p>购物车</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('User/index'); ?>">
                    <div class="icon">
                        <i class="icon-wode iconfont"></i>
                        <p>我的</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>

		<div class="p search_pl">
			<div class="maleri30">
				<div class="search2">
                    <form method="post" action="<?php echo U('Goods/search'); ?>" id="sourch_form">
                        <div class="le_inp">
                            <input type="text" name="q" id="q" value="" placeholder="搜索商品"/>
                        </div>
                        <a href="javascript:;" onclick="ajaxsecrch()" ><div class="ri_ss"><img src="__STATIC__/images/sea.png"/></div></a>
                    </form>
				</div>
			</div>
		</div>
		<!--<div class="near-le-ri p">-->
			<!--<div class="maleri30">-->
				<!--<span>最近搜索</span>-->
				<!--<img src="__STATIC__/images/dele.png"/>-->
			<!--</div>-->
		<!--</div>-->
		<!--<div class="lb_showhide se_shien p" style="display: block;">-->
			<!--<div class="maleri30">-->
				<!--<ul>-->
					<!--<li><a href="">返回默认</a></li>-->
					<!--<li><a href="">手机数码</a></li>-->
				<!--</ul>-->
			<!--</div>-->
		<!--</div>-->
		<div class="near-le-ri p">
			<div class="maleri30">
				<span>热门搜索</span>
                <!--<a href="">-->
                    <!--<img src="__STATIC__/images/refresh.png"/>-->
                <!--</a>-->
			</div>
		</div>
		<div class="lb_showhide se_shien p" style="display: block;">
			<div class="maleri30">
				<ul>
                    <?php if(is_array($tpshop_config['hot_keywords']) || $tpshop_config['hot_keywords'] instanceof \think\Collection || $tpshop_config['hot_keywords'] instanceof \think\Paginator): if( count($tpshop_config['hot_keywords'])==0 ) : echo "" ;else: foreach($tpshop_config['hot_keywords'] as $k=>$wd): ?>
                        <li><a href="<?php echo U('Goods/search',array('q'=>$wd)); ?>" <?php if($k == 0): ?>class="ht"<?php endif; ?>><?php echo $wd; ?></a></li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
		</div>

<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>
<script>
    function ajaxsecrch(){
        if($.trim($('#q').val()) != ''){
            $("#sourch_form").submit();
        }else{
            layer.open({content:'请输入搜索关键字',time:2});
        }
    }
    $(function(){
        $('#q').focus();
    })
</script>
