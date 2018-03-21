<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeGroupMembers]].
 *
 * @see SeGroupMembers
 */
class SeGroupMembersQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[isDelete]]=0');
        return $this;
    }

    /**
     * @inheritdoc
     * @return SeGroupMembers[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeGroupMembers|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}