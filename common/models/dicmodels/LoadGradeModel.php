<?php
namespace common\models\dicmodels;
use common\models\pos\SeSchoolInfo;
use common\models\sanhai\SeSchoolGrade;

/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 15-4-25
 * Time: 下午5:01
 */
class LoadGradeModel{
    private $data = array();


    function __construct($schoolId,$department)
    {
        $this->data = $this->getData($schoolId,$department);
    }

    /**
     * 根据学校id和学部查出年级
     * @param $schoolId
     * @param $department
     * @return array|mixed
     */
    public function getData($schoolId,$department)
    {
       $cacheId = 'load_dataV2_' .'schoolid'. $schoolId.'deppartment'.$department;
        $modelList = \Yii::$app->cache->get($cacheId);
        if ($modelList === false) {
            if(empty($schoolId)){$schoolId='';}
            if(empty($department)){$department='';}
            $schoolid=SeSchoolInfo::find()->where(['schoolID'=>$schoolId])->select('lengthOfSchooling')->limit(1)->one();
            if($schoolid){
                if($schoolid['lengthOfSchooling']==20503){
                    $List=SeSchoolGrade::find()->where(['schoolDepartment'=>$department])->select('gradeId,gradeName,schoolDepartment')->all();
                    $modelList=$this->pub($List,$schDepName='高中部',$lenOfSch=20503,$lenOfSchName='五三学制');
                }elseif($schoolid['lengthOfSchooling']==20502){
                    $List=SeSchoolGrade::find()->where(['schoolDepartment'=>$department])->select('gradeId,gradeName,schoolDepartment')->all();
                    $modelList=$this->pub($List,$schDepName='初中部',$lenOfSch=20502,$lenOfSchName='五四学制');
                    foreach($modelList as $key=>$val){if($val['gradeId']==1007){unset($modelList[$key]);} }
                }else{
                    $List=SeSchoolGrade::find()->where(['schoolDepartment'=>$department])->select('gradeId,gradeName,schoolDepartment')->all();
                    $modelList=$this->pub($List,$schDepName='小学部',$lenOfSch=20501,$lenOfSchName='六三学制');
                }
            }else{
                $List=SeSchoolGrade::find()->where(['schoolDepartment'=>$department])->select('gradeId,gradeName,schoolDepartment')->all();
                $modelList=$this->pub($List,$schDepName='小学部',$lenOfSch=20501,$lenOfSchName='六三学制');
            }

            if (!empty($modelList)) {
                \Yii::$app->cache->set($cacheId, $modelList, 3600);
            }
        }
        return is_null($modelList) ? array() : $modelList;
    }

    /**
     * 静态调用
     * @param null $schoolId
     * @param null $department
     * @return LoadGradeModel
     */
    public static function model($schoolId=null,$department = null)
    {
        $staticModel = new self($schoolId,$department);
        return $staticModel;
    }

    /**
     * 查询一条数据
     * @param $id
     * @return mixed
     */
    public function getOne($id)
    {
        return from($this->data)->firstOrDefault(null, function ($v) use ($id) {
            return $v->gradeId == $id;
        });
    }
    /*
    * 学部调用
    */
    public function pub($List,$schDepName,$lenOfSch,$lenOfSchName){
        $modelList=[];
        foreach($List as $val){
            $arr['gradeId']=$val->gradeId;
            $arr['gradeName']=$val->gradeName;
            $arr['schDep']=$val->schoolDepartment;
            $arr['schDepName']=$schDepName;
            $arr['lenOfSch']=$lenOfSch;
            $arr['lenOfSchName']=$lenOfSchName;
            $modelList[]=$arr;
        }
        return $modelList;
    }
}