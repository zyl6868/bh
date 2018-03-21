<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeTeacherMaterialInfo]].
 *
 * @see SeTeacherMaterialInfo
 */
class SeTeacherMaterialInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeTeacherMaterialInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeTeacherMaterialInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}