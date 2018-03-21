<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-10-16
 * Time: 下午4:00
 */
namespace common\clients;

use common\components\MicroServiceRequest;
use common\components\WebDataKey;
use Httpful\Mime;
use Yii;
use yii\db\Exception;

class UserService
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
     * 获取用户默认的版本信息
     * @param integer $userId
     * @return array|object|string
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getTeacherBookVersion(int $userId)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/teacher/' . $userId . '/book/version')
            ->sendsType(Mime::JSON)
            ->expectsType(Mime::JSON)
            ->send();
        return $result;

    }


    /**
     * 保存用户默认的版本信息
     * @param int $userId
     * @param int $subjectId
     * @param int $versionId
     * @param int $departmentId
     * @param int $tomeId
     * @return \Httpful\associative|string
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function saveTeacherBookVersion(int $userId, int $subjectId, int $versionId, int $departmentId, int $tomeId)
    {
        $result = $this->microServiceRequest->post($this->uri . '/v1/teacher/book/version')
            ->body(http_build_query(['user-id' => $userId, 'subject-id' => $subjectId, 'version' => $versionId, 'department' => $departmentId, 'tome' => $tomeId]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result;

    }


    /**
     * 根据用户名查询用户信息
     * @param string $userName
     * @return \Httpful\associative|string
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getUserInfoByUserName(string $userName)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/user/info/user-name?'. http_build_query(['user-name' => $userName]))
            ->sendsType(Mime::JSON)
            ->send();
        return $result;

    }


    /**
     *验证用户访问权限　id和token是否匹配
     * @param int $userId
     * @param string $token
     * @return \Httpful\associative|string
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function verifyUserToken(int $userId,string $token)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/'.$userId.'/token/'.$token.'/verify')
            ->sendsType(Mime::JSON)
            ->send();
        return $result;

    }



}