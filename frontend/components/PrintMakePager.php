<?php

namespace frontend\components;

use frontend\components\helper\NumberHelper;
use frontend\components\helper\StringHelper;
use PhpOffice\PhpWord\Element\Table;
use yii\base\Component;
use yii\web\Controller;


/**
 * Created by PhpStorm.
 * User: yang
 * Date: 15-6-12
 * Time: 下午4:37
 */
class PrintMakePager extends Component
{

    private $data = null;


    public function   run()
    {
//        foreach (Yii::$app->log->routes as $route) {
//            if ($route instanceof CWebLogRoute) {
//                $route->enabled = false;
//            }
//        }


// New Word document

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $styleTable = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80);
//        $styleFirstRow = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '66BBFF');
        $phpWord->addTableStyle('Fancy Table', $styleTable);
        $phpWord->addTableStyle('table', array('unit' => 'pct'));

        $phpWord->addFontStyle('t1', array('name' => 'Heiti SC Light', 'bold' => true, 'size' => 30));
        $phpWord->addFontStyle('t2', array('name' => 'Heiti SC Light', 'bold' => true, 'size' => 20));
        $phpWord->addParagraphStyle('Paragraph', array('align' => 'center'));
        $phpWord->addFontStyle('t3', array('name' => 'Heiti SC Light', 'bold' => true, 'size' => 15));
        $phpWord->addFontStyle('t4', array('name' => 'Heiti SC Light', 'bold' => true, 'size' => 12));

//        array('unit' => 'pct','width'=>100, 'bgColor' => 'FF0000')


//分栏
        $pStyle = array('paperSize' => 'A3',
            'orientation' => 'landscape',
            'colsNum' => 2,
            'colsSpace' => 1440,
            'breakType' => 'continuous',

        );


        $section = $phpWord->addSection($pStyle);

        $this->addHeader($section);
        $this->addFooter($section);
        $this->addPageName($section, $this->data->name);
        $this->addTopTable($section, count($this->data->pageMain->win_paper_typeone->questionTypes) + count($this->data->pageMain->win_paper_typetwo->questionTypes));

        $count = 0;

        $section->addText("第一卷(选择题)", 't2', 'Paragraph');
        $section->addTextBreak();

        $controller = new Controller("print-make-paer",null);

        foreach ($this->data->pageMain->win_paper_typeone->questionTypes as $items) {
            $this->addTable($section, NumberHelper::number2Chinese($count + 1) . "、" . $items->title . '(共' . count($items->questions) . '题）');

            foreach ($items->questions as $key => $i) {
                $html = $controller->renderPartial('//publicView/printPaper/_itemPreviewType', array('item' => $i, 'no' => $key + 1), true);
                $html = preg_replace("/<br[^>]*>/is", "<p>", $html);
                $html = StringHelper::htmlPurifier($html);


                \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);
            }
            $count++;
        }


        $section->addText("第二卷(非选择题)", 't2', 'Paragraph');
        $section->addTextBreak();

        foreach ($this->data->pageMain->win_paper_typetwo->questionTypes as $items) {
            $this->addTable($section, NumberHelper::number2Chinese($count + 1) . "、" . $items->title . '(共' . count($items->questions) . '题）');

            foreach ($items->questions as $key => $i) {
                $html = $controller->renderPartial('//publicView/printPaper/_itemPreviewType', array('item' => $i, 'no' => $key + 1));
                $html = preg_replace("/<br[^>]*>/is", "<p>", $html);
                $html = StringHelper::htmlPurifier($html);
                \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);
            }
            $count++;

        }


        $phpWord->save("{$this->data->name}.docx", 'Word2007', true);


    }

    /**
     * @param $section
     */
    private function addHeader($section)
    {
        $header = $section->addHeader();
        //装订线图
        $source = 'http://' . $_SERVER['HTTP_HOST'] . '/pub/images/paper_header_print.gif';
        $properties = array(
            'width' => 45,
            'height' => 500,
            'marginTop' => 50,
            'marginLeft' => 50,
            'positioning' => \PhpOffice\PhpWord\Style\Image::POS_RELATIVE,
            'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_LEFT,
            'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_VERTICAL_TOP,
            'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
            'posVerticalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE
        );
        try {
            $header->addImage($source, $properties);

        } catch (Exception $e) {
            \Yii::error('试卷添加装订线图失败错误信息' . '------' . $e->getMessage());
        }

    }

    /**
     * @param $section
     */
    private function addFooter($section)
    {
        $footer = $section->addFooter();
        $footer->addPreserveText(htmlspecialchars('第{PAGE}页,共{NUMPAGES}页'), null, array('align' => 'center', 'valign' => 'center'));
    }

    /**
     * @param $section
     * @param $result
     */
    private function addPageName($section, $name)
    {
        $section->addText(htmlspecialchars($name), 't1', 'Paragraph');
        $section->addTextBreak();
    }

    /** 试卷头部表格
     * @param $section  \PhpOffice\PhpWord\Element\Section
     * @param $title string
     */
    private function  addTopTable($section, $count = 0)
    {
        $cellCentered = array('align' => 'center', 'valign' => 'center');
        /** @var Table $table */
        $table = $section->addTable('Fancy Table');

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'borderSize' => 0, 'borderColor' => 'white');
        $cellRowContinue = array('vMerge' => 'continue', 'borderSize' => 0, 'borderColor' => 'white');
        $table->addRow();
        $table->addCell(2000, $cellCentered)->addTextRun($cellCentered)->addText("题号", 't4');
        for ($i = 0; $i < $count; $i++) {
            $table->addCell(1000, $cellCentered)->addTextRun($cellCentered)->addText(NumberHelper::number2Chinese($i + 1), 't4');
        }
        $table->addCell(1000, $cellCentered)->addTextRun($cellCentered)->addText("总分", 't4');

        $table->addRow();
        $table->addCell()->addTextRun($cellCentered)->addText("得分", 't4');
        for ($i = 0; $i < $count; $i++) {
            $table->addCell();
        }

        $table->addCell();
        $section->addTextBreak();


    }

    /**
     * 每道大道表格
     * @param $section  \PhpOffice\PhpWord\Element\Section
     * @param $title string
     */
    private function  addTable($section, $title)
    {
        $cellCentered = array('align' => 'center', 'valign' => 'center');
        $table = $section->addTable('Fancy Table');
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'borderSize' => 0, 'borderColor' => 'white');
        $cellRowContinue = array('vMerge' => 'continue', 'borderSize' => 0, 'borderColor' => 'white');
        $table->addRow();
        $table->addCell(2000, $cellCentered)->addTextRun($cellCentered)->addText("评卷人", 't4');
        $table->addCell(2000, $cellCentered)->addTextRun($cellCentered)->addText("得分", 't4');
        $table->addCell(6000, $cellRowSpan)->addTextRun(['valign' => 'center'])->addText(htmlspecialchars('    ' . $title), 't3');
        $table->addRow();
        $table->addCell(2000);
        $table->addCell(2000);
        $table->addCell(null, $cellRowContinue);
        $section->addTextBreak();
    }

    /**
     * @return null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param null $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }


    function __construct($data = null)
    {
        $this->data = $data;
    }
}