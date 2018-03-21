<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[\common\models\pos\SeMaterialDownloadRecord]].
 *
 * @see \common\models\pos\SeMaterialDownloadRecord
 */
class SeMaterialDownloadRecordQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\models\pos\SeMaterialDownloadRecord[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\pos\SeMaterialDownloadRecord|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}