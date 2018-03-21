<?php
use tests\codeception\frontend\FunctionalTester;

/* @var $scenario Codeception\Scenario */

$I = new FunctionalTester($scenario);
$I->wantTo('ensure that home page works');
$I->amOnPage(Yii::$app->homeUrl);
$I->see('班海');
$I->seeLink('忘记密码?');
$I->click('忘记密码?');

$I->see('找回密码');


