<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHomeworkPlatform]].
 *
 * @see SeHomeworkPlatform
 */
class SeHomeworkPlatformQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1 and [[isDelete]]=0');
        return $this;
    }

    /**
     * 级别
     * @param int $l
     * @return $this
     */
    public function level($l=0)
    {
        $this->andWhere('[[level]]=:level',[':level'=>$l]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return SeHomeworkPlatform[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHomeworkPlatform|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}