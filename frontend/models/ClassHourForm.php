<?php
namespace frontend\models;

use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-11-5
 * Time: 下午5:27
 */
class ClassHourForm extends Model
{

    /**
     * 节次号，如：第1节
     * @var
     */
    public $cNum;
    /**
     * 课时名称
     * @var
     */
    public $cName;

    /**
     * 知识点或章节的类型
     * @var
     */
    public $type;

    /**
     * 知识点或章节的值
     * @var
     */
    public $kcid;

    /**
     * 讲义id
     * @var
     */
    public $teachMaterialID;

    /**
     * 上传视频
     * @var
     */
    public $videoUrl;


    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [

            [["cName", "type"], 'required',],

            [["cNum", "cName", "type", "kcid", "teachMaterialID", "videoUrl"], "safe",]
        ];
    }

    public function attributeLabels()
    {
        return array();
    }
}