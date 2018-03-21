<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeQuestionTeamNotes]].
 *
 * @see SeQuestionTeamNotes
 */
class SeQuestionTeamNotesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeQuestionTeamNotes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeQuestionTeamNotes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}