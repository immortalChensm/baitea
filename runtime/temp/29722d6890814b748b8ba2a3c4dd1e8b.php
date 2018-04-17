<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:44:"./template/mobile/mobile1/user\userinfo.html";i:1517208525;s:44:"./template/mobile/mobile1/public\header.html";i:1517208521;s:48:"./template/mobile/mobile1/public\header_nav.html";i:1517208521;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>设置--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
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
            <a href="<?php echo U('User/index'); ?>"><img src="__STATIC__/images/return.png" alt="返回"></a>
        </div>
        <div class="ds-in-bl search center">
            <span>设置</span>
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
		<div class="floor my p setting">
			<div class="content">
				<div class="floor list7">
					<div class="myorder he p">
						<div class="content30">
							<div class="order">
								<div class="fl">
									<span>头像</span>
									<span class="bridh"></span>
								</div>
								<div class="fr">
									<!--<a href="">-->
										<div class="hendicon">
											<span></span>
											<form id="head_pic" method="post" enctype="multipart/form-data">
											<label class="file" style="cursor:pointer;">
											<div class="around" id="fileList">
												<img src="<?php echo (isset($user['head_pic']) && ($user['head_pic'] !== '')?$user['head_pic']:'__STATIC__/images/user68.jpg'); ?>"/>
												<input type="file" accept="image/*" name="head_pic" value="<?php echo (isset($user['head_pic']) && ($user['head_pic'] !== '')?$user['head_pic']:'__STATIC__/images/user68.jpg'); ?>"  onchange="handleFiles(this)" style="display:none">
											</div></label>
											</form>
										</div>
									<!--</a>-->
								</div>
							</div>
						</div>
					</div>
					<div class="myorder p">
						<div class="content30">
							<a href="<?php echo U('Mobile/User/userinfo',array('action'=>'nickname')); ?>">
								<div class="order">
									<div class="fl">
										<span>用户名</span>
									</div>
									<div class="fr">
                                        <span><?php echo $user['nickname']; ?></span>
										<i class="Mright"></i>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="myorder p">
						<div class="content30">
							<a href="<?php echo U('Mobile/User/userinfo',array('action'=>'sex')); ?>">
								<div class="order">
									<div class="fl">
										<span>性别</span>
									</div>
									<div class="fr">
                                        <span><?php echo $sex[$user['sex']]; ?></span>
										<i class="Mright"></i>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="myorder p">
						<div class="content30">
							<a href="<?php echo U('Mobile/User/setMobile'); ?>">
								<div class="order">
									<div class="fl">
										<span>手机</span>
									</div>
									<div class="fr">
                                        <span><?php echo $user['mobile']; ?></span>
										<i class="Mright"></i>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="myorder p bo">
						<div class="content30">
							<a href="<?php echo U('Mobile/User/userinfo',array('action'=>'email')); ?>">
								<div class="order">
									<div class="fl">
										<span>邮箱</span>
									</div>
									<div class="fr">
                                        <span><?php echo $user['email']; ?></span>
										<i class="Mright"></i>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="myorder p ma-to-20">
						<div class="content30">
							<a href="<?php echo U('Mobile/User/password'); ?>">
								<div class="order">
									<div class="fl">
										<span>修改密码</span>
									</div>
									<div class="fr">
										<i class="Mright"></i>
									</div>
								</div>
							</a>
						</div>
					</div>
                    <div class="myorder p">
                        <div class="content30">
                            <a href="<?php echo U('Mobile/User/paypwd'); ?>">
                                <div class="order">
                                    <div class="fl">
                                        <span>支付密码</span>
                                    </div>
                                    <div class="fr">
                                        <i class="Mright"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
					<div class="myorder p">
						<div class="content30">
							<a href="<?php echo U('Mobile/User/address_list'); ?>">
								<div class="order">
									<div class="fl">
										<span>收货地址</span>
									</div>
									<div class="fr">
										<i class="Mright"></i>
									</div>
								</div>
							</a>
						</div>
					</div>
					<!--<div class="myorder p bo">
						<div class="content30">
							<a href="<?php echo U('Mobile/User/authinfo'); ?>">
								<div class="order">
									<div class="fl">
										<span>实名认证</span>
									</div>
									<div class="fr">
										<i class="Mright"></i>
									</div>
								</div>
							</a>
						</div>
					&lt;!&ndash;</div>&ndash;&gt;
				</div>-->
			</div>
			<div class="close">
				<a href="<?php echo U('User/logout'); ?>" id="logout">安全退出</a>
				<a id="asubmit" style="display:none;" href="javascript:;" onclick="javascript:$('#head_pic').submit();">保存头像</a>
			</div>
		</div>
      </div>
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
<script>
//显示上传照片
window.URL = window.URL || window.webkitURL;
function handleFiles(obj) {
    fileList = document.getElementById("fileList");
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
        $('#fileList').find('img').remove();
        fileList.appendChild(img);
    }else if(window.FileReader){
        //opera不支持createObjectURL/revokeObjectURL方法。我们用FileReader对象来处理
        var reader = new FileReader();
        reader.readAsDataURL(files[0]);
        reader.onload = function(e){
            img.src = this.result;
            img.width = 60;
            img.height = 60;
            $('#fileList').find('img').remove();
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
        $('#fileList').find('img').remove();
        fileList.appendChild(img);
    }
    $('#asubmit').show();
    $('#logout').hide();
    $('#head_pic').submit();
}

</script>      
	</body>
</html>
