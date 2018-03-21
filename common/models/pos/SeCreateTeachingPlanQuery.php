<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeCreateTeachingPlan]].
 *
 * @see SeCreateTeachingPlan
 */
class SeCreateTeachingPlanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeCreateTeachingPlan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeCreateTeachingPlan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}