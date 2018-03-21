<?php

namespace common\models\sanhai;

use Yii;

/**
 * This is the model class for table "sh_question_paper".
 *
 * @property string $paperId
 * @property string $paperName
 * @property integer $gradeId
 * @property string $gradeName
 * @property integer $subjectId
 * @property string $subjectName
 * @property string $versionId
 * @property string $versionName
 * @property string $allquestionCount
 * @property string $country
 * @property string $city
 * @property string $provience
 * @property integer $department
 * @property string $testArea
 * @property string $creatorId
 * @property string $createTime
 * @property string $updateId
 * @property string $updateTime
 */
class ShQuestionPaper extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sh_question_paper';
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
            [['gradeId', 'subjectId', 'allquestionCount', 'department', 'creatorId', 'createTime', 'updateId', 'updateTime'], 'integer'],
            [['paperName'], 'string', 'max' => 200],
            [['gradeName'], 'string', 'max' => 50],
            [['subjectName', 'versionName', 'city'], 'string', 'max' => 20],
            [['versionId'], 'string', 'max' => 300],
            [['country'], 'string', 'max' => 100],
            [['provience', 'testArea'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'paperId' => 'Paper ID',
            'paperName' => 'Paper Name',
            'gradeId' => 'Grade ID',
            'gradeName' => 'Grade Name',
            'subjectId' => 'Subject ID',
            'subjectName' => 'Subject Name',
            'versionId' => 'Version ID',
            'versionName' => 'Version Name',
            'allquestionCount' => 'Allquestion Count',
            'country' => 'Country',
            'city' => 'City',
            'provience' => 'Provience',
            'department' => 'Department',
            'testArea' => 'Test Area',
            'creatorId' => 'Creator ID',
            'createTime' => 'Create Time',
            'updateId' => 'Update ID',
            'updateTime' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return ShQuestionPaperQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShQuestionPaperQuery(get_called_class());
    }
}
