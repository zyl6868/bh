<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_exam_classSubject".
 *
 * @property integer $examSubTeaId
 * @property integer $examSubId
 * @property integer $classExamId
 * @property integer $teacherId
 * @property integer $createTime
 * @property integer $updateTime
 * @property integer $schoolExamId
 */
class SeExamClassSubject extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_exam_classSubject';
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
            [['examSubId', 'classExamId', 'teacherId', 'createTime', 'schoolExamId'], 'required'],
            [['examSubId', 'classExamId', 'teacherId', 'createTime', 'updateTime', 'schoolExamId'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'examSubTeaId' => '考试科目教师表主键',
            'examSubId' => '考试科目主键id',
            'classExamId' => '班级考试id',
            'teacherId' => '教师id',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
            'schoolExamId' => '学校考试id',
        ];
    }

    public function getClassExam()
    {
        return $this->hasOne(SeExamClass::className(), ['classExamId' => 'classExamId']);
    }

    /**
     * @inheritdoc
     * @return SeExamClassSubjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeExamClassSubjectQuery(get_called_class());
    }

    /**
     * 获取考试科目教师ID
     * @param $subjectId
     * @param $classId
     * @param $schoolExamId
     * @return int
     */
    public static function getTeacherId($subjectId, $classId, $schoolExamId)
    {
        //科目ID转换为考试科目主键ID
        $examSubId = SeExamSubject::find()->where(['schoolExamId' => $schoolExamId, 'subjectId' => $subjectId])->limit(1)->one()->examSubId;
        //班级ID转换为班级考试ID
        $classExamId = SeExamClass::find()->where(['schoolExamId' => $schoolExamId, 'classId' => $classId])->limit(1)->one()->classExamId;
        $seExamClassSubjectModel = SeExamClassSubject::find()->where(['examSubId' => $examSubId, 'classExamId' => $classExamId, 'schoolExamId' => $schoolExamId])->limit(1)->one();
        $teacherId = 0;
        if (!empty($seExamClassSubjectModel)) {
            $teacherId = $seExamClassSubjectModel->teacherId;
        }
        return $teacherId;
    }


    /**
     * 录入成绩更新教师关联
     * @param array $examSubIdArray 考试科目主键数组
     * @param integer $classExamId 班级考试ID
     * @param integer $schoolExamId 学校考试ID
     * @param array $userIDArray 考试科目教师主键数组
     * @return bool
     */
    public static function addTeacherLink(array $examSubIdArray, int $classExamId, int $schoolExamId, array $userIDArray)
    {
        foreach ($examSubIdArray as $key => $examSubId) {
            $SeExamClassSubjectModel = SeExamClassSubject::find()->where(['examSubId' => $examSubId, 'classExamId' => $classExamId, 'schoolExamId' => $schoolExamId])->limit(1)->one();
            if (!empty($SeExamClassSubjectModel)) {
                if (empty($userIDArray[$key])) {
                    $SeExamClassSubjectModel->teacherId = 0;
                }
                $SeExamClassSubjectModel->teacherId = $userIDArray[$key];
                $SeExamClassSubjectModel->save(false);
            }
            if (!$SeExamClassSubjectModel->save(false)) {
                return false;
            }
        }
        return true;
    }

}
