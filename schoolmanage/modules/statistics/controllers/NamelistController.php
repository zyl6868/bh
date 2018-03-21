<?php
declare(strict_types=1);
namespace schoolmanage\modules\statistics\controllers;

use common\models\pos\SeViweExamReportExamPersonalScoreRankSearch;
use schoolmanage\components\SchoolManageBaseAuthController;
use Yii;
use yii\data\ActiveDataProvider;

class NamelistController extends SchoolManageBaseAuthController
{
    public $layout = 'lay_statistics_index';


    /**
     * 名单
     * @param integer $examId 考试ID
     * @param integer $classId 班级ID
     * @param integer $subjectId 科目ID
     * @param integer $level 层次
     * @return string
     * @throws \yii\base\InvalidParamException
     * @throws \yii\web\HttpException
     */
    public function actionIndex(int $examId, int $classId = 0, int $subjectId = 0, int $level = 0)
    {
        $seExamSchoolModel = $this->getSeExamSchoolModel($examId);

        $classesList = $seExamSchoolModel->getClasses();
        $examsList = $seExamSchoolModel->getExamSubject()->all();

        $query = SeViweExamReportExamPersonalScoreRankSearch::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ]

        ]);

        $query->andWhere(['schoolExamId' => $examId]);

        if (empty($subjectId)) {
            $query->orderBy('totalScore desc');
        } else {
            $query->orderBy("sub$subjectId desc");
        }

        $query->addOrderBy('userId');

        if (!empty($classId)) {
            $query->andWhere([
                'classId' => $classId,
            ]);
        }

        if (!empty($level)) {
            $totalScore = 0;
            $min = 0;
            $max = 0;
            if (empty($subjectId)) {
                $totalScore = $seExamSchoolModel->getTotalScore();

            } else {
                $totalScore = $seExamSchoolModel->getSubjectScoreById((int)$subjectId);
            }

            switch ($level) {
                //高分
                case '1':
                    $min = $totalScore * 0.8;
                    $max = $totalScore+1;
                    break;
                //及格
                case '2':
                    $min = 0;
                    $max = $totalScore * 0.6;
                    break;
                //低分
                case '3':
                    $min = 0;
                    $max = $totalScore * 0.4;
                    break;

            }

            if (empty($subjectId)) {
                $query->totalBetween($min, $max);
            } else {
                $query->subjectIdBetween($subjectId, $min, $max);
            }


            //总分
        }


        if (yii::$app->request->getIsAjax()) {
            return $this->renderPartial('_namelist', ['examId' => $examId, 'classesList' => $classesList, 'examsList' => $examsList, 'dataProvider' => $dataProvider]);
        }

        return $this->render('index', ['examId' => $examId, 'seExamSchoolModel'=>$seExamSchoolModel, 'classesList' => $classesList, 'examsList' => $examsList, 'dataProvider' => $dataProvider]);

    }


}