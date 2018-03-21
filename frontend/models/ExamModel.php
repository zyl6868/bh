<?php
namespace frontend\models;
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-10-24
 * Time: 下午5:48
 */
class ExamModel
{
    private $data = array();


    function __construct($classId, $teacherId)
    {

        $this->data = $this->getDate($classId, $teacherId);
    }

    public function getDate($classId, $teacherId)
    {

        $exams = new pos_ExamService();
        $examList = $exams->queryExamList($classId, $teacherId, null, null, null);
        if ($examList->resCode == "000000") {

            return $examList->data->examList;


        }
    }

    public static function model($classId = null, $teacherId = null)
    {
        $staticModel = new self($classId, $teacherId);
        return $staticModel;
    }

    public function   getList($id)
    {
        return from($this->data)->where(function ($v) use ($id) {
            return $v["examID"] == $id;
        })->toArray();

    }

}