<?php

namespace common\models\sanhai;

/**
 * This is the ActiveQuery class for [[ShQuestionPaper]].
 *
 * @see ShQuestionPaper
 */
class ShQuestionPaperQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[isDelete]]=0');
        return $this;
    }

    /**
     * @inheritdoc
     * @return ShQuestionPaper[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ShQuestionPaper|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}