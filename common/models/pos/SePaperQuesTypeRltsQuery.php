<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SePaperQuesTypeRlts]].
 *
 * @see SePaperQuesTypeRlts
 */
class SePaperQuesTypeRltsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SePaperQuesTypeRlts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SePaperQuesTypeRlts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}