<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_schlHomMsg".
 *
 * @property integer $id
 * @property string $title
 * @property string $examId
 * @property string $receiverType
 * @property string $sendWay
 * @property string $rankingChg
 * @property string $weakPoint
 * @property string $addContent
 * @property string $creator
 * @property string $isSend
 * @property string $isDelete
 * @property string $creatTime
 * @property string $classId
 * @property string $scope
 * @property string $reference
 * @property string $subjectId
 * @property string $kids
 * @property string $urls
 */
class SeSchlHomMsg extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_schlHomMsg';
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
     * @return SeSchlHomMsgQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeSchlHomMsgQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['addContent'], 'string'],
            [['title', 'weakPoint'], 'string', 'max' => 300],
            [['examId'], 'string', 'max' => 30],
            [['receiverType', 'sendWay', 'rankingChg', 'creator', 'isSend', 'isDelete', 'creatTime', 'classId', 'scope', 'reference', 'subjectId'], 'string', 'max' => 20],
            [['kids'], 'string', 'max' => 50],
            [['urls'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '短信id',
            'title' => '短信标题',
            'examId' => '考试id',
            'receiverType' => '收件人身份(数据字典 1学生 2家长)',
            'sendWay' => '发送方式(数据字段 1短息 2站内信)',
            'rankingChg' => '本班整体名次及其变化',
            'weakPoint' => '知识盲点',
            'addContent' => '补充内容',
            'creator' => '创建人',
            'isSend' => '是否发送',
            'isDelete' => '是否删除',
            'creatTime' => '创建时间',
            'classId' => '班级id',
            'scope' => '1全部,0部分',
            'reference' => '相关性 1考试反馈 2日常表现 3通知 4作业 5 藤条棍考试， 6藤条棍作业 ',
            'subjectId' => '科目id',
            'kids' => '知识点',
            'urls' => 'Urls',
        ];
    }
}
