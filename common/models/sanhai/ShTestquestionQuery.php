<?php

namespace common\models\sanhai;

/**
 * This is the ActiveQuery class for [[ShTestquestion]].
 *
 * @see ShTestquestion
 */
class ShTestquestionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ShTestquestion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ShTestquestion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}