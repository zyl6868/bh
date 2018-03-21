<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeQuestionCartQeustions]].
 *
 * @see SeQuestionCartQeustions
 */
class SeQuestionCartQeustionsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeQuestionCartQeustions[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeQuestionCartQeustions|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}