<?php
namespace frontend\models;

use yii\base\Model;

/**
 * Created by 王
 * User: Administrator
 * Date: 14-9-10
 * Time: 上午11:46
 */
class BriefForm extends Model
{
    public $name;
    public $schoolLevel;
    public $year;
    public $content;


    public function rules()
    {
        return [
            [["name", "schoolLevel", "year", "content"], "required",],
            [["name", "length"], 'max' => 50,],
            [["schoolLevel"], 'numerical',],
            [["year"], 'numerical',],
            [["name", "schoolLevel", "year", "content"], "safe", "on" => "search",]
        ];
    }


    public function attributeLabels()
    {
        return array(
            "name" => "name",
            "school" => "school",
            "year" => "year",
            "content" => "content"
        );
    }


}