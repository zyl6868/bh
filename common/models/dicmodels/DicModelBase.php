<?php
/**
 * Created by PhpStorm.
 * User: yangjie
 * Date: 17/1/17
 * Time: 上午10:45
 */
namespace common\models\dicmodels;


use common\components\WebDataKey;
use common\models\sanhai\SeDateDictionary;
use Yii;
use yii\helpers\ArrayHelper;


/**
 * Created by PhpStorm.
 * User: yangjie
 * Date: 2016/01/17
 * Time: 11:11
 */
class  DicModelBase implements DicModelInterFace
{
    protected $data = array();

    public function __construct()
    {
        $this->data = $this->getDataList();
    }

    /**
     * @return $this
     */
    public static function model()
    {
        $staticModel = new static();
        return $staticModel;
    }


    public function getDataList()
    {
        return $this->getSourceDataList('');

    }

    protected function getSourceDataList($cacheKey,$code=0)
    {
        if (empty($cacheKey)) {
            return [];
        }

        $modelList = \Yii::$app->cache->get($cacheKey);

        if ($modelList === false) {
            $modelList = SeDateDictionary::find()->where(['firstCode' => $code])->select('secondCode,secondCodeValue')->active()->all();
            if (!empty($modelList)) {
                \Yii::$app->cache->set($cacheKey, $modelList, 3600);
            }
        }
        return is_null($modelList) ? array() : $modelList;

    }

    /**
     * 数据字典模型
     * @param $tqtid
     * @param integer $secondCode 二级代码
     * @return array|SeDateDictionary|mixed|null
     */
    public static function getDictionaryModel(int $secondCode)
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::SHOWTYPE_CACHE_KEY . $secondCode;
        $data = $cache->get($key);
        if ($data === false) {
            $data = SeDateDictionary::find()->where(['secondCode' => $secondCode])->active()->limit(1)->one();
            if ($data != null) {
                $cache->set($key, $data, 6000);
            }
        }

        return $data;

    }


    public function getList()
    {
        return $this->getDataList();
    }

    /**
     * 下拉列表
     * @return array
     */
    public function getListData()
    {
        return ArrayHelper::map($this->getDataList(), 'secondCode', 'secondCodeValue');

    }


    /**
     * 查询单条数据
     * @param $id
     * @return \YaLinqo\Enumerable
     */
    public function getOne($id)
    {
        return from($this->data)->firstOrDefault(null, function ($v) use ($id) {
            return $v->secondCode == $id;
        });
    }


    /**
     * @param $id
     * @return string
     */
    public function getName($id)
    {
        if (!is_numeric($id)) return '';
        $result = $this->getOne($id);
        return isset($result) ? $result->secondCodeValue : '';
    }

    /**
     * 获取多个ids名称
     * @param array $ids
     * @return string
     */
    public function getNames(array $ids)
    {

        $versionArray = [];
        foreach ($ids as $item) {

            $name = $this->getName($item);
            if (!empty($name)) {
                $versionArray[] = $name;
            }
        }
        return implode(',', $versionArray);
    }

    /**
     * @param $ids
     * @return string
     */
    public function getNamesByStr($ids)
    {

        $arr = explode(',', $ids);
        $versionArray = [];
        foreach ($arr as $item) {

            $name = $this->getName($item);
            if (!empty($name)) {
                $versionArray[] = $name;
            }
        }
        return implode(',', $versionArray);
    }
}