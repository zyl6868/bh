<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeTestAnswerDetailImage]].
 *
 * @see SeTestAnswerDetailImage
 */
class SeTestAnswerDetailImageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeTestAnswerDetailImage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeTestAnswerDetailImage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}