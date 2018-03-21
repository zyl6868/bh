<?php
namespace frontend\models;

use yii\base\Model;

/**
 * This is the model class for table "{{Student}}".
 *
 * The followings are the available columns in table '{{Student}}':
 */
class  DianboCourseForm extends Model
{
    public $classType;
    public $provience;
    public $city;
    public $county;
    public $grade;
    public $subject;
    public $version;
    public $className;
    public $teacher;
    public $isCharge;
    public $imgUrl;
    public $price;
    public $tProportion;
    public $isAgreement;
    public $introduce;

    public $name;
    public $doc;
    public $video;
    public $type;
    public $kid;


    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [["classType", "provience", "city", "county", "grade", "subject", "version", "className", "introduce", "teacher", "isCharge", "imgUrl", "price", "tProportion", "isAgreement"], "required",],
            [["classType", "provience", "city", "county", "grade", "subject", "version", "className", "introduce", "teacher", "isCharge", "imgUrl", "price", "tProportion", "isAgreement"], "safe",]
//            array("name,doc,video,type,kid","required", 'on' => 'keshi'),
        ];
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            "userID" => "UserID",
            "paperName" => "PaperName",
            "paperRoute" => "PaperRoute",
            "provience" => "Provience",
            "city" => "City",
            "county" => "County",
            "subjectID" => "SubjectID",
            "versionID" => "versionID",
            "knowledgePoint" => "KnowledgePoint",
            "summary" => "Summary",
            "gradeID" => "GradeID"
        );
    }


}
