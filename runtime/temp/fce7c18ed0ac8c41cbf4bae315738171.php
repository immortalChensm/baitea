<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:44:"./template/mobile/mobile1/order\express.html";i:1517208521;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\header_nav.html";i:1517208521;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>查看物流信息--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
<body class="f3">

<div class="classreturn">
    <div class="content">
        <div class="ds-in-bl return">
            <a href="javascript:history.back(-1)"><img src="__STATIC__/images/return.png" alt="返回"></a>
        </div>
        <div class="ds-in-bl search center">
            <span>查看物流信息</span>
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
<div class="dindboxt p">
    <div class="maleri30">
        <div class="fl_addextra fl">
            <p><span class="gray">运单编号：</span><span><?php echo $delivery; ?></span></p>
            <p><span class="gray">国内承运人：</span><span><?php echo $order[shipping_name]; ?></span></p>
        </div>
        <!--<div class="fr_extra fr">-->
            <!--<a class="tuid sueye" href="javascript:void(0);">我要催单</a>-->
        <!--</div>-->
    </div>
</div>
<div class="listschdule orderrefuce ma-to-20">
    <?php if($order['shipping_code'] AND $delivery): ?>
        <p class="logis-detail-date" id="express_info"></p>
        <script>
            queryExpress();
            function queryExpress()
            {
                var shipping_code = "<?php echo $order['shipping_code']; ?>";
                var invoice_no = "<?php echo $delivery; ?>";
                $.ajax({
                    type : "GET",
                    dataType: "json",
                    url:"/index.php?m=Home&c=Api&a=queryExpress&shipping_code="+shipping_code+"&invoice_no="+invoice_no,//+tab,
                    success: function(data){
                        var html = '';
                        if(data.status == 200){
                            console.log(data);
                            $.each(data.data, function(i,o){
                                html +="<div class='tittimlord red-around'><h2>"+ o.context +"</h2> <p>"+ o.time +"</p></div>";
                            });
                        }else{
                            html +="<div class='tittimlord red-around'><h2>"+data.message+"</h2> <p></p></div>";
                        }
                        $("#express_info").after(html);
                    }
                });
            }
        </script>
    <?php endif; ?>
    <!--  物流信息 end-->
</div>
<div class="mask-filter-div" style="display: none;"></div>
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>
