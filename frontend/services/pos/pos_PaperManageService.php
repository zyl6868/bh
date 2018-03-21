<?php
namespace frontend\services\pos;
use frontend\services\BaseService;
use frontend\services\ShanHaiSoapClient;

/**
 * 试卷管理
 * Created by PhpStorm.
 * User: yangjie
 */
class pos_PaperManageService extends BaseService
{
    function __construct()
    {
        $this->_soapClient = new ShanHaiSoapClient(app()->params['pos_webService'] . "schoolService/paperManage?wsdl");
    }


    /**
     * 上传试卷
     * @param $name
     * @param $provience
     * @param $city
     * @param $country
     * @param $gradeId
     * @param $subjectId
     * @param $version
     * @param $knowledgeId
     * @param $paperDescribe
     * @param $creator
     * @param $gutter
     * @param $secret
     * @param $imageUrls
     * @return array
     * @throws \Camcima\Exception\InvalidParameterException
     */
    public function uploadPaper($name,
                                $provience,
                                $city,
                                $country,
                                $gradeId,
                                $subjectId,
                                $version,
                                $knowledgeId,
                                $paperDescribe,
                                $creator,
                                $imageUrls,
                                $gutter = 0,
                                $secret = 0
    )
    {
        $soapResult = $this->_soapClient->uploadPaper(
            array(
                'name' => $name,
                'provience' => $provience,
                'city' => $city,
                'country' => $country,
                'gradeId' => $gradeId,
                'subjectId' => $subjectId,
                'version' => $version,
                'knowledgeId' => $knowledgeId,
                'paperDescribe' => $paperDescribe,
                'creator' => $creator,
                'imageUrls' => $imageUrls,
                'gutter' => $gutter,
                'secret' => $secret

            ));
        $result = $this->soapResultToJsonResult($soapResult);
        return $result;
    }


    /**
     * 查询试卷
     * @param string $creator
     * @param string $getType
     * @param string $paperId
     * @param string $name
     * @param string $provience
     * @param string $city
     * @param string $country
     * @param string $gradeId
     * @param string $subjectId
     * @param string $version
     * @param string $knowledgeId
     * @param string $author
     * @param string $paperDescribe
     * @param string $paperType
     * @param string $mainTitle
     * @param string $subTitle
     * @param string $scope
     * @param string $examTime
     * @param string $studentInput
     * @param string $attention
     * @param string $orderType 排序   1发布时间倒序    2发布时间升序
     * @return array
     * @throws \Camcima\Exception\InvalidParameterException
     */
    public function queryPaper($creator = '', $currPage = 1, $pageSize = 10, $getType = '', $paperId = '', $name = '', $provience = '', $city = '', $country = '', $gradeId = '', $subjectId = '', $version = '', $knowledgeId = '', $author = '', $paperDescribe = '', $paperType = '', $mainTitle = '', $subTitle = '', $scope = '', $examTime = '', $studentInput = '', $attention = '', $orderType = '')
    {
        $soapResult = $this->_soapClient->queryPaper(array("getType" => $getType, "creator" => $creator, 'paperId' => $paperId, 'name' => $name, 'provience' => $provience, 'city' => $city, 'country' => $country, 'gradeId' => $gradeId, 'subjectId' => $subjectId, 'version' => $version, 'knowledgeId' => $knowledgeId, 'author' => $author, 'paperDescribe' => $paperDescribe, 'paperType' => $paperType, 'mainTitle' => $mainTitle, 'subTitle' => $subTitle, 'scope' => $scope, 'examTime' => $examTime, 'studentInput' => $studentInput, 'attention' => $attention, 'currPage' => $currPage, 'pageSize' => $pageSize, 'orderType' => $orderType));
        $result = $this->soapResultToJsonResult($soapResult);
        if ($result->resCode == self::successCode) {

            return $result->data;
        }
        return array();

    }

    /**
     * 获取一条组织试卷
     * @param $paperId
     * @return null
     */
    public function queryMakerPaperById($paperId)
    {
        $result = $this->queryPaper('', 1, 500, '', $paperId);

        if (empty($result)) {

            return null;
        }

        if (isset($result->list) && isset($result->list[0])) {
            return $result->list[0];
        }
        return null;


    }

    /**
     * 新试卷搜索映射 queryPaper 接口
     * @param $creator
     * @param $currPage
     * @param $pageSize
     * @param $gradeId
     * @param $subjectId
     * @param $version
     * @return array
     */
    public function searchPapeer($creator, $currPage, $pageSize, $getType, $gradeId, $subjectId, $version, $orderType)
    {
        return $this->queryPaper($creator, $currPage, $pageSize, $getType, $paperId = '', $name = '', $provience = '', $city = '', $country = '', $gradeId, $subjectId, $version, $knowledgeId = '', $author = '', $paperDescribe = '', $paperType = '', $mainTitle = '', $subTitle = '', $scope = '', $examTime = '', $studentInput = '', $attention = '', $orderType);
    }

    /**
     *  删除试卷
     * @param $paperId
     * @return ServiceJsonResult
     * @throws \Camcima\Exception\InvalidParameterException
     */
    public function deletePaper($paperId)
    {
        $soapResult = $this->_soapClient->deletePaper(array('paperId' => $paperId));
        $result = $this->soapResultToJsonResult($soapResult);

        return $result;
    }


    /**
     * 3.22.2.    查询试卷详情
     * {
     * "data": {
     * "id": 101186,//试卷id
     * "getType": "0",//试卷组织类型（0上传，1组卷）
     * "name": "4月18的单元测验数学试卷"//试卷名称
     * },
     * "resCode": "000000",
     * "resMsg": "查询成功"
     * }
     * @param $paperId
     * @param $testAnswerID
     * @param $examSubID
     * @return array
     */
    public function queryPaperById($paperId, $testAnswerID, $examSubID)
    {
        $soapResult = $this->_soapClient->queryPaperById(
            array(
                "paperId" => $paperId,
                "testAnswerID" => $testAnswerID,
                "examSubID" => $examSubID
            ));
        $result = $this->soapResultToJsonResult($soapResult);
        if ($result->resCode == self::successCode) {

            return $result->data;
        }
        return array();
    }

}