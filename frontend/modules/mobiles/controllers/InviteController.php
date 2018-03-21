<?php
declare(strict_types=1);

namespace frontend\modules\mobiles\controllers;

use common\clients\XuemiMicroService;
use common\components\CaptchaAction;
use common\components\WebDataCache;
use common\models\DateTime;
use common\models\JsonMessage;
use common\models\pos\SeUserinfo;
use common\models\pos\SeInviteTeacher;
use frontend\components\BaseController;
use frontend\components\helper\ImagePathHelper;
use Yii;
use yii\web\HttpException;


/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-5-3
 * Time: 下午4:21
 */
class InviteController extends BaseController
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

    /**
     * 被邀请老师信息填写页面
     * @return string
     * @throws HttpException
     */
    public function actionInviteTeacher()
    {
        $inviteCode = (string)app()->request->get('invite-code');


        return $this->redirect(url('mobiles/invite/invite-teacher-v2', ['invite-code' => $inviteCode]));
    }

    /**
     * 获取用户邀请码
     * @return string
     */
    public function actionGetInviteCode()
    {
        $resultArray = [];
        $resultArray['resCode'] = '001';
        $userId = (int)app()->request->getParam('user-id');
        $isExistUser = SeUserinfo::isExistUser($userId);
        if ($isExistUser == false) {
            $resultArray['resMsg'] = '用户不存在';
            return $this->renderJSON($resultArray);
        }
        $inviteCode = WebDataCache::getUserInviteCode($userId);
        if ($inviteCode == '') {
            $resultArray['resMsg'] = '邀请码生成失败';
            return $this->renderJSON($resultArray);
        }
        $resultArray['resCode'] = '000';
        $resultArray['data']['code'] = $inviteCode;
        $resultArray['resMsg'] = '成功';
        return $this->renderJSON($resultArray);

    }

    /**
     * 保存被邀请人的信息
     * @return string
     */
    public function actionSaveInviteTeacher()
    {
        $jsonResult = new jsonMessage();
        $inviteeName = app()->request->post('inviteeName', '');
        $inviteePhone = app()->request->post('inviteePhone', '');
        $ip = Yii::$app->getRequest()->getUserIP();
        $inviteCode = (string)app()->request->post('inviteCode', '');


        if (trim($inviteeName) == '') {
            $jsonResult->message = '姓名不能为空';
            return $this->renderJSON($jsonResult);
        }

        if (strlen($inviteeName) > 20) {
            $jsonResult->message = '姓名长度过长';
            return $this->renderJSON($jsonResult);
        }

        if (trim($inviteePhone) == '') {
            $jsonResult->message = '联系方式不能为空';
            return $this->renderJSON($jsonResult);
        }

        $reg = '/^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$/';
        if (!preg_match($reg, $inviteePhone)) {
            $jsonResult->message = '请输入正确的手机号';
            return $this->renderJSON($jsonResult);
        }

        if (trim($inviteCode) == '') {
            $jsonResult->message = '请正确填写信息';
            return $this->renderJSON($jsonResult);
        }

        //根据code  查询userId
        $userId = WebDataCache::getUserIdByInviteCode($inviteCode);

        if ($userId == 0) {
            $jsonResult->message = '邀请人不存在';
            return $this->renderJSON($jsonResult);
        }
        $getInviteCode = WebDataCache::getUserInviteCode($userId);

        if ($getInviteCode != $inviteCode) {
            $jsonResult->message = '邀请码不正确';
            return $this->renderJSON($jsonResult);
        }

        //保存数据
        $time = date('Y-m-d H:i:s', time());
        $inviteModel = new SeInviteTeacher();
        $inviteModel->userId = $userId;
        $inviteModel->inviteCode = $inviteCode;
        $inviteModel->inviteeName = trim($inviteeName);
        $inviteModel->inviteePhone = $inviteePhone;
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


    /**
     * 给学生的一封信
     * @return string
     * @throws HttpException
     */
    public function actionStudentsLetter()
    {
        $inviteCode = (string)app()->request->get('invite-code');
        $classInviteCode = (string)app()->request->get('class-invite-code', '');

        //根据code  查询userId
        $userId = WebDataCache::getUserIdByInviteCode($inviteCode);
        if ($userId == 0) {
            throw new HttpException(404, '用户不存在！');
        }
        if ($classInviteCode == '') {
            throw new HttpException(404, '班级邀请码不存在！');
        }
        $subjectName = WebDataCache::getSubjectNameByUserId($userId);
        $trueName = WebDataCache::getUserTrueNameByUserId($userId);
        return $this->render('studentsLetter', ['subjectName' => $subjectName, 'trueName' => $trueName, 'classInviteCode' => $classInviteCode]);
    }

    /**
     * 分享页面(邀请老师页面)
     * @return string
     * @throws HttpException
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function actionShareInvite()
    {
        $userId = (int)app()->request->getParam('user-id');


        return $this->redirect(url('mobiles/invite/share-invite-v2', array('user-id' => $userId)));
    }


    /**
     * 邀请老师　分享出去的页面
     * @return string
     * @throws HttpException
     */
    public function actionInviteTeacherV2()
    {
        $inviteCode = (string)app()->request->get('invite-code');
        return $this->redirect(Yii::$app->params['weixin_auth']."/study/invite/invite-teacher?invite-code=".$inviteCode);
    }


    /**
     * 分享页面(邀请老师页面) app页面　v2
     * @return string
     * @throws HttpException
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function actionShareInviteV2()
    {
        $userId = (int)app()->request->getParam('user-id');

        $dateTimeModel = new DateTime();
        $beginTime = $dateTimeModel->lastMonthFirstDay;
        $endTime = $dateTimeModel->lastMonthLastDay;
        $beginMonthTime = date('Y-m-d H:i:s', time() - 2592000);
        $endTimeNow = date('Y-m-d H:i:s', time());
        $ruleCodes = 'pos-real-name-auth-invite,pos-perfect-user-info-invite';

        $isExistUser = SeUserinfo::isExistUser($userId);
        if ($isExistUser == false) {
            throw new HttpException(404, '用户不存在！');
        }

        $xuemiTotal = 0;
        $xuemiService = new XuemiMicroService();
        $userXuemiTotalResult = $xuemiService->getUserXuemiTotalByCodes($userId, $ruleCodes, $beginTime, $endTime);

        if ($userXuemiTotalResult->code == 200) {

            $userXuemiTotalModel = $userXuemiTotalResult->body;
            if ($userXuemiTotalModel != null) {
                $xuemiTotal = $userXuemiTotalModel->xueMi;
            }
        }

        $inviteArray = array();
        $userCurrentAccountsResult = $xuemiService->getUserCurrentAccountsByCodes($userId, $ruleCodes, $beginMonthTime, $endTimeNow);

        if ($userCurrentAccountsResult->code == 200) {
            $inviteArray = $userCurrentAccountsResult->body;
            if (count($inviteArray) != 0) {
                foreach ($inviteArray as $v) {
                    $v->contributorTrueName = WebDataCache::getUserTrueNameByUserId($v->contributorId);
                }
            }
        }

        return $this->render('shareInviteV2', ['inviteArray' => $inviteArray, 'xuemiTotal' => $xuemiTotal]);
    }




}