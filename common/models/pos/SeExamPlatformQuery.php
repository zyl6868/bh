<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeExamPlatform]].
 *
 * @see SeExamPlatform
 */
class SeExamPlatformQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeExamPlatform[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeExamPlatform|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}