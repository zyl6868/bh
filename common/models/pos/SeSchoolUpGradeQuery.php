<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSchoolUpGrade]].
 *
 * @see SeSchoolUpGrade
 */
class SeSchoolUpGradeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeSchoolUpGrade[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeSchoolUpGrade|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}