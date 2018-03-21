<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_schoolSummary".
 *
 * @property integer $schoolID
 * @property string $brief
 * @property integer $creatorID
 * @property integer $status
 * @property integer $createTime
 * @property integer $updateTime
 */
class SeSchoolSummary extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_schoolSummary';
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
            [['schoolID'], 'required'],
            [['schoolID', 'creatorID', 'status', 'createTime', 'updateTime'], 'integer'],
            [['brief'], 'string', 'max' => 20000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'schoolID' => '学校id',
            'brief' => '简介',
            'creatorID' => 'Creator ID',
            'status' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
            'createTime' => '创建时间',
            'updateTime' => '最后一次修改时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SeSchoolSummaryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSchoolSummaryQuery(get_called_class());
    }

    /**
     * 获取学校简介信息
     * @param integer $schoolId 学校ID
     * @return array|SeSchoolSummary|null
     */
    public static function getSchoolSummary(int $schoolId)
    {
        if($schoolId){
            return self::find()->where(['schoolID' => $schoolId, 'status' => 0])->limit(1)->one();
        }
        return null;
    }

}
