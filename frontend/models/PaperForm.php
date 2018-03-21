<?php
namespace frontend\models;

use yii\base\Model;

/**
 * This is the model class for table "{{Student}}".
 *
 * The followings are the available columns in table '{{Student}}':
 */
class  PaperForm extends Model
{
    public $userID;
    public $paperName;
    public $paperRoute;
    public $provience;
    public $city;
    public $county;
    public $subjectID;
    public $versionID;
    public $knowledgePoint;
    public $summary;

    public $gradeID;
    public $titleID;
    public $sourceID;
    public $year;
    public $schoolID;
    public $deadlineTime;
    public $describe;
    public $image;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            //array('paperName',"paperRoute","provience","city","county","subject","textBook","knowledge","paperIntroduce"),
            [["userID", "paperName", "paperRoute", "provience", "city", "county", "subjectID", "versionID", "knowledgePoint", "summary", "gradeID", "deadlineTime", "describe", "image"], "safe"],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
//            array("paperName,paperRoute,provience,city,county,subjectID,versionID,knowledgePoint,summary,gradeID", 'safe','on'=>'search'),
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
            "gradeID" => "GradeID",
            "deadlineTime" => "DeadlineTime",
            "describe" => "Describe"
        );
    }


}
