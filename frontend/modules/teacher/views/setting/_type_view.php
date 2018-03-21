<?php
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 15-4-28
 * Time: 上午10:32
 */
?>
<?php if ($type == 1) {
    if ($item->favoriteType == 1) {
        echo "教案";
    } elseif ($item->favoriteType == 7) {
        echo "教学计划";
    } elseif ($item->favoriteType == 8) {
        echo "课件";
    } elseif ($item->favoriteType == 6) {
        echo "素材";
    } elseif ($item->favoriteType == 99) {
        echo "其他";
    }

} else {
    if ($item->matType == 1) {
        echo "教案";
    } elseif ($item->matType == 7) {
        echo "教学计划";
    } elseif ($item->matType == 8) {
        echo "课件";
    } elseif ($item->matType == 6) {
        echo "素材";
    } elseif ($item->matType == 99) {
        echo "其他";
    }

}?>

