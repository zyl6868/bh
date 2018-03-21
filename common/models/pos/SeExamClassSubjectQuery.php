<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeExamClassSubject]].
 *
 * @see SeExamClassSubject
 */
class SeExamClassSubjectQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeExamClassSubject[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeExamClassSubject|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}