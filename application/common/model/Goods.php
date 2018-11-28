<?php
/**
 * tpshop
 * ============================================================================
 * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * Author: dyr
 * Date: 2016-08-23
 */

namespace app\common\model;

use think\Model;
use think\Db;

/**
 * @package Home\Model
 */
class Goods extends Model
{

    public function FlashSale()
    {
        return $this->hasOne('FlashSale','id','prom_id');
    }

    public function PromGoods()
    {
        return $this->hasOne('PromGoods','id','prom_id')->cache(true,10);
    }
    public function GroupBuy()
    {
        return $this->hasOne('GroupBuy','id','prom_id');
    }
    public function store()
    {
        return $this->hasOne('store','store_id','store_id');
    }
    public function getDiscountAttr($value, $data)
    {
        if ($data['market_price'] == 0) {
            $discount = 10;
        } else {
            $discount = round($data['shop_price'] / $data['market_price'], 2) * 10;
        }
        return $discount;
    }

    public function goodsList($p){
        $where = array();
        $where['is_on_sale'] = '1';
        $where['is_crowd_goods'] = '1';
        $where['crowd_end'] = array('gt',time());
        $list['newList'] = D('Goods')->alias('a')->field('a.goods_id,a.goods_name,a.original_img,a.product_area,a.store_id,b.store_name AS seller_name')->order('a.goods_id desc')->join('Store b','a.store_id = b.store_id')->where($where)->limit('6')->select();
        $list['hotList'] = D('Goods')->alias('a')->field('a.goods_id,a.goods_name,a.original_img,a.product_area,a.store_id,b.store_name AS seller_name')->order('a.sales_sum desc')->join('Store b','a.store_id = b.store_id')->where($where)->page($p,8)->select();
        return $list;
    }

    public function getItem($goodsId){
        $list = $this->where(['goods_id'=>$goodsId,'is_on_sale'=>1])->field('goods_id,goods_name,store_id,goods_remark,original_img,crowdfunding_money,crowd_end')->find();
        $list['spec'] = D('RaiseSpecification')->where(array('rid'=>$list['goods_id']))->select();
        $list['image'] = $this->hasMany('GoodsImages','goods_id')->where(['goods_id'=>$goodsId])->field('image_url')->select();
        $list['purchase'] = count_down($list['crowd_end']);   //距离结束时间
        $list['crowdMoney'] = $this->orders($goodsId,1);                 //认筹金额
        $list['percent'] = $list['crowdMoney'] > '0' ? floor(($list['crowdMoney'] / $list['crowdfunding_money']) *100) : 0;  //百分比
        $list['crowdNum'] = $this->orders($goodsId,2);  //多少人支持
        $list['store'] = D('Store')->where(array('store_id'=>$list['store_id']))->field('store_logo,store_name AS seller_name,store_phone,store_qq')->select();
        return $list;
    }

    public function orders($goodsId,$status){
        $list = D('OrderGoods')->where(['goods_id'=>$goodsId])->select();
        $money = 0;
        $buyNum = 0;
        foreach ($list as $key => $val) {
            $order = D('Order')->where(['order_id'=>$val['order_id'],'pay_status'=>'1','order_status'=>'0','status'=>'1'])->find();
            if($order['pay_status'] =='1'){$money +=$order['order_amount']; $buyNum ++;}
        }
        return $status =='1' ? $money : $buyNum;
    }

    

}