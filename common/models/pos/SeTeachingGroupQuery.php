<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeTeachingGroup]].
 *
 * @see SeTeachingGroup
 */
class SeTeachingGroupQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeTeachingGroup[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeTeachingGroup|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}