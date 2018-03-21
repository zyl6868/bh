<?php

namespace common\models\sanhai;

use Yii;

/**
 * This is the model class for table "sh_lessonplan_delete".
 *
 * @property integer $lID
 * @property string $lName
 * @property string $areaID1
 * @property string $areaID2
 * @property string $areaID3
 * @property string $type
 * @property string $kid
 * @property string $tags
 * @property string $url
 * @property string $introduction
 * @property string $isDelete
 * @property string $createtime
 * @property string $gradeid
 * @property string $subjectid
 * @property string $versionid
 * @property string $school
 * @property string $plantype
 */
class ShLessonplanDelete extends SanhaiActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sh_lessonplan_delete';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sanku');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['introduction'], 'string'],
            [['lName', 'areaID1', 'areaID2', 'areaID3', 'type', 'kid', 'createtime', 'gradeid', 'subjectid', 'versionid'], 'string', 'max' => 20],
            [['tags', 'url'], 'string', 'max' => 100],
            [['isDelete', 'plantype'], 'string', 'max' => 2],
            [['school'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lID' => '教案id',
            'lName' => '教案名称',
            'areaID1' => '地区1',
            'areaID2' => '地区2',
            'areaID3' => '地区3',
            'type' => '类型',
            'kid' => 'FK知识点id',
            'tags' => '标签',
            'url' => '教案url',
            'introduction' => '简介',
            'isDelete' => '是否已删除 0：未删除 1：已删除 默认0',
            'createtime' => '教案创建时间',
            'gradeid' => 'Gradeid',
            'subjectid' => 'Subjectid',
            'versionid' => 'Versionid',
            'school' => 'School',
            'plantype' => '存储类型，1 ：讲义，2：教案，3：讲义',
        ];
    }

    /**
     * @inheritdoc
     * @return ShLessonplanDeleteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShLessonplanDeleteQuery(get_called_class());
    }
}
