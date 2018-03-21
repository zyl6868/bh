<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeWrongQuestionBookSubject]].
 *
 * @see SeWrongQuestionBookSubject
 */
class SeWrongQuestionBookSubjectQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeWrongQuestionBookSubject[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeWrongQuestionBookSubject|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}