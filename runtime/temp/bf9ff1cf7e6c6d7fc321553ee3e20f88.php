<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:47:"./template/mobile/mobile1/order\order_list.html";i:1519798454;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\header_nav.html";i:1517208521;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>我的订单--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
            <a href="<?php echo U('User/index'); ?>"><img src="__STATIC__/images/return.png" alt="返回"></a>
        </div>
        <div class="ds-in-bl search center">
            <span>我的订单</span>
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
<div class="tit-flash-sale p mytit_flash">
    <div class="maleri30">
        <ul class="addset">
            <li <?php if(\think\Request::instance()->param('type') == ''): ?>class="red"<?php endif; ?>>
                <a href="<?php echo U('/Mobile/Order/order_list'); ?>" class="tab_head">全部订单</a>
            </li>
            <li id="WAITPAY" <?php if(\think\Request::instance()->param('type') == 'WAITPAY'): ?>class="red"<?php endif; ?>">
                <a href="<?php echo U('/Mobile/Order/order_list',array('type'=>'WAITPAY')); ?>" class="tab_head" >待付款</a>
            </li>
            <li id="WAITSEND" <?php if(\think\Request::instance()->param('type') == 'WAITSEND'): ?>class="red"<?php endif; ?>>
                <a href="<?php echo U('/Mobile/Order/order_list',array('type'=>'WAITSEND')); ?>"  class="tab_head">待发货</a>
            </li>
            <li id="WAITRECEIVE"  <?php if(\think\Request::instance()->param('type') == 'WAITRECEIVE'): ?>class="red"<?php endif; ?>>
                <a href="<?php echo U('/Mobile/Order/order_list',array('type'=>'WAITRECEIVE')); ?>" class="tab_head">待收货</a>
            </li>
            <li id="WAITCCOMMENT"  <?php if(\think\Request::instance()->param('type') == 'WAITCCOMMENT'): ?>class="red"<?php endif; ?>>
                <a href="<?php echo U('/Mobile/Order/order_list',array('type'=>'WAITCCOMMENT')); ?>" class="tab_head">已完成</a>
            </li>
        </ul>
    </div>
</div>

    <!--订单列表-s-->
    <div class="ajax_return">
        <?php if(count($order_list) == 0): ?>
            <!--没有内容时-s--->
            <div class="comment_con p">
                <div class="none">
                    <img src="__STATIC__/images/none2.png">
                    <br><br>抱歉未查到数据！
                    <div class="paiton">
                        <div class="maleri30">
                            <a class="soon" href="<?php echo U('Index/index'); ?>"><span>去逛逛</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <!--没有内容时-e--->
            <?php else: if(is_array($order_list) || $order_list instanceof \think\Collection || $order_list instanceof \think\Paginator): $i = 0; $__LIST__ = $order_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?>
                <div class="mypackeg ma-to-20 getmore">
                    <div class="packeg p">
                        <div class="maleri30">
                            <div class="fl">
                                <h1>
                                   <a href="<?php echo U('mobile/Store/index',['store_id'=>$order['store']['store_id']]); ?>"><span class="bg"></span><span class="bgnum"><?php echo $order['store']['store_name']; ?></span></a>
                                </h1>
                                <p class="bgnum"><span>订单编号:</span><span><?php echo $order['order_sn']; ?></span></p>
                            </div>
                            <div class="fr">
                                <span><?php echo $order['order_status_detail']; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="shop-mfive p">
                        <div class="maleri30">
                            <?php if(is_array($order['order_goods']) || $order['order_goods'] instanceof \think\Collection || $order['order_goods'] instanceof \think\Paginator): if( count($order['order_goods'])==0 ) : echo "" ;else: foreach($order['order_goods'] as $key=>$good): ?>
                                <div class="sc_list se_sclist paycloseto">
                                    <?php if($order['order_prom_type'] != 5): ?>
                                        <!--普通订单-->
                                        <a <?php if($order['receive_btn'] == 1): ?>href="<?php echo U('/Mobile/Order/order_detail',array('id'=>$order['order_id'],'waitreceive'=>1)); ?>" <?php else: ?> href="<?php echo U('/Mobile/Order/order_detail',array('id'=>$order['order_id'])); ?>"<?php endif; ?>>
                                    <?php else: ?>
                                        <!--虚拟订单-->
                                        <a href="<?php echo U('/Mobile/Order/virtual_order',array('order_id'=>$order['order_id'])); ?>">
                                    <?php endif; ?>
                                    <div class="shopimg fl">
                                        <img src="<?php echo goods_thum_images($good[goods_id],200,200); ?>">
                                    </div>
                                    <div class="deleshow fr">
                                        <div class="deletes">
                                            <span class="similar-product-text"><?php echo getSubstr($good[goods_name],0,20); ?></span>
                                        </div>
                                        <div class="des-mes">
                                            <span class="similar-pro-text"><?php echo $good['spec_key_name']; ?></span>
                                        </div>
                                        <div class="prices  wiconfine">
                                            <p class="sc_pri"><span>￥</span><span><?php echo $good[member_goods_price]; ?></span></p>
                                        </div>
                                        <div class="qxatten  wiconfine">
                                            <p class="weight"><span>数量</span>&nbsp;<span><?php echo $good[goods_num]; ?></span></p>
                                        </div>
                                        <div class="buttondde">
                                            <?php if(($order['order_button'][return_btn] == 1) and ($good[is_send] > 0)): ?>
                                                <a href="<?php echo U('Mobile/Order/return_goods',['rec_id'=>$good['rec_id']]); ?>">申请售后</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </div>
                    <div class="shop-rebuy-price p">
                        <div class="maleri30">
			                <span class="price-alln">
			                    <span class="threel">共<?php echo count($order['order_goods']); ?>件商品</span>
			                    	<!--实付款：<span class="red">￥<?php echo $order['order_amount']; ?></span>-->
			                    	订单总价：<span class="red">￥<?php echo $order['total_amount']; ?></span>
			                    	<span class="threel">(含运费￥<?php echo $order['shipping_price']; ?>)</span>
			                </span>
                        </div>
                    </div>
                    <div class="shop-rebuy-price p">
                        <div class="maleri30">
                            <?php if($order['order_button'][pay_btn] == 1): ?>
                                    <!--<a class="shop-rebuy paysoon" href="<?php echo U('Mobile/Cart/cart4',array('master_order_sn'=>$order['master_order_sn'])); ?>">立即付款</a>-->
                                    <a class="shop-rebuy paysoon" href="<?php echo U('Mobile/Cart/cart4',array('order_id'=>$order['order_id'])); ?>">立即付款</a>
                            <?php endif; if($order['order_button'][cancel_btn] == 1 && $order['pay_status'] == 0): ?>
                                <a class="shop-rebuy " onClick="cancel_order(<?php echo $order['order_id']; ?>)">取消订单</a>
                            <?php endif; if($order['order_button'][cancel_info] == 1): ?>
                                  <a class="consoorder" href="<?php echo U('Order/cancel_order_info',array('order_id'=>$order[order_id])); ?>">取消详情</a>
                             <?php endif; if($order['order_button'][receive_btn] == 1): ?>
                                <a class="shop-rebuy paysoon"  onclick="order_confirm(<?php echo $order['order_id']; ?>)">确认收货</a>
                            <?php endif; if($order['order_button'][comment_btn] == 1): ?>
                                <a class="shop-rebuy" href="<?php echo U('Mobile/Order/comment',['status'=>0]); ?>">评价晒单</a>
                            <?php endif; if($order['order_button'][shipping_btn] == 1): ?>
                                <a class="shop-rebuy" class="shop-rebuy" href="<?php echo U('Mobile/Order/express',array('order_id'=>$order['order_id'])); ?>">查看物流</a>
                            <?php endif; ?>
                        </div>
                   </div>        
                </div>
            <?php endforeach; endif; else: echo "" ;endif; endif; ?>
    </div>
    <!--订单列表-e-->
    <!--加载更多-s-->
<?php if(!empty($order_list)): ?>
    <div id="getmore"  style="font-size:.32rem;text-align: center;color:#888;padding:.25rem .24rem .4rem; clear:both;display: none">
        <a >已显示完所有记录</a>
    </div>
<?php endif; ?>
<script type="text/javascript" src="__STATIC__/js/sourch_submit.js"></script>
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">

    /**
     * 确认收货
     * @param orderId
     */
    function order_confirm(orderId)
    {
        if(!confirm("确定收货?"))
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
                
                
                
                console.log(data);
                
                
            },
            error : function() {
                layer.open({content:'网络失败，请刷新页面后重试', time: 2});
            }
        })
    }

    /**
     * 取消订单
     */
    function cancel_order(id){
        if(!confirm("确定取消订单?"))
            return false;
        $.ajax({
            type: 'GET',
            url:"/index.php?m=Mobile&c=Order&a=cancel_order&id="+id,
            dataType:'JSON',
            success:function(data){
                if(data.status == 1){
                    layer.open({content:data.msg,time:2});
                    location.href = "/index.php?m=Mobile&c=Order&a=order_list";
                }else{
                    layer.open({content:data.msg,time:2});
                    return false;
                }
            },
            error:function(){
                layer.open({content:'网络失败，请刷新页面后重试',time:3});
            },
        });
    }

    var  page = 1;
    /**
     *加载更多
     */
    function ajax_sourch_submit()
    {
        page += 1;
        $.ajax({
            type : "GET",
            url:"/index.php?m=Mobile&c=Order&a=order_list&type=<?php echo \think\Request::instance()->param('type'); ?>&is_ajax=1&p="+page,//+tab,
            success: function(data)
            {
                if(data == '') {
                    $('#getmore').show();
                    return false;
                }else{
                    $(".ajax_return").append(data);
                    $(".m_loading").hide();
                }
            }
        });
    }
</script>
</body>
</html>
