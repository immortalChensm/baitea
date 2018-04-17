<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:49:"./application/seller/new/goods\goods_offline.html";i:1517208469;s:41:"./application/seller/new/public\head.html";i:1522050654;s:41:"./application/seller/new/public\left.html";i:1517208469;s:41:"./application/seller/new/public\foot.html";i:1517208469;}*/ ?>
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
    <div class="ncsc-path"><i class="icon-desktop"></i>商家管理中心<i class="icon-angle-right"></i>商品<i class="icon-angle-right"></i>仓库中的商品</div>
<div class="main-content" id="mainContent">
      
	<div class="tabmenu">
	  <ul class="tab pngFix">
	  <li class="<?php if($_GET[is_on_sale] == 0): ?>active<?php else: ?>normal<?php endif; ?>"><a  href="<?php echo U('Goods/goods_offline',array('is_on_sale'=>0)); ?>">仓库中的商品</a></li>
	  <li class="<?php if($_GET[is_on_sale] == 2): ?>active<?php else: ?>normal<?php endif; ?>"><a  href="<?php echo U('Goods/goods_offline',array('is_on_sale'=>2)); ?>">违规的商品</a></li>
	  </ul>
	</div>
	<form method="get" action="">
	  <table class="search-form">
	    <input type="hidden" name="act" value="goods_offline" />
	    <tr>
	      <td>&nbsp;</td>
	      <th>供货商</th>
	      <td class="w160">
	       <select name="suppliers_id" class="w150">
	        <option value="0">请选择...</option>
	        <?php if(is_array($suppliers_list) || $suppliers_list instanceof \think\Collection || $suppliers_list instanceof \think\Paginator): if( count($suppliers_list)==0 ) : echo "" ;else: foreach($suppliers_list as $key=>$sup): ?>
	        <option value="<?php echo $sup['suppliers_id']; ?>" ><?php echo $sup['suppliers_name']; ?></option>
	        <?php endforeach; endif; else: echo "" ;endif; ?>
	       </select>
	      </td>
	      <th>本店分类</th>
	      <td class="w160">
	          <select name="store_cat_id1" id="store_cat_id1" class="select">
	              <option value="">本店分类</option>
	              <?php if(is_array($store_goods_class_list) || $store_goods_class_list instanceof \think\Collection || $store_goods_class_list instanceof \think\Paginator): if( count($store_goods_class_list)==0 ) : echo "" ;else: foreach($store_goods_class_list as $k=>$v): ?>
	                  <option value="<?php echo $v['cat_id']; ?>"> <?php echo $v['cat_name']; ?></option>
	              <?php endforeach; endif; else: echo "" ;endif; ?>
	          </select>
	      </td>
	      <?php if($_GET[is_on_sale] == 0): ?>
	      <th>审核状态</th>
	      <td class="w90">
	        <select name="goods_state">
	          	<option value="">请选择...</option>
	            <option value="0" <?php if($_GTE[goods_state] === 0): ?>selected<?php endif; ?>>待审核</option>
	            <option value="1" <?php if($_GTE[goods_state] == 1): ?>selected<?php endif; ?>>审核通过</option>
	            <option value="2" <?php if($_GTE[goods_state] == 2): ?>selected<?php endif; ?>>未通过</option>
	          </select>
	      </td>
	      <?php endif; ?>
	      <td class="w160"><input type="text" class="text" name="key_word" value="" placeholder="搜索词"/></td>
	      <td class="tc w70"><label class="submit-border"><input type="submit" class="submit" value="搜索" /></label></td>
	    </tr>
	  </table>
	</form>
	<?php if($_GET[is_on_sale] == 2): ?>
	<table class="ncsc-default-table">
	  <thead>
	    <tr nc_type="table_header">
	      <th class="w30">ID</th>
	      <th class="w50"></th>
	      <th>商品名称</th>
	      <th class="w180">违规禁售原因</th>
	      <th class="w100">价格</th>
	      <th class="w100">库存</th>
	      <th class="w200">操作</th>
	    </tr>
	      <!--<tr>
	      <td class="tc"><input type="checkbox" id="all" class="checkall"/></td>
	      <td colspan="10"><label for="all">全选</label>
	        <a href="javascript:void(0);" class="ncbtn-mini" nc_type="batchbutton" uri="" name="commonid" confirm="您确定要删除吗?"><i class="icon-trash"></i>删除</a>
	      </tr>-->
	      </thead>
	  	  <tbody>
	  	  	  <?php if(is_array($goodsList) || $goodsList instanceof \think\Collection || $goodsList instanceof \think\Paginator): if( count($goodsList)==0 ) : echo "" ;else: foreach($goodsList as $key=>$vo): ?>
		      <tr>
		      <td class="trigger"><i class="icon-plus-sign" nctype="ajaxGoodsList"></i><?php echo $vo['goods_id']; ?></td>
		      <td><div class="pic-thumb"><a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$vo['goods_id'])); ?>" target="_blank">
		      	<img src="<?php echo goods_thum_images($vo['goods_id'],50,50); ?>"/></a></div>
		      </td>
		      <td class="tl">
		      	<dl class="goods-name">
		          <dt style="max-width: 450px !important;">
		          <?php if($vo[is_virtual] == 1): ?><span class="type-virtual" title="虚拟兑换商品">虚拟</span><?php endif; ?>
		          <a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$vo['goods_id'])); ?>" target="_blank"><?php echo getSubstr($vo['goods_name'],0,33); ?></a></dt>
		          <dd>商家货号：<?php echo $vo['goods_sn']; ?></dd>
		        </dl>
		      </td>
		      <td><?php echo $vo['close_reason']; ?></td>
		      <td><span>&yen;<?php echo $vo['shop_price']; ?></span></td>
		      <td><span><?php echo $vo['store_count']; ?>件</span></td>
		      <td class="nscs-table-handle tr">
			  	<span><a href="<?php echo U('Goods/goodsUpLine',array('goods_ids'=>$vo['goods_id'])); ?>" class="btn-bluejeans"><i class="icon-refresh"></i><p>重新申请审核</p> </a></span>
		      	<span><a href="<?php echo U('Goods/addEditGoods',array('goods_id'=>$vo['goods_id'])); ?>" class="btn-bluejeans"><i class="icon-edit"></i><p>编辑</p> </a></span>
		        <span><a href="javascript:void(0);" onclick="del('<?php echo $vo[goods_id]; ?>')" class="btn-grapefruit"><i class="icon-trash"></i><p>删除</p></a></span>
		      </td>
		      </tr>
		      <?php endforeach; endif; else: echo "" ;endif; ?>
	      </tbody>
	      <tfoot>
		    <tr>
		       <td colspan="20"><?php echo $page; ?></td>
		    </tr>
		  </tfoot>
	  </table>
	  <?php else: ?>
	  <table class="ncsc-default-table">
	  <thead>
	    <tr nc_type="table_header">
	      <th class="w30">ID</th>
	      <th class="w50"></th>
	      <th>商品名称</th>
	      <th class="w80">上架</th>
	      <th class="w80">审核状态</th>
	      <th class="w100">价格</th>
	      <th class="w100">库存</th>
	      <th class="w100">操作</th>
	    </tr>
	      <!--<tr>
	      <td class="tc"><input type="checkbox" id="all" class="checkall"/></td>
	      <td colspan="10"><label for="all">全选</label>
	        <a href="javascript:void(0);" class="ncbtn-mini" nc_type="batchbutton" uri="" name="commonid" confirm="您确定要删除吗?"><i class="icon-trash"></i>删除</a>
	      </tr>-->
	      </thead>
	  	  <tbody>
	  	  	  <?php if(is_array($goodsList) || $goodsList instanceof \think\Collection || $goodsList instanceof \think\Paginator): if( count($goodsList)==0 ) : echo "" ;else: foreach($goodsList as $key=>$vo): ?>
		      <tr id="list_<?php echo $vo[goods_id]; ?>">
		      <td class="trigger"><i class="icon-plus-sign" nctype="ajaxGoodsList"></i><?php echo $vo['goods_id']; ?></td>
		      <td><div class="pic-thumb"><a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$vo['goods_id'])); ?>" target="_blank">
		      <img src="<?php echo goods_thum_images($vo['goods_id'],50,50); ?>"/></a></div></td>
		      <td class="tl">
		      	<dl class="goods-name">
		          <dt style="max-width: 450px !important;">
		          <?php if($vo[is_virtual] == 1): ?><span class="type-virtual" title="虚拟兑换商品">虚拟</span><?php endif; ?>
		          <a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$vo['goods_id'])); ?>" target="_blank"><?php echo getSubstr($vo['goods_name'],0,33); ?></a></dt>
		          <dd>商家货号：<?php echo $vo['goods_sn']; ?></dd>
		        </dl>
		      </td>
		      <td><img width="20" height="20" src="__PUBLIC__/images/<?php if($vo[is_on_sale] == 1): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>" <?php if($vo[goods_state] != 1): ?>onclick="layer.msg('该商品需通过审核才能上架',{icon:2});"<?php else: ?>onclick="changeTableVal2('goods','goods_id','<?php echo $vo['goods_id']; ?>','is_on_sale',this)"<?php endif; ?> /></td>
		      <td><?php echo $state[$vo[goods_state]]; ?></td>
		      <td><span>&yen;<?php echo $vo['shop_price']; ?></span></td>
		      <td><span><?php echo $vo['store_count']; ?>件</span></td>
		      <td class="nscs-table-handle tr">
		      	<span><a href="<?php echo U('Goods/addEditGoods',array('goods_id'=>$vo['goods_id'])); ?>" class="btn-bluejeans"><i class="icon-edit"></i><p>编辑</p> </a></span>
		        <span><a href="javascript:void(0);" onclick="del('<?php echo $vo[goods_id]; ?>')" class="btn-grapefruit"><i class="icon-trash"></i><p>删除</p></a></span>
		      </td>
		      </tr>
		      <?php endforeach; endif; else: echo "" ;endif; ?>
	      </tbody>
	      <tfoot>
		    <tr>
		       <td colspan="20"><?php echo $page; ?></td>
		    </tr>
		  </tfoot>
	  </table>
	  <?php endif; ?>
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
<script>
// 删除操作
function del(id) {
	layer.confirm('确定要删除吗？', {
				btn: ['确定','取消'] //按钮
			}, function(){
				// 确定
				$.ajax({
					url: "/index.php?m=Seller&c=goods&a=delGoods&id=" + id,
                    dataType:'json',
					success: function (data) {
						layer.closeAll();
						if (data.status == 1){
                            layer.msg(data.msg, {icon: 1, time: 1000},function () {
                               $('#list_'+id).remove();
                                ajax_get_table('search-form2', cur_page);
                            });

                        }else{
                            layer.msg(data.msg, {icon: 2, time: 1000}); //alert(v.msg);
                        }

					}
				});
			}, function(index){
				layer.close(index);
			}
	);
}
</script>
</body>
</html>
