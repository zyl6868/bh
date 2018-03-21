<?php

namespace common\models\heEducation;

/**
 * This is the ActiveQuery class for [[ShHeUserInfo]].
 *
 * @see ShHeUserInfo
 */
class ShHeUserInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ShHeUserInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ShHeUserInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}