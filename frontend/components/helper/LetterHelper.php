<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-2
 * Time: 下午2:38
 */
namespace frontend\components\helper;

class LetterHelper {
    /**
     * @param $ranking
     * @return string
     * 对应的数字转化成大写字母
     */
    public static function getLetter($ranking){
        return  chr(65+$ranking);
    }


    /**
     * @param $string
     * @return int
     * 大写字母转换成ascii对应的数字
     */
    public static function getNum($string){
        return ord($string)-65;
    }


    /**
     * 判断题型显示
     * @param $number
     * @return mixed
     */
    public static function rightOrWrong($number){
           $array=array(
               '错','对'
           );
        return $array[$number];
    }

    //题目匹配选项
    public static function MatchOptions($num){

        $option = array(
            '0' => array('id' => '0', 'content' => '<em>A</em>'),
            '1' => array('id' => '1', 'content' => '<em>B</em>'),
            '2' => array('id' => '2', 'content' => '<em>C</em>'),
            '3' => array('id' => '3', 'content' => '<em>D</em>'),
            '4' => array('id' => '4', 'content' => '<em>E</em>'),
            '5' => array('id' => '5', 'content' => '<em>F</em>'),
            '6' => array('id' => '6', 'content' => '<em>G</em>'),
            '7' => array('id' => '7', 'content' => '<em>H</em>'),
            '8' => array('id' => '8', 'content' => '<em>I</em>'),
            '9' => array('id' => '9', 'content' => '<em>J</em>'),
            '10' => array('id' => '10', 'content' => '<em>K</em>'),
            '11' => array('id' => '11', 'content' => '<em>L</em>'),
            '12' => array('id' => '12', 'content' => '<em>M</em>'),
            '13' => array('id' => '13', 'content' => '<em>N</em>'),
            '14' => array('id' => '14', 'content' => '<em>O</em>'),
            '15' => array('id' => '15', 'content' => '<em>P</em>'),
            '16' => array('id' => '16', 'content' => '<em>Q</em>')
        );

        return array_slice($option, 0 ,$num);
    }

    //题目匹配选项2.0
    public static function MatchOptions2($num){

        $option = array(
            '0' => array('id' => '0', 'content' => 'A'),
            '1' => array('id' => '1', 'content' => 'B'),
            '2' => array('id' => '2', 'content' => 'C'),
            '3' => array('id' => '3', 'content' => 'D'),
            '4' => array('id' => '4', 'content' => 'E'),
            '5' => array('id' => '5', 'content' => 'F'),
            '6' => array('id' => '6', 'content' => 'G'),
            '7' => array('id' => '7', 'content' => 'H'),
            '8' => array('id' => '8', 'content' => 'I'),
            '9' => array('id' => '9', 'content' => 'J'),
            '10' => array('id' => '10', 'content' => 'K'),
            '11' => array('id' => '11', 'content' => 'L'),
            '12' => array('id' => '12', 'content' => 'M'),
            '13' => array('id' => '13', 'content' => 'N'),
            '14' => array('id' => '14', 'content' => 'O'),
            '15' => array('id' => '15', 'content' => 'P'),
            '16' => array('id' => '16', 'content' => 'Q')
        );

        return array_slice($option, 0 ,$num);
    }

}