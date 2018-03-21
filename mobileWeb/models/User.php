<?php

namespace mobileWeb\models;

use common\models\pos\SeUserinfo;
use common\clients\UserLoginService;
use Yii;
use yii\web\HttpException;

class User extends SeUserinfo implements \yii\web\IdentityInterface
{
    public function __construct(array $config = [])
    {
        parent::__construct($config);

    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $userInfoModel = self::getUserDetails($id);
        if ($userInfoModel != null && $userInfoModel->type == 1) {
            return $userInfoModel;
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $tokenInfo = json_decode(base64_decode($token));
        $userId = isset($tokenInfo->uid) ? (int)$tokenInfo->uid : 0;;
        $userToken = isset($tokenInfo->token) ? $tokenInfo->token : '';
        if ($userId == 0 || $userToken == ''){
            return null;
        }
        $userService = new UserLoginService();
        /** @var  $verifyTokenModel */
        $verifyTokenModel = $userService->accessToken($userId,$userToken);
        if ($verifyTokenModel->code != 200){
            $body = $verifyTokenModel->body;
            Yii::error("用户验证身份失败，用户id为：".$userId.",用户token为：".$userToken.",错误信息：".json_encode($body),'app');
            throw new \yii\web\UnauthorizedHttpException("token错误.");
        }

        return self::getUserDetails($userId);
        //return static::findOne(['access_token' => $token]);

    }

    /**
     * Finds user by username
     *
     * @param  string $username
     * @return static|null
     */
    public static function findByBanhaiUser()
    {


        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->userID;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return true;
    }


    public function loginRequired($checkAjax = true, $checkAcceptHeader = true)
    {
        $request = Yii::$app->getRequest();
        $canRedirect = !$checkAcceptHeader || $this->checkRedirectAcceptable();
        if ($this->enableSession
            && $request->getIsGet()
            && (!$checkAjax || !$request->getIsAjax())
            && $canRedirect
        ) {
            $this->setReturnUrl($request->getUrl());
        }
        if ($this->loginUrl !== null) {
            $loginUrl = (array) $this->loginUrl;
            if ($loginUrl[0] !== Yii::$app->requestedRoute) {
                return Yii::$app->getResponse()->redirect($this->loginUrl);
            }
        }
        throw new ForbiddenHttpException(Yii::t('yii', 'Login Required'));
    }




}
