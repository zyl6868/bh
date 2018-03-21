<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeExamReportOverline]].
 *
 * @see SeExamReportOverline
 */
class SeExamReportOverlineQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeExamReportOverline[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeExamReportOverline|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}