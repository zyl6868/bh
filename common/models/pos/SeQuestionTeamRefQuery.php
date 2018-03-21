<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeQuestionTeamRef]].
 *
 * @see SeQuestionTeamRef
 */
class SeQuestionTeamRefQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeQuestionTeamRef[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeQuestionTeamRef|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}