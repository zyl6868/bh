<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeTestAnswerQuestionMain]].
 *
 * @see SeTestAnswerQuestionMain
 */
class SeTestAnswerQuestionMainQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeTestAnswerQuestionMain[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeTestAnswerQuestionMain|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}