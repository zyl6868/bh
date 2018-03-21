<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeCoursePlayInfoOnlingMem]].
 *
 * @see SeCoursePlayInfoOnlingMem
 */
class SeCoursePlayInfoOnlingMemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeCoursePlayInfoOnlingMem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeCoursePlayInfoOnlingMem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}