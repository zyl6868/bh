<?php
namespace frontend\services\pos;
use frontend\services\BaseService;
use frontend\services\ShanHaiSoapClient;

/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-10-22
 * Time: 下午6:26
 */
class pos_SchlHomMsgService extends BaseService{

    function __construct()
    {
        $this->_soapClient = new ShanHaiSoapClient(app()->params['pos_webService'] . "schoolService/schlHomMsg?wsdl");
    }



    /**
     * 高：2014.10.22
     * 3.24.4.查询家校短信
     * 接口地址	http://主机地址:端口号/ /schoolService/ schlHomMsg?wsdl
     * 方法名	querySchlHomMsg
     * @param $id   integer    短信id
     * @param $creator integer 创建人
     * @param $token  string  用于安全控制，暂时为空
     *
     * "resCode":"000000",
    "resMsg":"查询成功",
    "data":{
    "currPage":"当前页码",
    "totalPages":"总页数",
    "countSize":"总记录数",
    "pageSize":"每页数据的条数",
    "list":[//列表
    {"id":"",//短信id
    "title":"",//短信标题
    "receiverType":"",//收件人身份(数据字典 1学生 2家长)
    "sendWay":"",//发送方式(数据字段 1短息 2站内信)
    "rankingChg":"",//本班整体名次及其变化(0没有,1变化)
    "weakPoint":"",//知识盲点
    "addContent":"",//补充内容
    "creator":"",//创建人
    "creatTime":"",//创建时间
    "receivers":"",//家校联系短信收件人
    [
    {"receivers":[{"type":"class",//类型class班级，student学生
    "id":"c1",//班级或学生id
    "scope":"all"//范围all全部,part部分
    },{"type":"student","id":"s1","scope":""}]}
    ]
    "ranks":""//家校联系短信分数段
    [
    {"ranks":[{"low":"60","high":"70","peoples":"10"},{"low":"70","high":"80","peoples":"20"}]}
    ]
    },
    ...
    ]
     * @return array
     */
    public function querySchlHomMsg($id,$creator,$isSend,$currPage,$pageSize,$token){
        $soapResult = $this->_soapClient->querySchlHomMsg(array("id" => $id, 'creator' => $creator,'isSend'=>$isSend,'currPage'=>$currPage,'pageSize'=>$pageSize, 'token' => $token));
        $result = $this->soapResultToJsonResult($soapResult);
        if ($result->resCode == self::successCode) {

            return $result->data;
        }
        return array();
    }

    /**
     * 高：2014.10。28
     * 3.24.3.删除家校短信
     * 接口地址	http://主机地址:端口号/ /schoolService/ schlHomMsg?wsdl
     * 方法名	delSchlHomMsg
     * @param $id       短信id
     * {
    "resCode":"000000",
    "resMsg":"成功",
    "data":{
    }
    }
     * @return ServiceJsonResult
     */
    public function delSchlHomMsg($id){
        $soapResult = $this->_soapClient->delSchlHomMsg(array('id'=>$id));
         return  $this->soapResultToJsonResult($soapResult);
    }

    /**
     * 高：2014.10.28
     * 发送信息
     * @param $id 信息id
     * @param $token
     * @return ServiceJsonResult
     */
    public function sendSchlHomMsg($id){
        $soapResult = $this->_soapClient->sendSchlHomMsg(array('id'=>$id));
        $result=  $this->soapResultToJsonResult($soapResult);
        if ($result->resCode == self::successCode) {

            return $result->data;
        }
        return null;
    }
}