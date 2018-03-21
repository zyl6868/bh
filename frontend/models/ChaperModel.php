<?php
namespace frontend\models;
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-7-28
 * Time: 下午6:22
 */
class ChaperModel
{
    private $data;

    function __construct()
    {
        $this->data = $this->getData();
    }

    /**
     *获取知识点查询主树
     */
    public function  getData()
    {
        $result = \Yii::$app->cache->get('chapter_data');
        if ($result == null) {
            $result = [
                ["cid" => 1, "pid" => 0, "subject" => 1, "grade" => 1, "version" => 1, "chaptername" => 'diyizhang', "isDelete" => 0],
                ["cid" => 2, "pid" => 0, "subject" => 1, "grade" => 1, "version" => 1, "chaptername" => 'diyizhang1', "isDelete" => 0],
                ["cid" => 3, "pid" => 1, "subject" => 1, "grade" => 1, "version" => 1, "chaptername" => 'diyizhang2', "isDelete" => 0],
                ["cid" => 4, "pid" => 1, "subject" => 1, "grade" => 1, "version" => 1, "chaptername" => 'diyizhang3', "isDelete" => 0],
                ["cid" => 4, "pid" => 1, "subject" => 1, "grade" => 1, "version" => 1, "chaptername" => 'diyizhang4', "isDelete" => 0],
            ];
            \Yii::$app->cache->set('chapter_data', $result, 120);
        }

        return $result;

    }

    /**
     *   获取子条目
     * @param $province
     * @return CActiveRecord[]
     */
    public function   getList($id)
    {
        return from($this->data)->where(function ($v) use ($id) {
            return $v["pid"] == $id;
        })->toArray();
    }

    /**
     *   获取一条条目
     * @param $province
     * @return CActiveRecord[]
     */
    public function   getOne($id)
    {
        return from($this->data)->firstOrDefault(null, function ($v) use ($id) {
            return $v["pid"] == $id;
        });
    }


}