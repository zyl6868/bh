<?php
namespace common\clients;
use Httpful\Mime;
use Httpful\Request;
use Yii;

/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 18-1-5
 * Time: 下午5:59
 */

class SchoolService
{
    private $uri = null;

    public function __construct()
    {
        $this->uri = Yii::$app->params['banhai_webService'];
    }

    /**
     * 创建学校
     * @param array $schoolInfo
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function CreateSchool($schoolInfo)
    {
        $result = Request::post($this->uri . '/schoolManage/create-schools')
            ->body(http_build_query(['schoolInfo' => $schoolInfo]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }

}