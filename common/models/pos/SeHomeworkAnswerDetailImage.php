<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_homeworkAnswerDetailImage".
 *
 * @property string $tID
 * @property string $homeworkAnswerID
 * @property string $imageUrl
 * @property string $checkInfoJson
 * @property string $isDelete
 */
class SeHomeworkAnswerDetailImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homeworkAnswerDetailImage';
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
//            [['tID'], 'required'],
            [['tID'], 'integer'],
            [['checkInfoJson'], 'string'],
            [['homeworkAnswerID'], 'string', 'max' => 20],
            [['imageUrl'], 'string', 'max' => 300],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tID' => '主键ID',
            'homeworkAnswerID' => '作业答案ID',
            'imageUrl' => '图片',
            'checkInfoJson' => '批改结果',
            'isDelete' => 'Is Delete',
        ];
    }

    /**
     * @inheritdoc
     * @return SeHomeworkAnswerDetailImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkAnswerDetailImageQuery(get_called_class());
    }

    /**
     * 根据 作业答案id 查询作答图片
     * @param integer $homeworkAnswerID 作业答案id
     * @return array|SeHomeworkAnswerDetailImage[]
     */
    public static function getHomeworkAnswerDetailImageUrl(int $homeworkAnswerID)
    {
        if($homeworkAnswerID > 0){
            return self::find()->where(['homeworkAnswerID' => $homeworkAnswerID])->select('imageUrl')->asArray()->all();
        }
        return null;
    }
}
