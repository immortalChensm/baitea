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
namespace app\home\controller;
 
use think\Verify;
use think\Db;
use app\common\logic\StoreLogic;
use think\Cookie;
use think\Image;

class Index extends Base
{
    public function index()
    {        
//         $cateList = array();
//         foreach ($this->cateTrre as $k => $v) {
//         	$cat_path = explode('_', $v['parent_id_path']);
//         	$v['hot_goods'] = M('goods')->field('goods_id,goods_name,shop_price')->where(array('cat_id1'=>$cat_path[1],'is_on_sale'=>1,'is_hot'=>1))->order('sort')->limit(10)->cache(true)->select();  
//             if($v['is_hot']){
//             	$cateList[] = $v;
//             }
//         }

        $web_list = S('web_index_data');
        if(!$web_list){
        	$web_list = M('web')->where(array('web_show'=>1))->order('web_sort')->select();
        	if($web_list){
        		foreach ($web_list as $kb=>$vb){
        			$block_list =  M('web_block')->where(array('web_id'=>$vb['web_id']))->order('web_id')->select();
        			if(is_array($block_list) && !empty($block_list)) {
        				foreach ($block_list as $key => $val) {//将变量输出到页面
        					$val['block_info'] = unserialize($val['block_info']);
        					$web_list[$kb][$val['var_name']] = $val['block_info'];
        				}
        			}
        		}
        		S('web_index_data',$web_list);
        	}
        }
        $this->assign('web_list', $web_list);
        return $this->fetch();
    }

    /**
     *  公告详情页
     */
    public function notice()
    {
        return $this->fetch();
    }
    
    public function qr_code_raw()
    {
        ob_end_clean();
        // 导入Vendor类库包 Library/Vendor/Zend/Server.class.php
        //http://www.tp-shop.cn/Home/Index/erweima/data/www.99soubao.com
        vendor('phpqrcode.phpqrcode');
        //import('Vendor.phpqrcode.phpqrcode');
        error_reporting(E_ERROR);
        $url = urldecode($_GET["data"]);
        \QRcode::png($url);
        exit;
    }
    
    // 二维码
    public function qr_code()
    {
        
        ob_end_clean();
        vendor('topthink.think-image.src.Image');
        vendor('phpqrcode.phpqrcode');

        error_reporting(E_ERROR);
        $url = isset($_GET['data']) ? $_GET['data'] : '';
        $url = urldecode($url);
        $head_pic = input('get.head_pic', '');
        $back_img = input('get.back_img', '');
        $valid_date = input('get.valid_date', 0);
        
        $qr_code_path = './public/upload/qr_code/';
        if (!file_exists($qr_code_path)) {
            mkdir($qr_code_path);
        }
        
        /* 生成二维码 */
        $qr_code_file = $qr_code_path.time().rand(1, 10000).'.png';
        \QRcode::png($url, $qr_code_file, QR_ECLEVEL_M);
        
        /* 二维码叠加水印 */
        $QR = Image::open($qr_code_file);
        $QR_width = $QR->width();
        $QR_height = $QR->height();

        /* 添加背景图 */
        if ($back_img && file_exists($back_img)) {
            $back =Image::open($back_img);
            $back->thumb($QR_width, $QR_height, \think\Image::THUMB_CENTER)
             ->water($qr_code_file, \think\Image::WATER_NORTHWEST, 60);//->save($qr_code_file);
            $QR = $back;
        }
        
        /* 添加头像 */
        if ($head_pic) {
            //如果是网络头像
            if (strpos($head_pic, 'http') === 0) {
                //下载头像
                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL, $head_pic); 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                $file_content = curl_exec($ch);
                curl_close($ch);
                //保存头像
                if ($file_content) {
                    $head_pic_path = $qr_code_path.time().rand(1, 10000).'.png';
                    file_put_contents($head_pic_path, $file_content);
                    $head_pic = $head_pic_path;
                }
            }
            //如果是本地头像
            if (file_exists($head_pic)) {
                $logo = Image::open($head_pic);
                $logo_width = $logo->height();
                $logo_height = $logo->width();
                $logo_qr_width = $QR_width / 5;
                $scale = $logo_width / $logo_qr_width;
                $logo_qr_height = $logo_height / $scale;
                $logo_file = $qr_code_path.time().rand(1, 10000);
                $logo->thumb($logo_qr_width, $logo_qr_height)->save($logo_file, null, 100);
                $QR = $QR->thumb($QR_width, $QR_height)->water($logo_file, \think\Image::WATER_CENTER);     
                unlink($logo_file);
            }
            if ($head_pic_path) {
                unlink($head_pic_path);
            }
        }
        
        if ($valid_date && strpos($url, 'weixin.qq.com') !== false) {
            $QR = $QR->text('有效时间 '.$valid_date, "./vendor/topthink/think-captcha/assets/zhttfs/1.ttf", 7, '#00000000', Image::WATER_SOUTH);
        }
        $QR->save($qr_code_file, null, 100);
        
        $qrHandle = imagecreatefromstring(file_get_contents($qr_code_file));
        unlink($qr_code_file); //删除二维码文件
        header("Content-type: image/png");
        imagepng($qrHandle);
        imagedestroy($qrHandle);
        exit;
    }

    // 验证码
    public function verify()
    {
        //验证码类型
        $type = I('get.type') ? I('get.type') : '';
        $fontSize = I('get.fontSize') ? I('get.fontSize') : '40';
        $length = I('get.length') ? I('get.length') : '4';

        $config = array(
            'fontSize' => $fontSize,
            'length' => $length,
            'useCurve' => true,
            'useNoise' => false,
        );
        $Verify = new Verify($config);
        $Verify->entry($type);
		exit();
    }


    /**
     * 店铺街
     * @author dyr
     * @time 2016/08/26
     */
    public function street()
    {
        $sc_id = I('get.sc_id/d');
        $province = I('get.province', 0);
        $city = I('get.city', 0);
        $order = I('order', 0);
        $area = I('area');
        if (empty($province) && empty($city) && $area != 'all') {
            $province = Cookie::get('province_id');
            $city =  Cookie::get('city_id');
            $location_array = array('province' => $province, 'city' => $city);
            if(!empty($sc_id)){
                $location_array['sc_id'] = $sc_id;
            }
            $location = U('street', $location_array);
            $this->redirect($location);// 根据城市来帅选
        }
        $store_class = M('store_class')->cache(true)->field('sc_id,sc_name')->where('')->select();
        $store_logic = new StoreLogic();
        $store_list = $store_logic->getStoreList($sc_id, $province, $city, $order, 10);
        $region = M('region')->cache(true)->where("`level` = 1")->getField("id,name");
        $this->assign('province', $province);
        $this->assign('city', $city);
        $this->assign('region', $region);
        $this->assign('page', $store_list['show']);// 赋值分页输出
        $this->assign('pages', $store_list['pages']);
        $this->assign('store_list', $store_list['result']);
        $this->assign('store_class', $store_class);//店铺分类
        return $this->fetch();
    }

    public function store_qrcode()
    {
        require_once 'vendor/phpqrcode/phpqrcode.php';

        error_reporting(E_ERROR);
        $store_id = I('store_id/d', 1);
        \QRcode::png(U('Mobile/Store/index', array('store_id' => $store_id), true, true));
    }

    /**
     * 使用步骤:
     * 1.将该函数的注释放开
     * 2.浏览器请求该函数, 将打印输出的SQL语句在MYSQL中执行即可清理数据
     *    以下变量: $database 是你的数据库名 
     * 3.执行完成之后将该函数注释起来
     * 注意: 如果执行该函数, 没有输出表名, 请检查你的数据库名是否正确
     * 访问形式  www.xxx.com/home/index/truncate_tables
     */
    function truncate_tables()
    {
        /*
        $tables = DB::query("show tables");
        $database = "tpshopbbc2.0";   //这里改成你的数据库名
        $k_name = "Tables_in_$database";
        $table = array('tp_admin','tp_config','tp_region','tp_system_module','tp_admin_role','tp_system_menu','tp_article_cat','tp_wx_user');        
        foreach ($tables as $key => $val) {
           if(!in_array($val[$k_name], $table)){
               echo 'truncate table'.$val[$k_name].";";
               echo "<br/>";         
           }
        }       
         */
    } 

    /**
     * 猜你喜欢
     * @author dyr
     */
    public function ajax_favorite()
    {
        $p = I('p', 0);
        $item = I('i', 5);//分页数
        $tpl = I('tpl');
        $goods_where = ['g.is_recommend' => 1, 'g.is_on_sale' => 1, 'g.goods_state' => 1,'g.virtual_indate'=>['exp',' = 0 OR g.virtual_indate > '.time()]];
        $favourite_goods = M('goods')->alias('g')->join('__STORE__ s' ,'g.store_id = s.store_id')
            ->field('g.*,s.store_name')
            ->where($goods_where)
            ->order('sort DESC')
            ->page($p, $item)
            ->cache(true, TPSHOP_CACHE_TIME)
            ->select();
        $this->assign('favourite_goods', $favourite_goods);
        if ($tpl) {
            return $this->fetch($tpl);
        } else {
            return $this->fetch();
        }
    }

}