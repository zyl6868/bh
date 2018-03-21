<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeClasAnnouncement]].
 *
 * @see SeClasAnnouncement
 */
class SeClasAnnouncementQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeClasAnnouncement[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeClasAnnouncement|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}