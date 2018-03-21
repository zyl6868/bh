<?php

namespace common\models\pos;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * This is the ActiveQuery class for [[SeViweExamReportExamPersonalScoreRank]].
 *
 * @see SeViweExamReportExamPersonalScoreRank
 */
class SeViweExamReportExamPersonalScoreRankSearch extends SeViweExamReportExamPersonalScoreRank
{

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'perScoreId' => '个人成绩主键id',
            'classExamId' => '班级考试id',
            'classId' => '班级id',
            'userId' => '用户id',
            'sub10010' => '语文',
            'sub10011' => '数学',
            'sub10012' => '英语',
            'sub10013' => '生物',
            'sub10014' => '物理',
            'sub10015' => '化学',
            'sub10016' => '地理',
            'sub10017' => '历史',
            'sub10018' => '政治',
            'sub10019' => '品德与生活',
            'sub10020' => '美术',
            'sub10021' => '音乐',
            'sub10022' => '体育',
            'sub10023' => '信息技术',
            'sub10024' => '法制',
            'sub10025' => '综合实践',
            'sub10026' => '科学',
            'sub10027' => '理综',
            'sub10028' => '文综',
            'sub10029' => '思想品德',
            'sub10030' => '品德与社会',
            'sub10031' => '心理',
            'sub10032' => '健康',
            'sub10033' => '校本课程',
            'sub10034' => '地方课程',
            'sub10035' => '劳动与技术',
            'sub10036' => '后勤',
            'sub10037' => '学法指导',
            'sub10038' => '写字',
            'sub10039' => '蒙古语文',
            'sub10040' => '汉语',
            'sub10041' => '俄语',
            'sub10042' => '书法',
            'sub10043' => '安全',
            'sub10044' => '通用技术',
            'sub10045' => '研究性学习',
            'sub10046' => '语法',
            'sub10047' => '常识',
            'sub10048' => '阅读',
            'totalScore' => '总分',
            'schoolExamId' => '考试id（学校）',
            'gradeRank' => '年级排名',
            'classRank' => '班级排名',
        ];
    }
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SeViweExamReportExamPersonalScoreRank::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'userId' => $this->userId,
        ]);


        return $dataProvider;
    }
}