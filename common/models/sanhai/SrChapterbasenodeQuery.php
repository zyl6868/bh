<?php

namespace common\models\sanhai;

/**
 * This is the ActiveQuery class for [[\common\models\pos\SrChapterbasenode]].
 *
 * @see \common\models\pos\SrChapterbasenode
 */
class SrChapterbasenodeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\pos\SrChapterbasenode[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\pos\SrChapterbasenode|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}