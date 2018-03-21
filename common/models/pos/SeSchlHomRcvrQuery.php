<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSchlHomRcvr]].
 *
 * @see SeSchlHomRcvr
 */
class SeSchlHomRcvrQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeSchlHomRcvr[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeSchlHomRcvr|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}