<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[ComArea]].
 *
 * @see ComArea
 */
class ComAreaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ComArea[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ComArea|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}