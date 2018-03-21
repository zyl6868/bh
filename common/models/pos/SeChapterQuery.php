<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeChapter]].
 *
 * @see SeChapter
 */
class SeChapterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeChapter[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeChapter|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}