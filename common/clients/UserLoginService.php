<?php
namespace common\clients;
use common\components\MicroServiceRequest;
use Httpful\Mime;
use Yii;

/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-8-2
 * Time: 下午5:17
 */
class UserLoginService{

    /**
     * 1 班海web
     */
    const BANHAI_WEB = 1 ;
    /**
     * @var null
     */
    private $uri = null;
    private $microServiceRequest = null;
    private $host = null;

    /**
     * XuemiMicroService constructor.
     */
    public function __construct()
    {
        $this->uri = Yii::$app->params['microService'];
        $this->host = 'user-base-service';
        $this->microServiceRequest = new MicroServiceRequest($this->host);
    }

    /**
     * 用户登录记录
     * @param integer $userId
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function userLoginRecord(int $userId){

        $ip = Yii::$app->getRequest()->getUserIP();
        $time = date(DATE_ISO8601);
        $terminal = self::BANHAI_WEB;

        $result = $this->microServiceRequest->post($this->uri.'/v1/user/'.$userId.'/record')
            ->body(http_build_query(['ip' => $ip, 'time' => $time,'terminal'=>$terminal]))
            ->sendsType(Mime::FORM)
            ->send();

        return $result->body;
    }

    /**
     * 获取用户的accessToken
     * @param int $userId 用户id
     * @param string $accessToken accessToken
     * @return array|object|string
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function accessToken(int $userId, string $accessToken)
    {
        $result = $this->microServiceRequest->get(Yii::$app->params['microService'] . "/v1/" . $userId . "/token/" . $accessToken . "/verify")
            ->expectsType(Mime::JSON)
            ->send();
        return $result;

    }
}