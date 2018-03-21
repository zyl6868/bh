<?php

namespace common\models\sanhai;

/**
 * This is the ActiveQuery class for [[ShQuestionError]].
 *
 * @see SeSchoolGrade
 */
class ShQuestionErrorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ShQuestionError[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ShQuestionError|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}