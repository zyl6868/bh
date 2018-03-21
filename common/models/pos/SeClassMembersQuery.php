<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeClassMembers]].
 *
 * @see SeClassMembers
 */
class SeClassMembersQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this;
    }

    /**
     * @inheritdoc
     * @return SeClassMembers[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    public function  ByUserId($useId)
    {
        $this->andWhere('[[userID]]=:userId', [':userId' => $useId]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return SeClassMembers|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}