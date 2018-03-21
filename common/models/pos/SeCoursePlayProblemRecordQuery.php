<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeCoursePlayProblemRecord]].
 *
 * @see SeCoursePlayProblemRecord
 */
class SeCoursePlayProblemRecordQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeCoursePlayProblemRecord[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeCoursePlayProblemRecord|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}