<?php

namespace frontend\controllers;

use frontend\components\BaseController;

/**
 * Created by PhpStorm.
 * User: a
 * Date: 14-6-24
 * Time: 下午2:45
 */
class QrcodeController extends BaseController
{
    /**
     *
     * 作业2维码
     */
    public function actionZy($id)
    {

        \PHPQRCode\QRcode::png('http://www.banhai.com:8907/app/d/downloadApp.d?s=1001:' . user()->id . ':' . $id . ':', false, 'h', 6, 2);

    }

    /**
     *
     * 作业2维码
     */
    public function actionVideo($id)
    {

        \PHPQRCode\QRcode::png('http://www.banhai.com:8907/app/d/downloadApp.d?s=1002:' . user()->id . ':' . $id . ':', false, 'h', 6, 2);

    }

    /**
     *
     * 个人2维码
     */
    public function actionGr($id, $source)
    {

        \PHPQRCode\QRcode::png('http://www.banhai.com:8907/app/d/downloadApp.d?s=1000:' . user()->id . ':' . $id . ':' . $source . ":", false, 'h', 6, 2);

    }

    public function actionLogin()
    {
        $code = app()->request->get('code');
        \PHPQRCode\QRcode::png('http://www.banhai.com:8907/app/d/downloadApp.d?s=1003:' . ':' . $code . ':' . ":", false, 'h', 6, 2);
    }

} 