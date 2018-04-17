<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:51:"./template/mobile/mobile1/public\dispatch_jump.html";i:1517208521;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>系统提示--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
<body class="[body]">

    <div class="classreturn loginsignup">
        <div class="content">
            <div class="ds-in-bl return">
                <!--<a href="javascript:void(0);"><img src="__STATIC__/images/return.png" alt="返回"></a>-->
            </div>
            <div class="ds-in-bl search center">
                <span>系统提示</span>
            </div>
            <!--<div class="ds-in-bl menu">
                <a href="javascript:void(0);"><img src="i__STATIC__/mages/class1.png" alt="菜单"></a>
            </div>-->
        </div>
    </div>

    <div class="successsystem">
        <?php if($code == 1) {?>
            <img src="__STATIC__/images/icogantanhao.png"></div>
        <?php }else{ ?>
            <img src="__STATIC__/images/icogantanhao-sb.png"></div>
        <?php }?>
    </div>
    <p class="prompt_s">
        <?php if($code == 1) {?><?php echo(strip_tags($msg)); }else{?>
        <?php echo(strip_tags($msg)); }?> ，等待时间：<b id="wait"><?php echo($wait); ?></b>
    </p>

    <div class="systemprompt">
        <a href="<?php echo($url); ?>" id="href">返回上一页</a>
        <a href="<?php echo U('Index/index'); ?>">返回首页</a>
    </div>

<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    (function(){
        var wait = document.getElementById('wait'),href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
    })();

</script>
</body>
</html>
