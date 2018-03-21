<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeCoursePlayCourseFile]].
 *
 * @see SeCoursePlayCourseFile
 */
class SeCoursePlayCourseFileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeCoursePlayCourseFile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeCoursePlayCourseFile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}