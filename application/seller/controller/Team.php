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
 * 拼团控制器
 */

namespace app\seller\controller;

use app\common\model\TeamActivity;
use app\common\model\TeamFound;
use app\seller\logic\TeamActivityLogic;
use think\Loader;
use think\Db;
use think\Page;

class Team extends Base
{
	public function index()
	{
		
		$TeamActivity = new TeamActivity();
		$count = $TeamActivity->where('store_id',STORE_ID)->count();
		$Page = new Page($count, 10);
		$show = $Page->show();
		$list = $TeamActivity->append(['team_type_desc','time_limit_hours','status_desc'])->with('spec_goods_price')->where('store_id',STORE_ID)->limit($Page->firstRow . ',' . $Page->listRows)->select();
		$this->assign('page', $show);
		$this->assign('list', $list);
		return $this->fetch();
		
	}

	/**
	 * 拼团详情
	 * @return mixed
	 */
	public function info()
	{
		
		$team_id = input('team_id');
		if ($team_id) {
			$TeamActivity = new TeamActivity();
			$teamActivity = $TeamActivity->append(['time_limit_hours'])->with('specGoodsPrice,goods')->where(['team_id'=>$team_id,'store_id'=>STORE_ID])->find();
			if(empty($teamActivity)){
				$this->error('非法操作');
			}
			$this->assign('teamActivity', $teamActivity);
		}
		return $this->fetch();
		
	}

	/**
	 * 保存
	 * @throws \think\Exception
	 */
	public function save(){
	
		$data = input('post.');
		$teamValidate = Loader::validate('Team');
		if (!$teamValidate->batch()->check($data)) {
			$this->ajaxReturn(['status' => 0, 'msg' => '操作失败', 'result' => $teamValidate->getError()]);
		}
		if($data['team_id']){
			$teamActivity = TeamActivity::get(['team_id' => $data['team_id'], 'store_id' => STORE_ID]);
			if(empty($teamActivity)){
				$this->ajaxReturn(array('status' => 0, 'msg' => '非法操作','result'=>''));
			}
		}else{
			$teamActivity = new TeamActivity();
		}
		$teamActivity->data($data, true);
		$teamActivity['store_id'] = STORE_ID;
		$row = $teamActivity->allowField(true)->save();
		if($data['item_id'] > 0){
			Db::name('spec_goods_price')->where(['item_id'=>$teamActivity->item_id])->update(['prom_id'=>$teamActivity->team_id,'prom_type'=>6]);
			Db::name('goods')->where(['goods_id'=>$teamActivity->goods_id])->update(['prom_type'=>6,'prom_id'=>0]);
		}else{
			Db::name('goods')->where(['goods_id'=>$teamActivity->goods_id])->update(['prom_id'=>$teamActivity->team_id,'prom_type'=>6]);
		}
		if($row !== false){
			$this->ajaxReturn(['status' => 1, 'msg' => '操作成功', 'result' => '']);
		}else{
			$this->ajaxReturn(['status' => 0, 'msg' => '操作失败', 'result' => '']);
		}
		
	}

	/**
	 * 删除拼团
	 */
	public function delete(){
	
		$team_id = input('team_id');
		if($team_id){
			$order_goods = Db::name('order_goods')->where(['prom_type' => 6, 'prom_id' => $team_id])->find();
			if($order_goods){
				$this->ajaxReturn(['status' => 0, 'msg' => '该活动有订单参与不能删除!', 'result' => '']);
			}
			$teamActivity = TeamActivity::get(['store_id'=>STORE_ID,'team_id'=>$team_id]);
			if($teamActivity){
				if($teamActivity['item_id']){
					Db::name('spec_goods_price')->where('item_id', $teamActivity['item_id'])->save(['prom_type' => 0, 'prom_id' => 0]);
					$goodsPromCount = Db::name('spec_goods_price')->where('goods_id', $teamActivity['goods_id'])->where('prom_type','>',0)->count('item_id');
					if($goodsPromCount == 0){
						Db::name('goods')->where("goods_id", $teamActivity['goods_id'])->save(['prom_type' => 0, 'prom_id' => 0]);
					}
				}else{
					Db::name('goods')->where("goods_id", $teamActivity['goods_id'])->save(['prom_type' => 0, 'prom_id' => 0]);
				}
				$row = $teamActivity->delete();
				if($row !== false){
					$this->ajaxReturn(['status' => 1, 'msg' => '删除成功', 'result' => '']);
				}else{
					$this->ajaxReturn(['status' => 0, 'msg' => '删除失败', 'result' => '']);
				}
			}else{
				$this->ajaxReturn(['status' => 0, 'msg' => '参数错误', 'result' => '']);
			}
		}else{
			$this->ajaxReturn(['status' => 0, 'msg' => '参数错误', 'result' => '']);
		}
		
	}

	/**
	 * 确认拼团
	 * @throws \think\Exception
	 */
	public function confirmFound(){
	
		$found_id = input('found_id');
		if(empty($found_id)){
			$this->ajaxReturn(['status'=>0,'msg'=>'参数错误','result'=>'']);
		}
		$TeamFound = new TeamFound();
		$teamFound = $TeamFound::get(['store_id'=>STORE_ID,'found_id'=>$found_id]);
		if(empty($teamFound)){
			$this->ajaxReturn(['status'=>0,'msg'=>'找不到拼单','result'=>'']);
		}
		if(empty($teamFound->order)){
			$this->ajaxReturn(['status'=>0,'msg'=>'找不到拼单的订单','result'=>'']);
		}
		if($teamFound->Surplus > 0){
			$this->ajaxReturn(['status'=>0,'msg'=>'不满足确认拼团条件，还缺'.$teamFound->Surplus,'result'=>'']);
		}
		if($teamFound->order->order_status > 0){
			$this->ajaxReturn(['status'=>0,'msg'=>'拼单已经确认','result'=>'']);
		}
		$follow_order_id = Db::name('team_follow')->where(['found_id' => $found_id, 'status' => 2])->getField('order_id', true);
		$follow_confirm = Db::name('order')->where('order_id', 'IN', $follow_order_id)->where(['order_prom_type' => 6, 'store_id' => STORE_ID])->update(['order_status' => 1]);
		if($follow_confirm !== false){
			$teamFound->order->order_status = 1;
			$found_confirm = $teamFound->order->save();
			if($found_confirm !== false){
				$this->ajaxReturn(['status'=>1,'msg'=>'拼单确认成功','result'=>'']);
			}else{
				$this->ajaxReturn(['status'=>0,'msg'=>'拼单确认失败','result'=>'']);
			}
		}else{
			$this->ajaxReturn(['status'=>0,'msg'=>'拼单确认失败','result'=>'']);
		}
		
	}

	/**
	 * 拼团退款
	 */
	public function refundFound(){
	
		$found_id = input('found_id');
		if(empty($found_id)){
			$this->ajaxReturn(['status'=>0,'msg'=>'参数错误','result'=>'']);
		}
		$teamFound = TeamFound::get(['store_id'=>STORE_ID,'found_id'=>$found_id]);
		$TeamActivityLogic = new TeamActivityLogic();
		$TeamActivityLogic->setTeamFound($teamFound);
		$result = $TeamActivityLogic->refundFound();
		$this->ajaxReturn($result);
		
	}

	/**
	 * 拼团抽奖
	 */
	public function lottery(){
	
		$team_id = input('team_id/d');
		if(empty($team_id)){
			$this->ajaxReturn(['status'=>0,'msg'=>'参数错误','result'=>'']);
		}
		$team = TeamActivity::get(['store_id'=>STORE_ID,'team_id'=>$team_id]);
		$TeamActivityLogic = new TeamActivityLogic();
		$TeamActivityLogic->setTeam($team);
		$result = $TeamActivityLogic->lottery();
		$this->ajaxReturn($result);
		
	}
}
