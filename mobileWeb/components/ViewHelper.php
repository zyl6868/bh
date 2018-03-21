<?php
/**
 * Created by PhpStorm.
 * User: WangShiKui
 * Date: 17-11-17
 * Time: 下午6:06
 */

namespace mobileWeb\components;


class ViewHelper
{


    /**
     * 空view 信息
     * @param string $message
     * @return mixed
     * @internal param $context
     */
    public static function emptyView($message = '暂无数据')
    {
        echo '<div class="noCtn"><img src="'.BH_CDN_RES.'/static/img/noCtn.png"><p>'.$message.'</p></div>';
    }



}