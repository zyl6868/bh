<?php

namespace frontend\components\helper;


/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-2
 * Time: 下午2:38
 */
class NumberHelper
{


    /**
     * 数字转中文
     * @param $num
     * @param int $m
     * @return string
     */
    public static  function number2Chinese($num, $m = 1)
    {
        switch ($m) {
            case 0:
                $CNum = array(
                    array('零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖'),
                    array('', '拾', '佰', '仟'),
                    array('', '萬', '億', '萬億')
                );
                break;
            default:
                $CNum = array(
                    array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九'),
                    array('', '十', '百', '千'),
                    array('', '万', '亿', '万亿')
                );
                break;
        }

        $int=null;
        $fl=null;
        if (is_integer($num)) {
            $int = (string)$num;
        } else if (is_numeric($num)) {
            $num = explode('.', (string)(float)($num));
            $int = $num[0];
            $fl = isset($num[1]) ? $num[1] : FALSE;
        }
// 长度
        $len = strlen($int);
// 中文
        $chinese = array();
// 反转的数字
        $str = strrev($int);

        for ($i = 0; $i < $len; $i += 4) {
            $s = array(0 => $str[$i], 1 =>  isset($str[$i + 1])?$str[$i + 1]:'', 2 => isset($str[$i + 2])?$str[$i + 2]:'', 3 => isset( $str[$i + 3])? $str[$i + 3]:'');
            $j = '';
// 千位
            if ($s[3] !== '') {
                $s[3] = (int)$s[3];
                if ($s[3] !== 0) {
                    $j .= $CNum[0][$s[3]] . $CNum[1][3];
                } else {
                    if ($s[2] != 0 || $s[1] != 0 || $s[0] != 0) {
                        $j .= $CNum[0][0];
                    }
                }
            }
// 百位
            if ($s[2] !== '') {
                $s[2] = (int)$s[2];
                if ($s[2] !== 0) {
                    $j .= $CNum[0][$s[2]] . $CNum[1][2];
                } else {
                    if ($s[3] != 0 && ($s[1] != 0 || $s[0] != 0)) {
                        $j .= $CNum[0][0];
                    }
                }
            }
// 十位
            if ($s[1] !== '') {
                $s[1] = (int)$s[1];


                if ($s[1] !== 0) {
                    $j .= ($s[1]===1?'':$CNum[0][$s[1]]) . $CNum[1][1];

                } else  {
                    if ($s[0] != 0 && $s[2] != 0) {
                        $j .= $CNum[0][$s[1]];
                    }
                }
            }
// 个位
            if ($s[0] !== '') {
                $s[0] = (int)$s[0];
                if ($s[0] !== 0) {
                    $j .= $CNum[0][$s[0]] . $CNum[1][0];
                } else {
// $j .= $CNum[0][0];
                }
            }
            $j .= $CNum[2][$i / 4];
            array_unshift($chinese, $j);
        }
        $chs = implode('', $chinese);
        if ($fl) {
            $chs .= '点';
            for ($i = 0, $j = strlen($fl); $i < $j; $i++) {
                $t = (int)$fl[$i];
                $chs .= $str[0][$t];
            }
        }
        return $chs;
    }


}