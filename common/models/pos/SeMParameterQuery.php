<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeMParameter]].
 *
 * @see SeMParameter
 */
class SeMParameterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeMParameter[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeMParameter|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}