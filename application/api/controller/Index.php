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
use app\common\logic\GoodsLogic;
use app\common\logic\StoreLogic;
use think\Db;
use think\Page;
class Index extends Base {

    public function index(){
        return $this->fetch();
    }
 
    /**
     * 获取首页数据
     */
    public function homePage()
    {
        $new_ad = I('new_ad',0); 
        $goodsLogic = new GoodsLogic(); 
        if($new_ad == 1){//新版新增广告模式  
            $banners =  $goodsLogic->getAppHomeAdv(true);
            foreach ($banners as $k => $v){
                if($v['media_type'] == 4){//如果是分类, 截取最后一个分类
                    $cats = explode('_',$v['ad_link']);
                    $count = count($cats);
                    if($count == 0)continue;
                    $v['ad_link'] = $cats[$count-1];
                    $banners[$k] = $v;
                }
            }
            $advs =  $goodsLogic->getAppHomeAdv(false);
            foreach ($advs as $k => $v){
                if($v['media_type'] == 4){//如果是分类, 截取最后一个分类
                    $cats = explode('_',$v['ad_link']);
                    $count = count($cats); 
                    if($count == 0)continue;
                    $v['ad_link'] = $cats[$count-1];
                    $advs[$k] = $v;
                }
            }
         
            $time_space = flash_sale_time_space();
            $time_arr = $time_space[1];//获取当前时间节点的请购信息
             
            $flash_sale_goods = $goodsLogic->getFlashSaleGoods(3 ,1 , $time_arr['start_time'], $time_arr['end_time']);
            $this->ajaxReturn(array(
                'status'=>1,
                'msg'=>'获取成功 11',
                'result'=>array(
                    'banner'=>$banners,
                    'ad'=>empty($advs) ? array() : $advs,
                    'flash_sale_goods' => $flash_sale_goods
                ),
            ));
        } 
        
        $promotion_goods = $goodsLogic->getPromotionGoods1();
        $high_quality_goods = $goodsLogic->getRecommendGoods(1);
        $flash_sale_goods = $goodsLogic->getFlashSaleGoods(3);
        $new_goods = $goodsLogic->getNewGoods();
        $advs =  $goodsLogic->getHomeAdv();
        /*foreach ($promotion_goods  as $key) {
            $promotion_goods['url'] = SITE_URL.U('');
        }*/
        foreach ($advs as &$adv) {
            $adv['ad_code'] = SITE_URL.$adv['ad_code'];
        }
        $this->ajaxReturn(array(
            'status'=>1,
            'msg'=>'获取成功',
            'result'=>array(
               'promotion_goods'=>$promotion_goods,
               'high_quality_goods'=>$high_quality_goods,
               'flash_sale_goods' => $flash_sale_goods,
               'new_goods'=>$new_goods,
               'ad'=>$advs
            ),
        ));
    }
    
  
    /**
     * 推荐的商品列表
     */
    public function recommend()
    {
        $p = I('p/d',1);
        $goodsLogic = new GoodsLogic();
        $json = [
            'status'=>1,
            'msg'=>'获取成功',
            'result' => $goodsLogic->getRecommendGoods($p),
        ];
       $this->ajaxReturn($json);
    }

    /**
     * 猜你喜欢: 根据经纬度, 返回距离由近到远的商品
     */
    public function favourite()
    {
       $p = I('p',1);
        
        $lng =trim(I('lng/s',114.067345));  //经度
        $lat =trim(I('lat/s',22.632611));    //纬度   
  
        $count= Db::query("SELECT COUNT(store_id) as num  FROM `tp_store` WHERE store_state = 1");//正常店铺
        $Page=new Page($count[0]['num'],10);
        $firstRow = ($p-1)*10;
        $goods_list = Db::query("SELECT g.goods_id, goods_name,is_virtual,shop_price,cat_id3, s.store_id , ROUND(SQRT((POW((($lng - longitude)* 111),2))+ (POW((($lat - latitude)* 111),2))),2) AS distance FROM tp_goods AS g INNER JOIN tp_store AS s
                                            ON g.`store_id` = s.store_id  AND store_state=1 AND is_recommend=1 AND g.goods_state=1 AND  g.is_on_sale=1 ORDER BY distance ASC  LIMIT {$firstRow},{$Page->listRows} ");
        
        $json = array(
            'status'=>1,
            'msg'=>'获取成功',
            'result' => array(
                'favourite_goods'=>$goods_list,
            ),
        );    
        
       $this->ajaxReturn($json);
    }

    /**
     * 获取服务器配置
     */
    public function getConfig()
    {
        $data = M('plugin')->where("type='login' and code in ('weixin','qq')")->select();
        $arr = array();
        foreach($data as $k=>$v){
            unset( $data[$k]['config']);
        
			if(!$v['config_value']){
				$data[$k]['config_value'] = "";
			}else{
				$data[$k]['config_value'] = unserialize($v['config_value']);
			}
		 
            if($data[$k]['type'] == 'login'){
                $arr['login'][] =  $data[$k];
            }
        } 
        
        $config_name = ['qq', 'qq2', 'qq3', 'store_name', 'point_rate', 'phone', 
            'address','hot_keywords', 'app_test', 'sms_time_out', 'regis_sms_enable', 
            'forget_pwd_sms_enable', 'bind_mobile_sms_enable','integral_use_enable'];
        $inc_type = ['ios','app'];
        $config = M('config')->where('name', 'IN', $config_name)->whereOr('inc_type' , 'IN' , $inc_type)->select();
        $result = ['config' => $config] + $arr;
        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $result]);
    }

    /**
     * 店铺街
     * @author dyr
     * @time 2016/08/15
     * 根据百度坐标，获取周边商家
     *  $lng 经度
     *  $lat 纬度
     *  $scope 范围  千米
     *  $fourpoint
     * */
    public function store_street()
    {
        $sc_id = I('get.sc_id/d', '');
        $p = I('get.p',1);
        $lng =trim(I('lng/s',114.067345));  //经度
        $lat =trim(I('lat/s',22.632611));    //纬度
        $province_id = I('province_id', 0);
        $city_id = I('city_id', 0);
        $district_id = I('district_id', 0);
        $order = I('sale_order', 0);

        //地区ID,目前搜索时只精确到市
        $address=['province_id'=>$province_id, 'city_id'=>$city_id, 'district_id'=>$district_id];
        $storeLogic = new StoreLogic();
        $store_list = $storeLogic->getStreetList($sc_id, $p, 10, $order, $this->user_id, $address, $lng, $lat);//获取店铺列表
        $distance = convert_arr_key($store_list,"store_id");

        //遍历获取店铺的四个商品数据
        foreach ($store_list as $key => $value) {
            $goodsList = $storeLogic->getStoreGoods($value['store_id'], 4);
            $store_list[$key]['cartList'] = $goodsList['goods_list'];
            $store_list[$key]['store_count'] = $goodsList['goods_count'];
            $store_list[$key]['distance'] = $distance[$value['store_id']]['distance'] ? $distance[$value['store_id']]['distance'] : -1;
            $store_list[$key]['is_collect'] = $value['add_time'] ? 1 : 0;
        }
        $result['store_list'] = $store_list;

        if ($p <= 1) {
            $result['store_class'] = M('store_class')->field('sc_id,sc_name')->select();
            array_unshift($result['store_class'], ['sc_id' => 0, 'sc_name' => '全部分类']);

            //查找广告
            $start_time = strtotime(date('Y-m-d H:00:00'));
            $end_time = strtotime(date('Y-m-d H:00:00'));
            $adv = M("ad")->field(array('ad_link','ad_name','ad_code','media_type,pid'))->where("pid=535 AND enabled=1 and start_time< $start_time and end_time > $end_time")->find();
            if($adv && $adv['media_type'] == 4){//如果是分类, 截取最后一个分类
                $cats = explode('_',$adv['ad_link']);
                $count = count($cats);
                if($count != 0){
                    $adv['ad_link'] = $cats[$count-1];
                }
            }

            $result['ad'] = empty($adv) ? "" : $adv ;
        }

        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $result]);
    }

    /**
     * 小程序的店铺街
     */
    public function store_street_list()
    {
        $p = I('p',1);
        $sc_id = I('get.sc_id/d',0);
        $province_id = I('province_id', 0);
        $city_id = I('city_id', 0);
        $district_id = I('district_id', 0);
        $order = I('sale_order', 0);

        //地区ID,目前搜索时只精确到市
        $address=['province_id'=>$province_id, 'city_id'=>$city_id, 'district_id'=>$district_id];
        $storeLogic = new StoreLogic();
        $store_list = $storeLogic->getStreetList($sc_id, $p, 10, $order, $this->user_id ,$address);
        foreach ($store_list as &$store) {
            $goodsList = $storeLogic->getStoreGoods($store['store_id'], 4);
            $store['cartList'] = $goodsList['goods_list'];
            $store['store_count'] = $goodsList['goods_count'];
            $store['is_collect'] = $store['add_time'] ? 1 : 0;
            $store['distance'] = -1;//遗留
        }
        $result['store_list'] = $store_list;
        
        if ($p <= 1) {
            $result['store_class'] = M('store_class')->field('sc_id,sc_name')->select();
            array_unshift($result['store_class'], ['sc_id' => 0, 'sc_name' => '全部分类']);
            $result['ad'] = M('ad')->field(['ad_link','ad_name','ad_code'])->where('pid', 2)->cache(true, TPSHOP_CACHE_TIME)->find();
        }
        
        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $result]);
    }

    /**
     * 店铺分类
     */
    public function store_class()
    {
        $store_class = M('store_class')->field('sc_id,sc_name')->select();
        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $store_class]);
    }

    /**
     * 品牌街
     * @author dyr
     * @time 2016/08/15
     */
    public function brand_street()
    {
        $p = I('get.p', 1);
        
        $brand_list = M('brand')->field('id,name,logo,url')
                ->where(['is_hot' => 1])
                ->order(['sort' => 'desc', 'id' => 'asc'])
                ->where('status', 0)
                ->page($p, 30)
                ->select();
        $result['brand_list'] = $brand_list;
        
        if ($p <= 1) {
            $goodsLogic = new GoodsLogic();
            //查找广告
            $start_time = strtotime(date('Y-m-d H:00:00'));
            $end_time = strtotime(date('Y-m-d H:00:00'));
            $adv = M("ad")->field(array('ad_link','ad_name','ad_code','media_type,pid'))->where("pid=533 AND enabled=1 and start_time< $start_time and end_time > $end_time")->find();
            if($adv && $adv['media_type'] == 4){//如果是分类, 截取最后一个分类
                    $cats = explode('_',$adv['ad_link']);
                    $count = count($cats);
                    if($count != 0){
                        $adv['ad_link'] = $cats[$count-1];
                    }
             }
        
            $result['ad'] = empty($adv) ? "" : $adv ;
            $result['hot_list'] = $goodsLogic->getBrandGoods(12);
        }

        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $result]);
    }

    /**
     * 获取区域地址列表，region_id=0是获取所有省份
     */
    public function get_region()
    {
        $parent_id = I('get.parent_id/d', 0);
        $data = M('region')->field('id,name')->where("parent_id", $parent_id)->select();
        $this->ajaxReturn(['status' => 1, 'msg' => '获取成功', 'result' => $data]);
    }
    
    //app端首页数据
    //@wroteby jackcsm
    public function app_home(\app\common\logic\Teacomment $tea)
    {
        $ad = M("ad")->where("pid",1)->select();
        $sort = "score";
        //人气茶艺师列表
        $list = M("tea_art")->order("add_time")->where("teart_state",2)->select();
       
        $teartId = [];
        foreach ($list as $k=>$v){
            
            $teartId[] = $v['teart_id'];
        }
        if($sort=='score'){
            //获取评综合评分
            $star = $tea->getcomment($teartId);
            $subscribe = $this->subscribe_teart($teartId);
            foreach ($list as $k=>$v){
                $list[$k]['star'] = $star[$v['teart_id']];
                $list[$k]['subscribe'] = $subscribe[$v['teart_id']];
                
             
            }
            $ret = [];
            foreach ($list as $k=>$v){
                $ret[$k.'a'] = $v;
            }
            //评分由高到低
            $ret = array_sort($ret,'star','desc');
            $TeaArt = [];
            foreach ($ret as $k=>$v){
                $TeaArt['list'][] = $v;
            }
        }
        
        //人气茶馆

        $sort_tea = I('sort','score');
         
        $user_location = I('location');
        
        $shoplist = \think\Db::name("store_entry")->field("store_id")->select();
        $store_id = [];
        foreach ($shoplist as $k=>$v){
            $store_id[] = $v['store_id'];
        }
        //print_r($store_id);
        //获取茶馆　　默认按评分来处理
        $store_list = M('Store')->alias("s")
                            ->field('
                            s.store_name,
                            s.store_zy,
                            s.store_id,
                            s.store_desccredit,
                            s.store_servicecredit,
                            s.store_deliverycredit,
                            s.longitude,
                            s.latitude,
                            s.store_slide,
                            s.mb_slide,
                            s.store_address,
                            se.shop_address,
                            se.shop_longitude,
                            se.shop_latitude
                            ')
                            ->join("__STORE_ENTRY__ se","s.store_id=se.store_id","LEFT")
                            ->whereIn("s.store_id",$store_id)
                            ->where("s.store_state",1)  //开启中的店铺
                            ->where("deleted",0)
                            ->fetchSql(false)
                            ->select();
 
        if($sort_tea=='score'){
            foreach ($store_list as $k=>$v){
                 
                $temp = round(($v['store_desccredit']+$v['store_servicecredit']+$v['store_deliverycredit'])/3,1);
                 
                $store_list[$k]['score'] = $temp;
                
                
            }
            $store = [];
            $location = [];
            foreach ($store_list as $k=>$v){
                $location[$v['store_id']] = [
                    'longitude'=>($v['shop_longitude']?$v['shop_longitude']:$v['longitude']),
                    'latitude'=>($v['shop_latitude']?$v['shop_latitude']:$v['latitude']),
                ];
            }
            //用户没有登录的话无法计算距离的
            $distance = $this->getstoredistance($location);
            foreach ($store_list as $k=>$v){
                $temp = explode(",", $v['mb_slide']);
                $store_list[$k]['store_bglist'] = $temp;
                
                $store_list[$k]['distance'] = is_null($distance)?'0':$distance[$v['store_id']];
            }
            foreach ($store_list as $k=>$v){
                $store[$k.'a'] =$v;
            }
            
            $storeList = [];
            foreach ($store as $k=>$v){
                $storeList['list'][] = $v;
            }
        }
        $store = array_sort($store,'score','desc');
        $json = ['status' => 1, 'msg' => '获取成功', 'result' => ['ad'=>$ad,'tea_art'=>$TeaArt,'store'=>$storeList]];
        $this->ajaxReturn($json);
    }
    //获取当前用户距离茶馆的距离　　如果用户不登录则为0
    private function getstoredistance($location)
    {
        $longitude = I("longitude");
        $latitude  = I("latitude");
        //未登录时
        if(Isempty([$latitude,$longitude])){
            return null;
        }
        $dis = '';
        foreach ($location as $k=>$v){
            if($v['longitude']&&$v['latitude']){
    
                $temp = caldistance($longitude, $latitude, $v['longitude'], $v['latitude']);
                $dis[$k] = $temp['results'][0]['distance']?:0;
            }else{
                $dis[$k] = 0;
            }
    
        }
        return $dis;
    }
    
    //判断当前用户是否关注这些茶艺师
    private function subscribe_teart($teartId)
    {
        if(empty($this->user_id))return false;
        /* 
        $list = \think\Db::name("teart_collect")->where(function($query)use($teartId){
            $query->whereIn("teart_id",$teartId);
        })->select();
        
        $sub = [];
        foreach ($list as $k=>$v){
            if($this->user_id==$v['user_id']){
                $sub[$v['user_id'].$v['teart_id']] = '1';
            }else{
                $sub[$v['user_id'].$v['teart_id']] = '2';
            }
        }
        return $sub;
        */
        $list = \think\Db::name("teart_collect")->whereIn("user_id",$this->user_id)->select();
        
        $sub = [];
        foreach ($list as $k=>$v){
            $sub[$v['teart_id']] = "1";
        }
        return $sub;
    }
}