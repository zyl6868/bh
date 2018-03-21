<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_superstudentdiary".
 *
 * @property integer $id
 * @property string $title
 * @property string $subjectID
 * @property string $type
 * @property string $content
 * @property string $summary
 * @property string $createTime
 * @property string $creatorID
 * @property string $isDelete
 * @property string $updateTime
 */
class SeSuperstudentdiary extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_superstudentdiary';
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
     * @return SeSuperstudentdiaryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSuperstudentdiaryQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['subjectID', 'type', 'createTime', 'creatorID', 'updateTime'], 'string', 'max' => 20],
            [['summary'], 'string', 'max' => 500],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '名字',
            'subjectID' => '科目',
            'type' => '类型',
            'content' => 'uri',
            'summary' => '总结',
            'createTime' => 'Create Time',
            'creatorID' => '创建人id ',
            'isDelete' => 'Is Delete',
            'updateTime' => 'Update Time',
        ];
    }
}
