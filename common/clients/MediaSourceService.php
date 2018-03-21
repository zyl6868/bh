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
use Httpful\Mime;
use Yii;

class MediaSourceService
{

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
        $this->uri = Yii::$app->params['mediaSource'];
        $this->host = 'mediafile-service';
        $this->microServiceRequest = new MicroServiceRequest($this->host);
    }

    /**
     * 获取资源信息
     * @param string $mediaId
     * @return \Httpful\associative|string
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    function getMediaSourceInfo(string $mediaId){
        $result = $this->microServiceRequest->get($this->uri . '/mfs/' . $mediaId .'/info')
            ->sendsType(Mime::JSON)
            ->send();
        return $result->body;
    }

}