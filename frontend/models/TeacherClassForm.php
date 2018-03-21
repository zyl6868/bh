<?php
namespace frontend\models;

use yii\base\Model;

/**
 * 老师教的班级
 * Class TeacherClassForm
 */
class TeacherClassForm extends Model
{

    /**
     *  班级
     * @var
     */
    public $classID;
    /**
     * 班级名称
     * @var
     */
    public $className;
    /**
     * 班内身份
     * @var
     */
    public $identity;
    /**
     * 教授科目
     * @var
     */
    public $subjectNumber;


    /**
     * 班级职务
     * @var
     */
    public $job;

    /**
     * 学生学号
     * @var
     */
    public $stuID;


    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [


            // array('classID, identity', 'required'),

            [['classID', 'className', 'identity', 'subjectNumber', 'job'], "safe"]
        ];
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array();
    }


}
