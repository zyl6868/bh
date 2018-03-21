<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 15-6-25
 * Time: 下午12:15
 */

namespace common\helper;


class DateTimeHelper
{

    public static function timestampDiv1000($d)
    {
        return $d ? (int)($d / 1000) : null;
    }

    public static function  timestampX1000()
    {

        return time() * 1000;

    }

    /**
     * 转换成０'0"
     * @param $duration
     * @return string
     */
    public static function convertMinSec($duration){
        if($duration > 60){
            return floor($duration/60)."'".floor($duration%60).'"';
        }else{
            return floor($duration).'"';
        }
    }

}