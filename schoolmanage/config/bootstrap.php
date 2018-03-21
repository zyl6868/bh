<?php

if (YII_ENV_DEV) {
    define('RESOURCES_BASE_VER', time());
} else {
    define('RESOURCES_BASE_VER', '20161028');
}

define('RESOURCES_VER', '?v='.RESOURCES_BASE_VER);
