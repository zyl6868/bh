<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSchlHomMsg]].
 *
 * @see SeSchlHomMsg
 */
class SeSchlHomMsgQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeSchlHomMsg[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeSchlHomMsg|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}