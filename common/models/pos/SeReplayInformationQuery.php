<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeReplayInformation]].
 *
 * @see SeReplayInformation
 */
class SeReplayInformationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeReplayInformation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeReplayInformation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}