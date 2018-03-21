<?php


if (YII_ENV_DEV) {
    define('RESOURCES_BASE_VER', time());
} else {
    define('RESOURCES_BASE_VER', '2018030413');
}

define('RESOURCES_VER', '?v=' . RESOURCES_BASE_VER);


Yii::setAlias('@mobile_static', '/mobile_static');


