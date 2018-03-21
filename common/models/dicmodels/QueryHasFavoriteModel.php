<?php
namespace common\models\dicmodels;

use common\models\pos\SeFavoriteFolder;

/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-12-10
 * Time: 下午4:18
 */
class QueryHasFavoriteModel
{

    /**
     * 其他用户查看教师的资料是否收藏
     * @param $favoriteId       收藏内容id（不为空）
     * @param $favoriteType     收藏类型(收藏类型(1教案，2讲义，3视频,4 资料，5 ppt，6 素材))
     * @param $userID           收藏人
     * @return ServiceJsonResult
     */
    public static function queryHasFavorite($favoriteId, $favoriteType, $userID)
    {
        if (empty($favoriteId) || empty($favoriteType) || empty($userID)) {
            return [];
        }
        $FavoriteFolder = SeFavoriteFolder::find()->where(['favoriteId' => $favoriteId, 'favoriteType' => $favoriteType, 'creatorID' => $userID, 'isDelete' => 0])->limit(1)->one();
        if ($FavoriteFolder) {
            $array = ['collectID' => $FavoriteFolder->collectID, 'isCollected' => 1];
        } else {
            $array = ['collectID' => $FavoriteFolder->collectID, 'isCollected' => 0];
        }
        return $array;
    }
}