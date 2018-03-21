<?php

namespace common\models\sanhai;

/**
 * This is the ActiveQuery class for [[SrKnowledgepoint]].
 *
 * @see SrKnowledgepoint
 */
class SrKnowledgepointQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SrKnowledgepoint[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SrKnowledgepoint|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}