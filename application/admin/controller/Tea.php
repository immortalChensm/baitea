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
 * Date: 2016-05-27
 */

namespace app\admin\controller;
use think\Page;
use think\Loader;
use think\Db;

class Tea extends Base{
	
	//茶艺师列表
	public function tea_list(){
	    
	    $teart_state = $this->request->param("teart_state");
	    $realname    = $this->request->param("realname");
	    $map  = [];
	    if(!empty($teart_state)){
	        $map['t.teart_state'] = $teart_state;
	        $map['u.realname']    = $realname;
	    }
		$model =  M('tea_art');
		
		$count = $model->alias("t")
		               ->join("__USERS__ u","t.user_id=u.user_id",'LEFT')
		               ->where($map)
		               ->count();
		
		$Page = new Page($count,10);
		
		$list = $model->alias("t")
		              ->join("__USERS__ u","t.user_id=u.user_id",'LEFT')
		              ->where($map)
		              ->order('t.add_time')
		              ->limit($Page->firstRow.','.$Page->listRows)
		              ->select();
		
		$this->assign('list',$list);
		$show = $Page->show();
		$this->assign('pager',$Page);
		$this->assign('page',$show);
		return $this->fetch();
	}
	
	//茶艺师详情
	public function tea_info()
	{
	    if($this->request->isPost()){
	        
	        $data['review_msg']  = $this->request->param("review_msg");
	        $data['teart_state'] = $this->request->param("teart_state");
	        $teart_id            = $this->request->param("teart_id");
	        if(\think\Db::name("tea_art")->where("teart_id",$teart_id)->save($data)){
	            $this->ajaxReturn(['status' => 1, 'msg' => '编辑成功', 'result' => '']);
	        }else{
	            $this->ajaxReturn(['status' => 0, 'msg' => '编辑失败或做任何更新', 'result' => '']);
	        }
	    }
	    $model =  M('tea_art');
	    
	    $list = $model->alias("t")
	                   ->field("t.*,u.realname,u.mobile,u.idcard_fpic")
	                   ->join("__USERS__ u","t.user_id=u.user_id",'LEFT')
	                   ->where('t.teart_id',$this->request->get("teart_id"))
	                   ->find();
	    $this->assign('list',$list);
	    
	    return $this->fetch();
	}
}

?>