<?php


namespace frontend\components\helper;
use yii\helpers\HtmlPurifier;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-2
 * Time: 下午2:38
 */
class StringHelper
{

    /** 截取字符串
     * @param $str
     * @param $len
     * @param string $suffix
     * @return string
     */
    public static function  cutStr($str, $len, $suffix = '...')
    {
        if (empty($str))
            return '';
        $str = strip_tags($str);
        $result = mb_substr($str, 0, $len, "utf8");
        if (mb_strlen($str, 'utf8') > $len) {
            $result = $result . $suffix;
        }
        return $result;
    }

    /**
     * 分隔字符不返回空的
     * @param $splitChar
     * @param $str
     * @return array
     */
    public static function  splitNoEMPTY($str, $splitChar = ',')
    {

        if (!isset($str)) {
            return array();
        }
        return preg_split("/$splitChar/", trim($str), -1, PREG_SPLIT_NO_EMPTY);
    }


    /**
     * html 去xss 标签
     * @param $str
     * @return mixed
     */
    public static function  htmlPurifier($str)
    {
        $htmlPurifier = new  HtmlPurifier();
        return $htmlPurifier->process($str);
    }

    /**
     * @param $tagsArr
     * @param $str
     * @return mixed
     */
    public static function  html_strip_tags($tagsArr, $str)
    {
        $p=[];
        foreach ($tagsArr as $tag) {
            $p[] = "{(<(?:/" . $tag . "|" . $tag . ")[^>]*>)}i";
        }
        $return_str = preg_replace($p, "", $str);
        return $return_str;
    }

    /**
     * textarea中 转换空格为&nbsp
     *
     */
    public static function translateSpace($string){

        return nl2br(str_replace(" ","&nbsp;",$string));

    }


}