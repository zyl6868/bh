<?php
/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/2/16
 * Time: 17:01
 */
namespace schoolmanage\components\helper;
use common\helper\DateTimeHelper;
use common\models\pos\SeSchoolInfo;
use common\models\pos\SeSchoolUpGrade;
use common\models\sanhai\SeSchoolGrade;

class GradeHelper {
    /**
     * 根据当前时间和年级ID获取入学年份
     * @param integer $gradeID 年级ID
     * @param string $lengthOfSchooling 学制
     * @param integer $schoolId 学校id
     * @param integer $department 学段ID
     * @return bool|string
     */
    public  static function  getComingYearByGrade(int $gradeID, string $lengthOfSchooling, int $schoolId, int $department) {
        $comingYear = 0;
        $finalYear=self::getCurrentSchoolYear($schoolId,$department)-1;
        switch($gradeID){
            case 1001;
                $comingYear=$finalYear;
                break;
            case 1002:
                $comingYear=$finalYear-1;
                break;
            case 1003:
                $comingYear=$finalYear-2;
                break;
            case 1004:
                $comingYear=$finalYear-3;
                break;
            case 1005:
                $comingYear=$finalYear-4;
                break;
            case 1006:
                $comingYear=$finalYear-5;
                break;
            case    1007:
                $comingYear=$finalYear;
                break;
            case 1008:
                if($lengthOfSchooling=='20501'||$lengthOfSchooling=='20503'){
                    $comingYear=$finalYear;
                }else{
                    $comingYear=$finalYear-1;
                }
                break;
            case 1009:
                if($lengthOfSchooling=='20501'||$lengthOfSchooling=='20503'){
                    $comingYear=$finalYear-1;
                }else{
                    $comingYear=$finalYear-2;
                }
                break;
            case 1010:
                if($lengthOfSchooling=='20501'||$lengthOfSchooling=='20503'){
                    $comingYear=$finalYear-2;
                }else{
                    $comingYear=$finalYear-3;
                }
                break;
            case 1011:
                $comingYear=$finalYear;
                break;
            case 1012:
                $comingYear=$finalYear-1;
                break;
            case 1013:
                $comingYear=$finalYear-2;
        }
        return $comingYear;

    }

    /**
     * 获取最大年级所经历的学年
     * @param $gradeArray
     * @param $schoolID
     * @return array
     */
    public   static function getYearLists($gradeArray,$schoolID){
        $finalYear=self::getSchoolYear();
        $lengthOfSchooling=SeSchoolInfo::find()->where(['schoolID'=>$schoolID])->one()->lengthOfSchooling;
        $yearArray=[];
        if(in_array('1006',$gradeArray)){
            for($i=0;$i<6;$i++){
                $year=($finalYear-1-$i).'-'.($finalYear-$i);

                array_push($yearArray,$year);
            }
        }elseif(in_array('1005',$gradeArray)){
            for($i=0;$i<5;$i++){
                $year=($finalYear-1-$i).'-'.($finalYear-$i);

                array_push($yearArray,$year);
            }
        }elseif(in_array('1004',$gradeArray)||(in_array('1010',$gradeArray)&&$lengthOfSchooling=='20502')){
            for($i=0;$i<4;$i++){
                $year=($finalYear-1-$i).'-'.($finalYear-$i);

                array_push($yearArray,$year);
            }
        }elseif(in_array('1003',$gradeArray)||in_array('1013',$gradeArray)||(in_array('1010',$gradeArray)&&$lengthOfSchooling!='20502')||(in_array('1009',$gradeArray)&&$lengthOfSchooling=='20502')){
            for($i=0;$i<3;$i++){
                $year=($finalYear-1-$i).'-'.($finalYear-$i);

                array_push($yearArray,$year);
            }
        }elseif(in_array('1002',$gradeArray)||in_array('1012',$gradeArray)||(in_array('1008',$gradeArray)&&$lengthOfSchooling=='20502')||(in_array('1009',$gradeArray)&&$lengthOfSchooling!='20502')){
            for($i=0;$i<2;$i++){
                $year=($finalYear-1-$i).'-'.($finalYear-$i);

                array_push($yearArray,$year);
            }
        }else{
            $yearArray=[($finalYear-1).'-'.$finalYear];
        }
        return $yearArray;
    }
    /**
     * 获取最小年级所经历的学年
     * @param array $gradeArray 年级
     * @param integer $schoolID 学校id
     * @param string $department 学部
     * @return array
     */
    public static function getYearList(array $gradeArray, int $schoolID, string $department){
        $finalYear=self::getCurrentSchoolYear($schoolID,(int)$department);
        $lengthOfSchooling=SeSchoolInfo::find()->where(['schoolID'=>$schoolID])->one()->lengthOfSchooling;
        $yearArray=[];
        if(in_array('1001',$gradeArray)||in_array('1011',$gradeArray)||in_array('1007',$gradeArray)||(in_array('1008',$gradeArray)&&$lengthOfSchooling!='20502')){
            $yearArray=[($finalYear-1).'-'.$finalYear];
        }elseif(in_array('1002',$gradeArray)||in_array('1012',$gradeArray)||(in_array('1008',$gradeArray)&&$lengthOfSchooling=='20502')||(in_array('1009',$gradeArray)&&$lengthOfSchooling!='20502')){
            for($i=0;$i<2;$i++){
                $year=($finalYear-1-$i).'-'.($finalYear-$i);

                array_push($yearArray,$year);
            }
        }elseif(in_array('1003',$gradeArray)||in_array('1013',$gradeArray)||(in_array('1009',$gradeArray)&&$lengthOfSchooling=='20502')||(in_array('1010',$gradeArray)&&$lengthOfSchooling!='20502')){
            for($i=0;$i<3;$i++){
                $year=($finalYear-1-$i).'-'.($finalYear-$i);

                array_push($yearArray,$year);
            }
        }elseif(in_array('1004',$gradeArray)||(in_array('1010',$gradeArray)&&$lengthOfSchooling=='20502')){
            for($i=0;$i<4;$i++){
                $year=($finalYear-1-$i).'-'.($finalYear-$i);

                array_push($yearArray,$year);
            }
        }elseif(in_array('1005',$gradeArray)){
            for($i=0;$i<5;$i++){
                $year=($finalYear-1-$i).'-'.($finalYear-$i);

                array_push($yearArray,$year);
            }
        }elseif(in_array('1006',$gradeArray)){
            for($i=0;$i<6;$i++){
                $year=($finalYear-1-$i).'-'.($finalYear-$i);

                array_push($yearArray,$year);
            }
        }
        return $yearArray;
    }


    /**
     * 获取当前年级当时学年所在的年级
     * @param integer $gradeID 年级id
     * @param string $schoolYear 学年
     * @param integer $schoolId 学校id
     * @param integer $department 学段ID
     * @return string
     */
    public static function getYearOutGrade(int $gradeID, string $schoolYear, int $schoolId, int $department){
        $outYearArray=explode('-',$schoolYear);
        $outYear=(int)$outYearArray[1];
        $finalYear=self::getCurrentSchoolYear($schoolId,$department);
        $diffValue=$finalYear-$outYear;
        $outGradeID=$gradeID-$diffValue;
        $gradeName=SeSchoolGrade::find()->where(['gradeId'=>$outGradeID])->one()->gradeName;
        return $gradeName;
    }

    /**
     * 根据学部和学制获取年级列表
     * 当$type 为空时 为默认排序  $type不为空时 按gradeId 倒叙排序
     * @param string $department 学部
     * @param string $lengthOfSchooling 学制id
     * @param int $type
     * @return array|\common\models\sanhai\SeSchoolGrade[]
     */
    public static function getGradeByDepartmentAndLengthOfSchooling(string $department, string $lengthOfSchooling, int $type=null){
        $departmentArray = explode(',', $department);

        $gradeData = [];

        if($type==null) {
            //        六三学制
            if ($lengthOfSchooling == '20501') {
                $gradeData = SeSchoolGrade::find()->where(['schoolDepartment' => $departmentArray])->andWhere(['sixThree' => 1])->all();
//        五四学制
            } elseif ($lengthOfSchooling == '20502') {
                $gradeData = SeSchoolGrade::find()->where(['schoolDepartment' => $departmentArray])->andWhere(['fiveFour' => 1])->all();
//        五三学制
            } elseif ($lengthOfSchooling == '20503') {
                $gradeData = SeSchoolGrade::find()->where(['schoolDepartment' => $departmentArray])->andWhere(['fiveThree' => 1])->all();
            }
        }else{
            //        六三学制
            if ($lengthOfSchooling == '20501') {
                $gradeData = SeSchoolGrade::find()->where(['schoolDepartment' => $departmentArray])->andWhere(['sixThree' => 1])->orderBy("gradeId desc")->all();
//        五四学制
            } elseif ($lengthOfSchooling == '20502') {
                $gradeData = SeSchoolGrade::find()->where(['schoolDepartment' => $departmentArray])->andWhere(['fiveFour' => 1])->orderBy("gradeId desc")->all();
//        五三学制
            } elseif ($lengthOfSchooling == '20503') {
                $gradeData = SeSchoolGrade::find()->where(['schoolDepartment' => $departmentArray])->andWhere(['fiveThree' => 1])->orderBy("gradeId desc")->all();
            }
        }
        return $gradeData;
    }

    /**
     * 根据当前时间获取当前学年
     * @return bool|string
     */
    public static function getSchoolYear($createTime=null){
        if($createTime ==null){
            $nowYear=Date('Y',time());
        }else{
            $nowYear=Date('Y',$createTime);
        }

        $overTime=$nowYear.'-09-01';
        $overStrtotime=strtotime($overTime);
        if(time()>$overStrtotime){
            $finalYear=$nowYear+1;
        }else{
            $finalYear=$nowYear;
        }

        return $finalYear;
    }

    /**
     * 根据是否升级判断确定当前学年
     * @param integer $schoolId 学校id
     * @param integer $department 学段id
     * @return bool|string
     */
    public static function getCurrentSchoolYear(int $schoolId, int $department){
        $nowYear = Date('Y',time());

        $UpGradeResult = SeSchoolUpGrade::find()->where(['schoolID'=>$schoolId,'department'=>$department])->one();

        $finalYear = $nowYear;

        if($UpGradeResult){

            $UpGradeYear = Date('Y',DateTimeHelper::timestampDiv1000($UpGradeResult->upgradeTime));

            if($UpGradeYear ==$nowYear){

                $finalYear = $nowYear +1;
            }

        }

        return $finalYear;
    }


}