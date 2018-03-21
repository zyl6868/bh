<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSchlHomRankChange]].
 *
 * @see SeSchlHomRankChange
 */
class SeSchlHomRankChangeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeSchlHomRankChange[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeSchlHomRankChange|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}