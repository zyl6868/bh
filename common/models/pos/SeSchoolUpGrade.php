<?php
namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_schoolUpGrade".
 *
 * @property integer $schoolUpGradeID 自增id
 * @property integer $schoolID 学校id
 * @property integer $department 学段id
 * @property integer $upgradeTime 升级时间
 * @property integer $createTime 创建时间
 */
class SeSchoolUpGrade extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_schoolUpGrade';
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
            [['schoolID', 'department', 'upgradeTime'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'schoolUpGradeID' => 'schoolUpGradeID',
            'schoolID' => 'School ID',
            'department' => 'Department',
            'upgradeTime' => 'Upgrade Time',
        ];
    }

    /**
     * @inheritdoc
     * @return SeSchoolUpGradeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSchoolUpGradeQuery(get_called_class());
    }

    /**
     * 学校升级记录
     * @param $schoolID
     * @param $department
     * @param $beginTime
     * @param $endTime
     * @return array|SeSchoolUpGrade|null
     */
    public static function schoolUpGradeOne($schoolID, $department, $beginTime, $endTime)
    {
        return self::find()->where(['schoolID' => $schoolID, 'department' => $department])->andWhere(['between', 'upgradeTime', $beginTime, $endTime])->limit(1)->one();
    }


    /**
     * 检测学校是否设升级  检测每年 从1月1日开始 到 12月31日结束
     *
     * @param integer $schoolID 学校id
     * @param integer $department 学段id
     * @param integer $beginTime 开始时间
     * @param integer $endTime 结束时间
     * @return bool
     */
    public static function findSchoolUpGradeIsExists(int $schoolID, int $department)
    {
        $beginTime = strtotime(date('Y-1-1', time())) * 1000;
        $endTime = strtotime(date('Y-12-31 23:59:59', time())) * 1000;
        return self::find()->where(['schoolID' => $schoolID, 'department' => $department])->andWhere(['between', 'upgradeTime', $beginTime, $endTime])->exists();
    }

}
