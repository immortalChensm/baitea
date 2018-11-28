<?php
	namespace app\h5\controller;

  class Login extends Base
 {
     public function index()
     {
         /*
         $url = "http://www.liketea.com/index.php/api/Goods/collectGoodsOrNo?token=klsjfklsjfklsjfkl";
         $data = [
             'goods_id'=>100
         ];
         
         
         
          //商品分类接口
         $url = "www.liketea.com/index.php/api/Goods/goodsCategoryList";
         $data = [
             'parent_id'=>849,
         ];
         method:post
         　　　　是否签名:是　　
       　　
         //商品列表页接口  默认排序
        $url = "www.liketea.com/index.php/api/Goods/goodsList";
         $data = [
             'id'=>851,  //当前分类id
             'p'=>1,     //页码
             'sort'=>'goods_id',//排序字段
             'sort_asc'=>'desc',//排序　　升序或是降序
         ];
         
         　　　　价格排序
         $url = "www.liketea.com/index.php/api/Goods/goodsList";
         $data = [
             'id'=>851,  //当前分类id
             'p'=>1,     //页码
             'sort'=>'shop_price',//排序字段
             'sort_asc'=>'desc',//排序　　升序或是降序
         ];
        　　　　 评价排序
         $url = "www.liketea.com/index.php/api/Goods/goodsList";
         $data = [
             'id'=>851,  //当前分类id
             'p'=>1,     //页码
             'sort'=>'comment_count',//排序字段
             'sort_asc'=>'desc',//排序　　升序或是降序
         ];
                     销量排序
          $url = "www.liketea.com/index.php/api/Goods/goodsList";
         $data = [
             'id'=>851,  //当前分类id
             'p'=>1,     //页码
             'sort'=>'sales_sum',//排序字段
             'sort_asc'=>'desc',//排序　　升序或是降序
         ];
         
          $url = "www.liketea.com/index.php/api/Goods/goodsList";
         $data = [
             'id'=>851,  //当前分类id
             'p'=>1,     //页码
             'sort'=>'sales_sum',//排序字段
             'sort_asc'=>'desc',//排序　　升序或是降序
         ];
         
         method:post
         
         //商品列表页搜索接口
         $url = "www.liketea.com/index.php/api/Goods/search";
         $data = [
             //'id'=>851,  //当前分类id
             'p'=>2,     //页码
             'sort'=>'goods_id',//排序字段
             'sort_asc'=>'asc',//排序　　升序或是降序
             'q'=>'茶'        //商品关键字
         ];
         
         method:post
         
         
         //登录接口
          www.liketea.com/index.php/api/User/login
          $data = [
            username:登录的手机号码
            password:登录的密码
            
          ]
          method:post 
          return:返回当前的账号信息需要调用者保存token值
          
           //商品列表页搜索接口  需要用户登录操作
         $token = '9c14902eb8cb3c68682d555210d40b8f';
         $url = "www.liketea.com/index.php/api/Goods/search?token={$token}";
         $data = [
             //'id'=>851,  //当前分类id
             'p'=>1,     //页码
             'sort'=>'goods_id',//排序字段
             'sort_asc'=>'asc',//排序　　升序或是降序
             'q'=>'茶'        //商品关键字
         ];
          
           //获取搜索关键字历史记录　需要用户登录操作
         $token = '9c14902eb8cb3c68682d555210d40b8f';
         $url = "www.liketea.com/index.php/api/Goods/getsearchlog?token={$token}";
         $data = [];
         method:post
         
         //获取商品信息接口
         $token = '9c14902eb8cb3c68682d555210d40b8f';
         $url = "www.liketea.com/index.php/api/Goods/goodsInfo";
         $data = [
             'id'=>106  商品的id
         ];
         
         method:post
         
         //获取商品的评价信息接口
        
         $url = "http://www.liketea.com/index.php/api/Goods/getGoodsComment";
         $data = [
             'id'=>106,
             'p'=>1
         ];
         
         
         //商品的物流运费计算　　正确的计算运费应该是获得当前登录用户的默认收货地址，取得其三级地区才可计算运费
        //并在订单确认修改收货地址时也要重新计算物流运费
         $url = "http://www.liketea.com/index.php/api/Goods/dispatching?goods_id=167";
         //$data = [
          //   'goods_id'=>167,
         //];
          * 
      
        //店铺信息获取接口
         $url = "http://www.liketea.com/index.php/api/Store/about";
         $data = [
             'store_id'=>1,
         ];
         method:post
          //店铺商品列表获取接口
         $url = "http://www.liketea.com/index.php/api/Store/storeGoods";
         $data = [
             'store_id'=>1,
         ];
         method:post
         
          //商品收藏接口 需要登录
         $token = '1db21bc6fcf0dada7553e8d89affcf74';
         $url = "http://www.liketea.com/index.php/api/Goods/collectGoodsOrNo?token={$token}";
         $data = [
             'goods_id'=>167,
         ];
         method:post
         
          //店铺收藏接口 需要登录
         $token = '1db21bc6fcf0dada7553e8d89affcf74';
         $url = "http://www.liketea.com/index.php/api/Store/collectStoreOrNo?token={$token}";
         $data = [
             'store_id'=>1
         ];
         
         //确认订单接口
         $token = '1db21bc6fcf0dada7553e8d89affcf74';
         $url = "http://www.liketea.com/index.php/api/Cart/cart2?token={$token}";
         $data = [
             'goods_id'=>167,
             'goods_num'=>2,
             'action'=>'buy_now'
         ];
         
         //获取用户收货地址列表接口
         $token = '1db21bc6fcf0dada7553e8d89affcf74';
         $url = "http://www.liketea.com/index.php/api/User/getAddressList?token={$token}";
         $data = [
         ];
         
         method:post
         
         //添加收货地址列表接口  以下为需要传递的参数
         //consignee 收货人
         //province  num
         //city      num
         //district  num
         //address   string
         //mobile    string
         //address_id num 存在则是更新操作　　否则则是添加操作
         //is_default =1 将此地址设置为　默认收货地址
         //town num
         //zipcode 邮政编码
         
         $token = '1db21bc6fcf0dada7553e8d89affcf74';
         $url = "http://www.liketea.com/index.php/api/User/addAddress?token={$token}";
         $data = [
             'consignee'=>'张飞',
             'province'=>'37906',
             'city'=>'37907',
             'district'=>'37909',
             'address'=>'南明区某地',
             'mobile'=>'18896871476',
             'is_default'=>1
         ];
         
         method:post
         
         
         
         //下单时使用的接口
         //action=buy_now 在用户修改商品数量以及使用优惠卷时重新计算一下总价格
         //act=submit_order 在提交订单的时候传递此参数　　完成订单入库并返回订单号
         $token = '1db21bc6fcf0dada7553e8d89affcf74';
         $url = "http://www.liketea.com/index.php/api/Cart/cart3?token={$token}";
         $data = [
             'goods_id'=>167,
             'goods_num'=>2,
             'action'=>'buy_now',
             'address_id'=>39,
             'user_note'=>['记得准时发货'],
             'action'=>'buy_now',
             //'act'=>'submit_order'
         ];
         
         method:post
         
         //使用了优惠卷
         $token = '1db21bc6fcf0dada7553e8d89affcf74';
         $url = "http://www.liketea.com/index.php/api/Cart/cart3?token={$token}";
         $data = [
             'goods_id'=>167,
             'goods_num'=>2,
             'action'=>'buy_now',
             'address_id'=>39,
             'user_note'=>'记得准时发货',
             'action'=>'buy_now',
             'coupon_id'=>'27', //优惠卷id
             'act'=>'submit_order'
         ];
         
         
         //支付页面调用的接口　　支付成功后跳转到订单详情　　支付成功就跳转到订单详情[成功页面]　　未支付成功则跳转到　订单详情[未成功页面]
        //根据订单号返回要支付的订单信息　　并点击支付按钮完成支付
         $token = '1db21bc6fcf0dada7553e8d89affcf74';
         $url = "http://www.liketea.com/index.php/api/Cart/cart4?token={$token}";
         $data = [
             'master_order_sn'=>'201803281452362322',
             'order_id'=>379,
         ];
         
         method:post

         //我的订单列表调用接口
         
         $token = '1db21bc6fcf0dada7553e8d89affcf74';
         $url = "http://www.liketea.com/index.php/api/User/getOrderList?token={$token}";
         $data = [
             'p'=>'1',
         ];
         
         //返回我的订单列表
         //order_status 订单状态.0待确认，1已确认，2已收货，3已取消，4已完成，5已作废
         //shipping_status  发货状态
         //pay_status 支付状态.0待支付，1已支付，2支付失败，3已退款，4拒绝退款
         $token = '1db21bc6fcf0dada7553e8d89affcf74';
         $url = "http://www.liketea.com/index.php/api/User/getOrderList?token={$token}";
         $data = [
             'p'=>'1',
         ];
         
         
         
          //订单详情获取接口
         
         $token = '1db21bc6fcf0dada7553e8d89affcf74';
         $url = "http://www.liketea.com/index.php/api/Order/order_detail?token={$token}";
         $data = [
             'id'=>'378',//订单id
         ];
         
         
            //获取当前店铺可以用的优惠卷列表  自行添加的接口
         $token = '1db21bc6fcf0dada7553e8d89affcf74';
         $url = "http://www.liketea.com/index.php/api/Store/getStoreCoupon?token={$token}";
         $data = [
             'storeid'=>'1',
         ];
         
         
          //会员注册接口
         
         $url = "http://www.liketea.com/index.php/api/User/reg";
         $data = [
             'username'=>'18896871476',
             'password'=>'123456',
             'password2'=>'123456',
             'code'=>'2074',
             'push_id'=>'21424214',
             'accept'=>'1'
         ];
          $url = "http://www.liketea.com/index.php/api/User/reg";
         $data = [
             'username'=>'18896871476',
             'password'=>'123456',
             'password2'=>'123456',
             'code'=>'2074',
             'push_id'=>'21424214',
             'accept'=>'1',
             'invite_code'=>'',//别人给的邀请码
         ];
         
           //忘记密码接口　　新增的接口
         
         $url = "http://www.liketea.com/index.php/api/User/forgotpwd";
         $data = [
             'username'=>'18896871476',
             'password'=>'123456',
             'password2'=>'123456',
             'code'=>'2074',
         ];
         
          //获取用户信息接口
         $token = '1db21bc6fcf0dada7553e8d89affcf74';
         $url = "http://www.liketea.com/index.php/api/User/userInfo?token={$token}";
         $data = [
         ];
         
          //收货地址删除接口
         $token = '1db21bc6fcf0dada7553e8d89affcf74';
         $url = "http://www.liketea.com/index.php/api/User/del_address?token={$token}";
         $data = [
             'id'=>'36',//收货地址的id
         ];
         
         //收货地址删除接口
         $token = '1db21bc6fcf0dada7553e8d89affcf74';
         $url = "http://www.liketea.com/index.php/api/User/getAddressList?token={$token}";
         $data = [
             'id'=>'36',//收货地址的id
         ];
         
         //获取省份信息
        
         $url = "http://www.liketea.com/index.php/Home/Api/getProvince";
         //获取市地区信息
        
         $url = "http://www.liketea.com/index.php?m=Home&c=Api&a=getRegionByParentId&parent_id=37906";
         
         
         //收货地址的添加/编辑　操作
        
        $token = 'a0ebca2ea326687678d3c5ee73abb37a';
         $url = "http://www.liketea.com/index.php/api/User/addAddress?token={$token}";
         $data = [
             'consignee'=>'刘玄德',
             'province'=>'37906',
             'city'=>'37907',
             'district'=>'37909',
             'address'=>'蜀国',
             'mobile'=>'18896871476',
             'is_default'=>0,
             'address_id'=>'38'//存在此参数则为修改操作
         ];
       
       
       //身份识别接口
        
         $idcard_f = "./public/upload/idcard/cxcidcard1.jpg";
         $idcard_g = "./public/upload/idcard/cxcidcard2.jpg";
         
         $idcard_source_f = base64_encode(file_get_contents($idcard_f));
         $idcard_source_g = base64_encode(file_get_contents($idcard_g));
         
         $token = 'a0ebca2ea326687678d3c5ee73abb37a';
         $url = "http://www.liketea.com/index.php/api/User/idcard_recognize?token={$token}";
         $data = [
             'realname'=>'曹晓晨',
             'sex'=>'1',
             'idcard'=>'320581199502271910',
             'idcard_f'=>$idcard_source_f,
             'idcard_b'=>$idcard_source_g
         ];
          //个人账户余额信息
        
         $token = '9f8f0a785d62279fdd2bfcdb41a3ac27';
         $url = "http://www.liketea.com/index.php/api/User/account?token={$token}";
         $data = [
             'is_json'=>1
         ];
         */
         
         //个人账户余额信息
        
        
         //登录接口
          $url = "http://www.liketea.com/index.php/api/User/login";
          
          $data = [
            'username'=>'18896871476',
            'password'=>'654321'
            
          ];
          
         $result = $this->get_api_data($url,'post',$data);
         
         
         print_r($result);
     }
     
     
 }
?>