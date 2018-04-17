<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 商业用途务必到官方购买正版授权, 使用盗版将严厉追究您的法律责任。
 * ============================================================================
 * $Author: 当燃 2016-01-09
 */ 
namespace app\mobile\controller;
use app\common\logic\JssdkLogic;
use app\common\logic\StoreLogic;
use Think\Db;
class Index extends MobileBase {

    public function test(){
        
        echo " name : ".MODULE_NAME;
        
    }
    public function index(){
        $hot_goods = M('goods')->where("is_hot=1 and is_on_sale=1")->order('goods_id DESC')->limit(20)->cache(true,TPSHOP_CACHE_TIME)->select();//首页热卖商品
        $thems = M('goods_category')->where('level=1')->order('sort_order')->limit(9)->cache(true,TPSHOP_CACHE_TIME)->select();
        $this->assign('thems',$thems);
        $this->assign('hot_goods',$hot_goods);
        $favourite_goods = M('goods')->where("is_recommend=1 and is_on_sale=1 and goods_state=1")->order('sort DESC')->limit(20)->cache(true,TPSHOP_CACHE_TIME)->select();//首页推荐商品
        //秒杀商品
        $now_time = time();  //当前时间
        if(is_int($now_time/7200)){      //双整点时间，如：10:00, 12:00
            $start_time = $now_time;
        }else{
            $start_time = floor($now_time/7200)*7200; //取得前一个双整点时间
        }
        $start_time = time();
        $end_time = $start_time+7200;   //结束时间
        $flash_sale_list = M('goods')->alias('g')
            ->field('g.goods_id,g.shop_price,f.price,s.item_id')
            ->join('__FLASH_SALE__ f','g.goods_id = f.goods_id','LEFT')
            ->join('__SPEC_GOODS_PRICE__ s','s.prom_id = f.id AND g.goods_id = s.goods_id','LEFT')
            ->where('f.status', 1)
            ->where("f.start_time <$start_time and f.end_time < $start_time and f.recommend=1")
            ->limit(6)->select();
        // echo  M('goods')->getLastsql();die;
        $this->assign('flash_sale_list',$flash_sale_list);
        $this->assign('start_time',$start_time);
        $this->assign('end_time',$end_time);
        $this->assign('favourite_goods',$favourite_goods);
        return $this->fetch();
    }

    /**
     * 分类列表显示
     */
    public function categoryList(){
        return $this->fetch();
    }

    /**
     * 模板列表
     */
    public function mobanlist(){
        $arr = glob("D:/wamp/www/svn_tpshop/mobile--html/*.html");
        foreach($arr as $key => $val)
        {
            $html = end(explode('/', $val));
            echo "<a href='http://www.php.com/svn_tpshop/mobile--html/{$html}' target='_blank'>{$html}</a> <br/>";            
        }        
    }
    
    /**
     * 商品列表页
     */
    public function goodsList(){
        $id = I('get.id/d',0); // 当前分类id
        $lists = getCatGrandson($id);
        $this->assign('lists',$lists);
        return $this->fetch();
    }
    
    public function ajaxGetMore(){
    	$p = I('p/d',1);
        $where = ['is_recommend'=>1,'is_on_sale'=>1,'goods_state'=>1,'virtual_indate'=>['exp',' = 0 OR virtual_indate > '.time()]];
    	$favourite_goods = Db::name('goods')->where($where)->order('sort DESC,goods_id DESC')->page($p,10)->cache(true,TPSHOP_CACHE_TIME)->select();//首页推荐商品
    	$this->assign('favourite_goods',$favourite_goods);
    	echo $this->fetch();
    }

    /**
     * 店铺街
     * @author dyr
     * @time 2016/08/15
     */
    public function street()
    {
        $store_class = M('store_class')->select();
        $this->assign('store_class', $store_class);//店铺分类
        return $this->fetch();
    }

    /**
     * ajax 获取店铺街
     */
    public function ajaxStreetList()
    {
        $p = I('p',1); //页数
        $sc_id = I('sc_id/d',0); //店铺分类ID
        $province_id = I('province_id'); //省 id
        $city_id = I('city_id'); //市 id
        $district_id = I('district_id'); //区 id
        $order = I('order', 0); //
        $all = I('all', 0); //所有
        $user_id = cookie('user_id') ? cookie('user_id'):0; //用户 id
        //如果 省 id  市 id  区 id 都是空的
        if (empty($province_id) && empty($city_id) && empty($district_id) && $all != 1) {
            $province_id = cookie('province_id');
            $city_id =  cookie('city_id');
            $district_id =  cookie('district_id');
        }
        //地区ID,目前搜索时只精确到市
        $address=['province_id'=>$province_id, 'city_id'=>$city_id, 'district_id'=>$district_id];
        $storeLogic = new StoreLogic();
        $store_list = $storeLogic->getStreetList2($sc_id,$p,10, $order, $user_id,$address);
        foreach($store_list as $key=>$value){
            $store_list[$key]['goods_array'] = $storeLogic->getStoreGoods($value['store_id'],3);
        }
        $this->assign('province_id', $province_id); //省 id
        $this->assign('city_id', $city_id);         //市 id
        $this->assign('district_id', $district_id); //区 id
        $this->assign('store_list',$store_list);    //店铺信息
        echo $this->fetch();      
    }

    public function ajaxStreetList2()
    {
        $p = I('p',1); //页数
        $sc_id = I('sc_id/d',0); //店铺分类ID
        $order = I('order', 0); //
        $all = I('all', 0); //所有
        $user_id = cookie('user_id') ? cookie('user_id'):0; //用户 id
        $storeLogic = new StoreLogic();
        $store_list = $storeLogic->getStreetList2($sc_id,$p,10, $order, $user_id,$address);
        foreach($store_list as $key=>$value){
            $store_list[$key]['goods_array'] = $storeLogic->getStoreGoods($value['store_id'],3);
        }
        $this->assign('province_id', $province_id); //省 id
        $this->assign('city_id', $city_id);         //市 id
        $this->assign('district_id', $district_id); //区 id
        $this->assign('store_list',$store_list);    //店铺信息
        echo $this->fetch('ajaxStreetList');      
    }

    /**
     * 品牌街
     * @author dyr
     * @time 2016/08/15
     */
    public function brand()
    {
        $brand_where['status'] = 0;
        $brand_where['is_hot'] = 1;
        $goods = M('goods')->field('goods_id,shop_price,market_price')->where(['is_on_sale'=> 1,'is_recommend'=>1])->limit(3)->order('sort desc')->select();
        $brand_list = M('brand')->field('id,name,logo,url')->order(array('sort'=>'desc'))->cache(true)->where($brand_where)->select();
        for($i=0;$i<3;$i++)
        {
           $Goods_group[]= array_slice($goods, $i * 3 ,3);//每三个一组，取三组
            if(!empty($Goods_group[$i])){ //去掉空的
                $recommendGoods=$Goods_group;
            }
        }
        $this->assign('brand_list', $brand_list);//品牌列表
        $this->assign('recommendGoods', $recommendGoods);//品牌列表
        return $this->fetch();
    }
    
    //微信Jssdk 操作类 用分享朋友圈 JS
    public function ajaxGetWxConfig(){
    	$askUrl = I('askUrl');//分享URL
    	$weixin_config = M('wx_user')->find(); //获取微信配置
    	$jssdk = new JssdkLogic($weixin_config['appid'], $weixin_config['appsecret']);
    	$signPackage = $jssdk->GetSignPackage(urldecode($askUrl));
    	if($signPackage){
    		$this->ajaxReturn($signPackage,'JSON');
    	}else{
    		return false;
    	}
    }
}