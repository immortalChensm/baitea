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
use think\Db;
use app\common\logic\StoreLogic;
use app\common\logic\StoreGoodsClass;


class Store extends Base {
    private $store;
    
    public function _initialize(){
        $store_id = I('store_id/d', 0);
        $this->store = M('store')->where(array('store_id'=>$store_id))->find();
    }
    
    /**
     * 关于店铺(店铺基本信息)
     */
    public function about(){
        $store_id = I('store_id/d',0); // 当前分类id //  "store_id , store_name , grade_id , province_id , city_id , store_address , store_time"
        $store = M('store')->where("store_id",$store_id)->find();
        if (!$store) {
            $this->ajaxReturn(['status' => -1, 'msg' => '店铺不存在']);
        }
        
        //所在地
        $regions = M("region")->where(" id in( ".$store['province_id'] ." , ".$store['city_id']." , ".$store['district']." )")->select();
        $region= "";
        foreach($regions as $k => $v){
            $region .= $v['name'];
        }
        $store['location'] = $region;
         
        $gradgeId = $store['grade_id'];
        
        //查询店铺等级
        $gradgeName = M('store_grade')->where("sg_id",$gradgeId)->getField("sg_name");
        $store['grade_name'] = $gradgeName;
        
        $total_goods = M('goods')->where(array('store_id'=>$store_id,'is_on_sale'=>1))->count();
        $store['total_goods'] = $total_goods;
        
        //新品
        $new_goods = M('goods')->where(array('store_id'=>$store_id,'is_new'=>1,'is_on_sale'=>1))->count();
        $store['new_goods'] = $new_goods;
        
        //热卖商品
        $hot_goods = M('goods')->where(array('store_id'=>$store_id,'is_hot'=>1,'is_on_sale'=>1))->count();
        $store['hot_goods'] = $hot_goods;
        
        $collect = M('store_collect')->where(['store_id'=> $store_id, 'user_id' => $this->user_id])->find();
        $store['is_collect'] = $collect ? 1 : 0;
                
        $res = array('status'=>1,'msg'=>'获取成功','result'=>$store );
        $this->ajaxReturn($res);
    }
      

    /***
     * 店铺
     */
    public function index()
    {
        $store_id = I('store_id/d',0);
        $store = M('store')->where("store_id=$store_id")->find();
        if (!$store) {
            $this->ajaxReturn(['status' => -1, 'msg' => '店铺不存在']);
        }
        
        //新品
        $new_goods_list = M('goods')->field('goods_content',true)->where(array('store_id'=>$store_id,'is_new'=>1))->order('goods_id desc')->limit(10)->select();
        //推荐商品
        $recomend_goods = M('goods')->field('goods_content',true)->where(array('store_id'=>$store_id,'is_recommend'=>1))->order('goods_id desc')->limit(10)->select();  
        //热卖商品
        $hot_goods_list = M('goods')->field('goods_content',true)->where(array('store_id'=>$store_id,'is_hot'=>1))->order('goods_id desc')->limit(10)->select();
        
        //店铺商品总数
        $total_goods = M('goods')->where(array('store_id'=>$store_id,'is_on_sale'=>1))->count();
        
        //店铺收藏总数
        $store_collect = M('store_collect')->where('store_id', $store_id)->count();
        
        $collect = M('store_collect')->where(['store_id'=> $store_id, 'user_id' => $this->user_id])->find();
        
        //新品
        $new_goods = M('goods')->where(array('store_id'=>$store_id,'is_new'=>1,'is_on_sale'=>1))->count();
        
        //热卖商品
        $hot_goods = M('goods')->where(array('store_id'=>$store_id,'is_hot'=>1,'is_on_sale'=>1))->count();
        
        $store['is_collect'] = $collect ? 1 : 0;
        $store['recomend_goods'] = $recomend_goods;
        $store['new_goods_list'] = $new_goods_list;
        $store['hot_goods_list'] = $hot_goods_list;
        $store['store_collect'] = $store_collect;
        $store['total_goods'] = $total_goods;
        $store['new_goods'] = $new_goods;
        $store['hot_goods'] = $hot_goods;
        
        $json_arr = array('status'=>1,'msg'=>'获取成功','result'=>$store );
        
        $this->ajaxReturn($json_arr);
    }
    
    
    /**
     * 搜索店铺内的商品
     */
    public function searchStoreGoodsClass(){
    
        $store_id = I('store_id/d',1);
      
        $search_key = I("search_key");  // 关键词搜索
        
        $where = " where 1 = 1 ";
    
        $search_key && $where .= " and (goods_name like '%$search_key%' or keywords like '%$search_key%')";
    
        if ($store_id > 0) {
            $where .= " and store_id = ".  $store_id;     //店铺ID
        }
        
        $cat_id  = I("cat_id/d",0); // 所选择的商品分类id
        if ($cat_id > 0) {
            $where .= " and store_cat_id2 = ".  $cat_id ; // 初始化搜索条件
        }
        
        $list = M("goods")->where("store_id = 1")->field("goods_remark,goods_content,is_virtual" , true)->limit(0 , 10)->select();
        $this->ajaxReturn(['status'=>1, 'msg'=>'获取成功', 'result'=>$list]);
    }
    
    /**
     * 获取店铺商品分类
     */
    public function storeGoodsClass(){
        $store_id = $this->store['store_id'];
        $goods_logic = new StoreGoodsClass;
        $store_goods_class =  $goods_logic->getStoreGoodsClass($store_id);
        $json_arr = array('status'=>1,'msg'=>'获取成功','result'=>$store_goods_class);
        $this->ajaxReturn($json_arr);
    }

    /**
     * @author dyr
     * 修改于2016/08/26
     * 获取店铺商品列表
     */
    public function storeGoods()
    {
        $store_id = $this->store['store_id'];
        $page = I('p', 1);
        $sort = I('sort', 'comprehensive');
        $sore_mode = I('mode', 'desc');
        $cat_id = I('cat_id/d');
        $sta = I('sta/s');  //状态:is_new 是否最新, is_hot是否热销
        $q = I('q', ''); //搜索词
        
        $store_goods_where['store_id'] = $store_id;
        
        if ($q !== '') {
            $store_goods_where['goods_name|keywords'] = ['like', "%$q%"];
        }
        
        if (!empty($cat_id) && ($cat_id != -1)) {
            $store_goods_class_info = M('store_goods_class')->where(array('cat_id' => $cat_id))->find();
            if ($store_goods_class_info['parent_id'] == 0) {
                //一级分类
                $store_goods_where['store_cat_id1'] = $cat_id;
            } else {
                //二级分类
                $store_goods_where['store_cat_id2'] = $cat_id;
            }
        }

        if ($sort == 'sales') { //销量排序
            $orderBy = array(
                'sales_sum' => $sore_mode,
                'sort' => 'desc',
            );
        } else if ($sort == 'price') { //价格排序
            $orderBy = array(
                'shop_price' => $sore_mode,
                'sort' => 'desc',
            );
        } else { //综合排序
            $orderBy = array(
                'sort' => 'desc',
            );
        }
        
        if($sta && $sta == 'is_new'){//最新
            $store_goods_where['is_new'] = 1;
        }
        if($sta && $sta == 'is_hot'){//热销
            $store_goods_where['is_hot'] = 1;
        }
        
        $store_goods_where['is_on_sale'] = 1;
        $store_goods_list_new = M('goods')
            ->field('goods_remark,goods_id,cat_id3,goods_sn,goods_name,shop_price,comment_count,sales_sum,is_virtual,original_img')
            ->where($store_goods_where)
            ->order($orderBy)
            ->page($page, 10)
            ->select();
        
        //获取各商品的星级指数
        $store_goods_list_new = $this->getstoreinfo_bygoods($store_goods_list_new);
        $store_goods_list['goods_list'] = $store_goods_list_new;
        
        $store_goods_list['sort'] = $sort;
        $store_goods_list['sort_asc'] = $sore_mode;
        $store_goods_list['orderby_default'] = U('storeGoods', array('store_id' => $store_id));
        $store_goods_list['orderby_sales_sum'] = ($sort == 'sales' && $sore_mode == 'desc') ? U('storeGoods', array('store_id' => $store_id, 'sort' => 'sales', 'mode' => 'asc')) : U('storeGoods', array('store_id' => $store_id, 'sort' => 'sales', 'mode' => 'desc'));
        $store_goods_list['orderby_price'] = ($sort == 'price' && $sore_mode == 'desc') ? U('storeGoods', array('store_id' => $store_id, 'sort' => 'price', 'mode' => 'asc')) : U('storeGoods', array('store_id' => $store_id, 'sort' => 'price', 'mode' => 'desc'));
        $store_goods_list['orderby_comprehensive'] = ($sort == 'comprehensive' && $sore_mode == 'desc') ? U('storeGoods', array('store_id' => $store_id, 'mode' => 'asc')) : U('storeGoods', array('store_id' => $store_id, 'mode' => 'desc'));
        $json_arr = array('status' => 1, 'msg' => '获取成功', 'result' => $store_goods_list);
        $this->ajaxReturn($json_arr);
    }

    //获取店铺信息　用于获取商品列表时
    private function getstoreinfo_bygoods($goodslist)
    {
        $list = Db::name("store")->field("store_id,store_name")->select();
        $store = [];
        foreach($list as $k=>$v){
            $store[$v['store_id']] = $v['store_name'];
        }
    
        foreach($goodslist as $k=>$v){
            //$goodslist[$k]['store_name'] = $store[$v['store_id']];
            $goodslist[$k]['comment_score'] = $this->commentStatistics($v['goods_id']);
        }
        return $goodslist;
    }
    
    //获取商品列表的综合评价
    /**
     * 获取某个商品的评论统计
     * 全部评论数  好评数 中评数  差评数
     * @param $goods_id
     * @return array
     */
    private  function commentStatistics($goods_id)
    {
        $commonWhere = ['is_show' => 1,'goods_id' => $goods_id,'user_id'=>['gt',0],'deleted'=>0]; //公共条件
    
        /*
         $c1 = M('Comment')->where($commonWhere)->where(" ceil(goods_rank) in(4,5)")->count(); // 好评
         $c2 = M('Comment')->where($commonWhere)->where(" ceil(goods_rank) in(3)")->count(); // 中评
         $c3 = M('Comment')->where($commonWhere)->where(" ceil(goods_rank) in(0,1,2)")->count(); // 差评
         //$c4 = M('Comment')->where($commonWhere)->where(" img !='' and img NOT LIKE 'N;%'")->count(); // 晒图
    
         $c0 = $c1 + $c2 + $c3; // 所有评论
         if ($c0 > 0) {
         $rate1 = ceil($c1 / ($c1 + $c2 + $c3) * 100); // 好评率
         $rate2 = ceil($c2 / ($c1 + $c2 + $c3) * 100); // 中评率
         $rate3 = ceil($c3 / ($c1 + $c2 + $c3) * 100); // 差评率
         //综合评价
         $all = ceil(($c1+$c2+$c3)/3);
         } else {
         $rate1 = 100; // 好评率
         $rate2 = 0; // 中评率
         $rate3 = 0; // 差评率
    
         $all = 0;
         }
        */
    
        //获取该商品的评论人数
    
        $comment_count = M('Comment')->where($commonWhere)->where("ceil(goods_rank) in(0,1,2,3,4,5)")->count();
    
        //统计该商品的综合星级指数
        $comment_star = M('Comment')->where($commonWhere)->where("ceil(goods_rank) in(0,1,2,3,4,5)")->sum("goods_rank");
    
        //计算综合评论星级
        if($comment_star&&$comment_count){
            $all_star = ceil($comment_star/$comment_count);
        }else{
            $all_star = 0;
        }
    
    
        return array('all'=>$all_star);
    }
    
    
    /**
     * @author dyr
     * 店铺收藏or取消操作
     */
    public function collectStoreOrNo()
    {
        $store_logic = new StoreLogic();
        $json_arr = $store_logic->collectStoreOrNo($this->user_id,$this->store['store_id'],$this->user['nickname']);
        $this->ajaxReturn($json_arr);
    }
    
    //获取商家已经发布的优惠卷
    //影响优惠卷使用的条件
    //领取数量，发送数量
    //优惠卷开始时间，结束时间
    public function getStoreCoupon()
    {
        
        $map['store_id'] = I("storeid");
       
        $list = Db::name("coupon")->where("store_id",$map['store_id'])->select();
        foreach ($list as $k=>$v){
            //使用数量和领取数量超级了发行量
            if($v['send_num']>=$v['createnum']){
                unset($list[$k]);
            }
            //如果当前时间超过了使用结束时间
            if(time()>=$v['use_end_time']){
                unset($list[$k]);
            }
        }
        
        $this->ajaxReturn($list);
    }
    
    //获取店铺列表
    public function getshop_list()
    {
        
       $page = I('p', 1);
       $sort = I('sort','score');
       
       $user_location = I('location');

       //获取茶馆　　默认按评分来处理
       $store_list = M('Store')->alias("s")
                        ->field('
                            s.store_name,
                            s.store_zy,
                            s.store_id,
                            s.store_desccredit,
                            s.store_servicecredit,
                            s.store_deliverycredit,
                            se.shop_address,
                            se.shop_longitude,
                            se.shop_latitude
                            ')
                        ->join("__STORE_ENTRY__ se","s.store_id=se.store_id","LEFT")
                        ->where("s.store_state",1)  //开启中的店铺
                        ->where("deleted",0)
                        ->page($page, 10)
                        ->fetchSql(false)
                        ->select();
       
       
       //按茶馆距离来算的处理流程
       //1、先获取当前登录用户的经纬度
       //2、获取所有的店铺的经纬度
       //3、调用第三方接口计算距离进行排序
       
       
       if($sort=='score'){
           foreach ($store_list as $k=>$v){
               
               $temp = round(($v['store_desccredit']+$v['store_servicecredit']+$v['store_deliverycredit'])/3,1);
               
               $store_list[$k]['score'] = $temp;
           }
       }
       /*$score = [];
       foreach ($store_list as $k=>$v){
           $score[$v['store_id']] = $v['score'];
       }
       asort($score);
       */
       
       $store_list_sort = $this->sortByField($store_list,'score');
       print_r($store_list_sort);
       
       $this->ajaxReturn($store_list);
    }
    
    /**
     * 二维数组按指定字段升序降序
     * **/
    public function sortByField($multArray,$sortField,$desc=0){
            $tmpKey='';
            $ResArray=array();

            $maIndex=array_keys($multArray);
            $maSize=count($multArray)-1;

            for($i=0; $i < $maSize ; $i++) {

               $minElement=$i;
               $tempMin=$multArray[$maIndex[$i]][$sortField];
               $tmpKey=$maIndex[$i];

                for($j=$i+1; $j <= $maSize; $j++)
                  if($multArray[$maIndex[$j]][$sortField] < $tempMin ) {
                     $minElement=$j;
                     $tmpKey=$maIndex[$j];
                     $tempMin=$multArray[$maIndex[$j]][$sortField];

                  }
                  $maIndex[$minElement]=$maIndex[$i];
                  $maIndex[$i]=$tmpKey;
            }

           if($desc)
               for($j=0;$j<=$maSize;$j++)
                  $ResArray[$maIndex[$j]]=$multArray[$maIndex[$j]];
           else
              for($j=$maSize;$j>=0;$j--)
                  $ResArray[$maIndex[$j]]=$multArray[$maIndex[$j]];

           return $ResArray;
       }
}