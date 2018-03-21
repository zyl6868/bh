<?php
/**
 * Created by PhpStorm.
 * User: yangjie
 * Date: 17/1/17
 * Time: 上午10:45
 */
namespace common\models\dicmodels;


/**
 * Created by PhpStorm.
 * User: yangjie
 * Date: 2016/01/17
 * Time: 11:11
 */
interface DicModelInterFace
{
    public static function model();

    /**
     * 查询题目掌握程度数据
     * @return array
     */
    public function getDataList();

    /**
     * 查询题目掌握程度列表
     * @param $id
     * @return array
     */
    public function getList();

    /**
     * 下拉列表
     * @return array
     */
    public function getListData();


    /**
     * 查询单条数据
     * @param $id
     * @return \YaLinqo\Enumerable
     */
    public function getOne($id);

    public function  getName($id);


}