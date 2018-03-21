<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeDibbleCourseClassHour]].
 *
 * @see SeDibbleCourseClassHour
 */
class SeDibbleCourseClassHourQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeDibbleCourseClassHour[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeDibbleCourseClassHour|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}