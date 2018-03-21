<?php
namespace frontend\models;
/**
 * 身份
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-7-28
 * Time: 下午6:22
 */

class IdentityModel
{

    /**
     * 通过职务ID获取职务名称
     * @param $identityID
     * @return mixed
     */
    public static function getIdentityNameByID($identityID)
    {
        $identityArray = self::getTeacherIdentity();
        return isset($identityArray[$identityID]) ?: "";
    }

    /**
     *   老师的角色
     */
    public static function   getTeacherIdentity()
    {
        return [20401 => '班主任', 20402 => '任课老师'];
    }

}