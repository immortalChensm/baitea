<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:46:"./application/admin/view2/store\shop_info.html";i:1522746687;s:44:"./application/admin/view2/public\layout.html";i:1517208468;}*/ ?>
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
<div id="toolTipLayer" style="position: absolute; z-index: 9999; display: none; visibility: visible; left: 95px; top: 573px;"></div>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title"><a class="back" href="javascript:history.back();" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
            <div class="subject">
                <h3>实体店铺管理 - 查看会员“<?php echo $store['realname']; ?>”的实体店铺信息</h3>
            </div>
        </div>
    </div>
   
    <table class="store-joinin" cellspacing="0" cellpadding="0" border="0">
        <thead>
        <tr>
            <th colspan="20">申请信息</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th class="w150">申请人：</th>
            <td><?php echo $store['realname']; ?></td>
        </tr>
        <tr>
            <th class="w150">店铺名称：</th>
            <td><?php echo $store['shop_name']; ?></td>
        </tr>
        
        <tr>
            <th>负责人手机号码：</th>
            <td><?php echo $store['mobile']; ?></td>
        </tr>
        
        <tr>
            <th>店铺图片：</th>
            <td><img src="<?php echo $store['shop_licence_img']; ?>"/></td>
        </tr>
        
        <tr>
            <th>主营商品：</th>
            <td><?php echo $store['shop_products']; ?></td>
        </tr>
        
        <tr>
            <th>注册号：</th>
            <td><?php echo $store['shop_licence_cert']; ?></td>
        </tr>
        
        <tr>
            <th>线下店铺地址：</th>
            <td><?php echo $store['shop_address']; ?></td>
        </tr>
        
        <tr>
            <th>店铺简介：</th>
            <td><?php echo $store['shop_desc']; ?></td>
        </tr>
        
        </tbody>
    </table>

    <table class="store-joinin" cellspacing="0" cellpadding="0" border="0">
        <thead>
        <tr>
            <th colspan="20">证件信息：</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>企业营业执照副本：</th>
            <td colspan="20"><a nctype="nyroModal" href="<?php echo $store['shop_licence_img']; ?>"> <img src="<?php echo $store['shop_licence_img']; ?>" alt=""> </a></td>
        </tr>
        
        <tr>
            <th>店铺负责人身份证：</th>
            <td colspan="20"><a nctype="nyroModal" href="__ROOT__/<?php echo $store['idcard_fpic']; ?>"> <img src="__ROOT__/<?php echo $store['idcard_fpic']; ?>" alt=""> </a></td>
        </tr>
        
        <tr>
            <th>国家认证证书：</th>
            <td colspan="20"><a nctype="nyroModal" href="__ROOT__/<?php echo $store['shop_cert']; ?>"> <img src="__ROOT__/<?php echo $store['shop_cert']; ?>" alt=""> </a></td>
        </tr>
        
        </tbody>
    </table>
    
     <table class="store-joinin" cellspacing="0" cellpadding="0" border="0">
            <thead>
            <tr>
                <th colspan="20">操作信息</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th>备注说明：</th>
                <td colspan="20">
                    <textarea name="review_msg" placeholder="请输入操作备注" rows="3" class="form-control"><?php echo $store['review_msg']; ?></textarea>
                </td>
            </tr>
            <tr>
                <th>商家信息审核：</th>
                <td colspan="20">
                    <input name="shop_state" value="1" <?php if($store['shop_state'] == 1): ?>checked="checked"<?php endif; ?> type="radio">未审核
                    <input name="shop_state" value="2" <?php if($store['shop_state'] == 2): ?>checked="checked"<?php endif; ?> type="radio">通过
                    <input name="shop_state" value="3" <?php if($store['shop_state'] == 3): ?>checked="checked"<?php endif; ?> type="radio">未通过
                </td>
            </tr>
            </tbody>
        </table>
        
</div>
 		<div class="bot" style="margin-left:200px;">
            <a href="JavaScript:void(0);" onclick="revise(this);" data-id="<?php echo $store['id']; ?>" class="ncap-btn-big ncap-btn-green">确认提交</a>
        </div>
        
<script type="text/javascript">

	function revise(obj){
		var url = '/index.php?m=Admin&c=Store&a=shop_revise';
		
		shop_state = 0;
		for(var i=0;i<$(":input[name=shop_state]").length;i++){
			if($(":input[name=shop_state]").eq(i).is(":checked")){
				shop_state = $(":input[name=shop_state]").eq(i).val();
			}
		}
		$.ajax({
			type: 'post',
			url: url,
			data : {
				id:$(obj).attr('data-id'),
				review_msg:$(":input[name=review_msg]").val(),
				shop_state:shop_state,
				},
			dataType: 'json',
			success: function (data) {
				//layer.closeAll();
				if (data.status == 1) {
					//$(obj).parent().parent().parent().remove();
					layer.msg(data.msg, {icon: 1});
				} else {
					layer.alert(data.msg, {icon: 2});
				}
			}
		})
	}

</script>
</body>
</html>