<?php

namespace frontend\controllers;


use common\clients\heEducation\heEducationService;
use common\clients\UserService;
use common\models\heEducation\SeHeEduAuth;
use common\models\JsonMessage;
use common\models\pos\SeUserControl;
use common\models\pos\SeUserinfo;
use common\clients\SmsManageService;
use frontend\components\BaseController;
use common\components\WebDataKey;
use frontend\components\User;
use frontend\models\LoginForm;
use frontend\services\pos\pos_MessageSentService;
use frontend\services\pos\pos_UserRegisterService;
use Yii;
use yii\base\Exception;
use yii\base\UserException;
use yii\web\HttpException;
use yii\captcha\CaptchaAction;

/**
 * Class SiteController
 */
class SiteController extends BaseController
{
    /**
     * @var string
     */
    public $layout = '@app/views/lay_site';

    /**
     * 验证类型  1验证  2 说明
     */
    const TYPE_VALIDATE = 1;

    /**
     *平台来源  1 web  2 手机
     */
    const SOURCE_TYPE_WEB = 1;

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => CaptchaAction::class,
                'backColor' => 0xFFFFFF,
                'maxLength' => 4,
                'height' => 40,
                'width' => 83,
                'minLength' => 4,

            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     * @throws \yii\base\InvalidParamException
     */
    public function actionIndex()
    {
        $this->layout = false;
        if ($this->isLogin()) {
            $this->userDefaultRedirectUrl();
        }

        return $this->render('homePage');

    }


    /**
     * Displays the login page
     * @throws \yii\base\InvalidParamException
     */
    public function actionLogin()
    {
        $this->layout = '@app/views/layouts/blank';


        if ($this->isLogin()) {
            $this->userDefaultRedirectUrl();
        }

        $model = new LoginForm();

        $username = app()->request->getQueryParam('username');
        if ($username != null) {
            $model->userName = $username;
        }
        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];

            if ($model->validate() && $model->login()) {
                //根据type跳转到不同页面
                $this->userDefaultRedirectUrl();
            }
        }

        return $this->render('login', array('model' => $model));
    }

    public function actionScanCodeLogin()
    {
        $jsonMessage = new JsonMessage();
        $userName = app()->request->post('userName');
        $userService = new UserService();
        $userResult = $userService->getUserInfoByUserName($userName);
        if ($userResult->code != 200) {
            $jsonMessage->message = "用户查询失败，请重试";
            return $this->renderJSON($jsonMessage);
        }
        $userModel = $userResult->body;
        $userId = $userModel->userId;
        $loginUser = User::findIdentity($userId);

        Yii::$app->user->login($loginUser, 2592000);

        $url = $this->userRedirectFindClass();
        if ($url == '') {
            $url = $this->userRedirectClassHome();
        }

        $jsonMessage->success = true;
        $jsonMessage->data = $url;
        return $this->renderJSON($jsonMessage);

    }

    /**
     * This is the action to handle external exceptions.
     * @throws \yii\base\InvalidParamException
     */
    public function actionError()
    {
        $this->layout = 'main';

        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            return '';
        }

        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
        } else {
            $code = $exception->getCode();
        }
        if ($exception instanceof Exception) {
            $name = $exception->getName();
        } else {
            $name = $this->defaultName ?: Yii::t('yii', 'Error');
        }
        if ($code) {
            $name .= " (#$code)";
        }

        if ($exception instanceof UserException) {
            $message = $exception->getMessage();
        } else {
            $message = $this->defaultMessage ?: Yii::t('yii', 'An internal server error occurred.');
        }

        if (Yii::$app->getRequest()->getIsAjax()) {
            return "$name: $message";
        } else {


            if (false) {
                return $this->render('localerror', ['name' => $name, 'message' => $message, 'exception' => $exception]);

            } else
                if ($code == 403) {
                    return $this->render('error403', ['name' => $name, 'message' => null, 'exception' => $exception]);
                } else if ($code == 404) {
                    return $this->render('error', ['name' => $name, 'message' => $message, 'exception' => $exception]);
                } else {
                    return $this->render('error', ['name' => $name, 'message' => null, 'exception' => $exception]);
                }

        }

    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        app()->user->logout();
        return $this->redirect(app()->homeUrl);
    }

    /**
     *找回密码
     * @throws \yii\base\InvalidParamException
     */
    public function actionGetPass()
    {
        return $this->render('getPass');
    }

    /**
     * 手机找回密码
     * @throws \yii\base\ExitException
     * @throws \yii\base\InvalidParamException
     */
    public function actionRecoverPassword()
    {

        $this->layout = '@app/views/layouts/n_lay_register';

        $jsonResult = new JsonMessage();

        $this->createAction('captcha')->getVerifyCode(true);

        if (isset($_POST['form1'])) {
            $verifyNum = $_POST['form1']['verifyNum'];      //手机号
            $verifyName = $_POST['form1']['regName'];       //用户名
            $verifyCode = $_POST['form1']['verifyCode'];    //手机验证码

            //judge phone num is exist
            $phoneExist = SeUserinfo::find()->where(['phoneReg' => $verifyName, 'bindphone' => $verifyNum])->one();
            if ($phoneExist) {
                $userControl = SeUserControl::find()->where(['userID' => $phoneExist->userID])->one();
                $activateCode = $userControl->activateMailCode;
                if ($activateCode == $verifyCode) {
                    $jsonResult->success = true;
                    $jsonResult->data = ['phone' => $verifyNum, 'regName' => $verifyName, 'code' => $verifyCode, 'regUserId' => $phoneExist->userID];
                } else {
                    $jsonResult->message = '验证码错误!';
                }
            } else {
                $jsonResult->message = '该用户名或手机号不存在!';
            }

            return $this->renderJSON($jsonResult);
        }

        if (isset($_POST['form2'])) {
            $password = $_POST['form2']['password'];
            $phonePwd = $_POST['form2']['phonePwd'];
            $code = $_POST['form2']['code'];
            $regUserId = $_POST['form2']['regUserId'];

            $userControl = SeUserControl::find()->where(['userID' => $regUserId])->one();
            if ($userControl && $userControl->activateMailCode == $code) {

                $userInfo = SeUserinfo::find()->where(['userID' => $regUserId, 'bindphone' => $phonePwd])->one();

                if ($userInfo) {
                    $userInfo->passWd = strtoupper(md5($password));
                    if ($userInfo->save(false)) {
                        $jsonResult->success = true;
                    } else {
                        $jsonResult->message = '重置密码失败,请重置!';
                    }
                } else {
                    $jsonResult->message = '重置密码失败,请重置!';
                }

            } else {
                $jsonResult->message = '重置密码失败,请重置!';
            }

            return $this->renderJSON($jsonResult);
        }

        return $this->render('recoverpassword');

    }

    //发送验证码

    /**
     * @return string
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \yii\base\ExitException
     */
    public function actionGetResetPasswdTolkenPhone()
    {
        $phoneReg = $_POST['phoneReg'];
        $verifyImageCode = $_POST['verifyCodeImage'];
        $regName = $_POST['regName'];
        $jsonResult = new JsonMessage();

        //regName is empty
        if (empty($regName)) {
            $jsonResult->message = '请填写用户名';
            $jsonResult->code = 3;
            return $this->renderJSON($jsonResult);
        }

        //phone is empty
        if (empty($phoneReg)) {
            $jsonResult->message = '请填写手机号';
            $jsonResult->code = 1;
            return $this->renderJSON($jsonResult);
        }

        //ImageCode is empty
        if (empty($verifyImageCode)) {
            $jsonResult->message = '请填写图片验证码';
            $jsonResult->code = 2;
            return $this->renderJSON($jsonResult);
        }

        //imageCode is false
        $flag = $this->createAction('captcha')->validate($verifyImageCode, false);
        if (empty($flag)) {
            $jsonResult->code = 2;
            $jsonResult->message = '图片验证码错误';
            return $this->renderJSON($jsonResult);
        }

        //catch
        $cachekey = WebDataKey::RESETPHONEMESSAGE . $phoneReg;
        $totleTime = \Yii::$app->cache->get($cachekey);
        if (isset($totleTime) && !empty($totleTime)) {
            $jsonResult->message = '一分钟内不能重复获取验证码';
            $jsonResult->code = 1;
            return $this->renderJSON($jsonResult);
        }

        //judge phone num is exist
        $useInfo = SeUserinfo::find()->where(['phoneReg' => $regName, 'bindphone' => $phoneReg])->one();
        if ($useInfo) {
            $result = $this->SendCode($useInfo);
            if ($result) {
                $jsonResult->success = true;
                $jsonResult->code = 200;
                $jsonResult->message = '发送成功';
                $times = time() + 60;
                Yii::$app->cache->set($cachekey, $times, 60);
            } else {
                $jsonResult->success = false;
                $jsonResult->message = '由于网络等原因，短信发送失败';
            }
        } else {
            $jsonResult->message = '该用户名或手机号不存在';
            $jsonResult->code = 1;
        }

        return $this->renderJSON($jsonResult);

    }


    /**
     *     发送验证码的数据库操作
     * @param SeUserinfo $userModel
     * @return bool
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function SendCode($userModel)
    {

        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= random_int(0, 9);
        }

        $UserModel = SeUserControl::find()->where(['userID' => $userModel->userID])->one();
        if ($UserModel == null) {
            $UserModel = new SeUserControl();
            $UserModel->userID = user()->id;
            $UserModel->phoneReg = $userModel->phoneReg;
        }

        $UserModel->activateMailCode = $code;
        $UserModel->generateCodeTime = time() * 1000;

        if ($UserModel->save(false)) {
            $type = self::TYPE_VALIDATE;     //1 验证  2 说明
            $sourceType = self::SOURCE_TYPE_WEB;    //1 web  2手机
            $smsResult = SmsManageService::getCode($type, $userModel->bindphone, $sourceType, $code);
            if ($smsResult->meta_data['http_code'] == 200) {
                return true;
            }

        }
        return false;

    }


    /**
     * 重置密码
     * @param $key
     * @return string|\yii\web\Response
     * @throws \Camcima\Exception\InvalidParameterException
     * @throws \yii\base\InvalidParamException
     */
    public function actionResetPass($key)
    {
        $key = trim($key);
        $pos_UserRegisterService = new pos_UserRegisterService();
        $email = $pos_UserRegisterService->checkResetPasswdTolken($key);
        $message = '';
        if (empty($email)) {
            return $this->render('resetpass', ['email' => $email]);

        }

        if (app()->request->isPost) {
            $password = app()->request->post('password');
            if ($pos_UserRegisterService->resetPassWord($key, $password)) {
                return $this->redirect(['login']);
            } else {
                $message = '执行错误';
            }
        }
        return $this->render('resetpass', ['email' => $email, 'message' => $message]);
    }

    /**
     * 异步加载网站头部消息数据
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionSiteHeaderMessage()
    {
        $obj = new pos_MessageSentService();

        $result = $obj->stasticUserMessage(user()->id);
        $sumCnt = empty($result->sumCnt) ? 0 : $result->sumCnt;
        $priMsg = empty($result->priMsg) ? 0 : $result->priMsg;
        $notice = empty($result->notice) ? 0 : $result->notice;
        $sysMsg = empty($result->sysMsg) ? 0 : $result->sysMsg;
        $jsonResult = new JsonMessage();
        $jsonResult->data = ['sumCnt' => $sumCnt, 'priMsg' => $priMsg, 'notice' => $notice, 'sysMsg' => $sysMsg];
        return $this->renderJSON($jsonResult);
    }

    /**
     * 加载app下载页
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionDownloadApp()
    {
        $this->layout = false;
        return $this->render('download-app');
    }

//    public function actionHeTest()
//    {
//
//        $uid = app()->request->get('uid');
//        $parameters = [
//            'uid' => $uid,
//            'time' => gettimeofday(true),
//            'beiyong' => '',
//        ];
//
//        $s = '';
//        foreach ($parameters as $key => $value) {
//            $s .= $key . '=' . $value . '&';
//        }
//
//
//        $heEducationService = new heEducationService();
//        echo $s . '&sign=' . $heEducationService->ToSign($parameters);
//
//
//    }


    /**
     * 和教育用户信息授权
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function actionHeAuth()
    {
        $this->layout = 'lay_he_edu';

        $time = Yii::$app->request->get('time', 0);
        $uid = Yii::$app->request->get('uid', 0);
        $beiyong = Yii::$app->request->get('beiyong', null);
        $sign = Yii::$app->request->get('sign', '');

        $heEducationService = new heEducationService();
        $params = ['time' => $time, 'uid' => $uid, 'beiyong' => $beiyong, 'sign' => $sign];

        $message = '';

        if (!$heEducationService->verificationInput($params)) {
            $message = '验证用户信息失败';
            return $this->render('he_auth', ['message' => $message]);
        }

        $modelSeHeModel = $heEducationService->getLoginUser((int)$uid);

        if ($modelSeHeModel != null) {
            Yii::$app->user->login($modelSeHeModel, 3600 * 24);
            $this->userDefaultRedirectUrl();
        }


        return $this->render('he_auth', ['message' => $message]);

    }

    public function actionHealth()
    {
        $this->layout = false;
        echo "ok";
        return;
    }

}
