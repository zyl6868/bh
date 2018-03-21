<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeExamReportBaseInfo]].
 *
 * @see SeExamReportBaseInfo
 */
class SeExamReportBaseInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeExamReportBaseInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeExamReportBaseInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}