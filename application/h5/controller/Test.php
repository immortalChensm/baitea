<?php
	namespace app\h5\controller;

  class Test extends Base
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
       
       
       //身份识别接口  实名认证
        
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
         
         //申请注册茶馆时图片的上传base64
        
          //入驻茶商或茶馆及茶艺师的图片上传接口　　
         $img = base64_encode(file_get_contents("jackma.jpg"));
          
         $token = '80f1828dc49583ac64d7ab91f1aee408';
         $url = "http://www.liketea.com/index.php/api/User/imgs_upload?token={$token}";
         $data = [
             'img'=>$img,
             'type'=>'tea_arts'
         ];
         
         */
         /*
         //入驻茶商接口
         //./public/upload/shopimgs/20180402065714654425b5a1258aad138981579e10dc3f.png
         $img = 'http://www.liketea.com/public/upload/shopimgs/20180402065714654425b5a1258aad138981579e10dc3f.png';
         $token = 'd8e5ccc538f9cd646b434d2a9f17b786';
         $url = "http://www.liketea.com/index.php/api/User/teamerchant_add?token={$token}";
         $data = [
                'shop_logo'=>$img,
                'store_name'=>'茶业店铺',//店铺名称
                'shop_zy'=>'茶叶，茶具，茶服',//主营商品
                'business_licence_number'=>'66454555546',//营业执照
                'business_licence_cert'=>$img,//注册号
                'country_cert'=>'',//认证证书
                'longtitude'=>'120.237',//店铺经纬度
                'latitude'=>'113.231',
                'shop_address'=>'上海市某某地',//店铺地址
                'shop_desc'=>'经营茶叶，茶具，茶服',//店铺简介
                'shop_bglist'=>$img,//店铺背景图片列表,
         ];
         
          //添加线下茶馆接口
         //./public/upload/shopimgs/20180402065714654425b5a1258aad138981579e10dc3f.png
         $img = 'http://www.liketea.com/public/upload/shopimgs/20180402065714654425b5a1258aad138981579e10dc3f.png';
         $token = 'c03822dbfb7bdf408849b0e10fdbaf25';
         $url = "http://www.liketea.com/index.php/api/User/teashop_add?token={$token}";
         $data = [
                'shop_logo'=>$img,
                'shop_name'=>'老油条的茶叶店',//店铺名称
                'shop_products'=>'茶叶，茶具，茶服',//主营商品
                'shop_licence_cert'=>'66454555546',//营业执照
                'shop_licence_img'=>$img,//注册号
                'shop_cert'=>'',//认证证书
                'shop_longitude'=>'120.237',//店铺经纬度
                'shop_latitude'=>'113.231',
                'shop_address'=>'上海市某某地',//店铺地址
                'shop_desc'=>'经营茶叶，茶具，茶服',//店铺简介
                'shop_bglist'=>$img,//店铺背景图片列表,
         ];
          //线下实体店铺茶馆列表
         //./public/upload/shopimgs/20180402065714654425b5a1258aad138981579e10dc3f.png
         $img = 'http://www.liketea.com/public/upload/shopimgs/20180402065714654425b5a1258aad138981579e10dc3f.png';
         $token = '097cc2272502a5e147bca6a2c911fc28';
         $url = "http://www.liketea.com/index.php/api/Store/getshop_list?token={$token}";
         $data = [
               'p'=>1, //分页
                'sort'=>'score'  //按评分来排序  distance 按距离来排序
         ];
         
         //会员入驻茶艺师接口
         //./public/upload/shopimgs/20180402065714654425b5a1258aad138981579e10dc3f.png


         $token = '80f1828dc49583ac64d7ab91f1aee408';


         $img = "./public/upload/tea_arts/2018040405135534ffeb359a192eb8174b6854643cc046.png";
         
         $url = "http://www.liketea.com/index.php/api/User/teart_add?token={$token}";
          $img = "./public/upload/tea_arts/2018040405135534ffeb359a192eb8174b6854643cc046.png";
          
         $url = "http://www.liketea.com/index.php/api/User/teart_add?token={$token}";
         $data = [
             'teart_id'=>1,//存在此变量意味着更新操作
             'teart_logo'=>$img,
             'teart_name'=>'差三姑爹五块钱',
             'teart_cert_num'=>'214214124',
             'teart_fcert'=>$img,
             'teart_bcert'=>$img,
             'longitude'=>'120.2312',
             'latitude'=>'113.2455',
             'teart_address'=>'北京市某某区某某地',
             'teart_desc'=>'专为各路茶友提供茶艺茶道展示，茶道讲解，茶水',
             'teart_pics'=>$img,
         ];
         
         //获取当前会员入驻茶艺师的状态信息接口
         //./public/upload/shopimgs/20180402065714654425b5a1258aad138981579e10dc3f.png
         $token = '73bd7037d5b81d55abd903ef3cf4f7bc';
         $url = "http://www.liketea.com/index.php/api/User/userteart_info?token={$token}";
         
         //茶艺师发布服务接口
         $token = '73bd7037d5b81d55abd903ef3cf4f7bc';
         $url = "http://www.liketea.com/index.php/api/User/addteart_service?token={$token}";
         $data = [
             'id'=>2,//存在即更新操作
             'start'=>'2018-04-06',//服务开始时间
             'end'=>'2018-04-08',//服务结束时间
             'orbit'=>'30',//服务范围
             'cost'=>'50',//服务费用
             'notice'=>'超过范围的不提供任何茶艺服务',//注意事项
         ];
         
         //获取茶艺师发布的服务
         //./public/upload/shopimgs/20180402065714654425b5a1258aad138981579e10dc3f.png
         $token = '73bd7037d5b81d55abd903ef3cf4f7bc';
        
         $url = "http://www.liketea.com/index.php/api/User/geteart_servicelist?token={$token}";
         $data = [
             'p'=>1
         ];
         
         //茶艺师关注和取消关注
         //./public/upload/shopimgs/20180402065714654425b5a1258aad138981579e10dc3f.png
         $token = '73bd7037d5b81d55abd903ef3cf4f7bc';
        
         $url = "http://www.liketea.com/index.php/api/User/subscribe_teart?token={$token}";
         $data = [
             'teart_id'=>1,//要关注的茶艺师id
         ];
         
         //茶艺师列表获取
         //./public/upload/shopimgs/20180402065714654425b5a1258aad138981579e10dc3f.png
         $token = '73bd7037d5b81d55abd903ef3cf4f7bc';
        
         $url = "http://www.liketea.com/index.php/api/User/teart_list?token={$token}";
         $data = [
             'p'=>1,//分页码
             'sort'=>'score',//distance 距离排序　　score评分排序
         ];
         
         //茶艺师列表获取  搜索使用
         //./public/upload/shopimgs/20180402065714654425b5a1258aad138981579e10dc3f.png
         $token = '73bd7037d5b81d55abd903ef3cf4f7bc';
        
         $url = "http://www.liketea.com/index.php/api/User/teart_list_serach?token={$token}";
         $data = [
             'p'=>1,//分页码
             'sort'=>'score',//distance 距离排序　　score评分排序
             'keyword'=>'五块钱',
             'longitude'=>'',//当前会员的位置
             'latitude'=>'',
         ];
         
          //茶艺师详情获取
         //./public/upload/shopimgs/20180402065714654425b5a1258aad138981579e10dc3f.png
         $token = '73bd7037d5b81d55abd903ef3cf4f7bc';
        
         $url = "http://www.liketea.com/index.php/api/User/get_teart_info?token={$token}";
         $data = [
             'teart_id'=>1,
             'longitude'=>'',//当前会员的位置
             'latitude'=>'',
         ];
         
         
          //茶艺师预约订单结算
         //./public/upload/shopimgs/20180402065714654425b5a1258aad138981579e10dc3f.png
         $token = '73bd7037d5b81d55abd903ef3cf4f7bc';
        
         $url = "http://www.liketea.com/index.php/api/User/addteart_order?token={$token}";
         $data = [
             'teart_id'=>1,//要预约的茶艺师id
             'start'=>'2018-08-10 10:20',//预约服务的时间段
             'end'=>'2018-08-10 15:20',
             'longitude'=>'',//预约服务的位置
             'latitude'=>''
         ];
         
         
         //茶艺师预约订单提交
         //./public/upload/shopimgs/20180402065714654425b5a1258aad138981579e10dc3f.png
         $token = '5bd2ef83d82f8ae7cf7c11518a9b32fc';
        //31.25812,120.73815
         $url = "http://www.liketea.com/index.php/api/User/submit_tea_order?token={$token}";
         $data = [
             'teart_id'=>1,//要预约的茶艺师id
             'start'=>'2018-04-08 10:20',//预约服务的时间段
             'end'=>'2018-04-08 15:20',
             'longitude'=>'120.74815',//预约服务的位置
             'latitude'=>'31.26812',
             'address'=>'北京市',//预约服务的具体位置
         ];
         
          //茶艺师预约订单支付页面　获取支付金额　及订单信息
         //./public/upload/shopimgs/20180402065714654425b5a1258aad138981579e10dc3f.png
         $token = '5bd2ef83d82f8ae7cf7c11518a9b32fc';
        //31.25812,120.73815
         $url = "http://www.liketea.com/index.php/api/User/teapayorder?token={$token}&order_id=11";
         $data = [
                'order_id'=>'11'
         ];
         
         
         //茶艺师订单支付宝支付
         //./public/upload/shopimgs/20180402065714654425b5a1258aad138981579e10dc3f.png
         $token = '5bd2ef83d82f8ae7cf7c11518a9b32fc';
        //31.25812,120.73815
         $url = "http://www.liketea.com/index.php/api/Apppay/alipay_sign?token={$token}&order_id=11";
         $data = [
                'order_sn'=>'201804090943452366',//订单号
         ];
         
         //会员我的预约订单列表
         //./public/upload/shopimgs/20180402065714654425b5a1258aad138981579e10dc3f.png
         $token = '04a82c448dbbc6f381a632905e907c30';
        //31.25812,120.73815
         $url = "http://www.liketea.com/index.php/api/User/tearorder_list?token={$token}";
         $data = [
                
         ];
        */
         
         //会员我的预约订单列表

          /*$token = 'eb7bf927efc12a4c51c353c235b23701';

        $url = "http://www.liketea.com/index.php/api/User/tearorder_list?token={$token}";
         $data = [
                'p'=>1,
                'status'=>0,//0 全部　1待付款　２待评价　３待审核　４已完成
         ];
         
         //茶艺师预约订单微信支付
         $token = 'eb7bf927efc12a4c51c353c235b23701';
         
         $url = "http://www.liketea.com/index.php/api/Teawxpay/dopay?token={$token}";
         $data = [
             'order_sn'=>'201804090943452366',//订单号
             'trade_type'=>'APP'
         ];
         
          //茶艺师预约订单详情
         $token = 'eb7bf927efc12a4c51c353c235b23701';
         
         $url = "http://www.liketea.com/index.php/api/User/getteaorder_details?token={$token}";
         $data = [
                'order_id'=>'11'
         ];
         
         //茶艺师预约订单取消申请
         $token = 'eb7bf927efc12a4c51c353c235b23701';
         
         $url = "http://www.liketea.com/index.php/api/User/cancelteaorder?token={$token}";
         
         $data = [
                'order_id'=>'11'
         ];
         
         //茶艺师预约订单评价
         $token = 'eb7bf927efc12a4c51c353c235b23701';
         
         $url = "http://www.liketea.com/index.php/api/User/teaorder_comment?token={$token}";
         
         $data = [
                'order_id'=>'11',
                'star'=>'3',
                'content'=>'茶艺师的服务不错，准时服务到位'
         ];
         //茶艺师接单详情页面
         $token = 'cef02015f3508e65ea49d64991ec5904';
         $url = "http://www.liketea.com/index.php/api/User/teart_receiveorder?token={$token}";
         $data = [
                'order_id'=>'11'
         ];
         
         
         //茶艺师接单详情页面
         $token = '773d45ce7ec39643f2927fcfa5c60883';
         $url = "http://www.liketea.com/index.php/api/User/tea_dealorder?token={$token}";
         $data = [
                'order_id'=>'12',
         ];
         
         //茶艺师对取消的订单　　处理　　该接口未完成　　退款流程
         $token = '773d45ce7ec39643f2927fcfa5c60883';
         $url = "http://www.liketea.com/index.php/api/User/dealcancel_order?token={$token}";
         $data = [
                'order_id'=>'12',
         ];
         
         //发帖
         $img = "./public/upload/tea_arts/2018040405135534ffeb359a192eb8174b6854643cc046.png";
         $token = '773d45ce7ec39643f2927fcfa5c60883';
         $url = "http://www.liketea.com/index.php/api/Article/addarticle?token={$token}";
         $data = [
                'title'=>'本公司茶叶新鲜出销，百年茶叶',
                'content'=>'本公司茶叶新鲜出销，百年茶叶本公司茶叶新鲜出销，百年茶叶本公司茶叶新鲜出销，百年茶叶本公司茶叶新鲜出销，百年茶叶本公司茶叶新鲜出销，百年茶叶本公司茶叶新鲜出销，百年茶叶本公司茶叶新鲜出销，百年茶叶本公司茶叶新鲜出销，百年茶叶本公司茶叶新鲜出销，百年茶叶本公司茶叶新鲜出销，百年茶叶本公司茶叶新鲜出销，百年茶叶本公司茶叶新鲜出销，百年茶叶',
                'imglist'=>$img
         ];
          //帖子详情
         $img = "./public/upload/tea_arts/2018040405135534ffeb359a192eb8174b6854643cc046.png";
         $token = '773d45ce7ec39643f2927fcfa5c60883';
         $url = "http://www.liketea.com/index.php/api/Article/details?token={$token}";
         $data = [
                'article_id'=>1
         ];
         
         
         //评论帖子
         $img = "./public/upload/tea_arts/2018040405135534ffeb359a192eb8174b6854643cc046.png";
         $token = '92478372ce5c692c729ec2e9880828ef';
         $url = "http://www.liketea.com/index.php/api/User/myarticle?token={$token}";
         $data = [
                'article_id'=>1,
         ];
         
         
        //优惠卷列表
        //需要商家在后台发布，发布的优惠卷并不能马上领取，会延迟一天
         $token = '6c047136726e8c422ecd85e7ac3387c5';
         $url = "http://www.liketea.com/index.php/api/Activity/coupon_list?token={$token}";
         $data = [
                'p'=>1,
         ];
             
                  
          //获取用户已经领取的优惠卷　　
         $token = "6c047136726e8c422ecd85e7ac3387c5";
         $url = "www.liketea.com/index.php/api/User/getCouponList?token={$token}";
         $data = [
            'store_id'=>1,//此参数必须传递　否则可能是获取其它商家的优惠卷了
         ];
         
         响应的内容：
         {
  "status": 1,
  "msg": "获取成功",
  "result": [
    {
      "id": 65,　　　　用户的优惠卷id
      "cid": 32,
      "type": 2,
      "uid": 48,
      "order_id": 0,
      "get_order_id": null,
      "use_time": 0,
      "code": "",
      "send_time": 1523607202,
      "store_id": 1,    店铺的id
      "status": 0,
      "deleted": 0,
      "name": "老油条发布的优惠卷",
      "use_type": 0,
      "money": "10.00",
      "use_start_time": 1523692867,
      "use_end_time": 1528876867,
      "condition": "11.00",
      "limit_store": "TPSHP旗舰店"
    }
  ]
}
         */
         
         //领取优惠卷接口  本项目只是免费领取优惠卷　　默认是全店使用的优惠卷
        
         //优惠卷使用流程：１商家发布　　２调用优惠卷列表接口获取优惠卷　３用户选择优惠卷时调用领取优惠卷接口完成领取　４下单时调用我的优惠卷接口获取优惠卷　　５下单时传递店铺对应我的优惠卷id
         //优惠卷接口使用流程：１调用优惠卷列表接口　２调用领取优惠卷接口　３我的优惠卷接口
         $token = '6c047136726e8c422ecd85e7ac3387c5';
         $url = "http://www.liketea.com/index.php/api/Activity/get_coupon?token={$token}";
         $data = [
                'coupon_id'=>32,//要领取的优惠卷id
         ];
         
         $result = $this->get_api_data($url,'post',$data);

         print_r($result);
     }
     
      
 }
?>