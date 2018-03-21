<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeGroupTeachingPlan]].
 *
 * @see SeGroupTeachingPlan
 */
class SeGroupTeachingPlanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeGroupTeachingPlan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeGroupTeachingPlan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}