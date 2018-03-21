<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-10-23
 * Time: 下午4:57
 */
namespace frontend\modules\teacher\models;
use yii\base\Model;

class HomeContactForm extends Model{
    public $title;
    public $receiverType;
    public $sendWay;
    public $rankingChg;
    public $weakPoint;
    public $addContent;
    public $examId;
    public $classId;
    public $scope;
    public $id;
    public $creator;
    public $reference;// 相关性 1考试反馈 2日常表现 3通知 4作业
    public $subjectId;//科目id
    public $kids;//知识点
    public $urls;//图片

    public function rules()
    {
        return [
            [["title",'receiverType','sendWay','classId',"reference"], "required"],
            [["title",'receiverType','sendWay','examId','rankingChg','weakPoint','addContent','classId','scope','id','reference','subjectId','kids',"urls"], "safe"],
        ];
    }
    public function attributeLabels()
    {
        return [
            "title" => "title",
            "receiverJson" => "receiverJson",
            "sendWay" => "sendWay",
            "rankingChg" => "rankingChg",
            "weakPoint" => "weakPoint",
            "addContent" => "addContent",
            "examId" => "examId",
            "classId"=>"classId",
            "scope"=>"scope",
            "id"=>"id",
            "reference"=>"reference",
            "subjectId"=>"subjectId",
            "kids"=>"kids",
            "urls"=>"urls"
       ];
    }
}