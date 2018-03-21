<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeCoursePlayTalk]].
 *
 * @see SeCoursePlayTalk
 */
class SeCoursePlayTalkQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeCoursePlayTalk[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeCoursePlayTalk|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}