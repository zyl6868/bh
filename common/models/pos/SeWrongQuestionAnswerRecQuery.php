<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeWrongQuestionAnswerRec]].
 *
 * @see SeWrongQuestionAnswerRec
 */
class SeWrongQuestionAnswerRecQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeWrongQuestionAnswerRec[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeWrongQuestionAnswerRec|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}