<?php
namespace frontend\models;

use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/4/22
 * Time: 16:07
 */
class TakePhotoForm extends Model
{


    public $provience;        //省
    public $city;            //市
    public $country;        //区县
    public $gradeid;        //适用年级 关联年级信息表的年级ID
    public $subjectid;        //科目 关联科目信息表的科目ID
    public $versionid;        //版本 管理版本信息表的版本ID
    public $complexity;        //难易程度,复杂度 21101	简单 21102	复杂 21103	非常复杂
    public $content;        //题目内容（多个url用逗号隔开）
//	public $answerContent;	//答案（多个url用逗号隔开）
    public $analytical;        //解析


    public function rules()
    {
        return [
            [['provience', 'city', 'country', 'gradeid', 'subjectid', 'complexity', 'versionid', 'content'], "required"],
            [['provience', 'city', 'country', 'gradeid', 'subjectid', 'complexity', 'versionid', 'content', 'analytical'], "safe"],
        ];
    }

    public function attributeLabels()
    {
        return array(

            "provience" => "Provience",
            "city" => "City",
            "country" => "Country",
            "gradeid" => "GradeID",
            "subjectid" => "SubjectID",
            "complexity" => "complexity",
            "versionid" => "versionID",
            "content" => "content",
//			"answerContent"=>"answerContent",
            "analytical" => "analytical",
        );
    }
}