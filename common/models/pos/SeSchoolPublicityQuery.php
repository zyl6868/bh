<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSchoolPublicity]].
 *
 * @see SeSchoolPublicity
 */
class SeSchoolPublicityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeSchoolPublicity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeSchoolPublicity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}