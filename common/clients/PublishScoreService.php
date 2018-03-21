<?php
/**
 * Created by PhpStorm.
 * User: ysd
 * Date: 2015/10/22
 * Time: 19:18
 */
namespace common\clients;

use common\components\MicroServiceRequest;
use Httpful\Mime;
use Httpful\Request;
use Yii;

class PublishScoreService
{
    /**
     * @var null
     */
    private $uri = null;
    private $microServiceRequest = null;
    private $host = null;

    /**
     * scoreMicroService constructor.
     */
    public function __construct()
    {
        $this->uri = Yii::$app->params['microService'];
        $this->host = 'databusiness-service';
        $this->microServiceRequest = new MicroServiceRequest($this->host);
    }

    /**
     * @param integer $examId 考试ID
     * @return array
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function publishScore(int $examId)
    {
        $result = $this->microServiceRequest->get($this->uri . '/examReport/addSchoolExamToReport.do?schoolExamId=' . $examId)
            ->contentType('')
            ->sendsType(Mime::FORM)
            ->send();

        if ($result->body->resCode == 000000) {
            return $result->body->resCode;
        } else {
            return array();
        }

    }

    public static function model()
    {
        return new self();
    }
}