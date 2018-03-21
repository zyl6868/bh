<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeDibbleCourseInfo]].
 *
 * @see SeDibbleCourseInfo
 */
class SeDibbleCourseInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeDibbleCourseInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeDibbleCourseInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}