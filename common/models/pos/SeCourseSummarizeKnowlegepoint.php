<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_courseSummarize_knowlegepoint".
 *
 * @property integer $ID
 * @property string $summarizeID
 * @property string $KID
 * @property string $knowlegeName
 * @property string $isDelete
 */
class SeCourseSummarizeKnowlegepoint extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_courseSummarize_knowlegepoint';
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
            [['ID'], 'required'],
            [['ID'], 'integer'],
            [['summarizeID', 'KID'], 'string', 'max' => 20],
            [['knowlegeName'], 'string', 'max' => 50],
            [['isDelete'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'Id',
            'summarizeID' => '课程总结id',
            'KID' => '知识点id',
            'knowlegeName' => '知识点名称',
            'isDelete' => '是否已删除',
        ];
    }

    /**
     * @inheritdoc
     * @return SeCourseSummarizeKnowlegepointQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeCourseSummarizeKnowlegepointQuery(get_called_class());
    }
}
