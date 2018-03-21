<?php

namespace common\models\heEducation;

/**
 * This is the ActiveQuery class for [[ShHeSchoolInfo]].
 *
 * @see ShHeSchoolInfo
 */
class ShHeSchoolInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ShHeSchoolInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ShHeSchoolInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}