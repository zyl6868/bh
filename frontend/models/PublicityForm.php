<?php
namespace frontend\models;

use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: bbb
 * Date: 2015/7/8
 * Time: 14:09
 */
class   PublicityForm extends Model
{

    public $publicityTitle;
    public $publicityType;
    public $publicityContent;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            //array('paperName',"paperRoute","provience","city","county","subject","textBook","knowledge","paperIntroduce"),
            [['publicityTitle', 'publicityType', 'publicityContent'], "safe"],
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
            "publicityType" => "分类",
            "publicityTitle" => "公示标题",
            "publicityContent" => "公示内容",
            "imageUrl" => "公示图片"
        );
    }


}
