<?php
/**
 * Created by wangchunlei
 * User: Administrator
 * Date: 2015/8/6
 * Time: 11:17
 */
namespace console\controllers;

use common\models\pos\SeUserinfo;
use yii\console\Controller;
use yii\db\mssql\PDO;

class UserSynchroController extends Controller
{

    /**
     *班海与dedecms用户同步
     */
    public function actionUserSynchro()
    {
        echo 'start time : ' . date('Y-m-d h;i;s', time());
        $arrdede = [];
        $pdo = new PDO("mysql:host=192.168.1.169;dbname=dedecmsv57utf8sp1", "admin", "neptune@admin");
        $pdo->query("SET NAMES utf8");
        $sql = "SELECT mid FROM dede_member";
        $res = $pdo->query($sql);
        $resultdede = $res->fetchAll(PDO::FETCH_ASSOC);

        foreach ($resultdede as $result) {
            $arrdede[] = $result['mid'];
        }

        $arr = [];
        $userInfoModel = SeUserinfo::find();
        $users = $userInfoModel->where(['status1' => 1, 'status2' => 1])->andWhere(['>=', 'type', 1])->select(['userID', 'trueName'])->all();
        foreach ($users as $user) {
            if (!in_array($user->userID, $arrdede)) {
                $sql = 'insert into dede_member (mid,uname) values (' . $user->userID . "," . "'" . $user->trueName . "'" . ')';
                $pdo->query($sql);
            }
        }
        print("\n");;
        echo 'end time : ' . date('Y-m-d h;i;s', time());
    }

}