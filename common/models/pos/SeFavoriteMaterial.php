<?php

namespace common\models\pos;

use common\helper\DateTimeHelper;
use common\models\sanhai\SrMaterial;
use common\models\search\Es_Material;
use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "se_favoriteMaterial".
 *
 * @property integer $collectId
 * @property integer $groupId
 * @property integer $favoriteId
 * @property integer $matType
 * @property integer $userId
 * @property integer $createTime
 * @property integer $isDelete
 * @property integer $disabled
 */
class SeFavoriteMaterial extends PosActiveRecord
{
    const ISDELETE = 0;      //是否删除
    const DESABLED = 0;      //是否禁用

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_favoriteMaterial';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_school');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groupId', 'favoriteId', 'matType', 'userId', 'createTime', 'isDelete', 'disabled'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'collectId' => '收藏id',
            'groupId' => '资源所属的分组id',
            'favoriteId' => '收藏内容id',
            'matType' => '收藏类型(1教案，2讲义，3视频,4 资料，5 ppt，6 素材)',
            'userId' => '收藏者',
            'createTime' => '创建时间',
            'isDelete' => '是否已删除',
            'disabled' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
        ];
    }

    /**
     * @inheritdoc
     * @return SeFavoriteMaterialQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeFavoriteMaterialQuery(get_called_class());
    }


    /**
     * 个人收藏课件数不能大于1000
     * @param $userId
     * @return bool
     */
    public static function getTotalMaterialNum($userId)
    {

        //同一个学科学段下，收藏课件个数不能大于1000
        $favoriteGroupIdList = SeFavoriteMaterialGroup::find()->where(['userId' => $userId])->select('groupId')->column();
        $maxFavoriteNum = SeFavoriteMaterial::find()->where(['groupId' => $favoriteGroupIdList])->count();
        return $maxFavoriteNum;
    }

    /**
     * 收藏课件操作
     * @param $srMaterial
     * @param $favoriteId
     * @param $userId
     * @return array|bool|SeFavoriteMaterial|null
     */
    public static function materialCollect($srMaterial, $favoriteId, $userId)
    {

        //判断是否已经收藏
        $favoriteModel = SeFavoriteMaterial::find()->where(['favoriteId' => $favoriteId, 'userId' => $userId])->limit(1)->one();
        if ($favoriteModel) {
            return false;
        }

        $transaction =  self::getDb() ->beginTransaction();
        try {

            //是否存在该学段，科目下的默认组
            $favoriteGroupModel = SeFavoriteMaterialGroup::find()->where(['userId' => $userId, 'subjectId' => $srMaterial->subjectid, 'department' => $srMaterial->department, 'groupType' => 0])->limit(1)->one();
            if (empty($favoriteGroupModel)) {
                $favoriteGroupModel = new SeFavoriteMaterialGroup();
                $favoriteGroupModel->userId = $userId;
                $favoriteGroupModel->subjectId = $srMaterial->subjectid;
                $favoriteGroupModel->department = (int)$srMaterial->department;
                $favoriteGroupModel->groupName = '我的收藏';
                $favoriteGroupModel->groupType = 0;
                $favoriteGroupModel->createTime = DateTimeHelper::timestampX1000();
                $favoriteGroupModel->save(false);
            }

            //收藏操作
            $favoriteModel = new SeFavoriteMaterial();
            $favoriteModel->groupId = $favoriteGroupModel->groupId;
            $favoriteModel->favoriteId = $favoriteId;
            $favoriteModel->matType = $srMaterial->matType;
            $favoriteModel->userId = $userId;
            $favoriteModel->createTime = DateTimeHelper::timestampX1000();
            if ($favoriteModel->save(false)) {
                //文件收藏总数加1
                /** @var SrMaterial $materialModel */
                $materialModel = SrMaterial::find()->where(['id' => $favoriteId])->limit(1)->one();
                if (!empty($materialModel)) {
                    $materialModel->favoriteNum = $materialModel->favoriteNum + 1;
                    $materialModel->save(false);
                }
                //ES文件收藏总数加1
                /** @var Es_Material $esMaterialModel */
                $esMaterialModel = Es_Material::find()->where(['id' => $favoriteId])->limit(1)->one();
                if (!empty($esMaterialModel)) {
                    $esMaterialModel->favoriteNum = $esMaterialModel->favoriteNum + 1;
                    $esMaterialModel->update(false);
                }

            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
        return $favoriteModel;
    }


    /**
     * 取消文件收藏的操作
     * @param $favoriteId
     * @param $userId
     * @return bool
     * @throws \Exception
     */
    public static function materialCancelCollect($favoriteId, $userId)
    {
        $transaction = Yii::$app->db_school->beginTransaction();
        try {
            $favoriteMaterial = SeFavoriteMaterial::find()->where(['favoriteId' => $favoriteId, 'userId' => $userId])->limit(1)->one();
            if (empty($favoriteMaterial)) {
                return false;
            }
            if ($favoriteMaterial->delete()) {
                //本地文件收藏总数减1
                $materialModel = SrMaterial::find()->where(['id' => $favoriteId])->limit(1)->one();
                if ($materialModel->favoriteNum <= 0) {
                    $materialModel->favoriteNum = 0;
                } else {
                    $materialModel->favoriteNum = $materialModel->favoriteNum - 1;
                }
                $materialModel->save(false);

                //ES文件收藏总数减1
                $esMaterialModel = Es_Material::find()->where(['id' => $favoriteId])->limit(1)->one();
                if ($esMaterialModel->favoriteNum <= 0) {
                    $esMaterialModel->favoriteNum = 0;
                } else {
                    $esMaterialModel->favoriteNum = $esMaterialModel->favoriteNum - 1;
                }
                $esMaterialModel->update(false);
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }


    /**
     * 加载整个页面判断每个课件是否被收藏了
     * @param $materialIdArray
     * @return array
     */
    public static function getMaterialIsCollected($materialIdArray, $userId)
    {
        $isCollectedArray = [];
        $collectedList = SeFavoriteMaterial::find()->where(['favoriteId' => $materialIdArray, 'userId' => $userId, 'isDelete' => 0])->select('')->asArray()->all();

        foreach ($collectedList as $v) {
            array_push($isCollectedArray, $v['favoriteId']);
        }
        return $isCollectedArray;
    }

    /**
     * 课件移动到其他分组
     * @param $userId
     * @param $collectArray
     * @param $groupId
     * @return bool
     */
    public static function moveGroup($userId, $collectArray, $groupId)
    {
        if (!is_array($collectArray)) {
            return false;
        }
        foreach ($collectArray as $v) {
            SeFavoriteMaterial::updateAll(['groupId' => $groupId], ['collectId' => $v, 'userId' => $userId]);
        }
        return true;
    }

    /**
     * 删除课件并且收藏数减1
     * @param $collectArray
     * @param $userId
     * @return bool
     * @throws \Exception
     */
    public static function delFavMaterial($collectArray, $userId)
    {
        $transaction = Yii::$app->db_school->beginTransaction();
        try {
            if (!is_array($collectArray)) {
                return false;
            }
            foreach ($collectArray as $value) {
                $favMaterialResult = SeFavoriteMaterial::find()->where(['collectId' => $value, 'userId' => $userId])->limit(1)->one();
                $srMaterialModel = SrMaterial::find()->where(['id' => $favMaterialResult->favoriteId])->limit(1)->one();
                if ($srMaterialModel->favoriteNum <= 0) {
                    $srMaterialModel->favoriteNum = 0;
                } else {
                    $srMaterialModel->favoriteNum = $srMaterialModel->favoriteNum - 1;
                }

                $srMaterialModel->save(false);      //课件收藏数减1

                $favMaterialResult->delete();   //删除课件
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }

    /**
     * 获取收藏的课件数
     * @param $userId
     * @return int|string
     */
    public static function favoriteFileNum($userId)
    {
        return SeFavoriteMaterial::find()->where(['userId' => $userId, 'isDelete' => 0])->count();
    }

    /**
     * 查询指定分组下课件份数
     * @param integer $groupId
     * @param integer $userId
     * @return int|string
     */
    public static function getGroupMaterialCount(int $groupId,int $userId)
    {
        if (intval($userId) <= 0 || intval($groupId) <= 0) {
            return null;
        }

        $data = SeFavoriteMaterial::find()->where(['groupId' => $groupId, 'userId' => $userId, 'isDelete' => self::ISDELETE, 'disabled' => self::DESABLED])->count();

        return $data;
    }

    /**
     * 各个分组下的数量
     * @param $groupIdArray
     * @param $userId
     * @return array|SeFavoriteMaterial[]
     */
    public static function everyGroupMaterialCount($groupIdArray, $userId)
    {
        $everyGroupMaterialCount = SeFavoriteMaterial::find()->where([ 'userId' => $userId, 'isDelete' => self::ISDELETE, 'disabled' => self::DESABLED])->andWhere(['in','groupId',$groupIdArray])->groupBy('groupId')->select('groupId,COUNT(*) collectNumber')->asArray()->indexBy('groupId')->all();
        return $everyGroupMaterialCount;
    }

}
