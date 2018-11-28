<?php

namespace app\api\controller; 


use think\Db;

class CrowdOrder extends Base {
    public $cart;
    public $user;
    public $order;
    public function  __construct() {   
        parent::__construct();
        $this->cart = new Cart();
        $this->user = new User();
        $this->order = new Order();
    } 
    
    //订单列表
    public function lists(){
        $this->user->getOrderList(1);
    }

    //订单详情
    public function detail(){
        !I('id') && $this->ajaxReturn(['status' => -1, 'msg' => '请携带订单id']);
        $list = Model('Order')->orderInfo(I('id'));
        $this->ajaxReturn(['status' => 1, 'msg' => '','result'=>$list]);
    }

    //提交订单
    public function submit(){
        !I('item_id') && $this->ajaxReturn(['status' => -1, 'msg' => '请携带规格id']);
        $this->cart->cart3(I('item_id'),1);
    }

    //1取消订单 2确认收货
    public function save(){
        !I('type') && $this->ajaxReturn(['status' => -1, 'msg' => '参数错误']);
        I('type') =='1' ? $this->user->cancelOrder() : $this->user->orderConfirm();
    }

    //删除订单
    public function delete(){
        $this->order->del_order();
    }

}