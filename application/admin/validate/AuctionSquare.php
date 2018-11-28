<?php
/**
 * tpshop
 * ============================================================================
 * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 商业用途务必到官方购买正版授权, 使用盗版将严厉追究您的法律责任。
 * ============================================================================
 * Author: IT宇宙人
 * Date: 2015-09-09
 */
namespace app\admin\validate;
use think\Validate;
class AuctionSquare extends Validate {

    //验证规则
    protected $rule = [

        "title"=>"require|min:2|unique:auction_square",
        "cover"=>"require",
        "auction_idlist"=>"require"

    ];

    //错误消息
    protected $message = [
        "title.require"=>"拍卖名填一个",
        "title.min"=>"拍卖名不对",
        "title.unique"=>"拍卖已经存在",
        "cover.require"=>"请上传拍卖图片",
        "auction_idlist"=>"拍卖品至少选择一个"
    ];

}
