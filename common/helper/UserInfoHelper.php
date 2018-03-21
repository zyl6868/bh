<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 15-6-25
 * Time: 下午12:15
 */

namespace common\helper;


use common\models\pos\SeClass;
use common\models\pos\SeClassMembers;
use common\models\pos\SeSchoolInfo;
use common\models\pos\SeUserinfo;
use common\models\sanhai\SeDateDictionary;
use common\models\sanhai\SeSchoolGrade;

class UserInfoHelper
{

    /**
     * 根据用户id返回用户教的年级
     */
    public static function getGradeName($id)
    {

        $classMemberModel = SeClassMembers::find()->where(['userID' => $id])->all();
        $result = '';
        foreach ($classMemberModel as $MemberModel) {
            $classId = $MemberModel->classID;
            $classModel = SeClass::find()->where(['classID' => $classId])->limit(1)->one();
            $gradeId = $classModel->gradeID;
            $gradeNameModel = SeSchoolGrade::find()->where(['gradeId' => $gradeId])->limit(1)->one();
            $result = $result . $gradeNameModel->gradeName . '&nbsp';
        }
        return $result;
    }

    /**
     * 根据用户id返回用户所在学校id 和 名字
     */
    public static function getSchoolName($id)
    {
        $arr = [];
        $userModel = SeUserinfo::find()->where(['userID' => $id])->limit(1)->one();
        $schoolId = $userModel->schoolID;
        $schoolModel = SeSchoolInfo::find()->where(['schoolID' => $schoolId])->limit(1)->one();
        $schoolName = $schoolModel->schoolName;
        $arr[0] = $schoolId;
        $arr[1] = $schoolName;
        return $arr;
    }

}