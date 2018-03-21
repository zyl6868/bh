<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_homeworktestquestion".
 *
 * @property integer $homeworkQuesId
 * @property integer $id
 * @property string $guid
 * @property string $provience
 * @property string $city
 * @property string $country
 * @property string $gradeid
 * @property string $subjectid
 * @property string $versionid
 * @property string $kid
 * @property string $tqtid
 * @property string $provenance
 * @property string $year
 * @property string $school
 * @property string $complexity
 * @property string $capacity
 * @property string $Tags
 * @property string $operater
 * @property string $createTime
 * @property string $updateTime
 * @property string $tqName
 * @property string $content
 * @property string $answerOption
 * @property string $answerContent
 * @property string $analytical
 * @property integer $childnum
 * @property string $mainQusId
 * @property string $textContent
 * @property string $questionPrice
 * @property string $status
 * @property string $isDelete
 * @property string $inputStatus
 * @property string $quesLevel
 * @property string $quesFrom
 * @property string $isPic
 * @property string $catid
 * @property string $chapterId
 */
class SeHomeworktestquestion extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homeworktestquestion';
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
            [['homeworkQuesId', 'id'], 'required'],
            [['homeworkQuesId', 'id', 'childnum'], 'integer'],
            [['content', 'answerOption', 'answerContent', 'analytical', 'textContent'], 'string'],
            [['guid'], 'string', 'max' => 60],
            [['provience', 'city', 'country', 'gradeid', 'subjectid', 'tqtid', 'provenance', 'year', 'complexity', 'operater', 'createTime', 'updateTime', 'mainQusId', 'questionPrice', 'status', 'isDelete', 'inputStatus', 'quesLevel', 'isPic'], 'string', 'max' => 20],
            [['versionid', 'kid'], 'string', 'max' => 300],
            [['school'], 'string', 'max' => 30],
            [['capacity', 'Tags', 'tqName'], 'string', 'max' => 200],
            [['quesFrom'], 'string', 'max' => 800],
            [['catid', 'chapterId'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'homeworkQuesId' => '试卷题目id',
            'id' => '题目id',
            'guid' => '全局唯一标识 数据位置存储表标识（4个字符）+GUID',
            'provience' => '省',
            'city' => '市',
            'country' => '区县',
            'gradeid' => '年级编码',
            'subjectid' => '科目编码',
            'versionid' => '版本编码',
            'kid' => '知识点之间使用逗号分隔',
            'tqtid' => '题型',
            'provenance' => '出处 改成考试分类',
            'year' => '年份',
            'school' => '名校',
            'complexity' => '难易程度,复杂度',
            'capacity' => '能力提升 掌握程度',
            'Tags' => '自定义标签',
            'operater' => '题目录入人员',
            'createTime' => '录入时间',
            'updateTime' => '最后一次修改时间',
            'tqName' => '题目名称',
            'content' => '题目内容',
            'answerOption' => '备选项[{\"id\":\"1\",\"content\":\"备选项1\",\"right\":\"1\"}] 0错误 1正确',
            'answerContent' => '题目答案 单选题选项id 多选题选项id逗号隔开',
            'analytical' => '题目分析',
            'childnum' => '小题数',
            'mainQusId' => '大题ID',
            'textContent' => '题目内容文本',
            'questionPrice' => '题目价格 0免费',
            'status' => '审核状态/禁用状态(0待审核,1通过,2已禁用)',
            'isDelete' => '删除状态',
            'inputStatus' => '录入状态 0临时 1正式',
            'quesLevel' => '题目等级',
            'quesFrom' => '题目来源',
            'isPic' => 'Is Pic',
            'catid' => 'Catid',
            'chapterId' => '章节id',
        ];
    }

    /**
     * @inheritdoc
     * @return SeHomeworktestquestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworktestquestionQuery(get_called_class());
    }
}
