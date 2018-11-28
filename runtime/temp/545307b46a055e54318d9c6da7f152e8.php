<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:49:"./application/seller/new/service\refund_list.html";i:1525917766;s:41:"./application/seller/new/public\head.html";i:1528699444;s:41:"./application/seller/new/public\left.html";i:1517208469;s:41:"./application/seller/new/public\foot.html";i:1525943636;}*/ ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>商家中心</title>
<link href="__PUBLIC__/static/css/base.css" rel="stylesheet" type="text/css">
<link href="__PUBLIC__/static/css/seller_center.css" rel="stylesheet" type="text/css">
<link href="__PUBLIC__/static/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $tpshop_config['shop_info_store_ico']; ?>" media="screen"/>
<!--[if IE 7]>
  <link rel="stylesheet" href="__PUBLIC__/static/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/seller.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/waypoints.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/layer/layer.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/dialog/dialog.js" id="dialog_js"></script>
<script type="text/javascript" src="__PUBLIC__/js/global.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/myAjax.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/myFormValidate.js"></script>
<script type="text/javascript" src="__ROOT__/public/static/js/layer/laydate/laydate.js"></script>
<script type="text/javascript" src="__ROOT__/public/static/js/layer/laydate/laydate_new.js"></script>
<script type="text/javascript" src="__ROOT__/public/static/js/layer/laydate/laydate_hoursmin.js"></script>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="__PUBLIC__/static/js/html5shiv.js"></script>
      <script src="__PUBLIC__/static/js/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<header class="ncsc-head-layout w">
  <div class="wrapper">
    <div class="ncsc-admin w252">
      <dl class="ncsc-admin-info">
        <dt class="admin-avatar"><img src="__PUBLIC__/static/images/seller/default_user_portrait.gif" width="32" class="pngFix" alt=""/></dt>
      </dl>
      <div class="ncsc-admin-function">

      <div class="index-search-container">
      <p class="admin-name"><a class="seller_name" href=""><?php echo $seller['seller_name']; ?></a></p>
      <div class="index-sitemap"><a class="iconangledown" href="javascript:void(0);">快捷导航 <i class="icon-angle-down"></i></a>
          <div class="sitemap-menu-arrow"></div>
          <div class="sitemap-menu">
              <div class="title-bar">
                <h2>管理导航</h2>
                <p class="h_tips"><em>小提示：添加您经常使用的功能到首页侧边栏，方便操作。</em></p>
                <img src="__PUBLIC__/static/images/obo.png" alt="">
                <span id="closeSitemap" class="close">X</span>
              </div>
              <div id="quicklink_list" class="content">
	          	<?php if(is_array($menuArr) || $menuArr instanceof \think\Collection || $menuArr instanceof \think\Paginator): if( count($menuArr)==0 ) : echo "" ;else: foreach($menuArr as $k2=>$v2): ?>
	             <dl>
	              <dt><?php echo $v2['name']; ?></dt>
	                <?php if(is_array($v2['child']) || $v2['child'] instanceof \think\Collection || $v2['child'] instanceof \think\Paginator): if( count($v2['child'])==0 ) : echo "" ;else: foreach($v2['child'] as $key=>$v3): ?>
	                <dd class="<?php if(!empty($quicklink)){if(in_array($v3['op'].'_'.$v3['act'],$quicklink)){echo 'selected';}} ?>">
	                	<i nctype="btn_add_quicklink" data-quicklink-act="<?php echo $v3[op]; ?>_<?php echo $v3[act]; ?>" class="icon-check" title="添加为常用功能菜单"></i>
	                	<a href=<?php echo U("$v3[op]/$v3[act]"); ?>> <?php echo $v3['name']; ?> </a>
	                </dd>
	            	<?php endforeach; endif; else: echo "" ;endif; ?>
	             </dl>
	            <?php endforeach; endif; else: echo "" ;endif; ?>      
              </div>
          </div>
        </div>
      </div>

		<!--  
      <a class="iconshop" href="<?php echo U('Home/Store/index',array('store_id'=>STORE_ID)); ?>" title="前往店铺" ><i class="icon-home"></i>&nbsp;店铺</a>
      -->
      <a class="iconshop" href="<?php echo U('Admin/modify_pwd',array('seller_id'=>$seller['seller_id'])); ?>" title="修改密码" target="_blank"><i class="icon-wrench"></i>&nbsp;设置</a>
      <a class="iconshop" href="<?php echo U('Admin/logout'); ?>" title="安全退出"><i class="icon-signout"></i>&nbsp;退出</a></div>
    </div>
    <div class="center-logo"> <a href="/" target="_blank">
     
    	<img src="<?php echo $tpshop_config['shop_info_store_user_logo']; ?>" class="pngFix" alt=""/></a>
      <h1>商家中心</h1>
    </div>
    <nav class="ncsc-nav">
      <dl <?php if(ACTION_NAME == 'index' AND CONTROLLER_NAME == 'Index'): ?>class="current"<?php endif; ?>>
        <dt><a href="<?php echo U('Index/index'); ?>">首页</a></dt>
        <dd class="arrow"></dd>
      </dl>
      
      <?php if(is_array($menuArr) || $menuArr instanceof \think\Collection || $menuArr instanceof \think\Paginator): if( count($menuArr)==0 ) : echo "" ;else: foreach($menuArr as $kk=>$vo): ?>
      <dl <?php if(ACTION_NAME == $vo[child][0][act] AND CONTROLLER_NAME == $vo[child][0][op]): ?>class="current"<?php endif; ?>>
        <dt><a href="/index.php?m=Seller&c=<?php echo $vo[child][0][op]; ?>&a=<?php echo $vo[child][0][act]; ?>"><?php echo $vo['name']; ?></a></dt>
        <dd>
          <ul>	
          		<?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): if( count($vo['child'])==0 ) : echo "" ;else: foreach($vo['child'] as $key=>$vv): ?>
                <li> <a href='<?php echo U("$vv[op]/$vv[act]"); ?>'> <?php echo $vv['name']; ?> </a> </li>
				<?php endforeach; endif; else: echo "" ;endif; ?>
           </ul>
        </dd>
        <dd class="arrow"></dd>
      </dl>
      <?php endforeach; endif; else: echo "" ;endif; ?>
	</nav>
  </div>
</header>
<div class="ncsc-layout wrapper">
     <div id="layoutLeft" class="ncsc-layout-left">
   <div id="sidebar" class="sidebar">
     <div class="column-title" id="main-nav"><span class="ico-<?php echo $leftMenu['icon']; ?>"></span>
       <h2><?php echo $leftMenu['name']; ?></h2>
     </div>
     <div class="column-menu">
       <ul id="seller_center_left_menu">
      	 <?php if(is_array($leftMenu['child']) || $leftMenu['child'] instanceof \think\Collection || $leftMenu['child'] instanceof \think\Paginator): if( count($leftMenu['child'])==0 ) : echo "" ;else: foreach($leftMenu['child'] as $key=>$vu): ?>
           <li class="<?php if(ACTION_NAME == $vu[act] AND CONTROLLER_NAME == $vu[op]): ?>current<?php endif; ?>">
           		<a href="<?php echo U("$vu[op]/$vu[act]"); ?>"> <?php echo $vu['name']; ?></a>
           </li>
	 	<?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
     </div>
   </div>
 </div>
    <div id="layoutRight" class="ncsc-layout-right">
        <div class="ncsc-path"><i class="icon-desktop"></i>商家管理中心<i class="icon-angle-right"></i>售后服务<i class="icon-angle-right"></i>退款换货
        </div>
        <div class="main-content" id="mainContent">
            <div class="tabmenu">
                <ul class="tab pngFix">
                	<li class="active"><a href="<?php echo U('Service/refund_list'); ?>">退货退款</a></li>
                	<!-- 
                    <li class=""><a href="<?php echo U('Service/return_list'); ?>">换货维修</a></li>
                     -->
                </ul>
            </div>
            <div class="alert alert-block mt10">
			  <ul class="mt5">
			    <li>1、若退货申请相关商品未发货，卖家审核通过后，视为同意退款，平台确认后，由平台处理退款到用户账号余额或按支付原路返回</li>
			    <li>2、若退货申请相关商品已经发货，卖家同意退货时，卖家需要确认收到买家发回的货物之后，再进入平台退款流程</li>
			    <li>3、若退货申请相关商品已经发货，卖家同意退货时，如果有运费，运费问题需要卖家与用户协商</li>
			  </ul>
			</div>
            <form method="post" action="" id="search-form2">
            <table class="search-form">
                    <tr>
                        <td>&nbsp;</td>
                        <th>申请时间</th>
                        <td class="w300">
	                        <input name="add_time_begin" id="add_time_begin" type="text" class="text w100" value="" readonly="readonly">
	                        <label class="add-on"><i class="icon-calendar"></i></label> – 
	                        <input name="add_time_end" id="add_time_end" type="text" class="text w100" value="" readonly="readonly">
	                        <label class="add-on"><i class="icon-calendar"></i></label>
                        </td>
                        <th>状态</th>
                        <td class="w100">
                            <select id="status" name="status" class="w90">
                                <option value="">所有状态</option>
                                <?php if(is_array($state) || $state instanceof \think\Collection || $state instanceof \think\Paginator): if( count($state)==0 ) : echo "" ;else: foreach($state as $kk=>$vo): ?>
                                <option value="<?php echo $kk; ?>"><?php echo $vo; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                        <th class="w80">订单编号</th>
                        <td class="w100"><input style="width: 90px;" class="text" type="text" value="<?php echo $_POST['order_sn']; ?>" name="order_sn"/></td>
                        <td class="w70 tc"><label class="submit-border"><input type="submit" class="submit" value="搜索"/></label></td>
                    </tr>
            </table>
            </form>
            <div id="ajax_return">
			<table class="ncsc-default-table">
			    <thead>
			    <tr>
			        <th class="w100">订单编号</th>
			        <th class="w240">商品名称*数量</th>
			        <th class="w80">退款金额</th>
			        <th class="w80">退还预存款</th>
			        <th class="w80">服务类型</th>
			        <th class="w120">买家会员名</th>
			        <th class="w120">申请日期</th>
			        <th class="w80">状态</th>
			        <th class="w80">平台确认</th>
			        <th class="w120">操作</th>
			    </tr>
			    </thead>
			    <tbody>
			    <?php if(count($list) > 0): if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$items): $mod = ($i % 2 );++$i;?>
				        <tr class="bd-line">
				            <td><a href="<?php echo U('order/detail',array('order_id'=>$items['order_id'])); ?>"><?php echo $items['order_sn']; ?></a></td>
				            <td><?php echo $goods_list[$items['goods_id']]; ?>*<?php echo $items['goods_num']; ?></td>
				            <td><?php echo $items['refund_money']; ?></td>
				            <td><?php echo $items['refund_deposit']; ?></td>
				            <td><?php if($items[type] == 0): ?>仅退款<?php else: ?>退货退款<?php endif; ?></td>
				            <td><?php echo $user_list[$items[user_id]]; ?></td>
				            <td class=""><?php echo date('Y-m-d H:i',$items['addtime']); ?></td>
				            <td class="">
                                <?php if(($items[status] == 3) AND ($items[is_receive] == 0)): ?>同意<?php else: ?><?php echo $state[$items[status]]; endif; ?>
                            </td>
				            <td class="">
				            	<?php if($items[status] == 3): ?>待处理<?php elseif($items[status] == 4): ?>已完成<?php else: ?>无<?php endif; ?>
				            </td>
				            <td class="nscs-table-handle">
				               <span>
				                  <a href="<?php echo U('Service/refund_info',array('id'=>$items['id'])); ?>" class="btn-bluejeans">
				                  <?php if($items[status] == 0): ?><i class="icon-edit"></i><p>处理</p><?php else: ?><i class="icon-eye-open"></i><p>查看</p><?php endif; ?>
				                  </a>
				               </span>
				               <?php if($items[status] == 2): ?>
				               <span>
			               		<a href="<?php echo U('Service/confirm_receive',array('id'=>$items['id'])); ?>" class="btn-bluejeans"><i class="icon-check-sign"></i><p>收货</p></a>
				               </span>
				               <?php endif; ?>
				            </td>
				        </tr>
				    <?php endforeach; endif; else: echo "" ;endif; else: ?>
			        <tr>
			            <td colspan="20">无记录</td>
			        </tr>
			    <?php endif; ?>
			    </tbody>
			    <tfoot>
			    <tr>
			        <td colspan="20">
			           <?php echo $page; ?>
			        </td>
			    </tr>
			    </tfoot>
			</table>
            </div>
        </div>
    </div>
</div>
<div id="cti">
  <div class="wrapper">
    <ul>
          </ul>
  </div>
</div>
<div id="faq">
  <div class="wrapper">
      </div>
</div>

<div id="footer">
<!-- 
  <p><a href="/">首页</a>
                | <a  href="#">招聘英才</a>
                | <a  href="#">合作及洽谈</a>
                | <a  href="#">联系我们</a>
                | <a  href="#">关于我们</a>
                | <a  href="#">物流自取</a>
                | <a  href="#">友情链接</a>
  </p>
   -->
  Copyright 2017 <a href="" target="_blank">趣喝茶</a> All rights reserved.<br />
  <a href="#" target="_blank">趣喝茶</a>  
</div>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.cookie.js"></script>
<link href="__PUBLIC__/static/js/perfect-scrollbar.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="__PUBLIC__/static/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/qtip/jquery.qtip.min.js"></script>
<link href="__PUBLIC__/static/js/qtip/jquery.qtip.min.css" rel="stylesheet" type="text/css">
<div id="tbox">
  <div class="btn" id="msg"><a href="<?php echo U('Seller/index/store_msg'); ?>"><i class="msg"><?php if(!(empty($storeMsgNoReadCount) || (($storeMsgNoReadCount instanceof \think\Collection || $storeMsgNoReadCount instanceof \think\Paginator ) && $storeMsgNoReadCount->isEmpty()))): ?><em><?php echo $storeMsgNoReadCount; ?></em><?php endif; ?></i>站内消息</a></div>
  <div class="btn" id="im"><i class="im"><em id="new_msg" style="display:none;"></em></i>
      <a href="tencent://message/?uin=<?php echo $tpshop_config['shop_info_qq3']; ?>&Site=TPshop商城&Menu=yes">在线联系</a>
  </div>
  <div class="btn" id="gotop" style="display: block;"><i class="top"></i><a href="javascript:void(0);">返回顶部</a></div>
</div>
<script type="text/javascript">
var current_control = '<?php echo CONTROLLER_NAME; ?>/<?php echo ACTION_NAME; ?>';
$(document).ready(function(){
    //添加删除快捷操作
    $('[nctype="btn_add_quicklink"]').on('click', function() {
        var $quicklink_item = $(this).parent();
        var item = $(this).attr('data-quicklink-act');
        if($quicklink_item.hasClass('selected')) {
            $.post("<?php echo U('Seller/Index/quicklink_del'); ?>", { item: item }, function(data) {
                $quicklink_item.removeClass('selected');
                var idstr = 'quicklink_'+ item;
                $('#'+idstr).remove();
            }, "json");
        } else {
            var scount = $('#quicklink_list').find('dd.selected').length;
            if(scount >= 8) {
                layer.msg('快捷操作最多添加8个', {icon: 2,time: 2000});
            } else {
                $.post("<?php echo U('Seller/Index/quicklink_add'); ?>", { item: item }, function(data) {
                    $quicklink_item.addClass('selected');
                    if(current_control=='Index/index'){
                        var $link = $quicklink_item.find('a');
                        var menu_name = $link.text();
                        var menu_link = $link.attr('href');
                        var menu_item = '<li id="quicklink_' + item + '"><a href="' + menu_link + '">' + menu_name + '</a></li>';
                        $(menu_item).appendTo('#seller_center_left_menu').hide().fadeIn();
                    }
                }, "json");
            }
        }
    });
    //浮动导航  waypoints.js
    $("#sidebar,#mainContent").waypoint(function(event, direction) {
        $(this).parent().toggleClass('sticky', direction === "down");
        event.stopPropagation();
        });
    });
    // 搜索商品不能为空
    $('input[nctype="search_submit"]').click(function(){
        if ($('input[nctype="search_text"]').val() == '') {
            return false;
        }
    });

	function fade() {
		$("img[rel='lazy']").each(function () {
			var $scroTop = $(this).offset();
			if ($scroTop.top <= $(window).scrollTop() + $(window).height()) {
				$(this).hide();
				$(this).attr("src", $(this).attr("data-url"));
				$(this).removeAttr("rel");
				$(this).removeAttr("name");
				$(this).fadeIn(500);
			}
		});
	}
	if($("img[rel='lazy']").length > 0) {
		$(window).scroll(function () {
			fade();
		});
	};
	fade();
	
    function delfunc(obj){
    	layer.confirm('确认删除？', {
    		  btn: ['确定','取消'] //按钮
    		}, function(){
    		    // 确定
   				$.ajax({
   					type : 'post',
   					url : $(obj).attr('data-url'),
   					data : {act:'del',del_id:$(obj).attr('data-id')},
   					dataType : 'json',
   					success : function(data){
                        layer.closeAll();
   						if(data==1){
   							layer.msg('操作成功', {icon: 1});
   							$(obj).parent().parent().parent().remove();
   						}else{
   							layer.msg(data, {icon: 2,time: 2000});
   						}
   					}
   				})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);
    }
</script>
<script>
    $(document).ready(function(){
     	$('#add_time_begin').layDate(); 
     	$('#add_time_end').layDate();
    });
</script>
</body>
</html>
