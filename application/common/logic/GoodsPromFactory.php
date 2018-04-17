<?php
/**
 * tpshop
 * ============================================================================
 * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * 如果商业用途务必到官方购买正版授权, 以免引起不必要的法律纠纷.
 * ============================================================================
 * Author: Dyr
 * Date: 2017-05-11
 */
namespace app\common\logic;

/**
 * 商品活动工厂类
 * Class CatsLogic
 * @package common\Logic
 */
class GoodsPromFactory
{
    /**
     * @param $goods|商品实例
     * @param $spec_goods_price|规格实例
     * @return FlashSaleLogic|GroupBuyLogic|PromGoodsLogic
     */
    public function makeModule($goods, $spec_goods_price)
    {
        switch ($goods['prom_type']) {
            // 0默认 1抢购 2团购 3优惠促销 4预售 5虚拟(5其实没用) 6拼团
            case 1:
                return new FlashSaleLogic($goods, $spec_goods_price); //1抢购
            case 2:
                return new GroupBuyLogic($goods, $spec_goods_price); //2团购
            case 3:
                return new PromGoodsLogic($goods, $spec_goods_price); //3优惠促销
            case 6:
                return new TeamActivityLogic($goods, $spec_goods_price); //6拼团
        }
    }

    /**
     * 检测是否符合商品活动工厂类的使用
     * @param $promType |活动类型
     * @return bool
     */
    public function checkPromType($promType)
    {
        //1抢购 2团购 3优惠促销 6拼团
        if (in_array($promType, array_values([1, 2, 3, 6]))) {
            return true;
        } else {
            return false;
        }
    }

}
