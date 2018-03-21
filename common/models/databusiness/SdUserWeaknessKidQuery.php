<?php

namespace common\models\databusiness;

/**
 * This is the ActiveQuery class for [[SdUserWeaknessKid]].
 *
 * @see SdUserWeaknessKid
 */
class SdUserWeaknessKidQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SdUserWeaknessKid[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SdUserWeaknessKid|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
