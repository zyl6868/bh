<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeUserControl]].
 *
 * @see SeUserControl
 */
class SeUserControlQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeUserControl[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeUserControl|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}