<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeClassEventPic]].
 *
 * @see SeClassEventPic
 */
class SeClassEventPicQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeClassEventPic[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeClassEventPic|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}