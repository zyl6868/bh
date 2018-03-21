<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_testAnswerDetailQuestion".
 *
 * @property integer $tID
 * @property string $testAnswerID
 * @property string $questionID
 * @property string $answerDetail
 * @property string $checkInfoJson
 * @property string $isDelete
 * @property string $isRight
 * @property string $getScore
 * @property string $pId
 */
class SeTestAnswerDetailQuestion extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_testAnswerDetailQuestion';
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
            [['tID'], 'required'],
            [['tID'], 'integer'],
            [['checkInfoJson'], 'string'],
            [['testAnswerID', 'questionID', 'getScore', 'pId'], 'string', 'max' => 20],
            [['answerDetail'], 'string', 'max' => 500],
            [['isDelete', 'isRight'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tID' => 'id',
            'testAnswerID' => '测验答案id',
            'questionID' => '问题id',
            'answerDetail' => '答案详情',
            'checkInfoJson' => '批改信息json',
            'isDelete' => 'Is Delete',
            'isRight' => '是否正确0：错误，1正确，2未判定',
            'getScore' => '此题得分',
            'pId' => '父id',
        ];
    }

    /**
     * @inheritdoc
     * @return SeTestAnswerDetailQuestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeTestAnswerDetailQuestionQuery(get_called_class());
    }
}
