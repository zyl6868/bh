<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2014/12/10
 * Time: 11:45
 */

namespace frontend\modules\teacher\models;
use yii\base\Model;

class UpdateCourseForm extends Model
{
    public $courseID;	    //课程ID
    public $courseName;     //课程名称
    public $subjectID;      //学科id
    public $subjectName;    //科目名称
    public $classId;        //班级id
    public $className;      //班级名称
    public $connetID;       //知识点或章节id
    public $filesID;        //知识点或章节
    public $handoutID;      //讲义ID
    public $beginTime;      //开始时间
    public $finishTime;     //结束时间
    public $url;            //图片
    public $courseBrief;    //课程介绍
    public $teacherID;      //上课老师ID
    public $teacherName;    //上课老师名称
    public $creatorID;      //创建人ID

    public $versionID;	    //教材版本
    public $gradeID;	        //年级


    /*
    * @return array
    */
    public function rules()
    {
        return [
            [["courseID", 'courseName', 'filesID', 'connetID', 'handoutID','beginTime',' finishTime','classId','subjectID', 'teacherID','versionID','gradeID'], "required"],
            [["courseID",'courseName', 'subjectID', 'subjectName',' classId',' className', 'connetID', 'filesID',' handoutID','beginTime',' finishTime','url', 'courseBrief', 'teacherID', 'teacherName', 'creatorID', 'versionID',"gradeID"], "safe"],
        ];
    }

    /*
     * @return array
     */
    public function attributeLabels(){
        return [
            "courseID" => "courseID",
            "creatorID" => "creatorID",
            "courseName" => "courseName",
            "gradeID" => "gradeID",
            "subjectID" => "subjectID",
            "subjectName" => "subjectName",
            "classId" => "classId",
            "className" => "className",
            "connetID" => "connetID",
            "filesID" => "filesID",
            "handoutID" => "handoutID",
            "beginTime" => "beginTime",
            "finishTime" => "finishTime",
            "url" => "url",
            "courseBrief" => "courseBrief",
            "teacherID" => "teacherID",
            "teacherName" => "teacherName",
            "versionID" => "versionID",

        ];
    }
}

