<?php
/**
 * Created by PhpStorm.
 * User: aaa
 * Date: 2016/3/12
 * Time: 13:11
 */
namespace common\business\homework;

use common\models\dicmodels\SubjectModel;
use common\models\pos\SeClass;
use common\models\pos\SeExamPersonalScore;
use common\models\pos\SeExamReportBaseInfo;
use common\models\pos\SeExamReportStudentStructure;
use common\models\pos\SeExamSubject;
use common\models\sanhai\SeDateDictionary;
use yii\helpers\ArrayHelper;

class ClassContrastModel{


    /**
     * 班级对比 学生构成分析
     * @param int $schoolExamId 学校考试ID
     * @return array
     */
    public function classAnalyze(int $schoolExamId)
    {
       $studentStructure = SeExamReportStudentStructure::find()->where(['schoolExamId'=>$schoolExamId])->all();
       $className = [];
       $aplusNum = [];
       $aNum = [];
       $bplusNum = [];
       $bNum = [];
       $cplusNum = [];
       $cNum = [];
       $sum = [];
       if(!empty($studentStructure)){
           foreach($studentStructure as $val){
               $name = $this->pubName($val['classId']);
               $className[] = $name;
               $aplusNum[] = $val['AplusNum'];
               $aNum[] = $val['ANum'];
               $bplusNum[] = $val['BplusNum'];
               $bNum[] = $val['BNum'];
               $cplusNum[] = $val['CplusNum'];
               $cNum[] = $val['CNum'];
               $sum[] = (float)$val['AplusNum'] + (float)$val['ANum'] + (float)$val['BplusNum'] + (float)$val['BNum'] + (float)$val['CplusNum'] + (float)$val['CNum'];
           }
       }
        $val = array_search(max($sum), $sum , false);
        $max = (float)$sum[$val] +5;
       $studentAnalyzeList = ['className'=>$className,'aplusNum'=>$aplusNum,'aNum'=>$aNum,'max'=>$max,
                              'bplusNum'=>$bplusNum,'bNum'=>$bNum,'cplusNum'=>$cplusNum,'cNum'=>$cNum];
       return $studentAnalyzeList;
    }


    /**
     * 班级对比 不及格人数对比
     * @param array $class 考试班级
     * @param int $schoolExamId 学校考试ID
     * @return array
     */
    public function classNoPassList(array $class, int $schoolExamId)
    {
        $data = $this->pubSumScore($class, $schoolExamId);

        $contrastLowScore = [];
        foreach ($data as $val) {
            if (0 == (float)$val['noPassNum']) {
                $lowNum = 0;
            } else {
                $lowNum = (float)$val['noPassNum'];
            }
            $contrastLowScore[] = ['number' => $lowNum, 'classId' => $val['classId']];
        }
        $lowScoreName = [];
        $lowNumber = [];
        foreach ($contrastLowScore as $val) {
            $name = $this->pubName($val['classId']);
            $lowScoreName[] = $name;
            $lowNumber[$name] = (float)$val['number'];
        }
        $lowScoreList = null;
        $lowScoreList = ['lowNumber' => $lowNumber, 'lowScoreName' => $lowScoreName];
        return $lowScoreList;
    }


    /**
     * 班级对比 高分人数对比
     * @param array $class 考试班级
     * @param int $schoolExamId 学校考试ID
     * @return array
     */
    public function classTopList(array $class, int $schoolExamId)
    {
        $data = $this->pubSumScore($class, $schoolExamId);

        $contrastLowScore = [];
        foreach ($data as $val) {
            if ((float)$val['goodNum'] == 0) {
                $topNum = 0;
            } else {
                $topNum = (float)$val['goodNum'];
            }
            $contrastLowScore[] = ['number' => $topNum, 'classId' => $val['classId']];
        }
        $topScoreName = [];
        $topNumber = [];
        foreach ($contrastLowScore as $val) {
            $name = SeClass::find()->where(['classID' => $val['classId']])->select('className')->scalar();
            $topScoreName[] = $name;
            $topNumber[$name] = (float)$val['number'];
        }
        $topScoreList = null;
        $topScoreList = ['topNumber' => $topNumber, 'topScoreName' => $topScoreName];
        return $topScoreList;

    }


    /**
     * 班级对比 低分率
     * @param array $class 考试班级
     * @param int $schoolExamId 学校考试ID
     * @return array
     */
    public function classLowList(array $class, int $schoolExamId)
    {
        $data = $this->pubSumScore($class, $schoolExamId);

        $userSum = 0;
        $lowScoreNum = 0;
        $contrastLowScore = [];
        foreach ($data as $val) {
            $userSum += (float)$val['classTotal']['userId'];
            $lowScoreNum += (float)$val['lowScoreNum'];

            $classNumber = (float)$val['classTotal']['userId'];
            if ($classNumber == 0 || (float)$val['lowScoreNum'] == 0) {
                $score = 0;
            } else {
                $score = (float)((float)$val['lowScoreNum'] / $classNumber) * 100;
            }
            $contrastLowScore[] = ['score' => $score, 'classId' => $val['classId']];
        }
        $lowScoreName = [];
        $lowNumber = [];
        $contrastLowScore = $this->sortArray($contrastLowScore);
        foreach ($contrastLowScore as $val) {
            $lowScoreName[] = $this->pubName($val['classId']);
            $lowNumber[] = round($val['score'],2);
        }
        $maxMin = $this->maxMin($lowNumber);
        if ($maxMin['big'] == 0) {
            $max = 100;
            $min = 0;
        } else {
            $max=(round($maxMin['big']/10)+1)*10;
            $min=$maxMin['small'] < 10 ? 0 : (round($maxMin['small']/10)-1)*10;
        }
        if ($userSum == 0 || $lowScoreNum == 0) {
            $averagegLow = 0;
        } else {
            $averagegLow = round(($lowScoreNum / $userSum)*100, 2);
        }
        $lowList = ['lowNumber' => $lowNumber, 'averagegLow' => $averagegLow, 'maxLow' => $max, 'minLow' => $min, 'lowScoreName' => $lowScoreName];
        return $lowList;

    }


    /**
     * 班级对比及格率
     * @param array $class 考试班级
     * @param int $schoolExamId 学校考试ID
     * @return array
     */
    public function classPassList(array $class, int $schoolExamId)
    {
        $data = $this->pubSumScore($class, $schoolExamId);

        $userSum = 0;
        $passNum = 0;
        $contrastPass = [];
        foreach ($data as $val) {
            $userSum += (float)$val['classTotal']['userId'];
            $passNum += (float)$val['PassNum'];

            $classNumber = (float)$val['classTotal']['userId'];

            if ($classNumber == 0 || (float)$val['PassNum'] == 0) {
                $score = 0;
            } else {
                $score = (float)$val['PassNum'] / $classNumber * 100;
            }
            $contrastPass[] = ['score' => $score, 'classId' => $val['classId']];
        }

        $passName = [];
        $passNumber = [];
        $contrast = $this->sortArray($contrastPass);
        foreach ($contrast as $val) {
            $passName[] = $this->pubName($val['classId']);
            $passNumber[] = round($val['score'],2);
        }
        $maxMin = $this->maxMin($passNumber);
        if ($maxMin['big'] == 0) {
            $max = 100;
            $min = 0;
        } else {
            $max=(round($maxMin['big']/10)+1)*10;
            $min=$maxMin['small'] < 10 ? 0 : (round($maxMin['small']/10)-1)*10;
        }
        if ($userSum == 0 || $passNum == 0) {
            $averagegPass = 0;
        } else {
            $averagegPass = round(($passNum / $userSum)*100,2);
        }
        $passList = ['passNumber' => $passNumber, 'averagegPass' => $averagegPass, 'maxPass' => $max, 'minPass' =>$min, 'passName' => $passName];
        return $passList;


    }


    /**
     * 班级对比优良率
     * @param int $class 考试班级
     * @param int $schoolExamId 学校考试ID
     * @return array
     */
    public function classGoodNum(array $class, int $schoolExamId)
    {
        $data = $this->pubSumScore($class, $schoolExamId);

        $userSum = 0;
        $goodNum = 0;
        $contrastGood = [];
        foreach ($data as $val) {
            $userSum += (float)$val['classTotal']['userId'];
            $goodNum += (float)$val['goodNum'];

            $classNumber = (float)$val['classTotal']['userId'];
            if ($classNumber == 0 || (float)$val['goodNum'] == 0) {
                $score = 0;
            } else {
                $score = ((float)$val['goodNum'] / $classNumber) * 100;
            }
            $contrastGood[] = ['classId' => $val['classId'], 'score' => $score];
        }

        //排序
        $goodNumber = [];
        $goodName = [];
        $contrast = $this->sortArray($contrastGood);
        foreach ($contrast as $val) {
            $goodNumber[] = round($val['score'],2);
            $goodName[] = $this->pubName($val['classId']);
        }
        $maxMin = $this->maxMin($goodNumber);
        if ($maxMin['big'] == 0) {
            $max = 100;
            $min = 0;
        } else {
            $max=(round($maxMin['big']/10)+1)*10;
            $min=$maxMin['small'] < 10 ? 0 : (round($maxMin['small']/10)-1)*10;
        }
        //优良率
        if ($goodNum == 0 || $userSum == 0) {
            $averagegGood = 0;
        } else {
            $averagegGood = round(($goodNum / $userSum)*100, 2);
        }
        $contrastList = ['goodNumber' => $goodNumber, 'averagegGood' => $averagegGood, 'maxGood' => $max, 'minGood' => $min, 'goodName' => $goodName,];
        return $contrastList;

    }


    /*
     * 班级对比班级名称
     * @return string
     * $classId  班级ID
     */
    public function pubName($classId)
    {
        return SeClass::find()->where(['classID' => $classId])->select('className')->limit(1)->one()->className;
    }


    /**
     * 班级对比总成绩
     * @param array $class 考试班级
     * @param int $schoolExamId 学校考试ID
     * @return array
     */
    public function classSumScore(array $class, int $schoolExamId)
    {
        $data = $this->pubSumScore($class, $schoolExamId);

        $sumNumber = 0;
        $sumScore = 0;
        $averagegClass = [];
        foreach ($data as $val) {
            $sumNumber += (float)$val['classTotal']['userId'];
            $sumScore += (float)$val['classTotal']['totalScore'];

            $userSum = (float)$val['classTotal']['userId'];
            $scoreSum = (float)$val['classTotal']['totalScore'];
            if ($userSum == 0 || $scoreSum == 0) {
                $score = 0;
            } else {
                $score = (float)($scoreSum / $userSum);
            }
            $averagegClass[] = ['classId' => $val['classId'], 'score' => $score];

        }
        //班级平均分排序
        $averagegClass = $this->sortArray($averagegClass);

        $className = [];
        $classScore = [];
        foreach ($averagegClass as $val) {
            $classScore[] = round($val['score'],2);
            $className[] = SeClass::find()->where(['classID' => $val['classId']])->select('className')->scalar();
        }
        //最大最小
        $maxMin = $this->maxMin($classScore);
        if ($maxMin['big'] == 0) {
            $max = 100;
            $min = 0;
        } else {
            $max=(round($maxMin['big']/10)+1)*10;
            $min=$maxMin['small'] < 10 ? 0 : (round($maxMin['small']/10)-1)*10;
        }
        //班级总成绩平均分
        if ($sumNumber == 0 || $sumScore == 0) {
            $average = 0;
        } else {
            $average = round($sumScore / $sumNumber,2);
        }
        $classList = ['max' => $max, 'min' => $min, 'average' => $average, 'className' => $className, 'classScore' => $classScore];
        return $classList;
    }


    /**
     * 班级对比总成绩
     * @param array $class 考试班级
     * @param int $schoolExamId 学校考试ID
     * @return array
     */
    public function pubSumScore($class, $schoolExamId)
    {
        $array = [];
        $data = [];
        foreach ($class as $val) {
            $list['classId'] = $val['classId'];
            $list['classExamId'] = $val['classExamId'];
            $array[] = $list;
        }

        $fullScore = SeExamSubject::find()->where(['schoolExamId' => $schoolExamId])->select('fullScore')->sum('fullScore');
        $fullScore = (float)$fullScore;
        foreach ($array as $val) {
            $arr['classId'] = $val['classId'];
            $arr['classTotal'] = SeExamPersonalScore::findBySql('SELECT COUNT(userId) userId,SUM(totalScore) totalScore FROM `se_exam_personalScore` where classExamId=:classExamId', [':classExamId' => $val['classExamId']])->limit(1)->one();
            $arr['goodNum'] = SeExamPersonalScore::findBySql("SELECT COUNT(perScoreId) perScoreId FROM `se_exam_personalScore` where classExamId=:examId and  totalScore >= $fullScore*0.8", [':examId' => $val['classExamId']])->limit(1)->one()->perScoreId;
            $arr['PassNum'] = SeExamPersonalScore::findBySql("SELECT COUNT(perScoreId) perScoreId FROM `se_exam_personalScore` where classExamId=:examId and  totalScore >= $fullScore*0.6", [':examId' => $val['classExamId']])->limit(1)->one()->perScoreId;
            $arr['lowScoreNum'] = SeExamPersonalScore::findBySql("SELECT COUNT(perScoreId) perScoreId FROM `se_exam_personalScore` where classExamId=:examId and  totalScore < $fullScore*0.4", [':examId' => $val['classExamId']])->limit(1)->one()->perScoreId;
            $arr['noPassNum'] = SeExamPersonalScore::findBySql("SELECT COUNT(perScoreId) perScoreId FROM `se_exam_personalScore` where classExamId=:examId and  totalScore < $fullScore*0.6", [':examId' => $val['classExamId']])->limit(1)->one()->perScoreId;

            $data[] = $arr;
        }
        return $data;
    }


    /**
     * 班级对比 单科高分人数
     * @param int $schoolExamId 学校考试ID
     * @param int $subjectId 科目ID
     * @return array
     */
    public function subjectTopList(int $schoolExamId, int $subjectId)
    {
        $data = $this->publicClass($schoolExamId, $subjectId);
        $contrastTopScore = [];
        foreach ($data as $val) {
            if ((float)$val['single']['goodNum'] == 0) {
                $topSum = 0;
            } else {
                $topSum = (float)$val['single']['goodNum'];
            }
            $contrastTopScore[] = ['number' => $topSum, 'classId' => $val['classId']];
        }
        $topScoreName = [];
        $topNumber = [];
        foreach ($contrastTopScore as $val) {
            $name = $this->pubName($val['classId']);
            $topScoreName[] = $name;
            $topNumber[$name] = (float)$val['number'];
        }
        $topScoreList = null;
        $topScoreList = ['topNumber' => $topNumber, 'topScoreName' => $topScoreName];
        return $topScoreList;
    }


    /**
     * 班级对比 单科不及格人数
     * @param int $schoolExamId 学校考试ID
     * @param int $subjectId 科目ID
     * @return array
     */
    public function subjectLowList(int $schoolExamId, int $subjectId)
    {
        $data = $this->publicClass($schoolExamId, $subjectId);
        $contrastLowScore = [];
        foreach ($data as $val) {
            if ((float)$val['single']['noPassNum'] == 0) {
                $lowSum = 0;
            } else {
                $lowSum = (float)$val['single']['noPassNum'];
            }
            $contrastLowScore[] = ['number' => $lowSum, 'classId' => $val['classId']];
        }
        $lowScoreName = [];
        $lowNumber = [];
        foreach ($contrastLowScore as $val) {
            $name = $this->pubName($val['classId']);
            $lowScoreName[] = $name;
            $lowNumber[$name] = (float)$val['number'];
        }
        $lowScoreList = ['lowNumber' => $lowNumber, 'lowScoreName' => $lowScoreName];
        return $lowScoreList;
    }


    /**
     * @return string
     * $sclassId 班级ID
     * 班级对比 公共班级名称
     */
    public function pubClassName($classID)
    {
        return SeClass::find()->where(['classID' => $classID])->select('className')->limit(1)->one()->className;
    }


    /**
     * 班级对比 单科优良率
     * @param int $schoolExamId 学校考试ID
     * @param int $subjectId 科目ID
     * @return array
     */
    public function subjectExcellent(int $schoolExamId, int $subjectId)
    {
        $data = $this->publicClass($schoolExamId, $subjectId);
        //总分
        $userSum = 0;
        $goodNum = 0;
        $goodSum = [];
        foreach ($data as $val) {
            $numberSum = (float)$val['single']['realNumber'] + (float)$val['single']['missNumber'];
            $userSum += $numberSum;
            $goodNum += (float)$val['single']['goodNum'];

            if ((float)$val['single']['goodNum'] == 0 || $numberSum == 0) {
                $score = 0;
            } else {
                $score = ((float)$val['single']['goodNum'] / $numberSum) * 100;
            }
            $goodSum[] = ['score' => $score, 'classId' => $val['classId']];
        }
        //排序
        $goodName = [];
        $goodNumber = [];
        $goodSum = $this->sortArray($goodSum);
        foreach ($goodSum as $val) {
            $goodName[] = $this->pubName($val['classId']);
            $goodNumber[] = round($val['score'],2);
        }
        $maxMin = $this->maxMin($goodNumber);
        if ($maxMin['big'] == 0) {
            $max = 100;
            $min = 0;
        } else {
            $max=(round($maxMin['big']/10)+1)*10;
            $min=$maxMin['small'] < 10 ? 0 : (round($maxMin['small']/10)-1)*10;
        }
        //平均分
        if ($goodNum == 0 || $userSum == 0) {
            $averagegGood = 0;
        } else {
            $averagegGood = round(($goodNum / $userSum)*100, 2);
        }
        $excellentList = ['goodNumber' => $goodNumber, 'averagegGood' => $averagegGood, 'maxGood' => $max, 'minGood' =>$min, 'goodName' => $goodName,];
        return $excellentList;
    }


    /**
     * 班级对比 单科及格率
     * @param int $schoolExamId 学校考试ID
     * @param int $subjectId 科目ID
     * @return array
     */
    public function subjectNoPass(int $schoolExamId, int $subjectId)
    {
        $data = $this->publicClass($schoolExamId, $subjectId);
        //总分
        $userSum = 0;
        $passNum = 0;
        $passSum = [];
        foreach ($data as $val) {
            $numberSum = (float)$val['single']['realNumber'] + (float)$val['single']['missNumber'];
            $userSum += $numberSum;
            $passNum += (float)$val['single']['noPassNum'];

            if($numberSum == 0){
                $score = 0;
            }else{
                if ((float)$val['single']['noPassNum'] == 0) {
                    $score = 100;
                } else {
                    $score = (1 - ((float)$val['single']['noPassNum'] / $numberSum)) * 100;
                }
            }

            $passSum[] = ['score' => $score, 'classId' => $val['classId']];
        }
        //排序
        $passName = [];
        $passNumber = [];
        $passSum = $this->sortArray($passSum);
        foreach ($passSum as $val) {
            $passName[] = $this->pubName($val['classId']);
            $passNumber[] = round($val['score'],2);
        }
        $maxMin = $this->maxMin($passNumber);
        if ($maxMin['big'] == 0) {
            $max = 100;
            $min = 0;
        } else {
            $max=(round($maxMin['big']/10)+1)*10;
            $min=$maxMin['small'] < 10 ? 0 : (round($maxMin['small']/10)-1)*10;
        }
        //平均分
        if($userSum==0){
            $averagegPass = 0;
        }else{
            $averagegPass = round((1-($passNum / $userSum))*100, 2);
        }
        $noPassList = ['passNumber' => $passNumber, 'averagegPass' => $averagegPass, 'maxPass' =>$max, 'minPass' => $min, 'passName' => $passName,];
        return $noPassList;
    }


    /**
     * 班级对比 单科低分率
     * @param int $schoolExamId 学校考试ID
     * @param int $subjectId 科目ID
     * @return array
     */
    public function subjectLow(int $schoolExamId, int $subjectId)
    {
        $data = $this->publicClass($schoolExamId, $subjectId);
        //总分
        $userSum = 0;
        $lowNum = 0;
        $lowSum = [];
        foreach ($data as $val) {
            $numberSum = (float)$val['single']['realNumber'] + (float)$val['single']['missNumber'];
            $userSum += $numberSum;
            $lowNum += (float)$val['single']['lowScoreNum'];

            if ((float)$val['single']['lowScoreNum'] == 0 || $numberSum == 0) {
                $score = 0;
            } else {
                $score = ((float)$val['single']['lowScoreNum'] / $numberSum) * 100;
            }
            $lowSum[] = ['score' => $score, 'classId' => $val['classId']];
        }
        //排序
        $lowScoreName = [];
        $lowNumber = [];
        $lowSum = $this->sortArray($lowSum);
        foreach ($lowSum as $val) {
            $lowScoreName[] = $this->pubName($val['classId']);
            $lowNumber[] = round($val['score'],2);
        }
        $maxMin = $this->maxMin($lowNumber);
        if ($maxMin['big'] == 0) {
            $max = 100;
            $min = 0;
        } else {
            $max=(round($maxMin['big']/10)+1)*10;
            $min=$maxMin['small'] < 10 ? 0 : (round($maxMin['small']/10)-1)*10;
        }
        //平均分
        if ($lowNum == 0 || $userSum == 0) {
            $averagegLow = 0;
        } else {
            $averagegLow = round(($lowNum / $userSum)*100, 2);
        }
        $lowList = ['lowNumber' => $lowNumber, 'averagegLow' => $averagegLow, 'maxLow' => $max, 'minLow' => $min, 'lowScoreName' => $lowScoreName,];
        return $lowList;
    }


    /**
     * 班级  单科平均分
     * @param int $subjectId 科目ID
     * @param int $schoolExamId 学校考试ID
     * @return array
     */
    public function subjectScoreSum(int $subjectId, int $schoolExamId)
    {
        $data = $this->publicClass($schoolExamId, $subjectId);
        //总分
        $userSum = 0;
        $gradeSumScore = 0;
        $classSum = [];
        $maxMin = [];
        foreach ($data as $val) {
            $numberSum = ((float)$val['single']['realNumber'] + (float)$val['single']['missNumber']);
            $userSum += $numberSum;
            $gradeSumScore += (float)$val['single']['avgScore'] * $numberSum;

            $maxMin[] = (float)$val['single']['avgScore'];
            if ((float)$val['single']['avgScore'] == 0) {
                $score = 0;
            } else {
                $score = (float)$val['single']['avgScore'];
            }
            $classSum[] = ['score' => $score, 'classId' => $val['classId']];
        }
        //排序
        $className = [];
        $classScore = [];
        $classSum = $this->sortArray($classSum);
        foreach ($classSum as $val) {
            $className[] = $this->pubName($val['classId']);
            $classScore[] = round($val['score'],2);
        }
        //最大最小值
        $maxMin = $this->maxMin($maxMin);
        if ($maxMin['big'] == 0) {
            $max = 100;
            $min = 0;
        } else {
            $max=(round($maxMin['big']/10)+1)*10;
            $min=$maxMin['small'] < 10 ? 0 : (round($maxMin['small']/10)-1)*10;
        }
        //平均分
        if ($gradeSumScore == 0 || $userSum == 0) {
            $average = 0;
        } else {
            $average = round($gradeSumScore / $userSum,2);
        }
        $dataList = ['max' => $max, 'min' => $min, 'average' => $average, 'className' => $className, 'classScore' => $classScore];

        return $dataList;
    }


    /**
     * 班级对比 公共班级
     * @param int $schoolExamId 学校考试ID
     * @param int $subjectId 科目ID
     * @return array
     */
    public function publicClass(int $schoolExamId, int $subjectId)
    {
        $examReportSum = SeExamReportBaseInfo::find()->where(['schoolExamId' => $schoolExamId, 'subjectId' => $subjectId])->select('classId,subjectId')->all();

        $list = [];
        $data = [];
        foreach ($examReportSum as $val) {
            $array['classId'] = $val['classId'];
            $array['subject'] = $val['subjectId'];
            $list[] = $array;
        }

        foreach ($list as $val) {
            $arr['classId'] = $val['classId'];
            $arr['single'] = SeExamReportBaseInfo::findBySql('SELECT realNumber,missNumber,avgScore,goodNum,noPassNum,lowScoreNum,overLineNum FROM `se_exam_reportBaseInfo` where schoolExamId=:schoolExamId and classId=:classId and subjectId=:subjectId', [':schoolExamId' => $schoolExamId, ':classId' => $val['classId'], ':subjectId' => $subjectId])->one();
            $data[] = $arr;
        }
        return $data;
    }

    /**
     * @return array
     * $arr array
     * 班级对比最大值最小值
     */
    public function maxMin(Array $arr)
    {
        $cmpTime = 0;
        $count = count($arr);
        $big = $small = $arr[0];
        for ($i = 1; $i < $count; $i++) {
            $cmpTime++;
            if ($big > $arr[$i]) {
                $cmpTime++;
                if ($small > $arr[$i]) {
                    $small = $arr[$i];
                }
            } else {
                $big = $arr[$i];
            }
        }
        $maxMin = null;
        $maxMin = ['big' => floor($big), 'small' => floor($small)];
        return $maxMin;
    }


    /**
     * @return array
     * $classSum array
     * 班级对比  成绩排序
     */
    public function sortArray($classSum)
    {
        foreach ($classSum as $key => $value) {
            $price[$key] = $value['score'];
        }
        array_multisort($price, SORT_NUMERIC, SORT_DESC, $classSum);
        return $classSum;
    }


    /**
     * 班级展示科目
     * @param array $subject 科目
     * @return array
     */
    public function showSubject(array $subject)
    {
        if (!empty($subject)) {
            $subjectId = array_values($subject);
            $subjectList = SubjectModel::model()->getSubjectById($subjectId);
            $subList = ArrayHelper::map($subjectList, 'secondCode', 'secondCodeValue');
        } else {
            $subList = [];
        }
        return $subList;
    }

}