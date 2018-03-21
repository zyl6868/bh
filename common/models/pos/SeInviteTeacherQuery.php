<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[ShInviteTeacher]].
 *
 * @see SeInviteTeacher
 */
class SeInviteTeacherQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeInviteTeacher[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeInviteTeacher|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}