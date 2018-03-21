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

class MessageSearchService {
    /**
     * @var null
     */
    private $uri = null;

    /**
     * MessageSearchService constructor.
     */
    public function __construct()
    {
        $this->uri = Yii::$app->params['nep_webService'];
    }

    /**
     * 收到的通知详情
     * @param string $id 通知id
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getMessageById($id){
        $result= Request::post($this->uri. '/psdmsg/messagesearch/getMessageById.se')
            ->body(http_build_query(['Id' =>$id]))
            ->sendsType(Mime::FORM)
            ->send();
        return    $result->body;
    }

    /**
     * 高：2014.10.22
     * 3.24.1.添加家校短息
     * 接口地址    http://主机地址:端口号/ /schoolService/ schlHomMsg?wsdl
     * 方法名    createSchlHomMsg
     * @param $title    string        短信标题
     * @param $receiverJson   integer  接收者{"receivers":[{"type":"class","id":"c1","scope":"all"//all:全部，part: 部分},{"type":"student","id":"s1","scope":""}]}
     * @param $receiverType   integer  收件人身份(数据字典 1学生 2家长)
     * @param $sendWay    integer      发送方式(数据字段 1短息 2站内信)
     * @param $rankingChg integer      本班整体名次及其变化
     * @param $rankJson   integer      分数区间{"ranks":[{"low":"60","high":"70","peoples":"10"},{"low":"70","high":"80","peoples":"20"}]}
     * @param $weakPoint  integer      知识盲点
     * @param $addContent string      补充内容
     * @param $creator    integer      创建人
     * @param $token      string      用于安全控制，暂时为空
     *
     * {
     * "resCode":"000000",
     * "resMsg":"成功",
     * "data":{
     * }
     * }
     * @return ServiceJsonResult
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function createSchlHomMsg($title,$classId,$scope,$examId,$receiverJson,$receiverType,$sendWay,$rankingChg,$rankJson,$weakPoint,$addContent,$creator,$reference,$subjectId,$kids,$urls,$token){
        $result= Request::post($this->uri. '/posidon/schlHomMsg/createSchlHomMsg.se')
            ->body(http_build_query(['title'=>$title,'classId'=>$classId,'scope'=>$scope,'examId'=>$examId,'receiverJson'=>$receiverJson,'receiverType'=>$receiverType,'sendWay'=>$sendWay,'rankingChg'=>$rankingChg,'rankJson'=>$rankJson,'weakPoint'=>$weakPoint,'addContent'=>$addContent,'creator'=>$creator,'reference'=>$reference,'subjectId'=>$subjectId,'kids'=>$kids,'urls'=>$urls,'token'=>$token]))
            ->sendsType(Mime::FORM)
            ->send();
        return    $result->body;
    }

    /**
     * 高：2014.10.28
     * 3.24.2.修改家校短息
     * 接口地址	http://主机地址:端口号/ /schoolService/ schlHomMsg?wsdl
     * 方法名	updateSchlHomMsg
     * @param $id    integer   短信id
     * @param $title string     短信标题
     * @param $receiverJson
     * @param $receiverType   integer  收件人身份(数据字典 1学生 2家长)
     * @param $sendWay       integer   发送方式(数据字段 1短息 2站内信)
     * @param $rankingChg     integer  本班整体名次及其变化
     * @param $rankJson       integer  分数区间{"ranks":[{"low":"60","high":"70","peoples":"10"},{"low":"70","high":"80","peoples":"20"}]}
     * @param $weakPoint      integer  知识盲点
     * @param $addContent      string 补充内容
     * @param $creator        integer  创建人
     * @param $token
     * {
    "resCode":"000000",
    "resMsg":"成功",
    "data":{
    }
    }
     * @return ServiceJsonResult
     */
    public function updateSchlHomMsg($id,$title,$examId,$classId,$scope,$receiverJson,$receiverType,$sendWay,$rankingChg,$rankJson,$weakPoint,$addContent,$reference,$subjectId,$kids,$urls,$token){
        $result= Request::post($this->uri."/posidon/schlHomMsg/updateSchlHomMsg.se")
            ->body(http_build_query(['id'=>$id,'title'=>$title,'examId'=>$examId,'classId'=>$classId,'scope'=>$scope,'receiverJson'=>$receiverJson,'receiverType'=>$receiverType,'sendWay'=>$sendWay,'rankingChg'=>$rankingChg,'rankJson'=>$rankJson,'weakPoint'=>$weakPoint,'addContent'=>$addContent,'reference'=>$reference,'subjectId'=>$subjectId,'kids'=>$kids,'urls'=>$urls,'token'=>$token]))
            ->sendsType(Mime::FORM)
            ->send();
        return    $result->body;
    }

} 