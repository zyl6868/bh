<?php
use tests\codeception\frontend\AcceptanceTester;

/* @var $scenario Codeception\Scenario */

$I = new AcceptanceTester($scenario);
$I->wantTo('perform actions and see result');
//$I->amOnUrl("http://localhost/");
$I->amOnUrl("http://localhost:89");
//$I->amOnPage('/');
//$I->see('班海');
//$I->seeLink('忘记登录密码?');
//$I->click(['link' => '忘记登录密码?']);
//$I->wait(1);
//$I->see('找回密码');
//$I->amOnPage('http://localhost:89/');
$I->pressKey('#loginform-username', '18511111111');
$I->pressKey('#loginform-passwd', '123456');
$I->seeLink('登录');
$I->click('登录');

$I->wait(1);
$I->see('田老师');
$I->click(['link' => '田老师']);
$I->wait(1);
$I->see('课件');
$I->wait(1);
$I->click(['link' => '课件']);
$I->wait(1);

/*
 * 创建组
 */
$I->see('新建组');
$I->click(['link' => '新建组']);
$I->see('限制15个字，多于15个字不允许输入');
$I->wait(1);
$I->pressKey('#add-group-name', '单元测试分组111');
$I->wait(2);
$I->see('确定');
$I->seeNumberOfElements('#sureAddCroup', 1);
$I->click("#sureAddCroup");
$I->waitForElementNotVisible('.successBox');    //等待‘成功提示’元素直到它不可见为止
$I->wait(5);

/*
 * 修改组
 */
$I->see('单元测试分组111');
$I->wait(1);
$I->click('单元测试分组111');
$I->wait(1);
$I->see('修改组名');
$I->wait(1);
$I->click('修改组名');
//$I->see( '单元测试分组111');
//$I->assertInternalType('string', '单元测试分组111');
//$I->see('限制15个字，多于15个字不允许输入');
$I->wait(1);
$I->fillField('#modify > div.popCont > div.input > input', '单元测试分组222');
$I->wait(3);
$I->see('确定');
$I->seeNumberOfElements('#updateGroupName', 1);
$I->click("#updateGroupName");
$I->waitForElementNotVisible('.successBox');
$I->wait(1);
$I->see('单元测试分组222');

/*
 * 移动课件
 */
$I->click('我的收藏');
$I->wait(2);
$I->click("input.allCheck");
$I->wait(3);
$I->click("a.move > b");
$I->wait(2);
$I->click("(//a[contains(text(),'单元测试分组222')])[2]");
$I->wait(1);
$I->waitForElementNotVisible('.successBox');
$I->wait(5);

/**
 * 删除课件
 */
$I->click('单元测试分组222');
$I->wait(1);
$I->click("input.oneCheck");
$I->wait(3);
$I->click("a.remove > i");
$I->see('确认删除所选课件吗？');
$I->wait(2);
$I->click("#delCourse > div.popBtnArea > div.btn_work > button.okBtn");
$I->wait(3);
$I->waitForElementNotVisible('.successBox');
$I->wait(5);

/**
 * 删除组
 */
$I->click("删除该组");
$I->see('确认删除该组吗？删除后该组下的课件也将删除!');
$I->wait(3);
$I->click("#deleteGroup");
$I->waitForElementNotVisible('.successBox');
$I->wait(6);