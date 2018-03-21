<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeTestAnswerDetailQuestion]].
 *
 * @see SeTestAnswerDetailQuestion
 */
class SeTestAnswerDetailQuestionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeTestAnswerDetailQuestion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeTestAnswerDetailQuestion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}