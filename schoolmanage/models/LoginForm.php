<?php
namespace schoolmanage\models;

use frontend\components\WebUserIdentity;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $verifyCode;
    private $_user = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'verifyCode'], 'required'],


            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['verifyCode', 'captcha'],
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
//            if (!$user || !$user->validatePassword($this->password)) {
//                $this->addError($attribute, 'Incorrect username or password.');
//            }
            if ($user) {
                if (!$user->validatePassword($this->password)) {
                    $this->addError($attribute, '密码不正确！');
                }
            } else {

                $this->addError('username', '用户名不存在!');

            }
        }
    }
    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->_user = new WebUserIdentity($this->username, $this->password);
            if ($this->_user->authenticate() > 0) {
                switch ($this->_user->errorCode) {
                    case WebUserIdentity::ERROR_USERNAME_INVALID :
                        $this->addError('username', '用户名不存在!');
                        break;
                    case WebUserIdentity::ERROR_USER_NOT_ACTIVE :
                        $this->addError('username', '用户被锁或未激活!');
                        break;
                    default :
                        $this->addError('username', '用户名或密码错误');
                        break;
                }
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
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * Logs in a user using the provided username and password.
     *
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

    public function attributeLabels()
    {
        return [
            'username' => '用户名',

            'password' => '密码',
            // 'verifyCode' => 'Verification Code',
            'verifyCode' => '验证码',//去掉默认验证码名字
        ];
    }
}
