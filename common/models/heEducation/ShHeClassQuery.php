<?php

namespace common\models\heEducation;

/**
 * This is the ActiveQuery class for [[ShHeClass]].
 *
 * @see ShHeClass
 */
class ShHeClassQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ShHeClass[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ShHeClass|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}