<?php
namespace frontend\models;

use yii\base\Model;

class CustomizedForm extends Model
{


    public $paperId;
    public $teacherId;
    public $studentId;
    public $planName;
    public $knowledges;
    public $planDescribe;
    public $planDetails;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [["knowledges"], "required", 'message' => '知识点不能为空',],
            [["planDescribe"], 'required', 'message' => '计划描述不能为空',],
            [["planName"], 'required', 'message' => '计划名称不能为空',],
            [["planDescribe", "planName"], 'length', 'min' => 3,],
            [["paperId", "teacherId", "studentId", "planName", "knowledges", "planDescribe", "planDetails"], "safe",]
        ];
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'paperId' => '试卷号',
            'teacherId' => '教师号',
            'studentId' => '学生号',
            'planName' => '规划名称',
            'knowledges' => '知识点',
            'planDescribe' => '计划描述',
            'planDetails' => '具体计划',
        );
    }


}
