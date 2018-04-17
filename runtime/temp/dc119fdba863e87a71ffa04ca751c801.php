<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:47:"./template/mobile/mobile1/user\withdrawals.html";i:1517208525;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\header_nav.html";i:1517208521;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>申请提现--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
            <a href="javascript:history.back(-1)"><img src="__STATIC__/images/return.png" alt="返回"></a>
        </div>
        <div class="ds-in-bl search center">
            <span>申请提现</span>
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
<input type="hidden" id="openid" value="<?php echo $user['openid']; ?>">
		<div class="loginsingup-input ma-to-20">
			<form method="post" id="returnform">
				<div class="content30">
					<div class="lsu" style="height:1.83467rem"><span>账号类型：</span>
                          <input type="radio" name="atype" style="width:.8rem;height:1rem;" checked value="支付宝">支付宝
                          <input type="radio" name="atype" style="width:.8rem;height:1rem;" value="微信">微信
                          <input type="radio" name="atype" style="width:.8rem;height:1rem;" value="银行卡">银行卡
					</div>
					<div class="lsu">
						<span>收款账号：</span>
						<input type="text" name="bank_card" id="bank_card" maxlength="18" placeholder="收款账号" onKeyUp="this.value=this.value.replace(/[^\d]/g,'')">
					</div>
					<div class="lsu">
						<span>开户名：</span>
						<input type="text" name="realname" id="realname" value=""  placeholder="持卡人姓名">
					</div>
					<div class="lsu">
						<span>银行名称：</span>
						<input type="text" name="bank_name" id="bank_name" value="" placeholder="如：工商银行，支付宝，微信">
					</div>
                    <div class="lsu">
                        <span>提现金额：</span>
                        <input type="text" name="money" id="money" value="" usermoney="<?php echo $user['user_money']; ?>" placeholder="可提现金额：<?php echo $user['user_money']; ?>元" onKeyUp="this.value=this.value.replace(/[^\d.]/g,'')">
                    </div>
                    <div class="lsu test">
                        <span>验证码：</span>
                        <input type="text" name="verify_code" id="verify_code" value="" placeholder="请输入验证码">
                        <img  id="verify_code_img" src="<?php echo U('User/verify',array('type'=>'withdrawals')); ?>" onClick="verify()" style=""/>
                    </div>
					<div class="lsu submit">
                        <input type="hidden" name="__token__" value="<?php echo \think\Request::instance()->token(); ?>" />
						<input type="button" onclick="checkSubmit()" value="提交申请">
					</div>
				</div>
			</form>
		</div>
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    // 验证码切换
    function verify(){
        $('#verify_code_img').attr('src','/index.php?m=Mobile&c=User&a=verify&type=withdrawals&r='+Math.random());
    }

    /**
     * 提交表单
     * */
    function checkSubmit(){
        var bank_name = $.trim($('#bank_name').val());
        var bank_card = $.trim($('#bank_card').val());
        var realname = $.trim($('#realname').val());
        var money = parseFloat($.trim($('#money').val()));
        var usermoney = parseFloat(<?php echo $user_money; ?>);  //用户余额
        var verify_code = $.trim($('#verify_code').val());
        //验证码
        if(verify_code == '' ){
            showErrorMsg('验证码不能空')
            return false;
        }
        if(bank_name == '' || bank_card == '' || realname=='' || money === ''){
            showErrorMsg("所有信息为必填")
            return false;
        }
        if(money > usermoney){
            showErrorMsg("提现金额大于您的账户余额")
            return false;
        }
        $.ajax({
            type: "post",
            url :"<?php echo U('Mobile/User/withdrawals'); ?>",
            dataType:'json',
            data:$('#returnform').serialize(),
            success: function(data)
            {
                showErrorMsg(data.msg);
                if(data.status == 1){
                    window.location.href=data.url;
                } else {
//                    window.location.reload();
                    verify();
                }
            }
        });
    }
    /**
     * 提示弹窗
     * @param msg
     */
    function showErrorMsg(msg){
        layer.open({content:msg,time:3});
    }
    
    $(function(){
    	$('input[name="atype"]').click(function(){
    		var bankstr = $(this).val();
    		if(bankstr =='微信'){
    			if($('#openid').val() == ''){
    				alert('请在用户中心账号绑定里先扫码绑定微信账号');
    				return false;
    			}
    		}
    		if(bankstr != '银行卡'){
    			$('#bank_name').val(bankstr);
    			$('#bank_name').attr('readonly','readonly');
    			if(bankstr == '微信'){
    				$('#bank_card').val($('#openid').val());
    				$('#bank_card').attr('readonly','readonly');
    			}else{
    				$('#bank_card').val('');
    				$('#bank_card').removeAttr('readonly');
    			}
    		}else{
    			$('#bank_name').val('');
    			$('#bank_name').removeAttr('readonly');
    		}
    	})
    });
</script>
	</body>
</html>
