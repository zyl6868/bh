<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeAnswerinfo]].
 *
 * @see SeAnswerinfo
 */
class SeAnswerinfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeAnswerinfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeAnswerinfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}