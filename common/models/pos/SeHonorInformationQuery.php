<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHonorInformation]].
 *
 * @see SeHonorInformation
 */
class SeHonorInformationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeHonorInformation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHonorInformation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}