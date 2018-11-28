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

class Live extends Base{
	
	//列表
	public function livelist(){
	    
	    $teart_state = $this->request->param("teart_state");
	    $realname    = $this->request->param("realname");
	    $map  = [];
	    if(!empty($teart_state)){
	        $map['t.teart_state'] = $teart_state;
	        $map['u.realname']    = $realname;
	    }
		$model =  M('LiveApply');
		
		$count = $model->alias("l")
		               ->field([
		                   "l.id",
		                   "l.username",
		                   "u.mobile",
		                   "u.realname",
		                   "l.add_time"
		               ])
		               ->join("__USERS__ u","l.userid=u.user_id",'LEFT')
		               ->where($map)
		               ->count();
		
		$Page = new Page($count,10);
		
		$list = $model->alias("l")
                		->field([
                		    "l.id",
                		    "l.username",
                		    "u.mobile",
                		    "u.realname",
                		    "l.add_time",
                		    "l.status",
                		    "u.user_id"
                		])
		              ->join("__USERS__ u","l.userid=u.user_id",'LEFT')
		              ->where($map)
		              ->order('l.add_time')
		              ->limit($Page->firstRow.','.$Page->listRows)
		              ->select();
		
		$this->assign('list',$list);
		
		$show = $Page->show();
		$this->assign('pager',$Page);
		$this->assign('page',$show);
		return $this->fetch();
	}
	
	//详情
	public function liveinfo()
	{
	    if($this->request->isPost()){
	        
	        $data['mark']  = $this->request->param("mark");
	        $data['status'] = $this->request->param("status");
	        $id            = $this->request->param("id");
	        if(\think\Db::name("live_apply")->where("id",$id)->save($data)){
	            $this->ajaxReturn(['status' => 1, 'msg' => '编辑成功', 'result' => '']);
	        }else{
	            $this->ajaxReturn(['status' => 0, 'msg' => '编辑失败或做任何更新', 'result' => '']);
	        }
	    }
	    $model =  M('LiveApply');
	    
	    $list = $model->alias("l")
	                   ->field("l.*,u.realname,u.mobile,u.idcard_fpic")
	                   ->join("__USERS__ u","l.userid=u.user_id",'LEFT')
	                   ->where('l.id',$this->request->get("id"))
	                   ->find();
	    if(strpos($list['idcard_fpic'],'.')==0){
	        $list['idcard_fpic'] = substr($list['idcard_fpic'], 1);
	    }
	    $this->assign('list',$list);
	    
	    return $this->fetch();
	}
	
	/*删除*/
	public function live_del(){
	    $liveid = I('del_id');
	    if($liveid){
	        if(Db::name("live_apply")->where("id",$liveid)->delete()){
	            $this->ajaxReturn(['status' => 1, 'msg' => '删除成功']);
	        }
	    }else{
	        $this->ajaxReturn(['status' => 0, 'msg' => '参数错误', 'result' => '']);
	    }
	}
}

?>