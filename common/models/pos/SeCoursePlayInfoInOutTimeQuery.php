<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeCoursePlayInfoInOutTime]].
 *
 * @see SeCoursePlayInfoInOutTime
 */
class SeCoursePlayInfoInOutTimeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeCoursePlayInfoInOutTime[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeCoursePlayInfoInOutTime|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}