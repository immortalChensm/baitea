<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:47:"./template/mobile/mobile1/user\points_list.html";i:1517208525;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\header_nav.html";i:1517208521;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>积分明细记录--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
            <span>积分明细记录</span>
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
<div class="allaccounted">
    <div class="maleri30">
        <div class="head_acc ma-to-20">
            <ul>
                <li <?php if($type == 'all'): ?>class="red"<?php endif; ?>">
                    <a href="<?php echo U('User/points_list',array('type'=>'all')); ?>"  data-list="1">全部</a>
                </li>
                <li <?php if($type == 'plus'): ?>class="red"<?php endif; ?>>
                    <a href="<?php echo U('User/points_list',array('type'=>'plus')); ?>"   data-list="2">赚取</a>
                </li>
                <li  <?php if($type == 'minus'): ?>class="red"<?php endif; ?>>
                    <a href="<?php echo U('User/points_list',array('type'=>'minus')); ?>"  data-list="3">消费</a>
                </li>
            </ul>
        </div>
        <div class="allpion">
	         <div class="fll_acc">
	         	<ul><li class="orderid-h">订单号</li><li class="price-h">积分</li><li class="time-h">时间</li></ul>
	         </div>
             <?php if(is_array($account_log) || $account_log instanceof \think\Collection || $account_log instanceof \think\Paginator): if( count($account_log)==0 ) : echo "" ;else: foreach($account_log as $key=>$v): ?>
                 <div class="fll_acc">
                     <ul>
                         <li class="orderid-h"><?php echo (isset($v[order_sn]) && ($v[order_sn] !== '')?$v[order_sn]:'无'); ?></li>
                         <li class="price-h"><?php echo $v[pay_points]; ?></li>
                         <li class="time-h"><?php echo date('Y-m-d H:i:s',$v[change_time]); ?></li>
                     </ul>
                     <div class="des-h">描述:<?php echo $v[desc]; ?></div>
                 </div>
             <?php endforeach; endif; else: echo "" ;endif; ?>
         </div>
        <div id="getmore"  style="font-size:.32rem;text-align: center;color:#888;padding:.25rem .24rem .4rem; clear:both;display: none">
            <a >已显示完所有记录</a>
        </div>
    </div>
</div>

<script type="text/javascript" src="__STATIC__/js/sourch_submit.js"></script>
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    //加载更多记录
    var page = 0;
    function ajax_sourch_submit()
    {
        page ++;
        $.ajax({
            type : "GET",
            url:"/index.php?m=mobile&c=User&a=points_list&is_ajax=1&type=<?php echo $type; ?>&p="+page,//+tab,
            success: function(data)
            {
                if($.trim(data) == '') {
                    $('#getmore').show();
                    return false;
                }else{
                    $(".allpion").append(data);
                }
            }
        });
    }
</script>
</body>
</html>