<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/8/6
 * Time: 17:40
 */

namespace common\clients;


use Httpful\Mime;
use Httpful\Request;
use Yii;

/**
 *广告服务管理
 * Class AdManageService
 * @package common\clients
 */
class AdManageService
{

    /**
     * @var null
     */
    private $uri = null;

    /**
     * AdManageService constructor.
     */
   public  function __construct()
    {
        $this->uri = Yii::$app->params['banhai_webService'];
    }


    /**
     * 调用后台广告服务
     * @param $placeCode
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    private function adManage($placeCode)
    {

        $result = Request::get($this->uri . "/v1/ads?" . http_build_query(["placeCode" => $placeCode]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result->body;
    }


    /**
     * 根据位置代码调用广告管理
     * @param $placeCode
     * @return mixed
     */
    public static function getOneByCode($placeCode)
    {

        $ad = new AdManageService();
        return $ad->adManage($placeCode);

    }

} 