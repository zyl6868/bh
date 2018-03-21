<?php
namespace frontend\models;

use yii\base\Model;

class EvaluationForm extends Model
{


    public $paperId;
    public $teacherId;
    public $studentId;
    public $knowledges;
    public $correctResult;
    public $evaluateResult;
    public $advise;
    public $resultId;


    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [["knowledges"], 'required', 'message' => '知识点不能为空',],
            [["evaluateResult"], 'required', 'message' => '评测结果不能为空',],
            [['advise'], 'required', 'message' => '学习建议不能为空',],
            [['evaluateResult', 'advise'], 'length', 'min' => 3,],
            [["resultId", "advise", "correctResult", "evaluateResult", "knowledges"], 'safe',]
//            array("resultId,advise,correctResult", 'safe','on'=>'search'),
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
            'knowledges' => '知识点',
            'correctResult' => '批改结果',
            'evaluateResult' => '评测结果',
            'advise' => '学习建议',
        );
    }


}
