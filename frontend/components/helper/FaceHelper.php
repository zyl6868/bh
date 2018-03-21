<?php

namespace frontend\components\helper;


/**
 * Created by PhpStorm.
 * User: ling
 * Date: 2014/12/9
 * Time: 15:01
 */
class FaceHelper
{

    public static $faceArr = [
        "拜拜" => "88_thumb.gif",
        "发怒" => "angrya_thumb.gif",
        "害羞" => "shamea_thumb.gif",
        "快哭了" => "bs_thumb.gif",
        "鄙视" => "bs2_thumb.gif",
        "闭嘴" => "bz_thumb.gif",
        "惊恐" => "cj_thumb.gif",
        "得意" => "cool_thumb.gif",
        "抓狂" => "crazya_thumb.gif",
        "衰" => "cry.gif",
        "馋" => "cza_thumb.gif",
        "晕" => "dizzya_thumb.gif",
        "鼓掌" => "gza_thumb.gif",
        "糗大了" => "h_thumb.gif",
        "尴尬" => "hatea_thumb.gif",
        "爱心" => "hearta_thumb.gif",
        "偷笑" => "heia_thumb.gif",
        "色" => "hsa_thumb.gif",
        "可怜" => "kl_thumb.gif",
        "抠鼻子" => "kbsa_thumb.gif",
        "憨笑" => "laugh.gif",
        "惊讶" => "ldln_thumb.gif",
        "飞吻" => "lovea_thumb.gif",
        "可爱" => "mb_thumb.gif",
        "咒骂" => "nm_thumb.gif",
        "ok" => "ok_thumb.gif",
        "亲亲" => "qq_thumb.gif",
        "大哭" => "sada_thumb.gif",
        "撇嘴" => "sb_thumb.gif",
        "冷汗" => "shamea_thumb.gif",
        "睡觉" => "sleepa_thumb.gif",
        "困" => "sleepya_thumb.gif",
        "微笑" => "smilea_thumb.gif",
        "疑问" => "yw_thumb.gif",
        "右哼哼" => "yhh_thumb.gif",
        "左哼哼" => "zhh_thumb.gif",
        "呕吐" => "t_thumb.gif",
        "阴险" => "yx_thumb.gif",
        "心碎" => "unheart.gif",
        "委屈" => "wq_thumb.gif",
        "嘘" => "x_thumb.gif",
        "调皮" => "zy_thumb.gif",

    ];


    /**
     * 替换表情
     * @param $context
     * @return mixed
     */
    public static function ReplaceFaceUrl($context)

    {
        foreach (self::$faceArr as $key => $val) {
            $context = str_replace("[$key]", '<img src="' . BH_CDN_RES.'/pub'. "/images/face/$val" . ' "/>', $context);
        }

        return $context;
    }

}