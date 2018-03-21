<?php
namespace mobileWeb\controllers;

use common\controller\YiiController;
use common\clients\UserLoginService;
use Exception;


use Yii;
use yii\base\UserException;
use yii\web\Cookie;
use yii\web\HttpException;
use yii\web\UnauthorizedHttpException;

/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-10-10
 * Time: 上午11:21
 */
class SiteController extends YiiController
{
    public function actionIndex()
    {


        die;

    }


    /**
     * This is the action to handle external exceptions.
     * @throws \yii\base\InvalidParamException
     */
    public function actionError()
    {
        $this->layout = false;

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
            $name =  Yii::t('yii', 'Error');
        }
        if ($code) {
            $name .= " (#$code)";
        }



        if ($exception instanceof UserException) {
            $message = $exception->getMessage();
        } else {
            $message = $this->defaultMessage ?: "";
        }

        $headerAccept = Yii::$app->getRequest()->getHeaders()->get('Accept');
        if (Yii::$app->getRequest()->getIsAjax() || $headerAccept == 'application/json, text/plain, */*'){
//            return "$name: $message";
            throw new UnauthorizedHttpException("请登陆");
        } else {
            return $this->render('error', ['code' => $code, 'name' => $name, 'message' => $message, 'exception' => $exception]);
        }


    }


    /**
     * Displays the login page
     * @throws \yii\base\InvalidParamException
     */
    public function actionLogin()
    {
        $this->layout = false;


        $token = app()->request->getQueryParam('token');


        if (empty($token)) {
            throw new UnauthorizedHttpException("请登陆");
        }

        try {
            $tokenInfo = \yii\helpers\Json::decode($token);
            $userId = isset($tokenInfo["uid"]) ? (int)$tokenInfo["uid"] : 0;;
            $userToken = isset($tokenInfo["token"]) ? $tokenInfo["token"] : '';
        } catch (\Throwable $e) {
            Yii::error("json不正确", 'app');
            throw new UnauthorizedHttpException("token错误.");
        }


        $userService = new UserLoginService();
        /** @var  $verifyTokenModel */
        $verifyTokenModel = $userService->accessToken($userId, $userToken);
        if ($verifyTokenModel->code != 200) {
            $body = $verifyTokenModel->body;

            Yii::error("用户验证身份失败，用户id为：" . $userId . ",用户token为：" . $userToken . ",错误信息：" . json_encode($body), 'app');
            throw new UnauthorizedHttpException("token错误.");
        }


        $authorization = base64_encode($token);
        $authCookie = new Cookie();
        $authCookie->name = 'auth';
        $authCookie->expire = 0;
        $authCookie->value = $authorization;

        $authCookie->httpOnly = false;
        Yii::$app->response->getCookies()->add($authCookie);

        $tokenCookie = new Cookie();
        $tokenCookie->name = 'token';
        $tokenCookie->expire = 0;
        $tokenCookie->value = $authorization;

        Yii::$app->response->getCookies()->add($tokenCookie);

        $headerAccept = Yii::$app->getRequest()->getHeaders()->get('Accept');
        if (Yii::$app->getRequest()->getIsAjax() || $headerAccept == 'application/json, text/plain, */*'){
            return true;
        }

        $retUrl = app()->request->getQueryParam('redirect_uri');


        if ($retUrl) {
            return $this->redirect($retUrl);
        }

//        // display the login form
        return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
    }

    /**
     * Displays the login page
     * @throws \yii\base\InvalidParamException
     */
    public function actionToLogin()
    {
        $this->layout = false;


//        // display the login form
        return $this->render("to_login");
    }


}
