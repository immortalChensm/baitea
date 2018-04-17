<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:42:"./application/admin/view2/index\index.html";i:1523440343;s:45:"./application/admin/view2/public\menubox.html";i:1517208468;s:42:"./application/admin/view2/public\left.html";i:1517208468;}*/ ?>
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $tpshop_config['shop_info_store_ico']; ?>" media="screen"/>
<title>掌心</title>
<script type="text/javascript">
var SITEURL = window.location.host +'/index.php/admin';
</script>
<link href="__PUBLIC__/static/css/main.css" rel="stylesheet" type="text/css">
<link href="__PUBLIC__/static/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css">
<link href="__PUBLIC__/static/font/css/font-awesome.min.css" rel="stylesheet" />
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/dialog/dialog.js" id="dialog_js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.cookie.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/admincp.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.validation.min.js"></script>
<script src="__PUBLIC__/js/layer/layer.js"></script><!--弹窗js 参考文档 http://layer.layui.com/--> 
<script src="__PUBLIC__/js/upgrade.js"></script>
</head>
<body>
<div class="admincp-map ui-widget-content" tptype="map_nav" style="display:none;" id="draggable" >
  <div class="title ui-widget-header" >
    <h3>管理中心全部菜单</h3>
    <h5>切换显示全部管理菜单，通过点击勾选可添加菜单为管理常用操作项，最多添加10个</h5>
    <span><a tptype="map_off" href="JavaScript:void(0);">X</a></span> </div>
  <div class="content"> 
	  <ul class="admincp-map-nav">
	  <li><a href="javascript:void(0);" data-param="map-system">平台</a></li>
	  <li><a href="javascript:void(0);" data-param="map-shop">商城</a></li>
	  <li><a href="javascript:void(0);" data-param="map-mobile">手机端</a></li>
	  <li><a href="javascript:void(0);" data-param="map-resource">资源</a></li>
	  </ul>
	  <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $mk=>$vo): ?>
	  <div class="admincp-map-div" data-param="map-<?php echo $mk; ?>">
		  <?php if(is_array($vo[child]) || $vo[child] instanceof \think\Collection || $vo[child] instanceof \think\Paginator): if( count($vo[child])==0 ) : echo "" ;else: foreach($vo[child] as $key=>$v2): ?>
		  <dl><dt><?php echo $v2['name']; ?></dt>
		  	<?php if(is_array($v2[child]) || $v2[child] instanceof \think\Collection || $v2[child] instanceof \think\Paginator): if( count($v2[child])==0 ) : echo "" ;else: foreach($v2[child] as $key=>$v3): ?>
		  	<dd class=""><a href="javascript:void(0);" data-param="<?php echo $v3['act']; ?>|<?php echo $v3['op']; ?>"><?php echo $v3['name']; ?></a><i class="fa fa-check-square-o"></i></dd>
		  	<?php endforeach; endif; else: echo "" ;endif; ?>
		  </dl>
		  <?php endforeach; endif; else: echo "" ;endif; ?>
	  </div>
	  <?php endforeach; endif; else: echo "" ;endif; ?> 
  </div>
  <script>
//固定层移动
$(function(){
	//管理显示与隐藏
            $("#admin-manager-btn").click(function () {
                if ($(".manager-menu").css("display") == "none") {
                    $(".manager-menu").css('display', 'block'); 
					$("#admin-manager-btn").attr("title","关闭快捷管理"); 
					$("#admin-manager-btn").removeClass().addClass("arrow-close");
                }
                else {
                    $(".manager-menu").css('display', 'none');
					$("#admin-manager-btn").attr("title","显示快捷管理");
					$("#admin-manager-btn").removeClass().addClass("arrow");
                }           
            });
	
	$("#draggable").draggable({
		handle: "div.title"
	});
	$("div.title").disableSelection()

	$('#_pic').change(uploadChange);
	function uploadChange(){
		var filepath=$(this).val();
		var extStart=filepath.lastIndexOf(".");
		var ext=filepath.substring(extStart,filepath.length).toUpperCase();
		if(ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG"){
			alert("file type error");
			$(this).attr('value','');
			return false;
		}
		if ($(this).val() == '') return false;
		ajaxFileUpload();
	}
});
</script> 
</div>
<style>
    .nc-module-menu ul li {height:auto;margin:0;}
    .nc-module-menu ul li a{padding: 19px 25px;margin:0;}
</style>
<div class="admincp-header">
  <div class="bgSelector"></div>
  <div id="foldSidebar"><i class="fa fa-outdent " title="展开/收起侧边导航"></i></div>
  <div class="admincp-name" style="padding: 5px 0 5px 18px;" onClick="javascript:openItem('welcome|Index');">
    <!-- <h2 style="cursor:pointer;">TPshop2.0<br>平台系统管理中心</h2> -->
    <img style="height:45px;" src="__PUBLIC__/static/images/TPlogo.png" alt="">
  </div>
  <div class="nc-module-menu">
    <ul class="nc-row">
      <li data-param="system"><a href="javascript:void(0);">系统</a></li>
      <li data-param="shop"><a href="javascript:void(0);">商城</a></li>
      <li data-param="community"><a href="javascript:void(0);">社区活动</a></li>
<!--      <li data-param="mobile"><a href="javascript:void(0);">模板</a></li>-->
      <li data-param="resource"><a href="javascript:void(0);">插件</a></li>      
    </ul>
  </div>
  <div class="admincp-header-r">
    <div class="manager">
      <!--服务器升级-->
      <textarea id="textarea_upgrade" style="display:none;"><?php echo $upgradeMsg['1']; ?></textarea>    
      <?php if($upgradeMsg[0] != null): ?>
      <dl style="text-align:left; font-size:15px;">
        <dd class="group"><a href="javascript:void(0);" id="a_upgrade" style="color:#FF0;"><?php echo $upgradeMsg['0']; ?></a></dd>
      </dl>
      <?php endif; ?>
      <!--服务器升级 end-->
      
      <dl>
        <!-- <dt class="name">TPshop2.0</dt>
        <dd class="group">ThinkPHP5框架版</dd> -->
      </dl>    
      <dl>
        <dt class="name"><?php echo $admin_info['user_name']; ?></dt>
        <dd class="group">管理员</dd>
      </dl>
      <span class="avatar">
      <!-- 屏蔽管理员头像上传 -->
      <!-- input name="_pic" type="file" class="admin-avatar-file" id="_pic" title="设置管理员头像"/ -->
      <img alt="" tptype="admin_avatar" src="__PUBLIC__/static/images/admint.png"> </span><i class="arrow" id="admin-manager-btn" title="显示快捷管理菜单"></i>
      <div class="manager-menu">
        <div class="title">
          <h4>最后登录</h4>
          <a href="javascript:void(0);" onClick="CUR_DIALOG = ajax_form('modifypw', '修改密码', '<?php echo U('Admin/modify_pwd',array('admin_id'=>$admin_info['admin_id'])); ?>');" class="edit-password">修改密码</a> </div>
        <div class="login-date"> <?php echo date('Y-m-d H:i:s',session('last_login_time'));?> <span>(IP: <?php echo session('last_login_ip');?> )</span> </div>
        <div class="title">
          <h4>常用操作</h4>
          <a href="javascript:void(0)" class="add-menu">添加菜单</a> </div>
                <ul class="nc-row" tptype="quick_link">
                <li><a href="javascript:void(0);" onClick="openItem('index|System')">站点设置</a></li>
                </ul>
      </div>
    </div>
    <ul class="operate nc-row">
      <!-- li tptype="pending_matters"><a class="toast show-option" href="javascript:void(0);" onClick="$.cookie('commonPendingMatters', 0, {expires : -1});ajax_form('pending_matters', '待处理事项', 'http://www.tpshop.cn/admin/index.php?act=common&op=pending_matters', '480');" title="查看待处理事项">&nbsp;<em>0</em></a></li-->
      <!-- li><a class="style-color show-option" tptype="map_on" href="javascript:void(0);" title="查看全部管理菜单">&nbsp;</a></li -->
      <li><a class="sitemap show-option" id="trace_show" href="<?php echo U('System/cleanCache'); ?>" target="workspace" title="更新缓存">&nbsp;</a></li>
      <li><a class="homepage show-option" target="_blank" href="/" title="新窗口打开商城首页">&nbsp;</a></li>
      <li><a class="login-out show-option" href="<?php echo U('Admin/logout'); ?>" title="安全退出管理中心">&nbsp;</a></li>
    </ul>
  </div>
  <div class="clear"></div>
</div>
<div class="admincp-container unfold">
<div class="admincp-container-left">
    <div class="top-border"><span class="nav-side"></span><span class="sub-side"></span></div>
    <div id="admincpNavTabs_index" class="nav-tabs">
    	<dl>
		    <dt><a href="javascript:void(0);"><span class="ico-microshop-1"></span><h3>概览</h3></a></dt>
		    <dd class="sub-menu">
			    <ul>
				    <li><a href="javascript:void(0);" data-param="welcome|Index">系统后台</a></li>
			    </ul>
		    </dd>
	    </dl>
    </div>
    <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $mk=>$vo): ?>
    <div id="admincpNavTabs_<?php echo $mk; ?>" class="nav-tabs">
    	<?php if(is_array($vo[child]) || $vo[child] instanceof \think\Collection || $vo[child] instanceof \think\Paginator): if( count($vo[child])==0 ) : echo "" ;else: foreach($vo[child] as $key=>$v2): ?>
	    <dl>
		    <dt><a href="javascript:void(0);"><span class="ico-<?php echo $mk; ?>-<?php echo $key; ?>"></span><h3><?php echo $v2['name']; ?></h3></a></dt>
		    <dd class="sub-menu">
			    <ul>
			    	<?php if(is_array($v2[child]) || $v2[child] instanceof \think\Collection || $v2[child] instanceof \think\Paginator): if( count($v2[child])==0 ) : echo "" ;else: foreach($v2[child] as $key=>$v3): ?>
				    	<li><a href="javascript:void(0);" data-param="<?php echo $v3['act']; ?>|<?php echo $v3['op']; ?>"><?php echo $v3['name']; ?></a></li>
				    <?php endforeach; endif; else: echo "" ;endif; ?>
			    </ul>
		    </dd>
	    </dl>
    	<?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; ?> 
    <div class="about" title="关于系统" onclick="javascript:layer.open({type: 2,title: '关于我们',shadeClose: true,shade: 0.3,area: ['50%', '60%'],content:'<?php echo U("Index/about"); ?>', });"><!-- <i class="fa fa-copyright"></i> --><span></span></div>
</div>
  <div class="admincp-container-right">
    <div class="top-border"></div>
    <iframe src="" id="workspace" name="workspace" style="overflow: visible;" frameborder="0" width="100%" height="94%" scrolling="yes" onload="window.parent"></iframe>
  </div>
</div>
<script type="text/javascript">
	// 没有点击收货确定的按钮让他自己收货确定
	var timestamp = Date.parse(new Date());
	$.ajax({
        type:'post',
        url:"<?php echo U('Admin/System/login_task'); ?>",
        data:{timestamp:timestamp},
        timeout : 100000000, //超时时间设置，单位毫秒
        success:function(){
            // 执行定时任务
        }
    });  
</script>
</body>
</html>