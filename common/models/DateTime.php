<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/31
 * Time: 19:11
 */
namespace common\models;

use Yii;
use yii\base\Model;


/**
 * Class DateTime
 * @package common\models
 */
class DateTime extends Model
{
    /**
     * 上一个月的月份
     * @var
     */
    public $lastMonth;

    /**
     * 上一个月的第一天的00:00:00时间戳
     * @var
     */
    public $lastMonthFirstDay;

    /**
     * 上一个月的最后一天的23:59:59的时间戳
     * @var
     */
    public $lastMonthLastDay;

    /**
     * 上一个月的年份
     * @var
     */
    public $lastMonthYear;



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lastMonth' => '上一个月的月份',
            'lastMonthFirstDay' => '上一个月的第一天的00:00:00时间戳',
            'lastMonthLastDay' => '上一个月的最后一天的23:59:59的时间戳',
            'lastMonthYear' => '上一个月的年份'
        ];
    }

    public function init()
    {
        $time = date('Y-m-01',time());
        $lastMonthTime = strtotime("$time -1 month");
        $this->lastMonth = date('m', $lastMonthTime);
        $this->lastMonthYear = date('Y', $lastMonthTime);
        $this->lastMonthFirstDay = date('Y-m-01 00:00:00', $lastMonthTime);
        $this->lastMonthLastDay = date('Y-m-d 23:59:59', strtotime("$this->lastMonthFirstDay +1 month -1 day"));

    }
}
