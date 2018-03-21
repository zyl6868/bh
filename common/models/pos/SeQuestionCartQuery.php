<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeQuestionCart]].
 *
 * @see SeQuestionCart
 */
class SeQuestionCartQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeQuestionCart[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeQuestionCart|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}