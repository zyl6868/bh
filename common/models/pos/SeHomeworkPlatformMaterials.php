<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_homework_platform_materials".
 *
 * @property integer $id
 * @property string $materialId
 */
class SeHomeworkPlatformMaterials extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homework_platform_materials';
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
            [['id', 'materialId'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'materialId' => 'Material ID',
        ];
    }

    /**
     * @inheritdoc
     * @return SeHomeworkPlatformMaterialsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkPlatformMaterialsQuery(get_called_class());
    }

    /**
     * 根据作业id查询 资料id
     * wgl
     * @param string $homeworkID 作业id
     * @return array|SeHomeworkPlatformMaterials[]
     */
    public static function getHomeworkPlatformMaterialsIdAll($homeworkID)
    {
        return self::find()->where(['id' => $homeworkID])->select('materialId')->asArray()->all();
    }

}
