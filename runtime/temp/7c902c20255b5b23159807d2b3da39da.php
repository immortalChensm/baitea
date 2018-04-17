<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:51:"./application/admin/view2/store\shop_info_edit.html";i:1522744889;s:44:"./application/admin/view2/public\layout.html";i:1517208468;}*/ ?>
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
<script type="text/javascript" src="__ROOT__/public/static/js/layer/laydate/laydate.js"></script>
<body style="background-color: #FFF; overflow: auto;">
<div id="toolTipLayer" style="position: absolute; z-index: 9999; display: none; visibility: visible; left: 95px; top: 573px;"></div>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
	<div class="fixed-bar">
		<div class="item-title"><a class="back" href="javascript:history.back();" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
			<div class="subject">
				<h3>实体店铺管理 - 编辑店铺</h3>
				<h5>网站系统编辑店铺</h5>
			</div>
		</div>
	</div>
	<form class="form-horizontal" method="post" id="store_info">

		<div class="ncap-form-default" id="tab_info">
		<table>
		<tbody>
				<tr>
					<th>店铺负责人身份证：</th>
					<td colspan="20">
						<a href="<?php echo $apply['store_person_cert']; ?>" target="_blank">
							<?php if($apply[store_person_cert] == ''): ?>
								<img id="store_person_cert" src="__PUBLIC__/images/not_adv.jpg" height="120">
								<?php else: ?>
								<img id="store_person_cert" src="<?php echo $apply['store_person_cert']; ?>" height="120">
							<?php endif; ?>
						</a>
						<input type="hidden" name="store_person_cert" value="<?php echo $apply['store_person_cert']; ?>">
						<input type="button" class="btn btn-default" onClick="upload_img('store_person_cert')"  value="上传图片"/>
					</td>
				</tr>
				
				<tr>
					<th>企业营业执照副本：</th>
					<td colspan="20">
						<a target="_blank" href="<?php echo $apply['business_licence_cert']; ?>">
							<?php if($apply[business_licence_cert] == ''): ?>
								<img id="business_licence_cert" src="__PUBLIC__/images/not_adv.jpg" height="120">
								<?php else: ?>
								<img id="business_licence_cert" src="<?php echo $apply['business_licence_cert']; ?>" height="120">
							<?php endif; ?>
						</a>
						<input type="hidden" name="business_licence_cert" value="<?php echo $apply['business_licence_cert']; ?>">
						<input type="button" class="btn btn-default" onClick="upload_img('business_licence_cert')"  value="上传图片"/>
					</td>
				</tr>
				
				</tbody>
			</table>
			<div class="bot"><a href="JavaScript:void(0);" onclick="actsubmit();" class="ncap-btn-big ncap-btn-green">确认提交</a></div>
		</div>
		
		<input type="hidden" name="store[user_id]" value="<?php echo $store['user_id']; ?>">
		<input type="hidden" name="store_id" value="<?php echo $store['store_id']; ?>">
		
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		/*
		// 加载默认选中
		var province_id = $('#province').val();
		if(province_id != 0){
			$('#province').trigger('blur');
		}
		var bank_province_id = $('#bank_province').val();
		if(bank_province_id != 0){
			$('#bank_province').trigger('blur');
		}
		// 加载默认选中
		<?php if($apply[company_district] > 0): ?>
				set_area('<?php echo $apply[company_city]; ?>','<?php echo $apply[company_district]; ?>');
		<?php endif; ?>
		*/
		
	});
	
	$('#store_end_time').layDate();
	
	/**
	 * 获取地区
	 */
	function set_area(parent_id,selected){
		if(parent_id <= 0){
			return;
		}
		$('#district').empty().css('display','inline');
		var url = '/index.php?m=Home&c=Api&a=getRegion&level=3&parent_id='+ parent_id+"&selected="+selected;
		$.ajax({
			type : "GET",
			url  : url,
			error: function(request) {
				layer.alert('服务器繁忙, 请联系管理员', {icon: 2});
				return;
			},
			success: function(v) {
				v = '<option>选择区域</option>'+ v;
				$('#district').empty().html(v);
			}
		});
	}
	var flag = true;
	function actsubmit(){
		if($('input[name=store_name]').val() == ''){
			layer.msg("店铺名称不能为空", {icon: 2,time: 2000});
			return;
		}
		if(flag){
			$('#store_info').submit();
		}else{
			layer.msg("请检查店铺名称和卖家账号", {icon: 2,time: 2000});
		}
	}

	var tmp_type = '';
	function upload_img(cert_type){
		tmp_type = cert_type;
		GetUploadify(1,'store','cert','callback');
	}

	function callback(img_str){
		$('#'+tmp_type).attr('src',img_str);
		$('input[name='+tmp_type+']').val(img_str);
	}
</script>
</body>
</html>