<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:41:"./template/mobile/mobile1/cart\cart4.html";i:1517479815;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\header_nav.html";i:1517208521;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>支付,提交订单--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
            <span>支付,提交订单</span>
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
<form action="<?php echo U('Mobile/Payment/getCode'); ?>" method="post" name="cart4_form" id="cart4_form">
    <div class="ddmoney">
        <div class="maleri30">
            <span class="fl">订单号</span>
            <span class="fr">
                <?php if($master_order_sn != ''): ?>
                    <?php echo $master_order_sn; else: ?>
                    <?php echo $order['order_sn']; endif; ?>
            </span>
        </div>
    </div>
    <div class="ddmoney">
        <div class="maleri30">
            <span class="fl">订单金额</span>
            <span class="fr">￥
                <?php if($master_order_sn != ''): ?>
                    <?php echo $sum_order_amount; else: ?>
                    <?php echo $order['order_amount']; endif; ?>

                元</span>
        </div>
    </div>
    <!--其他支付方式-s-->
    <div class="paylist">
        <div class="myorder debit otherpay p">
            <div class="content30">
                <a href="javascript:void(0);">
                    <div class="order">
                        <div class="fl">
                            <span>支付方式</span>
                        </div>
                        <div class="fr">
                            <!--<i class="Mright xjt"></i>-->
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="pay-list-4 p">
        <div class="maleri30">
            <ul>
                <?php if(is_array($paymentList) || $paymentList instanceof \think\Collection || $paymentList instanceof \think\Paginator): if( count($paymentList)==0 ) : echo "" ;else: foreach($paymentList as $k=>$v): ?>
                    <li  onClick="changepay(this);">
                        <lable>
                        <div class="radio fl">
							<span class="che <?php echo $k; ?>">
								<i>
                                    <input type="radio"   value="pay_code=<?php echo $v['code']; ?>" class="c_checkbox_t" name="pay_radio" style="display:none;"/>
                                </i>
							</span>
                        </div>
                        <div class="pay-list-img fl">
                            <img src="/plugins/<?php echo $v['type']; ?>/<?php echo $v['code']; ?>/<?php echo $v['icon']; ?>"/>
                        </div>
                        <div class="pay-list-font fl">
                            <?php echo $v[name]; ?>
                        </div>
                        </lable>
                    </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
    <!--其他支付方式-s-->

    <div class="paiton">
        <div class="maleri30">
            <input type="hidden" name="master_order_sn" value="<?php echo $master_order_sn; ?>" />
            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>" />
            <a class="soon" href="javascript:void(0);" onClick="pay()"><span>立即支付</span></a>
            <!--<p class="fr"><a href="javascript:void(0);" class="lossbq">支付失败？</a></p>-->
        </div>
    </div>

<!--    <div class="quickpayment">
        <div class="maleri30">
            <div class="quicks fl"><img src="__STATIC__/images/quick.png"/></div>
            <div class="paym fl">
                <p class="titp">快捷支付</p>
                <p class="spi">银行卡快捷支付服务</p>
            </div>
        </div>
    </div>
    <div class="myorder debit usedeb p">
        <div class="content30">
            <a href="javascript:void(0)">
                <div class="order">
                    <div class="fl">
                        <span>使用银行卡</span>
                    </div>
                    <div class="fr">
                        <i class="Mright xjt"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
&lt;!&ndash;选择银行卡弹窗-s&ndash;&gt;
		<div class="chooseebitcard">
			<div class="maleri30">
				<div class="choose-titr">
					<span>选择银行卡</span>
					<i class="gb-close"></i>
				</div>

				<div class="card">
					<div class="card-list">
						<div class="radio fl">
							<span class="che">
								<i>
                                    <input type="radio"   value="pay_code=<?php echo $v['code']; ?>" class="c_checkbox_t" name="pay_radio" style="display:none;"/>
                                </i>
							</span>
						</div>
						<p class="fl">&nbsp;&nbsp;<span>工商银行储蓄卡</span>&nbsp;&nbsp;<span>(3689)</span></p>
					</div>
				</div>

				<p class="teuse"><span class="red">+</span><span>使用新银行卡</span></p>
			</div>
		</div>
&lt;!&ndash;选择银行卡弹窗-e&ndash;&gt;

&lt;!&ndash;支付失败-s&ndash;&gt;
		<div class="losepay">
			<div class="maleri30">
				<p class="red">支付失败</p>
				<p class="lo-tit">以下两种情况需要您重新绑卡：</p>
				<p class="con-lo">1.信用卡有效期过期或更换了卡片</p>
				<p class="con-lo">2.修改了银行卡预留手机号码</p>
				<div class="qx-rebd">
					<a class="ax">取消</a>
					<a class="are">重新绑定</a>
				</div>
			</div>
		</div>
&lt;!&ndash;支付失败-e&ndash;&gt;-->

<div class="mask-filter-div" style="display: none;"></div>
</form>
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $(function(){
        //默认选中第一个
        $('.pay-list-4 div ul li:first').find('.che').addClass('check_t')
                .end().find(':radio').attr('checked',true);
    })
    //切换支付方式
    function changepay(obj){
        $(obj).find('.che').addClass('check_t').parents('li').siblings('li').find('.che').removeClass('check_t');
        //改变中状态
        if($(obj).find('.che').hasClass('check_t')){
            //选中
            $(obj).find(':radio').attr('checked',true);
            $(obj).siblings('li').find(':radio').removeAttr('checked');
        }else{
            //取消选中
            $(obj).find(':radio').removeAttr('checked');
        }

    }

    function pay(){
        $('#cart4_form').submit();
        return;
        //微信JS支付
    }

    $(function(){
        //使用银行卡
        $('.usedeb').click(function(){
            cover();
            $('.chooseebitcard').show();
        })
        $('.gb-close').click(function(){
            undercover();
            $('.chooseebitcard').hide();
        })

//        // 其他支付方式
//        $('.pay-list-4 ul li').click(function(){
//            $(this).find('.che').toggleClass('check_t').parents('li').siblings('li').find('.che').removeClass('check_t');
//        })

        //选择银行卡
        $('.card').click(function(){
            $(this).find('.che').toggleClass('check_t').parents('.card').siblings().find('.che').removeClass('check_t');
        })
//        $('.che').click(function(){
//            $(this).toggleClass('check_t')
//        })

        //支付失败弹窗
        $('.lossbq').click(function(){
            cover();
            $('.losepay').show();
        })
        $('.qx-rebd .ax').click(function(){
            undercover();
            $('.losepay').hide();
        })
        $('.are').click(function(){
            $('.losepay').hide();
            $('.chooseebitcard').show();
        })
    })
</script>
	</body>
</html>
