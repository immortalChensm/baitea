<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:49:"./application/admin/view2/finance\remittance.html";i:1517208468;s:44:"./application/admin/view2/public\layout.html";i:1517208468;}*/ ?>
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
<script src="__ROOT__/public/static/js/layer/laydate/laydate.js"></script>
<body style="background-color: rgb(255, 255, 255); overflow: auto; cursor: default; -moz-user-select: inherit;">
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>会员汇款记录</h3>
                <h5>网站系统会员汇款索引与管理</h5>
            </div>
            <ul class="tab-base nc-row">
            	<li><a <?php if($status == 1): ?>class="current"<?php endif; ?> href="<?php echo U('Finance/remittance',array('status'=>1)); ?>"><span>待转账列表</span></a></li>
            	<li><a <?php if($status == 2): ?>class="current"<?php endif; ?> href="<?php echo U('Finance/remittance',array('status'=>2)); ?>"><span>已转账列表</span></a></li>
            </ul>
        </div>
    </div>
    <!-- 操作说明 -->
    <div id="explanation" class="explanation" style="color: rgb(44, 188, 163); background-color: rgb(237, 251, 248); width: 99%; height: 100%;">
        <div id="checkZoom" class="title"><i class="fa fa-lightbulb-o"></i>
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span title="收起提示" id="explanationZoom" style="display: block;"></span>
        </div>
        <ul>
			<li>支付宝，微信在线转账会接收到付款成功通知，自动完成转账，银行卡转账则需要手动确认完成</li>
			<li>支付宝，微信支付接口支持在线向用户付款完成转账，银行卡提现请通过网银在线转账或者其他方式处理</li>
			<li>手动完成转账是指通过银行打款或其他转款方式处理了该笔提现申请，手动这一步操作只是标示该申请提现流程已处理完</li>
        </ul>
    </div>
    <div class="flexigrid">
        <div class="mDiv">
            <div class="ftitle">
                <h3>会员汇款转账列表</h3>
                <h5>(共<span id="total"></span>条记录)</h5>
            </div>
            <div title="刷新数据" class="pReload"><i class="fa fa-refresh"></i></div>
            <form class="navbar-form form-inline" id="remittance-form" method="get" action="<?php echo U('remittance'); ?>" onsubmit="return check_form();">
                <input type="hidden" name="create_time" id="create_time" value="<?php echo $create_time; ?>">
                <div class="sDiv">
                    <div class="sDiv2" style="margin-right: 10px;">
                        <input type="text" size="30" id="start_time" value="<?php echo $start_time; ?>" placeholder="起始时间" class="qsbox">
                        <input type="button" class="btn" value="起始时间">
                    </div>
                    <div class="sDiv2" style="margin-right: 10px;">
                        <input type="text" size="30" id="end_time" value="<?php echo $end_time; ?>" placeholder="截止时间" class="qsbox">
                        <input type="button" class="btn" value="截止时间">
                    </div>
                    <div class="sDiv2" style="margin-right: 10px;">
                        <input size="30" id="user_id" placeholder="用户id" value="<?php echo $_GET[user_id]; ?>" name="user_id" class="qsbox" type="text">
                    </div>
                    <div class="sDiv2" style="margin-right: 10px;">
                        <input size="30" placeholder="收款账户真实姓名" value="<?php echo $_GET[realname]; ?>" name="realname" class="qsbox" type="text">
                    </div>
                    <div class="sDiv2">
                        <input size="30" placeholder="收款账号" value="<?php echo $_GET[bank_card]; ?>" name="bank_card" class="qsbox" type="text">
                        <input type="hidden" name="export" id="export" value="0">
                        <input type="hidden" name="status"  value="<?php echo $status; ?>">
                        <input class="btn" value="搜索" type="button" onclick="form_submit(0)">
                    </div>
                </div>
            </form>
        </div>
        <div class="hDiv">
            <div class="hDivBox">
                <table cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th class="sign" axis="col0">
                           <div style="text-align: center; width: 50px;" class="">
                                <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);">
                            </div>
                        </th>
                        <th align="center" axis="col3" class="">
                            <div style="text-align: center; width: 50px;" class="">记录ID</div>
                        </th>
                        <th align="center"  axis="col5" class="">
                            <div style="text-align: center; width: 100px;" class="">用户昵称</div>
                        </th>
                        <th align="center"  axis="col6" class="">
                            <div style="text-align: center; width: 150px;" class="">银行机构名称</div>
                        </th>
                        <th align="center" axis="col6" class="">
                            <div style="text-align: center; width: 100px;" class="">账户号码</div>
                        </th>
                        <th align="center" axis="col6" class="">
                            <div style="text-align: center; width: 100px;" class="">账户开户名</div>
                        </th>
                        <th align="center" axis="col6" class="">
                            <div style="text-align: center; width: 80px;" class="">申请金额</div>
                        </th>
                        <th align="center" axis="col6" class="">
                            <div style="text-align: center; width: 50px;" class="">状态</div>
                        </th>
                        <th align="center" axis="col6" class="">
                            <div style="text-align: center; width: 150px;" class="">
                            	<?php if($status == 1): ?>审核时间<?php else: ?>转账时间<?php endif; ?>
                            </div>
                        </th>
                        <th align="center" abbr="article_time" axis="col6" class="">
                            <div style="text-align: center; width: 200px;" class="">备注</div>
                        </th>
                        <?php if($status == 1): ?>
                        <th align="center" abbr="article_time" axis="col6" class="">
                            <div style="text-align: center; width: 100px;" class="">操作</div>
                        </th>
                        <?php endif; ?>
                        <th style="width:100%" axis="col7">
                            <div></div>
                        </th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <form class="form-inline" id="transfer-form" method="get" action="<?php echo U('transfer'); ?>">
        <div class="tDiv">
            <div class="tDiv2">
                <div class="fbutton"> <a href="javascript:;" onclick="form_submit(1)">
                    <div class="add" title="导出excel">
                        <span><i class="fa fa-plus"></i>导出excel</span>
                    </div>
                </a> </div>
                <?php if($status == 1): ?>
                <div class="fbutton">
                    <a onclick="act_submit('online')">
                        <div class="add" title="在线转账">
                            <span><i class="fa fa-hand-o-right"></i>在线完成转账</span>
                        </div>
                    </a>
                </div>
                <div class="fbutton">
                    <a onclick="act_submit('hand')">
                        <div class="add" title="手动已转账">
                            <span><i class="fa fa-hand-o-up"></i>手动完成转账</span>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <div style="clear:both"></div>
        </div>
        <input type="hidden" name="atype" id="atype" value="hand">
        <div class="bDiv" style="height: auto;">
        	<div id="flexigrid" cellpadding="0" cellspacing="0" border="0">
			    <table>
			        <tbody>
			        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
			            <tr>
                            <td align="center" class="">
                                <div style="text-align: center; width: 50px;">
                                    <?php if($v['status'] == 1): ?><input type="checkbox" name="selected[]" value="<?php echo $v['id']; ?>"><?php endif; ?>
                                </div>
                            </td>
			                <td align="center" class="">
			                    <div style="text-align: center; width: 50px;">
			                        <a class="open" href="<?php echo U('editWithdrawals',array('id'=>$v[id])); ?>">
			                            <?php echo $v['id']; ?><i class="fa fa-external-link " title="新窗口打开"></i>
			                        </a>
			                    </div>
			                </td>
			                <td align="center" class="">
			                    <div style="text-align: center; width: 100px;">
			                        <a class="open" href="<?php echo U('Admin/user/detail',array('id'=>$v[user_id])); ?>" target="blank">
			                            <?php echo $v['nickname']; ?><i class="fa fa-external-link " title="新窗口打开"></i>
			                        </a>
			                    </div>
			                </td>
			                <td align="center" class="">
			                    <div style="text-align: center; width: 150px;"><?php echo $v['bank_name']; ?></div>
			                </td>
			                <td align="center" class="">
			                    <div style="text-align: center; width: 100px;"><?php echo $v['bank_card']; ?></div>
			                </td>
			                <td align="center" class="">
			                    <div style="text-align: center; width: 100px;"><?php echo $v['realname']; ?></div>
			                </td>
			                <td align="center" class="">
			                    <div style="text-align: center; width: 80px;"><?php echo $v['money']; ?></div>
			                </td>
			                <td align="center" class="">
			                    <div style="text-align: center; width: 50px;"><?php if($v[status] == 1): ?>待转账<?php else: ?>已转账<?php endif; ?></div>
			                </td>
			                <td align="center" class="">
			                    <div style="text-align: center; width: 150px;"><?php echo date("Y-m-d H:i",$v['create_time']); ?></div>
			                </td>
			                <td align="center" class="">
			                    <div style="text-align: center; width: 200px;"><?php echo $v['remark']; ?></div>
			                </td>
			                <?php if($status == 1): ?>
			                	<td align="center" class="handle">
			                	    <div style="text-align: center; width: 170px; max-width:250px;">
                                    	<a href="<?php echo U('transfer',array('selected'=>$v['id'],'atype'=>'online')); ?>" class="btn blue"><i class="fa fa-hand-o-right"></i>在线转账</a>
                                		<a href="<?php echo U('transfer',array('selected'=>$v['id'],'atype'=>'hand')); ?>" class="btn blue"><i class="fa fa-hand-o-up"></i>手动转账</a>
                                	</div>
			                	</td>
			                <?php endif; ?>
			                <td align="" class="" style="width: 100%;">
			                    <div>&nbsp;</div>
			                </td>
			            </tr>
			        <?php endforeach; endif; else: echo "" ;endif; ?>
			        </tbody>
			    </table>
			</div>
        </div>
        </form>
        <!--分页位置-->
        <?php echo $show; ?> </div>
</div>
<script>
    $(document).ready(function(){
        // 点击刷新数据
        $('.fa-refresh').click(function(){
            location.href = location.href;
        });

        // 点击刷新数据
        $('.fa-refresh').click(function(){
            location.href = location.href;
        });

        $('#start_time').layDate();
        $('#end_time').layDate();
    });

    function check_form(){
        var start_time = $.trim($('#start_time').val());
        var end_time =  $.trim($('#end_time').val());
        if(start_time == '' ^ end_time == ''){
            layer.alert('请选择完整的时间间隔', {icon: 2});
            return false;
        }
        if(start_time !== '' && end_time !== ''){
            $('#create_time').val(start_time+" - "+end_time);
        }
        if(start_time == '' && end_time == ''){
            $('#create_time').val('');
        }
    }
    
    
    //批量操作提交
    function act_submit(atype) {
        var a = [];
        $('input[name*=selected]').each(function(i,o){
            if($(o).is(':checked')){
                a.push($(o).val());
            }
        })
        if(a.length == 0){
            layer.alert('少年，请至少选择一项', {icon: 2});return;
        }
        $('#atype').val(atype);
        $('#transfer-form').submit();
    }
    
    function form_submit(v){
    	$('#export').val(v);
    	$('#remittance-form').submit();
    }
</script>
</body>
</html>