<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:41:"./template/mobile/mobile1/user\login.html";i:1517208525;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>掌心全球购</title>
    <link rel="stylesheet" href="__STATIC__/newskin/css/base.css">
    <link rel="stylesheet" href="__STATIC__/newskin/css/mobile.css">
    <script src="__STATIC__/newskin/js/jquery.min.js"></script>


    <script src="__STATIC__/js/mobile-util.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/global.js"></script>
    <script src="__STATIC__/js/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="__STATIC__/js/swipeSlide.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/mobile_common.js"></script>


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
<body>
<header style="background-color: #fd6600;">
    <div class="h-left"><a href="javascript:;" onclick="history.go(-1)"><img src="__STATIC__/newskin/images/login/return.png"></a></div>
    <div class="h-con" style="color: #fff;">登录</div>
    <div class="h-right"><a href="javascript:;"><img src="__STATIC__/newskin/images/login/fengxiang.png"></a></div>
</header>
<div class="main main-bg">
    <div class="login-head">
        <div class="a-img">
            <img src="__STATIC__/newskin/images/login/logo-new.png">
        </div>
    </div>
    <form  class="login-warp" onsubmit="return false;"  method="post">
        <div class="login-box">
            <label for="">
                <span></span>
                <input type="text" placeholder="输入手机号/邮箱" name="username" id="username" value="">
            </label>
            <label for="">
                <span></span>
                <input type="password" placeholder="请输入密码" name="password" id="password" value="">
            </label>
        </div>
        <button class="login-btn"  onclick="submitverify()">登录</button>
        <input type="hidden" name="referurl" id="referurl" value="<?php echo $referurl; ?>">
        <div class="login-lj">
            <a href="<?php echo U('User/reg'); ?>">立即注册</a>
            <a href="<?php echo U('User/forget_pwd'); ?>">忘记密码</a>
        </div>
        <div class="login-3f">
            <div class="a-title"><div class="line"></div><span>第三方账号登录</span></div>
            <ul id='login-function'>
            <?php
                                   
                                $md5_key = md5("select * from __PREFIX__plugin where type='login' AND status = 1");
                                $result_name = $sql_result_v = S("sql_".$md5_key);
                                if(empty($sql_result_v))
                                {                            
                                    $result_name = $sql_result_v = \think\Db::query("select * from __PREFIX__plugin where type='login' AND status = 1"); 
                                    S("sql_".$md5_key,$sql_result_v,31104000);
                                }    
                              foreach($sql_result_v as $k=>$v): ?>
            	<!-- <?php if($v['code'] == 'weixin' AND is_weixin() != 1): ?>
                    <li>
                        <a class="ta-weixin" href="<?php echo U('LoginApi/login',array('oauth'=>'weixin')); ?>" target="_blank" title="weixin"></a>
                        <div class="l-img" style="background-image: url(__STATIC__/newskin/images/login/weixin@2x.png)">
                    </li>
                <?php endif; ?> -->
                <?php if($v['code'] == 'qq' AND is_qq() != 1): ?>
                    <li>
                        <a class="ta-qq" href="<?php echo U('LoginApi/login',array('oauth'=>'qq')); ?>" target="_blank" title="QQ"></a>
                        <div class="l-img" style="background-image: url(__STATIC__/newskin/images/login/qq@2x.png)">
                    </li>
                <?php endif; endforeach; ?>
            </ul>
        </div>
    </form>
</div>
<script>
    $(".main-bg").css("min-height",$(window).height());
    if($("#login-function li").length<2){
    	$("#login-function").css("justify-content",'center');
    }
</script>

<!--第三方登陆-e-->
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    function verify(){
        $('#verify_code_img').attr('src','/index.php?m=Mobile&c=User&a=verify&r='+Math.random());
    }

    //复选框状态
    function remember(obj){
         var che= $(obj).attr("class");
        if ( che == 'che'){
            $('#remember').val(1);
        }else if(che == 'che check_t'){
            $('#remember').val(0);
        }
    }
    function submitverify()
    {
        var username = $.trim($('#username').val());
        var password = $.trim($('#password').val());
        var remember = $('#remember').val();
        var referurl = $('#referurl').val();
        var verify_code = $.trim($('#verify_code').val());
        if(username == ''){
            showErrorMsg('用户名不能为空!');
            return false;
        }
        if(!checkMobile(username) && !checkEmail(username)){
            showErrorMsg('账号格式不匹配!');
            return false;
        }
        if(password == ''){
            showErrorMsg('密码不能为空!');
            return false;
        }
       /* var codeExist = $('#verify_code').length;
        if (codeExist && verify_code == ''){
            showErrorMsg('验证码不能为空!');
            return false;
        }*/

        var data = {username:username,password:password,referurl:referurl};
       /* if (codeExist) {
            data.verify_code = verify_code;
        }*/
        $.ajax({
            type : 'post',
            url : '/index.php?m=Mobile&c=User&a=do_login&t='+Math.random(),
            data : data,
            dataType : 'json',
            success : function(res){
                if(res.status == 1){
                    var url = res.url.toLowerCase();
                    if (url.indexOf('user') !==  false && url.indexOf('login') !== false || url == '') {
                        window.location.href = '/index.php/mobile';
                    }
                    window.location.href = res.url;
                }else{
                    showErrorMsg(res.msg);
                    if (codeExist) {
                        verify();
                    } else {
                        location.reload();
                    }
                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                showErrorMsg('网络失败，请刷新页面后重试');
            }
        })
    }
        //切换密码框的状态
        $(function(){
            $('.loginsingup-input .lsu i').click(function(){
                $(this).toggleClass('eye');
                if ($(this).hasClass('eye')) {
                    $(this).siblings('input').attr('type','text')
                } else{
                    $(this).siblings('input').attr('type','password')
                }
            });
        })
    /**
     * 提示弹窗
     * @param msg
     */
    function showErrorMsg(msg){
        layer.open({content:msg,time:2});
    }
    </script>
</body>
</html>
