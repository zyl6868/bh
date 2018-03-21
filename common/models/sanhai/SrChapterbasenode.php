<?php

namespace common\models\sanhai;

use Yii;

/**
 * This is the model class for table "sr_chapterbasenode".
 *
 * @property integer $cid
 * @property string $pid
 * @property string $subject
 * @property string $grade
 * @property string $version
 * @property string $chaptername
 * @property string $isDelete
 * @property string $schoolLevel
 * @property string $schoolLength
 * @property string $remark
 * @property string $session
 * @property string $bookAtt
 * @property string $fascicule
 * @property string $image
 */
class SrChapterbasenode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sr_chapterbasenode';
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
            [['cid'], 'required'],
            [['cid'], 'integer'],
            [['pid', 'subject', 'grade', 'version', 'schoolLevel', 'schoolLength', 'session', 'bookAtt', 'fascicule'], 'string', 'max' => 20],
            [['chaptername'], 'string', 'max' => 100],
            [['isDelete'], 'string', 'max' => 2],
            [['remark'], 'string', 'max' => 200],
            [['image'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => 'Cid',
            'pid' => 'Pid',
            'subject' => 'Subject',
            'grade' => 'Grade',
            'version' => 'Version',
            'chaptername' => 'Chaptername',
            'isDelete' => 'Is Delete',
            'schoolLevel' => 'School Level',
            'schoolLength' => 'School Length',
            'remark' => 'Remark',
            'session' => 'Session',
            'bookAtt' => 'Book Att',
            'fascicule' => 'Fascicule',
            'image' => 'Image',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\sanhai\SrChapterbasenodeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\sanhai\SrChapterbasenodeQuery(get_called_class());
    }


    /**
     * 根据学部科目版本　获取响应的分册
     * @param int $subjectId  科目
     * @param int $departmentId　　学部
     * @param int $versionId　　版本
     * @return array|\common\models\sanhai\SrChapterbasenode[]
     */
    public static function tomeAll(int $subjectId, int $departmentId, int $versionId )
    {
        return self::find()->where(['subject'=>$subjectId,'schoolLevel'=>$departmentId,'version'=>$versionId ,'pid'=>'0'])->select('cid,chaptername,image')->all();
    }
}
