<?php
namespace frontend\models;

use yii\base\Model;

class InformationPackForm extends Model
{
    public $type;//资料类型
    public $name;
    public $provience;//省
    public $city;//市
    public $county;//县
    public $subjectID;//学科
    public $grade;//年级
    public $materials;//教材版本
    public $school;//学校
    public $url;//上传附件
    public $brief;//简介
    public $chapKids;//知识点
//    public $chapter;//章节
    public $tags;//自定义标签
    public $contentType;//知识点和章节的类型；
    public $otherSchool;//其他学校
    public $schoolLevel;//学籍
//    public $creator;


    /**
     * @return array
     */
    public function rules()
    {

        return [
            // array('type,name,provience,city,county,subjectID,grade,materials,contentType,tags ,url',"required"),
            [['type,name', 'grade,url'], "required"],
            [["type,name", "grade", "provience", "city", "county", "subjectID", "school", "chapKids", "url", "brief", "tags", "contentType", "otherSchool", "materials", "schoolLevel"], "safe"],

        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            "type" => "type",
            "name" => "name",
            "provience" => "provience",
            "city" => "city",
            "county" => "county",
            "subjectID" => "subjectID",
            "grade" => "grade",
            "school" => "school",
            "materials" => "materials",
            "url" => "url",
            "brief" => "brief",
            "chapKids" => "chapKids",
            "contentType" => "contentType",
            "otherSchool" => "otherSchool",
            "schoolLevel" => "schoolLevel"

        );
    }
}