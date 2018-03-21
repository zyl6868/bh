<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeUserMaterialPrivilege]].
 *
 * @see SeUserMaterialPrivilege
 */
class SeUserMaterialPrivilegeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeUserMaterialPrivilege[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeUserMaterialPrivilege|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}