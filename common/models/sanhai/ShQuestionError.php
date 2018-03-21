<?php

namespace common\models\sanhai;

use Yii;

/**
 * This is the model class for table "sh_question_error".
 *
 * @property integer $questionErrorId
 * @property integer $questionId
 * @property string $brief
 * @property integer $userId
 * @property string $userName
 * @property integer $auditorId
 * @property string $auditorName
 * @property integer $isPass
 * @property string $createTime
 * @property string $auditTime
 * @property string $updateTime
 * @property string errorType
 */
class ShQuestionError extends SanhaiActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sh_question_error';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sanku');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['questionId', 'userId'], 'required'],
            [['questionErrorId', 'questionId', 'userId', 'auditorId', 'isPass'], 'integer'],
            [['createTime', 'auditTime', 'updateTime'], 'safe'],
            [['brief','errorType'], 'string', 'max' => 500],
            [['userName', 'auditorName'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'questionErrorId' => '错误ID',
            'questionId' => '错题ID',
            'brief' => '错误描述',
            'userId' => '用户ID',
            'errorType'=>'错误类型',
            'userName' => '用户名称',
            'auditorId' => '审核人ID',
            'auditorName' => '审核人名称',
            'isPass' => '是否通过审核,1未通过审核,0通过审核',
            'createTime' => '创建时间',
            'auditTime' => '审核时间',
            'updateTime' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     * @return ShQuestionErrorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShQuestionErrorQuery(get_called_class());
    }
} 