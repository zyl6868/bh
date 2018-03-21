<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeClass]].
 *
 * @see SeClass
 */
class SeClassQuery extends \yii\db\ActiveQuery
{
    /**
     *删除的班
     * @return $this
     */
    public function isDelete()
    {
//        $this->andWhere('[[isDelete]]=0');
        return $this;
    }

    /**
     *活动的班
     * @return $this
     */
    public function active()
    {
        $this->andWhere('[[status]]=:status',[':status'=>SeClass::IS_LIVE]);
        return $this;
    }

    /**
     * 封班
     * @return $this
     */
    public function close()
    {
        $this->andWhere('[[status]]=:status',[':status'=>SeClass::IS_CLOSED]);
        return $this;
    }

    /**
     * 毕业
     * @return $this
     */
    public function over()
    {
        $this->andWhere('[[status]]=:status',[':status'=>SeClass::IS_OVER]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return SeClass[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeClass|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}