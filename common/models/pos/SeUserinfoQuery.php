<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeUserinfo]].
 *
 * @see SeUserinfo
 */
class SeUserinfoQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[disabled]]=0');
        return $this;
    }

    /**
     * @inheritdoc
     * @return SeUserinfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeUserinfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}