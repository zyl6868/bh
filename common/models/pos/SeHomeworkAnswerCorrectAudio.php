<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_homeworkAnswerCorrectAudio".
 *
 * @property integer $id
 * @property integer $homeworkAnswerID
 * @property string $audioUrl
 * @property integer $createTime
 */
class SeHomeworkAnswerCorrectAudio extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homeworkAnswerCorrectAudio';
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
     */
    public function rules()
    {
        return [
            [['homeworkAnswerID', 'createTime'], 'integer'],
            [['audioUrl'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'homeworkAnswerID' => '答题卡id',
            'audioUrl' => '音频',
            'createTime' => '创建时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SeHomeworkAnswerCorrectAudioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkAnswerCorrectAudioQuery(get_called_class());
    }
}
