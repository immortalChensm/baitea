<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:46:"./application/admin/view2/store\store_add.html";i:1517208468;s:44:"./application/admin/view2/public\layout.html";i:1517208468;}*/ ?>
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
<link href="__PUBLIC__/static/css/main.css" rel="stylesheet" type="text/css">
<link href="__PUBLIC__/static/css/page.css" rel="stylesheet" type="text/css">
<link href="__PUBLIC__/static/font/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="__PUBLIC__/static/font/css/font-awesome-ie7.min.css">
<![endif]-->
<link href="__PUBLIC__/static/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
<link href="__PUBLIC__/static/js/perfect-scrollbar.min.css" rel="stylesheet" type="text/css"/>
<style type="text/css">html, body { overflow: visible;}</style>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/layer/layer.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
<script type="text/javascript" src="__PUBLIC__/static/js/admin.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.mousewheel.js"></script>
<script src="__PUBLIC__/js/myFormValidate.js"></script>
<script src="__PUBLIC__/js/myAjax2.js"></script>
<script src="__PUBLIC__/js/global.js"></script>
<script type="text/javascript">
function delfunc(obj){
	layer.confirm('确认删除？', {
		  btn: ['确定','取消'] //按钮
		}, function(){
			$.ajax({
				type : 'post',
				url : $(obj).attr('data-url'),
				data : {act:'del',del_id:$(obj).attr('data-id')},
				dataType : 'json',
				success : function(data){
					layer.closeAll();
					if(data.status==1){
                        $(obj).parent().parent().parent().html('');
						layer.msg('操作成功', {icon: 1});
					}else{
						layer.msg('删除失败', {icon: 2,time: 2000});
					}
				}
			})
		}, function(index){
			layer.close(index);
		}
	);
}

function delAll(obj,name){
	var a = [];
	$('input[name*='+name+']').each(function(i,o){
		if($(o).is(':checked')){
			a.push($(o).val());
		}
	})
	if(a.length == 0){
		layer.alert('请选择删除项', {icon: 2});
		return;
	}
	layer.confirm('确认删除？', {btn: ['确定','取消'] }, function(){
			$.ajax({
				type : 'get',
				url : $(obj).attr('data-url'),
				data : {act:'del',del_id:a},
				dataType : 'json',
				success : function(data){
					layer.closeAll();
					if(data == 1){
						layer.msg('操作成功', {icon: 1});
						$('input[name*='+name+']').each(function(i,o){
							if($(o).is(':checked')){
								$(o).parent().parent().remove();
							}
						})
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

//表格列表全选反选
$(document).ready(function(){
	$('.hDivBox .sign').click(function(){
	    var sign = $('#flexigrid > table>tbody>tr');
	   if($(this).parent().hasClass('trSelected')){
	       sign.each(function(){
	           $(this).removeClass('trSelected');
	       });
	       $(this).parent().removeClass('trSelected');
	   }else{
	       sign.each(function(){
	           $(this).addClass('trSelected');
	       });
	       $(this).parent().addClass('trSelected');
	   }
	})
});

//获取选中项
function getSelected(){
	var selectobj = $('.trSelected');
	var selectval = [];
    if(selectobj.length > 0){
        selectobj.each(function(){
        	selectval.push($(this).attr('data-id'));
        });
    }
    return selectval;
}

function selectAll(name,obj){
    $('input[name*='+name+']').prop('checked', $(obj).checked);
}   

function get_help(obj){
	
	window.open("http://www.tp-shop.cn/");
	return false;
	
    layer.open({
        type: 2,
        title: '帮助手册',
        shadeClose: true,
        shade: 0.3,
        area: ['70%', '80%'],
        content: $(obj).attr('data-url'), 
    });
}

//
///**
// * 全选
// * @param obj
// */
//function checkAllSign(obj){
//    $(obj).toggleClass('trSelected');
//    if($(obj).hasClass('trSelected')){
//        $('#flexigrid > table>tbody >tr').addClass('trSelected');
//    }else{
//        $('#flexigrid > table>tbody >tr').removeClass('trSelected');
//    }
//}
/**
 * 批量公共操作（删，改）
 * @returns {boolean}
 */
function publicHandleAll(type){
    var ids = '';
    $('#flexigrid .trSelected').each(function(i,o){
//            ids.push($(o).data('id'));
        ids += $(o).data('id')+',';
    });
    if(ids == ''){
        layer.msg('至少选择一项', {icon: 2, time: 2000});
        return false;
    }
    publicHandle(ids,type); //调用删除函数
}
/**
 * 公共操作（删，改）
 * @param type
 * @returns {boolean}
 */
function publicHandle(ids,handle_type){
    layer.confirm('确认当前操作？', {
                btn: ['确定', '取消'] //按钮
            }, function () {
                // 确定
                $.ajax({
                    url: $('#flexigrid').data('url'),
                    type:'post',
                    data:{ids:ids,type:handle_type},
                    dataType:'JSON',
                    success: function (data) {
                        layer.closeAll();
                        if (data.status == 1){
                            layer.msg(data.msg, {icon: 1, time: 2000},function(){
                                location.href = data.url;
                            });
                        }else{
                            layer.msg(data.msg, {icon: 2, time: 3000});
                        }
                    }
                });
            }, function (index) {
                layer.close(index);
            }
    );
}
</script>
</head>
<body style="background-color: #FFF; overflow: auto;">
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
	<div class="fixed-bar">
		<div class="item-title"><a class="back" href="<?php echo U('Store/store_list'); ?>" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
			<div class="subject">
				<h3>店铺 - 新增"</h3>
				<h5>商城自营店铺相关设置与管理</h5>
			</div>
		</div>
	</div>
	<!-- 操作说明 -->
	<div class="explanation" id="explanation">
		<div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
			<h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
			<span id="explanationZoom" title="收起提示"></span> </div>
		<ul>
			<?php if($is_own_shop == 1): ?>
				<li>平台可以在此处添加自营店铺，新增的自营店铺默认为开启状态</li>
				<li>新增自营店铺默认绑定所有经营类目并且佣金为0，可以手动设置绑定其经营类目</li>
				<li>新增自营店铺将自动创建店主会员账号（用于登录网站会员中心）以及商家账号（用于登录商家中心）</li>
            <?php else: ?>
				<li>1. 平台可以在此处添加外驻店铺，新增的外驻店铺默认为开启状态</li>
				<li>2. 新增外驻店铺默认绑定所有经营类目并且佣金为0，可以手动设置绑定其经营类目。</li>
				<li>3. 新增外驻店铺将自动创建店主会员账号（用于登录网站会员中心）以及商家账号（用于登录商家中心）。</li>
			<?php endif; ?>
		</ul>
	</div>
	<form id="store_info" method="post">
		<div class="ncap-form-default">
			<dl class="row">
				<dt class="tit">
					<label for="store_name"><em>*</em>店铺名称</label>
				</dt>
				<dd class="opt">
					<input type="text" value="<?php echo $store['store_name']; ?>" id="store_name" name="store_name" class="input-txt" />
					<span class="err"></span>
					<p class="notic"></p>
				</dd>
			</dl>
			<dl class="row">
				<dt class="tit">
					<label for="member_name"><em>*</em>会员账号</label>
				</dt>
				<dd class="opt">
					<input type="text" value="<?php echo $store['user_name']; ?>" id="user_name" name="user_name" class="input-txt" />
					<span class="err"></span>
					<p class="notic">请输入手机号或者邮箱，用于登录会员中心</p>
				</dd>
			</dl>
			<dl class="row">
				<dt class="tit">
					<label for="seller_name"><em>*</em>商家账号</label>
				</dt>
				<dd class="opt">
					<input type="text" value="<?php echo $store['seller_name']; ?>" id="seller_name" name="seller_name" class="input-txt" />
					<span class="err"></span>
					<p class="notic">用于登录商家中心，可与店主账号不同</p>
				</dd>
			</dl>
			<dl class="row">
				<dt class="tit">
					<label for="member_passwd"><em>*</em>登录密码</label>
				</dt>
				<dd class="opt">
					<input type="password" value="<?php echo $store['password']; ?>" id="password" name="password" class="input-txt" />
					<span class="err"></span>
					<p class="notic"></p>
				</dd>
			</dl>
			<div class="bot">
				<a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="actsubmit()">确认提交</a>
				<input type="hidden" name="is_own_shop" value="<?php echo $is_own_shop; ?>">
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
	var flag = true;
	function actsubmit(){
		if($('input[name=store_name]').val() == ''){
			layer.msg("店铺名称不能为空", {icon: 2,time: 2000});
			return;
		}
		var user_name = $('input[name=user_name]').val();
		if(user_name == ''){
			layer.msg("店主账号不能为空", {icon: 2,time: 2000});
			return;
		}
		if(!checkEmail(user_name) && !checkMobile(user_name)){
			layer.msg("前台账号要求是手机号或者邮箱号", {icon: 2,time: 2000});
			return;
		}
		if($('input[name=seller_name]').val() == ''){
			layer.msg("店主卖家账号不能为空", {icon: 2,time: 2000});
			return;
		}
		if($('input[name=password]').val() == ''){
			layer.msg("登陆密码不能为空", {icon: 2,time: 2000});
			return;
		}
		if(flag){
            $.ajax({
                type:'post',
                url:"<?php echo U('Store/store_add'); ?>",
                dataType:'json',
                data:$('#store_info').serialize(),
                success:function(res){
                    if(res.status != '1'){
                        layer.msg(res.msg, {icon: 2,time: 2000});
                        return;
                    }else{
                        layer.msg(res.msg, {icon: 1,time: 2000});
                        window.location.href=res.url;
                    }
                }
            });
//			$('#store_info').submit();
		}
	}

	function store_check(){
		$.ajax({
			type:'post',
			url:"<?php echo U('Store/store_check'); ?>",
			dataType:'json',
			data:{store_name:$('input[name=store_name]').val(),seller_name:$('input[name=seller_name]').val(),user_name:$('input[name=user_name]').val()},
			success:function(res){
				if(res.status != '1'){
					layer.msg(res.msg, {icon: 2,time: 2000});
					flag = false;
					return;
				}else{
					flag = true;
				}
			}
		});
	}
</script>
</body>
</html>