<?php

namespace common\models\databusiness;

/**
 * This is the ActiveQuery class for [[SdUserWeakness]].
 *
 * @see SdUserWeakness
 */
class SdUserWeaknessQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SdUserWeakness[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SdUserWeakness|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
