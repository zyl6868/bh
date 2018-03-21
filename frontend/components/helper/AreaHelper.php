<?php
 namespace frontend\components\helper;
 use common\models\pos\ComArea;
 use yii\caching\FileCache;

 /**
 * Created by PhpStorm.
 * User: a
 * Date: 14-6-24
 * Time: 上午11:43
 */
class AreaHelper
{



private static function  getAreaData(){


    $fileCache = new FileCache();
    $cacheKey = "areaData_cache";

    $value = $fileCache->get($cacheKey);
    if ($value === false) {
        $value = ComArea::find()->asArray()->all();
        $fileCache->set($cacheKey, $value, 3600);

    }
    return $value;
}


    /**
     *   获取省列表
     * @return CActiveRecord[]
     */
public static function  getProvinceList()
    {
        return from(self::getAreaData())->where('$v ==> $v["Levels"]==1')->toList();
    }

    /**
     *   根据省获取市列表
     * @param $province
     * @return CActiveRecord[]
     */
    public static function  getCityList($province)
    {
        return from(self::getAreaData())->where(
            function ($v) use ($province) {
                return $v["Levels"] == 2 && $v["AreaPID"] == $province;
            }
        )->toList();
    }


    /**
     *   获取子条目
     * @param $province
     * @return CActiveRecord[]
     */
    public static function   getList($id)
    {
        return from(self::getAreaData())->where(function ($v) use ($id) {
            return $v["AreaPID"] == $id;
        })->toList();
    }

    /**
     *  根据市获取区列表
     * @param $city
     * @return CActiveRecord[]
     */
    public static function  getRegionList($city)
    {
        return from(self::getAreaData())->where(
            function ($v) use ($city) {
                return $v["Levels"] == 3 && $v["AreaPID"] == $city;
            }
        )->toList();

    }

    /**  根据区域ID获取名称
     * @param $areaID
     * @return mixed|string
     */
    public static function  getAreaName($areaID)
    {
        $a = from(self::getAreaData())->firstOrDefault(null, function ($v) use ($areaID) {
            return $v["AreaID"] == $areaID;
        });
        if ($a == null) {
            return "";
        }
        return $a["AreaName"];

    }

    /**
     * 获取当前地区的市id
     * @param string $areaID
     * @return string
     */
    public static function getOneInfo(string $areaID){
        $a = from(self::getAreaData())->firstOrDefault(null,function ($v) use ($areaID){
            return $v["AreaID"] == $areaID;
        });
        if ($a == null) {
            return '';
        }
        return $a['AreaPID'];

    }

} 