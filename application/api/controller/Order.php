<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 订单以及售后中心
 * @author soubao 当燃
 *  @Date: 2016-12-20
 */
namespace app\api\controller;

use app\common\logic\OrderLogic;
use app\common\logic\CommentLogic;
use app\common\logic\OrderGoodsLogic;
use app\common\logic\StoreLogic;
use app\common\logic\UsersLogic;
use think\Db;
use think\Page;

class Order extends Base 
{
    /**
     * 删除订单
     */
    public function del_order()
    {
        $order_id = I('post.order_id', 0);

        $orderLogic = new \app\common\logic\OrderLogic;
        $orderLogic->setUserId($this->user_id);
        $return = $orderLogic->delOrder($order_id);
        
        $this->ajaxReturn($return);
    }

    /*订单详情*/
    public function OrderDetail(){
        !I('orderId') && $this->ajaxReturn(['status' => -1, 'msg' => '请携带订单id']);
        $list = Model('Order')->orderInfo(I('orderId'));
        $this->ajaxReturn(['status' => 1, 'msg' => '','result'=>$list]);
    }

    /*
     * 获取订单详情
     */
    public function order_detail()
    {
        if (!$this->user_id) {
            $this->ajaxReturn(['status'=>-1, 'msg'=>'缺少参数', 'result'=>'']);
        }
        
        $id = I('id/d');
        if ($id){
            $map['order_id'] = $id;
        } else {
            $map['master_order_sn'] = I('sn');//主订单号
        }
        $map['user_id'] = $this->user_id;
        
        $Order = new \app\common\model\Order();
        $orderObj = $Order->where($map)->find();
        if (!$orderObj) {
            $this->ajaxReturn(['status'=>-1,'msg'=>'订单不存在','result'=>'']);
        }
        //转为数字，并获取订单状态，订单状态显示按钮，订单商品
        if ($orderObj->order_prom_type) {//虚拟订单
            $order_info = $orderObj->append(['order_status_detail','virtual_order_button','order_goods','store'])->toArray();
            $order_info['order_button'] = $order_info['virtual_order_button'] ;
        } else {
            $order_info = $orderObj->append(['order_status_detail','order_button','order_goods','store'])->toArray();
        }
  
        $invoice_no = M('DeliveryDoc')->where("order_id" , $order_info['order_id'])->getField('invoice_no',true);
        $order_info['invoice_no'] = implode(' , ', $invoice_no);
        // 获取 最新的 一次发货时间
        $order_info['shipping_time'] = M('DeliveryDoc')->where("order_id" , $order_info['order_id'])->order('id desc')->getField('create_time');        
        
        //虚拟订单兑换码
        if ($order_info['pay_status'] == 1 && $order_info['order_status'] != 3 && $order_info['order_prom_type'] == 5) {
            $vrorder = M('vr_order_code')->field('vr_state,vr_code,vr_indate,vr_usetime,refund_lock')->where(['order_id'=>$id])->select();
        }
        $order_info['vrorder'] = $vrorder ?: [];
        
        //订单收货地址
        $order_info['total_address'] = getTotalAddress($order_info['province'], $order_info['city'], $order_info['district'], $order_info['twon'], $order_info['address']);

        //返回商品规格组合id(item_id)
        foreach ($order_info['order_goods'] as &$v){
            if($v['spec_key']){
                $item_id = M("SpecGoodsPrice")->where(['key' => $v['spec_key'],'goods_id'=>$v['goods_id']])->getField('item_id');
            }
            $v['item_id'] = empty($item_id) ? 0 : $item_id;
        }
        
        /**************@wroteby jackcsm 2018 4 24***************/

        //获取这个订单的商品
        $order_info['new_goods_list'] = \think\Db::name("order_goods")->where("order_id",$order_info['order_id'])->select();
        $orderGoodsIdArr = [];
        foreach ($order_info['new_goods_list'] as $k=>$v){
            $orderGoodsIdArr[$v['goods_id']] = $v['goods_id'];
        }

        $order_info['img'] = $this->goodsimg($orderGoodsIdArr);
       
        /*****************************/
     
        $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result'=>$order_info]);
    }
    
    public function goodsimg($orderGoodsIdArr)
    {
        $a = \think\Db::name("goods")->field("goods_id,original_img")->whereIn("goods_id",$orderGoodsIdArr)->select();
        $b = [];
        foreach ($a as $key=>$v){
            $b[$v['goods_id']] = $v['original_img'];
        }
        return $b;
    }
    
    /*
     * 取消订单
     */
    public function cancel_order(){
        $id = I('get.id');
        //检查是否有积分，余额支付
        $logic = new OrderLogic();
        $data = $logic->cancel_order($this->user_id,$id);
        if($data['status'] < 0)
            //$this->error($data['msg']);
            $this->ajaxReturn($data);
        //$this->success($data['msg']);
        $this->ajaxReturn($data);
    }

    public function refund_order()
    {
        $order_id   = input('post.order_id', 0);
//        $user_note  = input('post.user_note', '');
//        $consignee  = input('post.consignee', '');
//        $mobile     = input('post.mobile', '');
        
        $user_note = '用户取消订单';
        $consignee = $this->user['nickname'];
        $mobile    = $this->user['mobile'];
        
        $logic = new \app\common\logic\OrderLogic;
        $return = $logic->recordRefundOrder($this->user_id, $order_id, $user_note, $consignee, $mobile);
        
        $this->ajaxReturn($return);
    }
    
    /**
     *  点赞
     * @author dyr
     */
    public function ajaxZan()
    {
        $comment_id = I('post.comment_id/d');
        $user_id = $this->user_id;
        $comment_info = M('comment')->where(array('comment_id' => $comment_id))->find();
        $comment_user_id_array = explode(',', $comment_info['zan_userid']);
        if (in_array($user_id, $comment_user_id_array)) {
            $result['success'] = 0;
        } else {
            array_push($comment_user_id_array, $user_id);
            $comment_user_id_string = implode(',', $comment_user_id_array);
            $comment_data['zan_num'] = $comment_info['zan_num'] + 1;
            $comment_data['zan_userid'] = $comment_user_id_string;
            M('comment')->where(array('comment_id' => $comment_id))->save($comment_data);
            $result['success'] = 1;
        }
        exit(json_encode($result));
    }

    /**
     * 添加回复
     * @author dyr
     */
    public function reply_add()
    {
        $comment_id = I('post.comment_id/d');
        $reply_id = I('post.reply_id/d', 0);
        $content = I('post.content');
        $to_name = I('post.to_name', '');
        $goods_id = I('post.goods_id/d');
        $reply_data = array(
            'comment_id' => $comment_id,
            'parent_id' => $reply_id,
            'content' => $content,
            'user_name' => $this->user['nickname'],
            'to_name' => $to_name,
            'reply_time' => time()
        );
        $where = array('o.user_id' => $this->user_id, 'og.goods_id' => $goods_id, 'o.pay_status' => 1);
        $user_goods_count = Db::name('order')
            ->alias('o')
            ->join('__ORDER_GOODS__ og','o.order_id = og.order_id', 'LEFT')
            ->where($where)
            ->count();
        if ($user_goods_count > 0) {
            M('reply')->add($reply_data);
            M('comment')->where(array('comment_id' => $comment_id))->setInc('reply_num');
            $json['success'] = true;
        } else {
            $json['success'] = false;
            $json['msg'] = '只有购买过该商品才能进行评价';
        }
        $this->ajaxReturn($json);
    }
    
    //确认收货
    //传递id 订单id
    public function order_confirm()
    {
    	$id = I('id/d', 0);
    	$data = confirm_order($id, $this->user_id);
    	if($this->request->param("isajax")){
    	    $this->ajaxReturn($data);
    	}
    	if (!$data['status'])
    		$this->error($data['msg']);
    	else
    		$this->success($data['msg']);
    }
    
    public function return_goods_index()
    {
        $sale_t = I('sale_t/i',0);
        $keywords = I('keywords');
        
        $logic = new OrderLogic;
        $data = $logic->getReturnGoodsIndex($sale_t, $keywords, $this->user_id);
        
    	$this->assign('order_list', $data['order_list']);
    	$this->assign('page', $data['page']);
        $this->assign('keywords', $keywords);
        
        if (I('get.is_ajax', 0)) {
            return $this->fetch('ajax_return_goods_index');
        }
    	return $this->fetch();
    }
    
    /**
     * 申请退货的数据
     */
    public function return_goods_data()
    {
        $rec_id = I('rec_id',0);
        if (empty($rec_id)) {
            $this->ajaxReturn(['status' => -1, 'msg' => '参数错误']);
        }

        $order_goods = M('order_goods')->alias('g')
                ->field('g.goods_id,g.goods_name,g.goods_price,g.goods_num,g.spec_key,g.order_id,o.order_sn,s.store_qq')
                ->join('__ORDER__ o', 'g.order_id=o.order_id')
                ->join('__STORE__ s', 's.store_id=o.store_id', 'LEFT')
                ->where('rec_id', $rec_id)->find();
        if (!$order_goods) {
            $this->ajaxReturn(['status' => -1, 'msg' => '订单不存在']);
        }

        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $order_goods]); 
    }
    
    /**
     * 申请退货
     */
    public function return_goods()
    {
    	$rec_id = I('rec_id/d',0);
    	$order_id = I('order_id/d',0);
    	$goods_id = I('goods_id/d',0);
    	$spec_key = I('spec_key','');
    	
    	//must verify 
    	empty($rec_id)&&$this->ajaxReturn(['status' =>-1, 'msg' => "订单商品rec_id未传递"]);
    	empty($order_id)&&$this->ajaxReturn(['status' =>-1, 'msg' => "订单id未传递"]);
    	empty($goods_id)&&$this->ajaxReturn(['status' =>-1, 'msg' => "订单商品id未传递"]);
    	$type = I("is_ajax","0");
    	//判断是否重复提交申请售后
    	if($order_id && $goods_id){
    	    $return_goods = M('return_goods')
    	    ->where(['order_id'=>$order_id,'goods_id'=>$goods_id,'spec_key'=>$spec_key])
    	    ->where('status','in','0,1')->find();
    	    !empty($return_goods) && $this->ajaxReturn(array('status'=>-1,'msg'=>'已经在申请退货中','result'=>''));
    	}
      
    	$return_goods = M('return_goods')->where(array('rec_id'=>$rec_id))->find();
    	$order_goods = M('order_goods')->where(array('rec_id'=>$rec_id))->find();
    	$order = M('order')->where(array('order_id'=>$order_goods['order_id'],'user_id'=>$this->user_id))->find();
    	 
    	if(!$order){
    	    $this->ajaxReturn(['status' => -1, 'msg' => "参数[$rec_id]无效", 'result' => '']);
    	}
    	   
    	
    	if(IS_POST&&$type){
    		$model = new OrderLogic();
    		$res = $model->addReturnGoods($rec_id,$order);  //申请售后
    		$this->ajaxReturn($res);
    	}
    	$confirm_time_config = tpCache('shopping.auto_service_date');
    	$confirm_time = $confirm_time_config * 24 * 60 * 60;
    	if ((time() - $order['confirm_time']) > $confirm_time && !empty($order['confirm_time'])) {
    	    $this->ajaxReturn(['status' => -1, 'msg' => '已经超过' . $confirm_time_config . "天内退货时间" , 'result' => '']);
    	}
    	//店铺信息
    	$store = M('store')->where(array('store_id'=>$order['store_id']))->find();
    	$map['id'] = array('in',array($store['province_id'],$store['city_id'],$store['district']));
    	$region = M('region')->where($map)->cache(7200)->getField('id,name');
    	 
    	$this->ajaxReturn(['status' => 1, 'msg' => "", 'result' => array(
    	    'goods_id'=>$order_goods['goods_id'],
    	    'goods_name'=>$order_goods['goods_name'],
    	    'goods_price' => $order_goods['goods_price'],
    	    'goods_num' => $order_goods['goods_num'],
    	    'spec_key' => $order_goods['spec_key'],
    	    'spec_key_name' => $order_goods['spec_key_name'],
    	    'order_id' => $order['order_id'],
    	    'order_sn' => $order['order_sn'],
    	    'store_name'=> $store['store_name'],
    	    'store_address'=>$region[$store['province_id']].$region[$store['city_id']].$region[$store['district']].$store['store_address'],
    	    'service_phone'=>$store['store_phone'], //客服电话
            'return_method' =>['仅退款','退货退款','换货','维修'],
    	    'store'=>$store,
    	    'goods_info'=>\think\Db::name("goods")->where("goods_id",$order_goods['goods_id'])->find(),
    	    'order_state'=>\think\Db::name("order")->where("order_id",$order_goods['order_id'])->value("shipping_status")
    	)]);
        }
        
        //批量性申请退款数据
        /**
         * 申请退货
         */
        public function getReturngoodslist()
        {
            /*$rec_id = I('rec_id/d',0);
            $order_id = I('order_id/d',0);
            $goods_id = I('goods_id/d',0);
            $spec_key = I('spec_key','');
             
             */
            
            $spec_key = I('spec_key','');
            $Recid = [];
            $OrderId = [];
            $GoodsId = [];
            $orderInfo = \think\Db::name("order_goods")->where("order_id",$this->request->param("order_id"))->find();
            foreach ($orderInfo as $k=>$v){
                $Recid[$v['rec_id']] = $v['rec_id'];
                $OrderId[$v['rec_id']] = $v['order_id'];
                $GoodsId[$v['rec_id']] = $v['goods_id'];
            }
            
            foreach ($Recid as $k=>$v){
                
                        $type = I("is_ajax","0");
                        //判断是否重复提交申请售后
                        if($OrderId[$k] && $GoodsId[$k]){
                            $return_goods = M('return_goods')
                            ->where(['order_id'=>$OrderId[$k],'goods_id'=>$GoodsId[$k],'spec_key'=>$spec_key])
                            ->where('status','in','0,1')->find();
                            !empty($return_goods) && $this->ajaxReturn(array('status'=>-1,'msg'=>'已经在申请退货中','result'=>''));
                        }
                    
                        $return_goods = M('return_goods')->where(array('rec_id'=>$Recid[$k]))->find();
                        $order_goods = M('order_goods')->where(array('rec_id'=>$Recid[$k]))->find();
                        $order = M('order')->where(array('order_id'=>$order_goods['order_id'],'user_id'=>$this->user_id))->find();
                    
                        if(!$order){
                            $this->ajaxReturn(['status' => -1, 'msg' => "参数[$Recid[$k]]无效", 'result' => '']);
                        }
                    
                       
                        $confirm_time_config = tpCache('shopping.auto_service_date');
                        $confirm_time = $confirm_time_config * 24 * 60 * 60;
                        if ((time() - $order['confirm_time']) > $confirm_time && !empty($order['confirm_time'])) {
                            $this->ajaxReturn(['status' => -1, 'msg' => '已经超过' . $confirm_time_config . "天内退货时间" , 'result' => '']);
                        }
                        
                        //店铺信息
                        $store = M('store')->where(array('store_id'=>$order['store_id']))->find();
                        $map['id'] = array('in',array($store['province_id'],$store['city_id'],$store['district']));
                        $region = M('region')->where($map)->cache(7200)->getField('id,name');
                    
                        $rec_order = [
                            'goods_id'=>$order_goods['goods_id'],
                            'goods_name'=>$order_goods['goods_name'],
                            'goods_price' => $order_goods['goods_price'],
                            'goods_num' => $order_goods['goods_num'],
                            'spec_key' => $order_goods['spec_key'],
                            'spec_key_name' => $order_goods['spec_key_name'],
                            'order_id' => $order['order_id'],
                            'order_sn' => $order['order_sn'],
                            'store_name'=> $store['store_name'],
                            'store_address'=>$region[$store['province_id']].$region[$store['city_id']].$region[$store['district']].$store['store_address'],
                            'service_phone'=>$store['store_phone'], //客服电话
                            'return_method' =>['仅退款','退货退款'],
                            'store'=>$store,
                            'goods_info'=>\think\Db::name("goods")->where("goods_id",$order_goods['goods_id'])->find(),
                            'order_state'=>\think\Db::name("order")->where("order_id",$order_goods['order_id'])->value("shipping_status")
                        ];
                        
                      $ReclistOrder['list'][] = $rec_order;
            }
            
            $this->ajaxReturn(['status' => 1, 'msg' => "获取成功", 'result' =>$ReclistOrder]);
        }
        
    //批量退款额外添加
    //@wroteby jackcsm
    
    public function return_listgoods()
    {
        $order = \think\Db::name("order_goods")->where("order_id",$this->request->param("order_id"))->find();
        $Recid = [];
        $goodsId = [];
        $OrderId = [];
        $goodsNum =[];
        
        foreach($order as $k=>$v){
            $Recid[$v['rec_id']] = $v['rec_id'];
            $goodsId[$v['rec_id']] = $v['goods_id'];
            $OrderId[$v['rec_id']] = $v['order_id'];
            $goodsNum[$v['rec_id']] = $v['goods_num'];
        }
        //退款类型
        $type   = $this->request->param("type");
        $reason = $this->request->param("reason");
        $describe = $this->request->param("describe");
        $imgs     = $this->request->param("imgs");
        //$order_sn = \think\Db::name("order")->where("order_id",$this->request->param("order_id"))->value("order_sn");
        $model = new OrderLogic();
        //退款的订单数据
        $order_info = M('order')->where(array('order_id'=>$this->request->param("order_id"),'user_id'=>$this->user_id))->find();
        
        foreach ($Recid as $k=>$v){
            
            $res = $model->addReturnGoodspatch($v,$order_info,[
                "rec_id"=>$v,
                "order_id"=>$OrderId[$k],
                "goods_id"=>$goodsId[$k],
                "type"=>$type,
                "reason"=>$reason,
                "describe"=>$describe,
                "imgs"=>$imgs,
                "order_sn"=>$order_info['order_sn'],
                "goods_num"=>$goodsNum[$k]
            ]);  
        }
        
        $this->ajaxReturn(['status' => 1, 'msg' => "批量退款成功"]);
    }
     
    /**
     * 退换货列表
     */
    public function return_goods_list()
    {   
        $is_json = I('is_json', 0);
        $keywords = I('keywords', '');
    	$addtime = I('addtime');
        $status = I('status', 0);
        
        $logic = new OrderLogic;
        $data = $logic->getReturnGoodsList($keywords, $addtime, $status,$this->user_id);
        
        if ($is_json) {
            $state = C('REFUND_STATUS');
            foreach ($data['return_list'] as $key => $val) {
                $data['return_list'][$key]['goods_name'] = $data['goodsList'][$val['goods_id']];
                $data['return_list'][$key]['status_name'] = $state[$val['status']];
            }
            $this->ajaxReturn(['status'=>1, 'msg'=>'获取成功', 'result'=>$this->getreturn_goodsinfo($data)]);
        }
        
        $this->assign('goodsList', $data['goodsList']);
    	$this->assign('return_list', $data['return_list']);
    	$this->assign('rtype',array('仅退款','退货退款','换货','维修'));
    	$this->assign('state',C('REFUND_STATUS'));
    	$this->assign('page', $data['page']);// 赋值分页输出
        $this->assign('keywords', $keywords);

        if (I('get.is_ajax', 0)) {
            return $this->fetch('ajax_return_goods_list');
        }
    	return $this->fetch();
    }
    
    //获取退款订单的商铺信息
    private function getreturn_goodsinfo($return_list)
    {
        $storeId = [];
        $goodsId = [];
        $orderId = [];
        foreach ($return_list['return_list'] as $k=>$v){
            $storeId[] = $v['store_id'];
            $goodsId[] = $v['goods_id'];
            $orderId[] = $v['order_id'];
        }
        
        $storeInfo = \think\Db::name("store")->whereIn("store_id",$storeId)->select();
        $goodsinfo = \think\Db::name("goods")->whereIn("goods_id",$goodsId)->select();
        $orderInfo = \think\Db::name("order")->whereIn("order_id",$orderId)->select();
        
        $store =[];
        $goods = [];
        $order = [];
        foreach ($storeInfo as $k=>$v){
            $store[$v['store_id']] = $v;
        }
        foreach ($goodsinfo as $k=>$v){
            $goods[$v['goods_id']] = $v;
        }
        foreach ($orderInfo as $k=>$v){
            $order[$v['order_id']] = $v;
        }
        foreach ($return_list['return_list'] as $k=>$v){
            $return_list['return_list'][$k]['storeinfo'] = $store[$v['store_id']];
            $return_list['return_list'][$k]['goodsinfo'] = $goods[$v['goods_id']];
            $return_list['return_list'][$k]['orderinfo'] = $order[$v['order_id']];
        }
        unset($return_list['goodsList']);
        unset($return_list['page']);
        return $return_list['return_list'];
    }
    /**
     *  退货详情
     */
    public function return_goods_info()
    {
        $is_json = I('is_json');
        $id = I('id/d',0);
        $user_id = $this->user_id;
        $return_goods = M('return_goods')->where(['id' => $id,'user_id'=>$user_id])->find();
        if (empty($return_goods)) {
            if ($is_json) {
                $this->ajaxReturn(['status' => -1, 'msg' => '参数错误']);
            }
            $this->error('参数错误');
        }
        
//        if(IS_POST){
//            $data = I('post.');
//            $data['delivery'] = serialize($data['delivery']);
//            $data['status'] = 2;
//            M('return_goods')->where(['id'=>$data['id'],'user_id'=>$user_id])->save($data);
//            $this->success('发货提交成功');
//        }
        
        if ($return_goods['imgs']) {
            $return_goods['imgs'] = explode(',', $return_goods['imgs']);
        }
        if ($return_goods['seller_delivery']) {
            $return_goods['seller_delivery'] = unserialize($return_goods['seller_delivery']);
        }
        if ($return_goods['delivery']) {
            $return_goods['delivery'] = unserialize($return_goods['delivery']);
        }
        $goods = M('goods')->where("goods_id = {$return_goods['goods_id']} ")->find();
        $store = M('store')->where(array('store_id'=>$return_goods['store_id']))->find();
        
        //若是json请求
        if (I('is_json')) {
            $state = C('REFUND_STATUS');
            $return_goods['status_name'] = $state[$return_goods['status']];
            $return_goods['store_name'] = $store['store_name'];
            $this->ajaxReturn(['status' => 1, 'msg' => '获取成功',
                'result' => [
                    'return_goods' => $return_goods,
                    'goods' => $goods,
                    'shoplogo'=>$store['store_logo'],
                    'return_method' => ['仅退款','退货退款','换货','维修']
                ]
            ]);
        }
        
        $this->assign('goods',$goods);
        $this->assign('return_goods',$return_goods);
        if($store['district']){
            $region = M('region')->where("id in({$store['province_id']},{$store['city_id']},{$store['district']})")->getField('id,name');
            $store['store_address'] = $region[$store['province_id']].$region[$store['city_id']].$region[$store['district']].$store['store_address'];
        }
        $this->assign('store',$store);
        return $this->fetch();
    }
    
    public function return_goods_refund()
    {
    	$order_sn = I('order_sn');
    	$where = array('user_id'=>$this->user_id);
    	if($order_sn){
    		$where['order_sn'] = $order_sn;
    	}
    	$where['status'] = 5;
    	$count = M('return_goods')->where($where)->count();
    	$page = new Page($count,10);
    	$list = M('return_goods')->where($where)->order("id desc")->limit($page->firstRow, $page->listRows)->select();
    	$goods_id_arr = get_arr_column($list, 'goods_id');
    	if(!empty($goods_id_arr))
    		$goodsList = M('goods')->where("goods_id in (".  implode(',',$goods_id_arr).")")->getField('goods_id,goods_name');
    	$this->assign('goodsList', $goodsList);
    	$state = C('REFUND_STATUS');
    	$this->assign('list', $list);
    	$this->assign('state',$state);
    	$this->assign('page', $page->show());// 赋值分页输出
    	return $this->fetch();
    }
    
    public function return_goods_cancel()
    {
        $id = I('id',0);
        $is_json = I('is_json', 0);
        $return_goods = M('return_goods')->where(array('id'=>$id, 'user_id'=>$this->user_id))->find();
        if (empty($return_goods)) {
            if ($is_json) {
                $this->ajaxReturn(['status' => -1, 'msg' => '参数错误']);
            }
            $this->error('参数错误');
        }
        
        M('return_goods')->where(array('id'=>$id))->save(array('status'=>-2,'canceltime'=>time()));
        if ($is_json) {
            $this->ajaxReturn(['status' => 1, 'msg' => '取消成功']);
        }
        $this->success('取消成功',U('order/return_goods_list'));  
    }
    
    public function dispute(){
    	$condition['user_id'] = $this->user_id;
    	$condition['pay_status'] = 1;
        $count = M('order')->where($condition)->count();
        $Page  = new Page($count,5);
        $show = $Page->show();
        $order_str = "order_id DESC";
        $order_list = M('order')->order('order_id desc')->where($condition)->limit($Page->firstRow.','.$Page->listRows)->select();
        //获取订单商品
        foreach($order_list as $k=>$v)
        {
        	$order_list[$k] = set_btn_order_status($v);  // 添加属性  包括按钮显示属性 和 订单状态显示属性
        	//$order_list[$k]['total_fee'] = $v['goods_amount'] + $v['shipping_fee'] - $v['integral_money'] -$v['bonus'] - $v['discount']; //订单总额
            $order_list[$k]['goods_list'] =  M('order_goods')->where('order_id', $v['order_id'])->find();
        }
        $store_id_list = get_arr_column($order_list, 'store_id');
        if(!empty($store_id_list))
        	$store_list = M('store')->where("store_id in (".  implode(',', $store_id_list).")")->getField('store_id,store_name,store_qq');
        $this->assign('store_list',$store_list);
        $this->assign('order_list',$order_list);
        return $this->fetch();
    }

    public function dispute_list(){
        $complain_time_out = input('complain_time_out');
        $complain_state_type = input('complain_state_type');
        $where = array('user_id'=>$this->user_id);
        $three_months_ago = strtotime(date("Y-m-d", strtotime("-3 months",  strtotime(date("Y-m-d",time())))));
        if(empty($complain_time_out)){
            //三个月内纠纷单
            $where['complain_time'] = ['>',$three_months_ago];
        }
        if($complain_time_out){
            //三个月前纠纷单
            $where['complain_time'] = ['<',$three_months_ago];
        }
        if($complain_state_type == 1){
            //处理中
            $where['complain_state'] = ['<',4];
        }
        if($complain_state_type == 2){
            //已完成
            $where['complain_state'] = 4;
        }
        $count = M('complain')->where($where)->count();
        $page = new Page($count,10);
        $list = M('complain')->where($where)->order("complain_id desc")->limit($page->firstRow, $page->listRows)->select();
        $complain_state = array(1=>'待处理',2=>'对话中',3=>'待仲裁',4=>'已完成');
        if(!empty($list)){
            foreach ($list as $k=>$val){
                $list[$k]['complain_state'] = $complain_state[$val['complain_state']];
                if($val['complain_pic']){
                    $list[$k]['complain_pic'] = unserialize($val['complain_pic'])[0];
                }
            }
        }
        $goods_id_arr = get_arr_column($list, 'order_goods_id');
        if(!empty($goods_id_arr)){
            $goodsList = M('goods')->where("goods_id in (".  implode(',',$goods_id_arr).")")->getField('goods_id,goods_name');
            $this->assign('goodsList', $goodsList);
        }
        if(!empty($goods_id_arr)){
            $goodsList = M('goods')->where("goods_id", "in", implode(',', $goods_id_arr))->getField('goods_id,goods_name');
            $this->assign('goodsList', $goodsList);
        }
        $this->assign('list', $list);
        $this->assign('page', $page->show());
        return $this->fetch();
    }
    
    public function dispute_apply(){
    	if(IS_POST){
    		$data = I('post.');
    		$order = Db::name('order')->where(array('order_id'=>$data['order_id']))->find();
    		if($order['store_id'] != $data['store_id'] || $order['user_id'] != $this->user_id){
    			$this->error('严禁非法提交数据');
    		}
    		$complain = M('complain')->where(array('order_id'=>$data['order_id'],'user_id'=>$this->user_id,'order_goods_id'=>$data['order_goods_id']))->find();
    		if($complain) $this->error('此服务单您已申请过交易投诉');
			if(!empty($data['complain_pic'])){
				$data['complain_pic'] = serialize($data['complain_pic']);
			}
			$complain_subject = M('complain_subject')->where(array('subject_id'=>$data['complain_subject_id']))->find();
			$data['complain_subject_name'] = $complain_subject['subject_name'];
			$data['user_id'] = $this->user_id;
			$data['user_name'] = $this->user['nickname'];
			$data['complain_time'] = time();
			if(M('complain')->add($data)){
				$this->success('投诉成功',U('Order/dispute_list'));
			}else{
				$this->error('投诉失败，请联系平台客服',U('Order/dispute'));
			}
    	}
    	$order_id = I('order_id');
    	$order = M('order')->where(array('order_id'=>$order_id,'user_id'=>$this->user_id))->find();
    	$order_goods = M('order_goods')->where(array('order_id'=>$order_id))->select();
    	$this->assign('order',$order);
    	$this->assign('order_goods',$order_goods);
    	$complain_subject = M('complain_subject')->where(array('subject_state'=>1))->select();
    	$this->assign('complain_subject',$complain_subject);
    	$store = M('store')->where(array('store_id'=>$order['store_id']))->find();
    	$this->assign('store',$store);
    	return $this->fetch();
    }
    
    public function checkType(){
    	$order_id = I('order_id/d');
    	$complain_subject_id = I('complain_subject_id/d');
    	if($order_id && $complain_subject_id){
    		$orderLogic = new OrderLogic();
    		$res = $orderLogic->check_dispute_order($order_id, $complain_subject_id,$this->user_id);
    		exit(json_encode($res));
    	}else{
    		exit(json_encode("参数错误，非法操作"));
    	}
    }

    public function dispute_info(){
    	$complain_id = I('complain_id/d');
    	$complain = M('complain')->where(array('complain_id'=>$complain_id,'user_id'=>$this->user_id))->find();
    	if($complain){
    		if(!empty($complain['complain_pic'])){
    			$complain['complain_pic'] = unserialize($complain['complain_pic']);
    		}
    		if(!empty($complain['appeal_pic'])){
    			$complain['appeal_pic'] = unserialize($complain['appeal_pic']);
    		}
    	}else{
    		$this->error("您的投诉单不存在");
    	}
    	$order = M('order')->where(array('order_id'=>$complain['order_id']))->find();
    	$order_goods = M('order_goods')->where(array('order_id'=>$complain['order_id'],'goods_id'=>$complain['order_goods_id']))->find();
    	$this->assign('complain',$complain);
    	$this->assign('order',$order);
    	$this->assign('order_goods',$order_goods);
    	$complain_state = array(1=>'待卖家处理',2=>'待客户确认',3=>'待管理员仲裁',4=>'已关闭完成');
    	$this->assign('state',$complain_state);
    	return $this->fetch();
    }

    public function get_complain_talk(){
    	$complain_id = I('complain_id/d');
    	$complain_info = M('complain')->where(array('complain_id'=>$complain_id,'user_id'=>$this->user_id))->find();
    	$talkhtml = '';
    	if(!$complain_info){
    		$talkhtml = '';
    	}else{
    		$complain_info['member_status'] = 'accused';
    		$complain_talk_list = M('complain_talk')->where(array('complain_id'=>$complain_id))->order('talk_id asc')->select();
    		if(!empty($complain_talk_list)){
    			foreach($complain_talk_list as $i=>$talk) {
    				$talk_time = date("Y-m-d H:i:s",$talk['talk_time']);
    				$myself_right = '';
    				$talker_name = $talk['talk_member_name'];
    				$path = C('view_replace_str.__STATIC__');
    				switch($talk['talk_member_type']){
    					case 'accuser':
    						$talker = '我';
    						$talker_pic = empty($this->user['head_pic']) ? $path.'/images/peri.jpg' : $this->user['head_pic'] ;
    						$myself_right = 'myself_right';
    						break;
    					case 'accused':
    						$talker = '卖家';
    						$talker_pic = $path.'/images/oppositehead.png';
    						break;
    					case 'admin':
    						$talker = '管理员';
    						$talker_pic = $path.'/images/pers.png';
    						break;
    				}
    				if(intval($talk['talk_state']) === 2) {
    					$talk['talk_content'] = '<该对话被管理员屏蔽>';
    				}
    				$talkhtml .= '<div class="opposite_left '.$myself_right.' p">
	    			<div class="sales_head p"><div class="sales_head_logo">
	    				<img class="" src="'.$talker_pic.'">
	    			</div>
	    			<div class="explay_sales_head">
	    			<i></i>
	    			<span class="sales_manage">'.$talker.'</span>
	    			<span class="store_name">'.$talker_name.'&nbsp;&nbsp;'.$talk_time.'</span>
	    			</div></div>
	    			<div class="myself_head">'.$talk['talk_content'].'</div></div>';
    			}
    		}
    	}

    	echo json_encode($talkhtml);
    }
    
    public function publish_complain_talk(){
    	$complain_id = I('complain_id/d');
    	$complain_talk = trim(I('complain_talk'));
    	$complain_info = M('complain')->where(array('complain_id'=>$complain_id,'user_id'=>$this->user_id))->find();
    	$complain_state = intval($complain_info['complain_state']);
    	if(is_array($complain_info) && $complain_state==2){
    		$talk_len = strlen($complain_talk);
    		if($talk_len>0 && $talk_len<255){
    			$param = array();
    			$param['complain_id'] = $complain_id;
    			$param['talk_member_id'] = $this->user_id;
    			$param['talk_member_name'] = $this->user['nickname'];
    			$param['talk_member_type'] = 'accuser';
    			$param['talk_content'] = $complain_talk;
    			$param['talk_state'] = 1;
    			$param['talk_admin'] = 0;
    			$param['talk_time'] = time();
    			if(M('complain_talk')->add($param)){
    				echo json_encode('success');
    			}else{
    				echo json_encode('error2');
    			}
    		}else{
    			echo json_encode('error1');
    		}
    	}else{
    		echo json_encode('error');
    	}
    }
    
    public function complain_handle(){
    	$complain_id = I('complain_id/d');
    	$complain_state = I('state/d');
    	$complain_info = M('complain')->where(array('complain_id'=>$complain_id,'user_id'=>$this->user_id))->find();
    	if($complain_info){
    		$updata['complain_state'] = $complain_state;
    		if($complain_state == 3){
    			M('return_goods')->where(array('user_id'=>$this->user_id,'order_id'=>$complain_info['order_id']))->save(array('status'=>6));
    			$updata['user_handle_time'] = time();
    		}else{
    			$updata['final_handle_time'] = time();
    			$updata['final_handle_msg'] = '用户提交问题已解决';
    		}
    		M('complain')->where(array('complain_id'=>$complain_id,'user_id'=>$this->user_id))->save($updata);
    		$this->success('操作成功',U('Order/dispute_list'));exit;
    	}else{
    		$this->error('操作失败，请联系平台客服');
    	}
    }
    
    public function expose(){
    	if(IS_POST){
    		$data = I('post.');
    		if(!empty($data['expose_pic'])){
    			$data['expose_pic'] = serialize($data['expose_pic']);
    		}
    		$data['expose_user_id'] = $this->user_id;
    		$data['expose_user_name'] = empty($this->user['nickname']) ? $this->user['mobile'] : $this->user['nickname'];
    		$data['expose_time'] = time();
    		if(M('expose')->where(array('expose_user_id'=>$this->user_id,'expose_goods_id'=>$data['expose_goods_id']))->count()>0){
    			$this->error('该商品您已举报过，请不要重复提交');
    		}else{
    			M('expose')->add($data);
    			$this->success('举报成功',U('Order/expose_list'));exit;
    		}
    	}
    	$goods_id = I('goods_id/d');
    	$goods = M('goods')->where(array('goods_id'=>$goods_id))->find();
    	if($goods){
    		$store = M('store')->where(array('store_id'=>$goods['store_id']))->find();
    		$expose_type = M('expose_type')->cache(true)->select();
    		$goods['category'] = M('goods_category')->where(array('id'=>$goods['cat_id3']))->getField('name');
    		$this->assign('goods',$goods);
    		$this->assign('store',$store);
    		$this->assign('expose_type',$expose_type);
    		return $this->fetch();
    	}else{
    		$this->error('参数错误');
    	}
    }
    
    public function expose_list(){
    	$where = array('expose_user_id'=>$this->user_id);
    	$count = M('expose')->where($where)->count();
    	$page = new Page($count,10);
    	$expose_list = M('expose')->where($where)->order("expose_id desc")->limit($page->firstRow, $page->listRows)->select();
    	$this->assign('expose_list', $expose_list);
    	$this->assign('page', $page->show());
    	return $this->fetch();
    }
    
    public function expose_info(){
    	$expose_id = I('expose_id/d');
    	$expose = M('expose')->where(array('expose_id'=>$expose_id,'expose_user_id'=>$this->user_id))->find();
    	if(!$expose){
    		$this->error('该举报不存在');
    	}
    	if(!empty($expose['expose_pic'])){
    		$expose['expose_pic'] = unserialize($expose['expose_pic']);
    	}
    	$store = M('store')->where(array('store_id'=>$expose['expose_store_id']))->find();
    	$this->assign('store',$store);
    	$this->assign('expose',$expose);
    	return $this->fetch();
    }
    
    public function get_expose_subject(){
    	$expose_type_id = I('expose_type_id/d');
    	$expose_subject = M('expose_subject')->where(array('expose_subject_type_id'=>$expose_type_id))->select();
    	$subject = '';
    	if(empty($expose_subject)){
    		$subject = '<txt style="position: absolute; z-index: 2; line-height: 1; margin-left: 11px; margin-top: 11px; font-size: 13.3333px; font-family: monospace; color: rgb(205, 205, 205); display: inline;"></txt>
    				<textarea name="expose_content" id="note" cols="30" rows="10" style="border: 1px solid #E6E6E6;width: 935px; height: 144px;margin-bottom: 8px;padding: 5px;" placeholder="请填写您认为该商品存在价格违规现象的理由"></textarea>
    				<div class="msg-care">(注意：被举报人能且只能看到此框中的内容，请您注意不要在此框填写会员名、订单号、运单号等任何可能泄露身份的信息)</div>';
    	}else{
    		$subject .= '<ul class="re-jbtype-box re-jbtype-s01">';
    		foreach ($expose_subject as $val){
    			$subject .='<li class="li-item" onclick="subject_onclick(this)" data-type="'.$val['expose_subject_id'].'">'.$val['expose_subject_content'].'<s class="icon-on"></s></li>';
    		}
    		$subject .= '</ul>';
    	}
    	exit($subject);
    }
    
    /**
     * 上传退换货图片，兼容小程序
     */
    public function upload_return_goods_img()
    {
        $logic = new \app\common\logic\OrderLogic;
        $return = $logic->uploadReturnGoodsImg();
        $this->ajaxReturn($return);
    }

    //提醒商家快到达结束时间
    public function crowd_remind(){

        //查出所有众筹商品
        $list = D('Goods')->where(array('is_crowd_goods'=>'1','is_on_sale'=>'1','remind'=>'0'))->select();
        foreach ($list as $key => $val) {
            $time = $val['crowd_end'] - time();
            if($time <='259200'){
                //查出订单中的商品总金额
                $goods = D('OrderGoods')->where(['goods_id'=>$val['goods_id']])->select();
                $money = 0;
                foreach ($goods as $k => $v) {
                    $order = D('Order')->where(['order_id'=>$v['order_id']])->find();
                    ($order['pay_status'] =='1' && $order['order_status'] =='0') && $money += $order['order_amount'];
                }

                if($money < $val['crowdfunding_money']){
                    $phone = D('Store')->where(['store_id'=>$val['store_id']])->getField('store_phone');
                    //给商家发短信
                    $msg = '您发布的众筹'.$val['goods_name'].'即将结束，还没有达到众筹目标，请及时处理或延期。';
                    $this->send_phone_code('13656214541',$msg);
                } 
            }
        }
    }

    //众筹提醒
    public function crowdgoods_notice()
    {
        //查出所有众筹商品　已结束的众筹商品
        $list = D('Goods')->where(array('is_crowd_goods'=>'1','is_on_sale'=>'1','remind'=>'0'))->select();
        $storelist = Db::name("store")->field("store_id,store_phone")->select();
        $storePhone = [];
        foreach ($storelist as $k=>$v){
            $storePhone[$v['store_id']] = $v['store_phone'];
        }
        $goodsId = [];
        $goodsInfo = [];
        $storeGoods = [];
        $goodsName = [];
        $goodsCrowdTime = [];
        foreach ($list as $k=>$v){
            $goodsId[]                     = $v['goods_id'];
            $goodsInfo[$v['goods_id']]     = $v['crowdfunding_money'];
            $storeGoods[$v['goods_id']]    = $v['store_id'];
            $goodsName[$v['goods_id']]     = $v['goods_name'];
            $goodsCrowdTime[$v['goods_id']]= $v['crowd_end'];
        }
        //获取已经支持的众筹商品
        $order_goods = Db::name("order_goods")->whereIn("goods_id",$goodsId)->select();
        $order_id = [];
        $orderIds = [];
        $crowdId  = [];
        
        $recid    = [];
       
        if($order_goods){
            //获取已经支持的众筹订单 此商品已经支持的众筹订单
            foreach ($order_goods as $k=>$v){
                $order_id[$v['goods_id']][] = $v['order_id'];
                $orderIds[]                 = $v['order_id'];
                $crowdId[$v['order_id']]    = $v['goods_id'];
                $recid[$v['goods_id']]      = $v['rec_id'];
             
            }
        }
        //获取已经支持众筹的数据
        $crowd_order = Db::name("order")->whereIn("order_id",$orderIds)->select();
        $crowd_order_goods = [];
        foreach ($crowd_order as $k=>$v){
            $crowd_order_goods[$crowdId[$v['order_id']]][] = $v;
        }
        foreach ($crowd_order_goods as $k=>$order){
            $crowd_money = [];
            foreach ($order as $kk=>$vv){
                if($vv['pay_status']==1&&($vv['order_status']==0||$vv['order_status']==1)){
                    $crowd_money[] = $vv['total_amount'];
                }
            }
            $crowd_diff_time = $goodsCrowdTime[$k]-time();
            if($crowd_diff_time>0&&$crowd_diff_time<='2592000'){//72小时 
                if($goodsInfo[$k]>array_sum($crowd_money)){//众筹金额未达到目标
                    //您在趣喝茶发起的${goods}即将结束，还没有达到${purpose}目标，请及时处理或延期。
                    $ret = sms_send($storePhone[$storeGoods[$k]],"SMS_136385115",[
                        "goods"=>"众筹{$goodsName[$k]}",
                        "purpose"=>"众筹"
                    ]);
                    
                    //已经发送则设置为已提醒
                    Db::name("goods")->where("goods_id",$k)->setField("remind",1);
                } 
            }
            
        }
        
    }

    //自动退款给用户
    public function tuikuan(){

        //查出所有众筹商品
        $list = D('Goods')->where(array('is_crowd_goods'=>'1','is_on_sale'=>'1','crowd_end'=>array('lt',time())))->select();
        foreach ($list as $key => $val) {
                //查出订单中的商品总金额
                $goods = D('OrderGoods')->where(['goods_id'=>$val['goods_id']])->select();
                $money = 0;
                foreach ($goods as $k => $v) {
                    $order = D('Order')->where(['order_id'=>$v['order_id'],'status'=>'1'])->find();
                    if($order['pay_status'] =='1' && $order['order_status'] =='0'){

                        D('Users')->where(['user_id'=>$order['user_id']])->setInc('user_money',$order['order_amount']);
                        D('Order')->where(['order_id'=>$order['order_id']])->save(array('pay_status'=>'3'));
                    }
                } 
            
        }
    }

    public function send_phone_code($mobile,$msg){
        $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
            $smsConf = array(
                'key'   => '399102f1109ffcd4b405650e074e4847', //您申请的APPKEY
                'mobile'    => $mobile, //接受短信的用户手机号码
                'tpl_id'    => '74139', //您申请的短信模板ID，根据实际情况修改
                'tpl_value' =>$msg, //您设置的模板变量，根据实际情况修改
                'dtype'=>'json'
            );
            $content = juhecurl($sendUrl,$smsConf,1); //请求发送短信
    }
    
    //众筹退款
    public function crowd_refund()
    {
        //查出所有众筹商品　已结束的众筹商品
        $list = D('Goods')->where(array('is_crowd_goods'=>'1','is_on_sale'=>'1','crowd_end'=>array('lt',time())))->select();
        $goodsId = [];
        $goodsInfo = [];
        foreach ($list as $k=>$v){
            $goodsId[] = $v['goods_id'];
            $goodsInfo[$v['goods_id']] = $v['crowdfunding_money'];
        }
        //获取已经支持的众筹商品
        $order_goods = Db::name("order_goods")->whereIn("goods_id",$goodsId)->select();
        $order_id = [];
        $orderIds = [];
        $crowdId  = [];
        
        $recid    = [];
        if($order_goods){
            //获取已经支持的众筹订单 此商品已经支持的众筹订单
            foreach ($order_goods as $k=>$v){
                $order_id[$v['goods_id']][] = $v['order_id'];
                $orderIds[]                 = $v['order_id'];
                $crowdId[$v['order_id']]    = $v['goods_id'];
                $recid[$v['goods_id']]      = $v['rec_id'];
            }
        }
        //获取已经支持众筹的数据
        $crowd_order = Db::name("order")->whereIn("order_id",$orderIds)->select();
        $crowd_order_goods = [];
        foreach ($crowd_order as $k=>$v){
            $crowd_order_goods[$crowdId[$v['order_id']]][] = $v;
        }
        //循环处理每个众筹商品所支持的众筹金额是否未达到众筹目标　　方可退款[退回余额]
        foreach ($crowd_order_goods as $k=>$order){
            $crowd_money = [];
            foreach ($order as $kk=>$vv){
                if($vv['pay_status']==1&&($vv['order_status']==0||$vv['order_status']==1)){
                    $crowd_money[] = $vv['total_amount'];
                }
            }
            //此商品的众筹目标是否未达到
            if(array_sum($crowd_money)>0){
                if($goodsInfo[$k]>array_sum($crowd_money)){
                    if(updateRefundCrowdGoods($recid[$k],1)){
                        echo '众筹退款ok';
                       
                        
                    };//退到会员账户余额
                }
            }else{
                echo 'goodsid='.$k.'没有众筹记录'.PHP_EOL;
            }
        }
        
    }
}