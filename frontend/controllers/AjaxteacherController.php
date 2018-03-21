<?php

namespace frontend\controllers;

use common\models\JsonMessage;
use frontend\components\TeacherBaseController;
use common\models\dicmodels\KnowledgePointModel;

/**
 * Created by PhpStorm.
 * User: a
 * Date: 14-6-24
 * Time: 下午2:45
 */
class AjaxteacherController extends TeacherBaseController
{

    /**
     *请求知识树
     * @throws \yii\base\ExitException
     */
    public function actionGetKnowledge()
    {

        $jsonResult = new JsonMessage();
        $jsonResult->data = [];
        $subjectID = app()->request->post('subjectID', null);
        $grade = app()->request->post('grade', null);
        if ($subjectID == null || $grade == null) {
            return $this->renderJSON($jsonResult);
        }

        $knowledgePoint = KnowledgePointModel::searchKnowledgePointGradeToTree($subjectID, $grade);
        if (!empty($knowledgePoint)) {
            $jsonResult->success = true;
            $jsonResult->data = $knowledgePoint;

        } else {
            $jsonResult->success = true;
        }
        return $this->renderJSON($jsonResult);
    }

} 