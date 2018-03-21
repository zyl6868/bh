<?php
/**
 * Created by PhpStorm.
 * User: ysd
 * Date: 14-11-18
 * Time: 下午2:15
 */
namespace frontend\modules\teacher\models;
use yii\base\Model;

class TopicPushForm extends Model{

    public $questionTeamID;
    public $isMessage;
    public $message;


    public function rules()
    {
        return [
            [["questionTeamID"], "required"],
            [["questionTeamID",'isMessage',"message"], "safe"],
        ];
    }
    public function attributeLabels()
    {
        return [
            "questionTeamID" => "questionTeamID",
            "isMessage" => "isMessage",
            "message" => "message",
        ];
    }
}