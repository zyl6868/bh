<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SePaperSection]].
 *
 * @see SePaperSection
 */
class SePaperSectionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SePaperSection[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SePaperSection|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}