<?php
/**
 * tpshop
 * ============================================================================
 * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 商业用途务必到官方购买正版授权, 使用盗版将严厉追究您的法律责任。
 * ============================================================================
 * Author: wangqh
 * Date: 2015-09-09
 *  短信平台短信模板管理
 */
namespace app\admin\controller; 

class SmsTemplate extends Base{

    public  $send_scene;
    
    public function _initialize() {
        parent::_initialize();
        
        // 短信使用场景
        $this->send_scene = C('SEND_SCENE');
        $this->assign('send_scene', $this->send_scene);
        
    }
    
    public function index(){        
        $smsTpls = M('sms_template')->select();
	$this->assign('smsTplList',$smsTpls);        
        return $this->fetch("sms_template_list");       
    }
    
    /**
     * 添加修改编辑  短信模板
     */
    public  function addEditSmsTemplate(){
        
        $id = I('tpl_id/d',0);
        $model = M("sms_template");
        
        if(IS_POST)
        {    
            $data = I('post.');
            $data['add_time'] = time();            
            
            if($id){
                $model->update($data);
            }else{
                $id = $model->save($data);
            }
            $this->success("操作成功!!!",U('Admin/SmsTemplate/index'));
            exit;
        } 
        
        
        if($id){
            //进入编辑页面
            $smsTemplate = $model->where(" tpl_id = ".$id)->find(); 
            $this->assign("smsTpl" , $smsTemplate );
            $sceneName = $this->send_scene[$smsTemplate['send_scene']][0];
            $sendscene = $smsTemplate['send_scene'];
            $this->assign("send_name" , $sceneName );
            $this->assign("send_scene_id" , $sendscene );
        }else{
            //进入添加页面
            //查找已经添加了的短信模板
            $scenes = $model->getField("send_scene" , true);
            $filterSendscene = array();
            //过滤已经添加过滤的短信模板
            foreach ($this->send_scene as $key => $value){
                if(!in_array($key, $scenes)){
                    $filterSendscene[$key] = $value;
                }
            }
        }
         
        
        $this->assign("send_scene" , $filterSendscene );
        return $this->fetch("_smsTemplate");
    }
    
    /**
     * 删除订单
     */
   public function delTemplate(){
       $id = I('id');
       $model = M("sms_template");
       $row = $model->where(array('tpl_id' => $id))->delete();
       if ($row){
           $return_arr = array('status' => 1,'msg' => '删除成功','data'  =>'',);   //$return_arr = array('status' => -1,'msg' => '删除失败','data'  =>'',);
       }else{
           $return_arr = array('status' => -1,'msg' => '删除失败','data'  =>'',);  
       } 
       $this->ajaxReturn($return_arr,'json');
       
   }

}