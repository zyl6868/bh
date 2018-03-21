<?php

namespace frontend\services\apollo;
use frontend\services\BaseService;
use frontend\services\ShanHaiSoapClient;

/**
 * Created by unizk.
 * User: ysd
 * Date: 2015/5/3
 * Time: 14:55
 */

/**
 * Class VideoLessonInfoService
 */
class Apollo_ResourceManageService extends BaseService
{

    /**
     *
     */
    function __construct()
    {
        $this->_soapClient = new ShanHaiSoapClient(app()->params['apollo_webService'] . "apollo/resource/resourceManage?wsdl");
    }


    /**
     * 2.10.1.视频库检索
     * videoSearch
     * @param  tag            搜索（可为空
     * @param  videoName        视频名称（可为空）
     * @param  gradeID        年级
     * @param  subjectID        科目
     * @param  year            年份
     * @param  examType        考试类型
     * @param  order            排序（按发布时间 0↓ 时间从现在到以前，1↑时间以前到现在）
     * @param  currPage        当前显示页码，可以为空,默认值1
     * @param  pageSize        每页显示的条数，可以为空，默认值10
     * {"data":{
     * "currPage":"当前页码",
     * "totalPages":"总页数",
     * "countSize":"总记录数",
     * "pageSize":"每页数据的条数"
     * "videoList":
     * [
     * {
     * "id":1002,视频ID
     * “title”:视频名称
     * "introduce":"2", 介绍
     * "tag":"3",标签
     * "fileSize":"4", 文件大小
     * “fileMD5”:””文件md5值
     * “resSource”:””来源
     * "fileFormat":"5", 文件编码格式
     * "fileType":"文件类型",
     * "resType":"6", 资源用途
     * "browseTotal": 观看次数，打开次数
     * "dowTotal":"7",下载次数
     * "recommendLevel":"",推荐指数
     * "videoCharacter":"视频清晰度、尺寸
     * ,“resFileId”：‘’资源文件存储id
     * "resFileUri":"8",资源文件存储url
     *
     * "screenImgUri":"文件截屏图片url
     * “screenImgId”:”文件截屏图片id
     * "creatTime":"9",创建时间
     * "creatorId":"1",创建id
     * "syncPar":"同步参数
     * }]
     * },
     * "resCode":"000000",
     * "resMsg":"录入成功" }
     * @return ServiceJsonResult
     */
    public function videoSearch($tag = null, $videoName = null, $gradeID = null, $subjectID = null,
                                $year = null, $examType = null, $order = null, $currPage = null, $pageSize = null)
    {

        $soapResult = $this->_soapClient->videoSearch(array(
            'tag' => $tag,
            'videoName' => $videoName,
            'gradeID' => $gradeID,
            'subjectID' => $subjectID,
            'year' => $year,
            'examType' => $examType,
            'order' => $order,
            'currPage' => $currPage,
            'pageSize' => $pageSize
        ));
        $result = $this->soapResultToJsonResult($soapResult);
        if ($result->resCode == self::successCode) {

            return $result->data;
        }
        return array();

    }

    /**
     * 2.10.2.视频详情
     * videoSearch
     * @param  id            资源id
     * {"data":返回的JSON：
     * {"data":{
     * "id":1002,视频ID
     * “title”:视频名称
     * "introduce":"2", 介绍
     * "tag":"3",标签
     * "fileSize":"4", 文件大小
     * “fileMD5”:””文件md5值
     * “resSource”:””来源
     * "fileFormat":"5", 文件编码格式
     * "fileType":"文件类型",
     * "resType":"6", 资源用途
     * "browseTotal": 观看次数，打开次数
     * "dowTotal":"7",下载次数
     * "recommendLevel":"",推荐指数
     * "videoCharacter":"视频清晰度、尺寸
     * ,“resFileId”：‘’资源文件存储id
     * "resFileUri":"8",资源文件存储url
     *
     * "screenImgUri":"文件截屏图片url
     * “screenImgId”:”文件截屏图片id
     * "creatTime":"9",创建时间
     * "creatorId":"1",创建id
     * "syncPar":"同步参数
     * }]
     * },
     * "resCode":"000000",
     * "resMsg":"录入成功" }
     */
    public function videoDetail($id)
    {

        $soapResult = $this->_soapClient->videoDetail(array(
            'id' => $id
        ));
        $result = $this->soapResultToJsonResult($soapResult);
        if ($result->resCode == self::successCode) {

            return $result->data;
        }
        return array();

    }


}

?>
