<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeExamReportClassRank]].
 *
 * @see SeExamReportClassRank
 */
class SeExamReportClassRankQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeExamReportClassRank[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeExamReportClassRank|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}