<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:50:"./application/admin/view2/service\refund_info.html";i:1517208468;s:44:"./application/admin/view2/public\layout.html";i:1517208468;}*/ ?>
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
    <div class="item-title"><a class="back" href="javascript:history.back(-1)" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subject">
        <h3>退货管理 - 查看退单“退单编号：<?php echo $order['order_sn']; ?>”</h3>
        <h5>商品订单退货申请及审核处理</h5>
      </div>
    </div>
  </div>
  <div class="ncap-form-default">
   <div class="title">
      <h3>买家退货退款申请</h3>
    </div>
      <dl class="row">
        <dt class="tit">申请时间</dt>
        <dd class="opt"><?php echo date('Y-m-d H:i:s',$return_goods['addtime']); ?> </dd>
      </dl>
    <dl class="row">
      <dt class="tit">商品名称</dt>
      <dd class="opt"><?php echo $order_goods['goods_name']; ?></dd>
    </dl>
    <dl class="row">
      <dt class="tit">退款金额</dt>
      <dd class="opt"><?php echo $return_goods['refund_money']; if($return_goods[refund_deposit] > 0): ?>
      <label>退还余额：<?php echo $return_goods['refund_deposit']; ?></label>
      <?php endif; if($return_goods[refund_integral] > 0): ?>
      <label>退还积分：<?php echo $return_goods['refund_integral']; ?></label>
      <?php endif; ?>
      </dd>
    </dl>
    <dl class="row">
      <dt class="tit">退货原因</dt>
      <dd class="opt"><?php echo $return_goods['reason']; ?></dd>
    </dl>
   <dl class="row">
    <dt class="tit">退货数量</dt>
    <dd class="opt"><?php echo $return_goods['goods_num']; ?></dd>
    </dl>
    <dl class="row">
      <dt class="tit">退货说明</dt>
      <dd class="opt"><?php echo $return_goods['describe']; ?></dd>
    </dl>
    <dl class="row">
      <dt class="tit">凭证上传</dt>
      <dd class="opt">
      	 <?php if(is_array($return_goods[imgs]) || $return_goods[imgs] instanceof \think\Collection || $return_goods[imgs] instanceof \think\Paginator): if( count($return_goods[imgs])==0 ) : echo "" ;else: foreach($return_goods[imgs] as $key=>$vo): ?>
         	<a href="<?php echo $vo; ?>" class="nyroModal" rel="gal"><img height="64" class="show_image" src="<?php echo $vo; ?>"></a>
         <?php endforeach; endif; else: echo "" ;endif; ?>
      </dd>
    </dl>
     <div class="title">
      <h3>商家退款退货处理</h3>
    </div>
    <dl class="row">
      <dt class="tit">审核结果</dt>
      <dd class="opt">
		<?php if($return_goods[status] == -2): ?>服务单取消
          <?php elseif($return_goods[status] == -1): ?>不同意
          <?php elseif($return_goods[status] == 0): ?>待审核
          <?php else: ?>同意
          <?php endif; ?>
	  </dd>
    </dl>
    <dl class="row">
      <dt class="tit">处理备注</dt>
      <dd class="opt"><?php echo $return_goods['remark']; ?></dd>
    </dl>
    <dl class="row">
      <dt class="tit">处理时间</dt>
      <dd class="opt"><?php if($return_goods[checktime] > 0): ?><?php echo date('Y-m-d H:i:s',$return_goods['checktime']); endif; ?></dd>
    </dl>
    <div class="title">
        <h3>订单支付信息</h3>
    </div>
    <dl class="row">
        <dt class="tit">支付方式</dt>
        <dd class="opt">
            <?php if($order[pay_status] == 1 and empty($order['pay_name'])): ?>
                在线支付
            <?php else: ?>
                <?php echo $order['pay_name']; endif; ?>
        </dd>
    </dl>
    <dl class="row">
        <dt class="tit">订单总额</dt>
        <dd class="opt"><?php echo $order['total_amount']; ?></dd>
    </dl>
    <?php if($return_goods[status] == 3): ?>
	    <div class="title">
	      <h3>平台退款审核</h3>
	    </div>
	    <form id="refundform" action="" method="post">
	    <dl class="row">
	        <dt class="tit">退款方式</dt>
	        <dd class="opt">				    
	        	<input type="radio" name="refund_type" value="1" checked>退到预存款  &nbsp;&nbsp;&nbsp;&nbsp;
	        	<?php if(!(empty($order[transaction_id]) || (($order[transaction_id] instanceof \think\Collection || $order[transaction_id] instanceof \think\Paginator ) && $order[transaction_id]->isEmpty()))): ?>
	            	<input type="radio" name="refund_type" value="0">支付原路退还
	            <?php endif; ?>
	            <input type="hidden" name="id" value="<?php echo $return_goods['id']; ?>">
	        </dd>
	    </dl>
	    <dl class="row">
	        <dt class="tit">
	          <label><em>*</em>备注信息</label>
	        </dt>
	        <dd class="opt">
	          <textarea id="refund_mark" name="refund_mark" class="tarea"></textarea>
	          <span class="err"></span> 
	          <p class="notic">系统默认退款到“站内余额”，如果“在线退款”到原支付账号，建议在备注里说明，方便核对。</p>
	        </dd>
	    </dl>
	    <div class="bot"><a href="JavaScript:void(0);" onclick="javascript:$('#refundform').submit();" class="ncap-btn-big ncap-btn-green" id="submitBtn">确认提交</a></div>
	    </form>
    <?php endif; if($return_goods[status] == 5): ?>
        <div class="title">
          <h3>平台退款审核</h3>
        </div>
        <dl class="row">
          <dt class="tit">平台确认</dt>
          <dd class="opt">已完成</dd>
        </dl>
        <dl class="row">
          <dt class="tit">处理备注</dt>
          <dd class="opt"><?php echo $return_goods['refund_mark']; ?></dd>
        </dl>
        <dl class="row">
          <dt class="tit">处理时间</dt>
          <dd class="opt"><?php echo date('Y-m-d H:i:s',$return_goods['refund_time']); ?> </dd>
        </dl>
        <div class="title">
          <h3>退款详细</h3>
        </div>
        <dl class="row">
          <dt class="tit">支付方式</dt>
          <dd class="opt"><?php if($return_goods[refund_type] == 0): ?>站内余额支付<?php else: ?>在线原路退回<?php endif; ?></dd>
        </dl>
        <dl class="row">
           <dt class="tit">退还预存款</dt>
           <dd class="opt"><?php echo $return_goods['refund_deposit']; ?> </dd>
        </dl>
        <dl class="row">
            <dt class="tit">退款金额</dt>
            <dd class="opt"><?php echo $return_goods['refund_money']; ?> </dd>
        </dl>
    <?php endif; ?>
   </div>
</div>
<div id="goTop"> <a href="JavaScript:void(0);" id="btntop"><i class="fa fa-angle-up"></i></a><a href="JavaScript:void(0);" id="btnbottom"><i class="fa fa-angle-down"></i></a></div>
</body>
</html>