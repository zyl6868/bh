<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_examinfo".
 *
 * @property integer $examID
 * @property string $classID
 * @property string $creatTime
 * @property string $creater
 * @property string $isDelete
 * @property string $evaluate
 * @property string $isChecked
 * @property string $classScore
 * @property string $examName
 * @property string $type
 * @property string $schoolYear
 * @property string $semester
 * @property string $disabled
 * @property string $learnSituation
 * @property string $commonPro
 * @property string $improveAdvise
 * @property string $isHavePaper
 * @property string $isHaveScore
 * @property string $isHaveCEva
 * @property string $examTime
 * @property string $isWarnPar
 */
class SeExaminfo extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_examinfo';
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
     * @return SeExaminfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeExaminfoQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['examID'], 'required'],
            [['examID'], 'integer'],
            [['classID'], 'string', 'max' => 30],
            [['creatTime'], 'string', 'max' => 36],
            [['creater', 'isDelete', 'isChecked', 'classScore'], 'string', 'max' => 50],
            [['evaluate', 'learnSituation', 'commonPro', 'improveAdvise'], 'string', 'max' => 500],
            [['examName'], 'string', 'max' => 200],
            [['type', 'schoolYear', 'semester'], 'string', 'max' => 100],
            [['disabled', 'isHavePaper', 'isHaveScore', 'isHaveCEva', 'isWarnPar'], 'string', 'max' => 2],
            [['examTime'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'examID' => '考试ID',
            'classID' => '班级ID',
            'creatTime' => '创建时间',
            'creater' => '创建者',
            'isDelete' => '是否删除0：否1：是默认0',
            'evaluate' => '班主任评价',
            'isChecked' => '是否批阅0：否1：是默认0',
            'classScore' => '班级成绩',
            'examName' => '考试名称',
            'type' => '考试类别',
            'schoolYear' => '考试学年',
            'semester' => '考试学期',
            'disabled' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
            'learnSituation' => '班内学习状态',
            'commonPro' => '共性问题',
            'improveAdvise' => '改进建议',
            'isHavePaper' => '是否有上传试卷，0没有，1有',
            'isHaveScore' => '是否有上传成绩，0没有，1有',
            'isHaveCEva' => '是否有班级总评，0没有，1有',
            'examTime' => '考试时间',
            'isWarnPar' => '是否发消息提醒家长',
        ];
    }

	/**
	 * @return \yii\db\ActiveQuery
	 * 查询考试科目信息
	 */
	public function getExamSubjectInfo()
	{
		return $this->hasMany(SeExamsubjectinfo::className(),['examID' => 'examID']);
	}

}
