<?php
/**
 * tpshop
 * ============================================================================
 * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * 如果商业用途务必到官方购买正版授权, 以免引起不必要的法律纠纷.
 * ============================================================================
 * Author: IT宇宙人
 * Date: 2015-09-09
 */

namespace app\common\logic;

use think\Model;
use think\Page;
use think\Db;

/**
 * 分类逻辑定义
 * Class CatsLogic
 * @package common\Logic
 */
class UsersLogic extends Model
{
    /**
     * 登陆
     * @param $username
     * @param $password
     * @return array
     */
    public function login($username, $password)
    {
        if (!$username || !$password)
            return array('status' => 0, 'msg' => '请填写账号或密码');
        $user = Db::name('users')->where("mobile='{$username}' OR email='{$username}'")->find();
        if (!$user) {
            $result = array('status' => -1, 'msg' => '账号不存在!');
        } elseif (encrypt($password) != $user['password']) {
            $result = array('status' => -2, 'msg' => '密码错误!');
        } elseif ($user['is_lock'] == 1) {
            $result = array('status' => -3, 'msg' => '账号异常已被锁定！！！');
        } else {
            //查询用户信息之后, 查询用户的登记昵称
            $levelId = $user['level'];
            $levelName = M("user_level")->cache(true)->where("level_id = {$levelId}")->getField("level_name");
            $user['level_name'] = $levelName;
            //Db::name('users')->where(array('user_id'=>$user['user_id']))->save(array('last_login'=>time()));
            Db::execute("update __PREFIX__users set last_login='" . time() . "' where user_id=" . $user['user_id'] . " limit 1");
            $result = array('status' => 1, 'msg' => '登陆成功', 'result' => $user);
        }
        return $result;
    }

    /**
     * app端登陆
     * @param $username
     * @param $password
     * @param $capache
     * @param int $push_id
     * @return array
     */
    public function app_login($username, $password, $capache, $push_id = 0)
    {
        if (!$username || !$password)
            return array('status' => 0, 'msg' => '请填写账号或密码');
        $user = Db::name('users')->where("mobile='{$username}' OR email='{$username}'")->find();
        if (!$user) {
            $result = array('status' => -1, 'msg' => '账号不存在!');
        } elseif (encrypt($password) != $user['password']) {
            $result = array('status' => -2, 'msg' => '密码错误!');
        } elseif ($user['is_lock'] == 1) {
            $result = array('status' => -3, 'msg' => '账号异常已被锁定！！！');
        } /* elseif (!capache([], SESSION_ID, $capache)) {
            $result = array('status'=>-4,'msg'=>'图形验证码错误！');
        } */ else {
            //查询用户信息之后, 查询用户的登记昵称
            $levelId = $user['level'];
            $levelName = M("user_level")->where("level_id = {$levelId}")->getField("level_name");
            $user['level_name'] = $levelName;
            $user['token'] = md5(time() . mt_rand(1, 999999999));
            $data = ['token' => $user['token'], 'last_login' => time()];
            $push_id && $data['push_id'] = $push_id;
            Db::name('users')->where("user_id", $user['user_id'])->save($data);
            $result = array('status' => 1, 'msg' => '登陆成功', 'result' => $user);
        }
        return $result;
    }

    /*
     * app端登出
     */
    public function app_logout($token = '')
    {
        if (empty($token)) {
            ajaxReturn(['status' => -100, 'msg' => '已经退出账户']);
        }

        $user = Db::name('users')->where("token", $token)->find();
        if (empty($user)) {
            ajaxReturn(['status' => -101, 'msg' => '用户不在登录状态']);
        }

        Db::name('users')->where(["user_id" => $user['user_id']])->save(['last_login' => 0, 'token' => '']);
        session(null);

        return ['status' => 1, 'msg' => '退出账户成功'];;
    }

    //绑定账号
    public function oauth_bind($data = array())
    {
        $user = session('user');
        if (empty($data['oauth_child'])) {
            $data['oauth_child'] = '';
        }

        if (empty($data['unionid'])) {
            $column = 'openid';
            $open_or_unionid = $data['openid'];
        } else {
            $column = 'unionid';
            $open_or_unionid = $data['unionid'];
        }

        if (empty($user['openid'])) {
            $ouser = Db::name('Users')->alias('u')->field('u.user_id,o.tu_id')->join('OauthUsers o', 'u.user_id = o.user_id')->where(['oauth' => $data['oauth'], $column => $open_or_unionid])->find();
            if ($ouser) {
                //删除原来绑定
                Db::name('OauthUsers')->where('tu_id', $ouser['tu_id'])->delete();
            }
            //绑定账号
            return Db::name('OauthUsers')->save(array('oauth' => $data['oauth'], 'openid' => $data['openid'], 'user_id' => $user['user_id'], 'unionid' => $data['unionid'], 'oauth_child' => $data['oauth_child']));

        }
        return false;
    }

    /**
     * * 绑定账号
     * @param  $user
     * @return array multitype:number string |multitype:number string unknown
     */
    public function oauth_bind_new($user = array())
    {

        $thirdOauth = session('third_oauth');

        $thirdName = ['weixin' => '微信', 'qq' => 'QQ', 'alipay' => '支付宝', 'miniapp' => '微信小程序'];

        //1.检查账号密码是否正确
        $ruser = Db::name('Users')->where(array('mobile' => $user['mobile']))->find();
        if (empty($ruser)) {
            return array('status' => -1, 'msg' => '账号不存在', 'result' => '');
        }

        if ($ruser['password'] != $user['password']) {
            return array('status' => -1, 'msg' => '账号或密码错误', 'result' => '');
        }

        //2.检查第三方信息是否完整
        $openid = $thirdOauth['openid'];   //第三方返回唯一标识
        $unionid = $thirdOauth['unionid'];   //第三方返回唯一标识
        $oauth = $thirdOauth['oauth'];      //来源
        $oauthCN = $platform = $thirdName[$oauth];
        if ((empty($unionid) || empty($openid)) && empty($oauth)) {
            return array('status' => -1, 'msg' => '第三方平台参数有误[openid:' . $openid . ' , unionid:' . $unionid . ', oauth:' . $oauth . ']', 'result' => '');
        }

        //3.检查当前当前账号是否绑定过开放平台账号
        //1.判断一个账号绑定多个QQ
        //2.判断一个QQ绑定多个账号
        if ($unionid) {
            //如果有 unionid

            //1.1此oauth是否已经绑定过其他账号
            $thirdUser = Db::name('OauthUsers')->where(['unionid' => $unionid, 'oauth' => $oauth])->find();
            if ($thirdUser && $ruser['user_id'] != $thirdUser['user_id']) {
                return array('status' => -1, 'msg' => '此' . $oauthCN . '已绑定其它账号', 'result' => '');
            }

            //1.2此账号是否已经绑定过其他oauth
            $thirdUser = Db::name('OauthUsers')->where(['user_id' => $ruser['user_id'], 'oauth' => $oauth])->find();
            if ($thirdUser && $thirdUser['unionid'] != $unionid) {
                return array('status' => -1, 'msg' => '此' . $oauthCN . '已绑定其它账号', 'result' => '');
            }

        } else {
            //如果没有unionid

            //2.1此oauth是否已经绑定过其他账号
            $thirdUser = Db::name('OauthUsers')->where(['openid' => $openid, 'oauth' => $oauth])->find();
            if ($thirdUser) {
                return array('status' => -1, 'msg' => '此' . $oauthCN . '已绑定其它账号', 'result' => '');
            }

            //2.2此账号是否已经绑定过其他oauth
            $thirdUser = Db::name('OauthUsers')->where(['user_id' => $ruser['user_id'], 'oauth' => $oauth])->find();
            if ($thirdUser) {
                return array('status' => -1, 'msg' => '此账号已绑定其它' . $oauthCN . '账号', 'result' => '');
            }
        }

        if (!isset($thirdOauth['oauth_child'])) {
            $thirdOauth['oauth_child'] = '';
        }
        //4.账号绑定
        Db::name('OauthUsers')->save(array('oauth' => $oauth, 'openid' => $openid, 'user_id' => $ruser['user_id'], 'unionid' => $unionid, 'oauth_child' => $thirdOauth['oauth_child']));
        $ruser['token'] = md5(time() . mt_rand(1, 999999999));
        $ruser['last_login'] = time();

        Db::name('Users')->where('user_id', $ruser['user_id'])->save(array('token' => $ruser['token'], 'last_login' => $ruser['last_login']));
        return array('status' => 1, 'msg' => '绑定成功', 'result' => $ruser);

    }

    public function checkLoginForSaas($device)
    {
        $return = ['status' => 1, 'msg' => '检查成功'];
        if (IS_SAAS) {
            switch ($device) {
                case 'miniapp':
                    if (empty($GLOBALS['SAAS_CONFIG']['miniapp_enable'])) {
                        $return = ['status' => -1, 'msg' => '小程序版已过期'];
                    }
                    break;
                case 'android' && empty($GLOBALS['SAAS_CONFIG']['android_enable']):
                    if (empty($GLOBALS['SAAS_CONFIG']['android_enable'])) {
                        $return = ['status' => -1, 'msg' => '安卓版已过期'];
                    }
                    break;
                case 'ios' && empty($GLOBALS['SAAS_CONFIG']['ios_enable']):
                    if (empty($GLOBALS['SAAS_CONFIG']['android_enable'])) {
                        $return = ['status' => -1, 'msg' => '苹果版已过期'];
                    }
                    break;
                default:
                    $return = ['status' => -1, 'msg' => '接口没访问权限'];
            }
        }
        return $return;
    }

    /**
     * 第三方登录: (第一种方式:第三方账号直接创建账号, 不需要额外绑定账号)
     * @param array $data
     * @return array
     */
    public function thirdLogin($data = array())
    {
        $openid = $data['openid']; //第三方返回唯一标识
        $oauth = $data['oauth']; //来源
        $unionid = $data['unionid']; //$unionid
        if (!$openid || !$oauth)
            return array('status' => -1, 'msg' => '参数有误', 'result' => '');
        //获取用户信息
        if(!empty($data['unionid'])){
            $map['unionid'] = $data['unionid'];
            $user = get_user_info($data['unionid'],4,$oauth);
        }
        if (empty($user)) {
            $user = get_user_info($openid,3,$oauth);
        }
        $user2 = session('user');
        if (!empty($user2)) {
            $r = $this->oauth_bind($data);//绑定账号
            if ($r) {
                return array('status' => 1, 'msg' => '绑定成功', 'result' => $user2);
            } else {
                return array('status' => -1, 'msg' => '您的' . $data['oauth'] . '账号已经绑定过账号', 'bind_status' => 0);
            }
        }
        $data['push_id'] && $map['push_id'] = $data['push_id'];
        $map['token'] = md5(time() . mt_rand(1, 999999999));
        $map['last_login'] = time();
        if (!$user) {
            //账户不存在 注册一个
            $map['password'] = '';
            $map['openid'] = $openid;
            $map['nickname'] = $data['nickname'];
            $map['reg_time'] = time();
            $map['oauth'] = $oauth;
            $map['head_pic'] = $data['head_pic'];
            $map['sex'] = $data['sex'] === null ? 0 : $data['sex'];
            $map['first_leader'] = cookie('first_leader'); // 推荐人id
            if ($_GET['first_leader'])
                $map['first_leader'] = $_GET['first_leader']; // 微信授权登录返回时 get 带着参数的

            // 如果找到他老爸还要找他爷爷他祖父等
            if ($map['first_leader']) {
                $first_leader = Db::name('users')->where("user_id = {$map['first_leader']}")->find();
                $map['second_leader'] = $first_leader['first_leader']; //  第一级推荐人
                $map['third_leader'] = $first_leader['second_leader']; // 第二级推荐人
                //他上线分销的下线人数要加1
                Db::name('users')->where(array('user_id' => $map['first_leader']))->setInc('underling_number');
                Db::name('users')->where(array('user_id' => $map['second_leader']))->setInc('underling_number');
                Db::name('users')->where(array('user_id' => $map['third_leader']))->setInc('underling_number');
            } else {
                $map['first_leader'] = 0;
            }
            // 成为分销商条件
            //$distribut_condition = tpCache('distribut.condition');
            //if($distribut_condition == 0)  // 直接成为分销商, 每个人都可以做分销
            $map['is_distribut'] = 1;
            $row_id = Db::name('users')->add($map);
            $user = Db::name('users')->where(array('user_id' => $row_id))->find();

            if (!isset($data['oauth_child'])) {
                $data['oauth_child'] = '';
            }

            //不存在则创建个第三方账号
            Db::name('OauthUsers')->save(array('oauth' => $oauth, 'openid' => $openid, 'user_id' => $user['user_id'], 'unionid' => $unionid, 'oauth_child' => $data['oauth_child']));

        } else {
            Db::name('users')->where("user_id = '{$user['user_id']}'")->save($map);
            $user['token'] = $map['token'];
            $user['last_login'] = $map['last_login'];
        }

        return array('status' => 1, 'msg' => '登陆成功', 'result' => $user);
    }

    /**
     * 第三方登录(第二种方式:第三方账号登录必须绑定账号)
     * @param array $data
     * @return array
     */
    public function thirdLogin_new($data = array())
    {
        $openid = $data['openid']; //第三方返回唯一标识
        $oauth = $data['oauth']; //来源
        if (!$openid || !$oauth) {
            return array('status' => -1, 'msg' => '第三方平台参数有误', 'result' => '');
        }
        //获取用户信息
        if ($data['unionid']) {
            $user = get_user_info($data['unionid'], 4, $oauth);
        } else {
            $user = get_user_info($openid, 3, $oauth);
        }

        if (!$user) {
            return array('status' => -1, 'msg' => '用户不存在', 'result' => $data);
        }

        $data['push_id'] && $map['push_id'] = $data['push_id'];

        $map['token'] = md5(time() . mt_rand(1, 999999999));
        $map['last_login'] = time();

        Db::name('users')->where(array('user_id' => $user['user_id']))->save($map);
        //重新加载一次用户信息
        $user = Db::name('users')->where(array('user_id' => $user['user_id']))->find();

        return array('status' => 1, 'msg' => '登陆成功', 'result' => $user);
    }

    /**
     * 注册
     * @param $username  邮箱或手机
     * @param $password  密码
     * @param $password2 确认密码
     * @param int $push_id
     * @param string $nickname
     * @param string $head_pic
     * @param string $invite_code 邀请码
     * @return array
     */
    public function reg($username, $password, $password2, $push_id = 0, $invite_code='',$nickname = "", $head_pic = "")
    {
        $is_validated = 0;
        /*if (check_email($username)) {
            $is_validated = 1;
            $map['email_validated'] = 1;
            $map['nickname'] = $map['email'] = $username; //邮箱注册
        }*/
        

        if (check_mobile($username)) {
            $is_validated = 1;
            $map['mobile_validated'] = 1;
            $map['nickname'] = $map['mobile'] = $username; //手机注册
        }

        if (!empty($nickname)) {
            $map['nickname'] = $nickname;
        }

        if (!empty($head_pic)) {
            $map['head_pic'] = $head_pic;
        }

        if ($is_validated != 1)
            return array('status' => -1, 'msg' => '请用手机号注册', 'result' => '');

        if (!$username || !$password)
            return array('status' => -1, 'msg' => '请输入用户名或密码', 'result' => '');

        //验证两次密码是否匹配
        if ($password2 != $password)
            return array('status' => -1, 'msg' => '两次输入密码不一致', 'result' => '');
        //验证是否存在用户名
        if (get_user_info($username, 1) || get_user_info($username, 2))
            return array('status' => -1, 'msg' => '账号已存在', 'result' => '');

        $map['password'] = encrypt($password);
        $map['reg_time'] = time();

        //邀请码
        if(!empty($invite_code)){
            //验证填写的邀请码是否存在
            $ret = Db::name("Users")->where("my_code",$invite_code)->getField("my_code");
            if($ret){
                $map['invite_code'] = $invite_code;
            }else{
                return array('status' => -1, 'msg' => '填写的邀请码不存在');
            }
        
        }
        
        
        if(!empty($invite_code)){
            $invite_user = Db::name("users")->where('my_code',$invite_code)->find();
        }else{
            $invite_user['user_id'] = 0;
        }
       
        
        //$map['first_leader'] = cookie('first_leader');  //推荐人id
        $map['first_leader'] = $invite_user['user_id'];
        // 如果找到他老爸还要找他爷爷他祖父等
        if ($map['first_leader']) {
            $first_leader = Db::name('users')->where("user_id = {$map['first_leader']}")->find();
            $map['second_leader'] = $first_leader['first_leader'];
            $map['third_leader'] = $first_leader['second_leader'];
            //他上线分销的下线人数要加1
            Db::name('users')->where(array('user_id' => $map['first_leader']))->setInc('underling_number');
            Db::name('users')->where(array('user_id' => $map['second_leader']))->setInc('underling_number');
            Db::name('users')->where(array('user_id' => $map['third_leader']))->setInc('underling_number');
        } else {
            $map['first_leader'] = 0;
        }

        /***分销机制分析　@jackCsm
         * 1、第一次注册的时候，当填写了邀请码后获取邀请人的user_id first_leader second_leader 的user_id
         * 2、此时第一个人的下线累加，如果第一个的first_leader有上个人的user_id也要增加，second_leader也要增加
         * 
         * ３、运行一次获取的数据大致如下[假设传递过来的user_id=3]
         * user_id first_leader  second_leader third_leader  underling_number
         * 3       0             0             0             1
         * 4       3             0             0
         * 
         * ５、第二次运行时[假设传递的是４]
         * user_id first_leader second_leader third_leader   underling_number
         * 3       0             0            0              2
         * 4       3             0            0              1
         * 5       4             3            0              
         * 
         * ６、第三次运行时[假设传递的是５]
         * user_id  first_leader seconde_leader third_leader underling_number
         * 3        0            0              0            3
         * 4        3            0              0            2
         * 5        4            3              0            1
         * 6        5            4              3            0
         * 
         * ７、第四运行时[假设传递的是３]
         * user_id  first_leader seconde_leader third_leader underling_number
         * 3        0             0             0            4
         * 4        3             0             0            2
         * 5        4             3             0            1
         * 6        5             4             3            0
         * 7        3             0             0            0
         * 
         * 这样一级下线人数　以及具体的会员信息
         * 二级线下有几个人
         * 三级线下有几个人更清晰明了
         * ***/
      

        //推广码自动生成
        $map['my_code'] = create_invite_code();
        
        // 成为分销商条件
        //$distribut_condition = tpCache('distribut.condition');
        //if($distribut_condition == 0)  // 直接成为分销商, 每个人都可以做分销
        $map['is_distribut'] = 1; // 默认每个人都可以成为分销商
        $map['push_id'] = $push_id; //推送id
        $map['token'] = md5(time() . mt_rand(1, 999999999));
        $map['last_login'] = time();
        $user_id = Db::name('users')->add($map);
        if (!$user_id)
            return array('status' => -1, 'msg' => '注册失败', 'result' => '');

        $pay_points = tpCache('basic.reg_integral'); // 会员注册赠送积分
        if ($pay_points > 0)
            accountLog($user_id, 0, $pay_points, '会员注册赠送积分'); // 记录日志流水
        $user = Db::name('users')->where("user_id = {$user_id}")->find();

        return array('status' => 1, 'msg' => '注册成功', 'result' => $user);
    }

    /**
     * 获取当前登录用户信息
     * @param $user_id
     * @return array|bool
     */
    public function get_info($user_id)
    {
        if (!$user_id > 0) {
            return array('status' => -1, 'msg' => '缺少参数');
        }

        $user = Db::name('users')->where('user_id', $user_id)->find();
        if (!$user) {
            return false;
        }

        return ['status' => 1, 'msg' => '获取成功', 'result' => $user];
    }

    public function getMobileUserInfo($user_id)
    {
        if (!$user_id) {
            return array('status' => -1, 'msg' => '缺少参数');
        }

        $user = Db::name('users')->where('user_id', $user_id)->find();
        if (!$user) {
            return false;
        }

        $activityLogic = new ActivityLogic;             //获取能使用优惠券个数
        $user['coupon_count'] = $activityLogic->getUserCouponNum($user_id, 0);
        $user['collect_count'] = Db::name('goods_collect')->where('user_id', $user_id)->count(); //获取商品收藏数量
        $user['focus_count'] = Db::name('store_collect')->where('user_id', $user_id)->count(); //获取商家关注数量
        $user['return_count'] = Db::name('return_goods')->where(['user_id' => $user_id, 'status' => ['<', 2]])->count();   //退换货数量
        //不统计虚拟的
        $user['waitPay'] = Db::name('order')->where("order_prom_type < 5 and user_id = $user_id " . C('WAITPAY'))->count(); //待付款数量
        $user['waitSend'] = Db::name('order')->where("order_prom_type < 5 and user_id = $user_id " . C('WAITSEND'))->count(); //待发货数量
        $user['waitReceive'] = Db::name('order')->where("order_prom_type < 5 and user_id = $user_id " . C('WAITRECEIVE'))->count(); //待收货数量
        $user['order_count'] = $user['waitPay'] + $user['waitSend'] + $user['waitReceive'];

        $commentLogic = new CommentLogic;
        $user['uncomment_count'] = $commentLogic->getWaitCommentNum($user_id); //待评论数

        return ['status' => 1, 'msg' => '获取成功', 'result' => $user];
    }

    public function getHomeUserInfo($user_id)
    {
        if (!$user_id) {
            return array('status' => -1, 'msg' => '缺少参数');
        }

        $user = Db::name('users')->cache(true, 10)->where('user_id', $user_id)->find();
        if (!$user) {
            return false;
        }

        $activityLogic = new ActivityLogic;             //获取能使用优惠券个数
        $user['coupon_count'] = $activityLogic->getUserCouponNum($user_id, 0);
        $user['waitPay'] = Db::name('order')->where("user_id = $user_id " . C('WAITPAY'))->count(); //待付款数量

        $commentLogic = new CommentLogic;
        $user['uncomment_count'] = $commentLogic->getWaitCommentNum($user_id); //待评论数

        return ['status' => 1, 'msg' => '获取成功', 'result' => $user];
    }

    public function getApiUserInfo($user_id)
    {
        if (!$user_id) {
            return array('status' => -1, 'msg' => '缺少用户id', 'result' => '');
        }

        $user = Db::name('users')->cache(true, 10)->where('user_id', $user_id)->find();
        if (!$user) {
            return false;
        }

        $activityLogic = new ActivityLogic;             //获取能使用优惠券个数
        $user['coupon_count'] = $activityLogic->getUserCouponNum($user_id, 0);

        $user['collect_count'] = Db::name('goods_collect')->where('user_id', $user_id)->count(); //获取商品收藏数量
        $user['focus_count'] = Db::name('store_collect')->where('user_id', $user_id)->count(); //获取商家关注数量
        $user['visit_count'] = Db::name('goods_visit')->where('user_id', $user_id)->count();   //商品访问记录数
        $user['return_count'] = Db::name('return_goods')->where(['user_id' => $user_id, 'status' => ['<', 2]])->count();   //退换货数量

        $order_where = "deleted=0 AND order_status<>5 AND order_prom_type<5 AND user_id=$user_id ";
        $user['waitPay'] = Db::name('order')->where($order_where . C('WAITPAY'))->count(); //待付款数量,不包括虚拟订单
        $user['waitSend'] = Db::name('order')->where($order_where . C('WAITSEND'))->count(); //待发货数量
        $user['waitReceive'] = Db::name('order')->where($order_where . C('WAITRECEIVE'))->count(); //待收货数量
        $user['order_count'] = $user['waitPay'] + $user['waitSend'] + $user['waitReceive'];

        $messageLogic = new \app\common\logic\MessageLogic();
        $user['message_count'] = $messageLogic->getUserMessageCount();

        $commentLogic = new CommentLogic;
        $user['comment_count'] = $commentLogic->getHadCommentNum($user_id); //已评论数
        $user['uncomment_count'] = $commentLogic->getWaitCommentNum($user_id); //待评论数
        $user['serve_comment_count'] = $commentLogic->getWaitServiceCommentNum($user_id); //服务未评价数

        $cartLogic = new CartLogic();
        $cartLogic->setUserId($user_id);
        $user['cart_goods_num'] = $cartLogic->getUserCartGoodsNum(); //购物车商品数量

        return ['status' => 1, 'msg' => '获取成功', 'result' => $user];
    }

    /**
     * 获取账户资金记录
     * @param $user_id |用户id
     * @param int $account_type 收入：1,支出:2 所有：0
     * @param null $order_sn 订单编号
     * @param null $order_start 查找时间范围-开始时间
     * @param null $order_end 查找时间范围-结束时间
     * @param null $desc 备注信息
     * @return mixed
     */
    public function get_account_log($user_id, $account_type = 0, $order_sn = null, $order_start = null, $order_end = null, $desc = null)
    {
        //查询条件
        $where['user_id'] = $user_id;
        if ($account_type == 1) {
            //收入
            $where['user_money|pay_points'] = array('gt', 0);
        }
        if ($account_type == 2) {
            //支出
            $where['user_money|pay_points'] = array('lt', 0);
        }
        if ($order_sn) {
            $where['order_sn'] = $order_sn;
        }
        if ($order_start && $order_end) {
            $order_start_time = strtotime(str_replace('+', ' ', $order_start));
            $order_end_time = strtotime(str_replace('+', ' ', $order_end));
            $where['change_time'] = array(array('gt', $order_start_time), array('lt', $order_end_time));
        }
        if ($desc) {
            $where['desc'] = array('like', '%' . $desc . '%');
        }
        $count = Db::name('account_log')->where($where)->count();
        $Page = new Page($count, 16);
        $account_log = Db::name('account_log')->where($where)->order('change_time desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $return = [
            'status' => 1,
            'msg' => '',
            'result' => $account_log,
            'show' => $Page->show()
        ];
        return $return;
    }

    /**
     * 提现记录
     * @author lxl 2017-4-26
     * @param $user_id
     * @param $withdrawals_status 状态：-2删除作废-1审核失败0申请中1审核通过2付款成功3付款失败
     * @return mixed
     */
    public function get_withdrawals_log($user_id, $withdrawals_status = '')
    {
        $withdrawals_log_where = ['user_id' => $user_id];
        if ($withdrawals_status) {
            $withdrawals_log_where['status'] = $withdrawals_status;
        }
        $count = Db::name('withdrawals')->where($withdrawals_log_where)->count();
        $Page = new Page($count, 15);
        $withdrawals_log = Db::name('withdrawals')->where($withdrawals_log_where)
            ->order('id desc')
            ->limit($Page->firstRow . ',' . $Page->listRows)
            ->select();
        $return = [
            'status' => 1,
            'msg' => '',
            'result' => $withdrawals_log,
            'show' => $Page->show()
        ];
        return $return;
    }

    /**
     * 用户充值记录
     * $author lxl 2017-4-26
     * @param $user_id 用户ID
     * @param int $pay_status 充值状态0:待支付 1:充值成功 2:交易关闭
     * @return mixed
     */
    public function get_recharge_log($user_id, $pay_status = 0)
    {
        $recharge_log_where = ['user_id' => $user_id];
        if ($pay_status) {
            $pay_status['status'] = $pay_status;
        }
        $count = Db::name('recharge')->where($recharge_log_where)->count();
        $Page = new Page($count, 15);
        $recharge_log = Db::name('recharge')->where($recharge_log_where)
            ->order('order_id desc')
            ->limit($Page->firstRow . ',' . $Page->listRows)
            ->select();
        $return = [
            'status' => 1,
            'msg' => '',
            'result' => $recharge_log,
            'show' => $Page->show()
        ];
        return $return;
    }

    /*
     * 获取优惠券
     * $type:查询类型 0:未使用，1:已使用，2:已过期
     * $order_money: 订单总额，筛选出大于等于总额的优惠券，0代表不加此筛选条件
     */
    public function get_coupon($user_id, $type = 0, $orderBy = null, $belone = 0, $store_id = 0, $order_money = 0)
    {
        $activityLogic = new ActivityLogic;
        $count = $activityLogic->getUserCouponNum($user_id, $type, $orderBy, $belone, $store_id, $order_money);

        $page = new Page($count, 12);
        $list = $activityLogic->getUserCouponList($page->firstRow, $page->listRows, $user_id, $type, $orderBy, $belone, $store_id, $order_money);

        $return['status'] = 1;
        $return['msg'] = '获取成功';
        $return['result'] = $list;
        $return['show'] = $page->show();
        return $return;
    }

    /**
     * 获取商品收藏列表
     * @param $user_id  用户id
     */
    public function get_goods_collect($user_id, $is_prom = -1)
    {
        $where = '';
        if ($is_prom > 0) {
            $where = ' AND prom_id > 0 ';
            $count = Db::name('goods_collect')->alias('gc')->join('__GOODS__ g', 'gc.goods_id = g.goods_id')->where(array('gc.user_id' => $user_id, 'g.prom_id' => ['gt', 0]))->count('collect_id');
        } else {
            $count = Db::name('goods_collect')->where(array('user_id' => $user_id))->count('collect_id');
        }
        $page = new Page($count, 10);
        $show = $page->show();
        //获取我的收藏列表
        $sql = "SELECT c.collect_id,c.add_time,g.goods_id,g.cat_id3,g.goods_name,g.is_virtual,g.shop_price,g.original_img,g.is_on_sale,g.store_count,g.prom_id,g.comment_count FROM __PREFIX__goods_collect c " .
            "inner JOIN __PREFIX__goods g ON g.goods_id = c.goods_id " .
            "WHERE c.user_id = " . $user_id . $where .
            " ORDER BY c.add_time DESC LIMIT {$page->firstRow},{$page->listRows}";
        $result = Db::query($sql);
        $return['status'] = 1;
        $return['msg'] = '获取成功';
        $return['result'] = $result;
        $return['show'] = $show;
        $return['page'] = $page;
        return $return;
    }

    /**
     * 邮箱或手机绑定
     * @param $email_mobile  邮箱或者手机
     * @param int $type 1 为更新邮箱模式  2 手机
     * @param int $user_id 用户id
     * @return bool
     */
    public function update_email_mobile($email_mobile, $user_id, $type = 1)
    {
        //检查是否存在邮件
        if ($type == 1)
            $field = 'email';
        if ($type == 2)
            $field = 'mobile';
        $condition['user_id'] = array('neq', $user_id);
        $condition[$field] = $email_mobile;

        $is_exist = Db::name('users')->where($condition)->find();
        if ($is_exist)
            return false;
        unset($condition[$field]);
        $condition['user_id'] = $user_id;
        $validate = $field . '_validated';
        Db::name('users')->where($condition)->save(array($field => $email_mobile, $validate => 1));
        return true;
    }

    /**
     * 上传头像
     */
    public function upload_headpic($must_upload = true)
    {
        if ($_FILES['head_pic']['tmp_name']) {
            $file = request()->file('head_pic');
            $image_upload_limit_size = config('image_upload_limit_size');
            $validate = ['size' => $image_upload_limit_size, 'ext' => 'jpg,png,gif,jpeg'];
            $dir = 'public/upload/head_pic/';
            if (!($_exists = file_exists($dir))) {
                mkdir($dir);
            }
            $parentDir = date('Ymd');
            $info = $file->validate($validate)->move($dir, true);
            if ($info) {
                $pic_path = '/' . $dir . $parentDir . '/' . $info->getFilename();
            } else {
                return ['status' => -1, 'msg' => $file->getError()];
            }
        } elseif ($must_upload) {
            return ['status' => -1, 'msg' => "图片不存在！"];
        }
        return ['status' => 1, 'msg' => '上传成功', 'result' => $pic_path];
    }

    /**
     * 更新用户信息
     * @param $user_id
     * @param $post  要更新的信息
     * @return bool
     */
    public function update_info($user_id, $data = [])
    {
        if (!$user_id) {
            return false;
        }

        $row = Db::name('users')->where('user_id', $user_id)->save($data);
        return $row !== false;
    }

    /**
     * 地址添加/编辑
     * @param $user_id 用户id
     * @param int $address_id 地址id(编辑时需传入
     * @param $data
     * @return array
     */
    public function add_address($user_id, $address_id = 0, $data)
    {
        $post = $data;
        if ($address_id == 0) {
            $c = Db::name('UserAddress')->where("user_id = $user_id")->count();
            if ($c >= 20)
                return array('status' => -1, 'msg' => '最多只能添加20个收货地址', 'result' => '');
        }

        //检查手机格式
        if ($post['consignee'] == '')
            return array('status' => -1, 'msg' => '收货人不能为空', 'result' => '');
        if (!($post['province'] > 0)|| !($post['city']>0) || !($post['district']>0))
            return array('status' => -1, 'msg' => '所在地区不能为空', 'result' => '');
        if (!$post['address'])
            return array('status' => -1, 'msg' => '地址不能为空', 'result' => '');
        if (!check_mobile($post['mobile']) && !check_telephone($post['mobile']))
            return array('status' => -1, 'msg' => '手机号码格式有误', 'result' => '');

        //编辑模式
        if ($address_id > 0) {

            $address = Db::name('user_address')->where(array('address_id' => $address_id, 'user_id' => $user_id))->find();
            if ($post['is_default'] == 1 && $address['is_default'] != 1)
                Db::name('user_address')->where(array('user_id' => $user_id))->save(array('is_default' => 0));
            
            $row = Db::name('user_address')->where(array('address_id' => $address_id, 'user_id' => $user_id))->fetchSql(false)->save($post);
            
            if ($row !== false) {
                return array('status' => 1, 'msg' => '编辑成功', 'result' => $address_id);
            } else {
                return array('status' => -1, 'msg' => '操作完成', 'result' => $address_id);
            }

        }
        //添加模式
        $post['user_id'] = $user_id;

        // 如果目前只有一个收货地址则改为默认收货地址
        $c = Db::name('user_address')->where("user_id = {$post['user_id']}")->count();
        if ($c == 0) $post['is_default'] = 1;

        $address_id = Db::name('user_address')->add($post);
        //如果设为默认地址
        $insert_id = Db::name('user_address')->getLastInsID();
        $map['user_id'] = $user_id;
        $map['address_id'] = array('neq', $insert_id);

        if ($post['is_default'] == 1)
            Db::name('user_address')->where($map)->save(array('is_default' => 0));
        if (!$address_id)
            return array('status' => -1, 'msg' => '添加失败', 'result' => '');


        return array('status' => 1, 'msg' => '添加成功', 'result' => $address_id);
    }

    /**
     * 设置默认收货地址
     * @param $user_id
     * @param $address_id
     */
    public function set_default($user_id, $address_id)
    {
        Db::name('user_address')->where(array('user_id' => $user_id))->save(array('is_default' => 0)); //改变以前的默认地址地址状态
        $row = Db::name('user_address')->where(array('user_id' => $user_id, 'address_id' => $address_id))->save(array('is_default' => 1));
        if (!$row)
            return false;
        return true;
    }

    /**
     * 修改密码
     * @param $user_id  用户id
     * @param $old_password  旧密码
     * @param $new_password  新密码
     * @param $confirm_password 确认新 密码
     * @param bool|true $is_update
     * @return array
     */
    public function password($user_id, $old_password, $new_password, $confirm_password, $is_update = true)
    {
        $user = Db::name('users')->where('user_id', $user_id)->find();
        if (strlen($new_password) < 6)
            return array('status' => -1, 'msg' => '密码不能低于6位字符', 'result' => '');
        if ($new_password != $confirm_password)
            return array('status' => -1, 'msg' => '两次密码输入不一致', 'result' => '');
        if ($user['password'] == encrypt($new_password))
            return array('status' => -1, 'msg' => '新密码不得与旧密码相同！', 'result' => '');
        //验证原密码
        if ($is_update && ($user['password'] != '' && encrypt($old_password) != $user['password']))
            return array('status' => -1, 'msg' => '密码验证失败', 'result' => '');
        $row = Db::name('users')->where("user_id", $user_id)->save(array('password' => encrypt($new_password)));
        if (!$row)
            return array('status' => -1, 'msg' => '修改失败', 'result' => '');
        return array('status' => 1, 'msg' => '修改成功', 'result' => '');
    }

    /**
     * 设置支付密码
     * @param $user_id  用户id
     * @param $new_password  新密码
     * @param $confirm_password 确认新 密码
     * @return array
     */
    public function paypwd($user_id, $new_password, $confirm_password)
    {
        $user = Db::name('users')->where('user_id', $user_id)->find();
        if (strlen($new_password) < 6)
            return array('status' => -1, 'msg' => '密码不能低于6位字符', 'result' => '');
        if ($new_password != $confirm_password)
            return array('status' => -1, 'msg' => '两次密码输入不一致', 'result' => '');
        if ($user['paypwd'] == encrypt($new_password))
            return array('status' => -1, 'msg' => '新密码不得与旧密码相同！', 'result' => '');
        $row = Db::name('users')->where("user_id", $user_id)->update(array('paypwd' => encrypt($new_password)));
        if (!$row) {
            return array('status' => -1, 'msg' => '修改失败', 'result' => '');
        }
        $payPriorUrl = session('payPriorUrl');
        $url = !empty($payPriorUrl) ? $payPriorUrl : U('User/userinfo');
        session('payPriorUrl', null);
        return array('status' => 1, 'msg' => '修改成功', 'url' => $url);
    }

    /**
     *  针对 APP 修改密码的方法
     * @param $user_id  用户id
     * @param $old_password  旧密码
     * @param $new_password  新密码
     * @param bool $is_update
     * @return array
     */
    public function passwordForApp($user_id, $old_password, $new_password, $is_update = true)
    {
        $user = Db::name('users')->where('user_id', $user_id)->find();
        if (strlen($new_password) < 6) {
            return array('status' => -1, 'msg' => '密码不能低于6位字符', 'result' => '');
        }
        //验证原密码
        if ($is_update && ($user['password'] != '' && $old_password != $user['password'])) {
            return array('status' => -1, 'msg' => '旧密码错误', 'result' => '');
        }

        $row = Db::name('users')->where("user_id='{$user_id}'")->update(array('password' => $new_password));
        if (!$row) {
            return array('status' => -1, 'msg' => '密码修改失败', 'result' => '');
        }
        return array('status' => 1, 'msg' => '密码修改成功', 'result' => '');
    }

    /**
     *  针对 APP 修改支付密码的方法
     * @param $user_id  用户id
     * @param $new_password  新密码
     * @return array
     */
    public function payPwdForApp($user_id, $new_password)
    {
        if (strlen($new_password) < 6) {
            return array('status' => -1, 'msg' => '密码不能低于6位字符', 'result' => '');
        }

        $row = Db::name('users')->where(['user_id'=>$user_id])->update(array('paypwd' => $new_password));
        if (!$row) {
            return array('status' => -1, 'msg' => '密码修改失败', 'result' => '');
        }
        return array('status' => 1, 'msg' => '密码修改成功', 'result' => '');
    }

    /**
     * 发送验证码: 该方法只用来发送邮件验证码, 短信验证码不再走该方法
     * @param $sender 接收人
     * @param $type 发送类型
     * @return json
     */
    public function send_email_code($sender)
    {
        $sms_time_out = tpCache('sms.sms_time_out');
        $sms_time_out = $sms_time_out ? $sms_time_out : 180;
        //获取上一次的发送时间
        $send = session('validate_code');
        if (!empty($send) && $send['time'] > time() && $send['sender'] == $sender) {
            //在有效期范围内 相同号码不再发送
            $res = array('status' => -1, 'msg' => '规定时间内,不要重复发送验证码');
            return $res;
        }
        $code = mt_rand(1000, 9999);
        //检查是否邮箱格式
        if (!check_email($sender)) {
            $res = array('status' => -1, 'msg' => '邮箱码格式有误');
            return $res;
        }
        $send = send_email($sender, '验证码', '您好，你的验证码是：' . $code);
        if ($send['status'] == 1) {
            $info['code'] = $code;
            $info['sender'] = $sender;
            $info['is_check'] = 0;
            $info['time'] = time() + $sms_time_out; //有效验证时间
            session('validate_code', $info);
            $res = array('status' => 1, 'msg' => '验证码已发送，请注意查收');
        } else {
            $res = array('status' => -1, 'msg' => $send['msg']);
        }
        return $res;
    }

    /**
     * 检查短信/邮件验证码验证码
     * @param unknown $code
     * @param unknown $sender
     * @param unknown $session_id
     * @return multitype:number string
     */
    public function check_validate_code($code, $sender, $type = 'email', $session_id = 0, $scene = -1)
    {

        $timeOut = time();
        $inValid = true;  //验证码失效

        //短信发送否开启
        //-1:用户没有发送短信
        //空:发送验证码关闭
        $sms_status = checkEnableSendSms($scene);

        //邮件证码是否开启
        $reg_smtp_enable = tpCache('smtp.regis_smtp_enable');

        if ($type == 'email') {
            if (!$reg_smtp_enable) {//发生邮件功能关闭
                $validate_code = session('validate_code');
                $validate_code['sender'] = $sender;
                $validate_code['is_check'] = 1;//标示验证通过
                session('validate_code', $validate_code);
                return array('status' => 1, 'msg' => '邮件验证码功能关闭, 无需校验验证码');
            }
            if (!$code) return array('status' => -1, 'msg' => '请输入邮件验证码');
            //邮件
            $data = session('validate_code');
            $timeOut = $data['time'];
            if ($data['code'] != $code || $data['sender'] != $sender) {
                $inValid = false;
            }
        } else {
            if ($scene == -1) {
                return array('status' => -1, 'msg' => '参数错误, 请传递合理的scene参数');
            } elseif ($sms_status['status'] == 0) {
                $data['sender'] = $sender;
                $data['is_check'] = 1; //标示验证通过
                session('validate_code', $data);
                return array('status' => 1, 'msg' => '短信验证码功能关闭, 无需校验验证码');
            }

            if (!$code) return array('status' => -1, 'msg' => '请输入短信验证码');

            //短信
            $sms_time_out = tpCache('sms.sms_time_out');
            $sms_time_out = $sms_time_out ? $sms_time_out : 180;
            $data = Db::name('sms_log')->where(array('mobile' => $sender,'status' => 1))->order('id DESC')->find();
            if (is_array($data) && $data['code'] == $code) {
                $data['sender'] = $sender;
                $timeOut = $data['add_time'] + $sms_time_out;
            } else {
                $inValid = false;
            }
        }

        if (empty($data)) {
            $res = array('status' => 0, 'msg' => '请先获取验证码');
        } elseif ($timeOut < time()) {
            $res = array('status' => 0, 'msg' => '验证码已超时失效');
        } elseif (!$inValid) {
            $res = array('status' => 0, 'msg' => '验证失败,验证码有误');
        } else {
            $data['is_check'] = 1; //标示验证通过
            session('validate_code', $data);
            $res = array('status' => 1, 'msg' => '验证成功');
        }
        return $res;
    }


    /**
     * 设置用户消息已读
     * @param int $category 0:系统消息|1：活动消息
     * @param $msg_id
     * @throws \think\Exception
     */
    public function setMessageForRead($category, $msg_id)
    {
        $user_info = session('user');
        if (!empty($user_info['user_id'])) {
            $data['status'] = 1;
            $set_where['user_id'] = $user_info['user_id'];
            if ($category != '') {
                $set_where['category'] = $category;
            }
            if ($msg_id) {
                $set_where['message_id'] = $msg_id;
            }
            $updat_meg_res = Db::name('user_message')->where($set_where)->update($data);
            if ($updat_meg_res) {
                return ['status' => 1, 'msg' => '操作成功'];
            }
        }
        return ['status' => -1, 'msg' => '操作失败'];
    }

    /**
     * 删除用户消息
     * @param int $category 0:系统消息|1：活动消息
     * @param $msg_id
     * @throws \think\Exception
     */
    public function delMessageForRead($category = 0, $msg_id)
    {
        $user_info = session('user');
        if (!empty($user_info['user_id'])) {
            $data['status'] = 1;
            $set_where['user_id'] = $user_info['user_id'];
            $set_where['category'] = $category;
            if ($msg_id) {
                $set_where['message_id'] = $msg_id;
            }
            $updat_meg_res = Db::name('user_message')->where($set_where)->delete();
            if ($updat_meg_res) {
                return ['status' => 1, 'msg' => '删除成功'];
            }
        }
        return ['status' => -1, 'msg' => '删除失败'];
    }

    /**
     * 积分明细
     */
    public function points($user_id, $type = 'all')
    {
        if ($type == 'all') {
            $count = Db::name('account_log')->where("user_id=" . $user_id . " and pay_points!=0 ")->count();
            $page = new Page($count, 16);
            $account_log = Db::name('account_log')->where("user_id=" . $user_id . " and pay_points!=0 ")->order('log_id desc')->limit($page->firstRow . ',' . $page->listRows)->select();
        } else {
            $where = $type == 'plus' ? " and pay_points>0 " : " and pay_points<0 ";
            $count = Db::name('account_log')->where("user_id=" . $user_id . $where)->count();
            $page = new Page($count, 16);
            $account_log = Db::name('account_log')->where("user_id=" . $user_id . $where)->order('log_id desc')->limit($page->firstRow . ',' . $page->listRows)->select();
        }

        $result['account_log'] = $account_log;
        $result['page'] = $page;
        return $result;
    }

    /**
     * 账户明细
     */
    public function account($user_id, $type = 'all')
    {
        if ($type == 'all') {
            $count = Db::name('account_log')->where("user_money!=0 and user_id=" . $user_id)->count();
            $page = new Page($count, 16);
            $account_log = Db::name('account_log')->where("user_money!=0 and user_id=" . $user_id)->order('log_id desc')->limit($page->firstRow . ',' . $page->listRows)->select();
        } else {
            $where = $type == 'plus' ? " and user_money>0 " : " and user_money<0 ";
            $count = Db::name('account_log')->where("user_id=" . $user_id . $where)->count();
            $page = new Page($count, 16);
            $account_log = Db::name('account_log')->where("user_id=" . $user_id . $where)->order('log_id desc')->limit($page->firstRow . ',' . $page->listRows)->select();
        }
        $result['account_log'] = $account_log;
        $result['page'] = $page;
        return $result;
    }

    /**
     * 新增或更新商品打分，联动更新店铺分数
     */
    public function save_store_score($user_id, $order_id, $store_id, $score)
    {
        $score_where = ['order_id' => $order_id, 'user_id' => $user_id, 'deleted' => 0];
        $order_comment = Db::name('order_comment')->where($score_where)->find();
        if ($order_comment) {
            Db::name('order_comment')->where($score_where)->save($score);
            Db::name('order')->where(array('order_id' => $order_id))->save(array('is_comment' => 1));
        } else {
            Db::name('order_comment')->add($score);//订单打分
            Db::name('order')->where(array('order_id' => $order_id))->save(array('is_comment' => 1));
        }
        //订单打分后更新店铺评分
        $store_logic = new \app\common\logic\StoreLogic;
        $store_logic->updateStoreScore($store_id);
    }

    public function visit_log($user_id, $p = 1)
    {
        $visit = Db::name('goods_visit')->alias('v')
            ->field('v.visit_id, v.goods_id, v.visittime, g.goods_name, g.shop_price, g.cat_id3,g.is_virtual')
            ->join('__GOODS__ g', 'v.goods_id=g.goods_id')
            ->where('v.user_id', $user_id)
            ->order('v.visittime desc')
            ->page($p, 20)
            ->select();

        /* 浏览记录按日期分组 */
        $curyear = date('Y');
        $visit_list = [];
        foreach ($visit as $v) {
            if ($curyear == date('Y', $v['visittime'])) {
                $date = date('m月d日', $v['visittime']);
            } else {
                $date = date('Y年m月d日', $v['visittime']);
            }
            $visit_list[$date][] = $v;
        }
        return $visit_list;
    }



    /**
     * 添加用户签到信息
     * @param $user_id int 用户id
     * @param $date date 日期
     * @return array
     */
    public function addUserSign($user_id, $date)
    {
        $config = tpCache('sign');
        $data['user_id'] = $user_id;
        $data['sign_total'] = 1;
        $data['sign_last'] = $date;
        $data['cumtrapz'] = $config['sign_integral'];
        $data['sign_time'] = "$date";
        $data['sign_count'] = 1;
        $data['this_month'] = $config['sign_integral'];
        $result['status'] = false;
        $result['msg'] = '签到失败!';
        if (Db::name('user_sign')->add($data)) {
            $result['status'] = true;
            $result['msg'] = '签到旅程开始啦,积分奖励!';
            accountLog($user_id, 0, $config['sign_integral'], '第一次签到赠送' . $config['sign_integral'] . '积分');
        }
        return $result;
    }

    /**
     * 累计用户签到信息
     * @param $userInfo  array   用户信息
     * @param $date      date    日期
     * @return array
     */
    public function updateUserSign($userInfo, $date)
    {
        $config = tpCache('sign');
        $update_data = array(
            'sign_total' => ['exp', 'sign_total+' . 1],                                     //累计签到天数
            'sign_last'  => ['exp', "'$date'"],                                             //最后签到时间
            'cumtrapz'   => ['exp', 'cumtrapz+' . $config['sign_integral']],                //累计签到获取积分
            'sign_time'  => ['exp', "CONCAT_WS(',',sign_time ,'$date')"],                   //历史签到记录
            'sign_count' => ['exp', 'sign_count+' . 1],                                     //连续签到天数
            'this_month' => ['exp', 'this_month+' . $config['sign_integral']],              //本月累计积分
        );
        $daya = $userInfo['sign_last'];
        $dayb = date("Y-n-j", strtotime($date) - 86400);
        if ($daya != $dayb) {                                                               //不是连续签
            $update_data['sign_count'] = ['exp', 1];
        }
        $mb = date("m", strtotime($date));
        if (intval($mb) != intval(date("m", strtotime($daya)))) {                            //不是本月签到
            $update_data['sign_count'] = ['exp', 1];
            $update_data['sign_time']  = ['exp', "'$date'"];
            $update_data['this_month'] = ['exp', $config['sign_integral']];
        }
        $update = Db::name('user_sign')->where(['user_id' => $userInfo['user_id']])->update($update_data);
        $result['status'] = false;
        $result['msg'] = '签到失败!';
        if ($update>0) {
            accountLog($userInfo['user_id'], 0, $config['sign_integral'], '签到赠送' . $config['sign_integral'] . '积分');
            $result['status'] = true;
            $result['msg'] = '签到成功!奖励' . $config['sign_integral'] . '积分';
            $userFind = Db::name('user_sign')->where(['user_id' => $userInfo['user_id']])->find();
            //满足额外奖励
            if ($userFind['sign_count'] >= $config['sign_signcount']) {
                $result['msg'] = '哇，你已经连续签到' . $userFind['sign_count'] . '天,得到额外奖励！';
                $this->extraAward($userInfo, $config);
            }
        }
        return $result;
    }

    /**
     * 累计签到额外奖励
     * @param $userSingInfo array 用户信息
     */
    public function extraAward($userSingInfo)
    {
        $config = tpCache('sign');
        //满足额外奖励
        Db::name('user_sign')->where(['user_id' => $userSingInfo['user_id']])->update([
            'cumtrapz' => ['exp', 'cumtrapz+' . $config['sign_award']],
            'this_month' => ['exp', 'this_month+' . $config['sign_award']]
        ]);
        $msg = '连续签到奖励' . $config['sign_award'] . '积分';
        accountLog($userSingInfo['user_id'], 0, $config['sign_award'], $msg);
    }

    /**
     * 标识用户签到信息
     * @param $user_id int 用户id
     * @return      array
     */
    public function idenUserSign($user_id)
    {
        $config = tpCache('sign');
        $map['us.user_id'] = $user_id;
        $field = [
            'u.user_id as user_id',
            'u.nickname',
            'u.mobile',
            'us.*',
        ];
        $join = [['users u', 'u.user_id=us.user_id', 'left']];
        $info = Db::name('user_sign')->alias('us')->field($field)->join($join)->where($map)->find();
        ($info['sign_last'] != date("Y-n-j", time())) && $tab = "1";
        $signTime = explode(",", $info['sign_time']);
        $str = "";
        //是否标识历史签到
        if (date("m", strtotime($info['sign_last'])) == date("m", time())) {
            foreach ($signTime as $val) {
                $str .= date("j", strtotime($val)) . ',';
            }
        } else {
            $info['sign_count'] = 0; //不是本月清除连续签到
        }
        if( $info['sign_count']>=$config['sign_signcount'])
            $display_sign=  $config['sign_award']+ $config['sign_integral'];
        else
            $display_sign=  $config['sign_integral'];
        $jiFen = ($config['sign_signcount'] * $config['sign_integral']) + $config['sign_award'];
        return ['info' => $info, 'str' => $str, 'jifen' => $jiFen, 'config' => $config, 'tab' => $tab,'display_sign'=>$display_sign];
    }


}