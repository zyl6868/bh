<?php
namespace frontend\models;

use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2015/4/20
 * Time: 16:08
 */
class AnswerQuestionsForm extends Model
{
    public $content;     //问题补充

    /*
     * @return array
     */
    public function rules()
    {
        return [
            [["content"], "safe",]

        ];
    }


    /*
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            "content" => "content",
        );
    }
}
