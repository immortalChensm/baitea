<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:51:"./template/mobile/mobile1/activity\coupon_list.html";i:1517208521;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\header_nav.html";i:1517208521;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>领券中心--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
    <link rel="stylesheet" href="__STATIC__/css/style.css">
<!--    <link rel='stylesheet' href="__STATIC__/css/base.css">
    <link rel='stylesheet' href="__STATIC__/css/mobile.css">-->
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/iconfont.css"/>
    <script src="__STATIC__/js/jquery-3.1.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__STATIC__/js/mobile-util.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/global.js"></script>
    <script src="__STATIC__/js/layer/layer.js" type="text/javascript" charset="utf-8"></script>
   <script src="__STATIC__/js/swipeSlide.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/mobile_common.js"></script>
    <style>
        body footer {
            height: 2rem;
        }
        body footer ul li .b-icon {
            width: .84rem;
            height: .84rem;
            margin: .2rem auto 0;
        }
        body footer ul li .b-wen {
            margin-top: .2rem; 
            font-size: .48rem;
        }
    </style>
</head>
<body class="[body]">

<div class="classreturn">
    <div class="content">
        <div class="ds-in-bl return">
            <a href="javascript:history.back(-1)"><img src="__STATIC__/images/return.png" alt="返回"></a>
        </div>
        <div class="ds-in-bl search center">
            <span>领券中心</span>
        </div>
        <div class="ds-in-bl menu">
            <a href="javascript:void(0);"><img src="__STATIC__/images/class1.png" alt="菜单"></a>
        </div>
    </div>
</div>
<div class="flool tpnavf">
    <div class="footer">
        <ul>
            <li>
                <a class="yello" href="<?php echo U('Index/index'); ?>">
                    <div class="icon">
                        <i class="icon-shouye iconfont"></i>
                        <p>首页</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('Goods/categoryList'); ?>">
                    <div class="icon">
                        <i class="icon-fenlei iconfont"></i>
                        <p>分类</p>
                    </div>
                </a>
            </li>
            <li>
                <!--<a href="shopcar.html">-->
                <a href="<?php echo U('Cart/index'); ?>">
                    <div class="icon">
                        <i class="icon-gouwuche iconfont"></i>
                        <p>购物车</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('User/index'); ?>">
                    <div class="icon">
                        <i class="icon-wode iconfont"></i>
                        <p>我的</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
		<nav class="storenav grst p">
			<ul>
				<li class="<?php if(\think\Request::instance()->param('atype') == 1 OR \think\Request::instance()->param('atype') == 0): ?>red<?php endif; ?>">
					<a href="<?php echo U('Activity/coupon_list',array('atype'=>1)); ?>"><span>默认 </span></a>
				</li>
				<li class="<?php if(\think\Request::instance()->param('atype') == 2): ?>red<?php endif; ?>">
					<a href="<?php echo U('Activity/coupon_list',array('atype'=>2)); ?>"><span>即将过期</span></a>
					<i></i>
				</li>
				<li class="<?php if(\think\Request::instance()->param('atype') == 3): ?>red<?php endif; ?>">
					<a href="<?php echo U('Activity/coupon_list',array('atype'=>3)); ?>"><span>面值最大</span></a>
					<i></i>
				</li>
			</ul>
		</nav>
		<div class="al_couponlist" id="coupon_list">
			<?php if(empty($coupon_list) || (($coupon_list instanceof \think\Collection || $coupon_list instanceof \think\Paginator ) && $coupon_list->isEmpty())): ?>
				<li style="text-align: center;">暂无可领取的优惠券<li>
			<?php endif; if(is_array($coupon_list) || $coupon_list instanceof \think\Collection || $coupon_list instanceof \think\Paginator): if( count($coupon_list)==0 ) : echo "" ;else: foreach($coupon_list as $key=>$vo): if($vo[isget] != 1): ?>
				<div class="maleri30">
					<div class="alcowlone p">
						<div class="goods-limit fl">
							<div class="goodsimgbo fl">
								<img src="<?php echo $store_arr[$vo[store_id]]['store_logo']; ?>"/>
							</div>
							<div class="goods-limit-fo fl">
								<p class="name">仅可购买<?php echo $store_arr[$vo[store_id]]['store_name']; ?>商品</p>
								<p class="condition"><em><?php echo intval($vo['money']); ?></em>满<?php echo intval($vo['condition']); ?>元可用</p>
							</div>
						</div>
						<div class="get-limit fr">
                            <canvas class="alreadyget" data-num="<?php if(!(empty($vo[createnum]) || (($vo[createnum] instanceof \think\Collection || $vo[createnum] instanceof \think\Paginator ) && $vo[createnum]->isEmpty()))): ?><?php echo round($vo[send_num]/$vo[createnum]*100,2); else: ?>0<?php endif; ?>"  width="100"  height="100"></canvas>
							<a class="clickgetcoupon" data-coupon-id="<?php echo $vo['id']; ?>" onclick="getCoupon(this)">点击领取</a>
						</div>
					</div>
				</div>
				<?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</div>
<script type="text/javascript" src="__STATIC__/js/sourch_submit.js"></script>
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
			$('.slide_list_row a').click(function(){
				$(this).addClass('bobo2').siblings().removeClass('bobo2');
			})
			window.onload = function(){
				var int = setInterval(dod,10);	
				var a = 135;
				var t = 0;
				var c = 0;
				var atr = [];
				
				//获取data-num的最大值
				function maxDataNum(){
					for(var i = 0;i<$('.alreadyget').length;i++){
						var d = $('.alreadyget').eq(i).attr("data-num");
						atr.push(d);
					}
					var max_data_num = Math.max.apply(null, atr)
					return max_data_num
				}
				function dod(){
					for(var i = 0;i<$('.alreadyget').length;i++){
						var et = document.getElementsByClassName('alreadyget')[i];
						var dn = et.getAttribute("data-num");
						var cc = et.getContext("2d");
						cc.lineWidth = 7;
						cc.lineCap = 'round';
						cc.clearRect(0,0,et.width,et.height);
						
						//外圆
						cc.beginPath();
						cc.strokeStyle = '#48b3b5';
						cc.arc(50,50,45,Math.PI*135/180,Math.PI*405/180,false);
						cc.stroke();
						cc.closePath();
						
						//内圆
						cc.beginPath();
						var radian = dn/(100/3) * 90 + 135;
						cc.strokeStyle= '#ffffff';
						if (t >=radian) {
							cc.arc(50,50,45,Math.PI*135/180,Math.PI * radian/180,false);
							cc.stroke();
							if(maxDataNum() == dn){
								clearInterval(int);	
							}
						} else{
							t = a++;
							cc.arc(50,50,45,Math.PI*135/180,Math.PI * t/180,false);
							cc.stroke();
						}
						cc.closePath();
						
						//文本
						cc.beginPath();
						cc.font = '24px 黑体,Helvetica,PingFangSC-Regular,Droid Sans,Arial,sans-serif';
						cc.fillStyle = '#ffffff';
						cc.textBaseline = 'middle';
						cc.textAlign = 'center';
						cc.fillText('已抢', 50, 40);
						if(c>dn){
							cc.fillText(dn+'%', 50, 70);
						}else{
							c++;
							cc.fillText(c+'%', 50, 70);
						}
						cc.closePath();
					}
				}
			}
			function getCoupon(obj){
				$.ajax({
					type: "POST",
					url: "<?php echo U('Mobile/Activity/getCoupon'); ?>",
					data: {coupon_id: $(obj).data('coupon-id')},
					dataType: "json",
					error: function () {
						layer.alert("服务器繁忙, 请联系管理员!");
					},
					success: function (data) {
						if (data.status == 1) {
							layer.open({content: data.msg,skin: 'msg',time: 2});
							$(obj).parent().parent().parent().remove();
						} else {
							layer.open({content: data.msg,skin: 'msg',time: 2});
						}
					}
				});
			}
			/**
			 * 加载更多商品
			 **/
			var  page = 1;
			function ajax_sourch_submit()
			{
				++page;
				$.ajax({
					type : "post",
					url:"/index.php?m=Mobile&c=Activity&a=coupon_list&p="+page,
					success: function(data) {
						if ($.trim(data) == '') {
							$('#getmore').hide();
						} else {
							$("#coupon_list").append(data);
						}
					}
				});
			}
		</script>
	</body>
</html>
