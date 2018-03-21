<?php
namespace frontend\controllers;

use common\clients\OrganizationService;
use common\models\JsonMessage;
use common\models\pos\SeUserControl;
use common\models\pos\SeUserinfo;
use common\clients\SmsManageService;
use frontend\components\BaseController;
use common\components\WebDataKey;
use Httpful\Exception\ConnectionErrorException;
use Yii;
use yii\filters\AccessControl;
use common\components\CaptchaAction;

class RegisterController extends BaseController
{
    /**
     * 验证类型  1验证  2 说明
     */
    const TYPE_VALIDATE = 1;

    /**
     *平台来源  1 web  2 手机
     */
    const SOURCE_TYPE_WEB = 1;


    public $layout = '@app/views/layouts/lay_register';

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

            ),
        );
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [

                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['send-verify-code','verify-img-code','captcha'],
                        'roles' => ['?'],
                    ],


                ],
            ]
        ];
    }


    /**
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionVerifyImgCode(){
        $jsonResult = new JsonMessage();
        $verifyImageCode = Yii::$app->request->post('imgverifycode','');
        if (empty($verifyImageCode)) {
            $jsonResult->message = '请填写图片验证码';
            return $this->renderJSON($jsonResult);
        }

        $flag = $this->createAction('captcha')->validate($verifyImageCode, false);
        if ($flag == false) {
            $jsonResult->message = '图片验证码错误';
            return $this->renderJSON($jsonResult);
        }else{
            $jsonResult->success = true;
        }
        return $this->renderJSON($jsonResult);
    }

    /**
     * 发送验证码
     * @return string
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\base\ExitException
     */
    public function actionSendVerifyCode()
    {
        $phoneNum = $_POST['phoneNum'];
        $jsonResult = new JsonMessage();

        //phone is empty
        if (empty($phoneNum)) {
            $jsonResult->message = '请填写手机号';
            return $this->renderJSON($jsonResult);
        }
        $cachekey = WebDataKey::REGISTER_SEND_VERIFYCODE . $phoneNum;
        $totleTime = \Yii::$app->cache->get($cachekey);
        if ($totleTime == true) {
            $jsonResult->success = false;
            $jsonResult->message = '一分钟内不能重复获取验证码';
            return $this->renderJSON($jsonResult);
        }

        $useInfo = SeUserinfo::find()->where(['bindphone' => $phoneNum])->one();
        if (!$useInfo) {
            $result = $this->SendCode($phoneNum);

            if ($result->meta_data['http_code'] == 200) {
                $jsonResult->success = true;
                $jsonResult->code = 200;
                $jsonResult->message = '发送成功';
            } else {
                $jsonResult->success = false;
                $jsonResult->message = $result->body->message;
            }
        } else {
            $jsonResult->message = '该用户名或手机号已存在';
        }

        return $this->renderJSON($jsonResult);

    }

    /**
     * 发送验证码的数据库操作
     * @param $phoneNum
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function SendCode($phoneNum)
    {
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= random_int(0, 9);
        }

        $type = self::TYPE_VALIDATE;     //1 验证  2 说明
        $sourceType = self::SOURCE_TYPE_WEB;    //1 web  2手机
        $smsResult = SmsManageService::getCode($type, $phoneNum, $sourceType, $code);
        if ($smsResult->meta_data['http_code'] == 200) {
            $cacheKey = WebDataKey::REGISTER_SEND_VERIFYCODE . $phoneNum;
            \Yii::$app->cache->set($cacheKey,true,60);

            //将验证码插入数据库
            $userModel = SeUserControl::find()->where(['phoneReg' => $phoneNum])->one();
            if ($userModel) {
                $userModel->activateMailCode = $code;
                $userModel->generateCodeTime = time() * 1000;
                $userModel->save(false);
            } else {
                $UserModel = new SeUserControl();
                $UserModel->phoneReg = $phoneNum;
                $UserModel->activateMailCode = $code;
                $UserModel->generateCodeTime = time() * 1000;
                $UserModel->save(false);
            }
        }
        return $smsResult;

    }

    /**
     * 注册后加入班级输入邀请码 页面
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionJoinClass()
    {
        $this->userRedirectClassHome();
        $this->layout = 'lay_join_class';

        return $this->render('joinClass');
    }

    /**
     * 注册后 加入班级
     * @return string
     * @throws \yii\base\ExitException
     * @throws ConnectionErrorException
     */
    public function actionRegisterJoinClass()
    {
        $jsonResult = new JsonMessage();
        $userId = user()->id;
        $code = app()->request->get('code');
        $model = new OrganizationService();
        $result = $model->AddClass($userId, $code);
        if ($result->success) {
            $jsonResult->success = true;
            $jsonResult->data = $result->data;
            $jsonResult->message = $result->message;
        } else {
            $jsonResult->success = false;
            $jsonResult->message = $result->message;
        }
        return $this->renderJSON($result);
    }


}
