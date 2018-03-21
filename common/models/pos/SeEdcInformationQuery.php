<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeEdcInformation]].
 *
 * @see SeEdcInformation
 */
class SeEdcInformationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeEdcInformation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeEdcInformation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}