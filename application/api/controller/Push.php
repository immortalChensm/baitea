<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 商业用途务必到官方购买正版授权, 使用盗版将严厉追究您的法律责任。
 * ============================================================================
 */ 
namespace app\api\controller;

require_once './vendor/jpush/jpush/autoload.php';
/**
 * Description of App
 *
 */
class Push extends Base
{
    /**
     * 获取最新的app
     */
    public function send()
    {
        $push = new \JPush\Client('ba930456252a3ac98c746dc7', 'b5ae4b7a4ff60e5c9045b278');
	$cid = 'xxxxxx';
$platform = array('ios', 'android');
$alert = 'Hello JPush';
$tag = array('tag1', 'tag2');
$regId = array('rid1', 'rid2');
$ios_notification = array(
    'sound' => 'hello jpush',
    'badge' => 2,
    'content-available' => true,
    'category' => 'jiguang',
    'extras' => array(
        'key' => 'value',
        'jiguang'
    ),
);
$android_notification = array(
    'title' => 'hello jpush',
    //'build_id' => 2,
    'extras' => array(
        'key' => 'value',
        'jiguang'
    ),
);
$content = 'Hello World';
$message = array(
    'title' => 'hello jpush',
    'content_type' => 'text',
    'extras' => array(
        'key' => 'value',
        'jiguang'
    ),
);
$options = array(
    'sendno' => 100,
    'time_to_live' => 100,
    //'override_msg_id' => 100,
    'big_push_duration' => 100
);
$response = $push->push()
    ->setPlatform($platform)
    ->addAlias('48')
    ->iosNotification($alert, $ios_notification)
    ->androidNotification($alert, $android_notification)
    ->message($content, $message)
    ->options($options)
    ->send();
    var_dump($response);
    }
    
}
?>