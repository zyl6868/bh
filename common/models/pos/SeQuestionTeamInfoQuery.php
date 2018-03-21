<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeQuestionTeamInfo]].
 *
 * @see SeQuestionTeamInfo
 */
class SeQuestionTeamInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeQuestionTeamInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeQuestionTeamInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}