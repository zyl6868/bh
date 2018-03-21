<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 15-7-13
 * Time: 下午1:17
 */

namespace common\components;
class WebDataKey
{

    const WEB_VIEW_CACHE = "WEB_VIEW_CACHE";

    /**
     * 用户cacheKey
     */
    const  USER_CACHE_KEY = "user_data_cache_userId";
    /**
     *班级cacheKey
     */
    const  CLASS_CACHE_KEY = "class_data_cache_classId";

    /**
     * 学校cacheKey
     */
    const  SCHOOL_CACHE_KEY = "school_data_cache_schoolId";

    /**
     *
     */
    const  TEACHER_GROUP_CACHE_KEY = "teagroup_data_cache_teagroupId";

    /**
     * 年级cacheKey
     */
    const  GRADE_CACHE_KEY = "grade_data_cache_schoolId";

    /**
     * 年级cacheKey
     */
    const  SHOWTYPE_CACHE_KEY = "question_show_type_data_cache";

    /**
     * 签到cacheKey
     */
    const USER_IS_SIGN = "user_is_sign_cache_userId";

    /**
     * 获取题目题号的cacheKey
     */
    const QUESTION_NO_OBJECT_KEY = "managetask_cache_question_number";


    /**
     * 获取题目题号的cacheKey
     */
    const QUESTION_HOMEWORK_QUESTION_LIST = "question_homework_question_list";

    /**
     * 学校简介页面的cacheKey
     */
    const WEB_SCHOOL_SUMMARY_CACHE_KEY = "WEB_SCHOOL_SUMMARY_VIEW_BY_";

    /**
     * 题目查询cacheKey
     */
    const  QUESTION_CHILDREN_LIST_KEY = "question_cache_child_list_by_questionid";

    /**
     * 全文搜索cacheKey
     */
    const  SEARCH_QUESTION_CHILDREN_LIST_KEY = "search_question_child_list_by_questionId";

    /**
     * 通过id获取平台小题列表cacheKey
     */
    const  QUESTION_CHILDREN_PLATFORM_LIST_KEY = "question_cache_platform_child_list_by_questionid";

    /**
     *班级首页 数据统计 cacheKey
     */
    const  WEB_CLASS_VIEW_CACHE_KEY = "WEB_VIEW_CACHE_CLASS_VIEW_BY_";

    /**
     * 班级首页 班级成员 cacheKey
     */
    const WEB_CLASS_VIEW_MEMBER_CACHE_KEY = "WEB_CLASS_VIEW_MEMBER_CACHE_BY_";
    /**
     * 班级首页 班级教师列表 cacheKey
     */
    const WEB_CLASS_VIEW_TEACHER_CACHE_KEY = "WEB_CLASS_VIEW_TEACHER_CACHE_BY_";
    /**
     * 班级首页 班级教师总数 cacheKey
     */
    const WEB_CLASS_COUNT_TEACHER_CACHE_KEY = "WEB_CLASS_COUNT_TEACHER_CACHE_BY_";
    /**
     * 班级首页 班级学生列表 cacheKey
     */
    const WEB_CLASS_VIEW_STUDENT_CACHE_KEY = "WEB_CLASS_VIEW_STUDENT_CACHE_BY_";
    /**
     * 班级首页 班级学生总数 cacheKey
     */
    const WEB_CLASS_COUNT_STUDENT_CACHE_KEY = "WEB_CLASS_COUNT_STUDENT_CACHE_BY_";
    /**
     * 班级 教师班级作业列表学科列表 片段缓存 cacheKey
     */
    const WEB_CLASS_TEACHER_HOMEWORK_CACHE_KEY = "WEB_CLASS_TEACHER_HOMEWORK_CACHE_BY_";

    /**
     * 教师班级作业 详情页作业简介片段缓存 cacheKey
     */
    const WEB_CLASS_WORK_dETAILS_CACHE_KEY = "WEB_CLASS_WORK_DETAILS_CACHE_BY_";
    /**
     * 教师个人中心 我的文件 cacheKey
     */
    const WEB_TEACHER_PERSONAL_CENTER_MY_FILES_CACHE_KEY = "WEB_TEACHER_PERSONAL_CENTER_MY_FILES_VIEW_BY_";

    /**
     * 教师个人中心 我的收藏 cacheKey
     */
    const WEB_TEACHER_PERSONAL_CENTER_MY_FAVORITE_CACHE_KEY = "WEB_TEACHER_PERSONAL_CENTER_MY_FAVORITE_VIEW_BY_";

    const WEB_TEACHER_PERSONAL_STATISTICS_CACHE_KEY = 'WEB_TEACHER_PERSONAL_STATISTICS_CACHE_KEY';

    /**
     * 教师个人中心 我的作业 cacheKey
     */
    const WEB_TEACHER_PERSONAL_CENTER_MY_HOMEWORK_CACHE_KEY = "WEB_TEACHER_PERSONAL_CENTER_MY_HOMEWORK_VIEW_BY_";

    /**
     * 学生个人中心 我的作业 cacheKey
     */
    const WEB_STUDENT_MY_CENTER_MY_HOMEWORK_CACHE_KEY = "WEB_STUDENT_MY_CENTER_MY_HOMEWORK_VIEW_BY_";

    /**
     *  subjectModel  根据学部获取科目缓存
     */
    const SUBJECT_DATA_BY_DEPARTMENT_KEY = 'subject_data_by_department';

    /**
     *SeUserinfo 获取用户所在班级
     */
    const CLASS_INFO_DATA_BY_USERID_KEY = "class_info_data_by_userID";

    /**
     * SeHomeworkRel  获取已答学生数
     */
    const HOMEWORK_ANSWER_INFO_COUNT_KEY = "homework_answer_info_count";

    /**
     * QuestionInfoHelper
     *   题目详细
     */
    const HOMEWORK_GET_QUESTION_DATA_BY_ID_KEY = "homework_get_question_data_by_id";

    /**
     *学生作业答题页面缓存
     */
    const WEB_STUDENT_ANSWERING_QUESTION_LIST_KEY = "web_student_answering_question_list";
    /**
     *   SeHomeworkRel  获取已批改学生数
     */
    const IS_CHECKED_STUDENT_COUNT_KEY = "is_checked_student_count";

    /**
     *判断用户是否在班级中
     */
    const USER_IS_IN_CLASS_KEY = "user_is_in_class";

    /**
     *判断用户是否在教研组中
     */
    const USER_IS_IN_GROUP_KEY = "user_is_in_group";

    /**
     *注册发送手机验证码 cacheKey
     */
    const REGISTER_SEND_VERIFYCODE = "register_send_verifycode";

    /**
     *找回密码 cacheKey
     */
    const RESETPHONEMESSAGE = "RESETPHONEMESSAGE_";

    /**
     * 平台作业分配给老师的所有记录
     */
    const PLATFORM_HOMEWORK_TEACHER = 'paltform_homework_teacher';
    /**
     * 作业回答总人数
     */
    const FINISH_HOMEWORK_KEY = 'finish_homework_key';
    /**
     *学生所在当前梯队前面有多少人
     */
    const OVER_HOMEWORK_NOWUSER = 'over_homework_nowuser';

    /**
     * 学生打完作业后的梯队展示
     */
    const  HOMEWORK_ANSWER_TEAMDATA_SHOW = "homework_answer_teamdata_show";

    /**
     *班级学生人数 cacheKey
     */
    const  CLASS_STUDENT_MEMBER_CACHE_KEY = "class_student_member_data_cache_classId";
    /*
     *科目
     */
    const CLASS_SUBJECT_ID_CACHE_KEY = 'class_subject_id_cache_key';
    /*
     * 学段
     */
    const CLASS_DEPARTMENT_ID_CACHE_KEY = 'class_department_id_cache_key';

    /*
     * 激活人数
     */
    const ACTIVATESUM_CACHE_KEY = 'activateSum_cache_key';
    /*
     * 学校注册总人数
     */
    const PEOPLESUM_CACHE_KEY = 'peopleSum_cache_key';
    /*
     * 家长激活人数
     */
    const HOMEREGISTERSUM_CACHE_KEY = 'homeRegisterSum_cache_key';
    /*
     * 作业使用统计
     */
    const HOMEWORKUSESUM_CACHE_KEY = 'homeworkuseSum_cache_key';

    /*
     * 课件分组下的课件数
     */
    const  GROUP_MATERAIL_NUM_CACHE_KEY = 'group_material_num_cache_key';

    /*
     * 学校短板统计
     */
    const SCHOOL_SHORTBOARD_CACHE_KEY = 'school_shortboard_cache_key';

    /**
     * 班级班主任
     */
    const CLASS_ADVISER_CACHE_KEY = 'class_adviser_class_id';

    /**
     * 班级教师列表
     */
    const CLASS_TEACHER_LIST_CACHE_KEY = 'class_teacher_list_class_id';

    /**
     * 班级学生列表
     */

    const CLASS_STUDENT_LIST_CACHE_KEY = 'class_student_list_class_id';

    /**
     * 页面顶导 通知数字
     */
    const TOP_NAV_MSG_NUM_CACHE_KEY = 'top_nav_msg_num_user_id';


    /**
     *查询所有学部
     */
    const ALL_DEPARTMENT_CACHE_KEY = 'all_department_cache_key';

    /**
     *答疑回答的内容
     */
    const ANSWER_DETAILS_CACHE_KEY = 'answer_details_cache_key';

    /**
     *答疑同问的人
     */
    const ANSWER_ALSO_ASK_CACHE_KEY = 'answer_also_ask_cache_key';

    /**
     * 答疑答案数缓存key
     */
    const ANSWER_QUESTION_COUNT_CACHE_KEY = 'answer_question_count_cache_key';
    /**
     * 学生个人作业优秀率统计 缓存key
     */
    const STUDENT_PERSON_HOMEWORK_PROFICIENCY_OF_STATISTICAL_CACHE_KEY = 'student_person_homework_proficiency_of_statistical_cache_key';

    /**
     * 学生作业未完成作业
     */
    const STUDENT_PERSON_HOMEWORK_UNFINISHED_CACHE_KEY = 'student_person_homework_unfinished_cache_key';

    /**
     * 学生作业已完成作业
     */
    const STUDENT_PERSON_HOMEWORK_FINISH_CACHE_KEY = 'student_person_homework_finish_cache_key';
    /**
     * 班级作业总数
     */
    const CLASS_HOMEWORK_MEMBER_CACHE_KEY = 'class_homework_member_cache_key';
    /**
     * 班级作业已截止总数
     */
    const CLASS_DEADLINE_TIME_HOMEWORK_MEMBER_CACHE_KEY = 'class_deadline_time_homework_member_cache_key';
    /**
     * 班级答疑总数
     */
    const CLASS_ANSWER_ALL_COUNT_CACHE_KEY = 'class_answer_all_count_cache_key';
    /**
     * 班级已解决答疑总数
     */
    const CLASS_RESOLVED_ANSWER_COUNT_CACHE_KEY = 'class_resolved_answer_count_cache_key';
    /**
     * 班级文件总数
     */
    const CLASS_FILE_COUNT_CACHE_KEY = 'class_file_count_cache_key';
    /**
     * 班级文件阅读总数
     */
    const CLASS_READ_COUNT_CACHE_KEY = 'class_read_count_cache_key';
    /**
     * 班级文件阅读总数
     */
    const PAPER_QUES_TYPE_RLTS_LIST_CACHE_KEY = 'according_department_and_subject_get_paper_ques_type_rlts_list_cache_key';
    /**
     * 获取章节知识点缓存
     */
    const CHAPTER_POINT_CACHE_KEY = 'according_subjectId_departmentId_bookVersionId_bookAtt_get_chapter_point_v1_cache_key';
    /**
     *根据年级id获取学校学段缓存
     */
    const GET_SCHOOL_DEPARTMENT_CACHE_KEY = 'according_gradeId_get_school_department_cache_key';
    /**
     *获取章节知识点数据缓存
     */
    const GET_CHAPTER_DATA_CACHE_KEY = 'according_subjectId_version_departments_get_chapter_data_cache_key';
    /**
     *根据学部id 获取年级id列表缓存
     */
    const GET_SCHOOL_GRADEID_CACHE_KEY = 'according_departments_get_gradeId_cache_key';
    /**
     * 查询知识点缓存
     */
    const GET_KNOWLEDGE_POINT_CACHE_KEY = 'according_department_subjectId_get_knowledge_point_cache_key';
    /**
     * 查询用户所教年级缓存
     */
    const GET_GRADE_INFO_BY_USER_CACHE_KEY = 'get_grade_info_by_user_cache_key';
    /**
     * 查询用户的邀请码
     */
    const GET_USER_INVITE_CODE_CACHE_KEY = 'get_user_invite_code_cache_key';
    /**
     * 根据用户邀请码查询用户信息
     */
    const GET_USER_MODEL_BY_INVITE_CODE_CACHE_KEY = 'get_user_model_by_invite_code_cache_key';
    /*
     *周周同特权用户查询
     */
    const PRIVILEGE_USER_KEY = 'privilege_user_key';
    /*
     * 获取单个分册信息缓存
     */
    const GET_TOME_INFO_CACHE_BY_ID = 'get_tome_info_cache_by_id';
    /*
     * 获取单个章节信息缓存
     */
    const GET_CHAPTER_INFO_CACHE_BY_ID = 'get_chapter_info_cache_by_id';

    /*
     * 获取单个章节信息缓存
    */
    const SCAN_LOGIN_CODE_USER_INFO = 'scan_login_code_user_info_';
}