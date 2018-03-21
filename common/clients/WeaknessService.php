<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 17-11-13
 * Time: 上午10:55
 */

namespace common\clients;


use common\components\MicroServiceRequest;
use Httpful\Mime;
use Yii;

class WeaknessService
{
    private $uri = null;
    private $host=null;
    private $microServiceRequest=null;

    public function __construct()
    {
        $this->uri = Yii::$app->params['microService'];
        $this->host = 'weakness-service';
        $this->microServiceRequest = new MicroServiceRequest($this->host);
    }


    /**
     * 获取学生短板题目列表
     * @param int $userId
     * @param int $subjectId
     * @param int $complexity
     * @param int $page
     * @param int $perPage
     * @param int $beginTime
     * @param int $endTime
     * @param string $type
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getQuestionList(int $userId, int $subjectId, int $complexity, int $page, int $perPage, int $beginTime, int $endTime, string $type)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/user/' . $userId . '/weakness/questions?'
            . http_build_query(['subject-id' => $subjectId, 'complexity' => $complexity, 'page' => $page, 'per-page' => $perPage, "begin-time" => $beginTime,"end-time"=>$endTime, "type" => $type]))
            ->sendsType(Mime::JSON)
            ->send();

        return $result;
    }


    /**
     * 获取学生单个错题信息
     * @param int $userId
     * @param int $questionId
     * @param int $beginTime
     * @param int $endTime
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getQuestionInfo(int $userId, int $questionId, int $beginTime, int $endTime)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/user/' . $userId . '/weakness/question/' . $questionId . '?'
        . http_build_query(["begin-time" => $beginTime,"end-time"=>$endTime]))
            ->sendsType(Mime::JSON)
            ->send();

        return $result;
    }


    /**
     * 学生知识点短板列表
     * @param int $userId
     * @param int $subjectId
     * @param int $page
     * @param int $perPage
     * @param int $beginTime
     * @param int $endTime
     * @param string $type
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getWeaknessKidList(int $userId, int $subjectId, int $page, int $perPage, int $beginTime, int $endTime, string $type)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/weakness/kid/report/' . $userId . '?'
            . http_build_query(["subject-id" => $subjectId, "begin-time" => $beginTime,"end-time"=>$endTime, 'page' => $page, 'per-page' => $perPage, 'type' => $type]))
            ->sendsType(Mime::JSON)
            ->send();

        return $result;
    }


    /**
     * 获取学生单个知识点短板题目列表
     * @param int $userId
     * @param int $kid
     * @param int $page
     * @param int $perPage
     * @param int $beginTime
     * @param int $endTime
     * @param string $type
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getKidQuestionList(int $userId, int $kid, int $page, int $perPage, int $beginTime, int $endTime, string $type)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/weakness/knowledge/' . $kid . '/user/' . $userId . '/questions?'
            . http_build_query(['page' => $page, 'per-page' => $perPage, "begin-time" => $beginTime, "end-time" => $endTime, "type" => $type]))
            ->sendsType(Mime::JSON)
            ->send();

        return $result;
    }

}