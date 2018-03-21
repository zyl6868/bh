<?php
namespace common\clients;
use common\components\MicroServiceRequest;
use Httpful\Mime;
use Yii;

/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 18-1-30
 * Time: 下午2:37
 */
class MessageService
{

    private $uri = null;
    private $host = null;
    private $microServiceRequest = null;

    public function __construct(){
        $this->uri = Yii::$app->params['microService'];
        $this->host = 'message-service';
        $this->microServiceRequest = new MicroServiceRequest($this->host);
    }

    /**
     * 布置作业发送消息
     * @param integer $id
     * @param integer $messageType
     * @return \Httpful\associative|string
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function assignHomeworkMessage($id,$messageType){
        $result = $this->microServiceRequest->post($this->uri.'/api/v2/banhai-message/type')
            ->body(http_build_query(['message-type'=>$messageType,'object-id'=>$id]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result;
    }


}