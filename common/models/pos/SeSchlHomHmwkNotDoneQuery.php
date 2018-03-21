<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSchlHomHmwkNotDone]].
 *
 * @see SeSchlHomHmwkNotDone
 */
class SeSchlHomHmwkNotDoneQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeSchlHomHmwkNotDone[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeSchlHomHmwkNotDone|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}