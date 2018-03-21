<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHomeworkPlatformVideos]].
 *
 * @see SeHomeworkPlatformVideos
 */
class SeHomeworkPlatformVideosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeHomeworkPlatformVideos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHomeworkPlatformVideos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}