<?php
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('schoolmanage', dirname(dirname(__DIR__)) . '/schoolmanage');
Yii::setAlias('mobileWeb', dirname(dirname(__DIR__)) . '/mobileWeb');
require(__DIR__.'/../config/globals.php');