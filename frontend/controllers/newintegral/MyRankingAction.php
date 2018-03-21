<?php
declare(strict_types = 1);
namespace frontend\controllers\newintegral;

use common\models\pos\SeClassMembers;
use common\clients\JfManageService;
use yii\base\Action;
use yii\web\HttpException;

class MyRankingAction extends Action
{

    /**
     * 积分排名
     * @return string
     * @throws HttpException
     */
    public function run()
    {
        $userid = user()->id;
        $user = loginUser();
        if (!$user) {
            throw new HttpException(404, 'The requested page does not exist.');
        }
        $jfManageHelperModel = new JfManageService();

        //总积分
        $userScore = $jfManageHelperModel->UserScore($userid);
        $totalPoints = $userScore->totalPoints;

        //今日积分，积分等级
        $todayPoints = $jfManageHelperModel->UserDayScore($userid);
        $gradePoints = $jfManageHelperModel->JfGrade($userid);

        if (app()->request->isAjax) {
            $category = (int)app()->request->getParam('category', 1);

            $userType = $user->type;

            $userInfoArr = [];
            if ($category == 1) {
                //全国排名
                $userInfoArr = $jfManageHelperModel->userCountrySorts($userType);

            } elseif ($category == 2) {
                //全校排名
                $schoolID = $user->schoolID;
                $userInfoArr = $jfManageHelperModel->userSorts($schoolID, $userType);
            } elseif ($category == 3 && $userType == 0) {
                //全班排名
                $classID = SeClassMembers::getClass($userid)->classID;
                $userInfoArr = $jfManageHelperModel->userClassSorts($classID, $userType);
            }

            $userIds = from($userInfoArr)->select(function ($v) {
                return $v->userID;
            })->toList();
            $userIds = implode(',', $userIds);
            $userGrades = $jfManageHelperModel->JfUsersGrade($userIds);
            $dataList = $this->gradeSort($userInfoArr, $userGrades);

            return $this->controller->renderPartial('@app/views/publicView/newintegral/_jf_sort', array('dataList' => $dataList, 'category' => $category));
        }
        return $this->controller->render('@app/views/publicView/newintegral/myRanking', [
            'user' => $user,
            'totalPoints' => $totalPoints,
            'todayPoints' => $todayPoints,
            'gradePoints' => $gradePoints,
        ]);
    }


    /**
     * 用户排名等级
     * @param array $user 用户排名
     * @param array $sort 用户等级
     * @param array $data 用户排名等级
     * @return array
     */
    public function gradeSort(array $user, array $sort): array
    {
        $data = [];
        foreach ($user as $key => $value) {
            foreach ($sort as $ke => $val) {
                if ($value->userID == $val->userId) {
                    $data[$key]['gradeName'] = $val->gradeName;
                    $data[$key]['userID'] = $value->userID;
                    $data[$key]['totalPoints'] = $value->totalPoints;
                    $data[$key]['trueName'] = $value->trueName;
                }
            }
        }
        return $data;
    }

}