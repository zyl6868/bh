<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_courseComment".
 *
 * @property integer $commentID
 * @property string $courseID
 * @property string $receiveMessageID
 * @property string $userID
 * @property string $userName
 * @property string $time
 * @property string $content
 * @property string $isDelete
 * @property string $disabled
 */
class SeCourseComment extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_courseComment';
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
     * @return SeCourseCommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeCourseCommentQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['commentID'], 'required'],
            [['commentID'], 'integer'],
            [['content'], 'string'],
            [['courseID', 'receiveMessageID', 'userID', 'time'], 'string', 'max' => 20],
            [['userName'], 'string', 'max' => 50],
            [['isDelete', 'disabled'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'commentID' => '评论消息id',
            'courseID' => '课程id',
            'receiveMessageID' => '回复消息id',
            'userID' => '评论人id',
            'userName' => '评论人姓名',
            'time' => '时间',
            'content' => '内容',
            'isDelete' => '是否已经删除',
            'disabled' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
        ];
    }
}
