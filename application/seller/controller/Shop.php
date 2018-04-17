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
 */

namespace app\seller\controller;

use app\common\model\Shopper;
use think\Db;
use think\Loader;
use think\Page;

class Shop extends Base
{

	public function index()
	{
		$Shop = new \app\common\model\Shop();
		$count = $Shop->where('store_id',STORE_ID)->count();
		$Page = new Page($count, 10);
		$show = $Page->show();
		$list = $Shop->append(['address_region'])->where('store_id', STORE_ID)->limit($Page->firstRow . ',' . $Page->listRows)->select();
		$this->assign('page', $show);
		$this->assign('list', $list);
		return $this->fetch();
	}

	public function info()
	{
		$shop_id = input('shop_id');
		$province_list = Db::name('region')->where(array('parent_id' => 0))->select();
		if($shop_id){
			$Shop = new \app\common\model\Shop();
			$shop = $Shop->where(['shop_id'=>$shop_id, 'store_id'=>STORE_ID])->find();
			if(empty($shop)){
				$this->error('非法操作');
			}
			$city_list = Db::name('region')->where(array('parent_id' => $shop['province_id']))->select();
			$district_list = Db::name('region')->where(array('parent_id' => $shop['city_id']))->select();
			$this->assign('city_list', $city_list);
			$this->assign('district_list', $district_list);
		}
		$this->assign('province_list', $province_list);
		$this->assign('shop', $shop);
		return $this->fetch();
	}

	public function add(){
		$data = input('post.');
		$shopValidate = Loader::validate('Shop');
		if (!$shopValidate->batch()->check($data)) {
			$this->ajaxReturn(['status' => 0, 'msg' => '操作失败', 'result' => $shopValidate->getError()]);
		}
		//添加
		$user_id = Db::name('users')->where(['email|mobile'=>$data['user_name']])->getField('user_id');
		if(empty($user_id)){
			if(check_email($data['user_name'])){
				$user_data['email'] = $data['user_name'];
			}else{
				$user_data['mobile'] = $data['user_name'];
			};
			$user_data['password'] = $data['password'];
			$user_obj = new \app\admin\logic\UsersLogic();
			$add_user_res = $user_obj->addUser($user_data);
			if($add_user_res['status'] !=1) {
				$this->ajaxReturn($add_user_res);
			}
			$user_id = $add_user_res['user_id'];
		}
		$shop = new \app\common\model\Shop();
		$shopper = new Shopper();
		$shop->data($data, true);
		$shop['store_id'] = STORE_ID;
		$shop['user_id'] = $user_id;
		$row = $shop->allowField(true)->save();
		$shopper_data = ['shopper_name'=>$data['shopper_name'],'user_id'=>$user_id,'store_id'=>STORE_ID,'shop_id'=>$shop->shop_id,'is_admin'=>1,'add_time'=>time()];
		$shopper->save($shopper_data);
		if($row !== false){
			$this->ajaxReturn(['status' => 1, 'msg' => '添加成功', 'result' => '']);
		}else{
			$this->ajaxReturn(['status' => 0, 'msg' => '操作失败', 'result' => '']);
		}
	}

	public function save(){
		$data = input('post.');
		if(empty($data['shop_id'])){
			$this->ajaxReturn(['status' => 0, 'msg' => '参数错误', 'result' => '']);
		}
		$Shop = new \app\common\model\Shop();
		$shop = $Shop->where(['store_id'=>STORE_ID,'shop_id'=>$data['shop_id']])->find();
		if(empty($shop)){
			$this->ajaxReturn(['status' => 0, 'msg' => '非法操作', 'result' => '']);
		}
		$Shopper = new Shopper();
		$shopper = $Shopper->where(['user_id'=>$shop['user_id'],'shop_id'=>$shop['shop_id']])->find();
		if(empty($shopper)){
			$this->ajaxReturn(['status' => 0, 'msg' => '非法操作', 'result' => '']);
		}
		$shopValidate = Loader::validate('Shop');
		if (!$shopValidate->scene('edit')->batch()->check($data)) {
			$this->ajaxReturn(['status' => 0, 'msg' => '操作失败', 'result' => $shopValidate->getError()]);
		}
		$shop->data($data, true);
		$row = $shop->allowField(true)->save();
		$shopper_data = ['shopper_name'=>$data['shopper_name']];
		$shopper->save($shopper_data);
		if($row !== false){
			$this->ajaxReturn(['status' => 1, 'msg' => '编辑成功', 'result' => '']);
		}else{
			$this->ajaxReturn(['status' => 0, 'msg' => '编辑失败', 'result' => '']);
		}
	}
}
