<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeCourseInTime]].
 *
 * @see SeCourseInTime
 */
class SeCourseInTimeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeCourseInTime[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeCourseInTime|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}