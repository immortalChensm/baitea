<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:49:"./template/mobile/mobile1/order\return_goods.html";i:1517208521;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\header_nav.html";i:1517208521;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>申请售后服务--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
<body class="g4">

<div class="classreturn">
    <div class="content">
        <div class="ds-in-bl return">
            <a href="javascript:history.back(-1);"><img src="__STATIC__/images/return.png" alt="返回"></a>
        </div>
        <div class="ds-in-bl search center">
            <span>申请售后服务</span>
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
		<div class="attention-shoppay applyafter">
			<div class="orderlistshpop tuharecha mabo20 p">
				<div class="maleri30">
					<div class="sc_list se_sclist paycloseto">
						<div class="shopimg fl">
							<img src="<?php echo goods_thum_images($goods['goods_id'],100,100); ?>">
						</div>
						<div class="deleshow fr">
							<div class="deletes">
								<a class="daaloe"><?php echo $goods['goods_name']; ?></a>
							</div>
							<div class="qxatten">
								<div class="weight">
									<p><span>价格：</span><span><em>￥</em><?php echo $goods['goods_price']; ?></span></p>
									<p><span>数量：</span><span>x<?php echo $goods['goods_num']; ?></span></p>
									<a class="closeannten" href="javascript:void(0)">联系卖家</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<form name="return_form" id="return_form" autocomplete="off" method="post" enctype="multipart/form-data">
		<div class="seravetype">
			<div class="maleri30">
				<p>服务类型</p>
				<div class="fuwxbo">
					<a href="javascript:void(0);" class="<?php if($return_goods[type] == 0): ?>red<?php endif; ?>" tvalue="0" onclick="$('#rtype').val(0)">仅退款</a>
					<a href="javascript:void(0);" class="<?php if($return_goods[type] == 1): ?>red<?php endif; ?>" tvalue="1" onclick="$('#rtype').val(1)">退货退款</a>
					<a href="javascript:void(0);" class="<?php if($return_goods[type] == 2): ?>red<?php endif; ?>" tvalue="2" onclick="$('#rtype').val(2)">换货</a>
					<a href="javascript:void(0);" class="<?php if($return_goods[type] == 3): ?>red<?php endif; ?>" tvalue="3" onclick="$('#rtype').val(3)">维修</a>
					<input type="hidden" name="type" value="<?php echo (isset($return_goods[type]) && ($return_goods[type] !== '')?$return_goods[type]:0); ?>" id="rtype">
					<input type="hidden" value="<?php echo $goods['goods_num']; ?>" id="buynum">
				</div>
			</div>
		</div>
		<div class="seravetype ma-to-20">
			<div class="maleri30">
				<p>申请数量</p>
				<div class="plus">
					<span class="mp_minous" onclick="altergoodsnum(-1)">-</span>
					<span class="mp_mp">
                        <input type="tel" name="goods_num" id="number" value="<?php echo $goods['goods_num']; ?>" min="<?php echo $goods['goods_num']; ?>" max="<?php echo $goods['goods_num']; ?>" onblur="altergoodsnum(0)">
                    </span>
					<span class="mp_plus" onclick="altergoodsnum(+1)">+</span>
				</div>
			</div>
		</div>
        <div class="seravetype ma-to-20 account">
            <div class="maleri30">
                <p>提交原因 <span class="ifhaeu" id="account">注意保持商品的完好，建议您先与卖家沟通</span></p>
            </div>
        </div>
		<div class="seravetype ma-to-20">
			<div class="maleri30">
				<p>货物状态</p>
				<div class="inspectrepot p">
					<div class="radio clr_unfinished">
						<span class="che <?php if($return_goods[is_receive] == 0): ?>check_t<?php endif; ?>" rel="0">
							<i></i>
							<span>未收到货</span>
						</span>
					</div>
					<div class="radio clr_achieve">
						<span class="che  <?php if($return_goods[is_receive] == 1): ?>check_t<?php endif; ?>" rel="1">
							<i></i>
							<span>已收到货</span>
						</span>
					</div>
					<input type="hidden" name="is_receive" id="is_receive" value="0">
				</div>
			</div>
		</div>
		<div class="customer-messa apply-afterserve ma-to-20">
			<div class="maleri30">
				<p><em class="red">*</em> 问题描述</p>
				<textarea class="tapassa" onkeyup="checkfilltextarea('.tapassa','500')" name="describe" id="describe" rows="" cols="" placeholder="请你在此描述详细问题"><?php echo $return_goods['describe']; ?></textarea>
				<span class="xianzd"><em id="zero">500</em>/500</span>
			</div>
		</div>
		<div class="seravetype ma-to-20">
			<div class="maleri30">
				<p>上传照片</p>
				<ul>
				<label>
                    <li class="file">
                        <div class="shcph" id="fileList0">
                            <img src="__STATIC__/images/scph.png">
                        </div>
                        <input  type="file" accept="image/*" name="return_imgs[]"  onchange="handleFiles(this,0)" style="display:none">
                    </li>
                </label>
                <label>
                    <li class="file">
                        <div class="shcph" id="fileList1">
                            <img src="__STATIC__/images/scph.png">
                        </div>
                        <input  type="file" accept="image/*" name="return_imgs[]"  onchange="handleFiles(this,1)" style="display:none">
                    </li>
                </label>
                <label>
                    <li class="file">
                        <div class="shcph" id="fileList2">
                            <img src="__STATIC__/images/scph.png">
                        </div>
                        <input  type="file" accept="image/*" name="return_imgs[]"  onchange="handleFiles(this,2)" style="display:none">
                    </li>
                </label>
                <label>
                    <li class="file">
                        <div class="shcph" id="fileList3">
                            <img src="__STATIC__/images/scph.png">
                        </div>
                        <input  type="file" accept="image/*" name="return_imgs[]"  onchange="handleFiles(this,3)" style="display:none">
                    </li>
                </label>
                <label>
                    <li class="file">
                        <div class="shcph" id="fileList4">
                            <img src="__STATIC__/images/scph.png">
                        </div>
                        <input  type="file" accept="image/*" name="return_imgs[]"  onchange="handleFiles(this,4)" style="display:none">
                    </li>
                </label>
				</ul>
				<p class="ifhaeu">为帮助我们更好的解决问题，请上传照片。最多5张，每张不超过5M，支持JPG、BMP、PNG</p>
			</div>
		</div>
		<div class="shprutba ma-to-20">
			<div class="maleri30">
				<p class="tutif">商品退回方式</p>
				<div class="kzthuic">
					<a class="kaid" href="javascript:void(0);">快递至第三方卖家</a>
				</div>
			</div>
		</div>
		<div class="intrudjs">
			<div class="maleri30">
				<p>商品返回地址将在服务审核通过后以短信形式告知，或在查看返修/退换货记录中查询，商城不收取快递附加费用</p>
			</div>
		</div>
		<div class="zblikbo p ma-to-20">
			<div class="qhsxix">
				<div class="myorder p">
					<div class="order">
						<div class="fl">
							<span>联系人：</span>
						</div>
						<div class="fl">
							<p class="addretu"><?php echo $order['consignee']; ?></p>
						</div>
					</div>
				</div>
				<div class="myorder p">
					<div class="order">
						<div class="fl">
							<span>联系电话：</span>
						</div>
						<div class="fl">
							<p class="addretu"><?php echo $order['mobile']; ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="zblikbo p" style="display:none;">
			<div class="qhsxix">
				<div class="myorder p">
					<div class="order">
						<div class="fl">
							<span>收货地址</span>
						</div>
						<div class="fl">
							<span class="li9">（该地址是商城回寄给您的地址）</span>
						</div>
					</div>
				</div>
				<div class="myorder p">
					<div class="order">
						<div class="fl">
							<span>所在地区：</span>
						</div>
						<div class="fl">
							<p class="addretu">广东省  深圳市  龙华新区</p>
						</div>
						<div class="fr">
							<i class="Mright"></i>
						</div>
					</div>
				</div>
				<div class="myorder cl-ordhi p">
					<div class="order">
						<div class="fl">
							<span>详细地址：</span>
						</div>
						<div class="fl">
							<textarea class="addretu2" name="" rows="" cols=""></textarea>
							<!--<p class="addretu2">广东深圳市龙华新区民治大道嘉熙业广场808室</p>-->
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="nextbutt">
            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>" />
            <input type="hidden" name="order_sn" value="<?php echo $order['order_sn']; ?>" />
            <input type="hidden" name="goods_id" value="<?php echo $goods['goods_id']; ?>" />
            <input type="hidden" name="spec_key" value="<?php echo $goods['spec_key']; ?>" />
            <input type="hidden" name="consignee" value="<?php echo $order['consignee']; ?>"/>
            <input type="hidden" name="mobile" value="<?php echo $order['mobile']; ?>" />
            <input type="hidden" name="id" value="<?php echo $return_goods['id']; ?>" />
            <input type="hidden" name="rec_id" value="<?php echo $goods['rec_id']; ?>" />
            <input type="hidden" name="reason" value="" />
			<a href="javascript:;" onclick="submit_form();">下一步</a>
		</div>
		</form>
<!--提交原因-s-->
<div class="losepay closeorder" style="display: ;">
    <div class="maleri30">
        <div class="l_top">
            <span>提交原因</span>
            <em class="turenoff" onclick="turenoff()"></em>
        </div>
        <div class="resonco">
            <div class="radio"><span class="che" data-val="订单不能按预计时间送达"><i></i><span>订单不能按预计时间送达</span></span></div>
            <div class="radio"><span class="che" data-val="操作有误（商品、地址等选错）"><i></i><span>操作有误（商品、地址等选错）</span></span></div>
            <div class="radio"><span class="che" data-val="重复下单/误下单"><i></i><span>重复下单/误下单</span></span></div>
            <div class="radio"><span class="che" data-val="其他渠道价格更低"><i></i><span>其他渠道价格更低</span></span></div>
            <div class="radio"><span class="che" data-val="该商品降价了"><i></i><span>该商品降价了</span></span></div>
            <div class="radio"><span class="che" data-val="不想买了"><i></i><span>不想买了</span></span></div>
        </div>
    </div>
</div>
<div class="mask-filter-div" style="display: none;"></div>
<!--提交原因-e-->
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    function turenoff(){
        $('.mask-filter-div').hide();
        $('.losepay').hide();
    }
	$(function(){
		//初始化 - 仅退款
		$('.clr_unfinished').show()
    	$('.clr_unfinished').find('span').addClass('check_t');
        $('.clr_achieve').hide();
        $('#is_receive').val(0);
        
		$('.fuwxbo a').click(function(){
            var  typeval= $(this).attr('tvalue');
            if(typeval == 0){
            	//仅退款
            	$('.clr_unfinished').show()
            	$('.clr_unfinished').find('span').addClass('check_t');
                $('.clr_achieve').hide();
                $('#is_receive').val(0);
            }else if(typeval == 1 || typeval == 3){
            	//退货退款/维修
                $('.clr_unfinished').hide()
                $('.clr_unfinished').find('span').removeClass('check_t');
                
                $('.clr_achieve').show();
                $('.clr_achieve').find('span').addClass('check_t');
                
                $('#is_receive').val(1);
            }else{
                $('.clr_unfinished').show()
                $('#is_receive').val(1);
            }
			$(this).toggleClass('red').siblings().removeClass('red');
		})

        $('.resonco span').click(function(){
            $('.resonco').find('.radio').find('.che').removeClass('check_t');
            $(this).addClass('check_t');
            //写入值
            var val = $(this).data('val');
            $('#account').text(val);
            $("input[name='reason']").val(val);
            //隐藏弹窗
            turenoff()
        })

        $(document).on('click','.account',function(){
            $('.mask-filter-div').show();
            $('.closeorder').show()
        })
		$('.inspectrepot .radio span').click(function(){
			$('.che').removeClass('check_t');
			$(this).addClass('check_t');
			$('#is_receive').val($(this).attr('rel'));
		})
	})
			
    //显示上传照片
    window.URL = window.URL || window.webkitURL;
    function handleFiles(obj,id) {
        fileList = document.getElementById("fileList"+id);
        var files = obj.files;
        img = new Image();
        if(window.URL){

            img.src = window.URL.createObjectURL(files[0]); //创建一个object URL，并不是你的本地路径
            img.width = 60;
            img.height = 60;
            img.onload = function(e) {
                window.URL.revokeObjectURL(this.src); //图片加载后，释放object URL
            }
            if(fileList.firstElementChild){
                fileList.removeChild(fileList.firstElementChild);
            }
            fileList.appendChild(img);
        }else if(window.FileReader){
            //opera不支持createObjectURL/revokeObjectURL方法。我们用FileReader对象来处理
            var reader = new FileReader();
            reader.readAsDataURL(files[0]);
            reader.onload = function(e){
                img.src = this.result;
                img.width = 60;
                img.height = 60;
                fileList.appendChild(img);
            }
        }else
        {
            //ie
            obj.select();
            obj.blur();
            var nfile = document.selection.createRange().text;
            document.selection.empty();
            img.src = nfile;
            img.width = 60;
            img.height = 60;
            img.onload=function(){

            }
            fileList.appendChild(img);
        }
    }

    function submit_form()
    {
        var describe = $.trim($('#describe').val());
         var reason= $.trim($("input[name='reason']").val());
        if(reason == '')
        {
            showErrorMsg('请选择提交原因');
            return false;
        }
        if(describe == '')
        {
        	showErrorMsg('请输入问题描述!');// alert('请输入退换货原因!');
            return false;
        }
        $('#return_form').submit();
    }
    /**
     * 提示弹窗
     * @param msg
     */
    function showErrorMsg(msg){
        layer.open({content:msg,time:2});
    }
</script>
	</body>
</html>
