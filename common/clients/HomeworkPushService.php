<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/11/17
 * Time: 19:10
 */

namespace common\clients;


use common\components\MicroServiceRequest;
use Httpful\Mime;
use Yii;

class HomeworkPushService {


    private $uri = null;
    private $host=null;
    private $microServiceRequest=null;

    public function __construct()
    {
        $this->uri = Yii::$app->params['microService'];
        $this->host = 'homework-service';
        $this->microServiceRequest = new MicroServiceRequest($this->host);
    }


    /**
     * 催作业
     * @param integer $relId
     * @return \Httpful\associative|string
     */
    public function urge(int $relId){

        $result = $this->microServiceRequest->post($this->uri . '/v2/homework-class/'.$relId.'/urge-student')
            ->body(http_build_query(['rel-id' => $relId]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result;
    }

} 