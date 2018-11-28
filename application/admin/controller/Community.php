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

use think\Page;
use app\admin\logic\ArticleCatLogic;
use think\Loader;

class Community extends Base {

    public function categoryList(){
        $ArticleCat = new ArticleCatLogic(); 
        $cat_list = $ArticleCat->article_cat_list(0, 0, false);
        $this->assign('cat_list',$cat_list);
        return $this->fetch('categoryList');
    }

    public function category()
    {
        $ArticleCat = new ArticleCatLogic();
        $act = I('get.act', 'add');
        $cat_id = I('get.cat_id/d');
        $parent_id = I('get.parent_id/d');
        if ($cat_id) {
            $cat_info = M('article_cat')->where('cat_id=' . $cat_id)->find();
            $parent_id = $cat_info['parent_id'];
            $this->assign('cat_info', $cat_info);
        }
        $cats = $ArticleCat->article_cat_list(0, $parent_id, true);
        $this->assign('act', $act);
        $this->assign('cat_select', $cats);
        return $this->fetch();
    }
    
    //帖子的列表
    public function articleList(){
        $Article =  M('ArticleTea'); 
        $res = $list = array();
        $p = empty($_REQUEST['p']) ? 1 : $_REQUEST['p'];
        $size = empty($_REQUEST['size']) ? 20 : $_REQUEST['size'];
        
        $where = " 1 = 1 ";
        $keywords = trim(I('keywords'));
        $keywords && $where.=" and title like '%$keywords%' ";
        
       
        $res = $Article->where($where)->order('id desc')->page("$p,$size")->select();
        $count = $Article->where($where)->count();// 查询满足要求的总记录数
        $pager = new Page($count,$size);// 实例化分页类 传入总记录数和每页显示的记录数
        //$page = $pager->show();//分页显示输出
        $articleId = [];
        $admin_articleId = [];
        foreach ($res as $k=>$v){
            $res[$k]['add_time'] = date("Y-m-d H:i",$v['add_time']);
            //if($v['type']==1){
            //    $admin_articleId[] = $v['id'];
            //}else{
                $articleId[] = $v['id'];
            //}
        }
       
        $comment = \think\Db::name("article_comment")->whereIn("article_id",$articleId)->select();
        $commentNum = [];
        foreach ($comment as $k=>$v){
           
            $commentNum[$v['article_id']][] = $v['user_id'];
        }
        
       
        $subnum = $this->getpraise($articleId);
        $userId = [];
        foreach ($res as $k=>$v){
            $res[$k]['subscribe_num'] = count($subnum[$v['id']]);
            $res[$k]['commentNum'] = count($commentNum[$v['id']]);
            $userId[]= $v['user_id']; 
        }
        $user = $this->getuserinfo($userId);
        $admin_user = $this->getadminuser($userId);
        foreach ($res as $k=>$v){
            if($v['type']==1){
                $res[$k]['user'] = $admin_user[$v['user_id']];
            }else{
                $res[$k]['user'] = $user[$v['user_id']];
            }
            
        }
        $this->assign('list',$res);// 赋值数据集
        $this->assign('pager',$pager);// 赋值分页输出        
		return $this->fetch('articleList');
    }
    //取得后台管理员发布的帖子公告
    public function getadminuser($admin_articleId)
    {
        $list = \think\Db::name("admin")->whereIn("admin_id",$admin_articleId)->select();
        $user = [];
        foreach ($list as $k=>$v){
            $user[$v['admin_id']] = $v['user_name'];
        }
        return $user;
    }

    //添加社区公告
    public function add_articletea()
    {
        if($this->request->param("act")=='edit'){
            $info = \think\Db::name("article_tea")->where("id",$this->request->param("article_id"))->find();
            $info['thumb'] = explode(",", $info['imglist']);
            $this->assign("info",$info);
        }
        $this->assign("act",I("act"));
        return $this->fetch("community");
    }
    
    public function getuserinfo($userId)
    {
        $list = db("users")->whereIn("user_id",$userId)->select();
        $user = [];
        foreach($list as $k=>$v){
            $user[$v['user_id']] = $v['realname']?:$v['nickname'];
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
        //print_r($articleId);
        //print_r($article_sub);
        return $article_sub;
    
    }
    
    //帖子详情
    public function detail()
    {
        $id = I("article_id");
        $info = \think\Db::name("article_tea")->where("id",$id)->find();
        $info['img'] = explode(",", $info['imglist']);
        $img = [];
        foreach ($info['img'] as $v){
                if($v[0]=='.'){
                    $img[] = substr($v,1);
                }else{
                    $img[] = $v;
                }
               
        }
        $info['imgs'] = $img;
        //该帖子的评论量
        $info['commentNum'] = \think\Db::name("article_comment")->whereIn("article_id",$info['id'])->count("user_id");
        //帖子的点赞量
        $info['clickNum']   = \think\Db::name("article_teasub")->where(function($query)use($info){
            $query->whereIn("article_id",$info['id'])->where("status",1);
        })->count("user_id");
        
        if($info['type']==1){
            $user = \think\Db::name("admin")->where("admin_id",$info['user_id'])->find();
            $info['username'] = $user['user_name'];
            
        }else{
            $user = \think\Db::name("users")->where("user_id",$info['user_id'])->find();
            $info['username'] = $user['realname']?:$user['nickname'];
        }
       
        
        
        $this->assign("info",$info);
       
        return $this->fetch("details");
    }
    
    //评论列表
    public function commentList(){
        $Article =  M('ArticleComment');
        $res = $list = array();
        $p = empty($_REQUEST['p']) ? 1 : $_REQUEST['p'];
        $size = empty($_REQUEST['size']) ? 20 : $_REQUEST['size'];
    
        $where = " 1 = 1 ";
        $keywords = trim(I('keywords'));
        $keywords && $where.=" and `title` like '%$keywords%' ";
    
    
        $res = $Article->where($where)
        ->alias("ac")
        ->join("__ARTICLE_TEA__ a","a.id=ac.article_id")
        ->join("__USERS__ u","u.user_id=ac.user_id")
        ->order('ac.cid desc')
        ->page("$p,$size")
        ->select();
         
        $count = $Article->where($where)
        ->alias("ac")
        ->join("__ARTICLE_TEA__ a","a.id=ac.article_id")
        ->join("__USERS__ u","u.user_id=ac.user_id")
        ->order('ac.cid desc')->count("id");// 查询满足要求的总记录数
        $pager = new Page($count,$size);// 实例化分页类 传入总记录数和每页显示的记录数
        //$page = $pager->show();//分页显示输出
        foreach ($res as $k=>$v){
            $res[$k]['add_time'] = date("Y-m-d H:i",$v['add_time']);
        }
        $this->assign('list',$res);// 赋值数据集
        $this->assign('pager',$pager);// 赋值分页输出
        return $this->fetch('commentList');
    }
    public function article(){
        $ArticleCat = new ArticleCatLogic();
 		$act = I('GET.act','add');
        $info = array();
        $info['publish_time'] = time()+3600*24;
        if(I('GET.article_id')){
           $article_id = I('GET.article_id');
           $info = M('article')->where('article_id='.$article_id)->find();
        }
        $cats = $ArticleCat->article_cat_list(0,$info['cat_id']);
        $this->assign('cat_select',$cats);
        $this->assign('act',$act);
        $this->assign('info',$info);
        return $this->fetch();
    }
    
    
    public function categoryHandle()
    {
    	$data = I('post.');

        $result = $this->validate($data, 'ArticleCategory.'.$data['act'], [], true);
        if ($result !== true) {
            $this->ajaxReturn(['status' => 0, 'msg' => '参数错误', 'result' => $result]);
        }
        
        if ($data['act'] == 'add') {
            $r = M('article_cat')->add($data);
        } elseif ($data['act'] == 'edit') {
        	$cat_info = M('article_cat')->where("cat_id",$data['cat_id'])->find();
        	if($cat_info['cat_type'] == 1 && $data['parent_id'] > 1){
        		$this->ajaxReturn(['status' => -1, 'msg' => '可更改系统预定义分类的上级分类']);
        	}
        	$r = M('article_cat')->where("cat_id",$data['cat_id'])->save($data);
        } elseif ($data['act'] == 'del') {
        	if($data['cat_id']<9){
        		$this->ajaxReturn(['status' => -1, 'msg' => '系统默认分类不得删除']);
        	}
        	if (M('article_cat')->where('parent_id', $data['cat_id'])->count()>0)
        	{
        		$this->ajaxReturn(['status' => -1, 'msg' => '还有子分类，不能删除']);
        	}
        	if (M('article')->where('cat_id', $data['cat_id'])->count()>0)
        	{
        		$this->ajaxReturn(['status' => -1, 'msg' => '该分类下有文章，不允许删除，请先删除该分类下的文章']);
        	}
        	$r = M('article_cat')->where('cat_id', $data['cat_id'])->delete();
        }
        
        if (!$r) {
            $this->ajaxReturn(['status' => -1, 'msg' => '操作失败']);
        } 
        $this->ajaxReturn(['status' => 1, 'msg' => '操作成功']);
    }
    
    
    //帖子的删除操作
    public function aticleHandle()
    {
        $data = I('post.');
        $data['publish_time'] = strtotime($data['publish_time']);
        $data['type'] = 1;  //表示平台发布的
        $data['user_id'] = session("admin_id");
       
        //$referurl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : U('Admin/Article/articleList');
        
        $result = $this->validate($data, 'ArticleTea.'.$data['act'], [], true);
        if ($result !== true) {
            $this->ajaxReturn(['status' => 0, 'msg' => '参数错误', 'result' => $result]);
        }
        if ($data['act'] == 'add') {
            $data['imglist'] = implode(",", $data['imglist']);
            $data['click'] = mt_rand(1000,1300);
        	$data['add_time'] = time(); 
            $r = M('ArticleTea')->add($data);
        } elseif ($data['act'] == 'edit') {
            $data['imglist'] = implode(",", $data['imglist']);
            $r = M('ArticleTea')->where('id='.$data['article_id'])->save($data);
        } elseif ($data['act'] == 'del') {
        	$r = M('ArticleTea')->where('id='.$data['article_id'])->delete(); 	
        }
        
        if (!$r) {
            $this->ajaxReturn(['status' => -1, 'msg' => '操作失败']);
        }
            
        $this->ajaxReturn(['status' => 1, 'msg' => '操作成功']);
    }
    
    
    public function link(){
    	$act = I('GET.act','add');
    	$this->assign('act',$act);
    	$link_id = I('GET.link_id');
    	$link_info = array();
    	if($link_id){
    		$link_info = M('friend_link')->where('link_id='.$link_id)->find();
    		$this->assign('info',$link_info);
    	}
    	return $this->fetch();
    }
    
    public function linkList(){
    	$Ad =  M('friend_link');
        $p = $this->request->param('p');
    	$res = $Ad->order('orderby')->page($p.',10')->select();
    	if($res){
    		foreach ($res as $val){
    			$val['target'] = $val['target']>0 ? '开启' : '关闭';
    			$list[] = $val;
    		}
    	}
    	$this->assign('list',$list);// 赋值数据集
    	$count = $Ad->count();// 查询满足要求的总记录数
    	$Page = new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
    	$show = $Page->show();// 分页显示输出
        $this->assign('pager',$Page);
    	$this->assign('page',$show);// 赋值分页输出
    	return $this->fetch();
    }
    
    public function linkHandle(){
        $data = I('post.');
    	if($data['act'] == 'del'){
    		$r = M('friend_link')->where('link_id='.$data['link_id'])->delete();
    		if($r) exit(json_encode(1));
    	}
        $result = $this->validate($data,'FriendLink.'.$data['act'], [], true);
        if(true !== $result){
            // 验证失败 输出错误信息
            $validate_error = '';
            foreach ($result as $key =>$value){
                $validate_error .=$value.',';
            }
            $this->error($validate_error);
        }
        if($data['act'] == 'add'){
            $r = M('friend_link')->insert($data);
        }
        if($data['act'] == 'edit'){
            $r = M('friend_link')->where('link_id='.$data['link_id'])->save($data);
        }
    	if($r){
    		$this->error("操作成功",U('Admin/Article/linkList'));
    	}else{
            $this->error("操作失败");
    	}
    }
    
    public function helpList(){
        $ArticleCat = new ArticleCatLogic();
    	$Article =  M('help');
    	$res = $list = array();
    	$p = empty($_REQUEST['p']) ? 1 : $_REQUEST['p'];
    	$size = empty($_REQUEST['size']) ? 20 : $_REQUEST['size'];
    	$where = " 1 = 1 ";
    	$keywords = trim(I('keywords'));
    	$keywords && $where.=" and help_title like '%$keywords%' ";
    	$type_id = I('type_id',0);
    	$type_id && $where.=" and type_id = $type_id ";
    	$res = $Article->where($where)->order('help_id desc')->page("$p,$size")->select();
    	$count = $Article->where($where)->count();
    	$pager = new Page($count,$size);
    	$all_type = M('help_type')->where(array('help_show'=>1))->getField('type_id,type_name,pid');
    	if(!empty($all_type)){
			$type_tree = $ArticleCat->getCatTree($all_type);
			$cat_select = $ArticleCat->exportTree($type_tree);
			$this->assign('cat_select',$cat_select);
			$this->assign('all_type',$all_type);
    	}
    	$this->assign('type_id',$type_id);
    	$this->assign('list',$res);
    	$this->assign('pager',$pager);
    	return $this->fetch();
    }
    
    public function helpInfo(){
    	$act = I('GET.act','add');
    	$help_id = I('help_id/d');
    	if($help_id>0){
    		$info = M('help')->where('help_id='.$help_id)->find();
    		$this->assign('info',$info);
    	}
        $ArticleCat = new ArticleCatLogic();
    	$all_type = M('help_type')->where(array('help_show'=>1))->getField('type_id,type_name,pid');
    	if(!empty($all_type)){
    		$all_type = $ArticleCat->getCatTree($all_type);
    		$select_id = !empty($info) ? $info['type_id'] : 0 ;
    		$cat_select = $ArticleCat->exportTree($all_type,0,$select_id);
    		$this->assign('cat_select',$cat_select);
    	}
    	$this->assign('act',$act);
    	return $this->fetch();
    }
    
    public function helpHandle()
    {
    	$data = I('post.');
    	if(empty($data['help_title']) && $data['act'] != 'del'){
    		$this->ajaxReturn(['status' => -1, 'msg' => '标题不能为空']);
    	}
        $validate = loader::Validate('Help');
        if (!$validate->scene($data['act'])->check($data)) {
            $error = $validate->getError();
            $this->ajaxReturn(['status' => -1,'msg' => $error]);
        }
    	if ($data['act'] == 'add') {
    		$data['add_time'] = time();
    		$r = M('help')->add($data);
    	} elseif ($data['act'] == 'edit') {
    		$r = M('help')->where('help_id='.$data['help_id'])->save($data);
    	} elseif ($data['act'] == 'del') {
            if($data['help_id']<11){
                $this->ajaxReturn(['status' => -1, 'msg' => '系统默认分类不得删除']);
            }
    		$r = M('help')->where('help_id='.$data['help_id'])->delete();
    	}
    	if (!$r) {
    		$this->ajaxReturn(['status' => -1, 'msg' => '操作失败']);
    	}
    	$this->ajaxReturn(['status' => 1, 'msg' => '操作成功']);
    }
    
    public function helpTypeList(){
        $all_type = M('help_type')->where(array('help_show'=>1))->order('type_id')->getField('type_id,type_name,pid,sort_order,is_show,level');
        $all_type2 = getSortCatArray($all_type,'type_id');
    	$this->assign('cat_list',$all_type2);
        return $this->fetch();
    }
    
    
    public function helpTypeInfo(){
       	$all_type = M('help_type')->where(['help_show'=>1,'level'=>0])->getField('type_id,type_name,pid');
        $ArticleCat = new ArticleCatLogic();
    	if(!empty($all_type)){
			$all_type = $ArticleCat->getCatTree($all_type);
			$cat_select = $ArticleCat->exportTree($all_type);
			$this->assign('cat_select',$cat_select);
    	}
    	$type_id = I('type_id/d');
    	if($type_id>0){
    		$type_info = M('help_type')->where(array('type_id'=>$type_id))->find();
    		$this->assign('cat_info',$type_info);
    	}
    	$act = I('get.act', 'add');
    	$this->assign('act', $act);
    	return $this->fetch();
    }
    
    public function helpTypeHandle(){
    	$data = I('post.');
    	if($data['pid']>0){
    		$data['level'] = M('help_type')->where(array('type_id'=>$data['pid']))->getField('level')+1;
    	}
        $validate = loader::Validate('HelpType');
        if (!$validate->scene($data['act'])->check($data)) {
            $error = $validate->getError();
            $this->ajaxReturn(['status' => -1,'msg' => $error]);
        }
    	if ($data['act'] == 'add') {
    		$r = M('help_type')->add($data);
    	} elseif ($data['act'] == 'edit') {
    		$r = M('help_type')->where("type_id",$data['type_id'])->save($data);
    	} elseif ($data['act'] == 'del') {
    		$r = M('help_type')->where('type_id', $data['type_id'])->delete();
    	}
    	if (!$r) {
    		$this->ajaxReturn(['status' => -1, 'msg' => '操作失败']);
    	}
    	$this->ajaxReturn(['status' => 1, 'msg' => '操作成功']);
    }
    
}