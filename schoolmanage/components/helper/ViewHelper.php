<?php


namespace schoolManage\components\helper;
use yii\data\Pagination;

/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2014/12/9
 * Time: 15:01
 */
class ViewHelper
{


    /**
     * 空view 信息
     * @param $context
     * @return mixed
     */
    public static function emptyView($message = '此处暂无内容')
    {
        echo "<div class='empty'><i></i>$message</div>";
    }


    /**
     * 根据空page 显示空信息
     * @param Pagination $pages
     * @param string $message
     */
    public static function  emptyViewByPage($pages, $message = '此处暂无内容')
    {
        if (isset($pages)) {
            if ($pages->totalCount == 0 || ($pages->totalCount - $pages->getPage() * $pages->getPageSize()) <= 0) {
                self::emptyView($message);
            }
        }
    }

}