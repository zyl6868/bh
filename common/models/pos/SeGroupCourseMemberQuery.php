<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeGroupCourseMember]].
 *
 * @see SeGroupCourseMember
 */
class SeGroupCourseMemberQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeGroupCourseMember[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeGroupCourseMember|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}