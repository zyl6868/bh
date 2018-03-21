<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSentMessage]].
 *
 * @see SeSentMessage
 */
class SeSentMessageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeSentMessage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeSentMessage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}