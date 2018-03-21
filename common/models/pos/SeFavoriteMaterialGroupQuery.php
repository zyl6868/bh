<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeFavoriteMaterialGroup]].
 *
 * @see SeFavoriteMaterialGroup
 */
class SeFavoriteMaterialGroupQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeFavoriteMaterialGroup[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeFavoriteMaterialGroup|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}