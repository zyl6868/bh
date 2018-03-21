<?php
use tests\codeception\frontend\AcceptanceTester;

/* @var $scenario Codeception\Scenario */

$I = new AcceptanceTester($scenario);
$I->wantTo('perform actions and see result');
$I->amOnUrl("http://localhost/");
$I->amOnPage('/');
$I->see('班海');
$I->seeLink('忘记登录密码?');
$I->click(['link' => '忘记登录密码?']);
$I->see('找回密码');
$I->amOnPage('/');
$I->pressKey('#loginform-username', '18511111111');
$I->pressKey('#loginform-passwd', '123456');
$I->seeLink('登录');
$I->click('登录');
$I->wait(1);
$I->see('田老师');
$I->click(['link' => '田老师']);
$I->wait(1);
$I->see('题目');
$I->click(['link' => '题目']);
$I->wait(1);
$I->see('新建组');
$I->click(['link' => '新建组']);
$I->pressKey('#groupName', '单元测试分组');
$I->see('确定');
$I->click('#addGroup', '确定');

$I->wait(5);

