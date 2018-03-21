<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeQuestionFavoriteFolder]].
 *
 * @see SeQuestionFavoriteFolder
 */
class SeQuestionFavoriteFolderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeQuestionFavoriteFolder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeQuestionFavoriteFolder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}