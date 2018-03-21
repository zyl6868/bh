<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeFavoriteMaterial]].
 *
 * @see SeFavoriteMaterial
 */
class SeFavoriteMaterialQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeFavoriteMaterial[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeFavoriteMaterial|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}