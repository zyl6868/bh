<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_wrongQuestionAnswerPic".
 *
 * @property integer $id
 * @property string $answerUrl
 * @property string $answerRight
 * @property string $checkJson
 * @property string $answerId
 * @property string $checkUser
 */
class SeWrongQuestionAnswerPic extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_wrongQuestionAnswerPic';
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
            [['id'], 'required'],
            [['id'], 'integer'],
            [['answerUrl'], 'string', 'max' => 300],
            [['answerRight', 'answerId', 'checkUser'], 'string', 'max' => 20],
            [['checkJson'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'answerUrl' => '题目答案',
            'answerRight' => '答案是否正确 0错误 1正确',
            'checkJson' => '批改',
            'answerId' => '对应答案id',
            'checkUser' => '批改人',
        ];
    }

    /**
     * @inheritdoc
     * @return SeWrongQuestionAnswerPicQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeWrongQuestionAnswerPicQuery(get_called_class());
    }
}
