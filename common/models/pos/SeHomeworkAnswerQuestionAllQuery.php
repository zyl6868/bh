<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHomeworkAnswerQuestionAll]].
 *
 * @see SeHomeworkAnswerQuestionAll
 */
class SeHomeworkAnswerQuestionAllQuery extends \yii\db\ActiveQuery
{
//    /*public function active()
//    {
//        $this->andWhere('[[status]]=1');
//        return $this;
//    }*/

    /**
     * @inheritdoc
     * @return SeHomeworkAnswerQuestionAll[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHomeworkAnswerQuestionAll|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}