<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeQuestionTeamAnswer]].
 *
 * @see SeQuestionTeamAnswer
 */
class SeQuestionTeamAnswerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeQuestionTeamAnswer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeQuestionTeamAnswer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}