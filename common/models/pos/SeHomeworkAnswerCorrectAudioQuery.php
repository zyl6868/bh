<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHomeworkAnswerCorrectAudio]].
 *
 * @see SeHomeworkAnswerCorrectAudio
 */
class SeHomeworkAnswerCorrectAudioQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeHomeworkAnswerCorrectAudio[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHomeworkAnswerCorrectAudio|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}