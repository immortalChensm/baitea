<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 订单以及售后中心
 * @author soubao 当燃
 *  @Date: 2016-12-20
 */
namespace app\api\controller;
use think\Db;
use think\Page;

class Tea extends Base 
{
    /**
     * 获取评价
     */
    function getTeartComment()
    {        
        $p       = I('p', 1);
        $teartid = I('teartid/d', 0);       
        empty($teartid) && $this->ajaxReturn(['status'=>-1,'msg'=>'参数错误']);
        $list = \think\Db::name("teart_comment_v")
                        ->where("teart_id",$teartid)
                        ->whereNotNull("comment_id")
                        ->order("add_time","desc")
                        ->page($p,10)
                        ->select();
        $total = \think\Db::name("teart_comment_v")
                        ->where("teart_id",$teartid)
                        ->whereNotNull("comment_id")
                        ->order("add_time","desc")
                        ->count();
        
        $page = ceil($total/10);
        $star = [];
        empty($list) && $this->ajaxReturn(['status'=>-1,'msg'=>'此茶艺师没有评价']);
        foreach ($list as $k=>$v){
            $list[$k]['add_time'] = date("Y-m-d H:i",$v['add_time']);
            $star[] = $v['star'];
        }
        $all = [];
        foreach ($list as $k=>$v){
            $temp = $v;
            $all['list'][] = $temp;
            
        }
        $all['star'] = round(array_sum($star)/count($star),0);
        $this->ajaxReturn(['status'=>1,'msg'=>'获取成功', 'result'=>['list'=>$all,'pages'=>$page]]);
        
    }
    
}
?>