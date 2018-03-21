<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeExamSubject]].
 *
 * @see SeExamSubject
 */
class SeExamSubjectQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeExamSubject[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeExamSubject|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}