<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:41:"./application/seller/new/admin\login.html";i:1517208469;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商家中心</title>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/static/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="__PUBLIC__/static/css/base.css" />
<script src="__PUBLIC__/static/js/layer/layer.js"></script>
<style type="text/css">
.sller_login {
    width: 100%;min-height: 979px;background: url(__PUBLIC__/static/images/seller/seller_login_bg.png) center center no-repeat;
}
.sller_login_warp {
    position: absolute; top: 50%;left: 0;width: 100%;
}
.ecsc-login-container {
    width: 778px;height: auto;margin: -198px auto 0;box-shadow: #444 0px 0px 30px;overflow: hidden;
}
.ecsc-login-container .login-left {
    float: left;width: 300px;height: 396px;background: url(__PUBLIC__/static/images/seller/login_left_bg.png) no-repeat;padding: 0 24px;
}
.ecsc-login-container .login-left h3 {
    font-size: 44px;color: #fff;line-height: 60px;margin-top: 50px;
}
.ecsc-login-container .login-left span {
    color: #fff;font-size: 14px;line-height: 24px;margin-top: 15px;display: block;
}
.ecsc-login-container .login-right {
    width: 304px;height: 396px; padding: 0 76px 0 50px;background: #edf9ff;float: left;
}
.ecsc-login-container .login-right .login-logo {
    margin: 60px 0 0 0;
}
.login-right .items {margin-top: 20px;}
.login-right .items .item_bor { border-bottom: 1px solid #459ee5;}
.login-right .items .item { height: 40px;line-height: 40px;position: relative;}
.mb10 {margin-bottom: 10px !important;}
.login-right .items .item b {
    position: absolute; top: 13px;left: 0px;width: 15px; text-align: center;
}
.login-right .items .item .text {
    border: 0;background: #edf9ff;width: 240px;
    float: left;height: 30px;padding: 5px 0 5px 25px;
    font-size: 14px;font-family: "microsoft yahei";
    height: 40px\0;padding: 0 0 0 25px\0;line-height: 40px\0;
}
.login-right .items .item .icon_no {
    background-position: -19px -19px;display: block;
}
.login-right .items .item i {
    background: url(__PUBLIC__/static/images/seller/logo_icon.png) no-repeat;width: 20px; height: 20px;display: none;float: right;margin-top: 10px;
}
.mb30 {
    margin-bottom: 30px !important;
}
.login-right .items .item .memory_user {
    float: left;
}
.checkbox {
    vertical-align: middle;margin: -2px 4px 0 0;
}
.login-right .items .item label {
    background: url(__PUBLIC__/static/images/seller/seller_login_checkbox.png) 0px 3px no-repeat;padding-left: 22px;color: #999;font-size: 14px;cursor: pointer;
}
.login-right .items .item .no_user {
    float: right;color: #999;font-size: 14px;text-decoration: none;
}
.login-right .items .item .login-submit {
    width: 142px;height: 45px;line-height: 45px;background: #49b9ee;color: #fff;font-size: 20px;
    font-family: "microsoft yahei";border-radius: 5px; font-weight: normal;float: right;border: 0; cursor: pointer;
}
.code-img img{width:120px;height:36px;}
.items .item .code{float:left}
.login-right .items .item .checkbox {
    display: none;display: block\9;filter: alpha(opacity=0); opacity: 0; position: absolute\9;
}
.checkbox {
    vertical-align: middle;margin: -2px 4px 0 0;
}
.login-right .items .item .checked label {
    background: url(__PUBLIC__/static/images/seller/seller_login_checkbox.png) 0px -23px no-repeat;
}
</style>
</head>
<body>
	<div class="sller_login">
    	<div class="sller_login_warp">
            <form method="post" id="form_login" action="privilege.php" name='theForm'>
            <div class="ecsc-login-container">
                <div class="login-left">
                    <h3>商家管理中心欢迎您.</h3>
                    <span>请输入您注册商铺时申请的商家名称，登录密码为商城用户通用密码。</span>
                </div>
                <div class="login-right">
                	<div class="login-logo"><img src="__PUBLIC__/static/images/seller/v2.png" /></div>
                    <div class="items">
                    	<div class="item item_bor mb10">
                        	<b><img src="__PUBLIC__/static/images/seller/login_icon01.png" /></b>
                        	<input name="username" type="text" id="username" autocomplete="off" class="text valid" placeholder="用户名" />
                            <i></i>
                        </div>
                        <div class="item item_bor mb10">
                        	<b><img src="__PUBLIC__/static/images/seller/login_icon02.png" /></b>
                        	<input name="password" type="password" id="password" autocomplete="off" class="text" placeholder="密码" />
                            <i></i>
                        </div>
                        <!-- <div class="item">
                        	<input type="text" name="vertify" id="captcha" autocomplete="off" class="text" style="width: 80px;" maxlength="4" size="10" placeholder="验证码" />
                        	<div class="code">
                                <div class="code-img"><img src="<?php echo U('Admin/vertify'); ?>" onclick="fleshVerify();" title="换一张"  name="codeimage" border="0" id="imgVerify" /></div>
                                <a href="JavaScript:void(0);" id="hide" class="close" title=""><i></i></a>
                                <a href="JavaScript:void(0);" class="change" nctype="btn_change_seccode" title=""><i></i></a>
                            </div>
                        </div> -->
                        <div class="item mb30">
                        	<div class="memory_user">
                            	<!--<input type="checkbox" value="1" name="remember" class="checkbox" id="remember"/>-->
                                <!--<label for="remember">记住密码</label>-->
                            </div>
                            <a href="<?php echo U('Home/User/forget_pwd'); ?>" class="no_user">您忘记了密码吗?</a>
                        </div>
                        <div class="item">
                        	<input type="button" class="login-submit" onclick="checkLogin()" value="登 录">
                        </div>
                        <input type="hidden" name="act" value="signin" />
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    
    <script type="text/javascript">
    	$(".memory_user .checkbox").click(function(){
			if($(this).prop("checked") == true){
				$(this).parent('.memory_user').addClass("checked");
			}else{
				$(this).parent('.memory_user').removeClass("checked");
			}
		});
		
        function checkLogin(){
            var username = $('#username').val();
            var password = $('#password').val();
            var vertify = $('input[name="vertify"]').val();
            if( username == '' || password ==''){
          	  layer.alert('用户名或密码不能为空', {icon: 2}); //alert('用户名或密码不能为空');
          	  return;
            }
           /* if(vertify ==''){
             	  layer.alert('验证码不能为空', {icon: 2});
          	  return;
            }
            if(vertify.length !=4){
             	  layer.alert('验证码错误', {icon: 2});
             	  fleshVerify();
          	  return;
            }*/
            $.ajax({
    			url:'/?m=Seller&c=Admin&a=login&t='+Math.random(),
  				type:'post',
  				dataType:'json',
  				data:{username:username,password:password,vertify:vertify},
  				success:function(res){
  					if(res.status==1){
  			     		top.location.href = res.url;
  					}else{
  						layer.alert(res.msg, {icon: 2});
                        fleshVerify();
  					}
  				},
  				error : function(XMLHttpRequest, textStatus, errorThrown) {
  					layer.alert('网络失败，请刷新页面后重试', {icon: 2});
  				}
            })
        }
		
     function fleshVerify(){
         //重载验证码
         $('#imgVerify').attr('src','/index.php?m=Seller&c=Admin&a=vertify&r='+Math.floor(Math.random()*100));
     }
    </script>
</body>
</html>
