<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:52:"./template/mobile/mobile1/user\withdrawals_list.html";i:1517208525;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\header_nav.html";i:1517208521;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>提现申请记录--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
            <span>提现申请记录</span>
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
<div class="application-record">
    <div class="maleri30">
        <ul class="re_tit">
            <li class="li1"><span>编号</span></li>
            <li class="li2"><span>申请日期</span></li>
            <li class="li3"><span>金额</span></li>
            <li class="li4"><span>状态</span></li>
        </ul>
        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$v): ?>
            <ul>
                <li class="li1"><span><?php echo $v[id]; ?></span></li>
                <li class="li2"><span><?php echo date('Y-m-d', $v[create_time]); ?></span></li>
                <li class="li3"><span><?php echo $v[money]; ?></span></li>
                <li class="li4"><span class="red">
                    <?php if($v[status] == -2): ?>无效作废<?php endif; if($v[status] == -1): ?>审核失败<?php endif; if($v[status] == 0): ?>申请中<?php endif; if($v[status] == 1): ?>审核通过<?php endif; if($v[status] == 2): ?>提现完成<?php endif; if($v[status] == 3): ?>转款失败<?php endif; ?>
                </span></li>
            </ul>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <div id="getmore"  style="font-size:.32rem;text-align: center;color:#888;padding:.25rem .24rem .4rem; clear:both;display: none">
        <a >已显示完所有记录</a>
    </div>
    <script type="text/javascript" src="__STATIC__/js/sourch_submit.js"></script>
</div>
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
<script>
    var page = 1;
    function ajax_sourch_submit(){
        page++;
        $.ajax({
            type:'GET',
            url:'/index.php/Mobile/User/withdrawals_list/is_ajax/1/p/'+page,
            success:function(data){
                if($.trim(data)==''){
                    $('#getmore').show();
                    return false;
                }else{
                    $('.maleri30').append(data);
                }
            }
        });
    }
</script>
</body>
</html>
