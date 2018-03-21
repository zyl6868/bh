<?php
/**
 * Created by PhpStorm.
 * User: ysd
 * Date: 2014/11/2
 * Time: 11:00
 */
namespace frontend\modules\teacher\models;
use yii\base\Model;

class teaQuestionPackForm extends Model
{
	public $title;      //标题
	public $detail;     //问题补充
	/*
	 * @return array
	 */
	public function rules()
	{

		return [
			[["title"], "required"],
            [["title"], "safe"],
            [["detail"],"safe"],

		];
	}

	/*
	 * @return array
	 */
	public function attributeLabels(){
		return [
			"title" => "title",
			"detail" => "detail",
		];
	}
}


