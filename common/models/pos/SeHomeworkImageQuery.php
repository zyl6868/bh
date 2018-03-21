<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHomeworkImage]].
 *
 * @see SeHomeworkImage
 */
class SeHomeworkImageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeHomeworkImage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHomeworkImage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}