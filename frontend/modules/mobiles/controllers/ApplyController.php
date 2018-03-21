<?php
declare(strict_types = 1);
namespace frontend\modules\mobiles\controllers;

use common\components\CaptchaAction;
use common\models\JsonMessage;
use common\models\pos\SeInviteTeacher;
use frontend\components\BaseController;
use Yii;


/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-6-16
 * Time: 下午4:21
 */
class ApplyController extends BaseController
{

    public $layout = 'lay_static';

    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => CaptchaAction::class,
                'backColor' => 0x55FF00,
                'maxLength' => 4,
                'height' => 40,
                'width' => 83,
                'minLength' => 4,
                'disturbCharCount' => 0

            ),
        );
    }

    public function actionApply(){

        return $this->render('applyUsing');
    }

    /**
     * 保存被邀请人的信息
     * @return string
     */
    public function actionSaveApplyTeacher()
    {
        $jsonResult = new jsonMessage();
        $applyName = app()->request->post('applyName', '');
        $applyPhone= app()->request->post('applyPhone', '');
        $ip = Yii::$app->getRequest()->getUserIP();


        if (trim($applyName) == '') {
            $jsonResult->message = '姓名不能为空';
            return $this->renderJSON($jsonResult);
        }

        if (strlen($applyName) >20 ) {
            $jsonResult->message = '姓名长度过长';
            return $this->renderJSON($jsonResult);
        }

        if (trim($applyPhone) == '') {
            $jsonResult->message = '联系方式不能为空';
            return $this->renderJSON($jsonResult);
        }

        $reg = '/^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$/';
        if(!preg_match($reg,$applyPhone)) {
            $jsonResult->message = '请输入正确的手机号';
            return $this->renderJSON($jsonResult);
        }

        //保存数据
        $time = date('Y-m-d H:i:s', time());
        $inviteModel = new SeInviteTeacher();
        $inviteModel->userId = 200;
        $inviteModel->inviteCode = '';
        $inviteModel->inviteeName = trim($applyName);
        $inviteModel->inviteePhone = $applyPhone;
        $inviteModel->IP = $ip;
        $inviteModel->createTime = $time;
        $inviteModel->updateTime = $time;
        if (!$inviteModel->save()) {
            $jsonResult->message = '申请失败,请重试';
            return $this->renderJSON($jsonResult);
        }
        $jsonResult->success = true;
        return $this->renderJSON($jsonResult);
    }

}