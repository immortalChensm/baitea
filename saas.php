<?php

/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * 如果商业用途务必到官方购买正版授权, 以免引起不必要的法律纠纷.
 * ============================================================================
 */

define('IS_SAAS', 0);
if (!IS_SAAS) {
    define('SAAS_BASE_USER', 0);
    return;
}

//saas的域名
define('SAAS_DOMAIN', 'tpshop1bb2.com');

$host = $_SERVER['HTTP_HOST'];
if (strpos($host, SAAS_DOMAIN) === false) {
    //个人域名的配置文件路径
    $domainMapPath = 'saas/_domain_map.cfg';
    if (!is_file($domainMapPath)) {
        http_response_code(404);
        exit('网页不存在');
    }
    //获取映射的二级域名
    $dataStr = file_get_contents($domainMapPath);
    $data = json_decode($dataStr, true);
    if (empty($data[$host])) {
        http_response_code(404);
        exit('网页不存在');
    }
    $domain = $data[$host];
} else {
    //获取二级域名
    $hostArr = explode('.', $host);
    if (count($hostArr) !== 3) {
        http_response_code(404);
        exit('网页不存在');
    }
    $domain = strtolower($hostArr[0]);
}

//用户配置文件的路径
$rightFilePath = 'saas/'.$domain.'.cfg';
if (!is_file($rightFilePath)) {
    http_response_code(404);
    exit('网页不存在');
}

$rightStr= file_get_contents($rightFilePath);
$right = json_decode($rightStr, true);
if (!$right['is_base_app'] && (!isset($right['expires']) || $right['expires'] < time())) {
    http_response_code(404);
    exit('网页不存在');
}

$GLOBALS['SAAS_CONFIG'] = $right;

define('SAAS_BASE_USER', $right['is_base_app']);
define('UPLOAD_PATH', __DIR__ . '/public/upload/saas/'.$domain.'/');
define('RUNTIME_PATH', __DIR__ . '/runtime/saas/'.$domain.'/');

//TODO 物流文件

if (!file_exists(UPLOAD_PATH)) {
    mkdir(UPLOAD_PATH, 0777, true);
}
if (!file_exists(RUNTIME_PATH)) {
    mkdir(RUNTIME_PATH, 0777, true);
}
