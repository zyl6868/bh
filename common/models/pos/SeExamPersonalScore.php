<?php

namespace common\models\pos;

use Yii;

/**
 * This is the model class for table "se_exam_personalScore".
 *
 * @property integer $perScoreId 个人成绩主键id
 * @property integer $classExamId 班级考试id
 * @property integer $userId 用户id（用户表中）
 * @property string $sub10010 语文
 * @property string $sub10011 数学
 * @property string $sub10012 英语
 * @property string $sub10013 生物
 * @property string $sub10014 物理
 * @property string $sub10015 化学
 * @property string $sub10016 地理
 * @property string $sub10017 历史
 * @property string $sub10018 政治
 * @property string $sub10019 品德与生活
 * @property string $sub10020 美术
 * @property string $sub10021 音乐
 * @property string $sub10022 体育
 * @property string $sub10023 信息技术
 * @property string $sub10024 法制
 * @property string $sub10025 综合实践
 * @property string $sub10026 科学
 * @property string $sub10029 理综
 * @property string $sub10030 品德与社会
 * @property string $sub10031 心理
 * @property string $sub10032 健康
 * @property string $sub10033 校本课程
 * @property string $sub10034 地方课程
 * @property string $sub10035 劳动与技术
 * @property string $sub10036 后勤
 * @property string $sub10037 学法指导
 * @property string $sub10038 写字
 * @property string $sub10039 蒙古语文
 * @property string $sub10040 汉语
 * @property string $sub10041 俄语
 * @property string $sub10042 书法
 * @property string $sub10043 安全
 * @property string $sub10044 通用技术
 * @property string $sub10045 研究性学习
 * @property string $sub10046 语法
 * @property string $sub10047 常识
 * @property string $sub10048 阅读
 * @property string $totalScore 总分
 * @property integer $createTime 创建时间
 * @property integer $updateTime 更新时间
 */
class SeExamPersonalScore extends PosActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'se_exam_personalScore';
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
            [['classExamId', 'userId', 'createTime', 'updateTime'], 'integer'],
            [['sub10010', 'sub10011', 'sub10012', 'sub10013', 'sub10014', 'sub10015', 'sub10016', 'sub10017', 'sub10018', 'sub10019', 'sub10020', 'sub10021', 'sub10022', 'sub10023', 'sub10024', 'sub10025', 'sub10026', 'sub10029', 'sub10030', 'sub10031', 'sub10032', 'sub10033', 'sub10034', 'sub10035', 'sub10036', 'sub10037', 'sub10038', 'sub10039', 'sub10040', 'sub10041', 'sub10042', 'sub10043', 'sub10044', 'sub10045', 'sub10046', 'sub10047', 'sub10048', 'totalScore'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'perScoreId' => '个人成绩主键id',
            'classExamId' => '班级考试id',
            'userId' => '用户id（用户表中）',
            'sub10010' => '语文',
            'sub10011' => '数学',
            'sub10012' => '英语',
            'sub10013' => '生物',
            'sub10014' => '物理',
            'sub10015' => '化学',
            'sub10016' => '地理',
            'sub10017' => '历史',
            'sub10018' => '政治',
            'sub10019' => '品德与生活',
            'sub10020' => '美术',
            'sub10021' => '音乐',
            'sub10022' => '体育',
            'sub10023' => '信息技术',
            'sub10024' => '法制',
            'sub10025' => '综合实践',
            'sub10026' => '科学',
            'sub10029' => '思想品德',
            'sub10030' => '品德与社会',
            'sub10031' => '心理',
            'sub10032' => '健康',
            'sub10033' => '校本课程',
            'sub10034' => '地方课程',
            'sub10035' => '劳动与技术',
            'sub10036' => '后勤',
            'sub10037' => '学法指导',
            'sub10038' => '写字',
            'sub10039' => '蒙古语文',
            'sub10040' => '汉语',
            'sub10041' => '俄语',
            'sub10042' => '书法',
            'sub10043' => '安全',
            'sub10044' => '通用技术',
            'sub10045' => '研究性学习',
            'sub10046' => '语法',
            'sub10047' => '常识',
            'sub10048' => '阅读',
            'totalScore' => '总分',
            'createTime' => '创建时间',
            'updateTime' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     * @return SeExamPersonalScoreQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeExamPersonalScoreQuery(get_called_class());
    }

}
