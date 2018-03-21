<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeGroupCourse]].
 *
 * @see SeGroupCourse
 */
class SeGroupCourseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeGroupCourse[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeGroupCourse|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}