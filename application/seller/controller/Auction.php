<?php 
namespace app\seller\controller;

use app\common\model\TeamFollow;
use app\common\model\TeamFound;
use app\seller\logic\OrderLogic;
use app\seller\logic\GoodsLogic;
use think\AjaxPage;
use think\Db;
use think\Page;

class Auction extends Base
{

    /*
     *拍卖品订单首页
     */
    public function index()
    {
        $begin = date('Y-m-d', strtotime("-3 month"));//30天前
        $end = date('Y-m-d', strtotime('+1 days'));
        $this->assign('timegap', $begin . '-' . $end);
        $this->assign('begin', date('Y-m-d', strtotime("-3 month")+86400));
        $this->assign('end', date('Y-m-d', strtotime('+1 days')));
        return $this->fetch();
    }

    /*
     *Ajax首页
     */
    public function ajaxindex()
    {
        $select_year = getTabByTime(I('add_time_begin')); // 表后缀
        $begin = strtotime(I('add_time_begin'));
        $end   = strtotime(I('add_time_end'));

        // 搜索条件 STORE_ID
        $condition = array('store_id' => STORE_ID); // 商家id
        //I('consignee') ? $condition['consignee'] = trim(I('consignee')) : false;
        if ($begin && $end) {
            $condition['add_time'] = array('between', "$begin,$end");
        }
        $addressid = M("user_address")->where("consignee",I('consignee'))->value("address_id");
        if($addressid){
            $condition['address_id'] = $addressid;
        }
        I('ordersn') ? $condition['ordersn'] = trim(I('ordersn')) : false;
        I('order_status') != '' ? $condition['order_status'] = I('order_status/d') : false;
        //I('pay_pay') != '' ? $condition['pay_pay'] = I('pay_pay') : false;

        //获取拍卖现场中　　拍卖品已经达到结拍时间且出价最高的人
        $maxAuctionPriceList = $this->getMaxPriceGoods();
      
        $idList = [];
        $userList = [];
        foreach ($maxAuctionPriceList as $k=>$v){
            $idList[] = $k;
            $userList[]  = $v['auction_max']['user_id'];
        }
        
        
        
        $page = new AjaxPage(M("auction_competition")->where($condition)->whereIn("goods_id",$idList)->whereIn("user_id",$userList)->count(),10);
        
        $show = $page->show();
        $orderList = M("auction_competition")->where($condition)->whereIn("goods_id",$idList)->whereIn("user_id",$userList)->limit("{$page->firstRow},{$page->listRows}")->fetchSql(false)->select();

        $userId = get_arr_column($orderList,"user_id");
        $goodsid = get_arr_column($orderList, "goods_id");
        $addressid = get_arr_column($orderList, "address_id");
        
        $userinfo = M("users")->whereIn("user_id",$userId)->select();
        $goodsInfo = M("goods")->whereIn("goods_id",$goodsid)->select();
        $addressInfo = M("user_address")->whereIn("address_id",$addressid)->select();
        
        $goodsArr = [];
        $userArr = [];
        $addressArr = [];
        foreach ($goodsInfo as $k=>$v){
            $goodsArr[$v['goods_id']] = $v;
        }
        foreach ($userinfo as $k=>$v){
            $userArr[$v['user_id']] = $v;
        }
        foreach ($addressInfo as $k=>$v){
            $addressArr[$v['address_id']] = $v;
        }
      
        $this->assign('orderList', $orderList);
        $this->assign('goodsList', $goodsArr);
        $this->assign('userList', $userArr);
        $this->assign('addressList', $addressArr);
        $this->assign('page', $show);// 赋值分页输出
        $this->assign('pager', $page);
        return $this->fetch();
    }
    
    //获取拍卖现场中，拍卖时间已经结束且出价最高的人
    private function getMaxPriceGoods()
    {
        $ret = M("auction_room ar")
        ->field(["ar.*","g.auction_end"])
        ->where("g.auction_end","<",time())
        ->where("ar.type",1)
        ->join("goods g","ar.goods_id=g.goods_id")
        ->select();
    
        $auction = [];
        foreach ($ret as $k=>$v){
            $auction[$v['goods_id']][] = $v;//保存该拍卖品的出价数据
        }
        
        foreach ($auction as $k=>$v){
            $max = [];
            foreach ($v as $kk=>$vv){
                $max[$vv['id'].'-'.$vv['user_id']] = $vv['offer_price'];
            }
            asort($max);//按出价排序　　从小到大
            $temp = array_reverse($max);
            $auction[$k]['auction_max'] = ['max_price'=>current($temp),'user_id'=>explode("-", current(array_keys($temp)))[1]];//数组出栈
        }
        return $auction;
    }
    
    public function detail()
    {
        $orderid = input("orderid");
        $orderInfo = M("auction_competition")->where("id",$orderid)->find();
        empty($orderInfo['id'])&&$this->error("不存在此拍品信息");
        $orderInfo['userInfo'] = M("user_address")->where("address_id",$orderInfo['address_id'])->find();
        $orderInfo['goodsInfo'] = M("goods")->where("goods_id",$orderInfo['goods_id'])->find();
        
        $orderInfo['maxinfo']  = M("auction_room")->where([
            "goods_id"=>$orderInfo['goodsInfo']['goods_id'],
            "user_id"=>$orderInfo['user_id']]
            )->max("offer_price");
        
        //该拍卖品的出价参与人数
        $ret = M("auction_room")->whereIn("goods_id",$orderInfo['goodsInfo']['goods_id'])->select();
        $auctionJoinNum = [];
        foreach($ret as $k=>$v){
            $auctionJoinNum[$v['goods_id']][] = $v['user_id'];
        }
        foreach ($auctionJoinNum as $k=>$v){
            $auctionJoinNum[$k] = array_unique($v);
        }
        $orderInfo['joinNum'] = count($auctionJoinNum[$orderInfo['goodsInfo']['goods_id']]);
        
        if($orderInfo['goodsInfo']['auction_end']<time()){
            $orderInfo['goodsInfo']['auction_state'] = "已结束";
        }else{
            $orderInfo['goodsInfo']['auction_state'] = "拍卖中";
        }
        
        $p = M('region')->where(array('id'=>$orderInfo['userInfo']['province']))->field('name')->find();
        $c = M('region')->where(array('id'=>$orderInfo['userInfo']['city']))->field('name')->find();
        $d = M('region')->where(array('id'=>$orderInfo['userInfo']['district']))->field('name')->find();
        $address = $p['name'].','.$c['name'].','.$d['name'].',';
        $orderInfo['userInfo']['address'] = $address.$orderInfo['userInfo']['address'];
        
        
        //$this->getAuctionCompetition($orderInfo['goodsInfo']['goods_id']);
        //print_r($orderInfo);
        $this->assign("info",$orderInfo);
        return $this->fetch();
    }
    
    //竞价拍卖排名
    private function getAuctionCompetition($goodsid)
    {
        $ret = M("auction_room ar")
        ->field("ar.*,u.nickname,u.mobile")
        ->where("goods_id",$goodsid)
        ->join("users u","ar.user_id=u.user_id","LEFT")
        ->order("offer_price","desc")
        ->select();
        $list = [];
        $listUser = [];
        foreach ($ret as $k=>$v){
            $list[$v['user_id']][] = $v['offer_price'];
            $listUser[$v['user_id']] = $v['nickname']?:$v['mobile'];
        }
        foreach ($list as $k=>$v){
            asort($v);
            $temp = array_reverse($v);
            //$list[$k] = $temp[0];
            //$list[$k] = ["offer_price"=>$temp[0],"add_time"=>$listTime[$k],"user"=>$listUser[$k]];
        }
        print_r($list);

    }
}
?>