<?php
use tests\codeception\frontend\AcceptanceTester;

/* @var $scenario Codeception\Scenario */

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that home page works');
$I->amOnPage(Yii::$app->homeUrl);
$I->see('班海');
$I->seeLink('忘记密码?');
$I->click(['link' => '忘记密码?']);
$I->see('找回密码');

