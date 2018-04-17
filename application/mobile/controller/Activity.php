<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 商业用途务必到官方购买正版授权, 使用盗版将严厉追究您的法律责任。
 * ============================================================================
 * $Author: 当燃   2016-05-10
 */ 
namespace app\mobile\controller;

use app\common\logic\ActivityLogic;
use app\common\logic\GoodsLogic;
use app\common\model\FlashSale;
use app\common\model\GroupBuy;
use think\Db;
use think\Page;

class Activity extends MobileBase {
    public function index(){      
        return $this->fetch();
    }
    
    /**
     * 团购活动列表
     */
    public function group_list()
    {
        $type = input('type', '');
        $is_ajax = input('is_ajax',0);
        if ($type == 'new') {
            $order = 'gb.start_time';
        } elseif ($type == 'comment') {
            $order = 'g.comment_count';
        } else {
            $order = '';
        }
        $group_by_where = array(
            'gb.start_time'=>array('lt',time()),
            'gb.end_time'=>array('gt',time()),
            'gb.recommend' =>1,
            'gb.status' =>1,
            'gb.status' =>1,
            'g.is_on_sale'=>1
        );
        $GroupBuy = new GroupBuy();
        $count =  $GroupBuy->alias('gb')->join('__GOODS__ g', 'g.goods_id = gb.goods_id')->where($group_by_where)->count('gb.goods_id');// 查询满足要求的总记录数
        $page = new Page($count, 20);
        $list = $GroupBuy
            ->alias('gb')
            ->join('__GOODS__ g', 'gb.goods_id=g.goods_id AND g.prom_type=2')
            ->where($group_by_where)
            ->page($page->firstRow, $page->listRows)
            ->order($order, 'desc')
            ->select();
        $this->assign('list', $list);
        if($is_ajax){
            return $this->fetch('ajax_group_list');
        }
        return $this->fetch();
    }
    
    public function ajaxGroupListGetMore(){
        $p = I('p',1);
        $list = M('GroupBuy')->where(time()." >= start_time and ".time()." <= end_time ")->page($p,10)->select(); // 找出这个商品
        $this->assign('list', $list);
        return $this->fetch();
    }
    
    
    public function discount_list(){
        $prom_id = I('id/d');    //活动ID
        $where = array(     //条件
            'is_on_sale'=>1,
            'prom_type'=>3,
            'prom_id'=>$prom_id,
        );
        $count =  M('goods')->where($where)->count(); // 查询满足要求的总记录数
        $Page = new Page($count, 20); //分页类
        $prom_list = Db::name('goods')->where($where)->limit($Page->firstRow.','.$Page->listRows)->select(); //活动对应的商品
        $spec_goods_price = Db::name('specGoodsPrice')->where(['prom_type'=>3,'prom_id'=>$prom_id])->select(); //规格
        foreach($prom_list as $gk =>$goods){  //将商品，规格组合
            foreach($spec_goods_price as $spk =>$sgp){
                if($goods['goods_id']==$sgp['goods_id']){
                    $prom_list[$gk]['spec_goods_price']=$sgp;
                }
            }
        }
        foreach($prom_list as $gk =>$goods){  //计算优惠价格
            $PromGoodsLogicuse = new \app\common\logic\PromGoodsLogic($goods,$goods['spec_goods_price']);
            if(!empty($goods['spec_goods_price'])){
                $prom_list[$gk]['prom_price']=$PromGoodsLogicuse->getPromotionPrice($goods['spec_goods_price']['price']);
            }else{
                $prom_list[$gk]['prom_price']=$PromGoodsLogicuse->getPromotionPrice($goods['shop_price']);
            }

        }
        $this->assign('prom_list', $prom_list);
        if(I('is_ajax')){
            return $this->fetch('ajax_discount_list');
        }
        return $this->fetch();
    }
    
    public function discount_goods_list(){
    	$prom_list = M('prom_goods')->where("end_time>".time())->select();
    	$this->assign('prom_list', $prom_list);
    	return $this->fetch();
    }

    /**
     * 商品活动页面
     * $author lxl
     * $time 2017-1
     */
    public function promote_goods(){
        $now_time = time();
        $where = " start_time <= $now_time and end_time >= $now_time and status=1 and recommend=1";
        $count = M('prom_goods')->where($where)->count();  // 查询满足要求的总记录数
        $pagesize = 10;  //每页显示数
        $Page  = new Page($count,$pagesize); //分页类
        $promote = M('prom_goods')->field('id,title,start_time,end_time,prom_img')
            ->where($where)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();    //查询活动列表
        $this->assign('promote',$promote);
        if(I('is_ajax')){
            return $this->fetch('ajax_promote_goods');
        }
        return $this->fetch();
    }
    /**
     * 抢购活动列表页
     */
    public function flash_sale_list()
    {
        $time_space = flash_sale_time_space();
        $this->assign('time_space', $time_space);
        return $this->fetch();
    }

    /**
     * 抢购活动列表ajax
     */
    public function ajax_flash_sale()
    {
        $p = input('p',1);
        $start_time = input('start_time');
        $end_time = input('end_time');
        $where = array(
            'fl.status' => 1, //状态
            'fl.start_time'=>array('egt',$start_time), //抢购开始时间 >=
            'fl.end_time'=>array('elt',$end_time),     //抢购结束时间 <=
            'fl.recommend'=>1, //是否推荐
            'g.is_on_sale'=>1  //是否上架
        );

        $FlashSale = new FlashSale();
        $flash_sale_goods = $FlashSale->alias('fl')->join('__GOODS__ g', 'g.goods_id = fl.goods_id')->with(['specGoodsPrice', 'goods'])->field('*,100*(FORMAT(buy_num/goods_num,2)) as percent')->fetchSql(false)->where($where)->page($p, 10)->order('fl.id desc')->select();       
        $this->assign('flash_sale_goods',$flash_sale_goods);
        return $this->fetch();
    }

    public function coupon_list()
    {
        $atype = I('atype', 1);
        $user = session('user');
        $p = I('p', '');
        
        $activityLogic = new ActivityLogic();
        $result = $activityLogic->getCouponList($atype, $user['user_id'], $p);
        $this->assign('store_arr', $result['store_arr']);
        $this->assign('coupon_list', $result['coupon_list']);
        if (request()->isAjax()) {
            return $this->fetch('ajax_coupon_list');
        }
        return $this->fetch();
    }

    /**
     * 领券
     */
    public function getCoupon()
    {
        $id = I('coupon_id/d');
        $user = session('user');
        $user['user_id'] = $user['user_id'] ?: 0;
        $activityLogic = new ActivityLogic();
        $return = $activityLogic->get_coupon($id, $user['user_id']);
        
        $this->ajaxReturn($return);
    }

}