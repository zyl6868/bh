<?php

namespace frontend\components\helper;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 15-4-16
 * Time: 下午8:14
 */
class TreeHelper
{

    public function treefun(&$knowledgePoint, $id, $htmlOptions,$default)
    {
        $str = '';
        $list = from($knowledgePoint)->where(function ($v) use ($id) {
            return $v->pId == $id;
        })->toList();
        if (count($list) > 0) {
            $str .= ' <ul class="subMenu">';
            foreach ($list as $ls) {
                $str .= '<li><i></i>';
                $htmlOptions['data-value'] = $ls->id;
	            $htmlOptions['title'] = $ls->name;
                if($default==$ls->id){
                    $htmlOptions['class']='ac';
                }else{
                    $htmlOptions['class']='';
                }
                $str .= Html::beginTag('a', $htmlOptions) . $ls->name . Html::endTag('a');
                $str .= $this->treefun($knowledgePoint, $ls->id, $htmlOptions,$default);
                $str .= '</li>';
            }
            $str .= '</ul>';
        }

        return $str;
    }

    public function treePid(&$knowledgePoint, $id, $htmlOptions,$class=null,$default=null)
    {
        $str = '';
        $list = from($knowledgePoint)->where(function ($v) use ($id) {
            return $v->pId == $id;
        })->toList();
        if (count($list) > 0) {
            $str .= ' <ul class="' . (empty($class) ?'':$class) . '">';
            foreach ($list as $ls) {
                $str .= '<li><i></i>';
                $htmlOptions['data-value'] = $ls->id;
	            $htmlOptions['title'] = $ls->name;

                if($default==$ls->id){
                   $htmlOptions['class']='ac';
                }else{
                    $htmlOptions['class']='';
                }
                $str .= Html::beginTag('a', $htmlOptions) . $ls->name . Html::endTag('a');
                $str .= $this->treefun($knowledgePoint, $ls->id, $htmlOptions,$default);

                $str .= '</li>';
            }
            $str .= '</ul>';
        }

        return $str;
    }


    public static function  streefun(&$knowledgePoint, $htmlOptions = [],$class=null,$default=null)
    {
        $tree = new TreeHelper();
        $htmlOptions['href'] = 'javascript:;';
        return $tree->treePid($knowledgePoint, 0, $htmlOptions,$class,$default);


    }


}