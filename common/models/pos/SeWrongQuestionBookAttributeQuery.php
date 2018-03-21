<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeWrongQuestionBookAttribute]].
 *
 * @see SeWrongQuestionBookAttribute
 */
class SeWrongQuestionBookAttributeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeWrongQuestionBookAttribute[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeWrongQuestionBookAttribute|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}