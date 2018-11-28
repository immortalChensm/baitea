<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 商业用途务必到官方购买正版授权, 使用盗版将严厉追究您的法律责任。
 * ============================================================================
 */ 
namespace app\api\controller;
use \think\Db;

/**
 * 
 *
 */
class Live extends Base
{
    /*******************生成RMPT推流地址和拉流地址**********************/
    /**
     * 获取推流地址
     * 如果不传key和过期时间，将返回不含防盗链的url
     * @param [bizId 您在腾讯云分配到的bizid]
     * streamId 您用来区别不同推流地址的唯一id     [直播码 也叫房间号，推荐用随机数字或者用户ID，注意一个合法的直播码需要拼接 BIZID 前缀。]
     * key 安全密钥
     * time 过期时间 sample 2016-11-12 12:00:00 建议24小时 
     * txTime 何时该URL会过期，格式是十六进制的UNIX时间戳，
     * 比如 5867D600 代表 2017年1月1日0时0点0分过期。 我们的客户一般会将 txTime 设置为当前时间 24 小时以后过期，过期时间不要太短，
     * 当主播在直播过程中遭遇网络闪断时会重新恢复推流，如果过期时间太短，主播会因为推流 URL 过期而无法恢复推流。
     * $bizId, $streamId, $key = null, $time = null
     * @return String url */
    function getPushUrl(){
        	
        $bizId = \think\Config::get("BIZID");
        $key   = \think\Config::get("RMPT_STEAL_KEY");
        $time = date("Y-m-d H:i:s",time()+24*3600);
        
        //$streamId = $this->request->param("streamId");
        $streamId   = $this->user_id;
        empty($streamId) && $this->ajaxReturn(['status'=>-1,'msg'=>'请您先登录']);
        if($key && $time){
            
            $txTime = strtoupper(base_convert(strtotime($time),10,16));
            
            //txSecret = MD5( KEY + livecode + txTime )
            //livecode = bizid+"_"+stream_id  如 8888_test123456
            //直播码＝bizid+stream_id+当前时间便于区分哪个主播放在什么时候直播
            $date = time();
            $livecode = $bizId."_".$streamId.'_'.$date; //直播码
            
            $txSecret = md5($key.$livecode.$txTime);
            
            $ext_str = "?".http_build_query(array(
                "bizid"=> $bizId,
                "txSecret"=> $txSecret,
                "txTime"=> $txTime
            ));
        }
        //return "rtmp://".$bizId.".livepush.myqcloud.com/live/".$livecode.(isset($ext_str) ? $ext_str : "");
        
        //echo "rtmp://".$bizId.".livepush.myqcloud.com/live/".$livecode.(isset($ext_str) ? $ext_str : "");
        $liveshow['rtmp']     = "rtmp://".$bizId.".livepush.myqcloud.com/live/".$livecode.(isset($ext_str) ? $ext_str : "");
        $liveshow['date']     = $date;
        $liveshow['streamId'] = $streamId;
        $liveshow['livecode'] = $livecode;
        return $liveshow;
    }
    	
    //echo getPushUrl("8888","123456","69e0daf7234b01f257a7adb9f807ae9f","2016-09-11 20:08:07");
    //echo "<br />";
    /**
     * 获取播放地址
     * @param bizId 您在腾讯云分配到的bizid
     * streamId 您用来区别不同推流地址的唯一id
     * $bizId, $streamId
     * @return String url */
    function getPlayUrl($liveshow){
        
        $bizId = \think\Config::get("BIZID");
        $key   = \think\Config::get("RMPT_STEAL_KEY");
        $time = time()+24*3600;
        //$streamId = $this->request->param("streamId");
        
        //$livecode = $bizId."_".$liveshow['streamId']; //直播码
        $livecode   = $liveshow['livecode'];
        $playurl = array(
            "rtmp://".$bizId.".liveplay.myqcloud.com/live/".$livecode,
            "http://".$bizId.".liveplay.myqcloud.com/live/".$livecode.".flv",
            "http://".$bizId.".liveplay.myqcloud.com/live/".$livecode.".m3u8"
        );
        return $playurl;
    }
    //print_r(getPlayUrl("8888","123456"));
    /*******************生成RMPT推流地址和拉流地址**********************/
    
    
    
    
    
   /***********生成userSig用于IM即时通迅********************/
    
    
    private $sdkappid = 0;         // 在腾讯云注册的sdkappid
    private $private_key = false;  // 腾讯云sdkappid对应的私钥
    private $public_key = false;   // 腾讯云sdkappid对应的公钥
    
    /**
     * 设置sdkappid
     * @param type $sdkappid
     */
    public function setSdkAppid($sdkappid) {
        $this->sdkappid = $sdkappid;
    }
    
    /**
     * 设置私钥 如果要生成userSig和privMapEncrypt则需要私钥
     * @param string $private_key 私钥文件内容
     * @return bool 是否成功
     */
    public function setPrivateKey($private_key) {
        $this->private_key = openssl_pkey_get_private($private_key);
        if ($this->private_key === false) {
            throw new \Exception(openssl_error_string());
        }
        return true;
    }
    
    /**
     * 设置公钥 如果要验证userSig和privMapEncrypt则需要公钥
     * @param string $public_key 公钥文件内容
     * @return bool 是否成功
     */
    public function setPublicKey($public_key) {
        $this->public_key = openssl_pkey_get_public($public_key);
        if ($this->public_key === false) {
            throw new \Exception(openssl_error_string());
        }
        return true;
    }
    
    /**
     * 用于url的base64encode
     * '+' => '*', '/' => '-', '=' => '_'
     * @param string $string 需要编码的数据
     * @return string 编码后的base64串，失败返回false
     */
    private function base64Encode($string) {
        static $replace = Array('+' => '*', '/' => '-', '=' => '_');
        $base64 = base64_encode($string);
        if ($base64 === false) {
            throw new \Exception('base64_encode error');
        }
        return str_replace(array_keys($replace), array_values($replace), $base64);
    }
    
    /**
     * 用于url的base64decode
     * '*' => '+', '-' => '/', '_' => '='
     * @param string $base64 需要解码的base64串
     * @return string 解码后的数据，失败返回false
     */
    private function base64Decode($base64) {
        static $replace = Array('*' => '+', '-' => '/', '_' => '=');
        $string = str_replace(array_keys($replace), array_values($replace), $base64);
        $result = base64_decode($string);
        if ($result == false) {
            throw new \Exception('base64_decode error');
        }
        return $result;
    }
    
    /**
     * ECDSA-SHA256签名
     * @param string $data 需要签名的数据
     * @return string 返回签名 失败时返回false
     */
    private function sign($data) {
        $signature = '';
        if (!openssl_sign($data, $signature, $this->private_key, 'sha256')) {
            throw new \Exception(openssl_error_string());
        }
        return $signature;
    }
    
    /**
     * 验证ECDSA-SHA256签名
     * @param string $data 需要验证的数据原文
     * @param string $sig 需要验证的签名
     * @return int 1验证成功 0验证失败
     */
    private function verify($data, $sig) {
        $ret = openssl_verify($data, $sig, $this->public_key, 'sha256');
        if ($ret == -1) {
            throw new \Exception(openssl_error_string());
        }
        return $ret;
    }
    
    /**
     * 根据json内容生成需要签名的buf串
     * @param array $json 票据json对象
     * @return string 按标准格式生成的用于签名的字符串
     * 失败时返回false
     */
    private function genSignContentForUserSig(array $json) {
        static $members = Array(
            'TLS.appid_at_3rd',
            'TLS.account_type',
            'TLS.identifier',
            'TLS.sdk_appid',
            'TLS.time',
            'TLS.expire_after'
        );
    
        $content = '';
        foreach ($members as $member) {
            if (!isset($json[$member])) {
                throw new \Exception('json need ' . $member);
            }
            $content .= "{$member}:{$json[$member]}\n";
        }
        return $content;
    }
    
    /**
     * 根据json内容生成需要签名的buf串
     * @param array $json 票据json对象
     * @return string 按标准格式生成的用于签名的字符串
     * 失败时返回false
     */
    private function genSignContentForPrivMapEncrypt(array $json) {
        static $members = Array(
            'TLS.appid_at_3rd',
            'TLS.account_type',
            'TLS.identifier',
            'TLS.sdk_appid',
            'TLS.time',
            'TLS.expire_after',
            'TLS.userbuf'
        );
    
        $content = '';
        foreach ($members as $member) {
            if (!isset($json[$member])) {
                throw new \Exception('json need ' . $member);
            }
            $content .= "{$member}:{$json[$member]}\n";
        }
        return $content;
    }
    
    /**
     * 生成userSig
     * @param string $userid 用户名
     * @param uint $expire userSig有效期 默认为300秒
     * @return string 生成的userSig 失败时为false
     */
    public function genUserSig($userid, $expire = 300) {
        $json = Array(
            'TLS.account_type' => '0',
            'TLS.identifier' => (string) $userid,
            'TLS.appid_at_3rd' => '0',
            'TLS.sdk_appid' => (string) $this->sdkappid,
            'TLS.expire_after' => (string) $expire,
            'TLS.version' => '201512300000',
            'TLS.time' => (string) time()
        );
    
        $err = '';
        $content = $this->genSignContentForUserSig($json, $err);
        $signature = $this->sign($content, $err);
        $json['TLS.sig'] = base64_encode($signature);
        if ($json['TLS.sig'] === false) {
            throw new \Exception('base64_encode error');
        }
        $json_text = json_encode($json);
        if ($json_text === false) {
            throw new \Exception('json_encode error');
        }
        $compressed = gzcompress($json_text);
        if ($compressed === false) {
            throw new \Exception('gzcompress error');
        }
        return $this->base64Encode($compressed);
    }
    
    /**
     * 生成privMapEncrypt
     * @param string $userid 用户名
     * @param uint $roomid 房间号
     * @param uint $expire privMapEncrypt有效期 默认为300秒
     * @return string 生成的privMapEncrypt 失败时为false
     */
    public function genPrivMapEncrypt($userid, $roomid, $expire = 300) {
        //视频校验位需要用到的字段
        /*
         cVer    unsigned char/1 版本号，填0
         wAccountLen unsigned short /2   第三方自己的帐号长度
         buffAccount wAccountLen 第三方自己的帐号字符
         dwSdkAppid  unsigned int/4  sdkappid
         dwAuthId    unsigned int/4  群组号码
         dwExpTime   unsigned int/4  过期时间 （当前时间 + 有效期（单位：秒，建议300秒））
         dwPrivilegeMap  unsigned int/4  权限位
         dwAccountType   unsigned int/4  第三方帐号类型
         */
        $userbuf = pack('C1', '0');                     //cVer  unsigned char/1 版本号，填0
        $userbuf .= pack('n',strlen($userid));          //wAccountLen   unsigned short /2   第三方自己的帐号长度
        $userbuf .= pack('a'.strlen($userid),$userid);  //buffAccount   wAccountLen 第三方自己的帐号字符
        $userbuf .= pack('N',$this->sdkappid);          //dwSdkAppid    unsigned int/4  sdkappid
        $userbuf .= pack('N',$roomid);                  //dwAuthId  unsigned int/4  群组号码/音视频房间号
        $userbuf .= pack('N', time() + $expire);        //dwExpTime unsigned int/4  过期时间 （当前时间 + 有效期（单位：秒，建议300秒））
        $userbuf .= pack('N', hexdec("0xff"));          //dwPrivilegeMap unsigned int/4  权限位
        $userbuf .= pack('N', 0);                       //dwAccountType  unsigned int/4  第三方帐号类型
    
        $json = Array(
            'TLS.account_type' => '0',
            'TLS.identifier' => (string) $userid,
            'TLS.appid_at_3rd' => '0',
            'TLS.sdk_appid' => (string) $this->sdkappid,
            'TLS.expire_after' => (string) $expire,
            'TLS.version' => '201512300000',
            'TLS.time' => (string) time(),
            'TLS.userbuf' => base64_encode($userbuf)
        );
    
        $err = '';
        $content = $this->genSignContentForPrivMapEncrypt($json, $err);
        $signature = $this->sign($content, $err);
        $json['TLS.sig'] = base64_encode($signature);
        if ($json['TLS.sig'] === false) {
            throw new \Exception('base64_encode error');
        }
        $json_text = json_encode($json);
        if ($json_text === false) {
            throw new \Exception('json_encode error');
        }
        $compressed = gzcompress($json_text);
        if ($compressed === false) {
            throw new \Exception('gzcompress error');
        }
        return $this->base64Encode($compressed);
    }
    
    /**
     * 验证userSig
     * @param type $userSig userSig
     * @param type $userid 需要验证用户名
     * @param type $init_time usersig中的生成时间
     * @param type $expire_time usersig中的有效期 如：3600秒
     * @param type $error_msg 失败时的错误信息
     * @return boolean 验证是否成功
     */
    public function verifyUserSig($userSig, $userid, &$init_time, &$expire_time, &$error_msg) {
        try {
            $error_msg = '';
            $decoded_sig = $this->base64Decode($userSig);
            $uncompressed_sig = gzuncompress($decoded_sig);
            if ($uncompressed_sig === false) {
                throw new \Exception('gzuncompress error');
            }
            $json = json_decode($uncompressed_sig);
            if ($json == false) {
                throw new \Exception('json_decode error');
            }
            $json = (array) $json;
            if ($json['TLS.identifier'] !== $userid) {
                throw new \Exception("userid error sigid:{$json['TLS.identifier']} id:{$userid}");
            }
            if ($json['TLS.sdk_appid'] != $this->sdkappid) {
                throw new \Exception("sdkappid error sigappid:{$json['TLS.sdk_appid']} thisappid:{$this->sdkappid}");
            }
            $content = $this->genSignContentForUserSig($json);
            $signature = base64_decode($json['TLS.sig']);
            if ($signature == false) {
                throw new \Exception('userSig json_decode error');
            }
            $succ = $this->verify($content, $signature);
            if (!$succ) {
                throw new \Exception('verify failed');
            }
            $init_time = $json['TLS.time'];
            $expire_time = $json['TLS.expire_after'];
            return true;
    
        } catch (\Exception $ex) {
            $error_msg = $ex->getMessage();
            return false;
        }
    }
    
    /**
     * 验证privMapEncrypt
     * @param type $privMapEncrypt privMapEncrypt
     * @param type $userid 需要验证用户名
     * @param type $init_time privMapEncrypt中的生成时间
     * @param type $expire_time privMapEncrypt中的有效期 如：3600秒
     * @param type $userbuf 视频校验位字符串
     * @param type $error_msg 失败时的错误信息
     * @return boolean 验证是否成功
     */
    public function verifyPrivMapEncrypt($privMapEncrypt, $userid, &$init_time, &$expire_time, &$userbuf, &$error_msg) {
        try {
            $error_msg = '';
            $decoded_sig = $this->base64Decode($privMapEncrypt);
            $uncompressed_sig = gzuncompress($decoded_sig);
            if ($uncompressed_sig === false) {
                throw new \Exception('gzuncompress error');
            }
            $json = json_decode($uncompressed_sig);
            if ($json == false) {
                throw new \Exception('json_decode error');
            }
            $json = (array) $json;
            if ($json['TLS.identifier'] !== $userid) {
                throw new \Exception("userid error sigid:{$json['TLS.identifier']} id:{$userid}");
            }
            if ($json['TLS.sdk_appid'] != $this->sdkappid) {
                throw new \Exception("sdkappid error sigappid:{$json['TLS.sdk_appid']} thisappid:{$this->sdkappid}");
            }
            $content = $this->genSignContentForPrivMapEncrypt($json);
            $signature = base64_decode($json['TLS.sig']);
            if ($signature == false) {
                throw new \Exception('sig json_decode error');
            }
            $succ = $this->verify($content, $signature);
            if (!$succ) {
                throw new \Exception('verify failed');
            }
            $init_time = $json['TLS.time'];
            $expire_time = $json['TLS.expire_after'];
            $userbuf = base64_decode($json['TLS.userbuf']);
            return true;
    
        } catch (\Exception $ex) {
            $error_msg = $ex->getMessage();
            return false;
        }
    }
    
    //获取即时通迅的usersign
    public function getImUserSigndemo()
    {
        
        if($this->request->isPost()){
            
            try{
                //$sdkappid = 1400037025;  //腾讯云云通信sdkappid
                $sdkappid = \think\Config::get("IM_SDKAPPID");
                
                //$roomid = 1234;          //音视频房间号roomid
                //$userid = "webrtc98";    //用户名userid
            
                $roomid   = $this->request->param("roomid");
                $userid   = $this->user_id;
                empty($sdkappid)&&$this->ajaxReturn(['status'=>-1,'msg'=>'IMsdkappid未配置']);
                empty($roomid)&&$this->ajaxReturn(['status'=>-1,'msg'=>'请传递当前主播的房间号']);
                empty($userid)&&$this->ajaxReturn(['status'=>-1,'msg'=>'请传递当前登录用户的token值']);
                /******
                 * 根据传递的当前直播房间号加当前观看用户的id进行RSA加密签名生成userSign
                 * 
                 * ******/
                //$api = new WebRTCSigApi();
            
                //设置在腾讯云申请的sdkappid
                $this->setSdkAppid($sdkappid);
            
                //读取私钥的内容
                //PS:不要把私钥文件暴露到外网直接下载了哦
                //$private = file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'private_key');
                
                $private = "./vendor/tengxun_im/private_key";
                if(file_exists($private)){
                    $this->ajaxReturn(['status'=>-1,'msg'=>'私钥文件不存在无法签名']);
                }
                //设置私钥(签发usersig需要用到）
                $this->SetPrivateKey($private);
            
                //读取公钥的内容
                //$public = file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'public_key');
                $public   = "./vendor/tengxun_im/public_key";
                if(file_exists($public)){
                    $this->ajaxReturn(['status'=>-1,'msg'=>'公钥文件不存在无法签名']);
                }
                //设置公钥(校验userSig和privMapEncrypt需要用到，校验只是为了验证，实际业务中不需要校验）
                $this->SetPublicKey($public);
            
            
                //生成privMapEncrypt
                $privMapEncrypt = $this->genPrivMapEncrypt($userid, $roomid);
            
                //生成userSig
                $userSig = $this->genUserSig($userid);
            
                //校验
                $result = $this->verifyUserSig($userSig, $userid, $init_time, $expire_time, $error_msg);
                $result = $this->verifyPrivMapEncrypt($privMapEncrypt, $userid, $init_time, $expire_time, $userbuf, $error_msg);
            
            
                //打印结果
                $ret =  array(
                    'privMapEncrypt' => $privMapEncrypt,
                    'userSig' => $userSig,
                    "roomid"=>$roomid,
                    "userid"=>$userid
                );
                //echo json_encode($ret);
                //echo "\n";
                $this->ajaxReturn(['status'=>1,'msg'=>'Usersig签名成功','result'=>$ret]);
            
            }catch(\Exception $e){
                //echo $e->getMessage();
                $this->ajaxReturn(['status'=>-1,'msg'=>$e->getMessage()]);
            }
        }else{
            $this->ajaxReturn(['status'=>-1,'msg'=>'仅支持post方式请求']);
        }
        
        
    }
    
    public function getImUserSign()
    {

         try{    
                 require_once "./vendor/livesign/TLSSig.php";
         
                 $api = new \TLSSigAPI();
                 $sdkappid = \think\Config::get("IM_SDKAPPID");
                 $api->SetAppid($sdkappid);
                 
                 $private = file_get_contents("./vendor/tengxun_im/private_key");
                 
                 $api->SetPrivateKey($private);
                 
                 $public = file_get_contents("./vendor/tengxun_im/public_key");
                 
                 $api->SetPublicKey($public);
                 $userid   = $this->user_id;
                 $sig = $api->genSig($userid);
                 
                 $result = $api->verifySig($sig, (string)$userid, $init_time, $expire_time, $error_msg);

                 $this->ajaxReturn(['status'=>1,'msg'=>'签名成功','result'=>[
                     'userSig' => $sig,
                     "userid"=>$userid
                 ]]);
                 }catch(\Exception $e){
                 echo $e->getMessage();
         }
 
    }
    /***********生成userSig用于IM即时通迅********************/
    
    //im账号导入 cli模式
    public function accountimport()
    {
        $url = "http://118.190.204.122:9501";
        $command_dic = array(
            "openim.sendmsg" => 'send_msg',
            "openim.sendmsg_pic" => 'send_msg_pic',
            "openim.batchsendmsg" => 'batch_sendmsg',
            "openim.batchsendmsg_pic" => 'batch_sendmsg_pic',
            "im_open_login_svc.account_import" => 'account_import',
            "registration_service.register_account" => 'register_account',
            "profile.portrait_get" => 'portrait_get',
            "profile.portrait_set" => 'portrait_set',
            "sns.friend_import" => 'friend_import',
            "sns.friend_delete" => 'friend_delete',
            "sns.friend_delete_all" => 'friend_delete_all',
            "sns.friend_check" => 'friend_check',
            "sns.friend_get_all" => 'friend_get_all',
            "sns.friend_get_list" => 'friend_get_list',
            "group_open_http_svc.get_appid_group_list" => 'get_appid_group_list',
            "group_open_http_svc.create_group" => 'create_group',
            "group_open_http_svc.change_group_owner" => 'change_group_owner',
            "group_open_http_svc.get_group_info" => 'get_group_info',
            "group_open_http_svc.get_group_member_info" => 'get_group_member_info',
            "group_open_http_svc.modify_group_base_info" => 'modify_group_base_info',
            "group_open_http_svc.add_group_member" => 'add_group_member',
            "group_open_http_svc.delete_group_member" => 'delete_group_member',
            "group_open_http_svc.modify_group_member_info" => 'modify_group_member_info',
            "group_open_http_svc.destroy_group" => 'destroy_group',
            "group_open_http_svc.get_joined_group_list" => 'get_joined_group_list',
            "group_open_http_svc.get_role_in_group" => 'get_role_in_group',
            "group_open_http_svc.forbid_send_msg" => 'forbid_send_msg',
            "group_open_http_svc.send_group_msg" => 'send_group_msg',
            "group_open_http_svc.send_group_msg_pic" => 'send_group_msg_pic',
            "group_open_http_svc.send_group_system_notification" => 'send_group_system_notification',
            "group_open_http_svc.import_group_member" => 'import_group_member',
            "group_open_http_svc.import_group_msg" => 'import_group_msg',
            "group_open_http_svc.set_unread_msg_num" => 'set_unread_msg_num'
        );
        if(!$command_dic[$this->request->param("server_name").'.'.$this->request->param("command")]){
            $this->ajaxReturn(['status'=>-1,'msg'=>'不存在IM命令']);
        }
        $user = \think\Db::name("users")->where("user_id",$this->request->param("identify"))->find();
        if($user['is_im']==1)$this->ajaxReturn(['status'=>-1,'msg'=>'此账号已经集成到IM系统']);
        $ret = httpRequest($url, 'post',[
            "server_name"=>$this->request->param("server_name"),
            'command'=>$this->request->param("command"),
            
                'identify'=>$this->request->param("args.identify"),
                'nick'=>$this->request->param("args.nick"),
                'face_url'=>$this->request->param("args.face_url")
            
        ]);
        $this->ajaxReturn(['status'=>1,'msg'=>'请求ok','result'=>$ret]);
    }
    
    //我要直播　主播进入直播页面
    public function liveshow(\app\common\logic\LiveLogic $liveLogic)
    {
        if($this->request->isPost()){
            empty(Db::name("users")->where("user_id",$this->user_id)->value("idcard_isvalidate"))&&$this->ajaxReturn(['status'=>-1,'msg'=>'请先实名认证']);;
            $is_live_host = Db::name("live_apply")->where("userid",$this->user_id)->find();
            if(empty($is_live_host))$this->ajaxReturn(['status'=>-1,'msg'=>'您还不是主播去申请一下']);
            if($is_live_host['status']!=2)$this->ajaxReturn(['status'=>-1,'msg'=>'您申请的主播还没有通过无法开播']);
            
            $is_live = Db::name("liveplay")->whereTime("add_time","today")->where("userid",$this->user_id)->find();
            if($is_live['userid']){
                //重复开播则更新标题，封面
                $data['title']      = $this->request->param("title");
                $data['live_cover'] = $this->request->param("live_cover");
                $data['live_pixs']  = $this->request->param("live_pixs");
                $data['roomid']     = $this->request->param("roomid");
                Db::name("liveplay")->whereTime("add_time","today")->where("userid",$this->user_id)->save($data);
                $is_live['title']      = $data['title'];
                $is_live['live_cover'] = $data['live_cover'];
                $is_live['live_pixs']  = $data['live_pixs'];
                $is_live['roomid']     = $data['roomid'];
                $is_live['playurl']    = unserialize($is_live['playurl']);
                $is_live['userinfo']   = Db::name("users")->field("user_id,head_pic,nickname,mobile")->where("user_id",$this->user_id)->find();
                $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result'=>$is_live]);
            }
            $data['userid']     = $this->user_id;
            $data['title']      = $this->request->param("title");
            $data['live_cover'] = $this->request->param("live_cover");
            $data['live_pixs']  = $this->request->param("live_pixs");
            $data['roomid']     = $this->request->param("roomid");
            $live = $this->getPushUrl();
            $play = $this->getPlayUrl($live);
            
            $data['pushurl']    = $live['rtmp'];
            $data['playurl']    =$play;
            $data['add_time']   = time();
            $data['live_roomid']= $liveLogic->generatorLiveRoom();
            $ret = $data;
            $ret['userinfo'] = Db::name("users")->field("user_id,head_pic,nickname,mobile")->where("user_id",$this->user_id)->find();
            $data['playurl']    = serialize($play);
            $result = $this->validate($data, 'Live');
            if($result==1){
                if(Db::name("liveplay")->save($data)){
                    $ret['id'] = Db::name("liveplay")->where("roomid",$data['roomid'])->value("id");
                    $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result'=>$ret]);
                }
            }else{
                $this->ajaxReturn(['status'=>-1,'msg'=>$result]);
            }
        }
    }
    
    //直播流状态更新
    public function livestreamevent()
    {
        $postStr = file_get_contents("php://input");
        //file_put_contents("steamstatus", $postStr.PHP_EOL,FILE_APPEND);
        $postRet = json_decode($postStr,true); 
        if($postRet){
            $ret = Db::name("liveplay")->whereLike("pushurl","%{$postRet['stream_id']}%")->find();
            if($ret){
                Db::name("liveplay")->where("id",$ret['id'])->save([
                    'status'=>$postRet['event_type']
                ]);
                echo '{ "code":0 }';
            }
        }
        
    }
    
    //直播列表 获取直播状态的数据
    public function livelist()
    {
        $keyword = input("keyword");
        if(is_numeric($keyword)&&isset($keyword)){
            $total = Db::name("liveplay")->where("live_roomid",$keyword)->whereTime("add_time",'today')->where("status",1)->count();
        }elseif(is_string($keyword)&&isset($keyword)){
            $total = Db::name("liveplay")->whereLike("title","%$keyword%")->whereTime("add_time",'today')->where("status",1)->count();
        }else{
            $total = Db::name("liveplay")->where("status",1)->whereTime("add_time",'today')->count();
        }
        
        $page = new \think\Page($total,10);
        $live = Db::name("liveplay")
                    ->where(function($query)use($keyword){
                        
                        if(is_numeric($keyword)&&isset($keyword)){
                            $query->where("live_roomid",$keyword)->whereTime("add_time",'today')->where("status",1);
                        }elseif(is_string($keyword)&&isset($keyword)){
                            $query->whereLike("title","%$keyword%")->whereTime("add_time",'today')->where("status",1);
                        }else{
                            $query->whereTime("add_time",'today')->where("status",1);
                        }
                        
                    })
                    ->order("add_time","desc")
                    ->limit($page->firstRow,$page->listRows)
                    ->select();
        $userid = [];
        $liveid = [];
        foreach ($live as $k=>$v){
            $userid[] = $v['userid'];
            $liveid[] = $v['id'];
        }

        /*$audience = Db::name("live_audience")->whereIn("liveid",$liveid)->select();
        $audienceNum = [];
        foreach ($audience as $k=>$v){
            $audienceNum[$v['liveid']][] = $v['userid'];
        }*/
        $user = Db::name("users")->whereIn("user_id",$userid)->select();
        $userInfo = [];
        foreach ($user as $k=>$v){
            $userInfo[$v['user_id']] = $v;
        }
        foreach ($live as $k=>$v){
            $live[$k] = $v;
            $live[$k]['userinfo'] = $userInfo[$v['userid']];
            //$live[$k]['audience'] = count($audienceNum[$v['id']]);
            $live[$k]['playurl']  = unserialize($v['playurl']);
        }
        
        $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result'=>$live]);
    }
    
    //申请直播
    public function liveshow_apply()
    {
        if($this->request->isPost()){
            $data['username'] = $this->request->param("username");
            $data['mobile']   = $this->request->param("mobile");
            $data['info']     = $this->request->param("info");
            $data['userid']   = $this->user_id;
            $data['add_time'] = time();
            $validate = Db::name("users")->where("user_id",$this->user_id)->find();
            $applylive = Db::name("live_apply")->where("userid",$this->user_id)->find();
            if($validate['idcard_isvalidate']!=1)$this->ajaxReturn(['status'>-1,'msg'=>'请先实名认证']);
            if($data['username']!=$validate['realname']){
                $this->ajaxReturn(['status'=>-1,'msg'=>'提交的姓名和实名认证的不一致']);
            }
            if(!check_mobile($data['mobile'])){
                $this->ajaxReturn(['status'=>-1,'msg'=>'手机号码不正确']);
            }
            if($applylive['userid']&&$applylive['status']==1){
                $this->ajaxReturn(['status'=>-1,'msg'=>'您的申请已提交，请等待平台审核']);
            }elseif($applylive['userid']&&$applylive['status']==2){
                
                $this->ajaxReturn(['status'=>-1,'msg'=>'您的申请已通过请不要重复申请']);
            }
            
            if(Db::name("live_apply")->save($data)){
                $this->ajaxReturn(['status'=>1,'msg'=>'提交成功请等待平台审核']);
            }
            
        }
    }
    
    //直播间　　观众进入直播间
    public function getliveinfo(\app\common\logic\LiveLogic $livelogic)
    {
        if($this->request->isPost()){
            empty($this->request->param("liveid"))&&$this->ajaxReturn(['status'=>-1,'msg'=>'参数错误']);
            if($this->user_id)$livelogic->add_audience($this->user_id, $this->request->param("liveid"));
            //Db::name("liveplay")->where("id",$this->request->param("liveid"))->setInc("audience");
            $live = Db::name("liveplay")->where("id",$this->request->param("liveid"))->find();
            
            if($live['id']){
                $live['audience'] = Db::name("live_audience")->whereIn("liveid",$live['id'])->count();
                $live['is_subscribe'] = (Db::name("livesub")
                                        ->where("userid",$this->user_id?:0)
                                        ->where("liveid",$live['userid'])
                                        ->value("id"))?1:0;
                $live['playurl']       = unserialize($live['playurl']);
                $live['userinfo'] = Db::name("users")->field("user_id,head_pic,nickname,mobile")->where("user_id",$live['userid'])->find();
                
                $sign = $this->makeSing();
                //当前主播的直播流id
                $streamId = substr($live['pushurl'],strpos($live['pushurl'], \think\Config::get("BIZID")."_"),strpos($live['pushurl'], "?bizid")-strpos($live['pushurl'], \think\Config::get("BIZID")."_"));
                $url  = "http://fcgi.video.qcloud.com/common_access?appid={$sign['appid']}&interface=Live_Channel_GetStatus&Param.s.channel_id={$streamId}&t={$sign['txTime']}&sign={$sign['txSecret']}";
                $ret = json_decode(file_get_contents($url),true);
                if($ret['ret']==0){
                    $live['live_status'] = $ret['output'][0]['status'];
                }else{
                    $live['live_status'] = -1;
                }
                
                
                $this->ajaxReturn(['status'=>1,'msg'=>'获取成功','result'=>$live]);
            }else{
                $this->ajaxReturn(['status'=>-1,'msg'=>'不存在此主播或已主播已关闭']);
            }
        }
    }
    
    //直播关注
    public function subscribeliver()
    {
        if($this->request->isPost()){
            $live = Db::name("livesub")
                        ->where("liveid",$this->request->param("liveid"))
                        ->where("userid",$this->user_id)
                        ->find();
            if($live['id']){
                if(Db::name("livesub")
                ->where("id",$live['id'])
                ->delete())$this->ajaxReturn(['status'=>1,'msg'=>'取消关注成功']);
            }else{
                if(Db::name("livesub")->save([
                    "liveid"=>$this->request->param("liveid"),
                    "userid"=>$this->user_id,
                    "add_time"=>time()
                ]))$this->ajaxReturn(['status'=>1,'msg'=>'关注成功']);
                
            }
        }
    }
    //退房
    public function exitliveroom(\app\common\logic\LiveLogic $livelogic)
    {
        if($this->request->isPost()){
            empty($this->request->param("liveid"))&&$this->ajaxReturn(['status'=>-1,'msg'=>'参数错误']);
            if($this->user_id) $ret = $livelogic->decraudience($this->user_id, $this->request->param("liveid"));
            //$ret = @Db::name("liveplay")->where("id",$this->request->param("liveid"))->setDec("audience");
            if($ret)$this->ajaxReturn(['status'=>1,'msg'=>'退出成功']);
            $this->ajaxReturn(['status'=>1,'msg'=>'退出失败']);
        }
    }
    
    //查询是否在直播中
    public function ispushstream($streamid)
    {
        $sign = $this->makeSing();
        $url  = "http://fcgi.video.qcloud.com/common_access?appid={$sign['appid']}&interface=Live_Channel_GetStatus&Param.s.channel_id={$$streamid}&t={$sign['txTime']}&sign={$sign['txSecret']}";
        $ret = file_get_contents($url);
        /**
         *  rate_type	码率	int	0：原始码率；10：普清；20：高清
            recv_type	播放协议	int	1：rtmp/flv；2：hls；3：rtmp/flv+hls
            status	状态	int	0：断流；1：开启；3：关闭
         * **/
        //print_r($ret);
    }
    
    //直播码api接口签名
    /*
     *  appid	客户 ID	int	即直播 appid，用于区分不同客户的身份	Y
        interface	接口名称	string	如：Get_LivePushStat	Y
        t	有效时间	int	UNIX 时间戳（十进制）	Y
        sign	安全签名	string	MD5(key+t)	Y
        Param.s.channel_id	直播码	string	一次只能查询一条直播流	Y
     * 
     * 
     */
    private function makeSing()
    {
        $key      = \think\Config::get("LIVE_API_KEY");
        $time     = date("Y-m-d H:i:s",(time()+300));
        $txTime   = strtotime($time);
        $txSecret = md5($key.$txTime);
        $appid    = \think\Config::get("liveappid");
        return    [
            "key"      =>$key,
            "time"     =>$time,
            "txTime"   =>$txTime,
            "txSecret" =>$txSecret,
            "appid"    =>$appid
        ];
        
    }
}
