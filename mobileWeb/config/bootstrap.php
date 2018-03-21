<?php


if (YII_ENV_DEV) {
    define('RESOURCES_BASE_VER', time());
} else {
    define('RESOURCES_BASE_VER', '1513664606');
}

define('RESOURCES_VER', '?v=' . RESOURCES_BASE_VER);


Yii::setAlias('@mobile_static', '/mobile_static');


