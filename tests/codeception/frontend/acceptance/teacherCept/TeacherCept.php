<?php
use tests\codeception\frontend\AcceptanceTester;

/* @var $scenario Codeception\Scenario */

$I = new AcceptanceTester($scenario);
$I->wantTo('perform actions and see result');
//$I->amOnUrl("http://localhost/");
$I->amOnUrl("http://localhost:8080/");
//$I->amOnPage('/');
$I->see('班海');
//$I->seeLink('忘记登录密码?');
//$I->click(['link' => '忘记登录密码?']);
//$I->wait(1);
//$I->see('找回密码');
//$I->amOnPage('/');
$I->pressKey('#loginform-username', '18511111111');
$I->pressKey('#loginform-passwd', '123456');
$I->seeLink('登录');
$I->click('登录');

$I->wait(1);
$I->see('田老师');
$I->click(['link'=>'田老师']);
$I->wait(1);
$I->see('发通知');
$I->click(['link'=>'发通知']);
$I->wait(2);
$I->see('发布通知');
$I->wait(1);
$I->pressKey('#text_gray','测试通知');
$I->selectOption('HomeContactForm[classId]','高一  一班');
$I->selectOption('HomeContactForm[scope]','全部学生');
$I->click("label.chkLabel");
$I->pressKey('#content','测试通知测试通知测试通知');
$I->see('立即发送');
$I->click("div.popBtnArea > button.okBtn");
$I->wait(2);
$I->see('个人中心');
$I->click(['link'=>'个人中心']);
$I->wait(5);

//$I->click("#ch1");
