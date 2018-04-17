<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:47:"./template/mobile/mobile1/newjoin\guidance.html";i:1517208521;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>个人中心--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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

<body>
<div class="banner1-joinus"><img src="__STATIC__/images/setupshop/banner1-joinus.jpg" alt="" /></div>
<div class="joinus-main-index">
    <div class="joinus-steps">
        <div class="steps">
            <i>1</i>提交门店信息，补全证照<span class="arrow-down"></span>
        </div>
        <div class="steps-des">请提交真实有效的信息！</div>
        <div class="steps">
            <i>2</i>审核资质，门店上架
        </div>
        <div class="steps-des">门店资料提交审核后，审核结果将在<span class="co-orange">1-3个工作日</span>内通知您</div>
    </div>
    <div class="joinus-mes">
        <h5>申请成功后，我们将按照以下标准收取服务费：</h5>
        <p>A服务费：标准介绍和费率介绍...</p>
        <p>B服务费：标准介绍和费率介绍...</p>
        <p>C服务费：标准介绍和费率介绍...</p>
    </div>
</div>
<div class="btns-fixed-bottom btns-1">
    <a class="btns-a" href="<?php echo U('Newjoin/basic_info'); ?>">立即开店</a>
</div>
</body>
</html>