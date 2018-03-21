<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHomeworkPlatformMaterials]].
 *
 * @see SeHomeworkPlatformMaterials
 */
class SeHomeworkPlatformMaterialsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeHomeworkPlatformMaterials[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHomeworkPlatformMaterials|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}