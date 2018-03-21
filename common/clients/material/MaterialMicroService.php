<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: zyl
 * Date: 17-4-20
 * Time: 11:00
 */
namespace common\clients\material;

use common\components\MicroServiceRequest;
use Httpful\associative;
use Httpful\Mime;
use Yii;

class MaterialMicroService
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
     * 课件列表
     * @param integer $perPage
     * @param integer $page
     * @param integer $departmentId
     * @param integer $subjectId
     * @param integer $versionId
     * @param integer $chapterId
     * @param integer $matType
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function list(int $perPage,int $page,int $departmentId,int $subjectId,int $versionId,int $chapterId,int $matType)
    {
        $result = $this->microServiceRequest->get($this->uri . '/api/v1/material/list?' . http_build_query(['per-page' => $perPage,'page' => $page,'department-id' => $departmentId,'subject-id' => $subjectId,'version-id' => $versionId,'chapter-id' => $chapterId,'mat-type'=>$matType]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result->body;
    }


    /**
     * 收藏课件
     * @param int $fileId
     * @param int $userId
     * @return mixed
     */
    public function collect(int $fileId,int $userId)
    {

        $result = $this->microServiceRequest->post($this->uri . '/api/v1/material/collect')
            ->body(http_build_query(['file-id' => $fileId, 'user-id' => $userId]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }

    /**
     * 取消收藏课件
     * @param int $fileId
     * @param int $userId
     * @return mixed
     */
    public function cancelCollect(int $fileId,int $userId)
    {

        $result = $this->microServiceRequest->post($this->uri . '/api/v1/material/cancel-collect')
            ->body(http_build_query(['file-id' => $fileId, 'user-id' => $userId]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }

    /**
     * 判断课件是否收藏
     * @param string $fileIds
     * @param integer $userId
     * @return mixed
     */
    public function isCollected(string $fileIds,int $userId)
    {

        $result = $this->microServiceRequest->get($this->uri . '/api/v1/material/is-collected?' . http_build_query(['file-ids'=>$fileIds,'user-id'=>$userId]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result->body;

    }

    /**
     * 判断课件是否收藏
     * @param integer $fileId
     * @return mixed
     */
    public function detail(int $fileId)
    {

        $result = $this->microServiceRequest->get($this->uri . '/api/v1/material/details?' . http_build_query(['file-id'=>$fileId]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result->body;

    }


    /**
     * 下载课件
     * @param int $fileId
     * @param int $userId
     * @return mixed
     */
    public function download(int $fileId,int $userId)
    {

        $result = $this->microServiceRequest->post($this->uri . '/api/v1/material/download')
            ->body(http_build_query(['file-id' => $fileId, 'user-id' => $userId]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }


    /**
     * 预览课件
     * @param int $fileId
     * @param int $userId
     * @return mixed
     */
    public function preview(int $fileId,int $userId)
    {
        $result = $this->microServiceRequest->get($this->uri . '/api/v1/material/preview?' . http_build_query(['file-id'=>$fileId,'user-id'=>$userId]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result->body;
    }

    /**
     * 投屏课件
     * @param int $fileId
     * @param int $userId
     * @return mixed
     */
    public function show(int $fileId,int $userId)
    {
        $result = $this->microServiceRequest->get($this->uri . '/api/v1/material/show?' . http_build_query(['file-id'=>$fileId,'user-id'=>$userId]))
            ->expectsType(Mime::JSON)
            ->send();
        return $result->body;
    }


    /**
     * 关键词搜索课件
     * @param string $keywords
     * @param int $page
     * @param int $perPage
     * @param int $isHighlight
     * @return mixed
     */
    public function searchKeywords(string $keywords, int $page, int $perPage, int $isHighlight)
    {
        $result = $this->microServiceRequest->get($this->uri . '/api/v1/material/list/keywords?'
            . http_build_query(['keywords' => $keywords, 'per-page' => $perPage, 'page' => $page, 'is-highlight' => $isHighlight]))
            ->expectsType(Mime::JSON)
            ->send();

        return $result;
    }



}