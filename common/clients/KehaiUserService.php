<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/10/22
 * Time: 19:18
 */
namespace common\clients;
use Httpful\Mime;
use Httpful\Request;
use Yii;

class KehaiUserService {
    public $url='';
    public function __construct(){
        $this->url = Yii::$app->params['kehai'];
    }
    public   function getUserData($userID){
        $result= Request::post($this->url.'/collegeStuMsg/getCollegeStuMsg.e')
            ->body(http_build_query(array(
                "userId" => $userID
            )))
            ->sendsType(Mime::FORM)
            ->send();
        if($result->body->resCode=='000'){
            return $result->body->data;
        }else{
            return array();
        }

    }
    public static function model(){
        return new self();
    }
}