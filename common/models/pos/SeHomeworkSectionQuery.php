<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHomeworkSection]].
 *
 * @see SeHomeworkSection
 */
class SeHomeworkSectionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeHomeworkSection[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHomeworkSection|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}