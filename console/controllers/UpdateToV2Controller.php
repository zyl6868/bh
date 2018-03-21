<?php
namespace console\controllers;

use common\models\pos\SeAnswerQuestion;
use common\models\pos\SeClassEvent;
use common\models\pos\SeClassEventPic;
use common\models\pos\SeFavoriteFolder;
use common\models\pos\SeQuestionResult;
use common\models\sanhai\SrMaterial;
use schoolmanage\models\User;
use yii\console\Controller;

/**
 * Created by wangchunlei.
 * User: Administrator
 * Date: 2016/3/5
 * Time: 10:27
 */
class UpdateToV2Controller extends Controller
{

    /**
     *把大事记seClassEvent里面的图片转移到seClassEventPic
     */
    public function actionMoveEventPic()
    {
        foreach (SeClassEvent::find()->batch(100) as $seClassEventList) {

            /** @var SeClassEvent[] $seClassEventList */
            foreach ($seClassEventList as $item) {

                //跑过已经有图片的大事迹
                if (SeClassEventPic::find()->where(['eventID' => $item->eventID])->exists()) {
                    continue;
                };

                $url = $item->url;
                $eventID = $item->eventID;
                $createTime = $item->createTime;
                if ($url != null) {

                    $urlArray = explode(',', $url);
                    foreach ($urlArray as $value) {
                        $eventPicModel = new SeClassEventPic();
                        $eventPicModel->eventID = $eventID;
                        $eventPicModel->picUrl = $value;
                        $eventPicModel->createTime = $createTime;
                        $eventPicModel->save(false);
                    }
                }
            }

        }
    }


    /**
     * 同步答疑回答数
     */
    public function actionSyncAnsweringQuestions()
    {
        foreach (SeAnswerQuestion::find()->batch(100) as $seAnswerQuestionList)

            /** @var SeAnswerQuestion[] $seAnswerQuestionList */
            foreach ($seAnswerQuestionList as $item) {
                $answerResult = SeQuestionResult::find()->where(['rel_aqID' => $item->aqID, "isUse" => 1])->exists();
                if ($answerResult) {
                    $item->isSolved = true;
                    $item->save(false);
                }
            }
    }


    /**
     *同步文件收藏数
     */
    public function actionSyncFileFavoriteNum()
    {

        foreach (SrMaterial::find()->batch(100) as $srMaterialList)
            /** @var SrMaterial[] $srMaterialList */
            foreach ($srMaterialList as $srMaterial) {
                $favoriteNum = SeFavoriteFolder::find()->where(['favoriteId' => $srMaterial->id])->count();
                $srMaterial->setFavoriteNum($favoriteNum);
            }

    }

    public function actionCreate()
    {


        $user = [91400004525=>15056626088,
            2021224=>15065983618,
            914000025739=>13705498480,
            202303=>15830380595,
            202331=>15350737586,
            202217=>18903239058,
            101100860=>13696595540,
            914000004706=>13892771807,
            864457000054196=>13863442095,
            2022520=>13948499070,
            101100819=>15931984056,
            202606=>15839005512,
            101101752=>13633263545,
            2021222=>15953983280,
            202356=>13731380318,
            101101749=>15076684558,
            202268=>13785351386,
            202622=>15028905885,
            841786000003834=>13933768069,
            855232000018157=>15165392262,
            2021314=>13503242389,
            202297=>15028516431,
            914000045253=>15056626088,
            913000009908=>13568905722,
            202263=>13593346040,
            841786000033392=>18979750630,
            202269=>15847218026,
            202660=>13309653793,
            914000001034=>13933385482,
            202668=>13908097907,
            2021066=>13932838256,
            101101139=>15100389037,
            2021349=>15147360009,
            101100377=>13954937289,
            858078000016051=>18978151923,
            914000036370=>13932067746,
            202308=>13606352302,
            841786000036558=>15264937928,
            2021319=>13954965396,
            2021051=>15853915963,
            2021083=>13949990457,
            913000017166=>13573052368,
            913000005591=>13954900766,
            913000005178=>13562025796,
            914000046391=>18131097120,
            202842=>18179962960,
            101100661=>13954969470,
            864457000054853=>15726199269,
            841786000038710=>15038853188,
            2021043=>13956758695,
            202264=>13137655733,
            841786000028771=>13399586600,
            2021136=>15563197111,
            841786000037727=>13573016008,
            202598=>18315730077];

        foreach ($user as $key=> $v) {

            $user = new   User();
            $user->auth_key = 'GVG6l3EAU3fG2oSrETdnO92d_crvpu9o';
            $user->password_hash = '$2y$13$bIYqcvFOK..cWdUeWdo4x.pMVLY1aXJt62ysX.NbpHJsxqWv.BLhW';
            $user->schoolID = $key;
            $user->username = $v;
            $user->email = 'www.banhai.com@banhai';
            $user->status = 10;
            $user->userID = 0;
            $user->created_at=time();
            $user->updated_at=time();
            $user->save(false);

        }


    }

    /**
     * 测试
     */
    public  function  actionTest()
    {

    }


}