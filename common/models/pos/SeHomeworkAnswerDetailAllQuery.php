<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHomeworkAnswerDetailAll]].
 *
 * @see SeHomeworkAnswerDetailAll
 */
class SeHomeworkAnswerDetailAllQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeHomeworkAnswerDetailAll[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHomeworkAnswerDetailAll|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}