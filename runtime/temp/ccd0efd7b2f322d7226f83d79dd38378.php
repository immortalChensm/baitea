<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:49:"./application/seller/new/service\refund_info.html";i:1517208469;s:41:"./application/seller/new/public\head.html";i:1522050654;s:41:"./application/seller/new/public\left.html";i:1517208469;s:41:"./application/seller/new/public\foot.html";i:1517208469;}*/ ?>
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
    <div class="ncsc-path">
    	<i class="icon-desktop"></i>商家管理中心
    	<i class="icon-angle-right"></i>售后服务
    	<i class="icon-angle-right"></i>退款记录
    </div>
    <div class="main-content" id="mainContent">
<div class="ncsc-flow-layout">
  <div class="ncsc-flow-container">
    <div class="title">
      <h3>售后服务处理</h3>
    </div>
    <?php if($return_goods['is_receive'] == 1): ?>
    <div id="saleRefundReturn">
      <div class="ncsc-flow-step">
        <dl class="step-first current">
          <dt>买家申请退货</dt>
          <dd class="bg"></dd>
        </dl>
        <dl class="<?php if(($return_goods[status] >= 1) OR ($return_goods[status] == -1)): ?>current<?php endif; ?>">
          <dt>商家处理退货申请</dt>
          <dd class="bg"> </dd>
        </dl>
        <dl class="<?php if($return_goods[status] >= 2): ?>current<?php endif; ?>">
          <dt>买家退货给商家</dt>
          <dd class="bg"> </dd>
        </dl>
        <dl class="<?php if($return_goods[status] >= 3): ?>current<?php endif; ?>">
          <dt>确认收货，平台审核</dt>
          <dd class="bg"> </dd>
        </dl>
      </div>
     </div>
     <?php else: ?>
      <div id="saleRefund">
      <div class="ncsc-flow-step">
        <dl class="step-first current">
          <dt>买家申请退款</dt>
          <dd class="bg"></dd>
        </dl>
        <dl class="<?php if(($return_goods[status] >= 1) OR ($return_goods[status] == -1)): ?>current<?php endif; ?>">
          <dt>商家处理退款申请</dt>
          <dd class="bg"> </dd>
        </dl>
        <dl class="<?php if($return_goods[status] == 5): ?>current<?php endif; ?>">
          <dt>平台审核，退款完成</dt>
          <dd class="bg"> </dd>
        </dl>
      </div>
      </div>
     <?php endif; ?>
    <form id="post_form" method="post" action="">
    <div class="ncsc-form-default">
      <h3>买家退款申请</h3>
      <dl>
        <dt>退款编号：</dt>
        <dd><?php echo $return_goods['id']; ?></dd>
      </dl>
      <dl>
        <dt>申请人（买家）：</dt>
        <dd><?php echo $user['nickname']; ?></dd>
      </dl>
      <dl>
        <dt>退款原因：</dt>
        <dd><?php echo $return_goods['reason']; ?></dd>
      </dl>
        <dl>
        <dt>退货数量：</dt>
        <dd><?php echo $return_goods['goods_num']; ?></dd>
      </dl>
      <dl>
        <dt>退款金额：</dt>
        <dd><strong class="red">&yen;</strong>
        	<input type="text" name="refund_money" value="<?php echo $return_goods['refund_money']; ?>">第三方支付部分原路退回
        </dd>
      </dl>
      <?php if($return_goods[refund_deposit] > 0): ?>
      <dl>
        <dt>退还预存款：</dt>
        <dd><strong class="red">&yen;</strong>
            <input type="text" name="refund_deposit" value="<?php echo $return_goods['refund_deposit']; ?>">余额支付部分退到用户余额
        </dd>
      </dl>
      <?php endif; if($return_goods[refund_integral] > 0): ?>
      <dl>
        <dt>退还积分：</dt>
        <dd><strong class="red">&yen;</strong>
            <input type="text" name="refund_integral" value="<?php echo $return_goods['refund_integral']; ?>">积分抵扣部分退还积分
        </dd>
      </dl>
      <?php endif; ?>
      <dl>
        <dt>退款说明：</dt>
        <dd><?php echo $return_goods['describe']; ?> </dd>
      </dl>
      <dl>
        <dt>凭证上传：</dt>
        <dd>
        	<ul class="ncsc-evidence-pic">
        	  <?php if(is_array($return_goods[imgs]) || $return_goods[imgs] instanceof \think\Collection || $return_goods[imgs] instanceof \think\Paginator): if( count($return_goods[imgs])==0 ) : echo "" ;else: foreach($return_goods[imgs] as $key=>$vo): ?>
              <li><a href="<?php echo $vo; ?>" nctype="nyroModal" rel="gal" target="_blank"><img class="show_image" src="<?php echo $vo; ?>"></a></li>
              <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </dd>
      </dl>
        <input type="hidden" name="id" value="<?php echo $return_goods['id']; ?>" />
        <h3>商家处理意见</h3>
        <dl>
          <dt><i class="required">*</i>是否同意：</dt>
          <dd>
          	<?php if($return_goods[status] == 0 or $return_goods[status] == 6): ?>
                <label class="mr20"><input type="radio" class="radio vm" name="status" value="1" checked/>同意</label>
                <label><input type="radio" class="radio vm" name="status" value="-1"/>拒绝</label>
                <span class="error"></span>
            <?php else: if($return_goods[status] >= 1): ?>同意<?php elseif($return_goods[status] == -2): ?>买家已取消<?php else: ?>不同意<?php endif; endif; ?>
          </dd>
        </dl>
        <dl>
          <dt><i class="required">*</i>备注信息：</dt>
          <dd>
           <?php if($return_goods[status] == 0): ?>
            <textarea name="remark" id="remark" rows="2" class="textarea w300"></textarea>
            <span class="error"></span>
            <p class="hint">只能提交一次，请认真选择。<br> 同意并经过平台确认后会将金额以预存款的形式返还给买家。<br>不同意时买家可以向平台投诉或申请仲裁。</p>
            <?php else: ?><?php echo $return_goods['remark']; endif; ?>
          </dd>
        </dl>
        <?php if($return_goods[checktime] > 0): ?>
        <dl>
        	<dt><i class="required">*</i>处理时间：</dt>
         	<dd><?php echo date('Y-m-d H:i:s',$return_goods['checktime']); ?></dd>
        </dl>
        <?php endif; if(($return_goods[is_receive] == 1) AND ($return_goods[delivery] != '')): ?>
        	<h3>用户发货信息</h3>
        	<dl><dt>快递公司：</dt><dd> <?php echo $return_goods[delivery][express_name]; ?></dd></dl>
        	<dl><dt>快递费用：</dt><dd> <?php echo $return_goods[delivery][express_fee]; ?> </dd></dl>
        	<dl><dt>快递单号：</dt><dd> <?php echo $return_goods[delivery][express_sn]; ?> </dd></dl>
        	<dl><dt>发货时间：</dt><dd> <?php echo $return_goods[delivery][express_time]; ?></dd></dl>
        <?php endif; if($return_goods[status] >= 3): ?>
        	<h3>商城平台退款审核</h3>
    	    <dl>
	          <dt><i class="required">*</i>平台确认：</dt>
	          <dd>
	          	<?php if($return_goods[status] < 5): ?>处理中<?php else: ?>退款完成<?php endif; ?>
	          </dd>
	        </dl>
	        <dl>
	          <dt><i class="required">*</i>平台备注：</dt>
	          <dd><?php echo $return_goods['refund_mark']; ?></dd>
	        </dl>
        <?php endif; ?>
        <div class="bottom">
          <?php if($return_goods[status] == 0): ?>
          <label class="submit-border">
            <a class="submit" id="confirm_button">确定</a>
          </label>
          <?php endif; if($return_goods[status] == 5): ?>
                <label class="submit-border">
                    <a class="submit" id="confirm_button">再次审核</a>
                </label>
            <?php endif; if($return_goods[status] == 2): ?>
                <label class="submit-border">
                    <a href="<?php echo U('Service/confirm_receive',array('id'=>$return_goods['id'])); ?>" class="submit">确定收货</a>
                </label>
          <?php endif; ?>
          <label class="submit-border">
            <a href="javascript:history.go(-1);" class="submit"><i class="icon-reply"></i>返回列表</a>
          </label>
        </div>
    </div></form>
  </div>

<div class="ncsc-flow-item">
  <div class="title">相关商品交易信息</div>
  <div class="item-goods">
      <dl>
        <dt>
          <div class="ncsc-goods-thumb-mini"><a target="_blank" href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$return_goods['goods_id'])); ?>">
            <img src="<?php echo goods_thum_images($return_goods['goods_id'],60,60); ?>"/></a></div>
        </dt>
        <dd><a target="_blank" href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$return_goods['goods_id'])); ?>"><?php echo $order_goods['goods_name']; ?></a>
            &yen;<?php echo $order_goods['member_goods_price']; ?> * <?php echo $order_goods['goods_num']; ?> <font color="#AAA">(数量)</font>
            <span></span>
        </dd>
      </dl>
  </div>
  <div class="item-order">
    <dl>
      <dt>运&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;费：</dt>
      <dd><?php echo (isset($order['shipping_price']) && ($order['shipping_price'] !== '')?$order['shipping_price']:'（免运费）'); ?></dd>
    </dl>
      <dl>
          <dt>购买单价：</dt>
          <dd><?php echo $order_goods['member_goods_price']; ?></dd>
      </dl>
    <dl>
      <dt>订单总额：</dt>
      <dd><strong>&yen;<?php echo $order['total_amount']; ?></strong> </dd>
    </dl>
    <dl class="line">
      <dt>订单编号：</dt>
      <dd><a target="_blank" href="<?php echo U('Order/detail',array('order_id'=>$order[order_id])); ?>"><?php echo $return_goods['order_sn']; ?></a>
      		<a href="javascript:void(0);" class="a">更多<i class="icon-angle-down"></i>
        <div class="more"> <span class="arrow"></span>
          <ul>
            <li>付款单号：<span><?php echo $order['transaction_id']; ?></span></li>
            <li>支付方式：<span><?php echo $order['pay_name']; ?></span></li>
            <li>下单时间：<span><?php echo date('Y-m-d H:i:s',$order['add_time']); ?></span></li>
            <li>付款时间：<span><?php if($order[pay_time] > 0): ?><?php echo date('Y-m-d H:i:s',$order['pay_time']); else: ?>待付款<?php endif; ?></span></li>
          </ul>
        </div>
        </a> </dd>
    </dl>
    <dl class="line">
      <dt>收&nbsp;&nbsp;货&nbsp;&nbsp;人：</dt>
      <dd><?php echo $order['consignee']; ?><a href="javascript:void(0);" class="a">更多<i class="icon-angle-down"></i>
        <div class="more"><span class="arrow"></span>
          <ul>
            <li>收货地址：<span><?php echo $order['address']; ?></span></li>
            <li>联系电话：<span><?php echo $order['mobile']; ?></span></li>
          </ul>
        </div>
        </a>
        <div><span member_id="<?php echo $order['user_id']; ?>"></span></div>
      </dd>
    </dl>
  </div>
</div></div>
<script type="text/javascript">
$(function(){
    $("#confirm_button").click(function(){
    	if($('#remark').val() == ''){
			layer.alert('请填写处理意见', {icon: 2});
			return false;
    	}
        $("#post_form").submit();
    });
});
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
