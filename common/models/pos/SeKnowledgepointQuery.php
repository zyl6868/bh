<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeKnowledgepoint]].
 *
 * @see SeKnowledgepoint
 */
class SeKnowledgepointQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeKnowledgepoint[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeKnowledgepoint|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}