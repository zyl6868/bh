<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_questionTeamNotes".
 *
 * @property string $notesID
 * @property string $notesTime
 * @property string $questionTeamID
 * @property string $isMessage
 * @property string $message
 * @property string $isAnswered
 * @property string $answerTime
 */
class SeQuestionTeamNotes extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_questionTeamNotes';
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
     * @return SeQuestionTeamNotesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeQuestionTeamNotesQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notesID'], 'required'],
            [['notesID', 'notesTime', 'questionTeamID', 'isAnswered', 'answerTime'], 'string', 'max' => 20],
            [['isMessage'], 'string', 'max' => 2],
            [['message'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notesID' => '推送学生id',
            'notesTime' => 'Notes Time',
            'questionTeamID' => 'Question Team ID',
            'isMessage' => '是否短信通知家长默认0   0 不通知 1 通知',
            'message' => 'Message',
            'isAnswered' => '是否答题',
            'answerTime' => '答题时间',
        ];
    }
}
