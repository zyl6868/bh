<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeExamReportStudentStructure]].
 *
 * @see SeExamReportStudentStructure
 */
class SeExamReportStudentStructureQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeExamReportStudentStructure[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeExamReportStudentStructure|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}