<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeExamPersonalScore]].
 *
 * @see SeExamPersonalScore
 */
class SeExamPersonalScoreQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeExamPersonalScore[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeExamPersonalScore|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}