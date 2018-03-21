<?php
namespace frontend\services\pos;
use frontend\services\BaseService;
use frontend\services\ShanHaiSoapClient;
use Httpful\Request;

/**
 * Created by unizk.
 * User: ysd
 * Date: 14-10-31
 * Time: 下午5:19
 */
class pos_MessageSentService extends BaseService
{
    public function __construct()
    {
        $this->Uri = app()->params['pos_webService'] . 'messageSent/readerQuerySentMessageInfo.se';
        $this->_soapClient = new ShanHaiSoapClient(app()->params['pos_webService'] . 'schoolService/messageSent?wsdl');
    }

    /**
     * 3.39.4.接收者查询接收的消息（组合条件查询）
     * readerQuerySentMessageInfo 方法名
     * @param $receiverUserID   integer    消息接收人id
     * @param $mainType 507    通知   508    系统消息    509    私信
     * @param $messageType 507001 作业消息  507002 测验消息 507101 直播课程消息    507102 每周一课消息    507103 家长会通知消息    507201 家校联系消息    507202 个人总评消息    507203 单科总评消息   507301 私信消息    507401 试题推送消息    507402 考试通知消息
     * @return $currPage             当前页码
     * @throws \Httpful\Exception\ConnectionErrorException
     * @return $pageSize             每页条数
     * @return ServiceJsonResul
     * {"data":
     * {"pageSize":"10","countSize":"1",
     * "list":[
     * {"messageID":10133,               消息id
     * "messageTiltle":"发送标题",        消息标题
     * "messageContent":"对个人发送",     消息内容
     * "messageType":"507301",             消息类型
     * "isRead":"0",                       是否已读
     * "sentTime":"2014-12-10 12:56:53",   发送时间
     * "fromUserid":1007,                  发送人id
     * "receiverUserID":"1014",             接收人id
     * "sentName":"无敌"，                  发送人姓名
     * "receiveName":"1014",}],           接收者姓名
     * "currPage":"1","listSize":1,"totalPages":"1"},"resCode":"000000","resMsg":"查询成功"}
     */
    public function readerQuerySentMessageInfo($receiverUserID, $mainType,$messageType, $currPage, $pageSize)
    {

        $result= Request::get($this->Uri.'?'.http_build_query(['receiverUserID' => $receiverUserID, 'mainType' => $mainType,'token'=>'', 'messageType' => $messageType, 'currPage' => $currPage, 'pageSize' => $pageSize]))
            ->send();
        return    $result->body;

    }

    /**
     * 3.39.7.接收者删除消息
     * readerMessageDelet 方法名
     * @param $messageID   integer  消息id
     * @return ServiceJsonResul
     * @throws \Camcima\Exception\InvalidParameterException
     * {"data":{
     * },
     * "resCode":"000000",
     * "resMsg":"删除成功"
     * }
     */
    public function readerMessageDelet($messageID)
    {
        $soapResult = $this->_soapClient->readerMessageDelet(array('messageID' => $messageID));
        return $this->soapResultToJsonResult($soapResult);
    }


    /**
     * 3.39.5.已经阅读
     * isRead 方法名
     * @param $messageID  integer  消息id
     * {"data":{
     * },
     * "resCode":"000000",
     * "resMsg":"修改成功"
     * }
     */
    public function isRead($messageID)
    {
        $soapResult = $this->_soapClient->isRead(array("messageID" => $messageID));
        return $this->soapResultToJsonResult($soapResult);
    }

    /**
     * 未读的条数
     * stasticUserMessage 方法名
     * @param $receiverUserID
     * @return int
     * {
        "data": {
        "507": "13",//通知
        "508": "12",//系统消息
        "509": "28"//私信
        },
        "resCode": "000000",
        "resMsg": "成功"
        }
     */
    public function stasticUserMessage($receiverUserID)
    {
        if (empty($receiverUserID)) {
            return 0;
        }
        $soapResult = $this->_soapClient->stasticUserMessage(array("receiverUserID" => $receiverUserID));
        $result = $this->soapResultToJsonResult($soapResult);

        if ($result->resCode == self::successCode) {

            return $result->data;
        }
        return 0;
    }



}