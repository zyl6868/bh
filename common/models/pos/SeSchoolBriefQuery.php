<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSchoolBrief]].
 *
 * @see SeSchoolBrief
 */
class SeSchoolBriefQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeSchoolBrief[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeSchoolBrief|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}