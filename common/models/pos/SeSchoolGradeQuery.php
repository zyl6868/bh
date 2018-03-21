<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSchoolGrade]].
 *
 * @see SeSchoolGrade
 */
class SeSchoolGradeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeSchoolGrade[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeSchoolGrade|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}