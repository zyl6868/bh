<?php
namespace frontend\models;

use yii\base\Model;

/**
 *  老师教研组
 * Class TeacherGroupForm
 */
class TeacherGroupForm extends Model
{

    /** 教研组ID
     * @var
     */
    public $groupID;

    /** 教研组名称
     * @var
     */
    public $groupName;

    /** 教研内身份
     * @var
     */
    public $identity;
    /**
     * 教研组职务名称
     * @var
     */
    public $identityName;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [


            [['groupID', 'groupName', 'identity'], 'required'],

            [['groupID', 'groupName', 'identity', 'identityName'], "safe"]
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
