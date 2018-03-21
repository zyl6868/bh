<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeTestAnswerQuestionPic]].
 *
 * @see SeTestAnswerQuestionPic
 */
class SeTestAnswerQuestionPicQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeTestAnswerQuestionPic[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeTestAnswerQuestionPic|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}