<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeMaterialShowRecord]].
 *
 * @see SeMaterialShowRecord
 */
class SeMaterialShowRecordQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeMaterialShowRecord[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeMaterialShowRecord|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}