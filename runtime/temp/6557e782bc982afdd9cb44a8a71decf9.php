<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:54:"./template/mobile/mobile1/order\return_goods_list.html";i:1517208521;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\header_nav.html";i:1517208521;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>退换货列表--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
            <span>退换货列表</span>
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
    <div class="two-bothshop rechange">
        <div class="maleri30">
            <ul>
                <li><span><a href="<?php echo U('Order/return_goods_index'); ?>" class="tab_head">售后申请</a></span></li>
                <li class="red"><span><a href="<?php echo U('Order/return_goods_list'); ?>" class="tab_head">进度查询</a></span></li>
            </ul>
        </div>
    </div>
    <div class="attention-shoppay">
        <div class="searchsh">
            <form action="" method="post" id="searchform">
                <div class="seac_noord">
                    <img src="__STATIC__/images/search.png" onclick="return $('#searchform').submit()"/>
                    <input type="text" name="keywords" value="<?php echo $_POST['keywords']; ?>" placeholder="商品名称、订单编号" />
                </div>
            </form>
        </div>
    </div>
    <div class="attention-shoppay">
        <!--没有关注-s-->
        <!--<div class="comment_con p">
                <div class="none"><img src="images/none.png"><br><br>亲，此处还没有进度哦~</div>
        </div>-->
        <!--没有关注-e-->
        <?php if(is_array($return_list) || $return_list instanceof \think\Collection || $return_list instanceof \think\Paginator): if( count($return_list)==0 ) : echo "" ;else: foreach($return_list as $key=>$vo): ?>
        <div class="severde tuharecha  ma-to-20">
            <div class="myorder p">
                <div class="content30">
                    <a>
                        <div class="order">
                            <div class="fl">
                                    <span>服务单号：<em><?php echo $vo['id']; ?></em></span>
                            </div>
                            <div class="fr">
                                <span><?php echo $rtype[$vo[type]]; ?></span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="sc_list se_sclist paycloseto">
                <div class="maleri30">
                    <div class="shopimg fl">
                        <img src="<?php echo goods_thum_images($vo['goods_id'],100,100); ?>">
                    </div>
                    <div class="deleshow fr">
                        <div class="deletes">
                            <a class="daaloe"><?php echo $goodsList[$vo[goods_id]]; ?></a>
                        </div>
                        <div class="qxatten">
                            <p class="weight"><span>申请时间：</span><span><?php echo date('Y-m-d H:i:s',$vo['addtime']); ?></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="myorder p">
                <div class="content30">
                    <a href="<?php echo U('Order/return_goods_info',array('id'=>$vo[id])); ?>">
                        <div class="order">
                            <div class="fl">
                                <span class="red"><?php echo $state[$vo[status]]; ?></span>
                                <span></span>
                            </div>
                            <div class="fr">
                                <i class="Mright"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!--  
            <div class="xomjdche">
                <div class="maleri30">
                    <a href="<?php echo U('Order/return_goods_info',array('id'=>$vo[id])); ?>">进度查询</a>
                    <a class="red" href="">去评价</a>
                </div>
            </div>
            -->
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <div id="notmore"  style="font-size:.32rem;text-align: center;color:#888;padding:.25rem .24rem .4rem; clear:both;display: none">
        <a  style="font-size:.50rem;">没有更多了</a>
    </div>
    <script type="text/javascript" src="__STATIC__/js/sourch_submit.js"></script>
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        $(function(){
            $('.two-bothshop ul li').click(function(){
                $(this).addClass('red').siblings().removeClass('red');
                var gs = $('.two-bothshop ul li').index(this);
                $('.attention-shoppay').eq(gs).show().siblings('.attention-shoppay').hide();
            })
        })
        var page = 1;
        var finish = 0;
        function ajax_sourch_submit() {
            if (finish) {
                return true;
            }
            page += 1;
            $.ajax({
                type : "get",
                url:"<?php echo U('Order/return_goods_list'); ?>?is_ajax=1&p=" + page,
                success: function(data) {
                    if ($.trim(data) === '') {
                        finish = 1;
                        $('#notmore').show();
                        return false;
                    } else {
                        $(".attention-shoppay").append(data);
                    }
                }
            });
        }
    </script>
    </body>
</html>