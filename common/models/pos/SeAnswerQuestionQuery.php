<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeAnswerQuestion]].
 *
 * @see SeAnswerQuestion
 */
class SeAnswerQuestionQuery extends \yii\db\ActiveQuery
{
   public function active()
    {
        $this->andWhere('[[isDelete]]=0');
        return $this;
    }

    /**
     * @inheritdoc
     * @return SeAnswerQuestion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeAnswerQuestion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}