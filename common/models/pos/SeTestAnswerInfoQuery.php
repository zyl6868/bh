<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeTestAnswerInfo]].
 *
 * @see SeTestAnswerInfo
 */
class SeTestAnswerInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeTestAnswerInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeTestAnswerInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}