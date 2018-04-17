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
 * 专题管理
 * Date: 2016-06-09
 *  拼团控制器
 */

namespace app\admin\controller;

use app\common\model\Order;
use app\common\model\TeamActivity;
use app\common\model\TeamFound;
use think\Loader;
use think\Db;
use think\Page;

class Team extends Base
{
	public function _initialize() {
		parent::_initialize();
		$this->assign('time_begin',date('Y-m-d', strtotime("-3 month")+86400));
		$this->assign('time_end',date('Y-m-d', strtotime('+1 days')));
	}
	public function index()
	{	
		
		$act_name = input('act_name');
		$team_where = [];
		if ($act_name) {
			$team_where['act_name'] = ['like', '%' . $act_name . '%'];
		}
		$TeamActivity = new TeamActivity();
		$count = $TeamActivity->where($team_where)->count();
		$Page = new Page($count, 10);
		$list = $TeamActivity->append(['team_type_desc','time_limit_hours','status_desc'])->with('store')->where($team_where)->limit($Page->firstRow . ',' . $Page->listRows)->select();
		$this->assign('page', $Page);
		$this->assign('list', $list);
		return $this->fetch();
		
	}

	public function info()
	{
		
		$team_id = input('team_id');
		if (empty($team_id)) {
			$this->error('非法操作');
		}
		$TeamActivity = new TeamActivity();
		$teamActivity = $TeamActivity->append(['time_limit_hours'])->with('specGoodsPrice,goods,store')->find($team_id);
		if (empty($teamActivity)) {
			$this->error('该数据不存在或已被删除');
		}
		$this->assign('teamActivity', $teamActivity);
		return $this->fetch();
		
	}

	/**
	 * 审核
	 */
	public function examine(){
		
		$team_id = input('team_id');
		$status = input('status');
		if (empty($team_id) || empty($status)) {
			$this->ajaxReturn(['status' =>0,'msg' => '参数有误','result' => '']);
		}
		$teamActivity = TeamActivity::get($team_id);
		if($teamActivity){
			$teamActivity->status = $status;
			$row = $teamActivity->save();
			if($row !== false){
				$this->ajaxReturn(['status' =>1,'msg' => '操作成功','result' => '']);
			}else{
				$this->ajaxReturn(['status' =>0,'msg' => '操作失败','result' => '']);
			}
		}else{
			$this->ajaxReturn(['status' =>0,'msg' => '没有找到数据','result' => '']);
		}
		
	}

	public function found_order_list(){
		
		$team_id = input('team_id');
		$found_id = input('found_id');
		$add_time_begin = input('add_time_begin',date('Y-m-d', strtotime("-3 month")+86400));
		$add_time_end = input('add_time_end',date('Y-m-d', strtotime('+1 days')));
		$status = input('status');
		$begin = strtotime($add_time_begin);
		$end = strtotime($add_time_end);
		// 搜索条件
		$found_where = ['o.order_prom_type'=>6];
		$keywords = input('keywords','','trim');
		$key_type = input('key_type');
		if($key_type != '' && $keywords != ''){
			if($key_type == 'store_name'){
				$store_id_arr = Db::name('store')->where("store_name", "like", '%' . $keywords . '%')->getField('store_id', true);
				if ($store_id_arr) {
					$found_where['tf.store_id'] = array('in', $store_id_arr);
				}
			}elseif($key_type == 'order_sn'){
				$found_where['o.order_sn'] = $keywords;
			}elseif($key_type == 'consignee'){
				$found_where['o.consignee'] = $keywords;
			}
		}
		if($begin && $end){
			$found_where['tf.found_time'] = array('between',"$begin,$end");
		}
		if($team_id != ''){
			$found_where['tf.team_id'] = $team_id;
		}
		if($found_id != ''){
			$found_where['tf.found_id'] = $found_id;
		}
		if($status != ''){
			$found_where['tf.status'] = $status;
		}
		$TeamFound = new TeamFound();
		$found_count = $TeamFound->alias('tf')->join('__ORDER__ o','tf.order_id = o.order_id')->where($found_where)->count('found_id');
		$page = new Page($found_count, 20);
		$TeamFound = $TeamFound->alias('tf')->join('__ORDER__ o','tf.order_id = o.order_id')->with('teamActivity,order,store')->where($found_where)->limit($page->firstRow, $page->listRows)->select();
		$this->assign('page', $page);
		$this->assign('teamFound', $TeamFound);
		$this->assign('add_time_begin',date('Y-m-d H:i',$begin));
		$this->assign('add_time_end',date('Y-m-d H:i',$end));
		return $this->fetch();
		
	}

	public function order_list(){
		
		$team_id = input('team_id');
		$found_id = input('found_id');
		$add_time_begin = input('add_time_begin',date('Y-m-d', strtotime("-3 month")+86400));
		$add_time_end = input('add_time_end',date('Y-m-d', strtotime('+1 days')));
		$order_status = input('order_status');
		$pay_status = input('pay_status');
		$shipping_status = input('shipping_status');
		$pay_code = input('pay_code');
		$key_type = input('key_type');
		$user_id = input('user_id');
		$order_by = input('order_by');
		$sort = input('sort','DESC');
		$begin = strtotime($add_time_begin);
		$end = strtotime($add_time_end);
		// 搜索条件
		$condition = ['order_prom_type'=>6];
		$keywords = I('keywords','','trim');
		if($key_type != '' && $keywords != ''){
			if($key_type == 'store_name'){
				$store_id_arr = Db::name('store')->where("store_name", "like", '%' . $keywords . '%')->getField('store_id', true);
				if ($store_id_arr) {
					$condition['store_id'] = array('in', $store_id_arr);
				}
			}elseif($key_type == 'order_sn'){
				$condition['order_sn'] = $keywords;
			}elseif($key_type == 'consignee'){
				$condition['consignee'] = $keywords;
			}
		}
		if($begin && $end){
			$condition['add_time'] = array('between',"$begin,$end");
		}
		if($order_status != ''){
			$condition['order_status'] = $order_status;
		}
		if($pay_status != ''){
			$condition['pay_status'] = $pay_status;
		}
		if($pay_code != ''){
			$condition['pay_code'] = $pay_code;
		}
		if($shipping_status != ''){
			$condition['shipping_status'] = $shipping_status;
		}
		if($user_id != ''){
			$condition['user_id'] = $user_id;
		}
		$TeamOrderIds = [];
		if($team_id != ''){
			$TeamFoundOrderId = Db::name('team_found')->where('team_id',$team_id)->getField('order_id',true);
			$TeamFollowOrderId = Db::name('team_follow')->where('team_id',$team_id)->getField('order_id',true);
			$TeamOrderIdByTeamId = array_merge($TeamFoundOrderId,$TeamFollowOrderId);
			$TeamOrderIds = array_merge($TeamOrderIdByTeamId,$TeamOrderIds);
		}
		if($found_id != ''){
			$TeamFollowOrderId = Db::name('team_follow')->where('found_id',$found_id)->getField('order_id',true);
			$TeamFoundOrderId = Db::name('team_found')->where('found_id',$found_id)->getField('order_id',true);
			$TeamOrderIdByFoundId = array_merge($TeamFoundOrderId,$TeamFollowOrderId);
			$TeamOrderIds = array_merge($TeamOrderIdByFoundId,$TeamOrderIds);
		}
		if(count($TeamOrderIds) > 0){
			$condition['order_id'] = ['in',$TeamOrderIds];
		}
		if ($order_by != '') {
			$orderBy = [$order_by => $sort];
		} else {
			$orderBy = ['order_id' => $sort];
		}
		$order = new Order();
		$count = $order->where($condition)->count();
		$page  = new Page($count);
		//获取订单列表
		$orderList = $order->with('teamActivity,teamFollow,teamFound')->where($condition)->limit($page->firstRow,$page->listRows)->order($orderBy)->select();
		$this->assign('orderList',$orderList);
		$this->assign('page',$page);
		$this->assign('add_time_begin',date('Y-m-d H:i',$begin));
		$this->assign('add_time_end',date('Y-m-d H:i',$end));
		return $this->fetch();
		
	}

	/**
	 * 团长佣金
	 */
	public function bonus(){
		
		$found_id = input('found_id');
		if(empty($found_id)){
			$this->error('参数错误');
		}
		$teamFound = TeamFound::get($found_id);
		if(empty($teamFound)){
			$this->error('拼主记录不翼而飞啦~');
		}
		if($teamFound['status'] != 2){
			$this->error('拼团未成功，请确认拼团~');
		}
		$this->assign('teamFound',$teamFound);
		return $this->fetch();
		
	}

	public function doBonus(){
		
		$desc = input('desc','拼团佣金');
		$found_id = input('found_id');
		if(empty($found_id)){
			$this->ajaxReturn(['status'=>0,'msg'=>'参数错误']);
		}
		$teamFound = TeamFound::get($found_id);
		if(empty($teamFound)){
			$this->error('拼主记录不翼而飞啦~');
		}
		if($teamFound['status'] != 2){
			$this->error('拼团未成功，请确认拼团~');
		}
		if($teamFound['bonus_status'] == 1){
			$this->ajaxReturn(['status'=>0,'msg'=>'团长已领取佣金']);
		}
		$doBonus = accountLog($teamFound['user_id'],$teamFound->teamActivity->bonus,0,$desc,0,$teamFound->order->order_id, $teamFound->order->order_sn,0);
		if($doBonus !== false){
			$teamFound->bonus_status = 1;
			$teamFound->save();
			$this->ajaxReturn(['status'=>1,'msg'=>'操作成功','result'=>'']);
		}else{
			$this->ajaxReturn(['status'=>0,'msg'=>'操作失败']);
		}
		
	}
}