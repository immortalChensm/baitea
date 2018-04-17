<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:54:"./application/admin/view2/order\refund_order_info.html";i:1517208468;s:44:"./application/admin/view2/public\layout.html";i:1517208468;}*/ ?>
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
 
<style type="text/css">
html, body {
	overflow: visible;
}
</style>  
<body style="background-color: #FFF; overflow: auto;">
<div id="toolTipLayer" style="position: absolute; z-index: 9999; display: none; visibility: visible; left: 95px; top: 573px;"></div>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title"><a class="back" href="<?php echo U('Admin/Order/refund_order_list'); ?>" title="返回退款单"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subject">
        <h3>退款单详情</h3>
        <h5>用户提交退款单详情</h5>
      </div>
    </div>
  </div>
  <form class="form-horizontal" method="post" id="refund_form"  name="refund_form" action="<?php echo U('Admin/Order/refund_order'); ?>">
   <div class="ncap-order-style">
    <div class="ncap-order-details">
        <div class="tabs-panels">
            <div class="misc-info">
                <h3>基本信息</h3>
                <dl>
                    <dt>订单 ID：</dt>
                    <dd><?php echo $order['order_id']; ?></dd>
                    <dt>订单号：</dt>
                    <dd><?php echo $order['order_sn']; ?></dd>
                    <dt>会员：</dt>
                    <dd><?php echo $order['consignee']; ?></dd>
                </dl>
                <dl>
                    <dt>E-Mail：</dt>
                    <dd><?php echo $order['email']; ?></dd>
                    <dt>电话：</dt>
                    <dd><?php echo $order['mobile']; ?></dd>
                    <dt>应付金额：</dt>
                    <dd><?php echo $order['order_amount']; ?></dd>
                </dl>
                <dl>
                    <dt>订单状态：</dt>
                    <dd><?php echo $order_status[$order[order_status]]; ?> / <?php echo $pay_status[$order[pay_status]]; ?>
                        / <?php echo $shipping_status[$order[shipping_status]]; ?>
                    </dd>
                    <dt>下单时间：</dt>
                    <dd><?php echo date('Y-m-d H:i',$order['add_time']); ?></dd>
                    <dt>支付时间：</dt>
                    <dd>
                        <?php if($order['pay_time'] != 0): ?><?php echo date('Y-m-d H:i',$order['pay_time']); else: ?>
                            N
                        <?php endif; ?>
                    </dd>
                </dl>
                <dl>
                    <dt>支付方式：</dt>
                    <dd><?php echo (isset($order['pay_name']) && ($order['pay_name'] !== '')?$order['pay_name']:'其他方式'); ?></dd>
                    <dt>发票抬头：</dt>
                    <dd><?php echo (isset($order['invoice_title']) && ($order['invoice_title'] !== '')?$order['invoice_title']:'N'); ?></dd>
                </dl>
            </div>
        
        <div class="addr-note">
          <h4>收货信息</h4>
          <dl>
            <dt>收货人：</dt>
            <dd><?php echo $order['consignee']; ?></dd>
            <dt>联系方式：</dt>
            <dd><?php echo $order['mobile']; ?></dd>
          </dl>
          <dl>
            <dt>收货地址：</dt>
            <dd><?php echo $order['address2']; ?></dd>
          </dl>
          <dl>
            <dt>邮编：</dt>
            	<dd><?php if($order['zipcode'] != ''): ?> <?php echo $order['zipcode']; else: ?>N<?php endif; ?></dd>
          </dl>
          <dl>
           		<dt>配送方式：</dt>
            	<dd><?php echo $order['shipping_name']; ?></dd>
          	</dl>
          	<dl>
           		<dt>取消订单留言：</dt>
            	<dd><?php echo (isset($order['user_note']) && ($order['user_note'] !== '')?$order['user_note']:''); ?></dd>
          	</dl>
        </div>
        <div class="goods-info">
          <h4>商品信息</h4>
          <table>
            <thead>
              <tr>
                <th >商品编号</th>
                <th colspan="2">商品</th>
                <th>规格属性</th>
                <th>数量</th>
                <th>单品价格</th>
                <th>会员折扣价</th>
                <th>单品小计</th>
              </tr>
            </thead>
            <tbody>
            <?php if(is_array($orderGoods) || $orderGoods instanceof \think\Collection || $orderGoods instanceof \think\Paginator): $i = 0; $__LIST__ = $orderGoods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$good): $mod = ($i % 2 );++$i;?>
           	<tr>
                <td class="w60"><?php echo $good['goods_sn']; ?></td>
                <td class="w30"><div class="goods-thumb"><a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$good['goods_id'])); ?>" target="_blank"><img alt="" src="<?php echo goods_thum_images($good['goods_id'],200,200); ?>" /> </a></div></td>
                <td style="text-align: left;"><a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$good['goods_id'])); ?>" target="_blank"><?php echo $good['goods_name']; ?></a><br/></td>
                <td class="w80"><?php echo $good['spec_key_name']; ?></td>
                <td class="w60"><?php echo $good['goods_num']; ?></td>
                <td class="w100"><?php echo $good['goods_price']; ?></td>
                <td class="w60"><?php echo $good['member_goods_price']; ?></td>
                <td class="w80"><?php echo $good['goods_total']; ?></td>
              </tr>
              <?php endforeach; endif; else: echo "" ;endif; ?>
          </table>
        </div>
        <div class="total-amount contact-info">
          <h3>订单总额：￥<?php echo $order['goods_price']; ?></h3>
        </div>
        <div class="contact-info">
          <h3>费用信息 </h3>
          <div class="form_class">
          		<a class="btn green" href="<?php echo U('Admin/Order/editprice',array('order_id'=>$order['order_id'])); ?>"><i class="fa fa-pencil-square-o"></i>修改费用</a>
          </div>   
          <dl>
            <dt>小计：</dt>
            <dd><?php echo $order['goods_price']; ?></dd>
            <dt>运费：</dt>
            <dd>+<?php echo $order['shipping_price']; ?></dd>
            <dt>积分 (-<?php echo $order['integral']; ?>)：</dt>
            <dd>-<?php echo $order['integral_money']; ?></dd>
          </dl>
          <dl>
            <dt>余额抵扣：</dt>
            <dd>-<?php echo $order['user_money']; ?></dd>
            <dt>优惠券抵扣：</dt>
            <dd>-<?php echo $order['coupon_price']; ?></dd>
            <dt>价格调整：</dt>
            <dd>减：<?php echo $order['discount']; ?></dd>
          </dl>
          <dl>
            <dt>应付：</dt>
            <dd><strong class="red_common"><?php echo $order['order_amount']; ?></strong></dd>
           </dl>
        </div>
        <div class="contact-info">
          <h3>退款处理</h3>
             <?php if($order['pay_status'] == 1): ?>
             <dl class="row">
                 <dt class="tit">
                     <label>审核意见</label>
                 </dt>
                 <dd class="opt">
                     <label class="pay_status"><input type="radio" name="pay_status" value="3" checked>同意退款</label>
                     <label class="pay_status"><input type="radio" name="pay_status" value="4">拒绝退款</label>
                 </dd>
             </dl>
             <dl class="row refund_type">
                 <dt class="tit">
                     <label>退款方式</label>
                 </dt>
                 <dd class="opt">
                     <label><input type="radio" name="refund_type" value="0" checked>支付原路退回</label>
                     <label><input type="radio" name="refund_type" value="1">退到用户余额</label>
                 </dd>
             </dl>
             <dl class="row">
		        <dt class="tit">
		          <label for="note">处理备注</label>
		        </dt>
		        <dd class="opt" style="margin-left:10px">
		         <textarea id="admin_note" name="admin_note" style="width:600px" rows="6"  placeholder="请输入操作备注" class="tarea"><?php echo $order['admin_note']; ?></textarea>
		        </dd>
		      </dl>
		      <dl class="row">
		      	<dt  class="tit"></dt>
		      	<dd class="opt" style="margin-left:10px">
		      	    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
               		<a href="JavaScript:;" onClick="refundOrder();" class="ncap-btn-big ncap-btn-green" id="submitBtn">确认提交</a>
		      	</dd>
		      </dl>
             <?php endif; if($order['pay_status'] == 3): ?>
             <dl class="row">
                 <dt class="tit">
                     <label>退款信息：</label>
                 </dt>
                 <dd class="opt">
                     <label>已退款</label>
                 </dd>
             </dl>
             <dl class="row">
		        <dt class="tit">
		          <label for="note">处理备注</label>
		        </dt>
		        <dd class="opt" style="margin-left:10px">
		         <textarea id="admin_note" name="admin_note" style="width:600px" rows="6"  placeholder="请输入操作备注" class="tarea"><?php echo $order['admin_note']; ?></textarea>
		        </dd>
		      </dl>
             <?php endif; if($order['pay_status'] == 4): ?>
             <dl class="row">
		        <dt class="tit">
		          <label for="note">处理备注</label>
		        </dt>
		        <dd class="opt" style="margin-left:10px">
		         <textarea id="admin_note" name="admin_note" style="width:600px" rows="6"  placeholder="请输入操作备注" class="tarea"><?php echo $order['admin_note']; ?></textarea>
		        </dd>
		      </dl>
             <?php endif; ?>
        </div>
      </div>
  	</div>
  	</div>
  </form>
</div>
<script type="text/javascript">
function refundOrder(){
	var admin_note = $('#admin_note').val();
	if(admin_note == ''){
		layer.alert('请填写备注', {icon: 2});
		return false;
	} 
	$('#refund_form').submit();
}
    $(document).on('click','.pay_status',function(){
        var pay_status = $(this).find('input[name="pay_status"]').val();
        if(pay_status == 4){
            $('.refund_type').hide()
        }else{
            $('.refund_type').show()
        }
    })
</script>
</body>
</html>