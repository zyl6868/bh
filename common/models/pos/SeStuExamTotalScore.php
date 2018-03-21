<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_stuExamTotalScore".
 *
 * @property integer $ID
 * @property string $examID
 * @property string $studentID
 * @property string $uploadTime
 * @property string $totalScore
 * @property string $personalEvaluate
 * @property string $isDelete
 * @property string $cmemID
 * @property string $teacherID
 * @property string $totalRank
 */
class SeStuExamTotalScore extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_stuExamTotalScore';
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
     * @return SeStuExamTotalScoreQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeStuExamTotalScoreQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'required'],
            [['ID'], 'integer'],
            [['personalEvaluate'], 'string'],
            [['examID', 'studentID', 'cmemID'], 'string', 'max' => 30],
            [['uploadTime', 'totalScore', 'totalRank'], 'string', 'max' => 20],
            [['isDelete'], 'string', 'max' => 2],
            [['teacherID'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '主键',
            'examID' => '考试id',
            'studentID' => '学生id',
            'uploadTime' => '更新时间',
            'totalScore' => '总分',
            'personalEvaluate' => '个人考试评价',
            'isDelete' => '是否已删除，0未删除，1已删除',
            'cmemID' => '班级成员id',
            'teacherID' => '评价教师ID',
            'totalRank' => '总分排名',
        ];
    }
}
