<?php
/**
 * Created by PhpStorm.
 * User: ysd
 * Date: 14-11-6
 * Time: 下午4:57
 */
namespace frontend\modules\teacher\models;
use yii\base\Model;

class ModifyParMetForm extends Model{
    /*
     * 班级id
     * 会议id
     * 会议名字
     * 开始时间
     * 结束时间
     * 会议内容
     */
    public $classid;
    public $meeid;
    public $meetingname;
    public $time1;
    public $time2;
    public $content;

    public function rules()
    {
        return [
            [["classid",'meeid','meetingname','time1','time2',"content"], "required"],
            [["classid",'meeid','meetingname','time1','time2',"content"], "safe"],
        ];
    }

    public function attributeLabels()
    {
        return [
            "classid" => "classid",
            "meeid" => "meeid",
            "meetingname" => "meetingname",
            "time1" => "time1",
            "time2" => "time2",
            "content" => "content",
        ];
    }
}