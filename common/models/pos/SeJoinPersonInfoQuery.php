<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeJoinPersonInfo]].
 *
 * @see SeJoinPersonInfo
 */
class SeJoinPersonInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeJoinPersonInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeJoinPersonInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}