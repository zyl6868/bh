<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 17-11-10
 * Time: 下午6:44
 */

namespace common\clients;


use common\components\MicroServiceRequest;
use Httpful\Mime;
use Yii;

class HomeworkService
{
    private $uri = null;
    private $host=null;
    private $microServiceRequest=null;

    public function __construct()
    {
        $this->uri = Yii::$app->params['microService'];
        $this->host = 'homework-service';
        $this->microServiceRequest = new MicroServiceRequest($this->host);
    }


    /**
     * 获取最近回答且有精讲作业视频的精品作业（最多6个）
     * @param int $userId
     * @param string $beginTime
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getHomeworkList(int $userId, string $beginTime)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/homework/student/' . $userId . '/answers-and-videos?'
            . http_build_query(['begin-time' => $beginTime]))
            ->sendsType(Mime::JSON)
            ->send();
        return $result;
    }


    /**
     * 查询学生单个作业答题卡及题目视频资源
     * @param int $homeworkAnswerId
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getHomeworkInfo(int $homeworkAnswerId)
    {
        $result = $this->microServiceRequest->get($this->uri . '/v1/homework/student-answer/' . $homeworkAnswerId . '/questions-and-videos')
            ->sendsType(Mime::JSON)
            ->send();
        return $result;
    }

    /**
     * 批改电子作业
     * @param integer $aid
     * @param integer $homeworkAnswerID
     * @param integer $correctResult
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function orgCorrectHomework(int $aid,int $homeworkAnswerID,int $correctResult)
    {
        $result = $this->microServiceRequest->post($this->uri . '/v1/homework/answer-question-all/'.$aid)
            ->body(http_build_query(['homework-answer-id' => $homeworkAnswerID,'correct-result'=>$correctResult]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result;
    }

    /**
     * 完成批改更改表状态
     * @param integer $userId
     * @param integer $homeworkAnswerID
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function finishCorrectHomework(int $userId,int $homeworkAnswerID)
    {
        $result = $this->microServiceRequest->post($this->uri . '/v1/homework/answer/'.$homeworkAnswerID)
            ->body(http_build_query(['homework-answer-id' => $homeworkAnswerID,'user-id'=>$userId]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result;
    }

    /**
     * 批改纸质作业
     * @param integer $userId
     * @param integer $homeworkAnswerID
     * @param integer $correctLevel
     * @return \Httpful\associative|string
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function correctPaperHomework(int $userId,int $homeworkAnswerID,int $correctLevel)
    {
        $result = $this->microServiceRequest->post($this->uri . '/v1/homework/paper/answer/'.$homeworkAnswerID)
            ->body(http_build_query(['user-id' => $userId,'correct-level'=>$correctLevel]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result;
    }


}