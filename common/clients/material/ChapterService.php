<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-11-13
 * Time: 下午6:52
 */

namespace common\clients\material;

use common\components\MicroServiceRequest;

use Httpful\Mime;
use Yii;

class ChapterService
{
    /**
     * @var null
     */
    private $uri = null;
    private $microServiceRequest = null;
    private $host = null;

    /**
     * XuemiMicroService constructor.
     */
    public function __construct()
    {
        $this->uri = Yii::$app->params['microService'];
        $this->host = 'teach-res-service';
        $this->microServiceRequest = new MicroServiceRequest($this->host);
    }

    /**
     * 获取分册列表
     * @param integer $subjectId
     * @param integer $version
     * @param integer $departments
     * @return array
     */
    public static function getTomeList(int $subjectId, int $version, int $departments)
    {

        $chapterTomeResult = [];
        $chapterService = new self();
        $tomeResult = $chapterService->tome($departments, $subjectId, $version);

        if ($tomeResult->code == 200) {
            $chapterTomeResult = $tomeResult->body;
        }
        return $chapterTomeResult;
    }


    /**
     * 版本信息
     * @param int $departmentId
     * @param int $subjectId
     * @return mixed
     */
    public function version(int $departmentId, int $subjectId)
    {
        $result = $this->microServiceRequest->get($this->uri . '/api/v2/material/chapter/version?' . http_build_query(['department-id' => $departmentId, 'subject-id' => $subjectId]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result;
    }

    /**
     * 分册信息
     * @param int $departmentId
     * @param int $subjectId
     * @param int $versionId
     * @return mixed
     */
    public function tome(int $departmentId, int $subjectId, int $versionId)
    {
        $result = $this->microServiceRequest->get($this->uri . '/api/v2/material/chapter/tome?' . http_build_query(['department-id' => $departmentId, 'subject-id' => $subjectId, 'version-id' => $versionId]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result;
    }


    /**
     * 章节列表
     * @param int $departmentId
     * @param int $subjectId
     * @param int $tomeId
     * @param int $versionId
     * @return mixed
     */
    public function chapter(int $departmentId, int $subjectId, int $versionId, int $tomeId)
    {
        $result = $this->microServiceRequest->get($this->uri . '/api/v1/material/chapter?' . http_build_query(['department-id' => $departmentId, 'subject-id' => $subjectId, 'tome-id' => $tomeId, 'version-id' => $versionId]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result;
    }


    /**
     * 章节列表
     * @param int $departmentId
     * @param int $subjectId
     * @param int $tomeId
     * @param int $versionId
     * @return mixed
     */
    public function chapterTree(int $departmentId, int $subjectId, int $versionId, int $tomeId)
    {
        $result = $this->microServiceRequest->get($this->uri . '/api/v2/material/chapter/tree-chapter?' . http_build_query(['department-id' => $departmentId, 'subject-id' => $subjectId, 'tome-id' => $tomeId, 'version-id' => $versionId, 'chapter-id' => $tomeId]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result->body;
    }


    /**
     * 知识点列表
     * @param integer $departmentId
     * @param integer $subjectId
     * @return mixed
     */
    public function knowledge(int $departmentId, int $subjectId)
    {
        $result = $this->microServiceRequest->get($this->uri . '/api/v1/material/knowledge-point/list?' . http_build_query(['department-id' => $departmentId, 'subject-id' => $subjectId]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result;
    }

    /**
     * 单个章节信息
     * @param integer $id
     * @return mixed
     *
     *  @returnParam
     * 'cid'
     * 'pid'
     * 'subject'
     * 'grade'
     * 'version'
     * 'chaptername'
     * 'isDelete'
     * 'schoolLevel'
     * 'schoolLength'
     * 'remark'
     * 'bookAtt'
     * 'showLevel'
     * 'orderNo'
     *
     */
    public function chapterInfo(int $id)
    {
        $chapterInfo = null;
        $result = $this->microServiceRequest->get($this->uri . '/api/v2/material/chapter/' . $id)
            ->expectsType(Mime::JSON)
            ->send();
        if($result->code == 200){
            $chapterInfo = $result->body;
        }
        return $chapterInfo;
    }


    /**
     * 单个分册信息
     * @param integer $id
     * @return mixed
     *
     * @returnParam
     * 'id'
     * 'pid'
     * 'subject'
     * 'grade'
     * 'version'
     * 'chaptername'
     * 'isDelete'
     * 'schoolLevel'
     * 'schoolLength'
     * 'remark'
     * 'session'
     * 'bookAtt'
     * 'fascicule'
     * 'image'
     *
     */
    public function tomeInfo(int $id)
    {
        $tomeInfo = null;
        $result = $this->microServiceRequest->get($this->uri . '/api/v2/material/chapter/tome/' . $id)
            ->expectsType(Mime::JSON)
            ->send();
        if ($result->code == 200) {
            $tomeInfo = $result->body;
        }
        return $tomeInfo;
    }

}