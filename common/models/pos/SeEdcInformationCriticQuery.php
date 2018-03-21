<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeEdcInformationCritic]].
 *
 * @see SeEdcInformationCritic
 */
class SeEdcInformationCriticQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeEdcInformationCritic[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeEdcInformationCritic|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}