<?php
	namespace app\h5\controller;

  class Testn extends Base
 {
     public function index()
     {
         /*
    
          //商品分类接口
         $url = "www.liketea.com/index.php/api/Goods/goodsCategoryList";
         $data = [
             'parent_id'=>849,
         ];
         method:post
    
    
        //购物车添加　　
         $token = "a3bf131a68d727a8a8d638f32501efbf";
         $url = "www.liketea.com/index.php/api/Cart/addCart?token={$token}";
         $data = [
             'goods_id'=>167,
             'goods_num'=>2,
         ];
         
         
         //购物车列表  传递$cart_from_data 为json
         //selected 为１表示选中的商品
         //selected 为０表示未选中的商品
         //goodsNum 表示购买的商品数量
         //cartId 　购物车商品id
         //数据格式是json 传递后台表示选中的商品重新修改购买数量
         $token = "a3bf131a68d727a8a8d638f32501efbf";
         $cart_from_date = [
             
                         [
                             'cartID'=>'2',
                             'goodsNum'=>'1',
                             'selected'=>'1'
                         ],
                         [
                         'cartID'=>'3',
                         'goodsNum'=>'1',
                         'selected'=>'1'
                         ],
                         [
                         'cartID'=>'4',
                         'goodsNum'=>'1',
                         'selected'=>'0'
                             ],
             
         ];
         $url = "www.liketea.com/index.php/api/Cart/cartList?token={$token}";
         $data = [
             'cart_form_data'=>json_encode($cart_from_date)
         ];
         
         //购物车的商品删除
         $token = "a3bf131a68d727a8a8d638f32501efbf";
         
         $url = "www.liketea.com/index.php/api/Cart/delCart?token={$token}";
         $data = [
             'ids'=>'',//购物车的id
         ];
         
         //购物车的商品删除
         $token = "a3bf131a68d727a8a8d638f32501efbf";
         
         $url = "www.liketea.com/index.php/api/Cart/delCart?token={$token}";
         $data = [
             'ids'=>'',//购物车的id
         ];
         
         //购物车的订单列表确认页面　
         //存在以下参数表示立即购买
         //不存在以下参数表示是去购物车结算的订单
         //tpshop的购物车是保存当前登录者的订单数据存于数据库里
         $token = "9e2c529064ad48947dbda536e176a425";
         
         $url = "www.liketea.com/index.php/api/Cart/cart2?token={$token}";
         $data = [
             'goods_id'=>'167',
             'goods_num'=>2,
             'action'=>'buy_now'
         ];
         
         <input type="hidden" name="address_id" value="35">
        <input type="hidden" name="pay_points" value="">
        <input type="hidden" name="user_money" value="">
        <input type="hidden" name="invoice_title" value="个人">
        <input type="hidden" name="paypwd" value="" hidden="">
        <!--立即购买才会用到-s-->
        <input type="hidden" name="action" value="buy_now">
        <input type="hidden" name="goods_id" value="166">
        <input type="hidden" name="item_id" value="">
        <input type="hidden" name="goods_num" value="1">
        <!--立即购买才会用到-e-->
                <input type="hidden" name="shipping_code[1]" value="shentong">
            <input type="hidden" name="user_note[1]" value="">
            
            
         //提交订单  传递以下参数是针对购物车的订单提交
         $token = "6c047136726e8c422ecd85e7ac3387c5";
         //此参数的key值是店铺的store_id值　　表示哪个店铺的留言和哪个店铺的优惠卷id
         $cart_from_data = [
             'user_note'=>['1'=>'茶叶给我包好点不然不要2','2'=>'包好2点'],//留言内容
             'coupon_id'=>['1'=>'65','2'=>'32'],//优惠卷id  
             //要获取此参数的流程是：１先调用优惠卷列表接口　２领取优惠卷接口　３我的优惠卷接口组装成此参数完成优惠卷传递
             //key=>store_id value=为优惠卷领取列表的id 以便下单时完成优惠卷使用时间，数量修改
         ];
         $url = "www.liketea.com/index.php/api/Cart/cart3?token={$token}";
         $data = [
             'address_id'=>'39',//收货地址
             'act'=>'submit_order',//此参数表示添加订单
             'cart_form_data'=>json_encode($cart_from_data)
         ];
         
         //提交订单  针对单件商品的订单提交
         $token = "6c047136726e8c422ecd85e7ac3387c5";
         //此参数的key值是店铺的store_id值　　表示哪个店铺的留言和哪个店铺的优惠卷id
         $cart_from_data = [
             'user_note'=>['1'=>'茶叶给我包好点不然不要2'],//留言内容
             'coupon_id'=>['1'=>'65'],//优惠卷id  
             //要获取此参数的流程是：１先调用优惠卷列表接口　２领取优惠卷接口　３我的优惠卷接口组装成此参数完成优惠卷传递
             //key=>store_id value=为优惠卷领取列表的id 以便下单时完成优惠卷使用时间，数量修改
         ];
         $url = "www.liketea.com/index.php/api/Cart/cart3?token={$token}";
         $data = [
             'address_id'=>'39',//收货地址
             'act'=>'submit_order',//此参数表示添加订单
             'goods_id'=>'167',//商品id
             'goods_num'=>'1', //商品购买数量
             'action'=>'buy_now',
             'cart_form_data'=>json_encode($cart_from_data)
             
         ];
         
          //订单支付页面
         $token = "6c047136726e8c422ecd85e7ac3387c5";
         //以下这３个参数随便传递一个
         $url = "www.liketea.com/index.php/api/Cart/cart4?token={$token}";
         $data = [

             'master_order_sn'=>'201804131717126306',//合并付款的订单号 针对多个订单
             'order_sn'=>'',//单一的订单号
             'order_id'=>''//订单的id
         ];
         
         //支付宝支付预支付订单请求签名 由app 端集成sdk完成支付
         $token = "6c047136726e8c422ecd85e7ac3387c5";
         $url = "www.liketea.com/index.php/api/Payment/alipay_sign?token={$token}";
         $data = [
             'order_sn'=>'201804131740131459',//合并付款的订单号 针对多个订单
         ];
         
          //我的订单列表
         $token = "0fa7a4ec1be54ab33cf3e904079eacc1";
         $url = "www.liketea.com/index.php/api/User/getOrderList?token={$token}";
         $data = [
             'p'=>1
         ];
         
         
          //订单详情
         $token = "0fa7a4ec1be54ab33cf3e904079eacc1";
         $url = "www.liketea.com/index.php/api/Order/order_detail?token={$token}";
         $data = [
             'id'=>'383',// 查看订单只有一件商品时
             //'master_order_sn'=>'201804131407341616',//订单有多件商品形成的子订单
         ];
         
          
         //取消订单
         $token = "0fa7a4ec1be54ab33cf3e904079eacc1";
         $url = "www.liketea.com/index.php/api/User/cancelOrder?token={$token}";
         $data = [
             'id'=>'399',// 订单id
         ];
         
          //申请售后　退货　　退款　操作
         //get　请求获取要退款退货的数据
         $token = "0fa7a4ec1be54ab33cf3e904079eacc1";
         $url = "www.liketea.com/index.php/api/Order/return_goods?token={$token}&order_id=398&rec_id=496&goods_id=167";
         $data = [
                'rec_id'=>497,//要退款退货的订单商品id
    	        'order_id'=>399,//要退款退货的订单id
    	        'goods_id'=>167,//要退款退化的商品id
         ];
         
         //申请售后　退货　　退款　操作
         //post 请求是申请退货提交
         //get　请求获取要退款退货的数据
         $token = "0fa7a4ec1be54ab33cf3e904079eacc1";
         $url = "www.liketea.com/index.php/api/Order/return_goods?token={$token}";
         $data = [
                'rec_id'=>496,//要退款退货的订单商品id
    	        'order_id'=>398,//要退款退货的订单id
    	        'goods_id'=>167,//要退款退化的商品id
    	        'type'=>0,//0退款 1退货退款 2换货 3维修
    	        'reason'=>'不想要了',//退款原因
    	        'describe'=>'商品质量不好不要了',//退款说明
    	        'imgs'=>'',//退款图片凭证　
    	        'order_sn'=>'201804131740132277',//退款订单号
    	        'goods_num'=>'1'
         ];
         
           //确认收货
         $token = "0fa7a4ec1be54ab33cf3e904079eacc1";
         $url = "www.liketea.com/index.php/api/User/orderConfirm?token={$token}";
         $data = [
                'id'=>'399',//要收货的订单id
                'isajax'=>1
         ];
         
          $data['order_id']         = input('post.order_id/d', 0);
        $data['rec_id']           = input('post.rec_id/d', 0);
        $data['goods_id']         = input('post.goods_id/d', 0);
        $data['seller_score']     = input('post.service_rank', 0);   //卖家服务分数（0~5）(order_comment表)
        $data['logistics_score']  = input('post.deliver_rank', 0); //物流服务分数（0~5）(order_comment表)
        $data['describe_score']   = input('post.goods_rank', 0);  //描述服务分数（0~5）(order_comment表)
        $data['goods_rank']       = input('post.goods_score/d', 0);   //商品评价等级
        $data['is_anonymous']     = input('post.is_anonymous/d', 0);
        $data['content']          = input('post.content', '');
        $data['img']              = input('post.img/a', ''); //小程序需要
        $data['user_id']          = $this->user_id;
         //订单评价
         $token = "0fa7a4ec1be54ab33cf3e904079eacc1";
         $url = "www.liketea.com/index.php/api/User/add_comment?token={$token}";
         $data = [
                 'order_id'=>'399',//评价哪个订单
                 'rec_id'=>'497',//评价哪个订单商品
                 'goods_id'=>'167',//评价哪个商品
                 'service_rank'=>5,//卖家服务分数（0~5）(order_comment表)
                 'deliver_rank'=>5,//物流服务分数（0~5）(order_comment表)
                 'goods_rank'=>5,//描述服务分数（0~5）(order_comment表)
                 'goods_score'=>5, //商品评价等级
                 'content'=>'这茶叶还是好喝的哦',
                 'img'=>'',
         ];
         
          //退款详情
         $token = "0fa7a4ec1be54ab33cf3e904079eacc1";
         $url = "www.liketea.com/index.php/api/Order/return_goods_info?token={$token}";
         $data = [
                'id'=>'29',
                'is_json'=>1
         ];
         
          //活动发布
         $token = "0fa7a4ec1be54ab33cf3e904079eacc1";
         $url = "www.liketea.com/index.php/api/Active/addactive?token={$token}";
         $data = [
                'title'=>'本周到梁山入伙活动开始啦',
                'desc'=>'活动由九纹龙史进主持',
                'active_time'=>'2018-04-17 17:00:00',
                'active_location'=>'梁山水泊',
                'location_x'=>'113.3456',
                'location_y'=>'30.123',
                'address'=>'山东梁山水泊',
                'num'=>'108',
                'sex'=>'3',//１男　２女　３不限
                'consume'=>'AA制自备伙食'
         ];
         
         //获取所有发布
         $token = "0fa7a4ec1be54ab33cf3e904079eacc1";
         $url = "www.liketea.com/index.php/api/Active/activelist?token={$token}";
         $data = [
             'p'=>1
         ];
         
         //我发布的活动列表
         $token = "e9007232e6dbd9e877e69bfa83e7139b";
         $url = "www.liketea.com/index.php/api/User/myactivity?token={$token}";
         $data = [
             'p'=>1
         ];
         
         
         //评论活动
         $token = "e9007232e6dbd9e877e69bfa83e7139b";
         $url = "www.liketea.com/index.php/api/Active/comment?token={$token}";
         $data = [
             'active_id'=>'3',//评论的活动id
             'content'=>'我们同意入伙',//评论的内容　
         ];
         
          //活动详情
         $token = "e9007232e6dbd9e877e69bfa83e7139b";
         $url = "www.liketea.com/index.php/api/Active/details?token={$token}";
         $data = [
             'active_id'=>'3',//评论的活动id
         ];
         
         //活动删除
         $token = "e9007232e6dbd9e877e69bfa83e7139b";
         $url = "www.liketea.com/index.php/api/Active/remove_activity?token={$token}";
         $data = [
             'active_id'=>'88',//评论的活动id
         ];
         
         
          //活动报名
         $token = "e9007232e6dbd9e877e69bfa83e7139b";
         $url = "www.liketea.com/index.php/api/Active/join_activity?token={$token}";
         $data = [
             'activity_id'=>'4',//评论的活动id
         ];
         
          //我报名的活动列表
         $token = "e9007232e6dbd9e877e69bfa83e7139b";
         $url = "www.liketea.com/index.php/api/User/myjoin_activity?token={$token}";
         $data = [
         ];
         */
         
       
         /**
          * I('post.nickname') ? $post['nickname'] = I('post.nickname') : false; //昵称
        //I('post.qq') ? $post['qq'] = I('post.qq') : false;  //QQ号码
        I('post.head_pic') ? $post['head_pic'] = I('post.head_pic') : false; //头像地址
        I('post.sex') ? $post['sex'] = I('post.sex') : false;  // 性别
        //I('post.birthday') ? $post['birthday'] = strtotime(I('post.birthday')) : false;  // 生日
        //I('post.province') ? $post['province'] = I('post.province') : false;  //省份
        //I('post.city') ? $post['city'] = I('post.city') : false;  // 城市
        //I('post.district') ? $post['district'] = I('post.district') : false;  //地区
        //I('post.email') ? $post['email'] = I('post.email') : false;  
        I('post.mobile') ? $post['mobile'] = I('post.mobile') : false;  
        I('post.info') ? $post['info'] = I('post.info') : false;
        I('post.longitude') ? $post['longitude'] = I('post.longitude') : false;
        I('post.latitude') ? $post['latitude'] = I('post.latitude') : false;
        $token = "f5604f8b2102befa1d026b52d2139880";
         $url = "www.liketea.com/index.php/api/User/updateUserInfo?token={$token}";
         $data = [
             'nickname'=>'laotouzi',
             'head_pic'=>'laoyoutiao',
             'sex'=>'1',
             //'mobile'=>'18896871476',
             'info'=>'我是一个老老油条abc',
             'longitude'=>'120.234561',
             'latitude'=>'31.2345'
         ];
         
         $token = "6c047136726e8c422ecd85e7ac3387c5";
         $url = "www.liketea.com/index.php/api/Payment/alipay_sign?token={$token}";
         $data = [
             'order_sn'=>'201804131740131459',//合并付款的订单号 针对多个订单
         ];
          * ***/
         
         /*
         $token = "7761a58c4a7471d00797f1661ab8aca0";
         $cart_from_date = [
            
             [
                'cartID'=>'4',
                'goodsNum'=>'5',
                'selected'=>'0'
             ],
             [
             'cartID'=>'12',
             'goodsNum'=>'1',
             'selected'=>'1'
             ],
             [
             'cartID'=>'15',
             'goodsNum'=>'1',
             'selected'=>'1'
             ],
              
         ];
         
         $a = '[{
  "cartId" : "18",
  "goodsNum" : "1",
  "selected" : "0"
}]';
         $url = "www.liketea.com/index.php/api/Cart/cart2?token={$token}";
         $data = [
             'cart_form_data'=>json_encode($cart_from_date)
         ];
         */
         
         
         $token = "59b28c3e9c8045d48e07fcbbf9b009a3";
         $url = "www.liketea.com/index.php/api/Cart/addCart?token={$token}";
         $data = [
             'goods_id'=>167,
             'goods_num'=>2,
         ];
         
         
         $result = $this->get_api_data($url,'post',$data);
         //print_r(json_encode($cart_from_date));
         print_r($result);
     }
     
    
      
 }
?>