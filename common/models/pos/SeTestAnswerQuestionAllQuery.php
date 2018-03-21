<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeTestAnswerQuestionAll]].
 *
 * @see SeTestAnswerQuestionAll
 */
class SeTestAnswerQuestionAllQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeTestAnswerQuestionAll[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeTestAnswerQuestionAll|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}