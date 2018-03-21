<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeCoursePlayInfo]].
 *
 * @see SeCoursePlayInfo
 */
class SeCoursePlayInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeCoursePlayInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeCoursePlayInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}