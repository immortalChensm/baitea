<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:41:"./template/mobile/mobile1/user\email.html";i:1517208525;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\header_nav.html";i:1517208521;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>邮箱--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
            <span>邮箱</span>
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
<style>
    .fetchcode{
        background-color: #ec5151;
        border-radius: 0.128rem;
        color: white;
        padding: 0.55467rem 0.21333rem;
        vertical-align: middle;
        font-size: 0.59733rem;
    }
    #fetchcode{
        background:#898995;
        border-radius: 0.128rem;
        color: white;
        padding: 0.55467rem 0.21333rem;
        vertical-align: middle;
        font-size: 0.59733rem;
    }
</style>
		<div class="loginsingup-input singupphone findpassword">
			<form action="<?php echo U('Mobile/User/userinfo'); ?>" method="post" onsubmit="return submitverify(this)">
				<div class="content30">
					<div class="lsu bk">
						<span>邮箱</span>
						<input type="text" name="email" id="email" value="<?php echo $user['ameil']; ?>" placeholder="请输入您的邮箱" onBlur="useremail(this.value);"/>
					</div>
                    <!--<div class="lsu boo zc_se">-->
                      <!--  <input type="text" id="email_code" name="email_code" value="" placeholder="邮箱验证码">
                        <a href="javascript:void(0);" rel="email"  id="fcode" onclick="sendcode(this)">获取邮箱验证码</a>
                    </div>-->
					<div class="lsu submit">
                        <input type="submit" name="" id="" value="确认修改" />
					</div>
				</div>
			</form>
		</div>
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    //验证邮箱
    function useremail(email){
        if(email == ''){
            layer.open({content:'请输入您的邮箱！',time:3});
            return false;
        }else if(checkEmail(email)){
            $.ajax({
                type : "GET",
                url:"/index.php?m=Home&c=Api&a=issetMobileOrEmail",//+tab,
//			url:"<?php echo U('Mobile/User/comment',array('status'=>$_GET['status']),''); ?>/is_ajax/1/p/"+page,//+tab,
                data :{mobile:email},// 你的formid 搜索表单 序列化提交
                success: function(data)
                {
                    if(data == '0')
                    {
                        return true;
                    }else{
                        layer.open({content:'邮箱已存在！',time:3});
                        return false;
                    }
                }
            });
        }else{
            layer.open({content:'邮箱地址不正确！',time:3});
            return false;
        }
    }

    //提交前验证表单
    function submitverify(obj){
        var newemail2 = $.trim($('#email').val());
        if(newemail2 == ''){
            layer.open({content:'请输入您的邮箱！',time:3});
            return false;
        }
//                var emailcode = $('#mobile_code').val();
//                if(emailcode == ''){
//                    layer.open({content:'验证码不能空！',time:3});
//                    return false;
//                }
        $(obj).onsubmit();
    }
</script>
</body>
</html>
