<?php
/**
 * Created by PhpStorm.
 * User: yangjie
 * Date: 15/8/21
 * Time: 下午3:03
 */

namespace common\elasticsearch;


use yii\elasticsearch\Exception;
use yii\helpers\Json;

class es_ActiveRecord extends  \yii\elasticsearch\ActiveRecord
{


    public static function flush(){
        $url = [static::index(), '_flush'];
        $response = static::getDb()->post($url);
    }


    public static function InsertAll($counters)
    {

        $bulk = '';
        /** @var  \yii\elasticsearch\ActiveRecord[] $counters */
        foreach ($counters as $pk) {
            $action = Json::encode([
                "create" => [
                    "_id" => $pk->getPrimaryKey(),
                    "_type" => static::type(),
                    "_index" => static::index(),
                ],
            ]);

            $data = Json::encode($pk->getDirtyAttributes());
            $bulk .= $action . "\n" . $data . "\n";
        }


        // TODO do this via command
        $url = [static::index(), static::type(), '_bulk'];
        $response = static::getDb()->post($url, [], $bulk);
        $n = 0;
        $errors = [];
        foreach ($response['items'] as $item) {
            if (isset($item['create']['status']) && $item['create']['status'] == 201) {
                $n++;
            } else {
                $errors[] = $item['create'];
            }
        }
        if (!empty($errors) || isset($response['errors']) && $response['errors']) {
            throw new Exception(__METHOD__ . ' failed create  records counters.', $errors);
        }

        return $n;
    }



}