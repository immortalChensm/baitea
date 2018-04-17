<?php
/*
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 商业用途务必到官方购买正版授权, 使用盗版将严厉追究您的法律责任。
 * ============================================================================
 * 2015-11-21
 */

namespace app\mobile\controller;

use think\Db;

class Newjoin extends MobileBase
{
    /*
     * 初始化操作
     */

    public $user_id;
    public $apply = array();

    public function _initialize()
    {
        parent::_initialize();
        $this->user_id = cookie('user_id');
        if (empty($this->user_id) && ACTION_NAME != 'index') {
            $this->redirect(U('User/login'));
        } else if (!empty($this->user_id)) {
            $this->apply = M('store_apply')->where(array('user_id' => $this->user_id))->find();
        }
        (!empty($this->apply) && $this->apply['apply_state'] == 0) && $this->error('入驻申请已经提交，请等待管理员审核', U('User/index'));
        ($this->apply['apply_state'] == 1) && $this->success('您的资料已经审核通过，现在您可以去经营您的店铺了，赶紧去商铺发布商品吧', U('User/index'), '', 5);
        $user = get_user_info($this->user_id);
        if ($user && empty($user['password'])) {
            $this->error('您使用的是第三方账号登陆，请先设置账号密码', U('User/password'));
        }
        $this->assign('user', $user);
    }

    /**
     * 我要开店
     */
    public function guidance()
    {
        ($this->apply['apply_state'] == 2) && $this->error('抱歉，您的申请没有通过，系统将导自动导引到入驻页面,请您重新填写入驻信息', U('Newjoin/basic_info'), '', 5);
        return $this->fetch();
    }

    public function basic_info()
    {
        if (IS_POST) {
            $data = I('post.');
            $data['user_id'] = $this->user_id;
            $data['add_time'] = time();
            $data['apply_type'] = 0;
            foreach ($_FILES as $k => $v) {
                if (empty($v['tmp_name'])) {
                    $this->error('请上传必要证件');
                }
            }
            $files = $this->request->file();
            $savePath = 'public/upload/store/cert/' . date('Y-m-d') . '/';
            if (!($_exists = file_exists($savePath))) {
                $isMk = mkdir($savePath);
            }
            $image_upload_limit_size = config('image_upload_limit_size');
            foreach ($files as $key => $file) {
                $info = $file->rule(function ($file) {
                    return md5(mt_rand()); // 使用自定义的文件保存规则
                })->validate(['size' => $image_upload_limit_size, 'ext' => 'jpg,png,gif,jpeg'])->move($savePath, true);
                if ($info) {
                    $filename = $info->getFilename();
                    $new_name = '/' . $savePath . $filename;
                    $data[$key] = $new_name;
                } else {
                    $this->error($file->getError()); //上传错误提示错误信息
                }
            }
            $data['business_licence_cert'] = $data['comment_img_file'];
            if (!empty($data['supplier'])) {
                $data['business_date_start'] = $data['supplier']['business_date_start'];
                $data['business_date_end'] = $data['supplier']['business_date_end'];
                unset($data['supplier']);
            }
            $data['business_permanent'] == 1 && $data['business_date_end'] = '长期';
            if (DB::name('store_apply')->add($data)) {
                (Db::name('store_apply')->where('id', $this->apply['apply_state'])->find()) && DB::name('store_apply')->where('id', $this->apply['id'])->delete();
                $this->success('提交成功,请等待审核结果', U('User/index'));
            } else {
                $this->error('服务器繁忙,请联系官方客服');
            }
        }
        //主营类目
        $this->assign('store_class', M('store_class')->getField('sc_id,sc_name'));
        return $this->fetch();
    }

}


