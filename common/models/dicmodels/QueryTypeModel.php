<?php
namespace common\models\dicmodels;
use common\models\pos\SePaperQuesTypeRlts;

/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-11-27
 * Time: 下午2:12
 */
class QueryTypeModel
{

    public static function queryQuesType($schoolLevel, $subject)
    {
        if(empty($schoolLevel) || empty ($subject)){
            return [];
        }
        $list=SePaperQuesTypeRlts::find()->where(['schoolLevelId'=>$schoolLevel,'subjectId'=>$subject])->select('paperQuesTypeId,paperQuesType')->all();
        return $list;
    }

}