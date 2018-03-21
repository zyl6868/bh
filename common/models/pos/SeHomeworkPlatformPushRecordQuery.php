<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHomeworkPlatformPushRecord]].
 *
 * @see SeHomeworkPlatformPushRecord
 */
class SeHomeworkPlatformPushRecordQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeHomeworkPlatformPushRecord[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHomeworkPlatformPushRecord|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}