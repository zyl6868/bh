<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_answerInfo_filesInfo".
 *
 * @property integer $filesID
 * @property string $answerID
 * @property string $filesType
 * @property string $url
 * @property string $isDelete
 */
class SeAnswerInfoFilesInfo extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_answerInfo_filesInfo';
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
            [['filesID'], 'required'],
            [['filesID'], 'integer'],
            [['answerID', 'filesType'], 'string', 'max' => 20],
            [['url'], 'string', 'max' => 100],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'filesID' => '作业答案附件id',
            'answerID' => '作业答案id',
            'filesType' => '附件类型',
            'url' => '附件URL',
            'isDelete' => '是否删除',
        ];
    }

    /**
     * @inheritdoc
     * @return SeAnswerInfoFilesInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeAnswerInfoFilesInfoQuery(get_called_class());
    }
}
