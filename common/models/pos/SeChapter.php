<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_chapter".
 *
 * @property integer $cid
 * @property integer $pid
 * @property integer $subject
 * @property integer $grade
 * @property integer $version
 * @property string $chaptername
 * @property integer $isDelete
 * @property string $schoolLevel
 * @property string $schoolLength
 * @property string $remark
 * @property string $session
 */
class SeChapter extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_chapter';
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
     * @return SeChapterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeChapterQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid'], 'required'],
            [['cid', 'pid', 'subject', 'grade', 'version', 'isDelete'], 'integer'],
            [['chaptername', 'schoolLevel', 'schoolLength'], 'string', 'max' => 20],
            [['remark'], 'string', 'max' => 200],
            [['session'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => '章节id',
            'pid' => '父id',
            'subject' => '科目',
            'grade' => '年级',
            'version' => '教材版本',
            'chaptername' => '章节名称',
            'isDelete' => '是否删除，0未删除，1已删除',
            'schoolLevel' => '学部',
            'schoolLength' => '学制',
            'remark' => '备注',
            'session' => '学期，0上学期，1下学期',
        ];
    }
}
