<?php

namespace common\models\sanhai;

/**
 * This is the ActiveQuery class for [[ShLessonplanDelete]].
 *
 * @see ShLessonplanDelete
 */
class ShLessonplanDeleteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ShLessonplanDelete[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ShLessonplanDelete|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}