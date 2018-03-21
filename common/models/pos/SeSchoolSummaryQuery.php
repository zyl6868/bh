<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSchoolSummary]].
 *
 * @see SeSchoolSummary
 */
class SeSchoolSummaryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeSchoolSummary[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeSchoolSummary|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}