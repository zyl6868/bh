<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeQuestionFavoriteFolderNew]].
 *
 * @see SeQuestionFavoriteFolderNew
 */
class SeQuestionFavoriteFolderNewQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeQuestionFavoriteFolderNew[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeQuestionFavoriteFolderNew|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}