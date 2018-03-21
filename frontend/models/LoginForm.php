<?php
namespace frontend\models;

use frontend\components\User;
use Yii;
use yii\base\Model;

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends Model
{
    public $userName;
    public $passwd;
    public $rememberMe;

    private $_user = false;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return [
            // username and password are required
            [['userName'], 'required', 'message' => '用户名不能为空！'],
            [[ 'passwd'], 'required', 'message' => '密码不能为空！'],
//            ['userName', 'string', 'max' => 30],
            [['rememberMe'], 'boolean'],
//            ['passwd', 'string', 'min' => 6, 'max' => 50],
            [['passwd'], 'validatePassword'],
        ];
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->_user = new WebUserIdentity($this->userName, $this->passwd);
           if ($this->_user->authenticate() > 0) {
                switch ($this->_user->errorCode) {
                    case WebUserIdentity::ERROR_USERNAME_INVALID :
                        $this->addError('userName', '用户名不存在!');
                        break;
                    case WebUserIdentity::ERROR_USER_NOT_ACTIVE :
                        $this->addError('userName', '用户被锁或未激活!');
                        break;
                    default :
                        $this->addError('userName', '用户名或密码错误');
                        break;
                }
            }

        }
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if ($user) {
                if (!$user->validatePassword($this->passwd)) {
                    $this->addError($attribute, '密码不正确！');
                }
            } else {

                $this->addError('userName', '用户名不存在!');

            }


        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername(str_replace(" ","",$this->userName));
        }

        return $this->_user;
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'userName' => '用户名',
            'passwd' => '密码',
        ];
    }

}
