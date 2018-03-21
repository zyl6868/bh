<?php
/**
 * Created by PhpStorm.
 * User: 邓奇文
 * Date: 2016/12/16
 * Time: 10:46
 */

namespace common\clients;

use common\components\MicroServiceRequest;
use Httpful\Mime;
use Yii;

class MpsdAppService {
    /**
     * @var null
     */
    private $uri = null;
    private $host=null;
    private $microServiceRequest=null;

    /**
     * HomeworkUpService constructor.
     */
    public function __construct()
    {
        $this->uri = Yii::$app->params['microService'];
        $this->host = 'mpsd-service';
        $this->microServiceRequest = new MicroServiceRequest($this->host);
    }

    /**
     * 提交作业
     * @param integer $relId 班级作业id
     * @param integer $studentID 学生id
     * @param string $imageUrls 图片url地址
     * @param string $answerList 客观题答题
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function uploadHomeworkAnswerQuestion(int $relId, int $studentID, string $imageUrls=null, string $answerList=null){
        $result= $this->microServiceRequest->post($this->uri. '/mPsd/m/homework/web/upAnswer.se')
            ->body(http_build_query(['relId' =>$relId, 'studentID' =>$studentID, 'imageUrls' =>$imageUrls, 'answerList' =>$answerList]))
            ->sendsType(Mime::FORM)
            ->send();
        return    $result->body;
    }



    /**
     * app端同步题目更新
     * @param int $questionId  题目id
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function  questionProcess(int $questionId){
        $result = $this->microServiceRequest->post($this->uri."/mPsd/m/ques/clearQuesCache.se")
            ->body(http_build_query(["questionId"=>$questionId]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }

}