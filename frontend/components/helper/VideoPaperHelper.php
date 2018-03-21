<?php
namespace frontend\components\helper;

use common\models\sanhai\ShTestquestion;

/**
 * Created by PhpStorm.
 * User: mahongru
 * Date: 2015/8/26
 * Time: 18:55
 */
class VideoPaperHelper
{

    /**
     * 查询试卷题目数
     * @param $paperId
     * @return array|\common\models\pos\SeSameQuestion[]
     */
    public static function questionNum($paperId)
    {
        $questionNum = ShTestquestion::find()->where(['paperId' => $paperId])->count();
        return $questionNum;
    }

}