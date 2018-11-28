<?php

namespace app\api\controller; 


use think\Db;

class CrowdGoods extends Base {

    //商品列表
    public function lists(){
        $list = Model('Goods')->goodsList(I('p',1));
        $this->ajaxReturn(['status' => 1, 'msg' => '','result'=>$list]);
    }

    //商品详情
    public function detail(){
        !I('id') && $this->ajaxReturn(['status' => -1, 'msg' => '商品id不存在']);
        $info = Model('Goods')->getItem(I('id'));
        $this->ajaxReturn(['status' => 1, 'msg' => '','result'=>$info]);
    }
}