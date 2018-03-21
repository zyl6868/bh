<?php

namespace common\models\sanhai;

/**
 * This is the ActiveQuery class for [[ShVideolesson]].
 *
 * @see ShVideolesson
 */
class ShVideolessonQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ShVideolesson[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ShVideolesson|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}