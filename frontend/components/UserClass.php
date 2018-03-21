<?php

namespace frontend\components;
/**
 * Created by PhpStorm.
 * User: unizk
 * Date: 14-7-7
 * Time: 下午6:21
 */
class UserClass
{
    /**
     *  班级
     * @var
     */
    public $classID;
    /**
     * 班级名称
     * @var
     */
    public $className;
    /**
     * 班内身份
     * @var
     */
    public $identity;
    /**
     * 教授科目
     * @var
     */
    public $subjectNumber;
    /**
     * 入学年份
     * @var
     */
    public $joinYear;
    /**
     * 第几班
     * @var
     */
    public $classNumber;

    /**
     * 是班主任
     */
    public function isMaster()
    {
        return $this->identity == '10056';
    }

}


