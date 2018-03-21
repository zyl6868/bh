<?php
namespace common\models\dicmodels;
use common\models\sanhai\SeDateDictionary;

/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-11-19
 * Time: 下午6:03
 */

class LoadSubjectModel
{
    private $data = array();


    function __construct($department,$notHasComp)
    {
        $this->data = $this->getData($department,$notHasComp);
    }


    /**
     * 查询学部显示科目数据源
     * @param string $department 学部
     * @return array|mixed
     */
    public function getData(string $department=null,$notHasComp=null)
    {
        $cacheId = 'subject_dataV2_' . $department.$notHasComp;
        $modelList = \Yii::$app->cache->get($cacheId);
        //$department学段，关联reserve1字段
        //$notHasComp文理综，空包含，不为空，不包含
        if ($modelList === false) {
            if(empty($notHasComp)){
                //包含文理综
                if(empty($department)){
                    $modelList=SeDateDictionary::find()->where(['firstCode'=>100])->select('secondCode,secondCodeValue')->all();
                }else{
                   $modelList=SeDateDictionary::find()->where(['firstCode'=>100])->andFilterWhere(['like','reserve1',$department])->select('secondCode,secondCodeValue')->all();
                }
            }else{
                //不包含文理综
                if(empty($department)){
                    $modelList=SeDateDictionary::find()->where('firstCode=100 and secondCode!=10027 and secondCode!=10028')->select('secondCode,secondCodeValue')->all();
                }else{
                    $modelList=SeDateDictionary::find()->where('firstCode=100 and secondCode!=10027 and secondCode!=10028')->andFilterWhere(['like','reserve1',$department])->select('secondCode,secondCodeValue')->all();
                }
            }
            if (!empty($modelList)) {
                \Yii::$app->cache->set($cacheId, $modelList, 3600);
            }
        }
        return is_null($modelList) ? array() : $modelList;
    }


    /**
     * 根据学部查询科目列表数据
     * @return array
     */
    public function getList()
    {
        return from($this->data)->where(function ($v)  {
            return true;
        })->toList();
    }


    /**
     * 获取科目一条数据
     * @param $id
     * @return mixed
     */
    public function getOne($id)
    {
        return from($this->data)->firstOrDefault(null, function ($v) use ($id) {
            return $v->secondCode == $id;
        });
    }


    /**
     * 调用静态方法
     * @param null $department
     * @return LoadSubjectModel
     */
    public static function model($department = null,$notHasComp=null)
    {
        $staticModel = new self($department,$notHasComp);
        return $staticModel;
    }


}
