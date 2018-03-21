<?php
/**
 * Created by PhpStorm.
 * User: yangjie
 * Date: 16/8/19
 * Time: 下午3:23
 */

namespace common\models;


use common\helper\DateTimeHelper;
use common\helper\MediaSourceHelper;
use common\helper\StringHelper;
use common\models\sanhai\ShTestquestion;
use common\clients\MediaSourceService;
use frontend\components\helper\ImagePathHelper;
use frontend\components\helper\LetterHelper;
use frontend\components\helper\StringHelper as FrontEndStringHelper;
use common\components\WebDataKey;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;


/**
 * This is the model class for table "sh_testquestion".
 *
 * @property integer $id
 * @property string $provience
 * @property string $city
 * @property string $country
 * @property integer $gradeid
 * @property integer $subjectid
 * @property string $versionid
 * @property string $kid
 * @property integer $tqtid
 * @property string $provenance
 * @property string $year
 * @property string $school
 * @property integer $complexity
 * @property integer $capacity
 * @property integer $operater
 * @property integer $createTime
 * @property integer $updateTime
 * @property string $content
 * @property string $analytical
 * @property string $mainQusId
 * @property integer $status
 * @property integer $isDelete
 * @property integer $quesLevel
 * @property string $quesFrom
 * @property string $chapterId
 * @property integer $noNum
 * @property integer $showType
 * @property integer $backendOperater
 * @property integer $paperId
 * @property string $answer
 * @property string $jsonAnswer
 * @property integer $isAuto
 * @property integer $keHaiUseNum
 */
trait TestQuestion
{


    /**
     * 加工题的正文部分
     */
    public function processContent()
    {
        return str_replace(ShTestquestion::TIAN_KONG_TI_REPLACE_CONTENT, ShTestquestion::TIAN_KONG_TI_REPLACE_TO_CONTENT, StringHelper::replacePath($this->content));
    }

    /**
     * 判断主客观题
     * @return int
     */
    public function isMajorQuestion()
    {
        $isMajor = 1;
        if ($this->showType == ShTestquestion::QUESTION_DAN_XUAN_TI || $this->showType == ShTestquestion::QUESTION_DUO_XUAN_TI || $this->showType == ShTestquestion::QUESTION_PAN_DUAN_TI) {
            $isMajor = 0;
        }
        return $isMajor;
    }

    /**
     * 判断是主观可判题
     * @return bool
     */
    public function isJudgeQuestion()
    {
        if ($this->showType == ShTestquestion::QUESTION_KE_PAN_TIAN_KONG_TI || $this->showType == ShTestquestion::QUESTION_KE_PAN_XUAN_TIAN_TI || $this->showType == ShTestquestion::QUESTION_KE_PAN_LIAN_XIAN_TI || $this->showType == ShTestquestion::QUESTION_KE_PAN_YING_YONG_TI) {
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getQuestionShowType()
    {
        return $this->showType;
    }

    /**
     * 判断当前题目是否是最近一周内创建的
     * @return bool
     */
    public function isNewQuestion()
    {
        $week_ago = strtotime('-1 week') * 1000;
        if ($this->createTime > $week_ago || $this->updateTime > $week_ago) {
            return true;
        }
        return false;
    }

    /**
     * 查询题库详情
     * wgl
     * @param integer $questionId 题id
     * @return array|null|\yii\elasticsearch\ActiveRecord
     */
    public static function getTestQuestionDetails(int $questionId)
    {
        return self::get($questionId);
    }


    //作业大题的选项
    /**
     * @return string
     */
    public function getHomeworkMainQuestionOption()
    {

        if ($this->answerOption == '' || $this->answerOption == null) {
            return '';
        }
        $content = '';
        if ($this->answerOption == '') {
            $op_list = LetterHelper::MatchOptions($this->answerOptCnt);
            if ($this->getQuestionShowType() == ShTestquestion::QUESTION_DAN_XUAN_TI) {
                $content = '<div class="checkArea">' . Html::radioList("answer[$this->id]", '', ArrayHelper::map($op_list, 'id', 'content'),
                        ['itemOptions' => ['class' => 'radio'], 'class' => "radio alternative", 'qid' => $this->id,
                            'tpid' => $this->getQuestionShowType(), 'separator' => '&nbsp;', 'encode' => false]) . '</div>';
            } elseif ($this->getQuestionShowType() == ShTestquestion::QUESTION_DUO_XUAN_TI) {
                $content = '<div class="checkArea">' . Html::checkboxList("answer[$this->id]", '', ArrayHelper::map($op_list, 'id', 'content'),
                        ['itemOptions' => ['class' => 'checkbox'], 'class' => "radio alternative", 'qid' => $this->id,
                            'tpid' => $this->getQuestionShowType(), 'separator' => '&nbsp;', 'encode' => false]) . '</div>';
            }
        } else {
            $result = json_decode($this->answerOption);
            $result = $result == null ? array() : $result;
            $select = (from($result)->select(function ($v) {
                return '<em>' . LetterHelper::getLetter($v->id) . '</em>&nbsp;<p>' . $v->content . '</p>';
            }, '$k')->toArray());
            if ($this->getQuestionShowType() == ShTestquestion::QUESTION_DAN_XUAN_TI) {
                $content = Html::radioList('answer[' . $this->id . ']', '', $select,
                    ['itemOptions' => ['class' => 'radio'], 'separator' => '', 'class' => 'radio', 'encode' => false]);
            } else {
                $content = Html::checkboxList('answer[' . $this->id . ']', '', $select,
                    ['itemOptions' => ['class' => 'checkbox'], 'separator' => '', 'class' => 'checkbox', 'encode' => false]);
            }
        }
        return $content;
    }


    //判断题显示选项（不包含radio)
    /**
     * @return string
     */
    public function getJudgeQuestionContent()
    {
        $content = '';
        $op_list = array(
            '0' => array('id' => '0', 'content' => '错'),
            '1' => array('id' => '1', 'content' => '对')
        );

        foreach ($op_list as $op) {
            $content .= LetterHelper::getLetter($op['id']) . '.' . $op['content'] . '&nbsp;';
        }
        return $content;
    }


    /**
     * 获取大题下的小题内容
     * @return array
     */
    public function getQuestionChild()
    {
        $childQuestionList = [];
        if ($this->showType == ShTestquestion::QUESTION_KE_PAN_YING_YONG_TI || $this->showType == ShTestquestion::QUESTION_BU_KE_PAN_YING_YONG_TI) {
            $childQuestionList = self::find()->where(['mainQusId' => $this->id])->orderBy('id')->limit(20)->all();
        }
        return $childQuestionList;

    }

    /**
     * @return array|\common\models\sanhai\ShTestquestion[]|mixed
     */
    public function getQuestionChildCache()
    {
        if ($this->showType == ShTestquestion::QUESTION_KE_PAN_YING_YONG_TI || $this->showType == ShTestquestion::QUESTION_BU_KE_PAN_YING_YONG_TI) {

            $cache = Yii::$app->cache;
            $key = WebDataKey::SEARCH_QUESTION_CHILDREN_LIST_KEY . $this->id;
            $data = $cache->get($key);
            if ($data === false) {
                $data = $this->getQuestionChild();
                $cache->set($key, $data, 1800);
            }
            return $data;
        }
        return [];
    }

    /**
     * @return bool
     */
    public function clearQuestionChildCache()
    {
        $cache = Yii::$app->cache;
        $key = WebDataKey::SEARCH_QUESTION_CHILDREN_LIST_KEY . $this->id;
        return $cache->delete($key);
    }


//作业（选择题）大题和小题选项内容（不含radio和checkbox）2.0
    /**
     * @return string
     */
    public function homeworkQuestionContent()
    {
        if ($this->jsonAnswer == '' || $this->jsonAnswer == null) {
            return '';
        }

        $content = '';
        if (!empty($this->jsonAnswer)) {
            $result = json_decode($this->jsonAnswer);
            $result = isset($result->left) ? $result->left : [];
            foreach ($result as $v) {
                if ($v->c == null || $v->c == '') {
                    return '';
                }
            }
            $select = (from($result)->select(function ($v, $k) {
                return '<tr><td style="vertical-align: top;">' . LetterHelper::getLetter($k) . '.&nbsp;</td><td>' . StringHelper::replacePath($v->c) . '</td></tr>';
            }, '$k')->toArray());
            $content .= '<table>';
            foreach ($select as $val) {
                $content .= $val;
            }
            $content .= '</table>';
        }
        return $content;
    }

    //作业题目（大题和小题）的选项（含radio和checkbox）2.0（未答的）
    /**
     * @return string
     */
    public function getHomeworkQuestionOption()
    {
        $content = '';
        if (empty($this->jsonAnswer)) {
            $op_list = LetterHelper::MatchOptions2($this->answerOptCnt);

            if ($this->getQuestionShowType() == ShTestquestion::QUESTION_DAN_XUAN_TI) {
                $content = Html::radioList("answer[$this->id]", '', ArrayHelper::map($op_list, 'id', 'content'),
                    ['qid' => $this->id, 'tpid' => $this->getQuestionShowType(), 'encode' => false]);
            } elseif ($this->getQuestionShowType() == ShTestquestion::QUESTION_DUO_XUAN_TI) {
                $content = Html::checkboxList("answer[$this->id]", '', ArrayHelper::map($op_list, 'id', 'content'),
                    ['qid' => $this->id, 'tpid' => $this->getQuestionShowType()]);
            }
        } else {
            $result = json_decode($this->jsonAnswer);
            $result = isset($result->left) ? $result->left : [];
            $select = (from($result)->select(function ($v, $k) {
                return LetterHelper::getLetter($k);
            }, '$k')->toArray());
            if ($this->getQuestionShowType() == ShTestquestion::QUESTION_DAN_XUAN_TI) {
                $content = Html::radioList('answer[' . $this->id . ']', '', $select, []);
            } else {
                $content = Html::checkboxList('answer[' . $this->id . ']', '', $select, []);
            }
        }
        return $content;
    }

    //作业小题的选项
    /**
     * @param string $mainId
     * @return string
     */
    public function getHomeworkChildQuestionOption($mainId = '')
    {
        $content = '';
        if (!empty($this->answerOption)) {
            $result = json_decode($this->answerOption);
            $select = (from($result)->select(function ($v) {
                return '<em>' . LetterHelper::getLetter($v->id) . '</em>&nbsp;<p>' . $v->content . '</p>';
            }, '$k')->toArray());
            if ($this->getQuestionShowType() == ShTestquestion::QUESTION_DAN_XUAN_TI) {
                $content = Html::radioList('answer[' . $mainId . '][item][' . $this->id . ']', '', $select,
                    array('itemOptions' => ['class' => 'radio'], 'separator' => '', 'class' => 'radio', "encode" => false));
            } else {
                $content = Html::checkboxList('answer[' . $mainId . '][item][' . $this->id . ']', '', $select,
                    array('itemOptions' => ['class' => 'checkbox'], 'separator' => '', 'class' => 'checkbox', "encode" => false));
            }
        } else {
            $op_list = LetterHelper::MatchOptions($this->answerOptCnt);
            if ($this->getQuestionShowType() == ShTestquestion::QUESTION_DAN_XUAN_TI) {
                $content = '<div class="checkArea">' . Html::radioList('answer[' . $mainId . '][item][' . $this->id . ']', '', ArrayHelper::map($op_list, 'id', 'content'),
                        ['itemOptions' => ['class' => 'radio'], 'class' => "radio alternative", 'qid' => $this->id,
                            'tpid' => $this->getQuestionShowType(), 'separator' => '&nbsp;', 'encode' => false]) . '</div>';
            } elseif ($this->getQuestionShowType() == ShTestquestion::QUESTION_DUO_XUAN_TI) {
                $content = '<div class="checkArea">' . Html::checkboxList('answer[' . $mainId . '][item][' . $this->id . ']', '', ArrayHelper::map($op_list, 'id', 'content'),
                        ['itemOptions' => ['class' => 'checkbox'], 'class' => "radio alternative", 'qid' => $this->id,
                            'tpid' => $this->getQuestionShowType(), 'separator' => '&nbsp;', 'encode' => false]) . '</div>';
            }
        }
        return $content;
    }


//作业题目（大题和小题）的选项结果2.0(答过的)
    /**
     * @param $objectiveAnswer
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function getHomeworkQuestionOptionAnswer($objectiveAnswer)
    {
        $content = '';
        if (empty($this->jsonAnswer)) {
            $op_list = LetterHelper::MatchOptions2($this->answerOptCnt);
            foreach ($op_list as $op) {
                $color = '';
                $obj = $objectiveAnswer[$this->id];
                if ($obj['answerOption'] == null) {
                    $content .= '<label>' . $op['content'] . '</label>';
                } else {
                    $answer = explode(',', $obj['answerOption']);
                    if (in_array($op['id'], $answer)) {
                        if ($obj['correctResult'] == 1) {
                            $color = 'chkLabel_error';
                        } elseif ($obj['correctResult'] == 2) {
                            $color = 'chkLabel_half';
                        } elseif ($obj['correctResult'] == 3) {
                            $color = 'chkLabel_ac';
                        }
                    }
                    $content .= '<label class="' . $color . '">' . $op['content'] . '</label>';
                }
            }
        } else {
            $result = \yii\helpers\Json::decode($this->jsonAnswer);
            $result = isset($result['left']) ? $result['left'] : [];
            foreach ($result as $v) {
                if ($v['c'] == null || $v['c'] == '') {
                    return '';
                }
            }
            $select = from($result)->select(function ($v, $k) {
                return LetterHelper::getLetter($k);
            }, '$k')->toArray();

            foreach ($select as $op) {
                $color = '';
                $obj = $objectiveAnswer[$this->id];
                if ($obj['answerOption'] == null) {
                    $content .= '<label>' . $op . '</label>';
                } else {
                    $answer = explode(',', $obj['answerOption']);
                    if (in_array(LetterHelper::getNum($op), $answer)) {
                        if ($obj['correctResult'] == 1) {
                            $color = 'chkLabel_error';
                        } elseif ($obj['correctResult'] == 2) {
                            $color = 'chkLabel_half';
                        } elseif ($obj['correctResult'] == 3) {
                            $color = 'chkLabel_ac';
                        }
                    }
                    $content .= '<label class="' . $color . '">' . $op . '</label>';
                }

            }
        }
        return $content;
    }


    /**
     * 获取回答的答案
     * @param int $level
     * @return string
     */
    public function getNewAnswerContent($level = 0)
    {

        $result = '';
        $questionChild = $this->getQuestionChildCache();
        $tqTid = $this->showType;
        $answerContent = $this->answer;

        if ($tqTid == ShTestquestion::QUESTION_BU_KE_PAN_TIAN_KONG_TI || $tqTid == ShTestquestion::QUESTION_JIE_DA_TI || ShTestquestion::QUESTION_KE_PAN_TIAN_KONG_TI || ShTestquestion::QUESTION_KE_PAN_XUAN_TIAN_TI) {
            if (isset($answerContent) && !empty($answerContent)) {
                $answerContents = null;
                if (is_json($answerContent, $answerContents)) {
                    /** @var TestQuestion $answerContents */
                    foreach ($answerContents as $answer) {
                        $result .= FrontEndStringHelper::htmlPurifier($answer) . '&nbsp;&nbsp;';
                    }
                } else {
                    $result = FrontEndStringHelper::htmlPurifier($answerContent) . '&nbsp;&nbsp;';
                }
            }
        } else {
            if (isset($answerContent) && !empty($answerContent)) {
                $result = $answerContent;
            }
        }

        if (empty($questionChild)) {
            return $result;
        } else {
            foreach ($questionChild as $i) {
                $result = $result . '&nbsp;' . $i->getNewAnswerContent($level + 1) . '<br/>';
            }
        }
        return $result;
    }


    /**
     *  判断题显示选项(包含radio)（未答的）
     * @return string
     */
    public function getJudgeQuestionOption()
    {
        $content = '';
        $op_list = array(
            '0' => array('id' => '0', 'content' => '错'),
            '1' => array('id' => '1', 'content' => '对')
        );
        $content .= Html::radioList("answer[$this->id]", '', ArrayHelper::map($op_list, 'id', 'content'), ['qid' => $this->id, 'tpid' => $this->getQuestionShowType()]);

        return $content;
    }


    /**
     *   判断题显示选项答案(包含radio)(答过的)
     * @param $objectiveAnswer
     * @return string
     */
    public function getJudgeQuestionOptionAnswer($objectiveAnswer)
    {
        $content = '';
        $op_list = array(
            '0' => array('id' => '0', 'content' => '错'),
            '1' => array('id' => '1', 'content' => '对')
        );
        foreach ($op_list as $op) {
            $color = '';
            $obj = $objectiveAnswer[$this->id];
            if ($obj['answerOption'] == null) {
                $content .= '<label>' . $op['content'] . '</label>';
            } else {
                $answer = explode(',', $obj['answerOption']);
                if (in_array($op['id'], $answer)) {
                    if ($obj['correctResult'] == 1) {
                        $color = 'chkLabel_error';
                    } elseif ($obj['correctResult'] == 3) {
                        $color = 'chkLabel_ac';
                    }
                }
                $content .= '<label class="' . $color . '">' . $op['content'] . '</label>';
            }
        }

        return $content;
    }


    /**
     * 连线题内容
     * @return string
     */
    public function getConnectionQuestionContent()
    {

        if ($this->jsonAnswer == '' || $this->jsonAnswer == null) {
            return '';
        }
        $content = '';
        if (!empty($this->jsonAnswer)) {
            $result = json_decode($this->jsonAnswer);
            $result = $result == null ? array() : $result;
            $left = $result->left;
            $right = $result->right;

            $content .= '<table class="edits">';
            foreach ($left as $k => $l) {
                $content .= '<tr><td class="textBox1">' . StringHelper::replacePath($l->c) . '</td><td class="textBox2">' . (isset($right[$k]) && isset($right[$k]->c) ? StringHelper::replacePath($right[$k]->c) : '') . '</td></tr>';
            }
            $content .= '</table>';
        }
        return $content;
    }


    /**
     * 媒体资源
     * @param $mediaId
     * @param $mediaType
     * @param $showType
     * @return string
     */
    public static function mediaSource($mediaId, $mediaType,$showType)
    {

        $content = '';
        $time = 0;

        if(!empty($mediaId))
        {
            $mediaService = new MediaSourceService();
            $mediaInfo = $mediaService->getMediaSourceInfo($mediaId);

            if ($mediaInfo) {
                $time = $mediaInfo->duration;
            }
            $duration = DateTimeHelper::convertMinSec($time);
            switch ($mediaType) {
                case 1:
                    if($showType == ShTestquestion::QUESTION_BU_KE_PAN_LANG_DU_TI){
                        $content.= '<audio controls="controls" src="' . MediaSourceHelper::getMediaSource((string)$mediaId) . '"></audio>';
                    }else {
                        $content .= '<div class="audioBox">
                                <p class="vol"></p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="140" height="36" viewBox="0 0 159 36">
                                    <defs>
                                    </defs>
                                    <rect class="cls-1" x="9" width="140" height="36" rx="18" ry="18"></rect>
                                    <path class="cls-2"
                                          d="M10.88,21.272S9.365,10.119.909,6.622c-1,1.068-4.219-1.724,12.464,0C13.158,6.854,16.208,12.325,10.88,21.272Z"></path>
                                </svg>
                                <audio src="' . MediaSourceHelper::getMediaSource((string)$mediaId) . '"></audio>

                                 <span class="time">
                                 ' . $duration . '
                                 </span>
                               </div>';
                    }
                    break;
                case 2:

                    $content .= '<video style="width: 450px" src="' . MediaSourceHelper::getMediaSource((string)$mediaId) . '" controls="controls"></video>';
                    break;
            }
        }

        return $content;

    }



    /**
     * 判断是不可判题
     * @return bool
     */
    public function isUndecidableQuestion()
    {
        if ($this->showType == ShTestquestion::QUESTION_BU_KE_PAN_YING_YONG_TI || $this->showType == ShTestquestion::QUESTION_BU_KE_PAN_TIAN_KONG_TI || $this->showType == ShTestquestion::QUESTION_JIE_DA_TI) {
            return true;
        }
        return false;
    }




    /**
     * 学生的答案
     * @param int $questionId
     * @param array $ansList
     * @param array $ansImages
     * @param int $level
     * @return mixed
     */
    public function getUserAnswer(int $questionId, array $ansList, array $ansImages, int $level = 0)
    {
        $result = '';
        $resultImage = '';
        $ansResult = [];
        $ansResult['result'] = &$result;
        $ansResult['resultImage'] = &$resultImage;

        if ($ansList == []) {
            return $ansResult;
        }

        $showType = $this->showType;

        if ($showType == ShTestquestion::QUESTION_KE_PAN_YING_YONG_TI || $showType == ShTestquestion::QUESTION_BU_KE_PAN_YING_YONG_TI) {
            if ($level = 0) {
                $level = -1;
            }
            $questionChild = $this->getQuestionChildCache();
            foreach ($questionChild as $question) {
                $ansQuestionResult = $question->getUserAnswer($question->id, $ansList, $ansImages, $level++);

                $ansResult['result'] = $ansResult['result'] . '&nbsp;' . $ansQuestionResult['result'] . '<br/>';
                if ($ansResult['resultImage'] == ''){
                    $ansResult['resultImage'] =  $ansQuestionResult['resultImage'] ;
                }
            }
            return $ansResult;
        }

        $right = [];
        $jsonAnswer = $this->jsonAnswer;
        if ($jsonAnswer != null) {
            $decodeJsonAnswer = json_decode($jsonAnswer);
            $right = $decodeJsonAnswer->right;
        }

        //取出对应小题的用户回答详情
        $answerContent = null;
        foreach ($ansList as $answerInfo){
            if ($questionId == $answerInfo->questionId){
                $answerContent = $answerInfo;
                break;
            }
        }
        if ($answerContent == null){
            return $ansResult;
        }

        $isUndecidableQuestion = $this->isUndecidableQuestion();
        if ($isUndecidableQuestion == true && $ansImages != [] && $resultImage == '') {    //不可判题已答
            $imagesNumber = count($ansImages);

            foreach ($ansImages as $key =>$image) {

                if ($imagesNumber === 1) {
                    $thumbUrl = ImagePathHelper::imgThumbnail($image, 600, 200);
                    $resultImage .= '<image class="answerImages" data-index="'.$key.'" width="100%" src="' . $thumbUrl . '"/>' . '&nbsp;&nbsp;';
                } else if ($imagesNumber > 1) {
                    $thumbUrl = ImagePathHelper::imgThumbnail($image, 200, 200);
                    $resultImage .= '<image class="answerImages" data-index="'.$key.'" width="30%" src="' . $thumbUrl . '"/>' . '&nbsp;&nbsp;';
                }

            }


        } else if ($isUndecidableQuestion == true && $ansImages == [] && $resultImage == '') {   //不可判题未答
            $result .= '未作答' . '&nbsp;&nbsp;';


        } else if ($isUndecidableQuestion == false && (string)$answerContent->userAnswer == '') {          //可判题未答
            $result .= '未作答' . '&nbsp;&nbsp;';


        } else if ($isUndecidableQuestion == false && (string)$answerContent->userAnswer != '') { //可判题已答
            $userAnswer = json_decode($answerContent->userAnswer);
            foreach ($userAnswer as $answer) {
                switch ($showType) {
                    case ShTestquestion::QUESTION_DAN_XUAN_TI:
                    case ShTestquestion::QUESTION_DUO_XUAN_TI:
                        if ($answer->id === ''){
                            $result.= '未作答';
                            continue;
                        }
                        $result .= LetterHelper::getLetter($answer->id) . '&nbsp;&nbsp;';
                        break;

                    case ShTestquestion::QUESTION_PAN_DUAN_TI :
                        if ($answer->id === ''){
                            $result.= '未作答';
                            continue;
                        }
                        $result .= LetterHelper::rightOrWrong($answer->id) . '&nbsp;&nbsp;';
                        break;

                    case ShTestquestion::QUESTION_KE_PAN_TIAN_KONG_TI:
                        $result.= '(空'.++$answer->id.')';

                        $result .= $answer->ret === '' ? '未作答&nbsp;&nbsp;':$answer->ret. '&nbsp;&nbsp;';
                        break;

                    case ShTestquestion::QUESTION_KE_PAN_XUAN_TIAN_TI:
                        $result.= '(空'.++$answer->id.')';
                        if ($answer->ret === ''){
                            $result.= '未作答'.'&nbsp;&nbsp;';
                            continue;
                        }
                        $result .= $right[$answer->ret]->c . '&nbsp;&nbsp;';
                        break;

                    case ShTestquestion::QUESTION_KE_PAN_LIAN_XIAN_TI:

                        $answer->ret = $answer->ret == '' ? '未作答' : ++$answer->ret;
                        $result .= '左' . ++$answer->id . '---右' . $answer->ret . '&nbsp;&nbsp;';
                        break;
                }
            }
        }

        return $ansResult;
    }


}