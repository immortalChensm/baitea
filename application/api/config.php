<?php
$home_config = [
    // +----------------------------------------------------------------------
    // | 模板设置
    // +----------------------------------------------------------------------
	//默认错误跳转对应的模板文件
	'dispatch_error_tmpl' => 'public:dispatch_jump',
	//默认成功跳转对应的模板文件
	'dispatch_success_tmpl' => 'public:dispatch_jump', 
	'API_SECRET_KEY'        =>'123456', // app 调用的签名秘钥
];

$html_config = include_once 'html.php';
$area_config = include_once 'area1.php';
return array_merge($home_config,$html_config,$area_config);
?>