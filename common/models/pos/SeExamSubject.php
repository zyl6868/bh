<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_exam_subject".
 *
 * @property integer $examSubId 考试科目主键id
 * @property integer $schoolExamId 学校考试id
 * @property integer $subjectId 科目id
 * @property integer $fullScore 满分
 * @property integer $borderlineOne 分数线1
 * @property integer $borderlineTwo 分数线2
 * @property integer $borderlineThree 分数线3
 * @property integer $createTime 创建时间
 * @property integer $updateTime 更新时间
 */
class SeExamSubject extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_exam_subject';
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
            [['schoolExamId', 'subjectId',  'borderlineTwo', 'borderlineThree', 'createTime', 'updateTime'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'examSubId' => '考试科目主键id',
            'schoolExamId' => '学校考试id',
            'subjectId' => '科目id',
            'fullScore' => '满分',
            'borderlineOne' => '分数线1',
            'borderlineTwo' => '分数线2',
            'borderlineThree' => '分数线3',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SeExamSubjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeExamSubjectQuery(get_called_class());
    }

    /**
     * 根据学校考试id获取考试科目全部列表
     * @param integer $schoolExamId 学校考试id
     * @return array|SeExamSubject[]
     */
    public static function getExamSubjectAll(int $schoolExamId)
    {
        return self::find()->where(['schoolExamId'=>$schoolExamId])->all();
    }

    /**
     * 根据学校考试id和科目id获取考试科目详情
     * @param int $schoolExamId 学校考试id
     * @param string $subjectId 科目id
     * @return array|SeExamSubject|null
     */
    public static function accordingToSchoolExamIdSubjectIdGetExamSubDetails(int $schoolExamId,string $subjectId)
    {
        return self::find()->where(['schoolExamId'=>$schoolExamId,'subjectId'=>$subjectId])->limit(1)->one();
    }
}
