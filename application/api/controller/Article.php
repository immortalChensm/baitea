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


class Article extends Base {
    
    public function addarticle()
    {
        $data['user_id'] = $this->user_id;
        $data['title']   = $this->request->param("title");
        $data['content'] = $this->request->param("content");
        $data['imglist'] = $this->request->param("imglist");
        $data['add_time']= time();
        
        $result = $this->validate($data, [
            'title'=>'require|min:2',
            'content'=>'require',
        ],[
            'title.require'=>'帖子标题写一个吧',
            'title.min'=>'帖子标题最少２个字',
            'content.require'=>'帖子内容来点吧'
        ]);
        
        $img_num = explode(",", $data['imglist']);
        if(count($img_num)>3) $this->ajaxReturn(['status'=>-1,'msg'=>'最多3张图片']);
        if(!is_bool($result)){
            $this->ajaxReturn(['status'=>-1,'msg'=>$result]);
        }
        \think\Db::name("article_tea")->save($data) && $this->ajaxReturn(['status'=>1,'msg'=>'发布成功']);
    }
    
    public function articlelist()
    {
        $p = $this->request->param("p");
        //empty($this->user_id) && $this->ajaxReturn(['status'=>-1,'msg'=>'需要您传递token']);
        if($this->request->param("type")){
            $list = \think\Db::name("article_tea")->where("type",$this->request->param("type"))->order("add_time desc")->page($p?:1,10)->select();
            
        }else{
            $list = \think\Db::name("article_tea")->order("add_time desc")->page($p?:1,10)->select();
            
        }
        
        $user = [];
        $articleId = [];
        foreach ($list as $k=>$v){
            $user[] = $v['user_id'];
            $list[$k]['add_time'] = date("Y-m-d H:i:s",$v['add_time']);
            $articleId[] = $v['id'];
        }
        $info = \think\Db::name("users")->field([
            "mobile","user_id","nickname"=>"realname","head_pic"
        ])->whereIn("user_id",$user)->select();
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
            
            if($this->user_id==$v['user_id']){
                $name = $v['realname']?:$v['mobile'];
            }else{
                $name = $v['realname']?:substr($v['mobile'],0,3).'****'.substr($v['mobile'], -3,5);
            }
            
            $userInfo[$v['user_id']] = [
                
                'realname'=>$name,
                
                
                'head_pic'=>$v['head_pic']
            ];
            
            
        }
        //print_r($userInfo);
        //print_r($info);
        $subscribe =  $this->getpraise($articleId);
        $is_substatus = $this->getsubstatus($articleId);
       
        foreach ($list as $k=>$v){
            $list[$k]['userinfo'] = $userInfo[$v['user_id']];
            if(in_array($v['user_id'], $teaMerchant)){
                $list[$k]['role'] = '茶商';
            }elseif(in_array($v['user_id'], $teaArt)){
                $list[$k]['role'] = '茶艺师';
            }else{
                $list[$k]['role'] = '茶友';
            }
            //获取每一个帖子的关注人数
            $list[$k]['subnum'] = count($subscribe[$v['id']]);
            
            //这家伙是否关注了
            $list[$k]['is_subscribe_this_article'] = $is_substatus[$v['id'].$this->user_id]?:'2';
        }
       
        
        $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result'=>$list]);
    }
    //社区公告列表
    public function communitylist()
    {
        $p = $this->request->param("p");
    
        $list = \think\Db::name("article_tea")->where("type",1)->order("add_time desc")->page($p?:1,10)->select();
        $user = [];
        $articleId = [];
        foreach ($list as $k=>$v){
            $user[] = $v['user_id'];
            $list[$k]['add_time'] = date("Y-m-d H:i:s",$v['add_time']);
            $articleId[] = $v['id'];
        }
        $info = \think\Db::name("admin")->whereIn("admin_id",$user)->select();
        
        $userInfo = [];
        foreach ($info as $k=>$v){
            
            
            $userInfo[$v['user_id']] = [
                'realname'=>$v['user_name'],
                'head_pic'=>'null'
                
            ];
        }
    
        $subscribe =  $this->getpraise($articleId);
        $is_substatus = $this->getsubstatus($articleId);
        foreach ($list as $k=>$v){
            $list[$k]['userinfo'] = $userInfo[$v['user_id']];
            $list[$k]['role'] = '平台';
            //获取每一个帖子的关注人数
            $list[$k]['subnum'] = count($subscribe[$v['id']]);
            //这家伙是否关注了
            $list[$k]['is_subscribe_this_article'] = $is_substatus[$v['id'].$this->user_id]?:'2';
        }
         
    
        $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result'=>$list]);
    }
    
    //获取用户是否关注帖子
    public function getsubstatus($articleId)
    {
        $article = db("article_teasub")->whereIn("article_id",$articleId)->select();
        $user = [];
        foreach($article as $k=>$v){
            //if($this->user_id==$v['user_id']&&$v['status']==1){
            //    $user[$v['article_id'].$v['user_id']] = '1';
            //}else{
                $user[$v['article_id'].$v['user_id']] = $v['status'];
            //}
        }
        return $user;
    }
    
    //获取所有帖子的点赞数据
    public function getpraise($articleId)
    {
        $list = \think\Db::name("article_teasub")->whereIn("article_id",$articleId)->where("status",1)->select();
        $article_sub = [];
        foreach ($list as $k=>$v){
            $article_sub[$v['article_id']][] = $v['user_id'];
        }
        
        return $article_sub;
        
    }
    
    public function details()
    {
        $article_id = $this->request->param("article_id");
        empty($article_id) && $this->ajaxReturn(['status'=>-1,'msg'=>'帖子不存在']);
        $article = \think\Db::name("article_tea")->where("id",$article_id)->find();
        $article['add_time'] = date("Y-m-d H:i:s",$article['add_time']);
        
        
        $article['userinfo'] = \think\Db::name("users")->field([
            "mobile","user_id","nickname"=>"realname","head_pic"
        ])->where("user_id",$article['user_id'])->find();
        
        if($this->user_id==$article['user_id']){
                $name = $article['userinfo']['realname']?:$article['userinfo']['mobile'];
            }else{
                $name = $article['userinfo']['realname']?:substr($article['userinfo']['mobile'],0,3).'****'.substr($article['userinfo']['mobile'], -3,5);
            }
            
        $article['userinfo']['realname'] = $name;
        
        
        $article['commentNum'] = \think\Db::name("article_comment")->whereIn("article_id",$article['id'])->count("cid");
        $article['commentList'] = \think\Db::name("article_comment")->whereIn("article_id",$article['id'])->select();
        $userId = [];
        foreach ($article['commentList'] as $k=>$v){
            $article['commentList'][$k]['add_time'] = date("Y-m-d H:i:s",$v['add_time']);
            $userId[] = $v['user_id'];
        }
        $userInfo = \think\Db::name("users")->field([
            "mobile","user_id","nickname"=>"realname","head_pic"
        ])->whereIn("user_id",$userId)->select();
        $user_info_arr = [];
        foreach ($userInfo as $k=>$v){
            
            if($this->user_id==$v['user_id']){
                $name = $v['realname']?:$v['mobile'];
            }else{
                $name = $v['realname']?:substr($v['mobile'],0,3).'****'.substr($v['mobile'], -4,4);
            }
            
            
            $user_info_arr[$v['user_id']] = [
                'realname'=>$name,
                'headimg'=>$v['head_pic']
                
            ];
        }
        foreach ($article['commentList'] as $k=>$v){
            
            $article['commentList'][$k]['commenterInfo'] = $user_info_arr[$v['user_id']];
        }
        
        $subscribe =  $this->getpraise($article['id']);
        
        $article['subnum'] = count($subscribe[$article['id']]);
        
        $is_substatus = $this->getsubstatus($article_id);

        //这家伙是否关注了
        $article['is_subscribe_this_article'] = $is_substatus[$article['id'].$this->user_id]?:'2';
        
        $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result'=>$article]);
    }
    
    //帖子的评论
    public function comment()
    {
        $article_id = $this->request->param("article_id");
        $comment    = $this->request->param("content");
        empty($article_id)&& $this->ajaxReturn(['status'=>-1,'msg'=>'参数错误']);
        \think\Db::name("article_comment")->save(['article_id'=>$article_id,'user_id'=>$this->user_id,'content'=>$comment,'add_time'=>time()])
        &&$this->ajaxReturn(['status'=>1,'msg'=>'评论成功']);
    }
    
   //帖子的点赞
   public function clickpraise()
   {
       $article_id = I("article_id");
       $userid = $this->user['user_id'];
       
       empty($userid) && $this->ajaxReturn(['status'=>-1,'msg'=>'您没有登录']);
       empty($article_id)&& $this->ajaxReturn(['status'=>-1,'msg'=>'参数错误']);
       $article = db("article_tea")->where("id",$article_id)->find();
       if($article['id']){
           
           $is_praise = db("article_teasub")->where(function($query)use($article_id,$userid){
               $query->where("article_id",$article_id)->where("user_id",$userid);
           })->find();
           //已经点赞过的
           if($is_praise['status']==1){
               \think\Db::name("article_teasub")->where(function($query)use($article_id,$userid){
                   $query->where("article_id",$article_id)->where("user_id",$userid);
               })->save(['status'=>2]) &&$this->ajaxReturn(['status'=>1,'msg'=>'取消点赞成功']);
               
           }elseif($is_praise['status']==2){
               \think\Db::name("article_teasub")->where("article_id",$article_id)->where("user_id",$userid)->save([
                   'article_id'=>$article_id,
                   'user_id'=>$userid,
                   'add_time'=>time(),
                   'status'=>1
               ]) &&$this->ajaxReturn(['status'=>1,'msg'=>'点赞成功']);
           }else{
               \think\Db::name("article_teasub")->save([
                   'article_id'=>$article_id,
                   'user_id'=>$userid,
                   'add_time'=>time(),
                   'status'=>1
               ]) &&$this->ajaxReturn(['status'=>1,'msg'=>'点赞成功']);
           }
           $this->ajaxReturn(['status'=>1,'msg'=>'点赞失败']);
       }else{
           $this->ajaxReturn(['status'=>-1,'msg'=>'帖子不存在']);
       }
   }
   
   
    
}
?>