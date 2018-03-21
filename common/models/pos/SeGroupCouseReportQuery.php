<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeGroupCouseReport]].
 *
 * @see SeGroupCouseReport
 */
class SeGroupCouseReportQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeGroupCouseReport[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeGroupCouseReport|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}