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

namespace app\seller\model;
use think\model;
class ShippingArea extends model {

    /**
     * 获取店铺的配送区域
     * @param $store_id
     * @return mixed
     */
    public function getShippingArea($store_id)
    {
        $shipping_areas = M('shipping_area')->where(array('store_id'=>$store_id))->select();
        foreach($shipping_areas as $key => $val){
            $shipping_areas[$key]['config'] = unserialize($shipping_areas[$key]['config']);
        }
        return $shipping_areas;
    }

}
