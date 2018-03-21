<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeWrongQuestionBookInfo]].
 *
 * @see SeWrongQuestionBookInfo
 */
class SeWrongQuestionBookInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeWrongQuestionBookInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeWrongQuestionBookInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}