<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHomeworkAnswerInfo]].
 *
 * @see SeHomeworkAnswerInfo
 */
class SeHomeworkAnswerInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    public function answerStatus()
    {
        $this->andWhere('[[isUploadAnswer]]=1');
        return $this;
    }

    /**
     * @inheritdoc
     * @return SeHomeworkAnswerInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHomeworkAnswerInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}