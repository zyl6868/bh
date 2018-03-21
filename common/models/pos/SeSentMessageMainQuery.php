<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSentMessageMain]].
 *
 * @see SeSentMessageMain
 */
class SeSentMessageMainQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeSentMessageMain[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeSentMessageMain|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}