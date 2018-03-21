<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeExamWaitForGenerateReport]].
 *
 * @see SeExamWaitForGenerateReport
 */
class SeExamWaitForGenerateReportQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeExamWaitForGenerateReport[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeExamWaitForGenerateReport|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}