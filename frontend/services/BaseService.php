<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 14-6-27
 * Time: 上午10:59
 */
namespace frontend\services;

use ArrayObject;
use Exception;
use JsonMapper;
use ReflectionClass;
use ReflectionProperty;

/**
 * Class SchoolService
 */
class BaseService
{

    private static $_instance;

    protected $_soapClient;

    /**
     *成功代码
     */
    const   successCode = "000000";
    const    failCode = 500000;


    /**
     *   反回通用结果
     * @param $json
     * @return ServiceJsonResult
     */
    public function  mapperJsonResult($json)
    {
        $mapper = new JsonMapper();
        //  ServiceJsonResult
        $object = $mapper->map($json, new ServiceJsonResult());
        if ($object->resCode > self::failCode) {
            throw new Exception('接口错误：' . $object->resCode);
        }
        return $object;
    }


    /**
     * 对象公共字段转数组
     * @param $classObject
     * @return array
     */
    public function   classToArray($classObject)
    {
        $class = new ReflectionClass($classObject);
        $private_properties = $class->getProperties(ReflectionProperty::IS_PUBLIC);
        $objectArray = array();
        foreach ($private_properties as $fr) {
            $objectArray[$fr->getName()] = $fr->getValue($classObject);
        }
        return $objectArray;
    }

    /** 获取返回结果
     * @param $soapResult
     * @return ServiceJsonResult
     * @throws \Camcima\Exception\InvalidParameterException
     */
    public function   soapResultToJsonResult($soapResult)
    {
        $jsonStr = $this->_soapClient->mapSoapResult($soapResult, new ArrayObject());
        $json = json_decode($jsonStr);
        return $this->mapperJsonResult($json);
    }

    /**
     *   单例模式
     * @return BaseService
     */
    public static function getInstance($className = __CLASS__)
    {

        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

}