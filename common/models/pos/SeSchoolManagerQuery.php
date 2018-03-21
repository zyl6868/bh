<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSchoolManager]].
 *
 * @see SeSchoolManager
 */
class SeSchoolManagerQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=10');
        return $this;
    }

    /**
     * @inheritdoc
     * @return SeSchoolManager[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeSchoolManager|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}