<?php

namespace common\models\sanhai;

/**
 * This is the ActiveQuery class for [[ShQuestionVideo]].
 *
 * @see ShQuestionVideo
 */
class ShQuestionVideoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ShQuestionVideo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ShQuestionVideo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}