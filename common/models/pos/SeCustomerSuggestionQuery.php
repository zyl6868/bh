<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeCustomerSuggestion]].
 *
 * @see SeCustomerSuggestion
 */
class SeCustomerSuggestionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeCustomerSuggestion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeCustomerSuggestion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}