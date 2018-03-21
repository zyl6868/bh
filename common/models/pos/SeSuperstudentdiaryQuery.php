<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSuperstudentdiary]].
 *
 * @see SeSuperstudentdiary
 */
class SeSuperstudentdiaryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeSuperstudentdiary[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeSuperstudentdiary|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}