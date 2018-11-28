<?php
	namespace app\api\controller;

 use Think\Page;
 class AuctionGoods extends Base
 {
     protected $beforeActionList = [
         //'createOrGetAuctionChatRoom' =>  ['only'=>'details'],
     ];
     
     
     public function auctionList()
     {
         
         $goods_list = $this->getAuctionGoods();
         $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $goods_list]);
     }
     
     private function getAuctionGoods($goodsId=[])
     {
         
         $field = [
             'store_id',
             'goods_id',
             'goods_name',
             'shop_price'=>'auction_price',
             'original_img',
             'auction_end'
         ];
         $count = count(M('goods')->field($field)
                                 ->where(["is_auction_goods"=>1])
                                 ->where(function($query)use($goodsId){
                                     if($goodsId){
                                         $query->whereIn("goods_id",$goodsId);
                                     }
                                 })
                                 ->whereTime("auction_end",">",time())->count());
         $page = new \think\Page($count, 15);
         $goods_list = M('goods')->field($field)
                                 ->where(["is_auction_goods"=>1])
                                 ->where(function($query)use($goodsId){
                                     if($goodsId){
                                         $query->whereIn("goods_id",$goodsId);
                                     }
                                 })
                                 ->whereTime("auction_end",">",time())
                                 ->order("shop_price desc")
                                 ->limit($page->firstRow.','.$page->listRows)
                                 ->select();
         $storeId = [];
         $goodsId = [];
         foreach ($goods_list as $k=>$v){
             $storeId[] = $v['store_id'];
             $goodsId[] = $v['goods_id'];
         }
         $store = \think\Db::name("store")->field("store_name,store_id")->whereIn("store_id",$storeId)->select();
         $goodsStore = [];
         foreach ($store as $k=>$v){
             $goodsStore[$v['store_id']] = $v['store_name'];
         }
         $auctionNumList = $this->getAuctionNum($goodsId);
         
         foreach ($goods_list as $k=>$v){
             $goods_list[$k]['store_name'] = $goodsStore[$v['store_id']];
             $goods_list[$k]['auction_end']= date("m-d H:i",$v['auction_end']);
             $goods_list[$k]['auction_join_num'] = count($auctionNumList[$v['goods_id']]);//出价人数
             //$goods_list[$k]['auction_price'] = round($v['auction_price']);
             //拍卖品的最高价格
             $temp = $this->maxAuctionPrice($v);
             $goods_list[$k]['auction_price'] = round($temp['offer_price'])?:round($v['auction_price']);
         }
         return $goods_list;
     }
    private function getAuctionNum($goodsidList)
    {
        /*
        $ret = M("auction_competition")->whereIn("goods_id",$goodsidList)->select();
        */
        $ret = M("auction_room")->whereIn("goods_id",$goodsidList)->where("type",1)->select();
        $auctionJoinNum = [];
        foreach($ret as $k=>$v){
            $auctionJoinNum[$v['goods_id']][] = $v['user_id'];
        }
        foreach ($auctionJoinNum as $k=>$v){
            $auctionJoinNum[$k] = array_unique($v);
        }
        return $auctionJoinNum;
     }
     //专场
     public function auctionSquareList()
     {
        
         $count = count(M('auction_square')
                                ->whereTime("auction_end",">",time())->count());
         $page = new \think\Page($count, 15);
         $auction_list = M('auction_square')
                                 ->whereTime("auction_end",">",time())
                                 ->order("auction_end desc")
                                 ->limit($page->firstRow.','.$page->listRows)
                                 ->select();
         //保存每个专场的拍卖品id
         $squareId = '';
         foreach ($auction_list as $k=>$v){
             $auction_list[$k]['auction_end']= date("m-d H:i",$v['auction_end']);
             $squareId = explode(",", $v['auction_idlist']);
             
             $auction_list[$k]['auction_join_num'] = $this->getAuctionUserNum($squareId);
             //$auction_list[$k]['auction_join_num'] = 0;//出价人数
         }
         
         $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $auction_list]);
     }
     private function getAuctionUserNum($id)
     {
         $ret = M("auction_room")->whereIn("goods_id",$id)->where("type",1)->select();
         $user = [];
         foreach($ret as $k=>$v){
             $user[$v['goods_id']][] = $v['user_id'];
         }
         $num = 0;
         foreach ($user as $k=>$v){
             $temp = array_unique($v);
             $num+=count($temp);
         }
         return $num;
     }
     
     //某一专场拍卖品
     public function auctionGoodsList()
     {
         $auction_id = input("auction_id");
         empty($auction_id)&&$this->ajaxReturn(['status' => -1, 'msg' => '参数错误']);
         //专场
         $auction = M("auction_square")->where("id",$auction_id)->find();
         $auction['auction_end']= date("m-d H:i",$auction['auction_end']);
         $auction['auction_join_num'] = 0;//出价人数
         
         //专场下对应的拍卖品
         empty($auction['id'])&&$this->ajaxReturn(['status' => -1, 'msg' => '不存在此专场']);
         $goodsId = explode(",", $auction['auction_idlist']);
         $goods_list = $this->getAuctionGoods($goodsId);
         $auction['auctionGoodsList'] = $goods_list;
         $auction['auction_goods_num'] = count($auction['auctionGoodsList']);//出价人数
         $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $auction]);
     }
     
     //拍品详情
     public function details()
     {
         $auction_id = input("goods_id");
         empty($auction_id)&&$this->ajaxReturn(['status' => -1, 'msg' => '参数错误']);
         $cr = M("goods")->where("goods_id",$auction_id)->value("chatroomid");
         if(!$cr){
             ob_start();
             $this->createOrGetAuctionChatRoom();
             $r = ob_get_contents();
             ob_end_clean();
         }
         
         //$id = call_user_func([$this,'createOrGetAuctionChatRoom'],$auction_id);
         $goods = M("goods")
         ->field([
             "goods_content",
             "store_id",
             "goods_id",
             "original_img",
             "shop_price"=>"auction_price",
             "deposit_price"
         ])
         ->where("goods_id",$auction_id)
         ->find();
         empty($goods['goods_id'])&&$this->ajaxReturn(['status' => -1, 'msg' => '不存在此拍卖品']);
         $goods['store'] = M("store")->field("store_name,store_id,store_logo")->where("store_id",$goods['store_id'])->find();
         $goods['chatroomid'] = M("goods")->where("goods_id",$auction_id)->value("chatroomid");
         $goods['lowincr_price'] = round(M("goods")->where("goods_id",$auction_id)->value("lowincr_price"));
         $goods['auction_price'] = round($goods['auction_price']);
         //当前登录的人是否关注了该店铺
         $substore = M("store_collect")->where("user_id",$this->user_id)->where("store_id",$goods['store_id'])->find();
         $goods['is_subscribe'] = $substore['store_id']?1:0;
         $goods['is_pay_promise'] = M("auction_competition")->where("goods_id",$auction_id)->where("user_id",$this->user_id)->value("pay_status");
       
         $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' =>$goods]);
         
     }
     
     //参与拍卖
     public function joinAuctionCompetition(\app\api\controller\Wxpay $wxpay)
     {
         $data['goods_id']      = input("goods_id");
         empty($data['goods_id'])&&$this->ajaxReturn(['status' => -1, 'msg' => '商品id参数错误']);
         $data['user_id']       = $this->user_id;
         empty($data['user_id'])&&$this->ajaxReturn(['status' => -1, 'msg' => '用户id参数错误']);
         $data['promise_price'] = input("promise_price",0,"float");
         empty($data['promise_price'])&&$this->ajaxReturn(['status' => -1, 'msg' => '保证金参数错误']);
         $data['pay_way']       = input("pay_way");
         empty($data['pay_way'])&&$this->ajaxReturn(['status' => -1, 'msg' => '支付方式参数错误']);
         //$data['address_id']    = input("address_id");
         //empty($data['address_id'])&&$this->ajaxReturn(['status' => -1, 'msg' => '收货地址参数错误']);
         
         $data['ordersn']       = $this->getAuctionOrdersn();
         
         $goodsInfo = M("goods")->where("goods_id",input("goods_id"))->find();
         $data['goods_name']    = $goodsInfo['goods_name'];
         $data['goods_origin']  = $goodsInfo['original_img'];
         $data['goods_auction'] = $goodsInfo['shop_price'];
         $data['store_id']      = $goodsInfo['store_id'];
         $order = M("auction_competition")->where("goods_id",$data['goods_id'])->where("user_id",$data['user_id'])->find();
         if($order['ordersn']){
             //未支付保证金
             if($order['pay_status']!=1){
                 if($data['pay_way']==1){
                     //支付宝
                     $data['ordersn'] = $order['ordersn'];
                     
                     $signStr = $this->getpaySign($data);
                 }elseif($data['pay_way']==2){
                     //wechat
                     $signStr = $wxpay->auctiondopay([
                         "total"=>$data['promise_price'],
                         "shop_info"=>"趣喝茶商城订单",
                         "goodsname"=>"趣喝茶商品paimai",
                         "ordersn"=>$data['ordersn']
                     ]);
                 }
                 
                 $result = ["status" =>1,"msg"=>"支付参数签名成功1","result"=>$signStr];
             }else{
                 $result = ["status" =>-1,"msg"=>"此拍品不可再操作","result"=>''];
             }
         }else{
             $data['add_time'] = time();
             if(M("auction_competition")->save($data)){
                 
                $order = M("auction_competition")->where("ordersn",$data['ordersn'])->where("user_id",$data['user_id'])->find();
                if($order['ordersn']){
                    if($data['pay_way']==1){
                        //支付宝
                        $signStr = $this->getpaySign($data);
                    }elseif($data['pay_way']==2){
                        //wechat
                        $signStr = $wxpay->auctiondopay([
                            "total"=>$data['promise_price'],
                            "shop_info"=>"趣喝茶商城订单",
                            "goodsname"=>"趣喝茶商品paimai",
                            "ordersn"=>$data['ordersn']
                        ]);
                    }
                    $result = ["status" =>1,"msg"=>"支付参数签名成功2","result"=>$signStr];
                }else{
                    $result = ["status" =>1,"msg"=>"不存在订单无法操作","result"=>$signStr];
                }
                
             }
             
         }
         $this->ajaxReturn($result);
         
     }
     private function getpaySign($data)
     {
         //file_put_contents("app_auction.log", json_encode($data,JSON_UNESCAPED_UNICODE));
         
         require_once 'vendor/Alipay/aop/AopClient.php';
         $private_path =  "./vendor/Alipay/key/rsa_private_key.pem";//私钥路径
         //构造业务请求参数的集合(订单信息)
         $content = array();
         $content['subject'] = I("subject","趣喝茶商城订单");
         $content['out_trade_no'] = $data['ordersn'];
         $content['timeout_express'] = "600";
         $content['total_amount'] = $data['promise_price'];
         $content['product_code'] = "QUICK_MSECURITY_PAY";
         $con = json_encode($content);//$content是biz_content的值,将之转化成json字符串
          
         //公共参数
         $Client = new \AopClient();//实例化支付宝sdk里面的AopClient类,下单时需要的操作,都在这个类里面
         $param['app_id'] = '2018032702455466';
         $param['method'] = 'alipay.trade.app.pay';//接口名称，固定值
         $param['charset'] = 'utf-8';//请求使用的编码格式
         $param['sign_type'] = 'RSA2';//商户生成签名字符串所使用的签名算法类型
         $param['timestamp'] = date("Y-m-d H:i:s");//发送请求的时间
         $param['version'] = '1.0';//调用的接口版本，固定为：1.0
         $param['notify_url'] = 'http://118.190.204.122/index.php/api/AuctionGoods/alipayNotify';
         $param['biz_content'] = $con;//业务请求参数的集合,长度不限,json格式，即前面一步得到的
          
         $paramStr = $Client->getSignContent($param);//组装请求签名参数
         $sign = $Client->alonersaSign($paramStr, $private_path, 'RSA2', true);//生成签名
         $param['sign'] = $sign;
         $str = $Client->getSignContentUrlencode($param);//最终请求参数
         //file_put_contents("auctionpay.log", json_encode($_POST,JSON_UNESCAPED_UNICODE));
         return $str;
     }
     //拍卖品保证金支付回调
     public function alipayNotify()
     {
       
         require_once('vendor/Alipay/aop/AopClient.php');
         $aop = new \AopClient;
         $public_path = "./vendor/Alipay/key/alipay_public_key_sha.pem";//公钥路径
         $aop->alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAsymouNF99FfWOHTv+STYvTX/gKaWvUCk+fi5UWXnm1R9USsZDlJ2ei7ZOo4wjTTZDsziDhyAMsQCAzALbTEMq4gTqil0qp05AdUeJ/MtgSE5pmekf0u3VkIZp9zRzLJoJWIXXwtfuPvGgORTyuIiJ1+nF36SdLPcYweLsz+sMSKs8D7SUQdnk1UaHEec1KqHCCdidFw2RoyB1GihVWpbDL411b2CYS7iwbqKRvY7YVHlfPMMfSZXhxLSXulaQ5mgAiQ9JTa0Czub2tBtkLns5rCI+wDJkSNTtAkTpGW8oepGvqDblVHQeCWa/RoyKCoIbpbgOxfiaAuyN3uUQPxfYQIDAQAB';
         $flag = $aop->rsaCheckV1($_POST, $public_path, "RSA2");
         
         //验证成功
         if ($flag) {
            
             $order_sn = $out_trade_no = trim($_POST['out_trade_no']); //商户订单号
             $trade_no = $_POST['trade_no'];//支付宝交易号
             $trade_status = $_POST['trade_status'];//交易状态
             $order_amount = M('auction_competition')->where(['ordersn'=>$order_sn])->sum('promise_price');
             if($order_amount!=$_POST['total_amount'])
                 exit("fail"); //验证失败
         
             if ($_POST['trade_status'] == 'TRADE_FINISHED') {
                 
                 M('auction_competition')->where('ordersn', $order_sn)
                                            ->save(['pay_status'=>1,'pay_time'=>time()]);
             } elseif ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                
                 M('auction_competition')->where('ordersn', $order_sn)
                 ->save(['pay_status'=>1,'pay_time'=>time()]);
             }
             
             echo "success"; //  告诉支付宝支付成功 请不要修改或删除
              
         } else {
             echo "fail"; //验证失败
             
         }
         
     }
     
     private function getAuctionOrdersn()
     {

         $order_sn = null;
         // 保证不会有重复订单号存在
         while(true){
             $order_sn = date('YmdHis').rand(1000,9999); // 订单编号
             $order_sn_count = M('auction_competition')->where("ordersn = '$order_sn'")->count();
             if($order_sn_count == 0)
                 break;
         }
         return $order_sn;

     }
     
     //im api sing
     private function makeImSign()
     {
         // 设置 REST API 调用基本参数
         $sdkappid = \think\Config::get("IM_SDKAPPID");
         $identifier = \think\Config::get("imadmin");
         $private_key_path = "/home/www/b2c/vendor/vendor/tengxun_im/private_key";
         $signature = "/home/www/b2c/vendor/PhpServerSdk/signature/linux-signature64";
         $private_pem_path = "/home/www/b2c/vendor/tengxun_im/private_key";
         require_once './vendor/PhpServerSdk/TimRestApi.php';
         // 初始化API
         $api = \createRestAPI();
         $api->init($sdkappid, $identifier);
          
         // 生成签名，有效期一天
         // 对于FastCGI，可以一直复用同一个签名，但是必须在签名过期之前重新生成签名
         ob_start();
         $ret = $api->generate_user_sig($identifier, '86400', $private_pem_path, $signature);
         ob_end_clean();
         if ($ret == null)
         {
             // 签名生成失败
             return -10;
         }
         return $api;
         
     }
     //im接口 获取指定拍卖品的聊天室id
     public function createOrGetAuctionChatRoom()
     {
         $goodname = M("goods")->where("goods_id",input("goods_id"))->find();
         empty($goodname['goods_name'])&& $this->ajaxReturn(['status'=>-1,'msg'=>'不存在此拍品无法创建']);
         if($goodname['chatroomid'])$this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result'=>$goodname['chatroomid']]);
         $data['goodsname'] = $goodname;
         $data['goods_id'] = input("goods_id");
         $api = $this->makeImSign();
        //function group_create_group2($group_type, $group_name, $owner_id, $info_set, $mem_list)
        //'Introduction' => $info_set['introduction'],
		//		'Notification' => $info_set['notification'],
		//		'FaceUrl' => $info_set['face_url'],
		//		'MaxMemberCount' => $info_set['max_member_num'],
		
         $group_type = "ChatRoom";
         $group_name = $data['goodsname']."-".$data['goods_id'];
         $owner_id   = "CR".$data['goodsname'];
         $info_set['Notification'] = $data['goodsname'];
         $mem_list[]['Member_Account'] = "ChatRoom"."-".$this->user_id;
         ob_start();
         $result = $api->group_create_group2($group_type,$group_name,$owner_id,$info_set,$mem_list);
         
         $ret = ob_get_contents();
         ob_end_clean();
         if($result['ActionStatus']=='OK'){
             $groupId = M("goods")->where("goods_id",$data['goods_id'])->find();
             if($groupId['chatroomid']){
                 return $result['GroupId'];
             }else{
                 if(M("goods")->where("goods_id",$data['goods_id'])->save(["chatroomid"=>$result['GroupId']])){
                     //$this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result'=>$result['GroupId']]);
                     return $result['GroupId'];
                 } 
             }
             
         }
         
         
     }
     
     //拍卖现场
     public function auctionProcess()
     {

         $data['user_id']     = $this->user_id;
         $data['type']        = input("type");
         $data['content']     = input("content");
         $data['offer_price'] = input("offer_price/d",0);
         $data['goods_id']    = input("goods_id");
         $data['store_id']    = input("store_id");
         $data['roomid']      = input("roomid");
         
         //$data['incr_price']  = input("incr_price/d",0);//最低出价

         if(input("auction")=='get'){
             $list = $this->getAuctionprocess($data);
             $ret = $list[0]['id']?$list:[];
             if(empty($ret)){
                 $this->ajaxReturn(['status'=>-1,'msg'=>'拍卖现场没有任何数据','result'=>$ret]);
             }else{
                 $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result'=>$ret]);
             }
             
         }

         if(!$this->user_id){
             $this->ajaxReturn(['status'=>-101, 'msg'=>'登录超时[token错误]']);
         }
         //入库
         if($data['type']==1){
             //先验证用户是否缴纳了保证金
             $ret = M("auction_competition")->where(["user_id"=>$this->user_id,"goods_id"=>input("goods_id")])->find();
             empty($ret['id'])&&$this->ajaxReturn(['status'=>-1,'msg'=>'您未缴纳保证金无法操作']);
             if($ret['pay_status']!=1)$this->ajaxReturn(['status'=>-1,'msg'=>'您未缴纳保证金无法操作']);
              
             //当前用户的出价：出价结果＝当前最高价+最低出价
             //当前商品的起拍价
             /*
             $auction_goods_price = M("goods")->where(['goods_id'=>input("goods_id")])->value("shop_price");
             $max = $this->maxAuctionPrice(['goods_id'=>input("goods_id"),'store_id'=>$data['store_id']])['offer_price'];
             if($max==0){
                 //计算用户的出价结果
                 $data['offer_price'] = $data['offer_price']+$auction_goods_price;
             }else{
                 $data['offer_price'] = $data['offer_price']+$max;
             }
             */
             
             //验证当前拍卖品是否存在相同的出价
             $auction_num = M("auction_room")->where(['offer_price'=>$data['offer_price'],'goods_id'=>$data['goods_id'],'store_id'=>$data['store_id']])->count();
              
             if ($auction_num>0)$this->ajaxReturn(['status'=>-1,'msg'=>'当前出价已经是'.$data['offer_price'].'请加价']);
             empty($data['offer_price'])&&$this->ajaxReturn(['status'=>-1,'msg'=>'出价金额参数错误']);
             
             
             
         }
         
         $data['add_time'] = time();
         if(M("auction_room")->add($data)){
             
             $list = $this->getAuctionprocess($data);
             
             $this->ajaxReturn(['status'=>1,'msg'=>($data['type']==1?'出价成功':'评论成功'),'result'=>$list]);
         }else{
             $this->ajaxReturn(['status'=>-1,'msg'=>'出价或评论失败']);
         }
     }
     
     private function getAuctionprocess($data)
     {
         $page = new \think\Page(M("auction_room")
         ->where(["goods_id"=>$data['goods_id'],"store_id"=>$data['store_id']])
         ->order("offer_price","desc")->count(),15);
         
         $list = M("auction_room")
         ->where(["goods_id"=>$data['goods_id'],"store_id"=>$data['store_id']])
         ->order("add_time","desc")
         //->limit($page->firstRow,$page->listRows)
         ->select();
          
         $userid = get_arr_column($list, "user_id");
         $userInfo = M("users")->field("head_pic,nickname,mobile,user_id")->whereIn("user_id",$userid)->select();
         $userArr = [];
         foreach ($userInfo as $k=>$v){
             $userArr[$v['user_id']] = $v;
         }
         foreach ($list as $k=>$v){
             $list[$k]['userinfo'] = $userArr[$v['user_id']];
             if(time()-$v['add_time']>60){
                 $list[$k]['add_time'] = date("m-d H:i",$v['add_time']);
             }else{
                 $list[$k]['add_time'] = "刚刚";
             }
             $list[$k]['offer_price'] = round($v['offer_price']);
             
         }
         
         $list[] = $this->maxAuctionPrice($data);
         return $list;
     }
     
     private function maxAuctionPrice($data)
     {
        
         $list = M("auction_room")
         ->where(["goods_id"=>$data['goods_id'],"store_id"=>$data['store_id'],'type'=>1])
         ->order("offer_price","desc")
         ->find();
         if(time()-$$list['add_time']>60){
             $list['add_time'] = date("m-d H:i",$list['add_time']);
         }else{
             $list['add_time'] = "刚刚";
         }
         $list['userinfo'] = M("users")
         ->field("head_pic,nickname,mobile,user_id")
         ->where("user_id",$list['user_id'])
         ->find();
         
         $list['offer_price'] = round($list['offer_price']);
  
         return $list;
     }
     
     //线下打款提交凭证
     public function dopayEvidence()
     {
         $orderid = input("orderid");
         
         $evidence_pay_src = input("pay_evidence");
         $addressid  = input("addressid");
         empty($orderid)&&$this->ajaxReturn(['status' => -1, 'msg' => '拍卖单id参数错误']);
         empty($addressid)&&$this->ajaxReturn(['status' => -1, 'msg' => '收货地址参数错误']);
         if(M("auction_competition")->where("id",$orderid)->where("user_id",$this->user_id)->save([
             'order_status'=>1,
             'pay_evidence'=>$evidence_pay_src,
             'pay_evidence_time'=>time(),
             'address_id'=>$addressid
         ])){
             $this->ajaxReturn(['status'=>1,'msg'=>'提交成功']);
         }else{
             $this->ajaxReturn(['status'=>-1,'msg'=>'提交失败请重试']);
         }
     }
     public function goodsContent()
     {
         $goodsid = input("goods_id");
         $ret = M("goods")->where("goods_id",$goodsid)->find();
         $this->ajaxReturn(['status'=>1,'msg'=>'success','ret'=>$ret]);
     }
     
     //保证金定时退款
     public function refundMoney()
     {
         //拍卖时间已经到，并且已经付款　退回到用户余额里
         $goods = M("goods")->whereTime("auction_end","<",time())->where("is_auction_goods",1)->select();
         $goodsId = [];
         foreach ($goods as $k=>$v){
             $goodsId[] = $v['goods_id'];
         }
         $returnId = [];
         if(count($goodsId)){
             $order = M("auction_competition")->whereIn("goods_id",$goodsId)->select();
             foreach ($order as $k=>$v){
                 //已经付款且未退款
                 if($v['pay_status']==1&&$v['is_return']!=1){
                     $returnId[$v['user_id'].'-'.$v['id']] = $v['promise_price'];
                 }
             }
         }
         if(count($returnId)!=0){
             //用户余额更新
             foreach ($returnId as $k=>$v){
                 $temp = explode("-", $k);
                 M("users")->where("user_id",$temp[0])->setInc("user_money",$v);
                 M("auction_competition")->where("id",$temp[1])->save(['is_return'=>1]);
             }
         }
         
         
     }
 }
?>