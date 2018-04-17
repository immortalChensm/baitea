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

//活动实体控制器
class Active extends Base {
    
    public function addactive(\app\common\model\Active $active)
    {
        $data['user_id']         = $this->user_id;
        $data['title']           = $this->request->param("title");
        $data['desc']            = $this->request->param("desc");
        $data['active_time']     = $this->request->param("active_time");
        $data['active_location'] = $this->request->param("active_location");
        $data['location_x']      = $this->request->param("location_x");
        $data['location_y']      = $this->request->param("location_y");
        $data['address']         = $this->request->param("address");
        $data['num']             = $this->request->param("num");
        $data['sex']             = $this->request->param("sex");
        $data['consume']         = $this->request->param("consume");
        $data['imglist']         = $this->request->param("imglist");
        $data['add_time']        = time();
        
        $result = $this->validate($data, 'Active');
        $img_num = explode(",", $data['imglist']);
        if(count($img_num)>3) $this->ajaxReturn(['status'=>-1,'msg'=>'最多3张图片']);
        if(!is_bool($result)){
            $this->ajaxReturn(['status'=>-1,'msg'=>$result]);
        }
        if(strtotime($data['active_time'])<time()){
            $this->ajaxReturn(['status'=>-1,'msg'=>'活动时间设置只允许将来时']);
        }
        $data['active_time'] = strtotime($data['active_time']);
        \think\Db::name("active")->save($data) && $this->ajaxReturn(['status'=>1,'msg'=>'发布成功']);
        
    }
    
    public function activelist()
    {
        $p = $this->request->param("p");
        $list = \think\Db::name("active")->order("add_time desc")->page($p?:1,10)->select();
        $user = [];
        foreach ($list as $k=>$v){
            $user[] = $v['user_id'];
            $list[$k]['add_time'] = date("Y-m-d H:i:s",$v['add_time']);
            $list[$k]['active_time'] = date("Y-m-d H:i:s",$v['active_time']);
            
            //报名状态处理
            if(time()>strtotime($v['active_time'])){
                $list[$k]['status'] = '1';//报名中
            }else{
                $list[$k]['status'] = '2';//已结束
            }
        }
        $info = \think\Db::name("users")->field("user_id,realname,head_pic")->whereIn("user_id",$user)->select();
        //茶商
        $tea_merchant = \think\Db::name("store")->field("user_id")->whereIn("user_id",$user)->select();
        //茶艺师
        $tea_art      = \think\Db::name("tea_art")->field("user_id")->whereIn("user_id",$user)->select();
        
        $teaArt = []; 
        foreach ($tea_art as $k=>$v){
            $teaArt[] = $v['user_id'];
        }
        
        $teaMerchant = [];
        foreach ($tea_merchant as $k=>$v){
            $teaMerchant[] = $v['user_id'];
        }
        
        $userInfo = [];
        foreach ($info as $k=>$v){
            $userInfo[$v['user_id']] = ['realname'=>$v['realname'],'head_pic'=>$v['head_pic']];
        }
        foreach ($list as $k=>$v){
            $list[$k]['userinfo'] = $userInfo[$v['user_id']];
            if(in_array($v['user_id'], $teaMerchant)){
                $list[$k]['role'] = '茶商';
            }elseif(in_array($v['user_id'], $teaArt)){
                $list[$k]['role'] = '茶艺师';
            }else{
                $list[$k]['role'] = '茶友';
            }
        }
        $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result'=>$list]);
    }
    
    public function details()
    {
        $article_id = $this->request->param("active_id");
        empty($article_id) && $this->ajaxReturn(['status'=>-1,'msg'=>'活动不存在']);
        $article = \think\Db::name("active")->where("id",$article_id)->find();
        $article['add_time'] = date("Y-m-d H:i:s",$article['add_time']);
        $article['userinfo'] = \think\Db::name("users")->field("realname,head_pic")->where("user_id",$article['user_id'])->find();
        $article['commentNum'] = \think\Db::name("active_comment")->whereIn("active_id",$article['id'])->count("cid");
        $article['commentList'] = \think\Db::name("active_comment")->whereIn("active_id",$article['id'])->select();
        $userId = [];
        foreach ($article['commentList'] as $k=>$v){
            $article['commentList'][$k]['add_time'] = date("Y-m-d H:i:s",$v['add_time']);
            $userId[] = $v['user_id'];
        }
        $userInfo = \think\Db::name("users")->field("user_id,realname,head_pic")->whereIn("user_id",$userId)->select();
        $user_info_arr = [];
        foreach ($userInfo as $k=>$v){
            $user_info_arr[$v['user_id']] = ['realname'=>$v['realname'],'headimg'=>$v['head_pic']];
        }
        foreach ($article['commentList'] as $k=>$v){
            
            $article['commentList'][$k]['commenterInfo'] = $user_info_arr[$v['user_id']];
        }
        
        $teaMerchant = \think\Db::name("store")->where("user_id",$article['user_id'])->find();
        $teaArt = \think\Db::name("tea_art")->where("user_id",$article['user_id'])->find();
        
        if($teaMerchant['user_id']){
            $article['role'] = "茶商";
        }elseif($teaArt['user_id']){
            $article['role'] = "茶艺师";
        }else{
            $article['role'] = "茶友";
        }
        $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result'=>$article]);
    }
    
    //活动的评论
    public function comment()
    {
        $article_id = $this->request->param("active_id");
        $comment    = $this->request->param("content");
        empty($article_id)&& $this->ajaxReturn(['status'=>-1,'msg'=>'参数错误']);
        \think\Db::name("active_comment")->save(['active_id'=>$article_id,'user_id'=>$this->user_id,'content'=>$comment,'add_time'=>time()])
        &&$this->ajaxReturn(['status'=>1,'msg'=>'评论成功']);
    }
    
    //活动删除
    public function remove_activity()
    {
        $article_id = $this->request->param("active_id");
        empty($article_id)&& $this->ajaxReturn(['status'=>-1,'msg'=>'参数错误']);
        $active = \think\Db::name("active")->where(function($query){
            $query->where("user_id",$this->user_id)->where("id",$article_id);
        })->find();
        empty($active['id'])&& $this->ajaxReturn(['status'=>-1,'msg'=>'您的活动不存在无法删除']);
        
        \think\Db::name("active")->where("user_id",$this->user_id)->where("id",$article_id)->delete() && $this->ajaxReturn(['status'=>1,'msg'=>'活动删除成功']);
    }
    
    //活动的报名
    public function join_activity()
    {
        //活动报名条件
        //必须在指定时间内报名
        //超出时间报名时间结束禁止报名
        //报名人数限制
        //报名性别限制
        
        $activity_id = $this->request->param("activity_id");
        empty($activity_id)&& $this->ajaxReturn(['status'=>-1,'msg'=>'参数错误']);
        $active = \think\Db::name("active")->where("id",$activity_id)->find();
        empty($active)&& $this->ajaxReturn(['status'=>-1,'msg'=>'活动不存在']);
        if(time()>$active['active_time']){
            $this->ajaxReturn(['status'=>-1,'msg'=>'报名时间已经结束了下次早点来吧']);
        }
        $join_num = \think\Db::name("activity_join")->where("active_id",$activity_id)->count("user_id");
        if(($join_num+1)>$active['num']){
            $this->ajaxReturn(['status'=>-1,'msg'=>'报名名额没有了']);
        }
        
        $userinfo = \think\Db::name("users")->where("user_id",$this->user_id)->getField("sex");
        if($active['sex']!=$userinfo['sex']){
            $this->ajaxReturn(['status'=>-1,'msg'=>'您不能参加异性群组织的活动']);
        }
        
        $is_join = \think\Db::name("activity_join")->where("user_id",$this->user_id)->find();
        if($is_join['user_id']){
            $this->ajaxReturn(['status'=>1,'msg'=>'您已经报名过了']);
        }
        
        \think\Db::name("activity_join")->save(['user_id'=>$this->user_id,'active_id'=>$activity_id,'add_time'=>time()])
        && $this->ajaxReturn(['status'=>1,'msg'=>'报名成功']);
    }
}
?>