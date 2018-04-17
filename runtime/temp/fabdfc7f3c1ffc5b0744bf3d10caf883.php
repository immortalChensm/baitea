<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:49:"./template/mobile/mobile1/order\order_detail.html";i:1517208521;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\header_nav.html";i:1517208521;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>订单详情--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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

<div class="classreturn">
    <div class="content">
        <div class="ds-in-bl return">
            <a href="javascript:history.go(-1);"><img src="__STATIC__/images/return.png" alt="返回"></a>
        </div>
        <div class="ds-in-bl search center">
            <span>订单详情</span>
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
.apply_service{
	 display: block;
    margin-top: .34133rem;
    line-height: 2;
    text-align: center;
    border: 1px solid #ddd;
	
}
</style>
<div class="edit_gtfix">
        <div class="namephone fl">
            <div class="top">
                <div class="le fl"><?php echo $order_info['consignee']; ?></div>
                <div class="lr fl"><?php echo $order_info['mobile']; ?></div>
            </div>
            <div class="bot">
                <i class="dwgp"></i>
                <span><?php echo $region_list[$order_info['province']]; ?>,<?php echo $region_list[$order_info['city']]; ?>,<?php echo $region_list[$order_info['district']]; ?>,<?php echo $order_info['address']; ?></span>
            </div>
        </div>
        <div class="fr youjter">
        </div>
        <div class="ttrebu">
            <img src="__STATIC__/images/tt.png"/>
        </div>
</div>
<div class="packeg p">
    <div class="maleri30">
        <div class="fl">
            <h1><span class="bg"></span><span class="bgnum"></span><span><?php echo $store['store_name']; ?></span></h1>
            <h1></h1>
        </div>
        <div class="fr">
            <span><?php echo $order_info['order_status_desc']; ?></span>
        </div>
    </div>
</div>
<!--订单商品列表-s-->
<div class="ord_list p">
    <div class="maleri30">
        <?php if(is_array($order_info['goods_list']) || $order_info['goods_list'] instanceof \think\Collection || $order_info['goods_list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $order_info['goods_list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$good): $mod = ($i % 2 );++$i;?>
            <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$good[goods_id])); ?>">
                <div class="shopprice">
                    <div class="img_or fl">
                        <img src="<?php echo goods_thum_images($good[goods_id],100,100); ?>"/>
                    </div>
                    <div class="fon_or fl">
                        <h2 class="similar-product-text"><?php echo $good[goods_name]; ?> <?php echo $good[goods_id]; ?></h2>
                        <div><span class="bac"><?php echo $good['spec_key_name']; ?></span></div>
                    </div>
                    <div class="price_or fr">
                        <p><span>￥</span><span><?php echo $good['member_goods_price']; ?></span></p>
                        <p>x<?php echo $good['goods_num']; ?></p>
                        <?php if(($order_info['return_btn'] == 1) and ($good[is_send] > 0)): ?>
                        	<a class="apply_service" href="<?php echo U('Mobile/Order/return_goods',['rec_id'=>$good['rec_id']]); ?>">申请售后</a>
                        <?php endif; ?>
                    </div>  
                </div>
            </a>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>
<!--订单商品列表-e-->
<div class="qqz">
    <div class="maleri30">
        <a href="tel:<?php echo $store['store_phone']; ?>">联系客服</a>
        <?php if($order_info['cancel_btn'] == 1 && $order_info['pay_status'] == 0): ?>
            <a class="closeorder_butt" >取消订单</a>
        <?php endif; if($order_info['cancel_btn'] == 1 && $order_info['pay_status'] == 1): ?>
            <a href="<?php echo U('Order/refund_order', ['order_id'=>$order_info['order_id']]); ?>">取消订单</a>
        <?php endif; ?>
    </div>
</div>
<div class="information_dr ma-to-20">
    <div class="maleri30">
        <div class="tit">
            <h2>基本信息</h2>
        </div>
        <div class="xx-list">
            <p class="p">
                <span class="fl">订单编号</span>
                <span class="fr"><?php echo $order_info['order_sn']; ?></span>
            </p>
            <p class="p">
                <span class="fl">下单时间</span>
                <span class="fr"><span><?php echo date('Y-m-d  H:i:s', $order_info['add_time']); ?></span></span>
            </p>
            <p class="p">
                <span class="fl">收货地址</span>
                <span class="fr"><?php echo $region_list[$order_info[province]]; ?>&nbsp;<?php echo $region_list[$order_info[city]]; ?>&nbsp;<?php echo $region_list[$order_info[district]]; ?>&nbsp;<?php echo $order_info[address]; ?></span>
            </p>
            <p class="p">
                <span class="fl">收货人</span>
                <span class="fr"><span><?php echo $order_info['consignee']; ?></span><span><?php echo $order_info['mobile']; ?></span></span>
            </p>
            <p class="p">
                <span class="fl">支付方式</span>
                <span class="fr">
                     <?php if($order_info[pay_status] == 1 and empty($order_info['pay_name'])): ?>
                         其他支付
                     <?php else: ?>
                         <?php echo $order_info['pay_name']; endif; ?>
                </span>
            </p>
            <p class="p">
                <span class="fl">配送方式</span>
                <span class="fr"><?php echo $order_info['shipping_name']; ?></span>
            </p>
        </div>
    </div>
</div>
<div class="information_dr ma-to-20">
    <div class="maleri30">
        <div class="tit">
            <h2>价格信息</h2>
        </div>
        <div class="xx-list">
            <p class="p">
                <span class="fl">商品总价</span>
                <span class="fr"><span>￥</span><span><?php echo (isset($order_info['goods_price']) && ($order_info['goods_price'] !== '')?$order_info['goods_price']:'0.00'); ?></span>元</span>
            </p>
            <p class="p">
                <span class="fl">运费</span>
                <span class="fr"><span>￥</span><span><?php echo (isset($order_info['shipping_price']) && ($order_info['shipping_price'] !== '')?$order_info['shipping_price']:'0.00'); ?></span>元</span>
            </p>
            <p class="p">
                <span class="fl">优惠券</span>
                <span class="fr"><span>-￥</span><span><?php echo (isset($order_info['coupon_price']) && ($order_info['coupon_price'] !== '')?$order_info['coupon_price']:'0.00'); ?></span>元</span>
            </p>
            <p class="p">
                <span class="fl">积分</span>
                <span class="fr"><span>-￥</span><span><?php echo (isset($order_info['integral_money']) && ($order_info['integral_money'] !== '')?$order_info['integral_money']:'0.00'); ?></span>元</span>
            </p>
            <p class="p">
                <span class="fl">余额</span>
                <span class="fr"><span>-￥</span><span><?php echo (isset($order_info['user_money']) && ($order_info['user_money'] !== '')?$order_info['user_money']:'0.00'); ?></span>元</span>
            </p>
            <p class="p">
                <span class="fl">活动优惠</span>
                <span class="fr"><span>-￥</span><span><?php echo (isset($order_info['order_prom_amount']) && ($order_info['order_prom_amount'] !== '')?$order_info['order_prom_amount']:'0.00'); ?></span>元</span>
            </p>
            <p class="p">
                <span class="fl">实付金额</span>
                <span class="fr red"><span>￥</span><span><?php echo $order_info['order_amount']; ?></span>元</span>
            </p>
        </div>
    </div>
</div>

<!--取消订单-s-->
<div class="losepay closeorder" style="display: none;">
    <div class="maleri30">
        <p class="con-lo">取消订单后,存在促销关系的子订单及优惠可能会一并取消。是否继续？</p>
        <div class="qx-rebd">
            <a class="ax">取消</a>
            <a class="are" onclick="cancel_order(<?php echo $order_info['order_id']; ?>)">确定</a>
        </div>
    </div>
</div>
<!--取消订单-e-->

<div class="mask-filter-div" style="display: none;"></div>

<!--底部支付栏-s-->
<div class="payit ma-to-20">
    <!--<div class="fl">-->
            <!--<p><span class="pmo">实付金额：</span>-->
                <!--<span>￥</span><span><?php echo $order_info['order_amount']+$order_info['shipping_price']; ?></span>-->
            <!--</p>-->
            <!--<p class="lastime"><span>付款剩余时间：</span><span id="lasttime"></span></p>-->
            <!--&lt;!&ndash;<p class="deel"><a href="<?php echo U('Mobile/User/order_del',array('order_id'=>$order_info['order_id'])); ?>">删除订单</a></p>&ndash;&gt;-->
    <!--</div>-->
    <div class="fr s">
        <?php if($order_info['pay_btn'] == 1): ?>
            <a href="<?php echo U('Mobile/Cart/cart4',array('order_id'=>$order_info['order_id'])); ?>">立即付款</a>
        <?php endif; if($order_info['receive_btn'] == 1): ?>
            <a onclick="order_confirm(<?php echo $order_info['order_id']; ?>)">收货确认</a>
        <?php endif; if($order_info['shipping_btn'] == 1): ?>
            <a href="<?php echo U('Mobile/Order/express',array('order_id'=>$order_info['order_id'])); ?>" >查看物流</a>
        <?php endif; ?>
        
    </div>
</div>
<!--底部支付栏-d-->
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    //取消订单按钮
    $('.closeorder_butt').click(function(){
        $('.mask-filter-div').show();
        $('.losepay').show();
    })
    //取消取消订单
    $('.qx-rebd .ax').click(function(){
        $('.mask-filter-div').hide();
        $('.losepay').hide();
    })
    /**
     * 确认收货
     * @param orderId
     */
    function order_confirm(orderId)
    {
        if(!confirm("确认收货?"))
            return false;
        $.ajax({
            url:"<?php echo U('Order/order_confirm'); ?>",
            type:'POST',
            dataType:'JSON',
            data:{order_id:orderId},
            success:function(data){
                if(data.status == 1){
                    layer.open({content:data.msg, time:2});
                    location.href ='/index.php?m=mobile&c=Order&a=order_detail&id='+orderId;
                }else{
                    layer.open({content:data.msg, time:2});
                    location.href ='/index.php?m=mobile&c=Order&a=order_list&type=<?php echo \think\Request::instance()->param('type'); ?>&p=<?php echo \think\Request::instance()->param('p'); ?>';
                }
            },
            error : function() {
                layer.open({content:'网络失败，请刷新页面后重试', time: 2});
            }
        })
    }

    //确认取消订单
    function cancel_order(id){
        $.ajax({
            type: 'GET',
            url:"/index.php?m=Mobile&c=Order&a=cancel_order&id="+id,
            dataType:'JSON',
            success:function(data){
                if(data.status == 1){
                    //成功
                    layer.open({content:data.msg,time:2});
                    location.href = "/index.php?m=Mobile&c=Order&a=order_detail&id="+id;
                }else{
                    //状态不允许
                    layer.open({content:data.msg,time:2});
                    return false;
                }
            },
            error:function(){
                layer.open({content:'网络失败，请刷新页面后重试',time:3});
            },
        });
        $('.mask-filter-div').hide();
        $('.losepay').hide();
    }


    //        $('.loginsingup-input .lsu i').click(function(){
    //            $(this).toggleClass('eye');
    //            if ($(this).hasClass('eye')) {
    //                $(this).siblings('input').attr('type','text')
    //            } else{
    //                $(this).siblings('input').attr('type','password')
    //            }
    //        });
</script>
</body>
</html>
