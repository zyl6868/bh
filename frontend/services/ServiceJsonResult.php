<?php

namespace frontend\services;

use JsonMapper;

/**
 * Created by PhpStorm.
 * User: yangjie
 * Date: 14-6-27
 * Time: 下午2:53
 */
class ServiceJsonResult
{
    /**
     * @var string 返回状态码
     */
    public $resCode;
    /**
     * @var string 返回状态信息
     */
    public $resMsg;

    public $data;
    public $map;

    /**
     *   数据data 反射
     * @param $class
     */
    public function  dataReflectModel($class)
    {
        if ($this->data === null)
            return null;
        $mapper = new JsonMapper();
        $object = $mapper->map($this->data, $class);

        return $object;
    }

    /**
     * @param $arr
     * @param $class
     * @return mixed|null
     */
    public function  dataReflectArrayModel($arr, $class = null)
    {
        if ($this->data === null)
            return array();
        $mapper = new JsonMapper();
        $object = $mapper->mapArray($this->data, $arr, $class);
        return $object;
    }


}