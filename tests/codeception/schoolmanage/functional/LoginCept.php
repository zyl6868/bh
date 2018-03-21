<?php
use tests\codeception\frontend\FunctionalTester;
use tests\codeception\common\_pages\LoginPage;

/* @var $scenario Codeception\Scenario */

$I = new FunctionalTester($scenario);
$I->wantTo('ensure login page works');

$loginPage = LoginPage::openBy($I);

$I->amGoingTo('try to login with correct credentials');
$loginPage->login('13810846220', 'dragon2');
$I->expectTo('see that user is logged');
$I->seeLink('退出登录','index-test.php?r=site%2Flogout');

