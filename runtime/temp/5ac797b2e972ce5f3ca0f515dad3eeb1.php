<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:39:"./template/mobile/mobile1/user\sex.html";i:1517208525;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\header_nav.html";i:1517208521;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>性别--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
            <a href="<?php echo U('Mobile/User/userinfo'); ?>"><img src="__STATIC__/images/return.png" alt="返回"></a>
        </div>
        <div class="ds-in-bl search center">
            <span>性别</span>
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
		<div class="loginsingup-input">
            <form action="<?php echo U('Mobile/User/userinfo'); ?>" method="post">
				<div class="content30">
					<div class="bandg">
						<ul>
							<li>
								<i class="boy"></i>
							</li>
							<li>
								<i class="girl"></i>
							</li>
                            <input type="hidden" name="sex" id="sex" value="<?php echo $user[sex]; ?>" />
						</ul>
					</div>
					<div class="lsu submit">
						<input type="submit" id="" value="确认" />
					</div>
				</div>
			</form>
		</div>
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var num = $('#sex').val();
    if(num == '1'){
        $('.bandg ul li .boy').addClass('boy_click');
    }
    if(num == '2' ){
        $('.bandg ul li .girl').addClass('girl_click');
    }
    //切换
    $(function(){
        $('.bandg ul li .boy').click(function(){
            $(this).addClass('boy_click').parent().siblings().find('.girl').removeClass('girl_click');
            $(this).parent('li').nextAll(':hidden').val(1)
        })
        $('.bandg ul li .girl').click(function(){
            $(this).addClass('girl_click').parent().siblings().find('.boy').removeClass('boy_click');
            $(this).parent('li').nextAll(':hidden').val(2)
        })
    })
</script>
</body>
</html>
