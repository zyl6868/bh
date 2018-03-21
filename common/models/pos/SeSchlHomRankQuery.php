<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSchlHomRank]].
 *
 * @see SeSchlHomRank
 */
class SeSchlHomRankQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeSchlHomRank[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeSchlHomRank|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}