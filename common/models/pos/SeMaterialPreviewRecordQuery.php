<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[\common\models\pos\SeMaterialPreviewRecord]].
 *
 * @see \common\models\pos\SeMaterialPreviewRecord
 */
class SeMaterialPreviewRecordQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\pos\SeMaterialPreviewRecord[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\pos\SeMaterialPreviewRecord|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}