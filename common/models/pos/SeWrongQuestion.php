<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_wrongQuestion".
 *
 * @property integer $id
 * @property string $questionId
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
 * @property string $wrongQuesfrom
 * @property string $wrongUserId
 * @property string $quesScore
 * @property string $inputStatus
 * @property string $quesLevel
 * @property string $quesFrom
 * @property string $isPic
 * @property string $catid
 * @property string $chapterId
 * @property string $wrongFrom
 * @property string $wrongFromTxt
 */
class SeWrongQuestion extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_wrongQuestion';
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
     * @return SeWrongQuestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeWrongQuestionQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'childnum'], 'integer'],
            [['content', 'answerOption', 'answerContent', 'analytical', 'textContent'], 'string'],
            [['questionId'], 'string', 'max' => 50],
            [['guid'], 'string', 'max' => 60],
            [['provience', 'city', 'country', 'gradeid', 'subjectid', 'tqtid', 'provenance', 'year', 'complexity', 'operater', 'createTime', 'updateTime', 'mainQusId', 'questionPrice', 'status', 'isDelete', 'wrongQuesfrom', 'quesScore', 'inputStatus', 'quesLevel', 'isPic', 'wrongFrom'], 'string', 'max' => 20],
            [['versionid', 'kid'], 'string', 'max' => 300],
            [['school'], 'string', 'max' => 30],
            [['capacity', 'Tags', 'tqName', 'wrongUserId'], 'string', 'max' => 200],
            [['quesFrom'], 'string', 'max' => 800],
            [['catid', 'chapterId'], 'string', 'max' => 1000],
            [['wrongFromTxt'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'questionId' => '题目id',
            'guid' => '全局唯一标识 数据位置存储表标识（4个字符）+GUID',
            'provience' => '省',
            'city' => '市',
            'country' => '区县',
            'gradeid' => '年级编码',
            'subjectid' => '科目编码',
            'versionid' => '版本编码',
            'kid' => '知识点之间使用逗号分隔',
            'tqtid' => '题型',
            'provenance' => '出处',
            'year' => '年份',
            'school' => '名校',
            'complexity' => '难易程度,复杂度',
            'capacity' => '能力提升',
            'Tags' => '自定义标签',
            'operater' => '题目录入人员',
            'createTime' => '录入时间',
            'updateTime' => '最后一次修改时间',
            'tqName' => '题目名称',
            'content' => '题目内容',
            'answerOption' => '备选项[{\"id\":\"1\",\"content\":\"备选项1\",\"right\":\"1\"}]',
            'answerContent' => '题目答案',
            'analytical' => '题目分析',
            'childnum' => '小题数',
            'mainQusId' => '大题ID',
            'textContent' => '题目内容文本',
            'questionPrice' => '题目价格 0免费',
            'status' => '审核状态/禁用状态(0待审核,1通过,2已禁用)',
            'isDelete' => '删除状态',
            'wrongQuesfrom' => '错题来源 1录入 2测验和作业 3推送题目组',
            'wrongUserId' => '错题人',
            'quesScore' => '分数',
            'inputStatus' => '录入状态 0临时 1正式',
            'quesLevel' => '题目等级',
            'quesFrom' => '题目来源',
            'isPic' => '图片题目',
            'catid' => 'Catid',
            'chapterId' => '章节id',
            'wrongFrom' => '错题来源关联id',
            'wrongFromTxt' => '错题来源关联名称',
        ];
    }
}
