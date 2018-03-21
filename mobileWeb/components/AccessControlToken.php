<?php
/**
 * Created by PhpStorm.
 * User: yangjie
 * Date: 2017/11/16
 * Time: 下午7:29
 */

namespace mobileWeb\components;


use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class AccessControlToken extends AccessControl
{

    protected function denyAccess($user)
    {

        if ($user->getIsGuest()) {

            $authcooker = Yii::$app->request->cookies->getValue('token');

            if ($authcooker == null) {
                $this->loginRequired($user);
            }



            /** @var \yii\web\User $user */

        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }


    /**
     * @param \yii\web\User $user
     * @param bool $checkAjax
     * @param bool $checkAcceptHeader
     * @return $this
     * @throws ForbiddenHttpException
     */
    public function loginRequired($user, $checkAjax = true, $checkAcceptHeader = true)
    {
        $request = Yii::$app->getRequest();
        $canRedirect = !$checkAcceptHeader;
        if ($user->enableSession
            && $request->getIsGet()
            && (!$checkAjax || !$request->getIsAjax())
            && $canRedirect
        ) {
            $user->setReturnUrl($request->getUrl());
        }
        if ($user->loginUrl !== null) {
            $loginUrl = (array)$user->loginUrl;
            if ($loginUrl[0] !== Yii::$app->requestedRoute) {


                $loginUrl = $user->loginUrl;
                $gologinUrl = '';

                if (is_array($loginUrl) && isset($loginUrl[0])) {
                    // ensure the route is absolute
                    $gologinUrl = '/' . ltrim($loginUrl[0], '/');
                } else {
                    $gologinUrl = $loginUrl;
                }

                return Yii::$app->getResponse()->redirect($gologinUrl . '?' . $_SERVER['QUERY_STRING'] . '&redirect_uri=' . urlencode($request->url));
            }
        }
        throw new ForbiddenHttpException(Yii::t('yii', 'Login Required'));
    }


}