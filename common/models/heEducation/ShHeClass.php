<?php

namespace common\models\heEducation;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "sh_he_class".
 *
 * @property integer $hClassId
 * @property string $className
 * @property integer $classNumber
 * @property integer $gradeId
 * @property integer $hSchoolId
 * @property string $joinYear
 * @property integer $classId
 * @property string $createTime
 * @property string $updateTime
 *
 * @property ShHeSchoolInfo $hSchool
 * @property ShHeClassMember[] $shHeClassMembers
 */
class ShHeClass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sh_he_class';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_he_edu');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hClassId'], 'required'],
            [['hClassId', 'hSchoolId', 'classId','classNumber','gradeId'], 'integer'],
            [['createTime', 'updateTime'], 'safe'],
            [['className'], 'string', 'max' => 20],
            [['joinYear'], 'string', 'max' => 4]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hClassId' => 'H Class ID',
            'className' => 'Class Name',
            'classNumber' => 'Class Number',
            'gradeId' => 'Grade ID',
            'hSchoolId' => 'H School ID',
            'joinYear' => 'Join Year',
            'classId' => 'Class ID',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHSchool()
    {
        return $this->hasOne(ShHeSchoolInfo::className(), ['hSchoolId' => 'hSchoolId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShHeClassMembers()
    {
        return $this->hasMany(ShHeClassMember::className(), ['hClassId' => 'hClassId']);
    }

    /**
     * @inheritdoc
     * @return ShHeClassQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShHeClassQuery(get_called_class());
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\AttributeBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createTime','updateTime'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updateTime'],
                ],
                'value' => date('Y-m-d H:i:s',time()),
            ],
        ];

    }

    /**
     * 保存班级
     * @param $heUser
     * @return array
     */
    public static function addClass($heUser){

        $classes = $heUser->education->classes;

        $classModelArr = [];
        foreach ($classes as $item){
            $classModel = self::find()->where(['hClassId'=>$item->classid])->one();

            if($classModel == null){
                $classModel = new self();
                self::getDb()->useMaster(function () use ($item,$classModel){
                    $classModel->hClassId = $item->classid;
                    $classModel->className = $item->classname;
                    $classModel->hSchoolId = $item->schoolid;
                    $classModel->joinYear = $item->year;

                    $classNumber = 1;
                    $classInfo = self::find()->where(['hSchoolId'=>$item->schoolid,'joinYear'=>$item->year])->max('classNumber');
                    if($classInfo){
                        $classNumber = $classInfo+1;
                    }

                    $classModel->classNumber = $classNumber;
                    $classModel->gradeId = self::getGradeByJoinYear($item->year);
                    $classModel->save(false);
                });

            }

            if($classModel->gradeId && $classModel->classNumber && $classModel->joinYear){
                $classModelArr[] = $classModel;
            }
        }
        return $classModelArr;
    }


    public static function  getGradeByJoinYear(int $joinYear) {
        $gradeId = 0;

        $nowYear = date('Y',time());

        $overTime=$nowYear.'-09-01';
        $overStrtotime=strtotime($overTime);

        if(time()>$overStrtotime){
            $nowYear=$nowYear+1;
        }

        $year = $nowYear-$joinYear;

        switch($year){
            case 0:
                $gradeId = 1001;
                break;
            case 1:
                $gradeId = 1002;
                break;
            case 2:
                $gradeId = 1003;
                break;
            case 3:
                $gradeId = 1004;
                break;
            case 4:
                $gradeId = 1005;
                break;
            case 5:
                $gradeId = 1006;
                break;
            case 6:
                $gradeId = 1007;
                break;
            case 7:
                $gradeId = 1008;
                break;
            case 8:
                $gradeId = 1009;
                break;
            case 9:
                $gradeId = 1010;
                break;
            case 10:
                $gradeId = 1011;
                break;
            case 11:
                $gradeId = 1012;
                break;
        }

        return $gradeId;

    }

}
