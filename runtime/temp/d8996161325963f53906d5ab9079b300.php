<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:41:"./application/seller/new/order\index.html";i:1517208469;s:41:"./application/seller/new/public\head.html";i:1522050654;s:41:"./application/seller/new/public\left.html";i:1517208469;s:41:"./application/seller/new/public\foot.html";i:1517208469;}*/ ?>
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
<style>
  .w150{
    margin-right: 35px;
  }
  .w378{
    display: inline-block !important;
  }
  .di-in{
    display: inline-block !important;
  }
  .w160{
    width: 160px !important;
  }
  .nscs-table-handle{
    border-right: 1px solid #dedede;
  }
</style>
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
    <div class="ncsc-path"><i class="icon-desktop"></i>商家管理中心<i class="icon-angle-right"></i>订单物流<i class="icon-angle-right"></i>订单列表</div>
    <div class="main-content" id="mainContent">
      
<div class="tabmenu">
  <ul id="tab" class="tab pngFix">
  	<li class="<?php if(is_null(\think\Request::instance()->param('order_status'))): ?>active<?php else: ?>normal<?php endif; ?>" data-val=""><a  href="#">所有订单</a></li>
  	<li class="<?php if(\think\Request::instance()->param('order_status') === 0): ?>active<?php else: ?>normal<?php endif; ?>" data-val="0"><a  href="#">待确认</a></li>
  	<li class="<?php if(\think\Request::instance()->param('order_status') == 1): ?>active<?php else: ?>normal<?php endif; ?>" data-val="1"><a  href="#">已确认</a></li>
  	<li class="<?php if(\think\Request::instance()->param('order_status') == 2): ?>active<?php else: ?>normal<?php endif; ?>" data-val="2"><a  href="#">已收货</a></li>
  	<li class="<?php if(\think\Request::instance()->param('order_status') == 3): ?>active<?php else: ?>normal<?php endif; ?>" data-val="3"><a  href="#">已取消</a></li>
  	<li class="<?php if(\think\Request::instance()->param('order_status') == 4): ?>active<?php else: ?>normal<?php endif; ?>" data-val="4"><a  href="#">已完成</a></li>
  	<li class="<?php if(\think\Request::instance()->param('order_status') == 5): ?>active<?php else: ?>normal<?php endif; ?>" data-val="5"><a  href="#">已作废</a></li>
  </ul>
  </div>
<form method="get" action="<?php echo U('order/export_order'); ?>" id="search-form2">
    <input type="hidden" name="order_by" value="order_id"/>
    <input type="hidden" name="sort" value="desc"/>
    <input type="hidden" name="order_status" id="order_status" value="<?php echo \think\Request::instance()->param('order_status'); ?>"/>
    <input type="hidden" value="<?php echo (isset($_GET['order_statis_id']) && ($_GET['order_statis_id'] !== '')?$_GET['order_statis_id']:0); ?>" name="order_statis_id" id="order_statis_id"/>
  <table class="search-form">
    <tr>
      <th>收货人</th>
      <td class="w150"><input type="text" class="text w150" name="consignee" placeholder="收货人" value=""/></td>
      <th>订单编号</th>
      <td class="w150"><input type="text" class="text w150" name="order_sn" placeholder="订单编号" value=""/></td>
      <th>下单时间</th>
      <td class="w378">
	      <input type="text" class="text w150" name="add_time_begin" id="add_time_begin" placeholder="开始时间" value="<?php echo $begin; ?>"/>
	      <input type="text" class="text w150" name="add_time_end" id="add_time_end" placeholder="结束时间" value="<?php echo $end; ?>"/>
	   </td>
     </tr>
     <tr> 
      <th>支付状态</th>
      <td class="w160">
          <select name="pay_status" class="w150 w160">
              <option value="">支付状态</option>
              <option value="0" <?php if(\think\Request::instance()->param('pay_status') === '0'): ?>selected='selected'<?php endif; ?>>未支付</option>
              <option value="1" <?php if(\think\Request::instance()->param('pay_status') == 1): ?>selected='selected'<?php endif; ?>>已支付</option>
          </select>
      </td>
      <th>发货状态</th>
      <td class="w160">
      		<select name="shipping_status" class="w150 w160">
          		<option value="">发货状态</option>
                <option value="0" <?php if(\think\Request::instance()->param('shipping_status') === '0'): ?>selected='selected'<?php endif; ?>>未发货</option>
               	<option value="1" <?php if(\think\Request::instance()->param('shipping_status') == 1): ?>selected='selected'<?php endif; ?>>已发货</option>
               	<option value="2" <?php if(\think\Request::instance()->param('shipping_status') == 2): ?>selected='selected'<?php endif; ?>>部分发货</option>
             </select>
		</td>
      <th>支付方式</th>
      <td><select name="pay_code" class="w150 w160 di-in">
          		<option value="">支付方式</option>
                <option value="alipay">支付宝支付</option>
                <option value="weixin">微信支付</option>
                <!--<option value="cod">货到付款</option>-->
             </select>
             <label class="submit-border"><input class="submit" value="搜索" onclick="ajax_get_table('search-form2',1)" type="button"></label>
      </td>
    </tr>
  </table>
</form>
<div id="ajax_return">
	 
</div>
<script>
$(document).ready(function(){	
	   
 	//$('#add_time_begin').layDate(); 
 	//$('#add_time_end').layDate();
 	 
 	ajax_get_table('search-form2',1);
 	
 	$("#tab > li").each(function(){
		$(this).click(function(){
			tabSelect(this);
		});
	});
 
    // 起始位置日历控件
	laydate.skin('molv');//选择肤色
	laydate({
	  elem: '#add_time_begin',
	  format: 'YYYY-MM-DD', // 分隔符可以任意定义，该例子表示只显示年月
	  festival: true, //显示节日
	  istime: false,
	  choose: function(datas){ //选择日期完毕的回调
		 compare_time($('#add_time_begin').val(),$('#add_time_end').val());
	  }
	});
	 
	 // 结束位置日历控件
	laydate({
	  elem: '#add_time_end',
	  format: 'YYYY-MM-DD', // 分隔符可以任意定义，该例子表示只显示年月
	  festival: true, //显示节日
	  istime: false,
	  choose: function(datas){ //选择日期完毕的回调
		   compare_time($('#add_time_begin').val(),$('#add_time_end').val());
	  }
	});
	
});


function tabSelect(obj){
	var currHasClass = $(obj).hasClass('active');
	if(currHasClass)return;
	
	$("#tab > li").each(function(){
		$(this).removeClass('active');
	});
	
	$(obj).addClass('active');
	var orderStatus = $(obj).attr("data-val");
	$("#order_status").val(orderStatus);
	ajax_get_table('search-form2',1);
}

function ajax_get_table(tab,page){
	var order_statis_id = $('#order_statis_id').val();
	cur_page = page; //当前页面 保存为全局变量
	var ajaxUrl = "/index.php/Seller/order/ajaxindex/p/"+page;
	if(order_statis_id>0){
		ajaxUrl = "/index.php/Seller/order/ajaxindex/p/"+page+"order_statis_id/"+order_statis_id;
	}
    $.ajax({
        type : "POST",
        url: ajaxUrl,
        data : $('#'+tab).serialize(),// 你的formid
        success: function(data){
            $("#ajax_return").html('');
            $("#ajax_return").append(data);
        }
    });
}

</script>    
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
  <p><a href="/">首页</a>
                | <a  href="#">招聘英才</a>
                | <a  href="#">合作及洽谈</a>
                | <a  href="#">联系我们</a>
                | <a  href="#">关于我们</a>
                | <a  href="#">物流自取</a>
                | <a  href="#">友情链接</a>
  </p>
  Copyright 2017 <a href="" target="_blank">掌心商城</a> All rights reserved.<br />本演示来源于
  <a href="#" target="_blank">掌心商城</a>  
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
</body>
</html>
