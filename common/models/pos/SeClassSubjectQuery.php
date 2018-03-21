<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeClassSubject]].
 *
 * @see SeClassSubject
 */
class SeClassSubjectQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeClassSubject[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeClassSubject|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}