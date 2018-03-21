<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeDibbleCourseClassFile]].
 *
 * @see SeDibbleCourseClassFile
 */
class SeDibbleCourseClassFileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeDibbleCourseClassFile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeDibbleCourseClassFile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}