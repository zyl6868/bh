<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SePaperQuestionType]].
 *
 * @see SePaperQuestionType
 */
class SePaperQuestionTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SePaperQuestionType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SePaperQuestionType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}