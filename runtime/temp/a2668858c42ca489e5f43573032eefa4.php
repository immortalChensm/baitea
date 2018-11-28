<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:42:"./application/seller/new/goods\_goods.html";i:1525916573;s:41:"./application/seller/new/public\head.html";i:1528699444;s:41:"./application/seller/new/public\left.html";i:1517208469;s:41:"./application/seller/new/public\foot.html";i:1525943636;}*/ ?>
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
<script type="text/javascript" src="__ROOT__/public/static/js/layer/laydate/laydate_new.js"></script>
<script type="text/javascript" src="__ROOT__/public/static/js/layer/laydate/laydate_hoursmin.js"></script>
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
<!--以下是在线编辑器 代码 -->
<style>
    .ncsc-goods-default-pic .goodspic-uplaod .upload-thumb{width: 180px;height:180px; display: inline-block;}
    .ncsc-goods-default-pic .goodspic-uplaod .upload-thumb img{ height: 160px; width: 160px;}
    .ncsc-goods-default-pic .goodspic-uplaod .upload-thumb{line-height: 20px;margin-right: 6px;}
    .ncsc-goods-default-pic .goodspic-uplaod .upload-thumb:nth-child(5n){margin-right: 0;}
    .ncsc-goods-default-pic{display: inherit;}
    /*.ncsc-form-goods dl dd{width: 98%;}*/
    .text-warning {color: #8a6d3b;}a{ color:#3BAEDA}
    /*.ncsc-form-goods{padding: 10px;}*/
    .table-bordered {border: 1px solid #f4f4f4;}
    .table { width: 100%;max-width: 100%;margin-bottom: 20px;}
    ul.group-list {width: 96%;min-width: 1000px; margin: auto 5px;list-style: disc outside none;}
    ul.group-list li { white-space: nowrap;float: left; width: 150px; height: 25px;padding: 3px 5px;list-style-type: none;list-style-position: outside;border: 0px;margin: 0px;}
    .row .table-bordered td .btn,.row .table-bordered td img{vertical-align: middle;}
    .row .table-bordered td{padding: 8px;line-height: 1.42857143;}
    .table-bordered{width: 100%}
    .table-bordered tr td{border: 1px solid #f4f4f4;}
    .btn-success {color: #fff;background-color: #48CFAE;border-color: #398439 solid 1px;}
    .btn {display: inline-block;padding: 6px 12px;margin-bottom: 0;font-size: 14px;
        font-weight: 400;line-height: 1.42857143;text-align: center;white-space: nowrap; vertical-align: middle;
        -ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;
        -ms-user-select: none;user-select: none;background-image: none;border: 1px solid transparent; border-radius: 4px;
    }
    .col-xs-8 {width: 66.66666667%;}
    .col-xs-4 {width: 33.33333333%;}
    .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {float: left;}
    .row .tab-pane h4{padding: 10px 0;}
    .row .tab-pane h4 input{vertical-align: middle;}
    .table-striped>tbody>tr:nth-of-type(odd) {background-color: #f9f9f9;}
    .ncap-form-default .title{border-bottom: 0}
    .ncap-form-default dl.row, .ncap-form-all dd.opt/*border-color: #F0F0F0;*/border: none;
    .ncap-form-default dl.row:hover, .ncap-form-all dd.opt:hover{border: none;box-shadow: inherit;}
    a:hover {color: #3BAEDA;text-decoration: none;}
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        padding: 8px;line-height: 1.42857143;vertical-align: top; border-top: 1px solid #ddd;}
    ul.group-list{min-width: 100%;}
    input{vertical-align:middle;}
    .ncsc-form-goods h4{margin: 10px 0 10px 10px;}
    .clabackkj{background-color: #F5F5F5;border-bottom: solid 1px #E7E7E7;overflow: hidden;}
    .clabackkj h3{border-bottom: 0;display: inline-block;}
    .clabackkj .ncbtn{float: right;margin-right: 15px;height: 12px;line-height: 12px;}
    #tab_goods_images dl dd{width: 99%;}
    .alert-block{margin-top: 0;}
    select{
		min-width:120px;
    }
</style>
<script type="text/javascript" charset="utf-8" src="__ROOT__/public/plugins/Ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="__ROOT__/public/plugins/Ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="__ROOT__/public/plugins/Ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
var url="<?php echo url('Uploadify/index',array('savepath'=>'goods')); ?>";
var ue = UE.getEditor('goods_content',{
    serverUrl :url,
    zIndex: 999,
    initialFrameWidth: "100%", //初化宽度
    initialFrameHeight: 300, //初化高度            
    focus: false, //初始化时，是否让编辑器获得焦点true或false
    maximumWords: 99999, removeFormatAttributes: 'class,style,lang,width,height,align,hspace,valign',//允许的最大字符数 'fullscreen',
    pasteplain:false, //是否默认为纯文本粘贴。false为不使用纯文本粘贴，true为使用纯文本粘贴
    autoHeightEnabled: true
});
</script>
<!--以上是在线编辑器 代码  end-->
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
        <div class="ncsc-path"><i class="icon-desktop"></i>商家管理中心<i class="icon-angle-right"></i>商品<i class="icon-angle-right"></i>商品发布</div>
        <div class="main-content" id="mainContent">
            <div class="tabmenu-fixed-wrap">
                <div class="tabmenu">
                    <ul class="tab pngFix">
                        <li class="active"><a onclick="select_nav(this);" data-id="tab_tongyong">通用信息</a></li>
                        <li class="normal"><a onclick="select_nav(this);" data-id="tab_goods_images">商品相册</a></li>
                        <!-- 
                        <li class="normal"><a onclick="select_nav(this);" data-id="tab_goods_spec">商品规格</a></li>
                        <li class="normal"><a onclick="select_nav(this);" data-id="tab_goods_attr">商品属性</a></li>
 						
                         <li class="normal goods_shipping"><a onclick="select_nav(this);" data-id="tab_goods_shipping">商品物流</a></li>
                         -->
                    </ul>
                </div>
            </div>
            <div class="item-publish">
                <form method="post" id="addEditGoodsForm" >
                    <input type="hidden" name="goods_id" value="<?php echo $goodsInfo['goods_id']; ?>">
                    <input type="hidden" name="cat_id1" value="<?php echo $goods_cat[2][id]; ?>">
                    <input type="hidden" name="cat_id2" value="<?php echo $goods_cat[1][id]; ?>">
                    <input type="hidden" name="cat_id3" value="<?php echo $goods_cat[0][id]; ?>">
                    <div class="ncsc-form-goods active" id="tab_tongyong">
                        <h3 id="demo1">商品基本信息</h3>
                        <dl>
                            <dt>商品分类：</dt>
                            <dd id="gcategory"> <?php echo $goods_cat[2][name]; ?> &gt;<?php echo $goods_cat[1][name]; ?> &gt;<?php echo $goods_cat[0][name]; if(empty($goodsInfo['goods_id']) || (($goodsInfo['goods_id'] instanceof \think\Collection || $goodsInfo['goods_id'] instanceof \think\Paginator ) && $goodsInfo['goods_id']->isEmpty())): ?>
                                    <a class="ncbtn" href="<?php echo U('Seller/Goods/addStepOne'); ?>">编辑</a>
                                <?php endif; ?>
                                <input id="cate_id" name="cate_id" value="156" class="text" type="hidden">
                                <input name="cate_name" value="<?php echo $goods_cat[2][name]; ?> ><?php echo $goods_cat[1][name]; ?> ><?php echo $goods_cat[0][name]; ?>" class="text" type="hidden">
                            </dd>
                        </dl>
                        <dl>
                            <dt><i class="required">*</i>商品名称：</dt>
                            <dd>
                                <input type="text" value="<?php echo $goodsInfo['goods_name']; ?>" name="goods_name"  class="text w400">
                                <span id="err_goods_name"></span>
                                <p class="hint">商品标题名称长度至少3个字符，最长50个汉字</p>
                            </dd>
                        </dl>
                        <dl>
                            <dt>商品简介：</dt>
                            <dd>
                                <textarea name="goods_remark" class="textarea h60 w400"><?php echo $goodsInfo['goods_remark']; ?></textarea>
                                <span id="err_goods_remark"></span>
                                <p class="hint">商品简介最长不能超过140个汉字</p>
                            </dd>
                        </dl>
                        <dl>
                            <dt>商品货号：</dt>
                            <dd>
                                <p>
                                    <input type="text" value="<?php echo $goodsInfo['goods_sn']; ?>" name="goods_sn" class="text" maxlength="20">
                                </p>
                                <span id="err_goods_sn"></span>
                                <p class="hint">商家货号是指商家管理商品的编号<br>最多可输入20个字符，支持输入中文、字母、数字、_、/、-和小数点</p>
                            </dd>
                        </dl>
                        <!-- 
                        <dl>
                            <dt>SPU：</dt>
                            <dd>
                                <p>
                                    <input type="text" value="<?php echo $goodsInfo['spu']; ?>" name="spu" class="text">
                                </p>
                                <p class="hint">可不填</p>
                            </dd>
                        </dl>
                        <dl>
                            <dt>SKU：</dt>
                            <dd>
                                <p>
                                    <input type="text" value="<?php echo $goodsInfo['sku']; ?>" name="sku" class="text">
                                </p>
                                <p class="hint">可不填</p>
                            </dd>
                        </dl>
                        <dl>
                            <dt>本店分类：</dt>
                            <dd>
                                <select name="store_cat_id1" id="store_cat_id1" onchange="get_store_category(this.value,'store_cat_id2','0');">
                                    <option value="0">请选择分类</option>
                                    <?php if(is_array($store_goods_class_list) || $store_goods_class_list instanceof \think\Collection || $store_goods_class_list instanceof \think\Paginator): if( count($store_goods_class_list)==0 ) : echo "" ;else: foreach($store_goods_class_list as $k=>$v): ?>
                                        <option value="<?php echo $v['cat_id']; ?>" <?php if($v['cat_id'] == $goodsInfo['store_cat_id1']): ?>selected="selected"<?php endif; ?> >
                                        <?php echo $v['cat_name']; ?>
                                        </option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                                <select name="store_cat_id2" id="store_cat_id2">
                                    <option value="0">请选择分类</option>
                                </select>
                                <span id="err_cat_id" style="color:#F00; display:none;"></span>
                                <p class="hint">可不选,为了用户更好检索到该商品，最好选择</p>
                            </dd>
                        </dl>
                        <dl>
                            <dt>商品品牌：</dt>
                            <dd>
                                <select name="brand_id" id="brand_id">
                                    <option value="0">选择品牌</option>
                                    <?php if(is_array($brandList) || $brandList instanceof \think\Collection || $brandList instanceof \think\Paginator): if( count($brandList)==0 ) : echo "" ;else: foreach($brandList as $k=>$v): if($v['status'] == 0): ?>
                                            <option value="<?php echo $v['id']; ?>"  data-cat_id1="<?php echo $v['cat_id1']; ?>" <?php if($v['id'] == $goodsInfo['brand_id']): ?>selected="selected"<?php endif; ?>>
                                            <?php echo $v['name']; ?>
                                            </option>
                                        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                                <p class="hint">可不选,为了用户更好检索到该商品，最好选择</p>
                            </dd>
                        </dl>
                        <dl>
                            <dt>供应商：</dt>
                            <dd>
                                <select name="suppliers_id" id="suppliers_id">
                                    <option value="0">不指定供应商属于本店商品</option>
                                    <?php if(is_array($suppliersList) || $suppliersList instanceof \think\Collection || $suppliersList instanceof \think\Paginator): if( count($suppliersList)==0 ) : echo "" ;else: foreach($suppliersList as $k=>$v): ?>
                                        <option value="<?php echo $v['suppliers_id']; ?>"  <?php if($v['suppliers_id'] == $goodsInfo['suppliers_id']): ?>selected="selected"<?php endif; ?>>
                                        <?php echo $v['suppliers_name']; ?>
                                        </option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                                <p class="hint">可不选,为了用户更好检索到该商品，最好选择</p>
                            </dd>
                        </dl>
                         -->
                        <dl>
                            <dt><i class="required">*</i>本店售价：</dt>
                            <dd>
                                <input name="shop_price" id="shop_price" value="<?php echo $goodsInfo['shop_price']; ?>" class="text w60" type="text" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')"><em class="add-on"><i class="icon-renminbi"></i></em> <span></span>
                                <p class="hint">价格必须是0.01~9999999之间的数字。<br>
                                    此价格为商品实际销售价格。该价格影响到积分赠送</p>
                            </dd>
                        </dl>
                        <dl>
                            <dt><i class="required">*</i>市场价：</dt>
                            <dd>
                                <input name="market_price" value="<?php echo $goodsInfo['market_price']; ?>" class="text w60" type="text" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')"><em class="add-on"><i class="icon-renminbi"></i></em> <span></span>

                                <p class="hint">价格必须是0.01~9999999之间的数字，此价格仅为市场参考售价，请根据该实际情况认真填写。</p>
                            </dd>
                        </dl>
                        <dl>
                            <dt>成本价：</dt>
                            <dd>
                                <input value="<?php echo $goodsInfo['cost_price']; ?>" name="cost_price" class="text w60" type="text" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')"><em class="add-on"><i class="icon-renminbi"></i></em> <span></span>

                                <p class="hint">价格必须是0.00~9999999之间的数字，此价格为商户对所销售的商品实际成本价格进行备注记录，非必填选项，不会在前台销售页面中显示。</p>
                            </dd>
                        </dl>
                        <!--
                        <dl>
                            <dt>分销金：</dt>
                            <dd>
                                <input value="<?php echo $goodsInfo['distribut']; ?>" name="distribut" class="text w60" type="text" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')"><em class="add-on"><i class="icon-renminbi"></i></em> <span></span>

                                <p class="hint">价格必须是0.00~9999999之间的数字，此价格用于前台会员帮助商家（本店）分销产品，返佣给分销会员的金额。</p>
                            </dd>
                        </dl>
                          -->
                        <dl>
                            <dt><i class="required">*</i>商品图片：</dt>
                            <dd>
                                <div class="ncsc-goods-default-pic">
                                    <div class="goodspic-uplaod">
                                        <div class="upload-thumb">
                                            <img id="original_img2" src="<?php echo (isset($goodsInfo['original_img']) && ($goodsInfo['original_img'] !== '')?$goodsInfo['original_img']:'/public/images/default_goods_image_240.gif'); ?>">
                                        </div>
                                        <input name="original_img" id="original_img" value="<?php echo $goodsInfo['original_img']; ?>" type="hidden">
                                        <p class="hint">上传商品默认主图，如多规格值时将默认使用该图或分规格上传各规格主图；支持jpg、gif、png格式上传或从图片空间中选择，建议使用<font color="red">尺寸800x800像素以上、大小不超过1M的正方形图片</font>，上传后的图片将会自动保存在图片空间的默认分类中。</p>
                                        <div class="handle">
                                            <div class="ncsc-upload-btn">
                                                <a onclick="GetUploadify3(1,'','goods','call_back');">
                                                    <p><i class="icon-upload-alt"></i>图片上传</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="demo"></div>
                            </dd>
                        </dl>
                        <?php if($goodsInfo['is_virtual'] != 1): ?>
                            <dl class="goods_shipping">
                                <dt>商品重量：</dt>
                                <dd>
                                    <p>
                                        <input type="text"  value="<?php echo $goodsInfo['weight']; ?>" name="weight" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" class="text">
                                    </p>
                                    <p class="hint">克 (以克为单位)</p>
                                </dd>
                            </dl>
                            <dl class="goods_shipping">
                                <dt>是否包邮：</dt>
                                <dd>
                                    <ul class="ncsc-form-radio-list">
                                        <li>
                                            <label>
                                                <input type="radio" <?php if($goodsInfo[is_free_shipping] == 1): ?>checked="checked"<?php endif; ?> value="1" name="is_free_shipping">
                                                是</label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="radio" <?php if($goodsInfo[is_free_shipping] == 0): ?>checked="checked"<?php endif; ?> value="0" name="is_free_shipping">
                                                否</label>
                                        </li>
                                    </ul>
                                    <p class="hint"></p>
                                </dd>
                            </dl>
                        <?php endif; ?>
                        <dl>
                            <dt nc_type="no_spec"><i class="required">*</i>总库存：</dt>
                            <dd nc_type="no_spec">
                                <?php if($goodsInfo[goods_id] > 0): ?>
                                    <input name="store_count" value="<?php echo $goodsInfo['store_count']; ?>" onkeyup="this.value=this.value.replace(/\D/g,'')" onpaste="this.value=this.value.replace(/\D/g,'')" class="text w60" type="text">
                                <?php else: ?>
                                    <input name="store_count" value="<?php echo $tpshop_config[basic_default_storage]; ?>" onkeyup="this.value=this.value.replace(/\D/g,'')" onpaste="this.value=this.value.replace(/\D/g,'')" class="text w60" type="text">
                                <?php endif; ?>
                                    <span></span>
                                <p class="hint">商铺库存数量必须为0~999999999之间的整数<br>若启用了库存默认配置，则系统自动计算商品的总数，此处无需卖家填写</p>
                            </dd>
                        </dl>
                        <!-- 
                        <dl>
                            <dt>赠送积分：</dt>
                            <dd>
                                <p>
                                    <input type="text" value="<?php echo $goodsInfo['give_integral']; ?>" name="give_integral" id="give_integral" onkeyup="this.value=this.value.replace(/\D/g,'')" onpaste="this.value=this.value.replace(/\D/g,'')" class="text">
                                    <p class="hint" id="give_integral_hint">赠送积分不能超过100</p>
                                </p>
                                <p class="hint">购买商品赠送用户积分，积分比例1元:<?php echo $tpshop_config[shopping_point_rate]; ?>分</p>
                            </dd>
                        </dl>
                        <dl>
                            <dt>兑换积分：</dt>
                            <dd>
                                <p>
                                    <input type="text" value="<?php echo $goodsInfo['exchange_integral']; ?>" name="exchange_integral" onkeyup="this.value=this.value.replace(/\D/g,'')" onpaste="this.value=this.value.replace(/\D/g,'')" class="text">
                                </p>
                                <p class="hint">兑换该商品可使用多少积分，积分比例1元:<?php echo $tpshop_config[shopping_point_rate]; ?>分,虚拟商品填写此项无效</p>
                            </dd>
                        </dl>
                         -->
                        <dl>
                            <dt>商品关键词：</dt>
                            <dd>
                                <p>
                                    <input type="text" value="<?php echo $goodsInfo['keywords']; ?>" name="keywords" class="text">
                                </p>
                                <p class="hint">多个关键词，用空格隔开</p>
                            </dd>
                        </dl>
                        
                         <dl>
                            <dt>商品产地：</dt>
                            <dd>
                                <textarea name="product_area" class="textarea h60 w400"><?php echo $goodsInfo['product_area']; ?></textarea>
                                <span id="err_product_area"></span>
                                <p class="hint">商品产地</p>
                            </dd>
                        </dl>
                        
                        <!-- 
                            <?php if(($_GET[goods_id] == 0) OR ($goodsInfo[is_virtual] == 1)): ?>
                        <h3 id="demo3">特殊商品</h3>
                        <dl class="special-01">
					        <dt>虚拟商品：</dt>
					        <dd>
					          <ul class="ncsc-form-radio-list">
					            <li>
					               <input type="radio" name="is_virtual" value="1" id="is_virtual_1" <?php if($goodsInfo[is_virtual] == 1): ?>disabled  checked<?php endif; ?>><label for="is_virtual_1">是</label>
					            </li>
					            <li>
					               <input type="radio" name="is_virtual" value="0" id="is_virtual_0" <?php if($goodsInfo[is_virtual] == 1): ?>disabled<?php else: ?>checked<?php endif; ?>><label for="is_virtual_0">否</label>
					            </li>
					          </ul>
					          <p class="hint vital">*虚拟商品不能参加限时折扣和组合销售两种促销活动。也不能赠送赠品和推荐搭配。</p>
					          <p class="hint vital">*勾选发布虚拟商品后，该商品交易类型为“虚拟兑换码”验证形式,无需物流发货。</p>
					        </dd>
				     	</dl>
				     	<dl class="special-01" nctype="virtual_valid" style="display: none;">
					        <dt><i class="required">*</i>虚拟商品有效期至：</dt>
					        <dd>
					          <input type="text" name="virtual_indate" id="virtual_indate" class="w80 text hasDatepicker" value="<?php echo date('Y-m-d',$goodsInfo[virtual_indate]); ?>" readonly="readonly" >
                                <em class="add-on"><i class="icon-calendar"></i></em>
					          <span id="err_virtual_indate" style="color:#ff0000"></span>
					          <p class="hint">虚拟商品可兑换的有效期，过期后商品不能购买，电子兑换码不能使用。</p>
					        </dd>
					    </dl>
					    <dl class="special-01" nctype="virtual_valid" style="display: none;">
					        <dt><i class="required">*</i>虚拟商品购买上限：</dt>
					        <dd>
					          <input type="text" name="virtual_limit" id="virtual_limit" class="w80 text" value="<?php echo (isset($goodsInfo['virtual_limit']) && ($goodsInfo['virtual_limit'] !== '')?$goodsInfo['virtual_limit']:'1'); ?>"  onpaste="this.value=this.value.replace(/[^\d]/g,'')"  onblur="checkInputNum(this.name,1,10,'',1);" >
					          <span></span>
					          <p class="hint">请填写1~10之间的数字，虚拟商品最高购买数量不能超过10个。</p>
					        </dd>
					    </dl> 
                                <input type="hidden" name="virtual_refund" id="virtual_refund_0" value="0" >-->
				<!--	    <dl class="special-01" nctype="virtual_valid" style="display: none;">
					        <dt>支持过期退款：</dt>
					        <dd>
					          <ul class="ncsc-form-radio-list">
					            <li>
					              <input type="radio" name="virtual_refund" id="virtual_refund_1" value="1" <?php if($goodsInfo[virtual_refund] == 1): ?>checked<?php endif; ?>>
					              <label for="virtual_refund_1">是</label>
					            </li>
					            <li>
					              <input type="radio" name="virtual_refund" id="virtual_refund_0" value="0" <?php if($goodsInfo[virtual_refund] == 0): ?>checked<?php endif; ?>>
					              <label for="virtual_refund_0">否</label>
					            </li>
					          </ul>
					          <p class="hint">兑换码过期后是否可以申请退款。</p>
					        </dd>
					    </dl>
					    <?php endif; ?>-->
					    
					   
                        
                        
                        <h3 id="demo2">商品详情描述</h3>
                        <dl>
                            <dt>商品详情描述：</dt>
                            <dd>
                                <p>
                                    <textarea id="goods_content" name="goods_content" class="txt"><?php echo $goodsInfo['goods_content']; ?></textarea>
                                </p>
                                <p class="hint">商品详情描述</p>
                            </dd>
                        </dl>
                    </div>

                    <div class="ncsc-form-goods" id="tab_goods_images" style="display: none;">
                        <dl>
                            <dd>
                                <div class="ncsc-form-goods-pic">
									<div class="container">
							            <div class="ncsc-goodspic-list" style="opacity: 1;">
								        <div class="clabackkj">
								          <h3>管理缩略图</h3>
								          <a ata-original-title="添加商品" onclick="add_image();" class="ncbtn ncbtn-grapefruit mt5"><i class="fa fa-plus"></i>添加缩略图</a>
								         </div>
								        	<ul nctype="ul0" class="goods-pic-list">
								        	<?php if(is_array($goodsImages) || $goodsImages instanceof \think\Collection || $goodsImages instanceof \think\Paginator): if( count($goodsImages)==0 ) : echo "" ;else: foreach($goodsImages as $k=>$vo): ?>
							                    <li class="ncsc-goodspic-upload">
									            <div class="upload-thumb"><a onclick="" href="<?php echo $vo['image_url']; ?>" target="_blank"><img nctype="file_<?php echo $k; ?>" src="<?php echo $vo['image_url']; ?>"></a>
									              <input type="hidden" value="<?php echo $vo['image_url']; ?>" name="goods_images[]" data-id="file_<?php echo $k; ?>">
									            </div>
									            <div nctype="file_00" class="show-default">
									              <p><i class="icon-ok-circle"></i>
									              </p><a title="移除" onclick="ClearPicArr2(this,'<?php echo $vo['image_url']; ?>')" class="del" <?php if($k >= 5): ?>ncaction="del"<?php endif; ?> nctype="del" href="javascript:void(0)">X</a>
									            </div>
									            <div class="show-sort">排序：<input type="text" maxlength="1" size="1"class="text" name="img_sorts[]" value="<?php echo $vo['img_sort']; ?>">
									            </div>
									            <div class="ncsc-upload-btn"><a href="javascript:void(0);"   onclick="img_upload(10, 'file_<?php echo $k; ?>', 'goods', 'call_back2');"><p><i class="icon-upload-alt"></i>上传</p></a>
									             </div>
									          </li>
									      <?php endforeach; endif; else: echo "" ;endif; if(count($goodsImages) < 5): $__FOR_START_16201__=count($goodsImages);$__FOR_END_16201__=5;for($i=$__FOR_START_16201__;$i < $__FOR_END_16201__;$i+=1){ ?>
                                                        <li class="ncsc-goodspic-upload">
                                                            <div class="upload-thumb"><a onclick="" href="#" target="_blank"><img nctype="file_<?php echo $i; ?>"
                                                                                                                                  src="/public/static/images/default_goods_image_240.gif"></a>
                                                                <input type="hidden" value="" name="goods_images[]" data-id="file_<?php echo $i; ?>">
                                                            </div>
                                                            <div class="show-default">
                                                                <p><i class="icon-ok-circle"></i>
                                                                </p><a title="移除" onclick="ClearPicArr2(this,'')" class="del" nctype="del" href="javascript:void(0)">X</a>
                                                            </div>
                                                            <div class="show-sort">排序 ：<input type="text" maxlength="1" size="1" class="text" name="img_sorts[]">
                                                            </div>
                                                            <div class="ncsc-upload-btn"><a href="javascript:void(0);"
                                                                                            onclick="img_upload(10, 'file_<?php echo $i; ?>', 'goods', 'call_back2');"><span></span>

                                                                <p><i class="icon-upload-alt"></i>上传</p>
                                                            </a>
                                                            </div>
                                                        </li>
                                                    <?php } endif; ?>
									      </ul>
									      <input type="hidden" value="" name="goods_images[]" >
									      </div>
								      </div>
								      <div class="sidebar"><div class="alert alert-info alert-block" id="uploadHelp">
									    <div class="faq-img"></div>
									    <h4>上传要求：</h4><ul>
									    <li>1. 请使用jpg\jpeg\png等格式、单张大小不超过1M的正方形图片。</li>
									    <li>3. 最多可上传10张图片，默认前面5张上传框不可删除, 新增加的上传框可删除, 但对上传的图片无影响, 已实际上传图片数量为准</li>
									    <li>4. 更改排序数字修改商品图片的排列显示顺序, 数字越小的越靠前显示</li>
									    <li>5. 图片质量要清晰，不能虚化，要保证亮度充足。</li>
									    <li>6. 操作完成后请点击"保存"按钮 , 否则上传的图片不会被保存</li>
									    </ul><h4>建议:</h4><ul><li>1. 主图为白色背景正面图。</li><li>2. 排序依次为正面图-&gt;背面图-&gt;侧面图-&gt;细节图。</li></ul></div>
									   </div>
								</div>
                            </dd>
                        </dl>
                    </div>
                    <div class="ncsc-form-goods" id="tab_goods_spec" style="display: none;">
                        <table class="table table-bordered" id="goods_spec_table">
                            <tr>
                                <td colspan="2">
                                    <div class="alert mt15 mb5"><strong>操作提示：</strong>
									  <ul>
										<li style="color:red">发布商品时, 如果规格没有显示出来请检查以下步骤</li>
									    <li>1、"通用信息"选项卡中是否选择商品分类</li>
									    <li>2、如果已经选择商品分类, 请在总平台确认商品分类是否关联商品模型</li>
									    <li>3、如果分类已经关联商品模型, 请检查商品模型是否关联规格</li>
									  </ul>
									</div>
                                </td>
                            </tr>
                        </table>
                        <div id="ajax_spec_data"><!-- ajax 返回规格--></div>
                    </div>
                    <div class="ncsc-form-goods" id="tab_goods_attr" style="display: none;">
                        <table class="table table-bordered" id="goods_attr_table">
                            <tr>
                                <td colspan="2">
                                    <div class="alert mt15 mb5"><strong>操作提示：</strong>
									  <ul>
										<li style="color:red">发布商品时, 如果属性没有显示出来请检查以下步骤</li>
									    <li>1、请先选择商品分类再设置属性</li>
									  </ul>
									</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="ncsc-form-goods" id="tab_goods_shipping" style="display: none;">
                        <h4><b>物流配送：</b><input type="checkbox" onclick="choosebox(this)">全选</h4>
                        <table class="table table-bordered table-striped dataTable" id="goods_shipping_table">
                            <?php if(is_array($plugin_shipping) || $plugin_shipping instanceof \think\Collection || $plugin_shipping instanceof \think\Paginator): if( count($plugin_shipping)==0 ) : echo "" ;else: foreach($plugin_shipping as $kk=>$shipping): ?>
                                <tr>
                                    <td class="title left" style="padding-right:50px;">
                                        <b><?php echo $shipping[name]; ?>：</b>
                                        <label class="right"><input type="checkbox" value="1" cka="mod-<?php echo $kk; ?>">全选</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <ul class="group-list">
                                            <?php if(is_array($shipping_area) || $shipping_area instanceof \think\Collection || $shipping_area instanceof \think\Paginator): if( count($shipping_area)==0 ) : echo "" ;else: foreach($shipping_area as $key=>$vv): if($vv[shipping_code] == $shipping[code]): ?>
                                                    <li><label><input type="checkbox" name="shipping_area_ids[]" value="<?php echo $vv['shipping_area_id']; ?>" ck="mod-<?php echo $kk; ?>"
                                                        <?php if(!empty($goodsInfo) && (in_array($vv['shipping_area_id'],$goodsInfo[shipping_area_id_arr]))): ?>checked='checked'<?php endif; ?>>
                                                        <?php echo $vv['shipping_area_name']; ?>
                                                    </label></li>
                                                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                            <div class="clear-both"></div>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </table>
                    </div>
                    <div class="bottom tc hr32">
                        <label class="submit-border">
                            <input nctype="formSubmit" class="submit" id="submit" value="保存" type="submit">
                        </label>
                    </div>
                </form>
            </div>
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
<!-- 
  <p><a href="/">首页</a>
                | <a  href="#">招聘英才</a>
                | <a  href="#">合作及洽谈</a>
                | <a  href="#">联系我们</a>
                | <a  href="#">关于我们</a>
                | <a  href="#">物流自取</a>
                | <a  href="#">友情链接</a>
  </p>
   -->
  Copyright 2017 <a href="" target="_blank">趣喝茶</a> All rights reserved.<br />
  <a href="#" target="_blank">趣喝茶</a>  
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
<script>
    /*
     * 上传之后删除组图input
     * @access   public
     * @val      string  删除的图片input
     */
    function ClearPicArr2(obj,path){
        var action = $(obj).attr('ncaction');
        if(action != undefined && action =='del'){
            $(obj).parent().parent().remove();
        }
        //删除图片文件
        if(path == '' || path == undefined){
            return;
        }
        // 删除数据库记录
         $.ajax({
            type:'GET',
            url:"<?php echo U('Seller/Goods/del_goods_images'); ?>",
            data:{filename:path},
            success:function(){
                 $(obj).parent().siblings('.upload-thumb').find('img').attr("src", '/public/static/images/default_goods_image_240.gif'); // 删除完服务器的, 再删除 html上的图片
                //删除input goods_image
                $(obj).parent().siblings('.upload-thumb').find('input[type=hidden]').val("");
                $(obj).parent().siblings('.show-sort').find('input[type=text]').val("0");
                
                //如果删除的是商品主图, 则把商品主图隐藏域删掉
                if($("#original_img").val() == path){
                	$("#original_img").val("");
                    $("#original_img2").attr("src" , '/Public/static/images/default_goods_image_240.gif');
                }
            }
        });
    }

    function select_nav(obj){
        var data_id = $(obj).attr('data-id');
        $('.ncsc-form-goods').hide();
        $('#'+data_id).show();
        $(obj).parent().parent().find('li').removeClass('active');
        $(obj).parent().addClass('active');
    }
    // 上传商品图片成功回调函数
    function call_back(fileurl_tmp){
        $("#original_img").val(fileurl_tmp);
        $("#original_img2").attr('src', fileurl_tmp);
    }

    var cur_img_id = "";
    function img_upload(num,elementid,path,callback){
    	cur_img_id = elementid;
    	GetUploadify3(num,elementid,path,callback);
    }

    // 上传商品相册回调函数
    function call_back2(paths){
    	if(paths == undefined || paths[0] == undefined) return ;
    	$("img[nctype="+cur_img_id+"]").attr("src" , paths[0]);
    	$("input[data-id="+cur_img_id+"]").val(paths[0]);

    	//重新绑定删除事件
    	$("input[data-id="+cur_img_id+"]").parent().siblings(".show-default").find("a:eq(0)").removeAttr('onclick').click(function(){  ClearPicArr2(this, paths[0]) }); ;

    }

    /**
     *	添加图片
     */
    function add_image(){
    	var length = $('.goods-pic-list>.ncsc-goodspic-upload').length;
    	if(length >= 10){
    		layer.alert("缩略图数量不能超过10个!", {icon:2});
    		return;
    	}
    	var new_id = "file_"+(length);
    	var  last_div = $(".goods-pic-list:last").children("li:first-child").prop("outerHTML");
    	$(".goods-pic-list:last").children("li:last-child").after(last_div);

    	var last_li = $(".goods-pic-list").children("li:last-child");
    	//第一个: a标签
    	last_li.find("a:eq(0)").attr("href" ,  '/public/static/images/default_goods_image_240.gif');
    	//img标签
    	last_li.find("img:eq(0)").attr("nctype" , new_id).attr("src" ,  '/public/static/images/default_goods_image_240.gif'); //src
    	//隐藏域: goods_images
    	last_li.find("input[type=hidden]:eq(0)").attr("data-id" , new_id);
    	//排序字段:
    	last_li.find("input.text").val(0);

    	//第二个: a标签 移除, 图片上传后, 修改ClearPicArr2参数, 添加ncaction属性, 如果该属性是del, 说明是超过5个的上传框, 可以删除.
    	last_li.find("a:eq(1)").attr("ncaction" , "del").removeAttr('onclick').click(function(){  ClearPicArr2(this,'') });
    	//第三个: a标签, 上传图片按钮
    	last_li.find("a:eq(2)").unbind('click').removeAttr('onclick').click(function(){  img_upload(10,  new_id, 'goods', 'call_back2') });

    }

    /**
     * ajax 加载规格 和属性
     */
    function ajaxGetSpecAttr()
    {
        // ajax调用 返回规格
        var goods_id = $('input[name=goods_id]').val();
        var cat_id3 = $('input[name=cat_id3]').val();
        $.ajax({
            type:'GET',
//			data:{goods_id:goods_id,cat_id3:cat_id3},
            url:"/index.php?m=Seller&c=Goods&a=ajaxGetSpecSelect&goods_id="+goods_id+"&cat_id3="+cat_id3,
            success:function(data){
                $("#ajax_spec_data").empty().html(data);
                if($.trim(data) != ''){
                    ajaxGetSpecInput();	// 触发完  马上触发 规格输入框
                }
            }
        });

        // 商品类型切换时 ajax 调用  返回不同的属性输入框
        $.ajax({
            type:'GET',
            url:"/index.php?m=Seller&c=Goods&a=ajaxGetAttrInput&goods_id="+goods_id+"&cat_id3="+cat_id3,
            success:function(data){
                $("#goods_attr_table tr:gt(0)").remove();
                $("#goods_attr_table").append(data);
            }
        });
    }
    
   
    /** 以下是编辑时默认选中某个商品分类*/
    $(document).ready(function(){
    	$("#shop_price").blur(function(){  
    		//可赠送积分    			
			var send_point = calc_send_point();
			$("#give_integral_hint").html("可赠送积分不能超过"+send_point);
        });
    	$('#shop_price').trigger("blur");

        // 店铺内部分类
        <?php if($goodsInfo['store_cat_id2'] > 0): ?>
                get_store_category("<?php echo $goodsInfo['store_cat_id1']; ?>",'store_cat_id2',"<?php echo $goodsInfo['store_cat_id2']; ?>");
        <?php endif; ?>
        ajaxGetSpecAttr();
        // 商品品牌根据分类显示相关的品牌
        $('#brand_id option').each(function(){
            var cat_id1 = $('input[name=cat_id1]').val();
            if($(this).data('cat_id1') != cat_id1 && $(this).val() > 0){
                $(this).hide();
            }
        });
        
        <?php if($goodsInfo['is_virtual'] == 1): ?>
        	$('[nctype="virtual_valid"]').show();
        	$('[nctype="virtual_null"]').hide();
		<?php endif; ?>
		
		$("#addEditGoodsForm").validate({
    		debug: false, //调试模式取消submit的默认提交功能   
    		focusInvalid: false, //当为false时，验证无效时，没有焦点响应  
            onkeyup: false,   
            submitHandler: function(form){   //表单提交句柄,为一回调函数，带一个参数：form
                $('#submit').attr('disabled',true);
            	var send_point = calc_send_point();   
            	var give_integral = $("input[name='give_integral']").val();
            	if(give_integral > send_point){
            		layer.alert("最多可赠送积分不能超过"+send_point , {icon:2, time:2000},function () {
                        $('#submit').attr('disabled',false);
                    });
            		return;
            	}
                $.ajax({
                    type: "POST",
                    url: "<?php echo U('Goods/save'); ?>",
                    data: $('#addEditGoodsForm').serialize(),
                    dataType: "json",
                    error: function(request) {
                        layer.alert("服务器繁忙, 请联系管理员!",{icon:2});
                        return false;
                    },
                    success: function (data) {
                        if (data.status == 1) {
                            layer.msg(data.msg,{icon: 1,time: 2000});
                            $("input[name=goods_id]").attr('value',data.result.goods_id);
                            window.location.href="<?php echo U('/seller/Goods/goodsList'); ?>";
                        } else {
                            layer.msg(data.msg,{icon: 2,time:2000},function () {
                                $('#submit').attr('disabled',false);
                            });
                            // 验证失败提示错误
                            for (var i in data.result) {
                                $("#err_" + i).text(data.result[i]).show(); // 显示对于的 错误提示
                            }
                        }
                    }
                });
            },
            ignore:":button,:checkbox",	//不验证的元素
            rules:{
            	goods_name:{
            		required:true
            	},
            	shop_price:{
            		required:true,
            		number:true,
            		min:0
            	},
            	market_price:{
            		required:true,
            		number:true,
            		min:0
            	},
            	store_count:{
            		required:true,
            		digits:true,
            		min:0
            	}
            },
            messages:{
            	goods_name:{
            		required:"请填写商品名称"
            	},
            	shop_price:{
            		required:"请填写商品售价",
            		number:"请输入数字",
            		min:"商品价格不能小于0"
            	},
            	market_price:{
            		required:"请填写市场售价",
            		number:"请输入数字",
            		min:"商品价格不能小于0"
            	},
            	store_count:{
            		required:"请输入库存",
            		digits:"库存必须是正数",
            		min:"库存数量不能小于0"
            	}
            }
    	});
    });
    
    /** 计算最多可赠送积分数 */
    function calc_send_point(){
    	
    	var point_rate = "<?php echo (isset($tpshop_config['shopping_point_rate']) && ($tpshop_config['shopping_point_rate'] !== '')?$tpshop_config['shopping_point_rate']:1); ?>";
    	var point_send_limit = "<?php echo (isset($tpshop_config[shopping_point_send_limit]) && ($tpshop_config[shopping_point_send_limit] !== '')?$tpshop_config[shopping_point_send_limit]:1); ?>";
    	 
    	var shop_price = $("#shop_price").val();
		//可赠送积分    			
		var send_point = shop_price * point_rate * point_send_limit / 100;
		return send_point;
    }
    
    function get_store_category(id,next,select_id){
        var url = '/index.php?m=Home&c=api&a=get_store_category';
        var store_id = "<?php echo $store_id; ?>";
        $.ajax({
            type : "GET",
            url : url,
            data:{'store_id':store_id,'parent_id':id},
            error: function(request) {
                layer.alert("服务器繁忙, 请联系管理员!",{icon:2});
                return;
            },
            success: function(v) {
                v = "<option value='0'>请选择商品分类</option>" + v;
                $('#'+next).empty().html(v);
                (select_id > 0) && $('#'+next).val(select_id);//默认选中
            }
        });
    }

    // 属性输入框的加减事件
    function addAttr(a)
    {
        var attr = $(a).parent().parent().prop("outerHTML");
        attr = attr.replace('addAttr','delAttr').replace('+','-');
        $(a).parent().parent().after(attr);
    }
    // 属性输入框的加减事件
    function delAttr(a)
    {
        $(a).parent().parent().remove();
    }
    function choosebox(o){
        var vt = $(o).is(':checked');
        if(vt){
            $('input[type=checkbox]').prop('checked',vt);
        }else{
            $('input[type=checkbox]').removeAttr('checked');
        }
    }
    $(document).ready(function(){
        $(":checkbox[cka]").click(function(){
            var $cks = $(":checkbox[ck='"+$(this).attr("cka")+"']");
            if($(this).is(':checked')){
                $cks.each(function(){$(this).prop("checked",true);});
            }else{
                $cks.each(function(){$(this).removeAttr('checked');});
            }
        });
    });
    
    
    var is_virtual = <?php echo ($_GET[goods_id] == 0) || ($goodsInfo[is_virtual] == 1) ? "1" : "0"; ?>;
    
    /* 虚拟控制 // 虚拟商品有效期 */
    if(is_virtual == '1'){	//虚拟商品属性
    	$('#virtual_indate').layDate();
        $('[name="is_virtual"]').change(function(){
            if ($('#is_virtual_1').prop("checked")) {
                $('[nctype="virtual_valid"]').show();
                $('[nctype="virtual_null"]').hide();
                $('.goods_shipping').hide();
            } else {
                $('[nctype="virtual_valid"]').hide();
                $('[nctype="virtual_null"]').show();
                $('.goods_shipping').show();
                $('#virtual_limit').val(1);
            }
        });
    }



</script>
</body>
</html>
