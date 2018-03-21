<?php
declare(strict_types=1);

namespace frontend\models;

use common\clients\UserService;
use common\components\WebDataCache;
use common\components\WebDataKey;
use common\models\pos\SeUserinfo;
use PhpOffice\PhpWord\IOFactory;
use Yii;

/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 18-3-16
 * Time: 下午1:58
 */
class ScanLoginModel
{
    public $code;
    public $userName;
    public $token;
    public $type;
    public $isSureLogin;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [

            [['code', 'userName', 'token'], 'string', 'max' => 200],
            [['type', 'isSureLogin'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => '唯一code码',
            'userName' => '用户名',
            'token' => '用户token',
            'type' => '扫码类型',
            'isSureLogin' => '是否确认登录',
        ];
    }

    /**
     * 保存用户扫码登录信息
     * @param string $code
     * @param string $token
     * @param string $userName
     * @param int $type
     * @return ScanLoginModel|null
     */
    public static function saveScanLoginCodeUser(string $code, string $token, string $userName, int $type = 1003)
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::SCAN_LOGIN_CODE_USER_INFO . $code . '_' . $type;

        $scanLoginModel = new ScanLoginModel();
        $scanLoginModel->code = $code;
        $scanLoginModel->token = $token;
        $scanLoginModel->userName = $userName;
        $scanLoginModel->type = $type;
        $scanLoginModel->isSureLogin = 0;

        $result = $cache->set($key, $scanLoginModel, 180);
        if ($result == false) {
            Yii::error('保存用户扫码信息失败，code为：' . $code . ',token为:' . $token . ',userMame为：' . $userName);
            return null;
        }
        return $scanLoginModel;

    }

    /**
     * 根据code和type　查询用户的扫码登录信息
     * @param string $code
     * @param int $type
     * @return mixed|null
     */
    public static function getScanLoginCodeUser(string $code, int $type = 1003)
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::SCAN_LOGIN_CODE_USER_INFO . $code . '_' . $type;
        $scanLoginModel = $cache->get($key);

        if ($scanLoginModel == false) {
            return null;
        }

        return $scanLoginModel;
    }


    /**
     *用户确认登录
     * @param string $code
     * @param int $type
     * @return mixed|null
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public static function updateUserIsSureLogin(string $code, int $type = 1003)
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::SCAN_LOGIN_CODE_USER_INFO . $code . '_' . $type;
        $scanLoginModel = self::getScanLoginCodeUser($code, $type);
        if ($scanLoginModel == null) {
            Yii::error('确认用户登录失败，没有对应的code值，code为：' . $code);
            return null;
        }
        //验证用户是否正确
        $userService = new UserService();
        $userName = $scanLoginModel->userName;
        $token = $scanLoginModel->token;
        $userInfo = $userService->getUserInfoByUserName($userName);
        if ($userInfo->code != 200) {
            Yii::error('确认用户登录失败，查询用户失败，错误信息是' . $userInfo->body->message);
            return null;
        }


        $userInfoModel = $userInfo->body;
        $userId = $userInfoModel->userId;

        $verifyUserToken = $userService->verifyUserToken($userId,$token);
        if ($verifyUserToken->code != 200){
            Yii::error('确认用户登录失败,验证用户token失败');
            return null;
        }
        $scanLoginModel->isSureLogin = 1;
        $result = $cache->set($key, $scanLoginModel, 600);
        if ($result == false) {
            Yii::error('确认用户登录失败，修改登录状态失败，code为：' . $code);
            return null;
        }
        return $scanLoginModel;

    }



    /**
     * 创建一个扫码登录的key
     * @param string $code
     * @param int $type
     * @return bool
     */
    public static function createLoginKey(string $code,int $type = 1003)
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::SCAN_LOGIN_CODE_USER_INFO . $code . '_' . $type;

        $result = $cache->set($key, "", 180);
        if ($result == false) {
            Yii::error('保存code失败，code为：' . $code);
            return false;
        }
       return true;

    }
}