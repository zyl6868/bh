<?php
namespace frontend\components\helper;
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/1/19
 * Time: 15:53
 */
class DepartAndSubHelper{
    private  static $topicSubArray=[
        '20201'=>[
            '10010'=>'语文',
            '10011'=>'数学',
            '10012'=>'英语',

        ],
        '20202'=>[
            '10010'=>'语文',
            '10011'=>'数学',
            '10012'=>'英语',
            '10013'=>'生物',
            '10014'=>'物理',
            '10015'=>'化学',
            '10016'=>'地理',
            '10017'=>'历史',
            '10029'=>'思想品德',
        ],
        '20203'=>[
            '10010'=>'语文',
            '10011'=>'数学',
            '10012'=>'英语',
            '10013'=>'生物',
            '10014'=>'物理',
            '10015'=>'化学',
            '10016'=>'地理',
            '10017'=>'历史',
            '10018'=>'政治',
        ]
    ];

    //视频
    private  static $topicArray=[
        '20202'=>[
            '10011'=>'数学',
            '10014'=>'物理',
            '10015'=>'化学',
        ],
        '20203'=>[
            '10011'=>'数学',
            '10014'=>'物理',
            '10015'=>'化学',
        ]
    ];
    private $videoSubArray=[];
    public static  function  getTopicSubArray(){

        return self::$topicSubArray;
    }
    public static function getvideoSubArray(){
        return self::$topicArray;
    }
}