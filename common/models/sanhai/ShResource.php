<?php

namespace common\models\sanhai;

use Yii;

/**
 * This is the model class for table "sh_resource".
 *
 * @property string $id
 * @property string $introduce
 * @property string $title
 * @property string $tag
 * @property integer $fileSize
 * @property string $fileMD5
 * @property string $resSource
 * @property string $fileFormat
 * @property integer $fileType
 * @property integer $resType
 * @property integer $browseTotal
 * @property integer $dowTotal
 * @property integer $recommendLevel
 * @property integer $videoCharacter
 * @property string $resFileId
 * @property string $resFileUri
 * @property string $screenImgUri
 * @property string $screenImgId
 * @property string $creatTime
 * @property string $creatorId
 * @property string $syncPar
 * @property integer $deleted
 * @property integer $disabled
 * @property string $playTime
 */
class ShResource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sh_resource';
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
            [['id'], 'required'],
            [['id', 'fileSize', 'fileType', 'resType', 'browseTotal', 'dowTotal', 'recommendLevel', 'videoCharacter', 'creatTime', 'deleted', 'disabled'], 'integer'],
            [['introduce', 'tag'], 'string', 'max' => 1000],
            [['title', 'syncPar'], 'string', 'max' => 200],
            [['fileMD5', 'resFileId', 'screenImgId', 'playTime'], 'string', 'max' => 100],
            [['resSource', 'fileFormat', 'creatorId'], 'string', 'max' => 20],
            [['resFileUri', 'screenImgUri'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'introduce' => 'Introduce',
            'title' => 'Title',
            'tag' => 'Tag',
            'fileSize' => 'File Size',
            'fileMD5' => 'File Md5',
            'resSource' => 'Res Source',
            'fileFormat' => 'File Format',
            'fileType' => 'File Type',
            'resType' => 'Res Type',
            'browseTotal' => 'Browse Total',
            'dowTotal' => 'Dow Total',
            'recommendLevel' => 'Recommend Level',
            'videoCharacter' => 'Video Character',
            'resFileId' => 'Res File ID',
            'resFileUri' => 'Res File Uri',
            'screenImgUri' => 'Screen Img Uri',
            'screenImgId' => 'Screen Img ID',
            'creatTime' => 'Creat Time',
            'creatorId' => 'Creator ID',
            'syncPar' => 'Sync Par',
            'deleted' => 'Deleted',
            'disabled' => 'Disabled',
            'playTime' => 'Play Time',
        ];
    }

    /**
     * @inheritdoc
     * @return ShResourceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShResourceQuery(get_called_class());
    }
}
