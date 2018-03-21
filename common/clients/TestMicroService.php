<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: liuxing
 * Date: 17-4-12
 * Time: 下午7:02
 */
namespace common\clients;

use common\components\MicroServiceRequest;
use Httpful\Mime;
use Yii;

class TestMicroService {
    /**
     * @var null
     */
    private $uri = null;
    private $microServiceRequest = null;
    private $host = null;

    /**
     * TestMicroService constructor.
     */
    public function __construct()
    {
        $this->uri = Yii::$app->params['microService'];
        $this->host = 'practice-service';
        $this->microServiceRequest = new MicroServiceRequest($this->host);
    }

    /**
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getLevelRankings()
    {

        $result= $this->microServiceRequest->get($this->uri. '/practice/user/getLevelRankings')
            ->sendsType(Mime::JSON)
            ->send();
        return    $result->body;
    }

}