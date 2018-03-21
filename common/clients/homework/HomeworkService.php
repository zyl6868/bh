<?php

declare(strict_types = 1);
namespace common\clients\homework;

use common\components\MicroServiceRequest;
use Httpful\Mime;
use Yii;

/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-11-14
 * Time: 下午12:00
 */
class HomeworkService
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
     * 精品作业列表
     * @param int $perPage
     * @param int $page
     * @param int $departmentId
     * @param int $subjectId
     * @param int $versionId
     * @param int $chapterId
     * @param int $homeworkType
     * @return mixed
     * @internal param int $userId
     */
    public function boutiqueList(int $perPage, int $page, int $departmentId,int $subjectId, int $versionId, int $chapterId, int $homeworkType)
    {
        $result = $this->microServiceRequest->get($this->uri . '/api/v1/homework/boutique-list?'
            . http_build_query(['per-page' => $perPage, 'page' => $page,'department-id' => $departmentId,
                'subject-id' => $subjectId,'version-id' => $versionId,'chapter-id' => $chapterId,
                'homework-type'=>$homeworkType]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result;
    }


    /**
     * 关键词搜索作业
     * @param string $keywords
     * @param int $page
     * @param int $perPage
     * @param int $isHighlight
     * @return mixed
     */
    public function searchKeywords(string $keywords, int $page, int $perPage, int $isHighlight)
    {
        $result = $this->microServiceRequest->get($this->uri . '/api/v1/homework/list/keywords?'
            . http_build_query(['keywords' => $keywords, 'per-page' => $perPage, 'page' => $page, 'is-highlight' => $isHighlight]))
            ->expectsType(Mime::JSON)
            ->send();

        return $result;
    }


}