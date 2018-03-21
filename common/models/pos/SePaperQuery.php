<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SePaper]].
 *
 * @see SePaper
 */
class SePaperQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SePaper[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SePaper|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}