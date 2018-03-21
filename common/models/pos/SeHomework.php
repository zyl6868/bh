<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_homework".
 *
 * @property integer $id
 * @property string $uploadTime
 * @property string $isDelete
 * @property string $subjectId
 * @property string $provience
 * @property string $city
 * @property string $country
 * @property string $gradeId
 * @property string $version
 * @property string $knowledgeId
 * @property string $name
 * @property string $getType
 * @property string $author
 * @property string $homeworkDescribe
 * @property string $homeworkType
 * @property string $gutter
 * @property string $secret
 * @property string $secretContent
 * @property string $secretCk
 * @property string $mainTitle
 * @property string $mainContent
 * @property string $mainTitleCk
 * @property string $subTitle
 * @property string $subTitleCk
 * @property string $subContent
 * @property string $info
 * @property string $infoContent
 * @property string $infoCk
 * @property string $scope
 * @property string $examTime
 * @property string $studentInput
 * @property string $studentInputContent
 * @property string $studentInputCk
 * @property string $attentionContent
 * @property string $attention
 * @property string $attentionCk
 * @property string $performance
 * @property string $creator
 * @property string $status
 * @property string $deadlineTime
 * @property string $classID
 * @property string $isHaveCrossCheck
 * @property string $sendNotDone
 */
class SeHomework extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_homework';
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
     * @return SeHomeworkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeHomeworkQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['info', 'scope', 'attention'], 'string'],
            [['uploadTime'], 'string', 'max' => 30],
            [['isDelete', 'provience', 'city', 'country', 'gradeId', 'version', 'creator'], 'string', 'max' => 50],
            [['subjectId', 'isHaveCrossCheck'], 'string', 'max' => 100],
            [['knowledgeId', 'secretContent', 'mainTitle', 'mainContent', 'subTitle', 'subContent', 'infoContent', 'studentInputContent', 'attentionContent'], 'string', 'max' => 300],
            [['name'], 'string', 'max' => 200],
            [['getType', 'sendNotDone'], 'string', 'max' => 5],
            [['author', 'homeworkType', 'gutter', 'secret', 'secretCk', 'mainTitleCk', 'subTitleCk', 'infoCk', 'examTime', 'studentInputCk', 'attentionCk', 'performance', 'status', 'deadlineTime', 'classID'], 'string', 'max' => 20],
            [['homeworkDescribe', 'studentInput'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uploadTime' => '上传时间',
            'isDelete' => '是否删除0：否1：是默认0',
            'subjectId' => '科目id',
            'provience' => '省',
            'city' => '市',
            'country' => '区县',
            'gradeId' => '年级id',
            'version' => '版本',
            'knowledgeId' => '知识点',
            'name' => '作业名称',
            'getType' => '作业组织类型（0上传，1组卷）',
            'author' => '作者（数据字典 0本校 1教师）',
            'homeworkDescribe' => ' 作业简介',
            'homeworkType' => '作业类型（数据字典 1标准 2小测验 3作业 4自定义）',
            'gutter' => '装订线',
            'secret' => '绝密启用前',
            'secretContent' => 'Secret Content',
            'secretCk' => 'Secret Ck',
            'mainTitle' => '主标题',
            'mainContent' => 'Main Content',
            'mainTitleCk' => 'Main Title Ck',
            'subTitle' => '副标题',
            'subTitleCk' => 'Sub Title Ck',
            'subContent' => 'Sub Content',
            'info' => '考生信息',
            'infoContent' => 'Info Content',
            'infoCk' => 'Info Ck',
            'scope' => '考试范围',
            'examTime' => '考试时间',
            'studentInput' => '考生输入',
            'studentInputContent' => 'Student Input Content',
            'studentInputCk' => 'Student Input Ck',
            'attentionContent' => 'Attention Content',
            'attention' => '注意事项',
            'attentionCk' => 'Attention Ck',
            'performance' => 'Performance',
            'creator' => '创建人',
            'status' => '作业状态(0临时，1正式)',
            'deadlineTime' => '交作业截至时间',
            'classID' => '班级id',
            'isHaveCrossCheck' => '是否交叉判卷',
            'sendNotDone' => '发送未完成作业通知',
        ];
    }
}
