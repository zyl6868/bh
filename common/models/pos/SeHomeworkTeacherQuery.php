<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHomeworkTeacher]].
 *
 * @see SeHomeworkTeacher
 */
class SeHomeworkTeacherQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[isDelete]]=0');
        return $this;
    }


    /**
     * 查询 我的创建 条件
     * @param integer $userId
     * @return $this
     */
    public function source_user(int $userId)
    {
        //使用sourceType查询我创建的作业， 表中数据有问题，目前先注释掉，使用下方方法查询
        //$this->andWhere(['sourceType'=>SeHomeworkTeacher::SOURCE_USER,'creator'=>$userId]);

        //使用homeworkPlatformId 查询我创建的作业， 大于0为我收藏的作业 等于0为我的创建作业
        $this->andWhere(['homeworkPlatformId'=>0,'creator'=>$userId])->active();
        return $this;
    }

    /**
     * 查询 我的收藏 条件
     * @param $userId
     * @return $this
     */
    public function source_platform($userId)
    {
        $this->andWhere(['sourceType'=>SeHomeworkTeacher::SOURCE_PLATFORM,'creator'=>$userId])->active();
        return $this;
    }
    /**
     * @inheritdoc
     * @return SeHomeworkTeacher[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeHomeworkTeacher|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}