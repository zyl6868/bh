<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSystemConf]].
 *
 * @see SeSystemConf
 */
class SeSystemConfQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeSystemConf[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeSystemConf|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}