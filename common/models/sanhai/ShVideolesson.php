<?php

namespace common\models\sanhai;

use Yii;

/**
 * This is the model class for table "sh_videolesson".
 *
 * @property integer $lid
 * @property string $gradeid
 * @property string $subjectid
 * @property string $versionid
 * @property string $classType
 * @property string $teacher
 * @property string $ischarge
 * @property string $introduce
 * @property string $price
 * @property string $tproportion
 * @property string $isAgreement
 * @property string $isDelete
 * @property string $creattime
 * @property string $disabled
 * @property string $imgurl
 * @property string $videoName
 * @property string $country
 * @property string $provience
 * @property string $city
 * @property string $classID
 * @property string $sProportion
 * @property string $isShare
 * @property string $lessonVideoType
 * @property string $videoUrl
 * @property string $schoolID
 * @property string $creatorID
 * @property string $groupID
 * @property string $matType
 * @property string $isStopSell
 * @property string $isFreeze
 */
class ShVideolesson extends SanhaiActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sh_videolesson';
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
            [['lid'], 'required'],
            [['lid'], 'integer'],
            [['introduce'], 'string'],
            [['gradeid', 'subjectid', 'versionid', 'classType', 'teacher', 'price', 'tproportion', 'creattime', 'country', 'provience', 'city', 'classID', 'lessonVideoType', 'schoolID', 'creatorID', 'groupID', 'matType'], 'string', 'max' => 20],
            [['ischarge', 'isAgreement', 'isDelete', 'isShare', 'isStopSell', 'isFreeze'], 'string', 'max' => 2],
            [['disabled'], 'string', 'max' => 10],
            [['imgurl', 'videoUrl'], 'string', 'max' => 200],
            [['videoName'], 'string', 'max' => 500],
            [['sProportion'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lid' => 'Lid',
            'gradeid' => 'Gradeid',
            'subjectid' => 'Subjectid',
            'versionid' => 'Versionid',
            'classType' => '班类型',
            'teacher' => '授课老师',
            'ischarge' => '是否需要付款',
            'introduce' => '介绍',
            'price' => '价格',
            'tproportion' => '教师分账比例',
            'isAgreement' => '是否已商定',
            'isDelete' => 'Is Delete',
            'creattime' => 'Creattime',
            'disabled' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
            'imgurl' => '广告url',
            'videoName' => '课程视频名称',
            'country' => '县',
            'provience' => '省',
            'city' => '市',
            'classID' => '班级id',
            'sProportion' => ' 学校分账比例',
            'isShare' => '是否分享',
            'lessonVideoType' => '课程视频类型0精品课程，1每周一课',
            'videoUrl' => '视频地址，每周一课时使用',
            'schoolID' => '学校ID',
            'creatorID' => '创建人id',
            'groupID' => '教研组id',
            'matType' => '3视频',
            'isStopSell' => 'Is Stop Sell',
            'isFreeze' => 'Is Freeze',
        ];
    }

    /**
     * @inheritdoc
     * @return ShVideolessonQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShVideolessonQuery(get_called_class());
    }
}
