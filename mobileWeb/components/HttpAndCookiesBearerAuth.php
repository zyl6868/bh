<?php
/**
 * Created by PhpStorm.
 * User: yangjie
 * Date: 2017/11/16
 * Time: 下午3:19
 */

namespace mobileWeb\components;


use yii\filters\auth\AuthMethod;

class HttpAndCookiesBearerAuth extends AuthMethod

{
    /**
     * @var string the HTTP authentication realm
     */
    public $realm = 'api';


    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get('Authorization');
        if ($authHeader !== null && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $identity = $user->loginByAccessToken($matches[1], get_class($this));
            if ($identity === null) {
                $this->handleFailure($response);
            }
            return $identity;
        }




        $authcooker = $request->cookies->getValue('token');

        if ($authcooker !== null) {
            $identity = $user->loginByAccessToken($authcooker, get_class($this));
            if ($identity === null) {
                $this->handleFailure($response);
            }

            return $identity;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function challenge($response)
    {
        $response->getHeaders()->set('WWW-Authenticate', "Bearer realm=\"{$this->realm}\"");
    }

}

