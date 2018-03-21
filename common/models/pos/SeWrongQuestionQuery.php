<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeWrongQuestion]].
 *
 * @see SeWrongQuestion
 */
class SeWrongQuestionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeWrongQuestion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeWrongQuestion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}