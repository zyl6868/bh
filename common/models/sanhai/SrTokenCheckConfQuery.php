<?php

namespace common\models\sanhai;

/**
 * This is the ActiveQuery class for [[SrTokenCheckConf]].
 *
 * @see SrTokenCheckConf
 */
class SrTokenCheckConfQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SrTokenCheckConf[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SrTokenCheckConf|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}