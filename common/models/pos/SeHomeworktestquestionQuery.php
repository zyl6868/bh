<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHomeworktestquestion]].
 *
 * @see SeHomeworktestquestion
 */
class SeHomeworktestquestionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeHomeworktestquestion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHomeworktestquestion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}