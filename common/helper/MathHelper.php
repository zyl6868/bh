<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 15-7-3
 * Time: 下午1:06
 */

namespace common\helper;

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 15-5-3
 * Time: 下午1:56
 */


/**
 * 数学计算
 * Class MathHelper
 * @package common\helper
 */
class MathHelper
{

    /**
     * 除法加上余数为0
     * @param $p1
     * @param $p2
     * @return float|int
     */
    public static function division($p1, $p2)
    {
        if (empty($p2)) {
            return 0;
        }
        return $p1 / $p2;
    }


}