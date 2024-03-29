<?php

namespace common\models\sanhai;

use Yii;

/**
 * This is the model class for table "sh_testquestion_paper".
 *
 * @property string $id
 * @property string $paperName
 * @property string $questionCount
 * @property string $gradeId
 * @property string $gradeName
 * @property string $subjectId
 * @property string $subjectName
 * @property string $versionId
 * @property string $versionName
 * @property integer $userId
 * @property string $userName
 * @property string $checked
 * @property string $tranCount
 * @property string $checkuserId
 * @property string $checkuserName
 * @property string $checkNum
 * @property string $notCheckNum
 * @property string $paperId
 * @property string $vUserId
 * @property string $vUserName
 * @property integer $vCompleteCount
 * @property string $vCheckUserId
 * @property string $vCheckUserName
 * @property string $vTranTime
 * @property string $allquestionCount
 * @property string $country
 */
class ShTestquestionPaper extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sh_testquestion_paper';
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
            [['questionCount', 'userId', 'tranCount', 'checkuserId', 'checkNum', 'notCheckNum', 'paperId', 'vUserId', 'vCompleteCount', 'vCheckUserId', 'vTranTime', 'allquestionCount'], 'integer'],
            [['id', 'paperName', 'userName'], 'string', 'max' => 200],
            [['gradeId', 'subjectId', 'subjectName', 'versionName', 'checked', 'checkuserName'], 'string', 'max' => 20],
            [['gradeName'], 'string', 'max' => 50],
            [['versionId'], 'string', 'max' => 300],
            [['vUserName', 'vCheckUserName'], 'string', 'max' => 100],
            [['country'], 'string', 'max' => 19]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'paperName' => 'Paper Name',
            'questionCount' => 'Question Count',
            'gradeId' => 'Grade ID',
            'gradeName' => 'Grade Name',
            'subjectId' => 'Subject ID',
            'subjectName' => 'Subject Name',
            'versionId' => 'Version ID',
            'versionName' => 'Version Name',
            'userId' => 'User ID',
            'userName' => 'User Name',
            'checked' => 'Checked',
            'tranCount' => 'Tran Count',
            'checkuserId' => 'Checkuser ID',
            'checkuserName' => 'Checkuser Name',
            'checkNum' => 'Check Num',
            'notCheckNum' => 'Not Check Num',
            'paperId' => 'Paper ID',
            'vUserId' => 'V User ID',
            'vUserName' => 'V User Name',
            'vCompleteCount' => 'V Complete Count',
            'vCheckUserId' => 'V Check User ID',
            'vCheckUserName' => 'V Check User Name',
            'vTranTime' => 'V Tran Time',
            'allquestionCount' => 'Allquestion Count',
            'country' => 'Country',
        ];
    }

    /**
     * @inheritdoc
     * @return ShTestquestionPaperQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShTestquestionPaperQuery(get_called_class());
    }
}
