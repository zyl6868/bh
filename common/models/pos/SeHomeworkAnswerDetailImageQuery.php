<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHomeworkAnswerDetailImage]].
 *
 * @see SeHomeworkAnswerDetailImage
 */
class SeHomeworkAnswerDetailImageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeHomeworkAnswerDetailImage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHomeworkAnswerDetailImage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}