<?php
namespace console\controllers;
use common\models\sanhai\SrMaterial;
use common\models\search\Material;
use yii\console\Controller;

/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2015/9/1
 * Time: 15:43
 */
class MaterialController extends Controller{
    /**
     *
     */
    public function actionAdd()
    {

        Material::getDb()->createCommand()->deleteIndex(Material::index());

        $config = [
            "settings" =>
                ["analysis" =>
                    ["analyzer" =>
                        ["stem" =>
                            ["tokenizer" => "standard",
                                "filter" => ["standard", "lowercase", "stop", "porter_stem"]
                            ]
                        ]
                    ]
                ],
//            "mappings" =>
//                [ "material" =>
//                    [ "dynamic" => true,
//                        "_timestamp"=>[ "enabled"=> "true","store"=>"yes"],
//                        "properties" =>
//                            [ "name" =>
//                                [ "type" => "string", "indexAnalyzer" => "ik", "searchAnalyzer"=>"ik" ]
//                                ,
//                                "tags" =>
//                                    [ "type" => "string", "indexAnalyzer" => "ik", "searchAnalyzer"=>"ik" ]
//                                ,
//                                "url" =>
//                                    [ "type" => "string", "indexAnalyzer" => "ik", "searchAnalyzer"=>"ik" ]
//                            ],
//
//                    ]
//                ]
        ];


        Material::getDb()->createCommand()->createIndex(Material::index(), $config);


        foreach (SrMaterial::find()->batch(10) as $customers) {
            $items=[];
            /** @var ShTestquestion $item */
            foreach ($customers as $item) {

                $materialModel = new  Material();
                $materialModel->id = $item->id;
                $materialModel->name=$item->name;
                $materialModel->provience = $item->provience;
                $materialModel->city = $item->city;
                $materialModel->country = $item->country;
                $materialModel->gradeid = (int)$item->gradeid;
                $materialModel->subjectid = (int)$item->subjectid;
                $materialModel->versionid = (int)$item->versionid;
                $materialModel->kid=(int)$item->kid;
                $materialModel->chapterId=(int)$item->chapterId;
                $materialModel->contentType=(int)$item->contentType;
                $materialModel->school=$item->school;
                $materialModel->tags=$item->tags;
                $materialModel->creator=$item->creator;
                $materialModel->createTime=(int)$item->createTime;
                $materialModel->updateTime=(int)$item->updateTime;
                $materialModel->matDescribe=$item->matDescribe;
                $materialModel->isDelete=$item->isDelete;
                $materialModel->url=$item->url;
                $materialModel->disabled=$item->disabled;
                $materialModel->readNum=$item->readNum;
                $materialModel->downNum=$item->downNum;
                $materialModel->chapKids=$item->chapKids;
                $materialModel->groupId=$item->groupId;
                $materialModel->access=$item->access;
                $materialModel->department=$item->department;
                $materialModel->isplatform=$item->isplatform;
                $items[]=$materialModel;

            }


            Material::InsertAll($items);

        }


    }
}