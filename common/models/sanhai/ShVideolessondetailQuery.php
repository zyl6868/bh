<?php

namespace common\models\sanhai;

/**
 * This is the ActiveQuery class for [[ShVideolessondetail]].
 *
 * @see ShVideolessondetail
 */
class ShVideolessondetailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ShVideolessondetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ShVideolessondetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}