<?php
namespace frontend\models;

use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2014/11/15
 * Time: 11:00
 */
class PublishInformationForm extends Model
{
    public $informationTitle;       //资讯标题
    public $informationType;        //资讯类型
    public $informationContent;     //咨询内容
    public $informationKeyWord;     //资讯关键字
    public $userID;                  //创建人Id

    public function rules()
    {
        return [
            [
                ["informationTitle", "informationType", "informationContent", "informationKeyWord", "userID"], "required"
            ],
            [
                ["informationTitle", "informationType", "informationContent", "informationKeyWord", "userID"], "safe"
            ],
            [
                ["informationTitle", "informationType", "informationContent", "informationKeyWord", "userID"], "safe", "on" => "search"
            ],
        ];
    }

    public function attributeLabels()
    {
        return array(
            'informationTitle' => 'informationTitle',
            'informationType' => 'informationType',
            'informationContent' => 'informationContent',
            'informationKeyWord' => 'informationKeyWord',
            'userID' => 'userID'
        );
    }


}



