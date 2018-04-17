<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:45:"./template/mobile/mobile1/user\setMobile.html";i:1517208525;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\header_nav.html";i:1517208521;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>手机号--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
            <span>手机号</span>
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
        pointer-events: none;
        background:#898995;
        border-radius: 0.128rem;
        color: white;
        padding: 0.55467rem 0.21333rem;
        vertical-align: middle;
        font-size: 0.59733rem;
    }
</style>
		<div class="loginsingup-input singupphone findpassword">
            <form action="<?php echo U('Mobile/User/setMobile'); ?>" method="post" onsubmit="return submitverify(this)">
				<div class="content30">
					<div class="lsu bk">
						<span>手机号</span>
                        <?php if($user['mobile'] && $status != 1): ?>
                            <input type="text" name="mobile" value="<?php echo $user['mobile']; ?>" id="tel" readonly/>
                            <input type="hidden" name="status" value="1"/>
                        <?php else: ?>
                            <input type="text" name="mobile"  id="tel" onBlur="checkMobilePhone(this.value);" maxlength="11"/>
                            <input type="hidden" name="validate" value="1"/>
                            <input type="hidden" name="status" value="0"/>
                        <?php endif; ?>
					</div>
                    <div class="lsu boo zc_se">
                        <input type="text" name="mobile_code" id="mobile_code" value="" placeholder="请输入验证码">
                        <a href="javascript:void(0);" rel="mobile" id="fcode" onclick="sendcode(this)">获取短信验证码</a>
                    </div>
					<div class="lsu submit">
                        <?php if($user['mobile'] && $status != 1): ?>
                            <input type="submit" name=""  value="下一步" />
                        <?php else: ?>
                            <input type="submit" name="" id="" value="确认修改" />
                        <?php endif; ?>
					</div>
				</div>
			</form>
		</div>
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
<script>
    //手机验证
    function checkMobilePhone(mobile){
        if(mobile == ''){
            showErrorMsg('请输入您的手机号');
            return false;
        }else  if(checkMobile(mobile)) {
            $.ajax({
                type: "GET",
                url: "/index.php?m=Home&c=Api&a=issetMobile",//+tab,
//			url:"<?php echo U('Mobile/User/comment',array('status'=>$_GET['status']),''); ?>/is_ajax/1/p/"+page,//+tab,
                data: {mobile: mobile},// 你的formid 搜索表单 序列化提交
                success: function (data) {
                    if (data == '0') {
                        $(obj).removeAttr('id');
                        return true;
                    } else {
                        $('#fcode').attr('id','fetchcode');
                        showErrorMsg('手机号已存在！');
                        return false;
                    }
                }
            });
        }else{
            showErrorMsg('手机号码格式不正确！');
            return false;
        }
    }
    //发送短信验证码
    function sendcode(obj){
        var tel = $.trim($('#tel').val());
        if(tel == ''){
            showErrorMsg('请输入您的号码！');
            return false;
        }
        $.ajax({
//            url:'/index.php?m=Mobile&c=User&a=send_validate_code&t='+Math.random(), //原获取短信验证码方法
            url : "/index.php?m=Home&c=Api&a=send_validate_code&scene=6&type=mobile&send="+tel,
            type:'post',
            dataType:'json',
            data:{type:$(obj).attr('rel'),send:tel},
            success:function(res){
                if(res.status==1){
                    //成功
                    showErrorMsg(res.msg);
                    countdown(obj);
                }else{
                    //失败
                    showErrorMsg(res.msg);
                    $(obj).text('请刷新后再试！');
                    $(obj).attr('id','fetchcode');
                }
            }
        })
    }

    function countdown(obj){
        var obj = $(obj);
        var s = <?php echo $tpshop_config['sms_sms_time_out']; ?>;
        //改变按钮状态
        obj.unbind('click');
        //添加样式
        obj.attr('id','fetchcode');
        callback();
        //循环定时器
        var T = window.setInterval(callback,1000);
        function callback()
        {
            if(s <= 0){
                //移除定时器
                window.clearInterval(T);
                obj.bind('click',sendcode)
                obj.removeAttr('id','fetchcode');
                obj.text('获取短信验证码');
            }else{
                obj.text(--s + '秒后再获取');
            }
        }
    }
    //提交前验证表单
    function submitverify(obj){
        var tel = $.trim($('#tel').val());
        if(tel == ''){
            showErrorMsg('请输入您的手机号！');
            return false;
        }
        if($('#mobile_code').val() == ''){
            showErrorMsg('验证码不能空！');
            return false;
        }
        $(obj).onsubmit();
    }
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
