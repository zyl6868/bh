<?php
declare(strict_types = 1);
namespace common\clients\material;

use common\components\MicroServiceRequest;
use Httpful\Mime;
use Yii;

/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-11-13
 * Time: 下午8:20
 */
class ListService
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
        $this->uri = Yii::$app->params['microService'];
        $this->host = 'teach-res-service';
        $this->microServiceRequest = new MicroServiceRequest($this->host);
    }


    /**
     * 用户收藏列表
     * @param int $perPage
     * @param int $page
     * @param int $userId
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function userCollectList(int $perPage, int $page, int $userId)
    {
        $result = $this->microServiceRequest->get($this->uri . '/api/v1/material/list/collect/' . $userId . '?' . http_build_query(['per-page' => $perPage, 'page' => $page]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result;
    }

    /**
     * 更多推荐列表
     * @param int $perPage
     * @param int $page
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function boutiqueList(int $perPage, int $page)
    {
        $result = $this->microServiceRequest->get($this->uri . '/api/v1/material/list/boutique?' . http_build_query(['per-page' => $perPage, 'page' => $page]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result;
    }


}