<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeClassEvent]].
 *
 * @see SeClassEvent
 */
class SeClassEventQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[isDelete]]=0');
        return $this;
    }

    /**
     * @inheritdoc
     * @return SeClassEvent[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeClassEvent|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}