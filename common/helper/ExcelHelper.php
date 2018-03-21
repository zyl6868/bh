<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 15-6-25
 * Time: 下午12:15
 */

namespace common\helper;


use common\models\pos\SeExamPersonalScore;
use common\models\pos\SeExamScoreInput;
use PHPExcel_IOFactory;

class ExcelHelper
{

    /*
 |--------------------------------------------------------------------------
 | Excel To Array
 |--------------------------------------------------------------------------
 | Helper function to convert excel sheet to key value array
 | Input: path to excel file, set wether excel first row are headers
 | Dependencies: PHPExcel.php include needed
 */
    public static function excelToArray($filePath, $header=true){
        //Create excel reader after determining the file type
        $inputFileName = $filePath;
        /**  Identify the type of $inputFileName  **/
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        /**  Create a new Reader of the type that has been identified  **/
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        /** Set read type to read cell data onl **/
        $objReader->setReadDataOnly(true);
        /**  Load $inputFileName to a PHPExcel Object  **/
        $objPHPExcel = $objReader->load($inputFileName);
        //Get worksheet and built array with first row as header
        $objWorksheet = $objPHPExcel->getActiveSheet();
        //excel with first row header, use header as key
        if($header){
            $highestRow = $objWorksheet->getHighestRow();
            $highestColumn = $objWorksheet->getHighestColumn();
            $headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
            $headingsArray = $headingsArray[1];
            $r = -1;
            $namedDataArray = array();
            for ($row = 2; $row <= $highestRow; ++$row) {
                $dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
                if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
                    ++$r;
                    foreach($headingsArray as $columnKey => $columnHeading) {
                        $namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
                    }
                }
            }
        }
        else{
            //excel sheet with no header
            $namedDataArray = $objWorksheet->toArray(null,true,true,true);
        }
        return $namedDataArray;
    }


    /**
     * 根据科目id获取对应的分数值
     * @param int $key 科目
     * @param SeExamPersonalScore $model 学生考试各个科目成绩,横表存储所有科目成绩
     * @return mixed
     */
    public static  function getSubjectScore(int $key , SeExamPersonalScore $model){
        $score = 0;
        switch ($key) {
            case 10010:
                $score = $model->sub10010;
                break;
            case 10011:
                $score = $model->sub10011;
                break;
            case 10012:
                $score = $model->sub10012;
                break;
            case 10013:
                $score = $model->sub10013;
                break;
            case 10014:
                $score = $model->sub10014;
                break;
            case 10015:
                $score = $model->sub10015;
                break;
            case 10016:
                $score = $model->sub10016;
                break;
            case 10017:
                $score = $model->sub10017;
                break;
            case 10018:
                $score = $model->sub10018;
                break;
            case 10019:
                $score = $model->sub10019;
                break;
            case 10020:
                $score = $model->sub10020;
                break;
            case 10021:
                $score = $model->sub10021;
                break;
            case 10022:
                $score = $model->sub10022;
                break;
            case 10023:
                $score = $model->sub10023;
                break;
            case 10024:
                $score = $model->sub10024;
                break;
            case 10025:
                $score = $model->sub10025;
                break;
            case 10026:
                $score = $model->sub10026;
                break;
            case 10027:
                $score = $model->sub10027;
                break;
            case 10028:
                $score = $model->sub10028;
                break;
            case 10029:
                $score = $model->sub10029;
                break;
            case 10030:
                $score = $model->sub10030;
                break;
            case 10031:
                $score = $model->sub10031;
                break;
            case 10032:
                $score = $model->sub10032;
                break;
            case 10033:
                $score = $model->sub10033;
                break;
            case 10034:
                $score = $model->sub10034;
                break;
            case 10035:
                $score = $model->sub10035;
                break;
            case 10036:
                $score = $model->sub10036;
                break;
            case 10037:
                $score = $model->sub10037;
                break;
            case 10038:
                $score = $model->sub10038;
                break;
            case 10039:
                $score = $model->sub10039;
                break;
            case 10040:
                $score = $model->sub10040;
                break;
            case 10041:
                $score = $model->sub10041;
                break;
            case 10042:
                $score = $model->sub10042;
                break;
            case 10043:
                $score = $model->sub10043;
                break;
            case 10044:
                $score = $model->sub10044;
                break;
            case 10045:
                $score = $model->sub10045;
                break;
            case 10046:
                $score = $model->sub10046;
                break;
            case 10047:
                $score = $model->sub10047;
                break;
            case 10048:
                $score = $model->sub10048;
                break;
        }
        return $score;
    }


    /**
     * 考务管理-》给科目设置分数
     * @param  SeExamPersonalScore | SeExamScoreInput $model 考试成绩导入临时表
     * @param integer $key 科目ID
     * @param string $val 分数
     */
    public static  function setSubjectScore($model, int $key, string $val){
        if(empty($val)){
            $val = 0;
        }
        switch ($key){
            case 10010:
                 $model->sub10010 = $val;
                break;
            case 10011:
                 $model->sub10011 = $val;
                break;
            case 10012:
                 $model->sub10012 = $val;
                break;
            case 10013:
                 $model->sub10013 = $val;
                break;
            case 10014:
                 $model->sub10014 = $val;
                break;
            case 10015:
                 $model->sub10015 = $val;
                break;
            case 10016:
                 $model->sub10016 = $val;
                break;
            case 10017:
                 $model->sub10017 = $val;
                break;
            case 10018:
                 $model->sub10018 = $val;
                break;
            case 10019:
                 $model->sub10019 = $val;
                break;
            case 10020:
                 $model->sub10020 = $val;
                break;
            case 10021:
                 $model->sub10021 = $val;
                break;
            case 10022:
                 $model->sub10022 = $val;
                break;
            case 10023:
                 $model->sub10023 = $val;
                break;
            case 10024:
                 $model->sub10024 = $val;
                break;
            case 10025:
                 $model->sub10025 = $val;
                break;
            case 10026:
                 $model->sub10026 = $val;
                break;
            case 10027:
                $model->sub10027 = $val;
                break;
            case 10028:
                $model->sub10028 = $val;
                break;
            case 10029:
                 $model->sub10029 = $val;
                break;
            case 10030:
                 $model->sub10030 = $val;
                break;
            case 10031:
                 $model->sub10031 = $val;
                break;
            case 10032:
                 $model->sub10032 = $val;
                break;
            case 10033:
                 $model->sub10033 = $val;
                break;
            case 10034:
                 $model->sub10034 = $val;
                break;
            case 10035:
                 $model->sub10035 = $val;
                break;
            case 10036:
                 $model->sub10036 = $val;
                break;
            case 10037:
                 $model->sub10037 = $val;
                break;
            case 10038:
                 $model->sub10038 = $val;
                break;
            case 10039:
                 $model->sub10039 = $val;
                break;
            case 10040:
                 $model->sub10040 = $val;
                break;
            case 10041:
                 $model->sub10041 = $val;
                break;
            case 10042:
                 $model->sub10042 = $val;
                break;
            case 10043:
                 $model->sub10043 = $val;
                break;
            case 10044:
                 $model->sub10044 = $val;
                break;
            case 10045:
                 $model->sub10045 = $val;
                break;
            case 10046:
                 $model->sub10046 = $val;
                break;
            case 10047:
                 $model->sub10047 = $val;
                break;
            case 10048:
                 $model->sub10048 = $val;
                break;

        }
    }

}