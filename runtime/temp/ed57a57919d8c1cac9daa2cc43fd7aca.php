<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:42:"./application/seller/new/order\detail.html";i:1517208469;s:41:"./application/seller/new/public\head.html";i:1522050654;s:41:"./application/seller/new/public\left.html";i:1517208469;s:41:"./application/seller/new/public\foot.html";i:1517208469;}*/ ?>
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
table{
  border-collapse: inherit !important;
}
.ncsc-order-contnet thead td {
    background-color: #f5f5f5;
}
.ncsc-order-contnet tfoot td {
    padding: 10px 0;
}

.ncsc-order-contnet h3 {
    background-color: #f5f5f5;
    clear: both;
    color: #000;
    font-size: 14px;
    font-weight: 600;
    line-height: 22px;
    padding: 5px 0 5px 12px;
}
h3 {
    font-size: 18px;
}
.ncsc-order-contnet  td .sum em {
    color: #c00;
    font: 16px/24px Verdana,Arial;
    margin: 0 4px;
    vertical-align: bottom;
}
.ncsc-order-step dl.step-first{
  margin-left: 0;
}
.ncsc-order-contnet h3{
  display: inline-block;
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
    <div class="ncsc-path"><i class="icon-desktop"></i>商家管理中心<i class="icon-angle-right"></i>订单物流<i class="icon-angle-right"></i>订单详情</div>
    <div class="main-content" id="mainContent">
      
<div class="main-content" id="mainContent">
      
<div class="ncsc-oredr-show">
<div class="ncsc-order-info" >
	<div class="ncsc-order-condition">
	<?php if(isset($button['edit'])): ?>
      <a class="ncbtn ncbtn-grapefruit mt5"   href="<?php echo U('order/edit_order',array('order_id'=>$order['order_id'])); ?>" data-original-title="修改订单">修改订单</a>
   <?php endif; if(isset($button['split'])): ?>   
      <a class="ncbtn ncbtn-grapefruit mt5"   href="<?php echo U('order/split_order',array('order_id'=>$order['order_id'])); ?>"  ata-original-title="拆分订单">拆分订单</a>
   <?php endif; ?>
   <a class="ncbtn ncbtn-grapefruit mt5"   href="<?php echo U('Order/order_print',array('order_id'=>$order['order_id'])); ?>"  ata-original-title="打印订单"><i class="fa fa-print"></i>打印订单</a>
    
    </div>                  
</div>
  <div class="ncsc-order-info" style="margin-top:30px">
    <div class="ncsc-order-details">
      <div class="title">订单信息</div>
      <div class="content">
        <dl>
          <dt>收&nbsp;&nbsp;货&nbsp;&nbsp;人：</dt>
          <dd><?php echo $order['consignee']; ?>&nbsp; <?php echo $order['mobile']; ?>&nbsp; <?php echo $order['address2']; ?></dd>
        </dl>
                <dl>
          <dt>支付方式：</dt>
          <dd> <?php if($order[pay_status] == 1 and empty($order['pay_name'])): ?>
              在线支付
              <?php else: ?>
              <?php echo $order['pay_name']; endif; ?></dd>
        </dl>
           <dl>
          <dt>发&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;票：</dt>
          <dd><?php echo $order['invoice_title']; ?></dd>
        </dl>
        <dl>
          <dt>买家留言：</dt>
          <dd><?php echo $order['user_note']; ?></dd>
        </dl>
        <dl class="line">
          <dt>订单编号：</dt>
          <dd><?php echo $order['order_sn']; ?></dd>
        </dl>
        <dl >
          <dt>配送方式：</dt>
          <dd><?php echo $order['shipping_name']; ?></dd>
        </dl>
        <dl>
          <dt></dt>
          <dd></dd>
        </dl>
      </div>
    </div> 
    <div class="ncsc-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd><?php echo \think\Config::get('ORDER_STATUS')[$order[order_status]]; ?></dd>
      </dl>
      <ul>
        	<!--<li>该订单还未确认</li>-->
      </ul>
    </div>
    </div>
    
    <div id="order-step" class="ncsc-order-step">
    <!-- 订单未支付 -->
    <dl class="step-first current">
      <dt>提交订单</dt>
      <dd class="bg"></dd>
      <dd class="date" title="下单时间"><?php echo date('Y-m-d H:i:s',$order['add_time']); ?></dd>
    </dl>
    	<!-- 已经支付, 单还未发货 -->
        <dl  <?php if($show_status >= 2): ?> class="current" <?php endif; ?>>
	   <dt>支付订单</dt>
      <dd class="bg"> </dd>
      <dd class="date" title="付款时间"><?php echo date('Y-m-d H:i:s',$order['pay_time']); ?></dd>
    </dl> 
      <dl <?php if($show_status >= 3): ?>class="current"<?php endif; ?>>
      <dt>商家发货 </dt>
      <dd class="bg"> </dd>
      <dd class="date" title="发货时间"><?php echo date('Y-m-d H:i:s',$order['shipping_time']); ?></dd>
    </dl>
    <dl <?php if($show_status >= 4): ?>class="current"<?php endif; ?>>
      <dt>确认收货</dt>
      <dd class="bg"> </dd>
      <dd class="date" title="收货时间"><?php echo date('Y-m-d H:i:s',$order['confirm_time']); ?></dd>
    </dl>
    <dl <?php if($show_status == 5): ?>class="current"<?php endif; ?>>
      <dt>评价</dt>
      <dd class="bg"> </dd>
      <dd class="date" title="评价时间"><?php echo date('Y-m-d H:i:s',$comment_time); ?></dd>
    </dl>
  </div>
  <div class="ncsc-order-contnet">
	    <table class="ncsc-default-table order">
	      <thead>
	        <tr>
	          <th class="w10">&nbsp;</th>
	          <th colspan="2">商品</th>
	          <th class="w120">单价(元)</th>
	          <th class="w60">数量</th>
	          <th class="w100">规格属性</th>
	          <th class="w200">会员折扣价</th>
	        </tr>
	      </thead>
      		<tbody>
      		<?php if(is_array($orderGoods) || $orderGoods instanceof \think\Collection || $orderGoods instanceof \think\Paginator): $i = 0; $__LIST__ = $orderGoods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$good): $mod = ($i % 2 );++$i;?>
	         <tr class="bd-line">
	          <td>&nbsp;</td>
	          <td class="w50"><div class="pic-thumb">
	          	<a target="_blank" href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$good['goods_id'])); ?>"><img src="<?php echo goods_thum_images($good['goods_id'],200,200); ?>"></a></div>
	          </td>
	          <td class="tl">
          		<dl class="goods-name">
              		<dt><a target="_blank" href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$good['goods_id'])); ?>"><?php echo $good['goods_name']; ?></a></dt>
              	</dl>
	          </td>
	          <td><?php echo $good['goods_price']; ?><p class="green"></p></td>
	          <td><?php echo $good['goods_num']; ?></td>
	          <td><?php echo $good['spec_key_name']; ?></td>
	          <td><?php echo $good['member_goods_price']; ?></td>
	          </tr>
	        <?php endforeach; endif; else: echo "" ;endif; ?>
           </tbody>
      	<tfoot>
          <tr>
          <td colspan="20">
            <dl class="sum">
              <dt>小计：</dt>
              <dd><em><?php echo $order['goods_price']; ?></em>元</dd>
            </dl></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<!-- 费用信息 -->
 <div class="ncsc-order-contnet">
	    <table class="ncsc-default-table order">
	      <thead>
	        <tr>
	          <td colspan="20"><dl class="freight">
	          		<h3>费用信息</h3>
                    <?php if(isset($button['edit'])): ?>
	          		<span><a title="修改费用信息" class="ncbtn-mini" target="_blank" href="<?php echo U('Order/editprice',array('order_id'=>$order['order_id'])); ?>"><i class="icon-edit"></i>修改费用信息</a></span>
                    <?php endif; ?>
	          	</dl></td>
	        </tr>
	        <tr>
	          <th class="w100">小计</th>
	          <th class="w100">运费</th>
	          <th class="w100">积分(-0)</th>
	          <th class="w100">余额抵扣</th>
	          <th class="w200">优惠券抵扣</th>
	          <th class="w100">价格调整</th>
	          <th class="w100">应付</th>
	        </tr>
	      </thead>
      		<tbody>
	         <tr class="bd-line">
	          <td class="w100"><?php echo $order['goods_price']; ?></td>
	          <td class="w100">+<?php echo $order['shipping_price']; ?></td>
	          <td class="w100">-<?php echo $order['integral_money']; ?></td>
	          <td class="w100">-<?php echo $order['user_money']; ?></td>
	          <td class="w100">-<?php echo $order['coupon_price']; ?></td>
	          <td class="w100">减:<?php echo $order['order_prom_amount']; ?></td>
	       <!--   <td class="w100">减:<?php echo $order['discount']; ?></td>-->
	          <td class="w100">
	         	<dl class="sum"><em><?php echo $order['order_amount']; ?> </em>元
	            </dl>
	           </td>
	        </tr>
           </tbody>
    </table>
  </div>
  
  <!--操作信息-->
 <div class="ncsc-form-goods" style="margin-top:30px">
 		<h3 id="demo1">操作</h3>
	    <dl>
        	<dt>操作备注</dt>
	        <dd>
			<form id="order-action">
	          <textarea name="note" placeholder="请输入操作备注" class="textarea h60 w400 valid"></textarea>
			</form>
	          <span></span>
	          <p class="hint">备注字不能超过140个汉字</p>
	        </dd>
      	</dl>
      	<dl>
        	<dt>可执行操作</dt>
	        <dd> 
                    <!--上面显示过的按钮这里不再显示-->
                    <?php unset($button['edit']); unset($button['split']); if(is_array($button) || $button instanceof \think\Collection || $button instanceof \think\Paginator): if( count($button)==0 ) : echo "" ;else: foreach($button as $k=>$vo): if($k == 'pay_cancel'): ?>
	        			<a href="javascript:void(0)" class="ncbtn ncbtn-grapefruit mt5"   data-url="<?php echo U('Order/pay_cancel',array('order_id'=>$order['order_id'])); ?>" onclick="pay_cancel(this)"><?php echo $vo; ?></a>			
	        		<?php elseif($k == 'delivery'): ?> 
	        			<a class="ncbtn ncbtn-grapefruit mt5"   href="<?php echo U('Order/delivery_info',array('order_id'=>$order['order_id'])); ?>"><?php echo $vo; ?></a>
	        		<?php elseif($k == 'refund'): ?>
                        <!--退货商品列表-->
                        <!--<input class="btn btn-primary" type="button" onclick="selectGoods2(<?php echo $order['order_id']; ?>)" value="退货申请"> 	-->
	        		<?php elseif($k != 'delivery_confirm'): ?>
		        		<label class="submit-border">
	        				<input class="submit" nctype="formSubmit" type="button" onclick="ajax_submit_form('order-action','<?php echo U('Order/order_action',array('order_id'=>$order['order_id'],'type'=>$k)); ?>');"  value="<?php echo $vo; ?>"> 
	      				</label>
		          	 <?php endif; endforeach; endif; else: echo "" ;endif; ?>
	        </dd>
      	</dl>
  </div>
  
  <!-- 操作记录 -->
  <div class="ncsc-order-contnet">
	    <table class="ncsc-default-table order">
	      <thead>
	        <tr>
	          <td colspan="20"><dl class="freight"><h3>操作记录</h3></dl></td>
	        </tr>
	        <tr>
	          <th class="w100">操作者</th>
	          <th class="w160">操作时间</th>
	          <th class="w100">订单状态</th>
	          <th class="w100">付款状态</th>
	          <th class="w200">发货状态</th>
	          <th class="w80">描述</th>
	          <th class="w200">备注</th>
	        </tr>
	      </thead>
      		<tbody>
      		<?php if(is_array($action_log) || $action_log instanceof \think\Collection || $action_log instanceof \think\Paginator): $i = 0; $__LIST__ = $action_log;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$log): $mod = ($i % 2 );++$i;?>
	         <tr class="bd-line">
	          <td class="w100">
                  <?php if($log['action_user'] != 0): ?><?php echo $log[seller_name]; else: ?>用户<?php endif; ?>
              </td>
	          <td class="w160"><?php echo date('Y-m-d H:i:s',$log['log_time']); ?></td>
	          <td class="w100"><?php echo $order_status[$log[order_status]]; ?></td>
	          <td class="w100"><?php echo $pay_status[$log[pay_status]]; if($order['pay_code'] == 'code'): ?><span style="color: red">(货到付款)</span><?php endif; ?></td>
	          <td class="w100"><?php echo $shipping_status[$log[shipping_status]]; ?></td>
	          <td class="w80"><?php echo $log['status_desc']; ?></td>
	          <td class="w200"><?php echo $log['action_note']; ?></td>
	        </tr>
	        <?php endforeach; endif; else: echo "" ;endif; ?>
           </tbody>
    </table>
</div>

</div>
<script>
function pay_cancel(obj){
    var url =  $(obj).attr('data-url');
    layer.open({
        type: 2,
        title: '退款操作',
        shadeClose: true,
        shade: 0.8,
        area: ['45%', '50%'],
        content: url, 
    });
}
//取消付款
function pay_callback(s){
	if(s==1){
		layer.msg('操作成功', {icon: 1});
		layer.closeAll('iframe');
		location.href =	location.href;
	}else{
		layer.msg('操作失败', {icon: 3});
		layer.closeAll('iframe');
		location.href =	location.href;		
	}
}

// 弹出退换货商品
function selectGoods2(order_id){
	var url = "/index.php?m=Seller&c=Order&a=get_order_goods&order_id="+order_id;
	layer.open({
		type: 2,
		title: '选择商品',
		shadeClose: true,
		shade: 0.8,
		area: ['60%', '60%'],
		content: url, 
	});
}    
// 申请退换货
function call_back(order_id,goods_id)
{
	var url = "/index.php?m=Seller&c=Order&a=add_return_goods&order_id="+order_id+"&goods_id="+goods_id;	
	location.href = url;
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
