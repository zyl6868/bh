<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_questionTeamInfo".
 *
 * @property string $questionTeamID
 * @property string $questionTeamName
 * @property string $provience
 * @property string $city
 * @property string $country
 * @property string $gradeID
 * @property string $subjectID
 * @property string $connetID
 * @property string $labelName
 * @property string $questionTeamMark
 * @property string $isDelete
 * @property string $createTime
 * @property string $creatorID
 * @property string $disabled
 */
class SeQuestionTeamInfo extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_questionTeamInfo';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_school');
    }

    /**
     * @inheritdoc
     * @return SeQuestionTeamInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeQuestionTeamInfoQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['questionTeamID'], 'required'],
            [['questionTeamMark'], 'string'],
            [['questionTeamID', 'gradeID', 'subjectID', 'createTime', 'creatorID'], 'string', 'max' => 20],
            [['questionTeamName'], 'string', 'max' => 200],
            [['provience', 'city', 'country', 'connetID', 'labelName'], 'string', 'max' => 50],
            [['isDelete', 'disabled'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'questionTeamID' => 'Question Team ID',
            'questionTeamName' => 'Question Team Name',
            'provience' => 'Provience',
            'city' => 'City',
            'country' => 'Country',
            'gradeID' => 'Grade ID',
            'subjectID' => 'Subject ID',
            'connetID' => 'Connet ID',
            'labelName' => 'Label Name',
            'questionTeamMark' => 'Question Team Mark',
            'isDelete' => '是否已删除，0未删除，1已删除，默认0',
            'createTime' => 'Create Time',
            'creatorID' => 'Creator ID',
            'disabled' => '是否已经禁用
0：未禁用/激活/解禁/审核通过
1：已经禁用
',
        ];
    }
}
