<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: 刘兴
 * Date: 2016/12/30
 * Time: 14:27
 */

namespace common\clients;

use Httpful\Mime;
use Httpful\Request;
use Yii;

class QuestionProcessService {
    /**
     * @var null
     */
    private $uri = null;

    /**
     * QuestionProcessService constructor.
     */
    public function __construct()
    {
        $this->uri = Yii::$app->params['homework_webService'];
    }

    /**
     * app端同步题目更新
     * @param int $questionId  题目id
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function  questionProcess(int $questionId){
        $result = Request::post($this->uri."mPsd/m/ques/clearQuesCache.se")
            ->body(http_build_query(["questionId"=>$questionId]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body;
    }

}