<?php

namespace common\models\pos;

use common\helper\DateTimeHelper;
use Yii;

/**
 * This is the model class for table "se_exam_class".
 *
 * @property integer $classExamId 班级考试id
 * @property integer $schoolExamId 学校考试id
 * @property integer $classId 班级id
 * @property integer $inputStatus 成绩录入状态，0未录入，1录入中，2录入完成
 * @property integer $createTime 创建时间
 * @property integer $updateTime 更新时间
 */
class SeExamClass extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_exam_class';
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
            [['schoolExamId', 'classId', 'inputStatus', 'createTime', 'updateTime'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'classExamId' => '班级考试id',
            'schoolExamId' => '学校考试id',
            'classId' => '班级id',
            'inputStatus' => '成绩录入状态，0未录入，1录入中，2录入完成',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SeExamClassQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeExamClassQuery(get_called_class());
    }

    public function afterSave($insert , $changedAttributes)
    {
            parent::afterSave($insert,$changedAttributes);

            if(!$insert){
                if($this->inputStatus == 2){
                    $classNum = $this::find()->where(['schoolExamId'=>$this->schoolExamId])->count();
                    $count = $this::find()->where(['schoolExamId'=>$this->schoolExamId ,'inputStatus'=>2])->count();
                    if($classNum == $count){
                        SeExamSchool::updateAll(['inputStatus'=>2 , 'updateTime'=>DateTimeHelper::timestampX1000()] ,'schoolExamId=:schoolExamId' , [':schoolExamId'=>$this->schoolExamId]);
                    }
                }
                if($this->inputStatus == 1){
                    SeExamSchool::updateAll(['inputStatus'=>1 , 'updateTime'=>DateTimeHelper::timestampX1000()] ,'schoolExamId=:schoolExamId' , [':schoolExamId'=>$this->schoolExamId]);
                }

                if($this->inputStatus == 0){
                    $halfCount = $this::find()->where(['schoolExamId'=>$this->schoolExamId ,'inputStatus'=>1])->limit(1)->one();
                    $finishCount = $this::find()->where(['schoolExamId'=>$this->schoolExamId ,'inputStatus'=>2])->limit(1)->one();
                    if($halfCount || $finishCount){
                        SeExamSchool::updateAll(['inputStatus'=>1 , 'updateTime'=>DateTimeHelper::timestampX1000()] ,'schoolExamId=:schoolExamId' , [':schoolExamId'=>$this->schoolExamId]);
                    }else{
                        SeExamSchool::updateAll(['inputStatus'=>0 , 'updateTime'=>DateTimeHelper::timestampX1000()] ,'schoolExamId=:schoolExamId' , [':schoolExamId'=>$this->schoolExamId]);
                    }
                }
            }

    }

    /**
     * 根据学校考试id获取班级id
     * @param integer $schoolExamId 学校考试id
     * @return array|SeExamClass[]
     */
    public static function getClassId(int $schoolExamId)
    {
        return self::find()->where(['schoolExamId'=>$schoolExamId])->select('classId')->all();
    }
}
