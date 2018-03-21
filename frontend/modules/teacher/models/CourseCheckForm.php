<?php

/**
 * Created by PhpStorm.
 * User: liquan
 * Date: 14-11-03
 * Time: PM 18:45
 */

namespace frontend\modules\teacher\models;
use yii\base\Model;

class CourseCheckForm extends Model
{
    /**
     * 班级ID
     * @var
     */
    public $classId;

    /** 科目ID
     * @var
     */
    public $subjectID;
    /**
     * 	总结名称
     * @var
     */
    public $summarizeName;
    /**
     *	开始时间
     * @var
     */
    public $beginTime;
    /**
     * 结束时间
     * @var
     */
    public $finishTime;

    /** 学习氛围
     * @var
     */
    public $classAtmosphere;
    /**
     * 学习计划
     */
    public $studyPlan;
    /**
     * 难点
     */
    public $knowledgepoint;
    /**
     * 创建人
     */
    public $creatorID;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [["classId","summarizeName","beginTime","finishTime","classAtmosphere","studyPlan","knowledgepoint","creatorID"], 'required'],
            [['classId','summarizeName','beginTime','finishTime','classAtmosphere','studyPlan','knowledgepoint','creatorID'], 'safe'],
       ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            "classId" => "classId",
            "summarizeName" => "summarizeName",
            "beginTime" => "beginTime",
            "finishTime" => "finishTime",
            "classAtmosphere" => "classAtmosphere",
            "studyPlan" => "studyPlan",
            "knowledgepoint" => "knowledgepoint",
            "creatorID" => "creatorID",
       ];
    }

}
