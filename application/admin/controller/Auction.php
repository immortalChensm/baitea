<?php
/**
 * tpshop
 * ============================================================================
 * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 商业用途务必到官方购买正版授权, 使用盗版将严厉追究您的法律责任。
 * ============================================================================
 * Author: 当燃
 * Date: 2015-09-09
 */
namespace app\admin\controller;
use app\admin\logic\OrderLogic;
use app\admin\model\OrderAction;
use think\AjaxPage;
use think\Db;
use think\Page;

class Auction extends Base {
    public  $order_status;
    public  $shipping_status;
    public  $pay_status;
    /*
     * 初始化操作
     */
    public function _initialize() {
        parent::_initialize();
        C('TOKEN_ON',false); // 关闭表单令牌验证
        // 订单 支付 发货状态
        $this->order_status = C('ORDER_STATUS');
        $this->pay_status = C('PAY_STATUS');
        $this->shipping_status = C('SHIPPING_STATUS');
        $this->assign('order_status',$this->order_status);
        $this->assign('pay_status',$this->pay_status);
        $this->assign('shipping_status',$this->shipping_status);
    }

    /*
     *订单首页
     */
    public function index(){
        $begin = date('Y-m-d', strtotime("-3 month"));//30天前
        $end = date('Y-m-d', strtotime('+1 days')); 	
    	$this->assign('timegap',$begin.'-'.$end);
    	//@new 新后台UI参数 @{
    	$this->assign('add_time_begin',date('Y-m-d', strtotime("-3 month")+86400));
    	$this->assign('add_time_end',date('Y-m-d', strtotime('+1 days')));
    	//}
        return $this->fetch();
    }

    /*
     *Ajax首页
     */
    public function ajaxindex(){
        $select_year = getTabByTime(I('add_time_begin')); // 表后缀
        $orderLogic = new OrderLogic();       
        $timegap = I('timegap');
        if($timegap){
        	$gap = explode('-', $timegap);
        	$begin = strtotime($gap[0]);
        	$end = strtotime($gap[1]);
        }else{
            //@new 新后台UI参数
            $begin = strtotime(I('add_time_begin'));
            $end = strtotime(I('add_time_end'));
        }
        // 搜索条件
        $condition = array();
        $keyType = I("keytype");
        $keywords = I('keywords','','trim');
    
        $consignee =  ($keyType && $keyType == 'consignee') ? $keywords : I('consignee','','trim');
        $consignee ? $condition['consignee'] = trim($consignee) : false;
        
        if($begin && $end){
        	//$condition['ac.add_time'] = array('between',"$begin,$end");
        }
        
        $store_name = ($keyType && $keyType == 'store_name') ? $keywords :  I('store_name','','trim');
        if($store_name)
        {
            $store_id_arr = M('store')->where("store_name like '%$store_name%'")->getField('store_id',true);
            if($store_id_arr)
            {
                $condition['store_id'] = array('in',$store_id_arr);
            }
        }    

        $order_sn = ($keyType && $keyType == 'ordersn') ? $keywords : I('ordersn') ;
        $order_sn ? $condition['ac.ordersn'] = trim($order_sn) : false;
         
        I('order_status') != '' ? $condition['ac.order_status'] = I('order_status') : false;
        I('pay_status') != '' ? $condition['ac.pay_status'] = I('pay_status') : false;
       
        I('user_id') ? $condition['user_id'] = trim(I('user_id')) : false;
        
        //获取拍卖现场中　　拍卖品已经达到结拍时间且出价最高的人
        $maxAuctionPriceList = $this->getMaxPriceGoods();
        //print_r($maxAuctionPriceList);
        $idList = [];
        $userList = [];
        foreach ($maxAuctionPriceList as $k=>$v){
            $idList[] = $k;
            $userList[]  = $v['auction_max']['user_id'];
        }
        $sort_order = I('order_by','DESC').' '.I('sort');
        $count = M('auction_competition ac')
                                        ->field([
                                            "ac.*",
                                            "ua.consignee",
                                            "g.auction_end"
                                        ])
                                        ->where($condition)
                                        //->where("g.auction_end","<",time())//只获取已经结束的拍卖品
                                        ->whereIn("ac.goods_id",$idList)//只获取每件已经结束的拍卖品的　出价最高的人
                                        ->whereIn("ac.user_id",$userList)
                                        ->join("user_address ua","ac.address_id=ua.address_id","LEFT")
                                        ->join("goods g","ac.goods_id=g.goods_id","LEFT")->count();
        $Page  = new AjaxPage($count,20);
        $show = $Page->show();
        //获取订单列表
        //$orderList = $orderLogic->getOrderList($condition,$sort_order,$Page->firstRow,$Page->listRows);
        
        $orderList = M('auction_competition ac')
                                        ->field([
                                            "ac.*",
                                            "ua.consignee",
                                            "g.auction_end"
                                        ])
                                        ->where($condition)
                                        //->where("g.auction_end","<",time())//只获取已经结束的拍卖品
                                        ->whereIn("ac.goods_id",$idList)//只获取每件已经结束的拍卖品的　出价最高的人
                                        ->whereIn("ac.user_id",$userList)
                                        ->join("user_address ua","ac.address_id=ua.address_id","LEFT")
                                        ->join("goods g","ac.goods_id=g.goods_id","LEFT")
                                        ->limit("{$Page->firstRow},{$Page->listRows}")
                                        ->order("ac.id","desc")
                                        ->fetchSql(false)
                                        ->select();
        $auctionOrder = [];
        foreach ($orderList as $k=>$v){
            //$orderList[$k]['auction_max_price'] = $this->getMaxAuctionPrice($v);
            //处理每件拍卖品的出价最高者
            $auctionPrice = $maxAuctionPriceList[$v['goods_id']];
            $userid = $auctionPrice['auction_max']['user_id'];
            if($userid==$v['user_id']){
                $v['auction_max_price'] = $auctionPrice['auction_max']['max_price'];
                $auctionOrder[$k] = $v;
            }
        }
        $store_list = M('store')->getField('store_id,store_name');        
        $this->assign('store_list',$store_list);       
        $this->assign('orderList',$auctionOrder);
        //print_r($orderList);
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('pager',$Page);// 赋值分页输出
        $this->getMaxPriceGoods();
        return $this->fetch();
    }
    //获取拍卖现场中，拍卖时间已经结束且出价最高的人
    private function getMaxPriceGoods()
    {
        $ret = M("auction_room ar")
                                ->field(["ar.*","g.auction_end"])
                                ->where("g.auction_end","<",time())
                                ->where("ar.type",1)
                                ->join("goods g","ar.goods_id=g.goods_id")
                                ->select();
        
        $auction = [];
        foreach ($ret as $k=>$v){
            $auction[$v['goods_id']][] = $v;//保存该拍卖品的出价数据
        }
        
        foreach ($auction as $k=>$v){
            $max = [];
            foreach ($v as $kk=>$vv){
                $max[$vv['id'].'-'.$vv['user_id']] = $vv['offer_price'];
            }
            asort($max);//按出价排序　　从小到大
            $temp = array_reverse($max);
            $auction[$k]['auction_max'] = ['max_price'=>current($temp),'user_id'=>explode("-", current(array_keys($temp)))[1]];//数组出栈
        }
        return $auction;
    }
    private function getMaxAuctionPrice($data){
        
        return M("auction_room")->where("type",1)->where(["user_id"=>$data['user_id'],"goods_id"=>$data["goods_id"]])->max("offer_price");
        
    }

    /*
     * ajax 发货订单列表
    */
    public function ajaxdelivery(){
    	$orderLogic = new OrderLogic();
    	$condition = array();
    	I('consignee') ? $condition['consignee'] = trim(I('consignee')) : false;
    	I('order_sn') != '' ? $condition['order_sn'] = trim(I('order_sn')) : false;
    	$condition['order_status'] = array('in','1,2,4');
    	$shipping_status = I('shipping_status');
    	$condition['shipping_status'] = empty($shipping_status) ? array('neq',1) : $shipping_status;    	
    	$count = M('order')->where($condition)->count();
    	$Page  = new AjaxPage($count,10);
    	//搜索条件下 分页赋值
    	foreach($condition as $key=>$val) {
    		$Page->parameter[$key]   =   urlencode($val);
    	}
    	$show = $Page->show();
    	$orderList = M('order')->where($condition)->limit($Page->firstRow.','.$Page->listRows)->order('add_time DESC')->select();
    	$this->assign('orderList',$orderList);
    	$this->assign('page',$show);// 赋值分页输出
    	return $this->fetch();
    }
    
    /**
     * 订单详情
     * @param int $id 订单id
     */
    public function detail(){
        
        $id = input("id");
        $ret = M("auction_competition")
                                    ->alias("ac")
                                    ->field([
                                        "ac.*",
                                        "ad.consignee",
                                        "ad.mobile",
                                        "ad.province",
                                        "ad.city",
                                        "ad.district",
                                        "ad.zipcode",
                                        "ad.address",
                                        "g.goods_name",
                                        "g.original_img",
                                        "g.shop_price",
                                        "g.auction_end",
                                        "g.goods_id",
                                        "u.nickname"
                                    ])
                                    ->join("goods g","ac.goods_id=g.goods_id","LEFT")
                                    ->join("user_address ad","ac.address_id=ad.address_id","LEFT")
                                    ->join("users u","ac.user_id=u.user_id","LEFT")
                                    ->where("ac.id",$id)
                                    ->find();
        $p = M('region')->where(array('id'=>$ret['province']))->field('name')->find();
        $c = M('region')->where(array('id'=>$ret['city']))->field('name')->find();
        $d = M('region')->where(array('id'=>$ret['district']))->field('name')->find();
        $address = $p['name'].','.$c['name'].','.$d['name'].',';
        $ret['address2'] = $address.$ret['address'];
        $ret['maxPrice'] = M("auction_room")->where(["goods_id"=>$ret['goods_id'],"user_id"=>$ret['user_id']])->max("offer_price");
       
        $this->assign("order",$ret);
        return $this->fetch();
    }
    
    public function editAuction()
    {
        $id = input("id");
        $type = input("type");
        //$ret = M("auction_competition")->where("id",$id)->setField("order_status",$type);
        $ret = M("auction_competition")->where("id",$id)->save(['order_status'=>$type]); 
        //为2已完成时，商家的账户累加 此时通知商家　用户线下打款的钱会进入对应的商家
        if($ret&&$type==2){
            $store = M("auction_competition")->where("id",$id)->find();
            $offer = M("auction_room")->where(["goods_id"=>$store['goods_id'],"user_id"=>$store['user_id']])->max("offer_price");
            $update_data = array(
                'store_money' => ['exp', 'store_money+' . $offer],
            );
            Db::name('store')->where('store_id', $store['store_id'])->update($update_data);
            //您好，${name}已经付款，请登录商家后台处理
            sms_send(Db::name("users")->where("user_id",$store['user_id'])->value("mobile"),"SMS_137687633",[
                "name"=>"拍卖商品为：{$store['goods_name']}的拍单平台已审核通过",
                
            ]);
        }
        
        $this->ajaxReturn(['status'=>1,'ret'=>$ret]);
        
    }
    public function refund_order_list(){
    	$condition = array();
    	I('consignee') ? $condition['consignee'] = trim(I('consignee')) : false;
    	I('order_sn') != '' ? $condition['order_sn'] = trim(I('order_sn')) : false;
    	I('mobile') != '' ? $condition['mobile'] = trim(I('mobile')) : false;
    	$condition['shipping_status'] = 0;
    	$condition['order_status'] = 3;
    	$condition['pay_status'] = array('gt',0);
    	$count = M('order')->where($condition)->count();
    	$Page  = new Page($count,10);
    	//搜索条件下 分页赋值
    	foreach($condition as $key=>$val) {
    		if(!is_array($val)){
    			$Page->parameter[$key]   =   urlencode($val);
    		}
    	}
    	$show = $Page->show();
    	$orderList = M('order')->where($condition)->limit($Page->firstRow.','.$Page->listRows)->order('add_time DESC')->select();
    	$this->assign('orderList',$orderList);
    	$this->assign('page',$show);// 赋值分页输出
    	$this->assign('pager',$Page);
    	return $this->fetch();
    }
    
    /**
     * 退回用户金额(原路/余额退还)
     * @param unknown $order_id
     * @return \think\mixed
     */
    public function refund_order_info($order_id){
    	$orderLogic = new OrderLogic();
    	$order = $orderLogic->getOrderInfo($order_id);
    	$orderGoods = $orderLogic->getOrderGoods($order_id);
    	$this->assign('order',$order);
    	$this->assign('orderGoods',$orderGoods);
    	return $this->fetch();
    }

    //处理取消订单  订单原路退款
    public function refund_order(){
    	$data = I('post.');
    	$orderLogic = new OrderLogic();
    	$order = $orderLogic->getOrderInfo($data['order_id']);
    	if(!$order){
    		$this->error('订单不存在或参数错误');
    	}
        if($data['pay_status'] == 3) {
            if ($data['refund_type'] == 1) {
                //退到用户余额  8-25
                if(updateRefundOrder($order,1)){
                    $this->success('成功退款到账户余额');
                }else{
                    $this->error('退款失败');
                }
            }
            if ($data['refund_type'] == 0) {   
	           	
            	if ($order['pay_code'] == 'weixin' || $order['pay_code'] == 'alipay' || $order['pay_code'] == 'alipayMobile') {
            		if ($order['pay_code'] == 'weixin') {
            			include_once PLUGIN_PATH . "payment/weixin/weixin.class.php";
            			$payment_obj = new \weixin();
            			$refund_data = array('transaction_id' => $order['transaction_id'], 'total_fee' => $order['order_amount'], 'refund_fee' => $order['order_amount']);
            			$result = $payment_obj->payment_refund($refund_data);
            			if ($result['return_code'] == 'SUCCESS' && $result['result_code' == 'SUCCESS']) {
                            if(updateRefundOrder($order)){
                                $this->success('支付原路退款成功');
                            }else{
                                $this->error('支付原路退款成功,余额支付部分退款失败');
                            }
            			}else{
            				$this->error('支付原路退款失败'.$result['return_msg']);
            			}
            		} else {
            			include_once PLUGIN_PATH . "payment/alipay/alipay.class.php";
            			$payment_obj = new \alipay();
            			$detail_data = $order['transaction_id'] . '^' . $order['order_amount'] . '^' . '用户申请订单退款';
                        $refund_data = array('batch_no' => date('YmdHi') .'o'.$order['order_id'], 'batch_num' => 1, 'detail_data' => $detail_data);
						$CommonOrderLogic = new \app\common\logic\OrderLogic();
						$CommonOrderLogic->alterReturnGoodsInventory($order);//取消订单后改变库存
            			$payment_obj->payment_refund($refund_data);
            		}
            	} else {
            		$this->error('该订单支付方式不支持在线退回');
            	}
		
            }
        }else{
    		M('order')->where(array('order_id'=>$order['order_id']))->save($data);
    		$this->success('拒绝退款操作成功');
    	}
    }
    
    
    
    //处理取消订单  订单原路退款
    public function refund_order_new(){
        $data = I('post.');
        
        $order['transaction_id'] = '2018041121001004190529243482';
        $order['order_amount']   = '0.01';
        $out_trade_no            = "0411193343-1759";
        
        include_once PLUGIN_PATH . "payment/alipay/alipay.class.php";
        
        $payment_obj = new \alipay();
        
        $detail_data = $order['transaction_id'] . '^' . $order['order_amount'] . '^' . '用户申请订单退款';
        
        $refund_data = array('batch_no' => date('YmdHi') .'o'.$order['order_id'], 'batch_num' => 1, 'detail_data' => $detail_data);
    
        
        $payment_obj->payment_refund($refund_data);
              
    }
    
    
// 虚拟订单列表
    public function virtual_list(){
    
    	$condition['order_prom_type'] = 5;
    	$sort_order = 'order_id desc';         
    	$begin = I('add_time_begin') ? strtotime(I('add_time_begin')) : strtotime("-3 month")+86400;
    	$end = I('add_time_end') ? strtotime(I('add_time_end')) : strtotime('+1 days');        
        $select_year = getTabByTime(I('add_time_begin')); // 表后缀 
    	if($begin && $end){
    		$condition['add_time'] = array('between',"$begin,$end");
    	}
    	I('pay_status') != '' ? $condition['pay_status'] = I('pay_status') : false;
    	I('pay_code') != '' ? $condition['pay_code'] = I('pay_code') : false;
    	$keyType = I("keytype");
    	$keywords = I('keywords','','trim');
    	$mobile =  ($keyType && $keyType == 'mobile') ? $keywords : I('mobile','','trim');
    	$mobile ? $condition['mobile'] = trim($mobile) : false;
    	$order_sn = ($keyType && $keyType == 'order_sn') ? $keywords : I('order_sn') ;
    	$order_sn ? $condition['order_sn'] = trim($order_sn) : false;
    	$store_name = ($keyType && $keyType == 'store_name') ? $keywords :  I('store_name','','trim');
    	if($store_name){
    		$store_id_arr = M('store')->where("store_name like '%$store_name%'")->getField('store_id',true);
    		if($store_id_arr) $condition['store_id'] = array('in',$store_id_arr);
    	}
    	$orderLogic = new OrderLogic();
    	$export = I('export');
    	if($export == 1){
			$order_ids = I('order_ids');
			if($order_ids){
				$condition['order_id'] = ['in',$order_ids];
			}
    		$orderList = M('order'.$select_year)->where($condition)->order($sort_order)->select();
    		$strTable ='<table width="500" border="1">';
    		$strTable .= '<tr>';
    		$strTable .= '<td style="text-align:center;font-size:12px;width:120px;">订单编号</td>';
    		$strTable .= '<td style="text-align:center;font-size:12px;" width="100">日期</td>';
    		$strTable .= '<td style="text-align:center;font-size:12px;" width="*">接收人</td>';
    		$strTable .= '<td style="text-align:center;font-size:12px;" width="*">购买人</td>';
    		$strTable .= '<td style="text-align:center;font-size:12px;" width="*">订单金额</td>';
    		$strTable .= '<td style="text-align:center;font-size:12px;" width="*">实际支付</td>';
    		$strTable .= '<td style="text-align:center;font-size:12px;" width="*">支付方式</td>';
    		$strTable .= '<td style="text-align:center;font-size:12px;" width="*">支付状态</td>';
    		$strTable .= '<td style="text-align:center;font-size:12px;" width="*">使用期限</td>';
			$strTable .= '<td style="text-align:center;font-size:12px;" width="*">商品数量</td>';
    		$strTable .= '<td style="text-align:center;font-size:12px;" width="*">商品信息</td>';
    		$strTable .= '</tr>';
    		 
    		foreach($orderList as $k=>$val){
    			$strTable .= '<tr>';
    			$strTable .= '<td style="text-align:center;font-size:12px;">&nbsp;'.$val['order_sn'].'</td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.date('Ymd',$val['add_time']).' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['mobile'].'</td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['consignee'].' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['goods_price'].'</td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['order_amount'].'</td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['pay_name'].'</td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$this->pay_status[$val['pay_status']].'</td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.date('Ymd',$val['shipping_time']).'</td>';
    			$orderGoods = M('order_goods'.$select_year)->where('order_id='.$val['order_id'])->select();
    			$strGoods="";
				$goods_num = 0;
    			foreach($orderGoods as $goods){
					$goods_num = $goods_num + $goods['goods_num'];
    				$strGoods .= "商品编号：".$goods['goods_sn']." 商品名称：".$goods['goods_name'];
    				if ($goods['spec_key_name'] != '') $strGoods .= " 规格：".$goods['spec_key_name'];
    				$strGoods .= "<br />";
    			}
    			unset($orderGoods);
				$strTable .= '<td style="text-align:left;font-size:12px;">'.$goods_num.' </td>';
    			$strTable .= '<td style="text-align:left;font-size:12px;">'.$strGoods.' </td>';
    			$strTable .= '</tr>';
    		}
    		$strTable .='</table>';
    		unset($orderList);
    		downloadExcel($strTable,'order');
    		exit();
    	}
    	$count = M('order'.$select_year)->where($condition)->count();
    	$Page  = new Page($count,20);
    	$show = $Page->show();
    	$orderList = $orderLogic->getOrderList($condition,$sort_order,$Page->firstRow,$Page->listRows);
    	//获取每个订单的商品列表
    	$order_id_arr = get_arr_column($orderList, 'order_id');
    	$user_id_arr = get_arr_column($orderList, 'user_id');
    	$store_id_arr = get_arr_column($orderList, 'store_id');
    	if(!empty($order_id_arr));
    	if($order_id_arr){
    		$goods_list = M('order_goods'.$select_year)->where("order_id in (".  implode(',', $order_id_arr).")")->select();
    		$goods_arr = array();
    		foreach ($goods_list as $v){
    			$goods_arr[$v['order_id']][] =$v;
    		}
    		$this->assign('goodsArr',$goods_arr);
    		$user_arr = M('users')->where("user_id in (".  implode(',', $user_id_arr).")")->getField('user_id,nickname');
    		$this->assign('userArr',$user_arr);
    		$store_arr = M('store')->where("store_id in (".  implode(',', $store_id_arr).")")->getField('store_id,store_name');
    		$this->assign('store_arr',$store_arr);
    	}
        $this->assign('begin', date('Y-m-d',$begin));
        $this->assign('end', date('Y-m-d',$end));        
    	$this->assign('orderList',$orderList);
    	$this->assign('page',$show);
    	$this->assign('total_count',$count);
    	return $this->fetch();
	
    }
    
    public function virtual_info(){
    	$order_id = I('order_id');
        // 获取操作表
        $select_year = getTabByOrderId($order_id);           
    	$order = M('order'.$select_year)->where(array('order_id'=>$order_id))->find();
    	if($order['pay_status'] == 1){
    		$vrorder = M('vr_order_code')->where(array('order_id'=>$order_id))->select();
    		$this->assign('vrorder',$vrorder);
    	}
    	$order_goods = M('order_goods'.$select_year)->where(array('order_id'=>$order_id))->find();
    	$order_goods['commission_money'] = $order_goods['commission']*$order_goods['goods_price']*$order_goods['goods_num']/100;
    	$order_goods['virtual_indate'] = M('goods')->where(array('goods_id'=>$order_goods['goods_id']))->getField('virtual_indate');
        $order['order_status_detail'] = C('ORDER_STATUS')[$order['order_status']];
    	$this->assign('order',$order);
    	$this->assign('order_goods',$order_goods);
    	$store = M('store')->where(array('store_id'=>$order['store_id']))->find();
    	$this->assign('store',$store);
    	return $this->fetch();
    }

    /**
     * 订单编辑
     * @param int $id 订单id
     */
    public function edit_order(){
    	$order_id = I('order_id');
        $orderLogic = new OrderLogic();
        $order = $orderLogic->getOrderInfo($order_id);
        if($order['shipping_status'] != 0){
            $this->error('已发货订单不允许编辑');
            exit;
        } 
    
        $orderGoods = $orderLogic->getOrderGoods($order_id);
                
       	if(IS_POST)
        {
            $order['consignee'] = I('consignee');// 收货人
            $order['province'] = I('province'); // 省份
            $order['city'] = I('city'); // 城市
            $order['district'] = I('district'); // 县
            $order['address'] = I('address'); // 收货地址
            $order['mobile'] = I('mobile'); // 手机           
            $order['invoice_title'] = I('invoice_title');// 发票
            $order['admin_note'] = I('admin_note'); // 管理员备注
            $order['admin_note'] = I('admin_note'); //                  
            $order['shipping_code'] = I('shipping');// 物流方式
            $order['shipping_name'] = M('plugin')->where(array('status'=>1,'type'=>'shipping','code'=>I('shipping')))->getField('name');            
            $order['pay_code'] = I('payment');// 支付方式            
            $order['pay_name'] = M('plugin')->where(array('status'=>1,'type'=>'payment','code'=>I('payment')))->getField('name');                            
            $goods_id_arr = I("goods_id");
            $new_goods = $old_goods_arr = array();
            //################################订单添加商品
            if($goods_id_arr){
            	$new_goods = $orderLogic->get_spec_goods($goods_id_arr);
            	foreach($new_goods as $key => $val)
            	{
            		$val['order_id'] = $order_id;
            		$rec_id = M('order_goods')->add($val);//订单添加商品
            		if(!$rec_id)
            			$this->error('添加失败');
            	}
            }
            
            //################################订单修改删除商品
            $old_goods = I('old_goods');
            foreach ($orderGoods as $val){
            	if(empty($old_goods[$val['rec_id']])){
            		M('order_goods')->where("rec_id=".$val['rec_id'])->delete();//删除商品
            	}else{
            		//修改商品数量
            		if($old_goods[$val['rec_id']] != $val['goods_num']){
            			$val['goods_num'] = $old_goods[$val['rec_id']];
            			M('order_goods')->where("rec_id=".$val['rec_id'])->save(array('goods_num'=>$val['goods_num']));
            		}
            		$old_goods_arr[] = $val;
            	}
            }
            
            $goodsArr = array_merge($old_goods_arr,$new_goods);
            $result = calculate_price($order['user_id'],$goodsArr,$order['shipping_code'],$order['province'],$order['city'],$order['district'],0,0,0);
            if($result['status'] < 0)
            {
            	$this->error($result['msg']);
            }
       
            //################################修改订单费用
            $order['goods_price']    = $result['result']['goods_price']; // 商品总价
            $order['shipping_price'] = $result['result']['shipping_price'];//物流费
            $order['order_amount']   = $result['result']['order_amount']; // 应付金额
            $order['total_amount']   = $result['result']['total_amount']; // 订单总价           
            $o = M('order')->where('order_id='.$order_id)->save($order);
            
			$admin_id = session('admin_id'); // 当前操作的管理员
            $l = $orderLogic->orderActionLog($order_id,'编辑订单','修改订单',$admin_id);//操作日志
            if($o && $l){
            	$this->success('修改成功',U('Admin/Order/editprice',array('order_id'=>$order_id)));
            }else{
            	$this->success('修改失败',U('Admin/Order/detail',array('order_id'=>$order_id)));
            }
            exit;
        }
        // 获取省份
        $province = M('region')->where(array('parent_id'=>0,'level'=>1))->select();
        //获取订单城市
        $city =  M('region')->where(array('parent_id'=>$order['province'],'level'=>2))->select();
        //获取订单地区
        $area =  M('region')->where(array('parent_id'=>$order['city'],'level'=>3))->select();
        //获取支付方式
        $payment_list = M('plugin')->where(array('status'=>1,'type'=>'payment'))->select();
        //获取配送方式
        $shipping_list = M('plugin')->where(array('status'=>1,'type'=>'shipping'))->select();
        
        $this->assign('order',$order);
        $this->assign('province',$province);
        $this->assign('city',$city);
        $this->assign('area',$area);
        $this->assign('orderGoods',$orderGoods);
        $this->assign('shipping_list',$shipping_list);
        $this->assign('payment_list',$payment_list);
        return $this->fetch();
    }
    
    /*
     * 拆分订单
     */
    public function split_order(){
    	$order_id = I('order_id');
    	$orderLogic = new OrderLogic();
    	$order = $orderLogic->getOrderInfo($order_id);
    	if($order['shipping_status'] != 0){
    		$this->error('已发货订单不允许编辑');
    		exit;
    	}
    	$orderGoods = $orderLogic->getOrderGoods($order_id);
    	if(IS_POST){
    		$data = I('post.');
    		//################################先处理原单剩余商品和原订单信息
    		$old_goods = I('goods');
    		foreach ($orderGoods as $val){
    			if(empty($old_goods[$val['rec_id']])){
    				M('order_goods')->where("rec_id=".$val['rec_id'])->delete();//删除商品
    			}else{
    				//修改商品数量
    				if($old_goods[$val['rec_id']] != $val['goods_num']){
    					$val['goods_num'] = $old_goods[$val['rec_id']];
    					M('order_goods')->where("rec_id=".$val['rec_id'])->save(array('goods_num'=>$val['goods_num']));
    				}
    				$oldArr[] = $val;//剩余商品
    			}
    			$all_goods[$val['rec_id']] = $val;//所有商品信息
    		}
    		$result = calculate_price($order['user_id'],$oldArr,$order['shipping_code'],$order['province'],$order['city'],$order['district'],0,0,0);
    		if($result['status'] < 0)
    		{
    			$this->error($result['msg']);
    		}
    		//修改订单费用
    		$res['goods_price']    = $result['result']['goods_price']; // 商品总价
    		$res['order_amount']   = $result['result']['order_amount']; // 应付金额
    		$res['total_amount']   = $result['result']['total_amount']; // 订单总价
    		M('order')->where("order_id=".$order_id)->save($res);
			//################################原单处理结束
			
    		//################################新单处理
    		for($i=1;$i<20;$i++){
    			if(empty($_POST[$i.'_goods'])){
    				break;
    			}else{
    				$split_goods[] = $_POST[$i.'_goods'];
    			}
    		}

    		foreach ($split_goods as $key=>$vrr){
    			foreach ($vrr as $k=>$v){
    				$all_goods[$k]['goods_num'] = $v;
    				$brr[$key][] = $all_goods[$k];
    			}
    		}
    		
    		foreach($brr as $goods){
    			$result = calculate_price($order['user_id'],$goods,$order['shipping_code'],$order['province'],$order['city'],$order['district'],0,0,0);
    			if($result['status'] < 0)
    			{
    				$this->error($result['msg']);
    			}
    			$new_order = $order;
    			$new_order['order_sn'] = date('YmdHis').mt_rand(1000,9999);
    			$new_order['parent_sn'] = $order['order_sn'];
    			//修改订单费用
    			$new_order['goods_price']    = $result['result']['goods_price']; // 商品总价
    			$new_order['order_amount']   = $result['result']['order_amount']; // 应付金额
    			$new_order['total_amount']   = $result['result']['total_amount']; // 订单总价
    			$new_order['add_time'] = time();
    			unset($new_order['order_id']);
    			$new_order_id = M('order')->add($new_order);//插入订单表
    			foreach ($goods as $vv){
    				$vv['order_id'] = $new_order_id;
    				$nid = M('order_goods')->add($vv);//插入订单商品表
    			}
    		}
    		//################################新单处理结束
    		$this->success('操作成功',U('Admin/Order/detail',array('order_id'=>$order_id)));
                exit;
    	}
    	
    	foreach ($orderGoods as $val){
    		$brr[$val['rec_id']] = array('goods_num'=>$val['goods_num'],'goods_name'=>getSubstr($val['goods_name'], 0, 35).$val['spec_key_name']);
    	}
    	$this->assign('order',$order);
    	$this->assign('goods_num_arr',json_encode($brr));
    	$this->assign('orderGoods',$orderGoods);
    	return $this->fetch();
    }
    
    /*
     * 价钱修改
     */
    public function editprice($order_id){
        $orderLogic = new OrderLogic();
        $order = $orderLogic->getOrderInfo($order_id);
        $this->editable($order);
        if(IS_POST){
        	$admin_id = session('admin_id');
            if(empty($admin_id)){
                $this->error('非法操作');
                exit;
            }
            $update['discount'] = I('post.discount');
            $update['shipping_price'] = I('post.shipping_price');
			$update['order_amount'] = $order['goods_price'] + $update['shipping_price'] - $update['discount'] - $order['user_money'] - $order['integral_money'] - $order['coupon_price'];
            $row = M('order')->where(array('order_id'=>$order_id))->save($update);
            if(!$row){
                $this->success('没有更新数据',U('Admin/Order/editprice',array('order_id'=>$order_id)));
            }else{
                $this->success('操作成功',U('Admin/Order/detail',array('order_id'=>$order_id)));
            }
            exit;
        }
        $this->assign('order',$order);
        return $this->fetch();
    }

    
    /**
     * 订单取消付款
     */
    public function pay_cancel($order_id){
    	if(I('remark')){
    		$data = I('post.');
    		$note = array('退款到用户余额','已通过其他方式退款','不处理，误操作项');
    		if($data['refundType'] == 0 && $data['amount']>0){
    			accountLog($data['user_id'], $data['amount'], 0,  '退款到用户余额');
    		}
    		$orderLogic = new OrderLogic();
			$admin_id = session('admin_id'); // 当前操作的管理员
    		$d = $orderLogic->orderActionLog($data['order_id'],'取消付款',$data['remark'].':'.$note[$data['refundType']],$admin_id);
    		if($d){
    			exit("<script>window.parent.pay_callback(1);</script>");
    		}else{
    			exit("<script>window.parent.pay_callback(0);</script>");
    		}
    	}else{
    		$order = M('order')->where("order_id=$order_id")->find();
    		$this->assign('order',$order);
    		return $this->fetch();
    	}
    }

    /**
     * 订单打印
     * @param int $id 订单id
     */
    public function order_print($order_id){
        $orderLogic = new OrderLogic();
        $order = $orderLogic->getOrderInfo($order_id);
        $order['province'] = getRegionName($order['province']);
        $order['city'] = getRegionName($order['city']);
        $order['district'] = getRegionName($order['district']);
        $order['full_address'] = $order['province'].' '.$order['city'].' '.$order['district'].' '. $order['address'];
        $orderGoods = $orderLogic->getOrderGoods($order_id);
        $shop = tpCache('shop_info');
        $this->assign('order',$order);
        $this->assign('shop',$shop);
        $this->assign('orderGoods',$orderGoods);
        return $this->fetch('print');
    }

    /**
     * 快递单打印
     */
    public function shipping_print(){
        $order_id = I('get.order_id');
        $orderLogic = new OrderLogic();
        $order = $orderLogic->getOrderInfo($order_id);
        //查询是否存在订单及物流
        $shipping = M('plugin')->where(array('code'=>$order['shipping_code'],'type'=>'shipping'))->find();        
        if(!$shipping){
        	$this->error('物流插件不存在');
        }
		if(empty($shipping['config_value'])){
			$this->error('请设置'.$shipping['name'].'打印模板');
		}
        $shop = tpCache('shop_info');//获取网站信息
        $shop['province'] = empty($shop['province']) ? '' : getRegionName($shop['province']);
        $shop['city'] = empty($shop['city']) ? '' : getRegionName($shop['city']);
        $shop['district'] = empty($shop['district']) ? '' : getRegionName($shop['district']);

        $order['province'] = getRegionName($order['province']);
        $order['city'] = getRegionName($order['city']);
        $order['district'] = getRegionName($order['district']);
        if(empty($shipping['config'])){
        	$config = array('width'=>840,'height'=>480,'offset_x'=>0,'offset_y'=>0);
        	$this->assign('config',$config);
        }else{
        	$this->assign('config',unserialize($shipping['config']));
        }
        $template_var = array("发货点-名称", "发货点-联系人", "发货点-电话", "发货点-省份", "发货点-城市",
        		 "发货点-区县", "发货点-手机", "发货点-详细地址", "收件人-姓名", "收件人-手机", "收件人-电话", 
        		"收件人-省份", "收件人-城市", "收件人-区县", "收件人-邮编", "收件人-详细地址", "时间-年", "时间-月", 
        		"时间-日","时间-当前日期","订单-订单号", "订单-备注","订单-配送费用");
        $content_var = array($shop['store_name'],$shop['contact'],$shop['phone'],$shop['province'],$shop['city'],
        	$shop['district'],$shop['phone'],$shop['address'],$order['consignee'],$order['mobile'],$order['phone'],
        	$order['province'],$order['city'],$order['district'],$order['zipcode'],$order['address'],date('Y'),date('M'),
        	date('d'),date('Y-m-d'),$order['order_sn'],$order['admin_note'],$order['shipping_price'],
        );
        $shipping['config_value'] = str_replace($template_var,$content_var, $shipping['config_value']);
        $this->assign('shipping',$shipping);
        return $this->fetch("Plugin/print_express");
    }

    /**
     * 生成发货单
     */
    public function deliveryHandle(){
        $orderLogic = new OrderLogic();
		$data = I('post.');
		$res = $orderLogic->deliveryHandle($data);
		if($res){
			$this->success('操作成功',U('Admin/Order/delivery_info',array('order_id'=>$data['order_id'])));
		}else{
			$this->success('操作失败',U('Admin/Order/delivery_info',array('order_id'=>$data['order_id'])));
		}
    }

    
    public function delivery_info(){
    	$order_id = I('order_id');
    	$orderLogic = new OrderLogic();
    	$order = $orderLogic->getOrderInfo($order_id);
    	$orderGoods = $orderLogic->getOrderGoods($order_id);
    	$this->assign('order',$order);
    	$this->assign('orderGoods',$orderGoods);
		$delivery_record = Db::name('delivery_doc')->alias('d')->join('__SELLER__ s','s.seller_id = d.admin_id', 'LEFT')->where('d.order_id', $order_id)->select();
		$this->assign('delivery_record',$delivery_record);//发货记录
    	return $this->fetch();
    }
    
    /**
     * 发货单列表
     */
    public function delivery_list(){
        return $this->fetch();
    }
	
    /*
     * ajax 退货订单列表
     */
    public function ajax_return_list(){
        // 搜索条件        
        $order_sn =  trim(I('order_sn'));
        $order_by = I('order_by') ? I('order_by') : 'id';
        $sort_order = I('sort_order') ? I('sort_order') : 'desc';
        $status =  I('status','','trim');       
        
        $where = " 1 = 1 ";       
        $order_sn && $where.= " and order_sn like '%$order_sn%' ";
        ($status === '') ? 'do nothing' : ($where.= " and status = '$status' ");
          
        $count = M('return_goods')->where($where)->count();
        $Page  = new AjaxPage($count,13);
        $show = $Page->show();
        $list = M('return_goods')->where($where)->order("$order_by $sort_order")->limit("{$Page->firstRow},{$Page->listRows}")->select();        
        $goods_id_arr = get_arr_column($list, 'goods_id');
        if(!empty($goods_id_arr)){
            $goods_list = M('goods')->where("goods_id in (".implode(',', $goods_id_arr).")")->getField('goods_id,goods_name');
        }
        $store_list = M('store')->getField('store_id,store_name');        
        $this->assign('store_list',$store_list);
        $this->assign('goods_list',$goods_list);
        $this->assign('list',$list);
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('pager',$Page);// 赋值分页输出
        return $this->fetch();
    }
    
    /**
     * 删除某个退换货申请
     */
    public function return_del(){
        $id = I('get.id');
        M('return_goods')->where("id = $id")->delete(); 
        $this->success('成功删除!');
    }
    
    /**
     * 退换货操作
     */
    public function return_info()
    {
        $id = I('id');
        $return_goods = M('return_goods')->where("id= $id")->find();
        if($return_goods['imgs'])            
             $return_goods['imgs'] = explode(',', $return_goods['imgs']);
        $user = M('users')->where("user_id = {$return_goods[user_id]}")->find();
        $goods = M('goods')->where("goods_id = {$return_goods[goods_id]}")->find();
        $type_msg = array('退换','换货');
        $status_msg = array('未处理','处理中','已完成');
        if(IS_POST)
        {
            $data['type'] = I('type');
            $data['status'] = I('status');
            $data['refund_mark'] = I('refund_mark');                                    
            $note ="退换货:{$type_msg[$data['type']]}, 状态:{$status_msg[$data['status']]},处理备注：{$data['remark']}";
            $result = M('return_goods')->where("id= $id")->save($data);    
            if($result)
            {        
            	$type = empty($data['type']) ? 2 : 3;
            	$where = " order_id = ".$return_goods['order_id']." and goods_id=".$return_goods['goods_id'];
            	M('order_goods')->where($where)->save(array('is_send'=>$type));//更改商品状态        
                $orderLogic = new OrderLogic();
				$admin_id = session('admin_id'); // 当前操作的管理员
                $log = $orderLogic->orderActionLog($return_goods[order_id],'退换货',$note,$admin_id);
                $this->success('修改成功!');            
                exit;
            }  
        }        
        
        $this->assign('id',$id); // 用户
        $this->assign('user',$user); // 用户
        $this->assign('goods',$goods);// 商品
        $this->assign('return_goods',$return_goods);// 退换货               
        return $this->fetch();
    }
    
    /**
     * 管理员生成申请退货单
     */
    public function add_return_goods()
   {                
            $order_id = I('order_id'); 
            $goods_id = I('goods_id');
                
            $return_goods = M('return_goods')->where("order_id = $order_id and goods_id = $goods_id")->find();            
            if(!empty($return_goods))
            {
                $this->error('已经提交过退货申请!',U('Admin/Order/return_list'));
                exit;
            }
            $order = M('order')->where("order_id = $order_id")->find();
            
            $data['order_id'] = $order_id; 
            $data['order_sn'] = $order['order_sn']; 
            $data['goods_id'] = $goods_id; 
            $data['addtime'] = time(); 
            $data['user_id'] = $order[user_id];            
            $data['remark'] = '管理员申请退换货'; // 问题描述            
            M('return_goods')->add($data);            
            $this->success('申请成功,现在去处理退货',U('Admin/Order/return_list'));
            exit;
    }

    public function order_log(){
        $OrderActionModel = new OrderAction();
//        $select_year = getTabByTime(I('add_time_begin')); // 表后缀
    	$begin = I('add_time_begin') ? strtotime(I('add_time_begin')) : strtotime("-3 month")+86400;
    	$end = I('add_time_end') ? strtotime(I('add_time_end')) : strtotime('+1 days');        
        
    	$condition = array();
//    	$log =  M('order_action'.$select_year);
    	if($begin && $end){
    		$condition['oa.log_time'] = array('between',"$begin,$end");
    	}
    	$admin_id = I('admin_id');
		if($admin_id >0 ){
			$condition['oa.action_user'] = $admin_id;
		}
    	$count = $OrderActionModel->alias('oa')->where($condition)->count();
    	$Page = new Page($count,20);    	 
    	$show = $Page->show();
    	$list = $OrderActionModel->where($condition)->alias('oa')
            ->field('oa.*,u.user_id,u.nickname')
            ->join('users u','oa.action_user = u.user_id','left')
            ->order('oa.action_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
    	$this->assign('list',$list);
    	$this->assign('page',$show);   	
    	$admin = M('admin')->getField('admin_id,user_name');
        $this->assign('begin', date('Y-m-d',$begin));
        $this->assign('end', date('Y-m-d',$end));        
    	$this->assign('admin',$admin);    	
    	return $this->fetch();
    }

    /**
     * 检测订单是否可以编辑
     * @param $order
     */
    private function editable($order){
        if($order['shipping_status'] != 0){
            $this->error('已发货订单不允许编辑');
            exit;
        }
        return;
    }

    public function export_order()
    {
    	//搜索条件
		$consignee = I('consignee');
		$order_sn =  I('order_sn');
		$timegap = I('timegap');
		$order_status = I('order_status');
		$order_ids = I('order_ids');
		$where = array();//搜索条件
		if($consignee){
			$where['consignee'] = ['like','%'.$consignee.'%'];
		}
		if($order_sn){
			$where['order_sn'] = $order_sn;
		}
		if($order_status){
			$where['order_status'] = $order_status;
		}
		if($timegap){
			$gap = explode('-', $timegap);
			$begin = strtotime($gap[0]);
			$end = strtotime($gap[1]);
			$where['add_time'] = ['between',[$begin, $end]];
		}
		if($order_ids){
			$where['order_id'] = ['in', $order_ids];
		}
		$where['status'] = 1;
		
		$region	= Db::name('region')->cache(true)->getField('id,name');
		$orderList = Db::name('order')->field("*,FROM_UNIXTIME(add_time,'%Y-%m-%d') as create_time")->where($where)->order('order_id')->select();
    	$strTable ='<table width="500" border="1">';
    	$strTable .= '<tr>';
    	$strTable .= '<td style="text-align:center;font-size:12px;width:120px;">订单编号</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="100">日期</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">收货人</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">收货地址</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">电话</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">订单金额</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">实际支付</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">支付方式</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">支付状态</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">发货状态</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">商品数量</td>';
    	$strTable .= '<td style="text-align:center;font-size:12px;" width="*">商品信息</td>';
    	$strTable .= '</tr>';
    	
    	foreach($orderList as $k=>$val){
    		$strTable .= '<tr>';
    		$strTable .= '<td style="text-align:center;font-size:12px;">&nbsp;'.$val['order_sn'].'</td>';
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['create_time'].' </td>';
			$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['consignee'].'</td>';
			$strTable .= '<td style="text-align:left;font-size:12px;">'."{$region[$val['province']]},{$region[$val['city']]},{$region[$val['district']]},{$region[$val['twon']]}{$val['address']}".' </td>';
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['mobile'].'</td>';
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['goods_price'].'</td>';
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['order_amount'].'</td>';
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$val['pay_name'].'</td>';
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$this->pay_status[$val['pay_status']].'</td>';
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$this->shipping_status[$val['shipping_status']].'</td>';    
    		$orderGoods = D('order_goods')->where('order_id='.$val['order_id'])->select();
    		$strGoods="";
			$goods_num = 0;
    		foreach($orderGoods as $goods){
				$goods_num = $goods_num + $goods['goods_num'];
    			$strGoods .= "商品编号：".$goods['goods_sn']." 商品名称：".$goods['goods_name'];
    			if ($goods['spec_key_name'] != '') $strGoods .= " 规格：".$goods['spec_key_name'];
    			$strGoods .= "<br />";
    		}
    		unset($orderGoods);
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$goods_num.' </td>';
    		$strTable .= '<td style="text-align:left;font-size:12px;">'.$strGoods.' </td>';
    		$strTable .= '</tr>';
    	}
    	$strTable .='</table>';
    	unset($orderList);
    	downloadExcel($strTable,'order');
    	exit();
    }
    
    /**
     * 退货单列表
     */
    public function return_list(){
        return $this->fetch();
    }
    
    /**
     * 添加一笔订单
     */
    public function add_order()
    {
        $order = array();
        //  获取省份
        $province = M('region')->where(array('parent_id'=>0,'level'=>1))->select();
        //  获取订单城市
        $city =  M('region')->where(array('parent_id'=>$order['province'],'level'=>2))->select();
        //  获取订单地区
        $area =  M('region')->where(array('parent_id'=>$order['city'],'level'=>3))->select();
        //  获取配送方式
        $shipping_list = M('plugin')->where(array('status'=>1,'type'=>'shipping'))->select();
        //  获取支付方式
        $payment_list = M('plugin')->where(array('status'=>1,'type'=>'payment'))->select();
        if(IS_POST)
        {
            $order['user_id'] = I('user_id');// 用户id 可以为空
            $order['consignee'] = I('consignee');// 收货人
            $order['province'] = I('province'); // 省份
            $order['city'] = I('city'); // 城市
            $order['district'] = I('district'); // 县
            $order['address'] = I('address'); // 收货地址
            $order['mobile'] = I('mobile'); // 手机           
            $order['invoice_title'] = I('invoice_title');// 发票
            $order['admin_note'] = I('admin_note'); // 管理员备注            
            $order['order_sn'] = date('YmdHis').mt_rand(1000,9999); // 订单编号;
            $order['admin_note'] = I('admin_note'); // 
            $order['add_time'] = time(); //                    
            $order['shipping_code'] = I('shipping');// 物流方式
            $order['shipping_name'] = M('plugin')->where(array('status'=>1,'type'=>'shipping','code'=>I('shipping')))->getField('name');            
            $order['pay_code'] = I('payment');// 支付方式            
            $order['pay_name'] = M('plugin')->where(array('status'=>1,'type'=>'payment','code'=>I('payment')))->getField('name');            
                            
            $goods_id_arr = I("goods_id");
            $orderLogic = new OrderLogic();
            $order_goods = $orderLogic->get_spec_goods($goods_id_arr);          
            $result = calculate_price($order['user_id'],$order_goods,$order['shipping_code'],$order[province],$order[city],$order[district],0,0,0);
            if($result['status'] < 0)	
            {
                 $this->error($result['msg']);      
            } 
           
           $order['goods_price']    = $result['result']['goods_price']; // 商品总价
           $order['shipping_price'] = $result['result']['shipping_price']; //物流费
           $order['order_amount']   = $result['result']['order_amount']; // 应付金额
           $order['total_amount']   = $result['result']['total_amount']; // 订单总价
           
            // 添加订单
            $order_id = M('order')->add($order);
            if($order_id)
            {
                foreach($order_goods as $key => $val)
                {
                    $val['order_id'] = $order_id;
                    $rec_id = M('order_goods')->add($val);
                    if(!$rec_id)                 
                        $this->error('添加失败');                                  
                }
                $this->success('添加商品成功',U("Admin/Order/detail",array('order_id'=>$order_id)));
                exit();
            }
            else{
                $this->error('添加失败');
            }                
        }     
        $this->assign('shipping_list',$shipping_list);
        $this->assign('payment_list',$payment_list);
        $this->assign('province',$province);
        $this->assign('city',$city);
        $this->assign('area',$area);        
        return $this->fetch();
    }
    
    /**
     * 选择搜索商品
     */
    public function search_goods()
    {
    	$brandList =  M("brand")->select();
    	$categoryList =  M("goods_category")->select();
    	$this->assign('categoryList',$categoryList);
    	$this->assign('brandList',$brandList);   	
    	$where = ' is_on_sale = 1 ';//搜索条件
    	I('intro')  && $where = "$where and ".I('intro')." = 1";
    	if(I('cat_id')){
    		$this->assign('cat_id',I('cat_id'));    		
            $grandson_ids = getCatGrandson(I('cat_id')); 
            $where = " $where  and cat_id in(".  implode(',', $grandson_ids).") "; // 初始化搜索条件
                
    	}
        if(I('brand_id')){
            $this->assign('brand_id',I('brand_id'));
            $where = "$where and brand_id = ".I('brand_id');
        }
    	if(!empty($_REQUEST['keywords']))
    	{
    		$this->assign('keywords',I('keywords'));
    		$where = "$where and (goods_name like '%".I('keywords')."%' or keywords like '%".I('keywords')."%')" ;
    	}  	
    	$goodsList = M('goods')->where($where)->order('goods_id DESC')->limit(10)->select();
                
        foreach($goodsList as $key => $val)
        {
            $spec_goods = M('spec_goods_price')->where("goods_id = {$val['goods_id']}")->select();
            $goodsList[$key]['spec_goods'] = $spec_goods;            
        }
    	$this->assign('goodsList',$goodsList);
    	return $this->fetch();
    }
    
    public function ajaxOrderNotice(){
        $order_amount = M('order')->where(array('order_status'=>0))->count();
        echo $order_amount;
    }
}
