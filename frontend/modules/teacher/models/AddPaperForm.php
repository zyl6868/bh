<?php
/**
 * Created by PhpStorm.
 * User: ysd
 * Date: 14-11-15
 * Time: 上午11:00
 */

namespace frontend\modules\teacher\models;
use yii\base\Model;

class AddPaperForm extends  Model{
    public $questionTeamName;       //题目组名称
    public $provience;              //适用地区 省
    public $city;                   //市
    public $county;                 //区县
    public $gradeID;                //年级ID
    public $subjectID;                   //科目ID
    public $knowledgePoint;         //知识点
    public $labelName;              //自定义标签名称，多个用逗号隔开
    public $questionTeamMark;       //题目组描述
    //public $creatorID;            //创建人ID
    //public $questionID;           //关联的题目ID字符串  多个题目ID 用逗号隔开

    /**
     * @return array
     */
    public function rules()
    {
        return [
            //array("questionTeamName,provience,city,county,grade,item,knowledgePoint,labelName,questionTeamMark", "required"),
            [["questionTeamName","provience","city","county","gradeID","subjectID","knowledgePoint","labelName","questionTeamMark"], "safe"],
        ];
    }

    public function attributeLabels()
    {
        return [
            "questionTeamName"=>"QuestionTeamName",
            "provience"=>"Provience",
            "city"=>"City",
            "county"=>"County",
            "gradeID"=>"GradeID",
            "subjectID"=>"SubjectID",
            "knowledgePoint"=>"KnowledgePoint",
            "labelName"=>"LabelName",
            "questionTeamMark"=>"QuestionTeamMark",

           // "creatorID"=>"CreatorID",
           // "questionID"=>"QuestionID",
       ];
    }
}