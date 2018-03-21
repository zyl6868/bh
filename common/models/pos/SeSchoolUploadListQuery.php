<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSchoolUploadList]].
 *
 * @see SeSchoolUploadList
 */
class SeSchoolUploadListQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeSchoolUploadList[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeSchoolUploadList|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}