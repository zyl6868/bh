<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeShareMaterial]].
 *
 * @see SeShareMaterial
 */
class SeShareMaterialQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[isDelete]]=0');
        return $this;
    }

    /**
     * @inheritdoc
     * @return SeShareMaterial[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeShareMaterial|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}