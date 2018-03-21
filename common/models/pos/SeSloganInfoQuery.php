<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSloganInfo]].
 *
 * @see SeSloganInfo
 */
class SeSloganInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeSloganInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeSloganInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}