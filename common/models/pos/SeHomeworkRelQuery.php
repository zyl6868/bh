<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHomeworkRel]].
 *
 * @see SeHomeworkRel
 */
class SeHomeworkRelQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[isDelete]]=0');
        return $this;
    }

    /**
     * @inheritdoc
     * @return SeHomeworkRel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHomeworkRel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}