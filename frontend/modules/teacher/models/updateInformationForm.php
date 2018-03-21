<?php
/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2014/11/17
 * Time: 18:12
 */
namespace frontend\modules\teacher\models;
use yii\base\Model;

class updateInformationForm extends Model
{
    public $informationID;	    //资讯ID
    public $informationTitle	;    //资讯标题
    public $informationType;	    //资讯类型
    public $informationContent;	//资讯内容
    public $informationKeyWord;	//资讯关键字
    public $userID;	            //创建人id
    /*
     * @return array
     */
    public function rules()
    {
        return [
            [["informationID", 'informationTitle', 'informationType','informationContent','informationKeyWord'], "required"],
            [["informationID", 'informationTitle', 'informationType', 'informationContent', 'informationKeyWord',"userID"], "safe"],
        ];
    }

    /*
     * @return array
     */
    public function attributeLabels(){
        return [
            "informationID" => "informationID",
            "informationTitle" => "informationTitle",
            "informationType" => "informationType",
            "informationContent" => "informationContent",
            "informationKeyWord" => "informationKeyWord",
            "userID" => "userID",
        ];
    }
}


