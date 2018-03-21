<?php
declare(strict_types=1);
namespace schoolmanage\models;

use common\models\pos\SeUserinfo;
use common\components\WebDataKey;
use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\db\Query;

/**
 * Created by PhpStorm.
 * User: 邓奇文
 * Date: 2016/5/5
 * Time: 17:28
 */


class Homeworkuse extends Model
{
    public $creator;
    public $department;
    public $subjectId;
    public $teacherNum;
    public $teacherSum;
    public $studentNum;
    public $studentSum;
    public function rules(){
        return[
            [['creator','department','subjectId','teacherNum','teacherSum','studentNum','studentSum'], 'safe'],
        ];
    }

    /**
     * 作业使用统计
     * @param int $schoolID 学校ID
     * @param string $week_start 上周开始时间
     * @param string $week_end 上周结束时间
     * @return mixed
     */
    public function search(int $schoolID, string $week_start, string $week_end)
    {

        /**
         * @param int $schoolID 学校ID
         * @param string $week_start 上周开始时间
         * @param string $week_end 上周结束时间
         * @return ArrayDataProvider
         */
        $dataProvider_fun =function(int $schoolID, string $week_start, string $week_end)
        {
            //学校所有老师ID
            $teacherId = $this->teacherId($schoolID);

            $cache = Yii::$app->cache;
            $cacheKey = WebDataKey::HOMEWORKUSESUM_CACHE_KEY.$schoolID;
            $group = $cache->get($cacheKey);
            {
                if($group === false)
                //作业使用统计整合数组
                    $group = $this->group($teacherId);
                    $homeworkuseSum = $this->homeworkuseSum($teacherId,$week_start,$week_end);
                    $submitSum = $this->submitSum($teacherId,$week_start,$week_end);
                    $isCheckSum = $this->isCheckSum($teacherId,$week_start,$week_end);

                foreach ($group as &$groupInfo){
                    foreach ($homeworkuseSum as $home){
                        if($groupInfo['creator']==$home['creator'] && $groupInfo['department']==$home['department'] && $groupInfo['subjectId']==$home['subjectId']){
                            $groupInfo['teacherNum'] = $home['teacherNum'];
                            $groupInfo['teacherSum'] = $home['teacherSum'];
                        }
                    }
                    foreach ($submitSum as $sub){
                            if($groupInfo['creator']==$sub['creator'] && $groupInfo['department']==$sub['department'] && $groupInfo['subjectId']==$sub['subjectId']){
                                $groupInfo['studentNum'] = $sub['studentNum'];
                        }
                    }
                    foreach ($isCheckSum as $isCheck){
                        if($groupInfo['creator']==$isCheck['creator'] && $groupInfo['department']==$isCheck['department'] && $groupInfo['subjectId']==$isCheck['subjectId']){
                            $groupInfo['studentSum'] = $isCheck['studentSum'];
                        }
                    }
                }
                foreach ($group as $key=>&$val){
                    if ( !$val['department'] || !$val['subjectId']){
                        unset ( $group[$key] );
                    }
                }
                foreach ($group as $key=>&$val){
                    if (empty($val['teacherNum']) && empty($val['teacherSum']) && empty($val['studentNum']) && empty($val['studentSum'])){
                        unset ( $group[$key] );
                    }
                }
                $cache->set($cacheKey,$group,3600);
            }
            return  new ArrayDataProvider([
                'allModels' => $group,
                'sort' => [
                    'attributes' => ['creator','department','subjectId','teacherNum','teacherSum','studentNum','studentSum'],
                ],
                'pagination' => [
                    'pageSize' =>20,
                ],
            ]);
        };

        return   $dataProvider_fun($schoolID,$week_start,$week_end);
    }


    /**
     * 学校所有老师ID
     * @param int $schoolID 学校ID
     * @return array|\common\models\pos\SeUserinfo[]
     */
    public function teacherId(int $schoolID)
    {
        $teacherId = SeUserinfo::find()->where(['schoolID' => $schoolID, 'type'=>1])->select('userID')->active()->asArray()->all();
        foreach($teacherId as $key=>$teacher){
            $teacherId[$key] = $teacher['userID'];
        }
        return $teacherId;
    }


    /**
     * 老师-学段-科目分组
     * @param array $teacherId 老师ID
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function group(array $teacherId)
    {
        $query = new Query();
        $query->select('a.creator,a.department,a.subjectId')
            ->from('(se_homework_teacher a)')
            ->groupBy('a.creator,a.department,a.subjectId');
        $query->where(['in','a.creator',$teacherId]);
        $query->andWhere(['a.isDelete'=>0]);
        $group = $query->createCommand(Yii::$app->get('db_school'))->queryAll();
        return $group;
    }


    /**
     * 布置作业次数-接收作业人次
     * @param array $teacherId 老师ID
     * @param string $week_start 上周开始时间
     * @param string $week_end 上周结束时间
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function homeworkuseSum(array $teacherId, string $week_start, string $week_end)
    {
        $query = new Query();
        $query->select('count(0) teacherNum,sum(memberTotal) teacherSum,a.creator,a.department,a.subjectId')
            ->from('(se_homework_teacher a)')
            ->leftJoin('(se_homework_rel b)','a.id = b.homeworkId')
            ->groupBy('a.creator,a.department,a.subjectId');
        $query->where(['in','a.creator',$teacherId]);
        $query->andWhere(['b.isDelete'=>0]);
        $query->andWhere(['between', 'b.createTime', strtotime($week_start.' 00:00:00')*1000,strtotime($week_end.' 23:59:59')*1000]);
        $homeworkuseSum = $query->createCommand(Yii::$app->get('db_school'))->queryAll();
        return $homeworkuseSum;
    }


    /**
     * 提交作业人次
     * @param array $teacherId 老师ID
     * @param string $week_start 上周开始时间
     * @param string $week_end 上周结束时间
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function submitSum(array $teacherId, string $week_start, string $week_end)
    {
        $query = new Query();
        $query->select('count(c.studentID) studentNum,a.creator,a.department,a.subjectId')
            ->from('se_homework_teacher a')
            ->innerJoin('se_homework_rel b','a.id = b.homeworkId')
            ->innerJoin('se_homeworkAnswerInfo c','b.id = c.relId')
            ->groupBy('a.creator,a.department,a.subjectId');
        $query->where(['in','a.creator',$teacherId]);
        $query->andWhere(['c.isDelete'=>0]);
        $query->andWhere(['c.isUploadAnswer'=>1]);
        $query->andWhere(['between', 'c.uploadTime', strtotime($week_start.' 00:00:00')*1000,strtotime($week_end.' 23:59:59')*1000]);
        $submitSum = $query->createCommand(Yii::$app->get('db_school'))->queryAll();
        return $submitSum;
    }


    /**
     * 批改作业人次
     * @param array $teacherId 老师ID
     * @param string $week_start 上周开始时间
     * @param string $week_end 上周结束时间
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function isCheckSum($teacherId, $week_start, $week_end)
    {
        $query = new Query();
        $query->select('count(CASE WHEN c.isCheck = 1 THEN c.studentID ELSE NULL END) studentSum,a.creator,a.department,a.subjectId')
            ->from('(se_homework_teacher a)')
            ->innerJoin('se_homework_rel b','a.id = b.homeworkId')
            ->innerJoin('se_homeworkAnswerInfo c','b.id = c.relId')
            ->groupBy('a.creator,a.department,a.subjectId');
        $query->where(['in','a.creator',$teacherId]);
        $query->andWhere(['c.isDelete'=>0]);
        $query->andWhere(['c.isUploadAnswer'=>1]);
        $query->andWhere(['between', 'c.checkTime', strtotime($week_start.' 00:00:00')*1000,strtotime($week_end.' 23:59:59')*1000]);
        $isCheckSum = $query->createCommand(Yii::$app->get('db_school'))->queryAll();
        return $isCheckSum;
    }


}