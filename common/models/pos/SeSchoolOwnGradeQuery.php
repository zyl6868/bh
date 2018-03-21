<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSchoolOwnGrade]].
 *
 * @see SeSchoolOwnGrade
 */
class SeSchoolOwnGradeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeSchoolOwnGrade[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeSchoolOwnGrade|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}