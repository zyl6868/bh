<?php

namespace common\models\heEducation;

/**
 * This is the ActiveQuery class for [[ShHeClassMember]].
 *
 * @see ShHeClassMember
 */
class ShHeClassMemberQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ShHeClassMember[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ShHeClassMember|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}