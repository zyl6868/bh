<?php
namespace frontend\models;

use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 15-1-19
 * Time: 下午5:02
 */
class UploadmaterialsForm extends Model
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

    public function rules()
    {

        return [

            [['type', 'name', 'url'], "required"],
            [['type', 'name', 'grade', 'subjectID', 'url', 'brief', 'tags', 'chapKids', 'contentType', 'provience', 'city', 'county'], "safe"],

        ];
    }

    public function attributeLabels()
    {
        return array(
            "type" => "type",
            "name" => "name",
            "subjectID" => "subjectID",
            "url" => "url",
            "brief" => "brief",
            "tags" => "tags"
        );
    }

}