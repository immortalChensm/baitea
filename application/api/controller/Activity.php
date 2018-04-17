<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 商业用途务必到官方购买正版授权, 使用盗版将严厉追究您的法律责任。
 * ============================================================================
 * $Author: IT宇宙人 2015-08-10 $
 */ 
namespace app\api\controller;
use app\common\logic\ActivityLogic;
use app\common\logic\GoodsPromFactory;
use think\Db;
use think\Page;
/**
 * 
 * 此项目优惠卷　　默认优惠卷类型为免费领取
 * 不在对优惠卷进行分类获取了
 * 直接从优惠卷列表让用户在付款的时候完成领取操作
 * 优惠卷后台发布规则是优惠卷放送的时候会延迟一天，使用时间会延长一个月
 * 
 * @author admin
 ****/
class Activity extends Base {
    /**
     * @author dyr
     * @time 2016/09/20
     * 团购活动列表
     */
    public function group_list()
    {
        $page_size = I('page_size', 10);
        $p = I('p',1);
        $type = I('type', '');
        
        $activityLogic = new ActivityLogic();
        $groups = $activityLogic->getGroupBuyList($type, $p, $page_size);
         
        //查找广告
        $start_time = strtotime(date('Y-m-d H:00:00'));
        $end_time = strtotime(date('Y-m-d H:00:00')); 
        $adv = M("ad")->field(array('ad_link','ad_name','ad_code','media_type,pid'))->where("pid=534 AND enabled=1 and start_time< $start_time and end_time > $end_time")->find();
        if($adv && $adv['media_type'] == 4){//如果是分类, 截取最后一个分类
            $cats = explode('_',$adv['ad_link']);
            $count = count($cats);
            if($count != 0) {
                $adv['ad_link'] = $cats[$count-1];
            }
        } 
        $json = array(
            'status'=>1,
            'msg'=>'获取成功',
            'result'=> [
                'groups' => $groups,
                'ad' => empty($adv) ? "" : $adv,
                'server_current_time' => time()
            ]
        );
        $this->ajaxReturn($json);
    }

    /**
     * @author wangqh
     * 抢购活动时间节点
     */
    public function flash_sale_time()
    {
        $time_space = flash_sale_time_space();
        $times = array();
        foreach ($time_space as $k => $v){
            $times[] = $v;
        }
        
        $ad = M('ad')->field(['ad_link','ad_name','ad_code'])->where('pid', 2)->cache(true, TPSHOP_CACHE_TIME)->find();
        
         $return = array(
            'status'=>1,
            'msg'=>'获取成功',
            'result'=> [
                'time' => $times,
                'ad' => $ad
            ] ,
        );
        $this->ajaxReturn($return);
    }
    
 
    /**
     * @author wangqh
     * 抢购活动列表
     */
    public function flash_sale_list()
    {
        $p = I('p',1);
        $start_time = I('start_time');
        $end_time = I('end_time');
        $where = array(
            'f.status' => 1,
            'f.start_time'=>array('egt',$start_time),
            'f.end_time'=>array('elt',$end_time)
        );
         
        $flash_sale_goods = M('flash_sale')
        ->field('f.goods_name,f.price,f.goods_id,f.price,g.shop_price,f.item_id,100*(FORMAT(f.buy_num/f.goods_num,2)) as percent')
        ->alias('f')
        ->join('__GOODS__ g','g.goods_id = f.goods_id')
        ->where($where)
        ->page($p,10)
        ->cache(true,TPSHOP_CACHE_TIME)
        ->select();
        
        $return = array(
            'status'=>1,
            'msg'=>'获取成功',
            'result'=>$flash_sale_goods ,
        );
        $this->ajaxReturn($return);
    }

    /**
     * 领券列表：与手机网页版的接口一样
     */
    public function coupon_list()
    {
        //默认就是　　免费领取的优惠卷列表
        $type = I('type', 1);
        $p = I('p', 1);

        $activityLogic = new ActivityLogic();
        $result = $activityLogic->getCouponList($type, $this->user_id, $p);
        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $result]);
    }
    
    /**
     * 领券中心
     */
    public function coupon_center()
    {
        $p = I('get.p', 1);
        $cat_id = I('get.cat_id', 0);
        
        $activityLogic = new ActivityLogic();
        $result = $activityLogic->getCouponCenterList($cat_id, $this->user_id, $p);
        
        $return = array(
            'status' => 1,
            'msg' => '获取成功',
            'result' => $result ,
        );
        $this->ajaxReturn($return); 
    }
    
    /**
     * 优惠券类型列表
     */
    public function coupon_type_list()
    {
        $p = I('get.p', 1);
        
        $activityLogic = new ActivityLogic();
        $result = $activityLogic->getCouponTypes($p, 15);

        $return = array(
            'status' => 1,
            'msg' => '获取成功',
            'result' => $result ,
        );
        $this->ajaxReturn($return); 
    }
    
    /**
     * 领取优惠券
     */
    public function get_coupon()
    {
        $id = I('post.coupon_id/d', 0);
        
        $activityLogic = new ActivityLogic();
        $return = $activityLogic->get_coupon($id, $this->user_id);
        
        $this->ajaxReturn($return);
    }
    
    /**
     *  促销活动页面
     */ 
    public function promote_list()
    {
       
        $pageSize = I('page_size/d' , 10);
        $goods_where['p.start_time']  = array('lt',time());
        $goods_where['p.end_time']  = array('gt',time());
        $goods_where['p.status']  = 1;
        $goods_where['p.is_end']  = 0;
        $goods_where['g.prom_type']  = 3;
        $goods_where['g.is_on_sale']  = 1;
        $goods_where['g.is_virtual']  = 0;
        
        $goodsCount = M('goods')
        ->alias('g')
        ->join('__PROM_GOODS__ p', 'g.prom_id = p.id')
        ->join('__SPEC_GOODS_PRICE__ s','g.prom_id = s.prom_id AND s.goods_id = g.goods_id','LEFT')
        ->where($goods_where)
        ->group('g.goods_id')
        ->count('g.goods_id');
        $Page  = new Page($goodsCount,$pageSize); //分页类
        $goodsList = M('Goods')
            ->field('g.goods_id,g.goods_name,g.shop_price,g.click_count ,g.market_price ,p.end_time,s.item_id')
            ->alias('g')
            ->join('__PROM_GOODS__ p', 'g.prom_id = p.id')
            ->join('__SPEC_GOODS_PRICE__ s','g.prom_id = s.prom_id AND s.goods_id = g.goods_id','LEFT')
            ->where($goods_where)
            ->limit($Page->firstRow.','.$Page->listRows)
            ->group('g.goods_id')
            ->order('p.recommend desc')
            ->cache(true,10)
            ->select();
        $server_time = time();
        $return_list = array();
        foreach ($goodsList as $v) {
            $v["server_time"] = $server_time;
            $return_list[] = $v;
        }
         
        $return = array(
            'status' => 1,
            'msg' => '获取成功',
            'result' => $return_list ,
        );
        $this->ajaxReturn($return);
    }
}