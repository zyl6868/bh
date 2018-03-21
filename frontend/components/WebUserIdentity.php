<?php

namespace frontend\components;

use frontend\services\pos\pos_UserInfoLoginService;
use yii\web\IdentityInterface;


/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class WebUserIdentity implements IdentityInterface
{

    /**
     *
     * @var int Id of the User
     */
    private $_id;

    /**
     *
     * @var CActiveRecord current User Model
     */
    private $_model;

    const ERROR_USER_NOT_ACTIVE = 3;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $userInfoLogin = new pos_UserInfoLoginService();
        $result = $userInfoLogin->userPhoneLogin($this->username, $this->password);

        if ($result[0] == '100010')
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        elseif ($result[0] == '100011')
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        elseif ($result[0] == '100012')
            $this->errorCode = self::ERROR_USER_NOT_ACTIVE;
        else {
            $this->errorCode = self::ERROR_NONE;
            $this->_id = $result[1]->userID;
            $this->_model = \common\models\pos\SeUserinfo::findOne($result[1]->userID);
            $this->username = $result[1]->nickName;
            $this->setState("sessionToken", $result[1]->sessionToken);

        }

        return $this->errorCode;
    }

    /**
     * Return the property _id of the class
     * @return bigint
     */
    public function getId()

    {
        return $this->_id;
    }

    /**
     *
     * Return the _model of the class
     * @return CActiveRecord
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}