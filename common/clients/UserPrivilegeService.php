<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-4-20
 * Time: 11:00
 */
namespace common\clients;

use common\components\MicroServiceRequest;
use common\components\WebDataKey;
use Httpful\Mime;
use Yii;
use yii\db\Exception;

class UserPrivilegeService
{
    /**
     * @var null
     */
    private $uri = null;
    private $microServiceRequest = null;
    private $host = null;

    /**
     * TestMicroService constructor.
     */
    public function __construct()
    {
        $this->uri = Yii::$app->params['microService'];
        $this->host = 'user-base-service';
        $this->microServiceRequest = new MicroServiceRequest($this->host);
    }


    /**
     * 获取特权勋章
     * @param integer $userID
     * @return array|object|string
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getUserPrivilege(int $userID)
    {
        try{
            $result= $this->microServiceRequest->get($this->uri. '/users/privilege-status?' . http_build_query(['user-id' => $userID]))
                ->sendsType(Mime::JSON)
                ->send()
                ->body;
        }catch (Exception $e){
            Yii::error('特权用户查询失败：' . $userID . '---' . $e->getMessage());
            $result = [];
        }
        return  $result;

    }

    /**
     *获取特权勋章缓存
     * @param int $userID
     * @return bool|mixed
     */
    public function getUserPrivilege_cache(int $userID)
    {

        if (empty($userID)) {
            return 0;
        }

        $cache = Yii::$app->cache;
        $key = WebDataKey::PRIVILEGE_USER_KEY . $userID;
        $privilegeStatus = $cache->get($key);

        if ($privilegeStatus === false) {

            $result = $this->getUserPrivilege($userID);

            if (count($result) !== 0) {

                $firstPrivilegeData = from($result)->firstOrDefault();
                if ($firstPrivilegeData !== null) {

                    $privilegeStatus = (int)$firstPrivilegeData->privilegeStatus;
                    if ($privilegeStatus == 1) {
                        $time = strtotime(date('Y-m-d 23:59:59'))-time();
                    }else{
                        $time = 120;
                    }

                    $cache->set($key, $privilegeStatus, $time);
                }
            }

        }

        return $privilegeStatus;

    }
}