<?php
namespace frontend\models;

use yii\base\Model;

/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 14-10-16
 * Time: 上午10:10
 */
class ExamForm extends Model
{
    public $classID;
    public $userID;
    public $examName;
    public $type;
    public $schoolYear;
    public $semester;
    public $subject;
    public $subjectTime;
    public $subjectList;
    public $paperId;
    public $score;
    public $examTime;

    public function rules()
    {
        return [
            [["classID", "examName", "schoolYear", "semester", "subject", "type"], "required"],
            [["classID", "type", "paperId", "examName", "schoolYear", "semester", "subject", "subjectTime", "subjectList", "score", "examTime"], "safe"],
        ];
    }

    public function attributeLabels()
    {
        return ["classID" => "classID",
            "userID" => "userID",
            "examName" => "examName",
            "type" => "type",
            "schoolYear" => "schoolYear",
            "semester" => "semester",
            "subject" => "subject",
            "subjectTime" => "subjectTime",
            "subjectList" => "subjectList",
            "paperId" => "paperId"
        ];
    }
}