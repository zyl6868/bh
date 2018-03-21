<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeQuestionGroup]].
 *
 * @see SeQuestionGroup
 */
class SeQuestionGroupQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeQuestionGroup[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeQuestionGroup|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}