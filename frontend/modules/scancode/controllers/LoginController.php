<?php

namespace frontend\modules\scancode\controllers;


/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 18-3-15
 * Time: 下午6:57
 */
use common\components\WebDataCache;
use common\controller\YiiController;
use common\models\JsonMessage;
use frontend\models\ScanLoginModel;
use PhpOffice\PhpWord\IOFactory;
use Yii;
use yii\web\Controller;

class LoginController extends YiiController
{
    /**
     * 扫码登录标识
     */
    const SCAN_CODE_LOGIN = 1003;

    /**
     * 保存用户扫码登录记录
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionUserInfo()
    {
        $jsonMessage = new JsonMessage();
        $code = app()->request->post('code','');
        $token = app()->request->post('token','' );
        $userName = app()->request->post('user-name','');
        $type = app()->request->post('type',self::SCAN_CODE_LOGIN);

        Yii::warning($code.$token.$userName.$type);
        if ($code == '' || $token == '' || $userName == ''){
            $jsonMessage->message = '参数不正确';
            return $this->renderJSON($jsonMessage);
        }
        Yii::warning('扫码code为：'.$code);
        $scanLoginModel = ScanLoginModel::getScanLoginCodeUser($code,$type);

        if ($scanLoginModel == null || $scanLoginModel->userName != ''){
            $jsonMessage->message = '该二维码已经失效，请重试';
            return $this->renderJSON($jsonMessage);
        }

        $saveScanLoginModel = ScanLoginModel::saveScanLoginCodeUser($code,$token,$userName,$type);
        if ($saveScanLoginModel == null){
            $jsonMessage->message = '扫码失败，请重试';
            return $this->renderJSON($jsonMessage);
        }
        $jsonMessage->data = $saveScanLoginModel;
        $jsonMessage->success = true;
        return $this->renderJSON($jsonMessage);

    }


    /**
     * 查询扫码用户信息
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionGetCodeUserInfo()
    {
        $jsonMessage = new JsonMessage();
        $code = app()->request->get('code', '');
        $type = app()->request->get('type', self::SCAN_CODE_LOGIN);
        if ($code == ''){
            $jsonMessage->message = '参数不正确';
            return $this->renderJSON($jsonMessage);
        }

        $scanLoginModel = ScanLoginModel::getScanLoginCodeUser($code,$type);
        if ($scanLoginModel == null){
            $jsonMessage->message = '没有用户扫描该二维码登录';
            return $this->renderJSON($jsonMessage);
        }

        $jsonMessage->data = $scanLoginModel;
        $jsonMessage->success = true;
        return $this->renderJSON($jsonMessage);
    }

    /**
     * 用户确认登录，修改状态
     * @return string
     * @throws \yii\base\ExitException
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function actionSureLogin()
    {
        $jsonMessage = new JsonMessage();
        $code = app()->request->post('code', '');
        $type = app()->request->post('type', self::SCAN_CODE_LOGIN);
        if ($code == ''){
            $jsonMessage->message = '参数不正确';
            return $this->renderJSON($jsonMessage);
        }

        $scanLoginModel = ScanLoginModel::updateUserIsSureLogin($code,$type);
        if ($scanLoginModel == null){
            $jsonMessage->message = '确认登录失败';
            return $this->renderJSON($jsonMessage);
        }

        $jsonMessage->data = $scanLoginModel;
        $jsonMessage->success = true;
        return $this->renderJSON($jsonMessage);
    }


    /**
     * 创建code
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionCode()
    {
        $jsonMessage = new JsonMessage();
        $code = gen_uuid();

        $createLoginKey = ScanLoginModel::createLoginKey($code,self::SCAN_CODE_LOGIN);
        if ($createLoginKey == false){
            $jsonMessage->message = '生成二维码失败，请重试';
            return $this->renderJSON($jsonMessage);
        }

        $jsonMessage->success = true;
        $jsonMessage->data = $code;
        return $this->renderJSON($jsonMessage);
    }

}