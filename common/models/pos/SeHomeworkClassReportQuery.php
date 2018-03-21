<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHomeworkClassReport]].
 *
 * @see SeHomeworkClassReport
 */
class SeHomeworkClassReportQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SeHomeworkClassReport[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHomeworkClassReport|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
