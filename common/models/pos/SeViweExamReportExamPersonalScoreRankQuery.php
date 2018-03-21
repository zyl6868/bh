<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeViweExamReportExamPersonalScoreRank]].
 *
 * @see SeViweExamReportExamPersonalScoreRank
 */
class SeViweExamReportExamPersonalScoreRankQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    public function totalBetween($min, $max)
    {
        $this->andWhere(['between', 'totalScore', $min, $max])->andWhere(['<>',"totalScore",$max]);
        return $this;
    }

    /**
     * @param integer $subjectId 科目ID
     * @param float $min 不同层次最低分
     * @param float $max 不同层次最高分
     * @return $this
     */
    public function subjectIdBetween(int $subjectId, float $min, float $max)
    {
        $this->andWhere(['between', "sub$subjectId", $min, $max])->andWhere(['<>',"sub$subjectId",$max]);
        return $this;
    }


    /**
     * @inheritdoc
     * @return SeViweExamReportExamPersonalScoreRank[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeViweExamReportExamPersonalScoreRank|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}