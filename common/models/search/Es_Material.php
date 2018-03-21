<?php
namespace common\models\search;
use common\elasticsearch\es_ActiveRecord;
use common\models\Material;
use yii\elasticsearch\Query;

/**
 * This is the model class for table "material".
 *
 * @property integer $id
 * @property string $name
 * @property string $matType
 * @property string $provience
 * @property string $city
 * @property string $country
 * @property string $gradeid
 * @property string $subjectid
 * @property string $versionid
 * @property string $kid
 * @property string $chapterId
 * @property string $contentType
 * @property string $school
 * @property string $tags
 * @property string $creator
 * @property string $createTime
 * @property string $updateTime
 * @property string $matDescribe
 * @property string $isDelete
 * @property string $url
 * @property string $disabled
 * @property string $readNum
 * @property string $downNum
 * @property string $chapKids
 * @property string $groupId
 * @property string $access
 * @property integer $favoriteNum
 * @property string $department
 * @property integer $isBoutique
 * @property string $image
 * @property integer $price
 */
class Es_Material extends es_ActiveRecord
{
    use Material;
    public function attributes()
    {
        return [
            'id',
            'name',
            'matType',
            'provience',
            'city',
            'country',
            'gradeid',
            'subjectid',
            'versionid',
            'kid',
            'chapterId',
            'contentType',
            'school',
            'tags',
            'creator',
            'createTime',
            'updateTime',
            'matDescribe',
            'isDelete',
            'url',
            'disabled',
            'readNum',
            'downNum',
            'chapKids',
            'groupId',
            'access',
            'favoriteNum',
            'department',
            'isplatform',
            'isBoutique',
            'image',
            'price'
        ];
    }

    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * @return string
     */
    public static function index()
    {
        return 'materials';
    }

    /**
     * @return string the name of the type of this record.
     */
    public static function type()
    {
        return 'material';
    }

    /**
     * 前台搜索
     * @return Query
     */
    public static function forFrondSearch()
    {
        return self::find()->where(['isDelete'=>0]);
    }
}