<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_answerdetailinfo".
 *
 * @property integer $id
 * @property string $pID
 * @property string $imageURL
 * @property string $uploadTime
 * @property string $isDelete
 * @property string $isChecked
 * @property string $paperScore
 * @property string $examSubID
 */
class SeAnswerdetailinfo extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_answerdetailinfo';
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
     * @return SeAnswerdetailinfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeAnswerdetailinfoQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['pID', 'uploadTime', 'examSubID'], 'string', 'max' => 30],
            [['imageURL'], 'string', 'max' => 500],
            [['isDelete', 'isChecked'], 'string', 'max' => 50],
            [['paperScore'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pID' => 'answerinfo表中的ID',
            'imageURL' => '图片地址',
            'uploadTime' => '上传时间',
            'isDelete' => '是否删除0：否1：是默认0',
            'isChecked' => '是否批阅0：否1：是默认0',
            'paperScore' => '卷面成绩',
            'examSubID' => '考试科目id',
        ];
    }
}
