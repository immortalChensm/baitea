<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:46:"./template/mobile/mobile1/user\forget_pwd.html";i:1517208525;}*/ ?>
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
    <div class="h-con" style="color: #fff;">找回密码</div>
    <div class="h-right"><a href="javascript:;"><img src="__STATIC__/newskin/images/login/fengxiang.png"></a></div>
</header>
<div class="main main-bg">
    <form class="forget-password" action="<?php echo U('User/forget_pwd'); ?>"  method="post" id="fpForm">
       <div class="margin-top">
           <label for="">
               <span>手机号：</span>
               <input type="text" placeholder="输入真实手机号"  name="username" id="username" value="">
               <a class="hq">发送验证码</a>
           </label>
           <label for="">
               <span>验证码：</span>
               <input type="text" placeholder="输入验证码" name="verify_code" id="verify_code" value="" >
           </label>
       </div>
       <div class="margin-top">
            <label for="">
                <span>新密码：</span>
                <input type="text" placeholder="输入新的密码">
            </label>
            <label for="">
                <span>确认密码：</span>
                <input type="text" placeholder="再次输入新密码">
            </label>
       </div>
        <button class="tj-btn" id="btn_submit">提交</button>
    </form>
</div>
<script>
    $(".main-bg").css("min-height",$(window).height());
</script>
<!-- 
<div class="loginsingup-input singupphone findpassword">
    <form action="<?php echo U('User/forget_pwd'); ?>" method="post" id="fpForm">
        <div class="content30">
            <div class="lsu bk">
                <span>账号</span>
                <input type="text" name="username" id="username" value="" placeholder="用户名 / 邮箱 / 手机号"/>
            </div>
            <div class="lsu bk ma">
                <input type="text" name="verify_code" id="verify_code" value="" placeholder="请输入验证码"/>
                <span><img src="/index.php?m=Mobile&c=User&a=verify&type=forget" id="verify_code_img" onclick="verify()"></span>
            </div>
            <div class="lsu submit">
                <input type="button" id="btn_submit"  value="下一步" />
            </div>
        </div>
    </form>
</div>
-->
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
</body>
<script>

    //加载验证码
    function verify(){
        $('#verify_code_img').attr('src','/index.php?m=Mobile&c=User&a=verify&type=forget&r='+Math.random());
    }

    $("#btn_submit").click(function(){
        var username = $.trim($('#username').val());
        var verify_code = $.trim($('#verify_code').val());
        if(username == ' '){
            showErrorMsg('账号不能为空');
            return false;
        }
       if(verify_code == ''){
           showErrorMsg('验证码不能为空');
           return false;
       }

        $.ajax({
            type:'POST',
            url:"<?php echo U('mobile/User/forget_pwd'); ?>",
            dataType:'JSON',
            data:$("#fpForm").serialize(),
            success:function(data){
                if(data.status == 1){
                    location.href=data.url;
                }else {
                    showErrorMsg(data.msg);
                    verify();
                }
            },
            error:function(){
                showErrorMsg('网络错误，请刷新后再试！');
            }
        })
    });
    /**
     * 提示弹窗
     * @param msg
     */
    function showErrorMsg(msg){
        layer.open({content:msg,time:2});
    }
</script>
</html>
