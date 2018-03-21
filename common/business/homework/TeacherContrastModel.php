<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/3/12
 * Time: 13:30
 */
namespace common\business\homework;
use common\models\pos\SeExamClassSubject;
use common\models\pos\SeExamReportBaseInfo;
use common\models\pos\SeExamSubject;
use common\components\WebDataCache;

class TeacherContrastModel{


    /**
     * 老师下面的班级
     * @param int $subjectId 科目ID
     * @param int $schoolExamId 学校考试ID
     * @return array
     */
    public function teacherData (int $subjectId, int $schoolExamId) {

        $examSubId=SeExamSubject::find()->where(['subjectId'=>$subjectId,'schoolExamId'=>$schoolExamId])->limit(1)->one()->examSubId;
        $teacherResult=SeExamClassSubject::find()->where(['examSubId'=>$examSubId,'schoolExamId'=>$schoolExamId])->groupBy(['teacherId'])->all();
        $allDataArray=[];
        foreach($teacherResult as $v){
            $teacherData=SeExamClassSubject::find()->where(['teacherId'=>$v->teacherId,'examSubId'=>$examSubId])->all();
            if($v->teacherId!=0) {
                $classArray = [];
                foreach ($teacherData as $value) {
                    $examClassResult = $value->classExam;
                    $classId = $examClassResult->classId;
                    array_push($classArray, $classId);
                }
                $classData = implode(',', $classArray);
                $dataArray = ['teacherId' => $v->teacherId, 'classData' => $classData];
                array_push($allDataArray, $dataArray);
            }else{
                foreach($teacherData as $value){
                    $examClassResult = $value->classExam;
                    $classId = $examClassResult->classId;
                    array_push($allDataArray,['teacherId'=>0,'classData'=>$classId]);
                }
            }
        }

        return $allDataArray;
    }


    /**
     * 低分率
     * @param array $list 老师对应的班级
     * @return array
     */
    public function lowList(array $list){
        $array=[];
        foreach($list as $val){
            //班级人数
            $lowNum=(float)($val['data']['realNumber'])+(float)($val['data']['missNumber']);

            if($lowNum==0 || (float)($val['data']['lowScoreNum'])==0){
                $lowContrast=0;
            }else{
                $lowContrast=((float)($val['data']['lowScoreNum'])/$lowNum)*100;
            }
            $array[]=['teacherId'=>$val['teacherId'],'lowContrast'=>$lowContrast];
        }

        $lowNumber=[];
        $name=[];
        foreach($array as $val){
            $lowNumber[]=round($val['lowContrast'],2);
            $name[]=$val['teacherId']==0?'':WebDataCache::getUserNameByUserId($val['teacherId']);
        }
        $lowNumList=['max'=>100,'min'=>0,'lowNumber'=>$lowNumber,'name'=>$name];
        return $lowNumList;
    }


    /**
     * 及格率
     * @param array $list 及格率数据列表
     * @return array
     */
    public function noPassList(array $list){
        $array=[];
        foreach($list as $val){
            //班级人数
            $passNum=(float)($val['data']['realNumber'])+(float)($val['data']['missNumber']);
            if($passNum==0){
                $passContrast=0;
            }else{
                if((float)($val['data']['noPassNum'])==0){
                    $passContrast=100;
                }else{
                    $passContrast=(1-((float)($val['data']['noPassNum'])/$passNum))*100;
                }
            }
            $array[]=['teacherId'=>$val['teacherId'],'passContrast'=>$passContrast];
        }
        $passNumber=[];
        $name=[];
        foreach($array as $val){
            $passNumber[]=round($val['passContrast'],2);
            $name[]=$val['teacherId']==0?'':WebDataCache::getUserNameByUserId($val['teacherId']);
        }
        $goodNumList=['max'=>100,'min'=>0,'passNumber'=>$passNumber,'name'=>$name];
        return $goodNumList;
    }


    /**
     * 优良率
     * @param array $list 优良率数据列表
     * @return array
     */
    public function goodNumList(array $list){
        $array=[];
        foreach($list as $val){
            //班级人数
            $gooNum=(float)($val['data']['realNumber'])+(float)($val['data']['missNumber']);

            if($gooNum==0 || (float)($val['data']['goodNum'])==0){
                $goodContrast=0;
            }else{
                $goodContrast=((float)($val['data']['goodNum'])/$gooNum)*100;
            }
            $array[]=['teacherId'=>$val['teacherId'],'goodContrast'=>$goodContrast];
        }
        $goodNumber=[];
        $teacherName=[];
        foreach($array as $val){
            $goodNumber[]=round($val['goodContrast'],2);
            $teacherName[]=$val['teacherId']==0?'':WebDataCache::getTrueNameByuserId($val['teacherId']);
        }
        $goodNumList=['max'=>100,'min'=>0,'goodNumber'=>$goodNumber,'teacherName'=>$teacherName];
        return $goodNumList;
    }


    /**
     * 上线人数
     * @param array $list 老师对应的班级
     * @return array|float|int
     */
    public function  overLineNum(array $list){

        $array=[];
        foreach($list as $val){
            $classNum=count(explode(',',$val['classId']));

            if($classNum==0 || (float)($val['data']['overLineNum'])==0){
                $overLineNum=0;
            }else{
                $overLineNum=((float)($val['data']['overLineNum'])/$classNum);
            }
            $array[]=['teacherId'=>$val['teacherId'],'overLineNum'=>$overLineNum];
        }

        $overLineNumArray=[];
        $name=[];
        foreach($array as $val){
            $overLineNumArray[]=round($val['overLineNum'],2);
            $name[]=$val['teacherId']==0?'':WebDataCache::getUserNameByUserId($val['teacherId']);
        }
        $overLineNum=['max'=>100,'min'=>0,'overLineNum'=>$overLineNumArray,'name'=>$name];
        return $overLineNum;
    }


    /**
     * 公共方法
     * @param string $dataResult 回传数据，老师对应的班级
     * @param int $examId 考试ID
     * @param int $subjectId 科目ID
     * @return array
     */
    public function pubList(string $dataResult, int $examId, int $subjectId){
        $list=[];
        foreach(json_decode($dataResult) as $val){
            $array['teacherId']=$val->teacherId;
            $array['classId']=$val->classData;
            $array['data']=SeExamReportBaseInfo::findBySql("SELECT sum(realNumber) realNumber,sum(missNumber) missNumber,sum(goodNum) goodNum,sum(noPassNum) noPassNum,sum(lowScoreNum) lowScoreNum,sum(overLineNum) overLineNum
                FROM `se_exam_reportBaseInfo` WHERE schoolExamId=:examId and  subjectId=:subjectId and classId in ($val->classData)",[':examId'=>$examId,':subjectId'=>$subjectId])->one();
            $list[]=$array;
        }
        return $list;
    }


    /*
    *移动公共方法
    * @renter array
    * $dataResult 回传数据，老师对应的班级
    * $examId  考试ID
    * $subjectId  科目ID
    */
    public function pubTeacherList($dataResult,$examId,$subjectId){
        $list=[];
        foreach($dataResult as $val){
            $array['teacherId']=$val['teacherId'];
            $array['classId']=$val['classData'];
            $classId=$val['classData'];
            $array['data']=SeExamReportBaseInfo::findBySql("SELECT sum(realNumber) realNumber,sum(missNumber) missNumber,sum(goodNum) goodNum,sum(noPassNum) noPassNum,sum(lowScoreNum) lowScoreNum,sum(overLineNum) overLineNum
                FROM `se_exam_reportBaseInfo` WHERE schoolExamId=:examId and  subjectId=:subjectId and classId in ($classId)",[':examId'=>$examId,':subjectId'=>$subjectId])->one();
            $list[]=$array;
        }
        return $list;
    }


}