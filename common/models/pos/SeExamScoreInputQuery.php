<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeExamScoreInput]].
 *
 * @see SeExamScoreInput
 */
class SeExamScoreInputQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeExamScoreInput[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeExamScoreInput|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}