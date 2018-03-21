<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 15-6-25
 * Time: 下午12:05
 */

namespace common\helper;


class StringHelper
{

    #字符表
    public static $charset = "0123456789abcdefghijklmnopqrstuvwxyz";


    public static function isEmpty($value)
    {
        return $value === '' || $value === [] || $value === null || is_string($value) && trim($value) === '';
    }

//图片路径的替换成cdn路径
    public static function replacePath($content)
    {

        if (preg_match("/<img.*>/", $content)) {
            $resCdn = resCdn();
            $img = preg_replace("/src=\"\//", "src=\"$resCdn/", $content);
            $img = preg_replace("/src=\'\//", "src=\'$resCdn/", $img);
            return $img;
        } else {
            return $content;
        }

    }


    /**
     * 短连接生成算法
     * @param $url
     * @return array
     */
    public static function short(string $url)
    {
        $key = "banhai";

        $urlhash = md5($key . rand(1000, 9999) . '::::' . $url);

        $len = strlen($urlhash);

        #将加密后的串分成4段，每段4字节，对每段进行计算，一共可以生成四组短连接
        for ($i = 0; $i < 4; $i++) {

            $urlhash_piece = substr($urlhash, $i * $len / 4, $len / 4);
            #将分段的位与0x3fffffff做位与，0x3fffffff表示二进制数的30个1，即30位以后的加密串都归零
            $hex = hexdec($urlhash_piece) & 0x3fffffff; #此处需要用到hexdec()将16进制字符串转为10进制数值型，否则运算会不正常

            $short_url = "";
            #生成6位短连接
            for ($j = 0; $j < 8; $j++) {
                #将得到的值与0x0000003d,3d为61，即charset的坐标最大值
                $short_url .= self::$charset[$hex & 0x00000023];
                #循环完以后将hex右移5位
                $hex = $hex >> 2;
            }

            $short_url_list[] = $short_url;
        }

        return $short_url_list;
    }

}