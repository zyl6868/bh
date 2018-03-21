<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_paper".
 *
 * @property integer $id
 * @property string $uploadTime
 * @property string $isDelete
 * @property string $schoolLevel
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
 * @property string $paperDescribe
 * @property string $paperType
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
 * @property string $disabled
 * @property string $ispass
 */
class SePaper extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_paper';
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
     * @return SePaperQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SePaperQuery(get_called_class());
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
            [['isDelete', 'provience', 'city', 'country', 'gradeId', 'version', 'name', 'creator'], 'string', 'max' => 50],
            [['schoolLevel', 'author', 'paperType', 'gutter', 'secret', 'secretCk', 'mainTitleCk', 'subTitleCk', 'infoCk', 'examTime', 'studentInputCk', 'attentionCk', 'performance', 'status'], 'string', 'max' => 20],
            [['subjectId'], 'string', 'max' => 100],
            [['knowledgeId', 'paperDescribe', 'studentInput'], 'string', 'max' => 500],
            [['getType'], 'string', 'max' => 5],
            [['secretContent', 'mainTitle', 'mainContent', 'subTitle', 'subContent', 'infoContent', 'studentInputContent', 'attentionContent'], 'string', 'max' => 300],
            [['disabled', 'ispass'], 'string', 'max' => 2]
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
            'schoolLevel' => '学部',
            'subjectId' => '科目id',
            'provience' => '省',
            'city' => '市',
            'country' => '区县',
            'gradeId' => '年级id',
            'version' => '版本',
            'knowledgeId' => '知识点',
            'name' => '试卷名称',
            'getType' => '试卷组织类型（0上传，1组卷）',
            'author' => '作者（数据字典 0本校 1教师）',
            'paperDescribe' => ' 试卷简介',
            'paperType' => '试卷类型（数据字典 1标准 2小测验 3作业 4自定义）',
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
            'status' => '试卷状态(0临时，1正式)',
            'disabled' => '是否已经禁用 0：未禁用/激活/解禁/审核通过  1：已经禁用',
            'ispass' => '是否通过审核 0:未审核，1：以审核，2：审核未通过',
        ];
    }


    /**
     * 查询试卷
     * @param integer $userId  用户id
     * @param integer $subjectId  科目id
     * @param array $gradeList  指定学部的年级列表
     * @param integer $getType  试卷类型 0：纸质 1：电子
     * @return SePaperQuery
     */
    public static function getPaperModel($userId, $subjectId, $gradeList, $getType){
        $paperModel = self::find()->where(['creator'=>$userId, 'subjectId'=>$subjectId, 'gradeId'=>$gradeList, 'status'=>1, 'isDelete'=>0]);
        if($getType != null){
            $paperModel->andWhere(['getType'=>$getType]);
        }
        return $paperModel;
    }
}
