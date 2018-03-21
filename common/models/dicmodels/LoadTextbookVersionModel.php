<?php
namespace common\models\dicmodels;

use common\models\sanhai\SeDateDictionary;
use common\models\sanhai\SeSchoolGrade;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 15-4-8
 * Time: 下午4:47
 */
class LoadTextbookVersionModel
{
	private $data = array();

	function __construct($subject, $grade = null, $department = null)
	{
		$this->data = $this->getData((int)$subject,(int)$grade,(int)$department);
	}


    /**
     * 根据学科查询版本
     * @param int|null $subject
     * @param int|null $grade
     * @param int|null $department
     * @return array|SeDateDictionary[]|mixed
     */
	public function getData(int $subject = null,int $grade = null,int $department = null)
	{
		$cacheId = 'loadTextbookVersionV2_data_' . $subject . 'grade' . $grade . 'department' . $department;
		$modelList = \Yii::$app->cache->get($cacheId);
		if ($modelList === false) {
			if (empty($subject)) {
				return [];
			}
            $dicModel = SeDateDictionary::find()->where(['firstCode' => 206]);
			if (empty($department)) {
				if (empty($grade)) {
					$modelListQuery = $dicModel->andFilterWhere(['like', 'reserve1', $subject]);
				} else {
					$departmentId = SeSchoolGrade::find()->where(['gradeId' => $grade])->select('schoolDepartment')->limit(1)->one();
					if ($departmentId['schoolDepartment'] == 20201) {
                        $modelListQuery = $dicModel->andFilterWhere(['like', 'reserve1', $subject]);
					} elseif ($departmentId['schoolDepartment'] == 20202) {
                        $modelListQuery = $dicModel->andFilterWhere(['like', 'reserve2', $subject]);
					} elseif ($departmentId['schoolDepartment'] == 20203) {
                        $modelListQuery = $dicModel->andFilterWhere(['like', 'reserve3', $subject]);
					} else {
						return [];
					}
				}
			} else {
				if ($department == 20201) {
                    $modelListQuery = $dicModel->andFilterWhere(['like', 'reserve1', $subject]);
				} elseif ($department == 20202) {
                    $modelListQuery = $dicModel->andFilterWhere(['like', 'reserve2', $subject]);
				} elseif ($department == 20203) {
                    $modelListQuery = $dicModel->andFilterWhere(['like', 'reserve3', $subject]);
				} else {
					return [];
				}
			}
            $modelList = $modelListQuery->select('secondCode,secondCodeValue')->orderBy('orderNo desc')->active()->all();

			if (!empty($modelList)) {
				\Yii::$app->cache->set($cacheId, $modelList, 3600);
			}
		}

		return is_null($modelList) ? array() : $modelList;
	}

	/**
	 * 查询版本数据
	 * @return array
	 */
	public function getList()
	{
		return from($this->data)->where(function ($v) {
			return true;
		})->toList();
	}

	/**
	 * 查询一条版本数据
	 * @param $id
	 * @return mixed
	 */
	public function getOne($id)
	{
		return from($this->data)->firstOrDefault(null, function ($v) use ($id) {
			return $v->secondCode == $id;
		});
	}

	public function  getListData()
	{

		return ArrayHelper::map($this->data, 'secondCode', 'secondCodeValue');
	}


    /**
     * 调用静态方法
     * @param string|null $subject
     * @param string|null $grade
     * @param string|null $department
     * @return LoadTextbookVersionModel
     */
	public static function model($subject = null, $grade = null, $department = null)
	{
		$staticModel = new self($subject, $grade, $department);
		return $staticModel;
	}

}