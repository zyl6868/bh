<?php
namespace frontend\models;

use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2014/11/6
 * Time: 16:00
 */
class NewCourseForm extends Model
{

    public $creatorID;      //课程创建人
    public $courseName;     //课程名称
    public $filesID;        //资源ID的字符串，多个用逗号隔开(知识点或者章节的ID)
    public $connetID;       //课程相关类型Id 0:知识点 1:章节
    public $handoutID;      //讲义ID 字符串
    public $beginTime;      //上课开始时间
    public $finishTime;     //上课结束时间
    public $url;            //广告URL
    public $courseBrief;    //课程介绍
    public $classId;        //班级id
    public $subjectID;      //科目id
    public $teacherID;      //上课老师id。

    public $versionID;      //版本
    public $gradeID;              //年级


    public function rules()
    {
        return [
            [["creatorID", "courseName", "filesID", "connetID", "handoutID", "beginTime", "finishTime", "url", "courseBrief", "classId", "subjectID", "teacherID", "versionID", "gradeID"], "required"],
            [['creatorID', 'courseName', 'filesID', 'connetID', 'handoutID', 'beginTime', 'finishTime', 'url', 'courseBrief', 'classId', 'subjectID', 'teacherID', 'versionID', 'gradeID'], "safe"],
            [['creatorID', 'courseName', 'filesID', 'connetID', 'handoutID', 'beginTime', 'finishTime', 'url', 'courseBrief', 'classId', 'subjectID', 'teacherID', 'versionID', 'gradeID'], "safe", "on" => "search"],
        ];
    }

    public function attributeLabels()
    {
        return array(
            'creatorID' => 'creatorID',
            'courseName' => 'courseName',
            'filesID' => 'filesID',
            'connetID' => 'connetID',
            'handoutID' => 'handoutID',
            'beginTime' => 'beginTime',
            'finishTime' => 'finishTime',
            'url' => 'url',
            'courseBrief' => 'courseBrief',
            'classId' => 'classId',
            'subjectID' => 'subjectID',
            'teacherID' => 'teacherID',
            'versionID' => 'versionID',
            'gradeID' => 'gradeID',
        );
    }


}