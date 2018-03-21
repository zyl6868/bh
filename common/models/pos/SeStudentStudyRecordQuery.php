<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeStudentStudyRecord]].
 *
 * @see SeStudentStudyRecord
 */
class SeStudentStudyRecordQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeStudentStudyRecord[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeStudentStudyRecord|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}