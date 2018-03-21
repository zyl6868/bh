<?php

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 14-10-17
 * Time: 下午2:17
 */
namespace frontend\modules\teacher\models;
class MakePaperModel
{

    public static function     toZtreeData($jsonModel)
    {
        $pageMain=   new stdClass();
        $pageMain->paperHead[]=['id'=>'line','name'=>'装订线','checked'=>true];
        $pageMain->paperHead[]=['id'=>'line','name'=>'装订线','checked'=>true];
        $pageMain->paperHead[]=['id'=>'line','name'=>'装订线','checked'=>true];
        $pageMain->paperHead[]=['id'=>'line','name'=>'装订线','checked'=>true];
        $pageMain->paperHead[]=['id'=>'line','name'=>'装订线','checked'=>true];
        $pageMain->paperBody;



//        paperHead: [
//        {id: 'line', name: "装订线", checked: true},
//        {id: 2, name: "绝密★启用前", text: "绝密★启用前", checked: true},
//        {id: 'main_title', name: "主标题", text: "2013-2014学年度xx学校xx月考卷", checked: true},
//        {id: 4, name: "副标题", text: "内部模拟考试", checked: true},
//        {id: 5, name: "范围/时间", text: "考试范围：xxx；考试时间：100分钟；命题人：xxx", checked: true},
//        //id:6 name:"学校/姓名
//        //id:7 name:"记分表"
//        {id: 'pay_attention', name: "注意事项", text: "注意事项注意事项注意事项", checked: true}
//    ],
//    paperBody: [
//        {id: 10, pId: 0, name: "第一卷(选择题)", text: "注释内容", open: true, checked: true},
//        {id: 11, pId: 0, name: "第二卷(非选择题)", text: "第二卷(非选择题)", open: true, checked: true},
//
//        //以下为子项目,id编号从200开始
//        {id: 200, pId: 11, name: "单选题", text: "注释内容", checked: true},
//        {id: 201, pId: 11, name: "判断题", text: "注释内容", checked: true},
//        {id: 202, pId: 10, dataId:10, name: "填空题", text: "注释内容", checked: true},
//        {id: 203, pId: 11, name: "解答题", text: "注释内容", checked: true},
//        {id: 204, pId: 10, name: "计算题", text: "注释内容", checked: true}
//    ]


    }

    public static function   toModelDataJson($json)
    {


    }


}
