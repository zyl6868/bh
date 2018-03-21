<?php
/**
 * Created by unizk.
 * User: ysd
 * Date: 2015/4/22
 * Time: 10:55
 */

namespace frontend\modules\teacher\models;
use yii\base\Model;

class CameraAddPaperForm extends  Model{

    public $provience;              //适用地区 省
    public $city;                   //市
    public $country;                 //区县
    public $gradeid;                //年级ID
    public $subjectid;                   //科目ID
    public $versionid;                   //版本
    public $complexity;                   //难易程度
    public $content;                   //题目详情
    public $answerContent;                   //答案与解析


    /**
     * @return array
     */
    public function rules()
    {
        return [
            [["provience","city","country","gradeid","subjectid","complexity","versionid","content"], "required"],
            [["provience","city","country","gradeid","subjectid","complexity","versionid","content","answerContent"], "safe"],
        ];
    }

    public function attributeLabels()
    {
        return [

            "provience"=>"Provience",
            "city"=>"City",
            "country"=>"Country",
            "gradeid"=>"GradeID",
            "subjectid"=>"SubjectID",
            "complexity"=>"complexity",
            "versionid"=>"versionID",
            "content"=>"content",
            "answerContent"=>"answerContent",
        ];
    }
}
?>

