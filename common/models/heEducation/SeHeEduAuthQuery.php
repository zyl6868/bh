<?php

namespace common\models\heEducation;


/**
 * This is the ActiveQuery class for [[SeHeEduAuth]].
 *
 * @see SeDateDictionary
 */
class SeHeEduAuthQuery extends \yii\db\ActiveQuery
{


    /**
     * @inheritdoc
     * @return SeHeEduAuth[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHeEduAuth|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


}