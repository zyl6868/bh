<?php

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 14-10-17
 * Time: 下午2:17
 */

namespace frontend\modules\teacher\models;

use yii\base\Model;

class MakePaperForm extends Model
{
    /**
     * 试卷ID
     * @var
     */
    public $paperId;

    /**
     * 试卷名称
     * @var
     */
    public $paperName;
    /** 省
     * @var
     */
    public $provience;
    /**
     * 市
     * @var
     */
    public $city;
    /**
     * 县
     * @var
     */
    public $county;
    /**
     * 年级
     * @var
     */
    public $gradeId;

    /** 科目
     * @var
     */
    public $subject;
    /**
     * @var
     */
    public $version;
    /**
     * @var
     */
    public $type;
    /**
     * 章节
     * @var
     */
    public $knowledgePointId;
    /**
     * @var
     */
    public $school;
    /**
     * @var
     */
    public $tags;
    /**
     * @var
     */
    public $url;


    /**
     * 试卷作者
     * @var
     */
    public $author;


    /** 试卷描述
     * @var
     */
    public $paperDescribe;

    /**
     * 试卷类型
     * @var
     */
    public $paperType;
    public $deadLineTime;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
//            array('knowledgePointId', 'required'),
            [['paperId', 'paperType', 'paperDescribe', 'author', 'provience', 'paperName', 'city', 'county', 'gradeId', 'subject', 'version', 'type', 'knowledgePointId', 'school', 'tags', 'url', 'paperDescribe', 'deadLineTime'], 'safe'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            "paperName" => "paperName",
            "provience" => "provience",
            "city" => "city",
            "county" => "county",
            "subject" => "subject",
            "version" => "version",
            "type" => "type",
            "school" => "school",
            "tags" => "tags",
            "url" => "url",
            "paperDescribe" => "paperDescribe",
            "deadLineTime" => "deadLineTime"
        ];
    }

}
