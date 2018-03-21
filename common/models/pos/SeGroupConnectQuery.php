<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeGroupConnect]].
 *
 * @see SeGroupConnect
 */
class SeGroupConnectQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeGroupConnect[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeGroupConnect|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}