<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHomeworkPlatformSuggest]].
 *
 * @see SeHomeworkPlatformSuggest
 */
class SeHomeworkPlatformSuggestQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeHomeworkPlatformSuggest[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHomeworkPlatformSuggest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}