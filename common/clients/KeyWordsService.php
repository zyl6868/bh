<?php
/**
 * Created by PhpStorm.
 * User: ysd
 * Date: 2015/8/6
 * Time: 11:32
 */

namespace common\clients;


use common\components\MicroServiceRequest;
use Httpful\Mime;
use Yii;

class KeyWordsService
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
        $this->host = 'keywords-service';
        $this->microServiceRequest = new MicroServiceRequest($this->host);
    }

    /**
     * @param $text
     * 替换字符串内的敏感字符
     * @return string
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    protected function ReplaceText(string $text)
    {
        $result = $this->microServiceRequest->post($this->uri . "/key-words")
            ->body(http_build_query(["text" => $text, "method" => "replace"]))
            ->sendsType(Mime::FORM)
            ->send();
        return $result->body->text;
    }


    /**
     *  敏感性替换
     * @param string $text
     * @return string
     */
    public static function ReplaceKeyWord(string $text)
    {

        $self = new self();
        $replaceText = $self->ReplaceText($text);

        return $replaceText;


    }


}

?>