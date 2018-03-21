<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeCoursePlayRaiseHandRecord]].
 *
 * @see SeCoursePlayRaiseHandRecord
 */
class SeCoursePlayRaiseHandRecordQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeCoursePlayRaiseHandRecord[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeCoursePlayRaiseHandRecord|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}