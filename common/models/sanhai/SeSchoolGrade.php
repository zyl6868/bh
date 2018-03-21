<?php

namespace common\models\sanhai;

use common\components\WebDataKey;
use Yii;

/**
 * This is the model class for table "se_schoolGrade".
 *
 * @property integer $gradeId
 * @property string $gradeName
 * @property string $sixThree
 * @property string $fiveFour
 * @property string $fiveThree
 * @property string $xFour
 * @property string $xFive
 * @property string $xSix
 * @property string $schoolDepartment
 */
class SeSchoolGrade extends SanhaiActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_schoolGrade';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sanku');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gradeId'], 'required'],
            [['gradeId'], 'integer'],
            [['gradeName'], 'string', 'max' => 50],
            [['sixThree', 'fiveFour', 'fiveThree'], 'string', 'max' => 2],
            [['xFour', 'xFive', 'xSix'], 'string', 'max' => 3],
            [['schoolDepartment'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gradeId' => '年级id',
            'gradeName' => '年级名称',
            'sixThree' => '六三学制是否存在该年级，0不存在，1：存在',
            'fiveFour' => '五四学制是否存在该年级，0不存在，1：存在',
            'fiveThree' => '五三学制是否存在该年级，0不存在，1：存在',
            'xFour' => '预设该学制，用来判断该学制是否存在该年级',
            'xFive' => '预设该学制，用来判断该学制是否存在该年级',
            'xSix' => '预设该学制，用来判断该学制是否存在该年级',
            'schoolDepartment' => '0：小学部，1:初中部，2：高中部',
        ];
    }

    /**
     * @inheritdoc
     * @return SeSchoolGradeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSchoolGradeQuery(get_called_class());
    }

    /**
     * 根据学部id 获取年级id列表
     * @param integer $departments 学部id
     * @return array|SeSchoolGrade[]
     */
    public static function accordingDepartmentsGetGradeId(int $departments)
    {
        return self::find()->where(['schoolDepartment' => $departments])->select('gradeId')->asArray()->all();
    }
    /**
     * 根据学部id 获取年级id列表缓存
     * @param integer $departments 学部id
     * @return array|SeSchoolGrade[]
     */
    public static function getGradeId_Cache(int $departments)
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::GET_SCHOOL_GRADEID_CACHE_KEY . $departments;
        $result = $cache->get($key);
        if($result === false) {
            $result = self::accordingDepartmentsGetGradeId($departments);
            $cache->set($key,$result,3600);
        }
        return $result;

    }

    /**
     * 根据年级id获取学校学段
     * @param integer $gradeId 年级id
     * @return array|SeSchoolGrade|null
     */
    public static function accordingToGradeIdGetSchoolDepartment(int $gradeId)
    {
        return self::find()->where(['gradeId'=>$gradeId])->select('schoolDepartment')->limit(1)->one();
    }

    /**
     * 根据年级id获取学校学段缓存
     * @param integer $gradeId 年级id
     * @return array|SeSchoolGrade|null
     */
    public static function getSchoolDepartment_Cache(int $gradeId)
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::GET_SCHOOL_DEPARTMENT_CACHE_KEY . $gradeId;
        $result = $cache->get($key);
        if($result === false) {
            $result = self::accordingToGradeIdGetSchoolDepartment($gradeId);
            $cache->set($key,$result,3600);
        }
        return $result;
    }

    /**
     * 获取年级名称
     * @param array $gradeId 班级id
     * @return array
     */
    public static function getGradeName(array $gradeId)
    {
        $gradeNameArr = [];
        $gradeInfo = self::find()->select('gradeId,gradeName')->where(['gradeId'=>$gradeId])->all();
        foreach ($gradeInfo as $v){
            $gradeNameArr[$v->gradeId] = $v->gradeName;
        }
        return $gradeNameArr;
    }

}
