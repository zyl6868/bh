<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SePapertestquestion]].
 *
 * @see SePapertestquestion
 */
class SePapertestquestionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SePapertestquestion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SePapertestquestion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}