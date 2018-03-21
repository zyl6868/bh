<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_schoolBrief".
 *
 * @property integer $briefID
 * @property string $schoolID
 * @property string $briefName
 * @property string $department
 * @property string $year
 * @property string $detailOfBrief
 * @property string $createTime
 * @property string $creatorID
 * @property string $nameOfCreator
 * @property string $isDelete
 */
class SeSchoolBrief extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_schoolBrief';
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
     * @return SeSchoolBriefQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSchoolBriefQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['briefID'], 'required'],
            [['briefID'], 'integer'],
            [['detailOfBrief'], 'string'],
            [['schoolID', 'year', 'createTime', 'creatorID'], 'string', 'max' => 20],
            [['briefName'], 'string', 'max' => 300],
            [['department', 'nameOfCreator'], 'string', 'max' => 50],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'briefID' => 'id',
            'schoolID' => '学校名称',
            'briefName' => '简介名称',
            'department' => '学部',
            'year' => '年份',
            'detailOfBrief' => '简介内容',
            'createTime' => '创建时间',
            'creatorID' => '创建人',
            'nameOfCreator' => '创建人姓名',
            'isDelete' => '是否删除 ',
        ];
    }
}
