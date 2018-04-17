<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:43:"./template/mobile/mobile1/goods\search.html";i:1517208521;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;s:45:"./template/mobile/mobile1/public\top_nav.html";i:1517208522;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>搜索列表--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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

    <!--搜索栏-s-->
    <div class="classreturn whiback">
        <div class="content">
            <div class="ds-in-bl return">
                <a href="javascript:history.back(-1);"><img src="__STATIC__/images/return.png" alt="返回"></a>
            </div>
            <div class="ds-in-bl search">
                <form action="" method="post">
                    <div class="sear-input">
                        <a href="<?php echo U('Goods/ajaxSearch'); ?>">
                            <input type="text" value="<?php echo I('q')?>">
                        </a>
                    </div>
                </form>
            </div>
            <div class="ds-in-bl menu">
                <a href="javascript:void(0);"><img src="__STATIC__/images/class1.png" alt="菜单"></a>
            </div>
        </div>
    </div>
    <!--搜索栏-e-->

    <!--顶部隐藏菜单-s-->
    <div class="flool tpnavf [cla]">
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
    <!--顶部隐藏菜单-e-->

    <!--排序按钮-s-->
    <nav class="storenav p search_list_dump" id="head_search_box product_sort">
        <ul>
            <li>
                <span class="lb <?php if((I('sort') == 'is_new' or  I('sort') == 'comment_count')): ?>red<?php endif; ?>">综合</span>
                <i></i>
            </li>
            <li class="<?php if(I('sort') == 'sales_sum'): ?>red<?php endif; ?>">
                <a href="<?php echo urldecode(U('Mobile/Goods/search',array_merge($filter_param,array('sort'=>'sales_sum')),''));?>" >
                     <span class="dq">销量</span>
                </a>
            </li>
            <li class="<?php if(I('sort') == 'shop_price'): ?>red<?php endif; ?>">
                <a href="<?php echo urldecode(U('Mobile/Goods/search',array_merge($filter_param,array('sort'=>'shop_price','sort_asc'=>$sort_asc)),''));?>">
                    <span class="jg">价格 </span>
                    <i  class="pr  <?php if(I('sort_asc') == 'asc'): ?>bpr2<?php endif; if(I('sort_asc') == 'desc'): ?> bpr1 <?php endif; ?>"></i>
                </a>
            </li>
            <li >
                <span class="sx">筛选</span>
                <i class="fitter"></i>

            </li>
            <li>
                <i class="listorimg"></i>
            </li>
        </ul>
    </nav>
    <!--排序按钮-e-->

    <!--商品列表-s-->
    <div id="goods_list">
        <?php if(empty($goods_list) || (($goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator ) && $goods_list->isEmpty())): ?>
            <p class="goods_title" id="goods_title" style="line-height: 100px;text-align: center;margin-top: 30px;">抱歉暂时没有相关结果，换个筛选条件试试吧</p>
        <?php else: ?>
            <!--商品-s-->
            <?php if(is_array($goods_list) || $goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator): if( count($goods_list)==0 ) : echo "" ;else: foreach($goods_list as $k=>$vo): ?>
                <div class="orderlistshpop p"  >
                    <div class="maleri30">
                        <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$vo[goods_id])); ?>" class="item">
                            <div class="sc_list se_sclist">
                                <div class="shopimg fl">
                                    <img src="<?php echo goods_thum_images($vo['goods_id'],400,400); ?>">
                                </div>
                                <div class="deleshow fr">
                                    <div class="deletes">
                                        <span class="similar-product-text fl"><?php echo getSubstr($vo['goods_name'],0,20); ?></span>
                                    </div>
                                    <div class="prices">
                                        <p class="sc_pri fl"><span>￥</span><span><?php echo $vo[shop_price]; ?>元</span></p>
                                    </div>
                                    <p class="weight"><span><?php echo $vo[comment_count]; ?></span><span>条评价</span></p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <!--商品-e-->
        <?php endif; ?>
    </div>
    <!--商品列表-e-->

<div id="getmore"  style="font-size:.32rem;text-align: center;color:#888;padding:.25rem .24rem .4rem; clear:both;display: none">
    <a >已显示完所有记录</a>
</div>

    <!--综合筛选弹框-s-->
    <div class="fil_all_comm">
        <div class="maleri30">
            <ul>
                <li >
                    <a href="<?php echo urldecode(U('Mobile/Goods/search',array_merge($filter_param,array('sort'=>'')),''));?>" class="<?php if((I('sort') == '')): ?>on red<?php endif; ?>" >综合</a>
                </li>
                <li >
                    <a href="<?php echo urldecode(U('Mobile/Goods/search',array_merge($filter_param,array('sort'=>'is_new')),''));?>" class="<?php if((I('sort') == 'is_new')): ?>on red<?php endif; ?>">新品</a>
                </li>
                <li >
                    <a href="<?php echo urldecode(U('Mobile/Goods/search',array_merge($filter_param,array('sort'=>'comment_count')),''));?>" class="<?php if(I('sort') == 'comment_count'): ?>on red<?php endif; ?>">评价</a>
                </li>
            </ul>
        </div>
    </div>
    <!--综合弹框-e-->

    <!--筛选-s-->
    <div class="screen_wi">
        <div class="classreturn loginsignup">
            <div class="content">
                <div class="ds-in-bl return seac_retu">
                    <a href="javascript:void(0);" ><img src="__STATIC__/images/return.png" alt="返回"></a>
                </div>
                <div class="ds-in-bl search center">
                    <span class="sx_jsxz">筛选</span>
                </div>
                <div class="ds-in-bl suce_ok ">
                    <a href="javascript:void(0);">确定</a>
                </div>
            </div>
        </div>

        <!--顶部筛选-s-->
        <div class="popcover">
            <ul>
                <li>
                    <span <?php if(\think\Request::instance()->param('sel') == 'all' or \think\Request::instance()->param('sel') == 'all'): ?>class="ch_dg"<?php endif; ?>>
                    显示全部<input type="hidden"  class="sel" value="all" >
                    </span>
                </li>
                <li>
                    <span <?php if(\think\Request::instance()->param('sel') == 'free_post'): ?>class="ch_dg"<?php endif; ?>>
                    仅看包邮<input type="hidden"  value="free_post" >
                    </span>
                </li>
                <li>
                    <span <?php if(\think\Request::instance()->param('sel') == 'store_count'): ?>class="ch_dg"<?php endif; ?>>
                    仅看有货<input type="hidden"  value='store_count'>
                    </span>
                </li>
                <li>
                    <span <?php if(\think\Request::instance()->param('sel') == 'prom_type'): ?>class="ch_dg"<?php endif; ?>>
                    促销商品<input type="hidden"  value="prom_type" >
                    </span>
                </li>
            </ul>
        </div>
        <!--筛选顶部-e-->

        <!--一级筛选条件-s-->
        <div class="list-se-all ma-to-20 one-related" >
            <!--品牌-s-->
            <?php if(!(empty($filter_brand) || (($filter_brand instanceof \think\Collection || $filter_brand instanceof \think\Paginator ) && $filter_brand->isEmpty()))): ?>
                <div class="myorder p " onclick="filtercriteria('brand')">
                    <div class="content30" >
                        <a href="javascript:void(0)">
                            <div class="order" >
                                <div class="fl">
                                    <span>品牌</span>
                                </div>
                                <div class="fr">
                                    <i class="Mright"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            <!--品牌-e-->

            <!--价格-s-->
            <?php if($filter_price != null): ?>
            <div class="myorder p" onclick="filterprice()" >
                <div class="content30">
                    <a href="javascript:void(0)">
                        <div class="order" >
                            <div class="fl">
                                <span>价格</span>
                            </div>
                            <div class="fr">
                                <i class="Mright"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <?php endif; ?>
            <!--价格-e-->
            <input type="hidden" id="key" value="" />
        </div>
        <!--一级筛选条件-e-->

        <!--二级刷选条件-->
        <div class="list-se-all ma-to-20 two-related">
            <!--商品品牌筛选-s-->
            <?php if(is_array($filter_brand) || $filter_brand instanceof \think\Collection || $filter_brand instanceof \think\Paginator): if( count($filter_brand)==0 ) : echo "" ;else: foreach($filter_brand as $brandk=>$brand): ?>
                <div class="myorder p filter brnda" data-val='<?php echo $brand[id]; ?>'>
                    <div class="content30">
                        <div class="order">
                            <div class="fl">
                                <span><?php echo $brand[name]; ?></span>
                            </div>
                            <div class="fr">
                                <i class=""><input type="checkbox" style="display: none;"  value="<?php echo $brand[id]; ?>"/></i>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <!--商品品牌筛选-e-->

            <!--价格筛选-s-->
            <?php if(is_array($filter_price) || $filter_price instanceof \think\Collection || $filter_price instanceof \think\Paginator): if( count($filter_price)==0 ) : echo "" ;else: foreach($filter_price as $pricek=>$price): ?>
                <div class="myorder p tow-price">
                    <div class="content30">
                        <a href="<?php echo $price[href]; ?>">
                            <div class="order">
                                <div class="fl">
                                    <span><?php echo $price[value]; ?></span>
                                </div>
                                <div class="fr">
                                    <i class=""></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <!--价格筛选-e-->
        </div>
        <!--二级刷选条件-e-->
    </div>
    <!--筛选-e-->
<script type="text/javascript" src="__STATIC__/js/sourch_submit.js"></script>
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
<div class="mask-filter-div" style="display: none;"></div>
<script>
        //############   点击多选确定按钮      ############
        // t 为类型  是品牌 还是 规格 还是 属性
        // btn 是点击的确定按钮用于找位置
        get_parment = <?php echo json_encode($_GET); ?>;
        function submitMoreFilter(t){
            var val = new Array();  // 请求的参数值
            $(".filter").each(function(i,o){
                var che=$(o).find('.fr input');
                if(che.attr('checked')){    //选中的值
                    val.push(che.val());
                }
            });
            // 没有被勾选的时候
            if(key == ''){
                return false;
            }
            // 品牌
            if(t == 'brand')
            {
                get_parment.brand_id = val.join('_');
            }

            // 组装请求的url
            var url = '';
            for ( var k in get_parment )
            {
                url += "&"+k+'='+get_parment[k];
            }
            location.href ="/index.php?m=Mobile&c=Goods&a=search"+url;
        }

        //确定按钮
        $('.suce_ok').click(function(){
            //判断当前二级筛选状态
            if($('.suce_ok').is('.two')) {
//                        get_parment += 'spec=@'+key+'_'+val.join('_');
//                        console.log(get_parment);
////                        $('.screen_wi,.popcover,.one-related').show();
////                        $('.two-related').hide();
////                        $('.sx_jsxz').html('筛选');
////                        $('.suce_ok').removeClass('two');
                var t=$('#key').attr('class');
                submitMoreFilter(t);
            }else{
                var sel = $('.sel').val();
                // 组装请求的url
                var url = '';
                for ( var k in get_parment )
                {
                    url += "&"+k+'='+get_parment[k];
                }
                location.href= "/index.php?m=Mobile&c=Goods&a=goodsList"+url+"&sel="+sel;
            }
        })
        //返回按钮
        $('.seac_retu').click(function(){
            //判断当前二级筛选状态
            if($('.suce_ok').is('.two')){
                $(".filterspec").each(function(i,o){
                    //去掉全部选择
                    $(o).find('.fr input').attr('checked',false);
                });
                $('#key').removeAttr('class');
                //显示一级筛选
                $('.screen_wi,.popcover,.one-related').show();
                $('.two-related').hide();
                $('.sx_jsxz').html('筛选');
                $('.suce_ok').removeClass('two');
            }else{
                $('.screen_wi').animate({width: '0', opacity: 'hide'}, 'normal',function(){
                    undercover();
                    $('.screen_wi').hide();
                });
            }
        })
</script>
<script type="text/javascript">
    //筛选弹窗的品牌筛选
    function filtercriteria(criteria){
        $('#key').addClass(criteria);
        $('.filter').show();
        $('.tow-price').hide();
    }

    //筛选弹窗的价格筛选
    function filterprice(){
        $('.tow-price').show();
        $('.filter').hide();
    }

    //加载更多商品
    var  page = 1;
    /*** ajax 提交表单 查询订单列表结果*/
    function ajax_sourch_submit(){
        page += 1;
        $.ajax({
            type : "GET",
            url:"<?php echo U('Mobile/Goods/search'); ?>",//+tab,
            data:{id:'<?php echo \think\Request::instance()->param('id'); ?>',sort:'<?php echo \think\Request::instance()->param('sort'); ?>',sort_asc:'<?php echo \think\Request::instance()->param('sort_asc'); ?>',sel:'<?php echo \think\Request::instance()->param('sel'); ?>',q:'<?php echo \think\Request::instance()->param('q'); ?>',is_ajax:1,p:page},
            success: function(data)
            {
                if($.trim(data) == '')
                    $('#getmore').hide();
                else
                    $("#goods_list").append(data);
            }
        });
    }

    //筛选菜单栏切换效果
    var lb = $('.search_list_dump .lb')
    var fil = $('.fil_all_comm');
    var cs = $('.classreturn,.search_list_dump');
    var son = $('.search_list_dump .jg').siblings();
$(function(){
    $('.storenav ul li span').click(function(){
        $(this).parent().parent().addClass('red').siblings('li').removeClass('red')
        if(!$(this).hasClass('lb')){
            fil.hide();
            undercover();
            cs.removeClass('pore');
        }
        if(!$(this).hasClass('jg')){
            son.removeClass('bpr1');
            son.removeClass('bpr2');
        }
    });


    //综合
    lb.click(function(){
        fil.show();
        cover();
        cs.addClass('pore');
    });

    lb.html($('.on').html());


     //显示隐藏筛选弹窗
    $('.search_list_dump .sx').click(function(){
        $('body').css('position','relative');
        $('.screen_wi').animate({width: '14.4rem', opacity: 'show'}, 'normal',function(){
            $('.screen_wi').show();
            cover();
        });
    })

    //  筛选顶部 筛选1-popcover
    $('.popcover ul li span').click(function(){
        //给span添加样式，并给其子代input添加class
        $(this).addClass('ch_dg').find('input').addClass('sel');
        $(this).parent('li').siblings('li').find('span').removeClass('ch_dg')
                .find('input').removeClass('sel');
    })

    // 一级筛选条件筛选2-one-related
    $('.one-related .myorder .order').click(function(){
        $('.two-related').show();
        $('.suce_ok').addClass('two');
        $('.tow-price,.one-related,.popcover').hide();
        $('.sx_jsxz').html($(this).find('.fl span').text());
    })

    //筛选3-two-related
    $(function(){
        $('.two-related .myorder .order').click(function(){
            var mright = $(this).find('.fr i');
            var input = mright.find("input");
            mright.toggleClass('Mright');
            //改变复选框状态
            mright.hasClass('Mright') ? input.attr('checked',true) : input.attr('checked',false);
        })
    })

    //切换商品排列样式
    $('.listorimg').click(function(){
        $(this).toggleClass('orimg');
        $('#goods_list').toggleClass('addimgchan');
    })
})
</script>
</body>
</html>
