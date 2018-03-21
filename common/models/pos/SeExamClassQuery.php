<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeExamClass]].
 *
 * @see SeExamClass
 */
class SeExamClassQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeExamClass[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeExamClass|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}