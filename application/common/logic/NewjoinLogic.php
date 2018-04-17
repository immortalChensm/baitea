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
 */

namespace app\common\logic;

class NewjoinLogic
{
    /**
     * 上传营业证书
     * @param bool $force 是否强制上传
     * @return array
     */
    public function uploadBusinessCertificate($force = false)
    {
        $img = '';
        if ($_FILES['business_licence_cert']['tmp_name']) {
            $file = request()->file('business_licence_cert');
            $image_upload_limit_size = config('image_upload_limit_size');
            $validate = ['size' => $image_upload_limit_size, 'ext' => 'jpg,png,gif,jpeg'];
            $dir = 'public/upload/store/cert/';
            if (!($_exists = file_exists($dir))) {
                mkdir($dir);
            }
            $parentDir = date('Y-m-d');
            $info = $file->validate($validate)->move($dir, true);
            if (!$info) {
                return ['status' => -1, 'msg' => $file->getError()];
            }
            $img = '/' . $dir . $parentDir . '/' . $info->getFilename();
        }

        if ($force && !$img) {
            return ['status' => -1, 'msg' => '没有上传营业执照'];
        }

        return ['status' => 1, 'msg' => '上传成功', 'result' => $img];
    }
}