<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHomeworkAnswerQuestionPic]].
 *
 * @see SeHomeworkAnswerQuestionPic
 */
class SeHomeworkAnswerQuestionPicQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeHomeworkAnswerQuestionPic[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHomeworkAnswerQuestionPic|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}