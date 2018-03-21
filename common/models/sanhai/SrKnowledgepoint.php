<?php

namespace common\models\sanhai;

use common\components\WebDataKey;
use Yii;

/**
 * This is the model class for table "sr_knowledgepoint".
 *
 * @property integer $kid
 * @property string $pid
 * @property string $kpointname
 * @property string $subject
 * @property string $grade
 * @property string $isDelete
 * @property string $remark
 * @property string $showLevel
 * @property string $orderNumber
 */
class SrKnowledgepoint extends SanhaiActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sr_knowledgepoint';
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
            [['kid'], 'required'],
            [['kid','showLevel','orderNumber'], 'integer'],
            [['pid', 'subject', 'grade'], 'string', 'max' => 20],
            [['kpointname'], 'string', 'max' => 300],
            [['isDelete'], 'string', 'max' => 2],
            [['remark'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kid' => 'Kid',
            'pid' => 'Pid',
            'kpointname' => 'Kpointname',
            'subject' => '科目id',
            'grade' => '学部，学段',
            'isDelete' => 'Is Delete',
            'remark' => 'Remark',
            'showLevel' => '知识点等级',
            'orderNumber' => '排序'
        ];
    }

    /**
     * @inheritdoc
     * @return SrKnowledgepointQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SrKnowledgepointQuery(get_called_class());
    }

    /**
     * 查询知识点缓存
     * @param string $subjectID
     * @param string $departmentID
     * @return array|SrKnowledgepoint[]
     */
    public static function getKnowledgePointData(string $subjectID,string $departmentID){
        return SrKnowledgepoint::find()->where(['subject' => $subjectID, 'grade' => $departmentID, 'isDelete' => 0])->select('kid,pid,kpointname,subject,grade')->orderBy('orderNumber')->limit(10000)->all();
    }

    /**
     * 查询知识点缓存
     * @param string $subjectID
     * @param string $departmentID
     * @return array|SrKnowledgepoint[]|mixed
     */
    public static function getKnowledgePointData_Cache(string $subjectID,string $departmentID){
        $cache = Yii::$app->cache;
        $key = WebDataKey::GET_KNOWLEDGE_POINT_CACHE_KEY . $subjectID .'_'.$departmentID;
        $result = $cache->get($key);
        if($result === false) {
            $result = self::getKnowledgePointData($subjectID,$departmentID);
            $cache->set($key,$result,3600);
        }
        return $result;

    }
}
