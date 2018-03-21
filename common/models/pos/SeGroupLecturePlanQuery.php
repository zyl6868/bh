<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeGroupLecturePlan]].
 *
 * @see SeGroupLecturePlan
 */
class SeGroupLecturePlanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeGroupLecturePlan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeGroupLecturePlan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}