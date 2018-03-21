<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeSchoolInfo]].
 *
 * @see SeSchoolInfo
 */
class SeSchoolInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SeSchoolInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    public function  findNameById($id)
    {

        $result = $this->andWhere('[[schoolID]]=:id', ['id' => $id])->select('schoolName')->limit(1)->one();
        if ($result != null) {
            return $result->schoolName;
        }
        return '';
    }

    /**
     * @inheritdoc
     * @return SeSchoolInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}