<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_edcInformationCritic".
 *
 * @property integer $commentID
 * @property integer $informationID
 * @property string $commentContent
 * @property string $commentTime
 * @property integer $commentUserID
 * @property string $isReport
 * @property string $isDelete
 * @property integer $commentType
 * @property string $informationName
 * @property string $disabled
 */
class SeEdcInformationCritic extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_edcInformationCritic';
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
            [['commentID'], 'required'],
            [['commentID', 'informationID', 'commentUserID', 'commentType'], 'integer'],
            [['commentContent'], 'string'],
            [['commentTime'], 'string', 'max' => 20],
            [['isReport', 'isDelete', 'disabled'], 'string', 'max' => 2],
            [['informationName'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'commentID' => '评论ID',
            'informationID' => '评论对象id',
            'commentContent' => '评论内容',
            'commentTime' => '评论时间',
            'commentUserID' => '评论人ID',
            'isReport' => '是否举报',
            'isDelete' => '是否已删除',
            'commentType' => '评论类型',
            'informationName' => '评论对象名称',
            'disabled' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
        ];
    }

    /**
     * @inheritdoc
     * @return SeEdcInformationCriticQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeEdcInformationCriticQuery(get_called_class());
    }
}
