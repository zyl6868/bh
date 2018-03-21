<?php
namespace frontend\services\pos;
use frontend\services\BaseService;
use frontend\services\ShanHaiSoapClient;

/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 14-10-16
 * Time: 下午3:22
 */
class pos_ExamService extends BaseService
{
    function __construct()
    {
        $this->_soapClient = new ShanHaiSoapClient(app()->params['pos_webService'] . "schoolService/examService?wsdl");
    }

    /**
     * 3.42.31.	预览试卷(在线组卷类型使用)
     * @param $examSubID
     * @param string $paperId
     * @param string $currPage
     * @param string $pageSize
     * @return array
     */
    public function queryPaperByIDOrgType($examSubID ,$paperId="",$currPage="",$pageSize="1000"){
        $soapResult = $this->_soapClient->queryPaperByIDOrgType(
            array(
                "examSubID"=>$examSubID,
                "paperId"=>$paperId,
                "currPage"=>$currPage,
                "pageSize"=>$pageSize
            ));
        $result = $this->soapResultToJsonResult($soapResult);
        if ($result->resCode == BaseService::successCode) {
            return $result->data;
        }
        return array();
    }

}