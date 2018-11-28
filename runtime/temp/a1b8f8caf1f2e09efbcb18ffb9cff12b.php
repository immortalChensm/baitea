<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:45:"./application/seller/new/index\store_msg.html";i:1517208469;s:41:"./application/seller/new/public\head.html";i:1522050654;s:41:"./application/seller/new/public\left.html";i:1517208469;s:41:"./application/seller/new/public\foot.html";i:1517208469;}*/ ?>
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
    .ncsc-goods-sku.ps-container {
        height: 1px;
        border: 0;
        border-bottom: solid 1px #E6E6E6;
        background: inherit;
        box-shadow: inherit;
    }
    .content_show{
        display: none;
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
        <div class="ncsc-path"><i class="icon-desktop"></i>商家管理中心<i class="icon-angle-right"></i>客服消息<i class="icon-angle-right"></i>系统消息</div>
        <div class="main-content" id="mainContent">
            <div class="tabmenu">
                <ul class="tab pngFix">
                    <li class="active"><a href="<?php echo U('Seller/Index/store_msg'); ?>">系统消息</a></li>
                </ul>
            </div>
            <div class="alert alert-block mt10">
                <ul class="mt5">
                    <li>1、管理员可以看见全部消息。</li>
                    <li>2、只有管理员可以删除消息，删除后其他账户的该条消息也将被删除。</li>
                </ul>
            </div>
            <form id="op">
                <input type="hidden" id="action" name="action"/>
                <table class="ncsc-default-table">
                    <?php if(empty($msg_list) || (($msg_list instanceof \think\Collection || $msg_list instanceof \think\Paginator ) && $msg_list->isEmpty())): ?>
                        <tr>
                            <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span>暂无符合条件的数据记录</span></div></td>
                        </tr>
                        <?php else: ?>
                        <thead>
                        <tr nc_type="table_header">
                            <th class="w30">&nbsp;</th>
                            <th class="w430">消息内容</th>
                            <th class="w120">发送时间</th>
                            <th class="w80">状态</th>
                            <th class="w120">操作</th>
                        </tr>
                        <tr class="content_show">
                            <td class="tc"><input type="checkbox" id="all" class="checkall" onclick="$('input[name*=\'sm_id\']').prop('checked', this.checked);"/></td>
                            <td colspan="20">
                                <label for="all">全选</label>
                                <a onclick="check_action('del');" class="ncbtn-mini"><i class="icon-trash"></i>删除</a>
                                <a onclick="check_action('open');" class="ncbtn-mini"><i></i>标记已读</a>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($msg_list) || $msg_list instanceof \think\Collection || $msg_list instanceof \think\Paginator): $i = 0; $__LIST__ = $msg_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?>
                            <tr class="store_msg_<?php echo $list[sm_id]; ?>">
                                <td class="trigger">
                                    <input type="checkbox" class="checkitem tc" id="check_content_<?php echo $list[sm_id]; ?>" name="sm_id[]" value="<?php echo $list['sm_id']; ?>"/>
                                </td>
                                <td class="tl content_<?php echo $list['sm_id']; ?>"><?php echo $list['content']; ?></td>
                                <td class="goods-time"><span><?php echo date('Y-m-d H:i',$list['addtime']); ?></span></td>
                                <td class="goods-time"><span id="see_content_<?php echo $list[sm_id]; ?>"><?php if($list['open'] == 1): ?>已阅<?php else: ?>未阅<?php endif; ?></span></td>
                                <td class="nscs-table-handle">
                                    <span>
                                        <a onclick="showMsg('content_<?php echo $list['sm_id']; ?>');" class="btn-bluejeans" href="javascript:;">
                                            <i class="icon-search"></i><p>查看</p>
                                        </a>
                                    </span>
                                    <span>
                                        <a onclick="del(this)" data-id="<?php echo $list[sm_id]; ?>" class="btn-grapefruit">
                                            <i class="icon-trash"></i><p>删除</p></a>
                                    </span>
                                </td>
                            </tr>
                            <tr class="store_msg_<?php echo $list[sm_id]; ?>">
                                <td colspan="20">
                                    <div class="ncsc-goods-sku ps-container"></div>
                                </td>
                            </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                        <tfoot>
                        <tr class="content_show">
                            <th class="tc"><input type="checkbox" id="all2" class="checkall" onclick="$('input[name*=\'sm_id\']').prop('checked', this.checked);"/></th>
                            <th colspan="10">
                                <label for="all2">全选</label>
                                <a onclick="check_action('del');" class="ncbtn-mini"><i class="icon-trash"></i>删除</a>
                                <a onclick="check_action('open');" class="ncbtn-mini"><i></i>标记已读</a>
                            </th>
                        </tr>
                        <tr>
                            <td colspan="20">
                                <?php echo $page; ?>
                            </td>
                        </tr>
                        </tfoot>
                    <?php endif; ?>
                </table>
            </form>
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
    var is_admin = <?php echo $seller['is_admin']; ?>;
    $(document).ready(function(){
        if(is_admin == 1){
            $('.content_show').css('display','table-row');  //还原显示，修复block显示结构混乱
        }else{
            $('.content_show').hide();
        }
    })
    // 显示消息
    function showMsg(content_id) {
        layer.msg($('.'+content_id).html(), {time: 5000, icon: 6});
        if (is_admin == 1) {
            $('#check_' + content_id).prop('checked', true);
            layer.confirm($('.' + content_id).html(), {
                        btn: ['确定'] //按钮
                    }, function (index) {
                        $('#see_' + content_id).html('已阅');
                        check_action('open')
                        layer.close(index);
                    }, function (index) {
                        layer.close(index);
                    }
            );
        }
    }
    // 删除操作
    function del(t) {
        if (is_admin == 1) {
            layer.confirm('确定要删除吗？', {
                        btn: ['确定', '取消'] //按钮
                    }, function () {
                        var msg_id = $(t).data('id');
                        $.ajax({
                            type: "POST",
                            url: "<?php echo U('index/del_store_msg'); ?>",
                            data: {sm_id: msg_id},
                            dataType: "json",
                            success: function (data) {
                                if (data.status == 1) {
                                    layer.msg(data.msg, {icon: 1});
                                    $('.store_msg_' + msg_id).html('');
                                } else {
                                    layer.msg(data.msg, {icon: 2});
                                }
                            }
                        });
                    }, function (index) {
                        layer.close(index);
                    }
            );
        }else{
            layer.msg('你不是管理员，没有删除权限！！', {icon: 2});
        }
    }
    function check_action(action){
        var selected = $('input[name*="sm_id"]:checked');
        if(selected.length < 1){
            layer.msg('请至少选择一个条目',{icon:2});
            return false;
        }
        $('#action').val(action);
        $.ajax({
            type: "POST",
            url: "<?php echo U('index/store_msg_batch'); ?>",
            data: $('#op').serialize(),
            dataType: "json",
            success: function (data) {
                layer.open({content:data.msg, time:2000 ,end:function(layero, index){
                    window.location.href="<?php echo U('seller/index/store_msg'); ?>";
                }});
            }
        });
//        $('#op').submit();
    }
</script>
</body>
</html>
