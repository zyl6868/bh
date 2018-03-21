<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_waitReviewSchoolInfo".
 *
 * @property integer $id
 * @property string $schoolID
 * @property string $newDepartment
 * @property string $ndIsPass
 * @property string $ndSubTime
 * @property string $ndPassTime
 * @property string $ndPassUserID
 * @property string $ndSubUserID
 * @property string $isDelete
 */
class SeWaitReviewSchoolInfo extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_waitReviewSchoolInfo';
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
            [['id'], 'required'],
            [['id'], 'integer'],
            [['schoolID'], 'string', 'max' => 20],
            [['newDepartment', 'ndIsPass', 'ndSubTime', 'ndPassTime'], 'string', 'max' => 100],
            [['ndPassUserID', 'ndSubUserID'], 'string', 'max' => 300],
            [['isDelete'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'schoolID' => '学校',
            'newDepartment' => '带审核学部',
            'ndIsPass' => '是否通过审核 0:未审核，1：以审核，2：审核未通过',
            'ndSubTime' => '新学部提交时间',
            'ndPassTime' => '新学部通过时间',
            'ndPassUserID' => '新学部通过人',
            'ndSubUserID' => '新学部提交人',
            'isDelete' => '是否删除0：否1：是默认0',
        ];
    }

    /**
     * @inheritdoc
     * @return SeWaitReviewSchoolInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeWaitReviewSchoolInfoQuery(get_called_class());
    }
}
