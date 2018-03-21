<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_replayInformation".
 *
 * @property integer $replayID
 * @property integer $commentID
 * @property string $replayContent
 * @property string $replayTime
 * @property integer $replayUserID
 * @property string $isReport
 * @property string $isDelete
 * @property integer $preplayID
 * @property integer $replayTargetUserID
 * @property integer $replayType
 * @property string $disabled
 */
class SeReplayInformation extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_replayInformation';
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
     * @return SeReplayInformationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeReplayInformationQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['replayID'], 'required'],
            [['replayID', 'commentID', 'replayUserID', 'preplayID', 'replayTargetUserID', 'replayType'], 'integer'],
            [['replayContent'], 'string'],
            [['replayTime'], 'string', 'max' => 20],
            [['isReport', 'isDelete', 'disabled'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'replayID' => '回复ID',
            'commentID' => '被评论资讯id',
            'replayContent' => '回复内容',
            'replayTime' => '回复时间',
            'replayUserID' => '回复人ID',
            'isReport' => '是否举报',
            'isDelete' => '是否已删除',
            'preplayID' => '被回复的回复id',
            'replayTargetUserID' => '被回复人ID',
            'replayType' => '回复类型',
            'disabled' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
        ];
    }
}
