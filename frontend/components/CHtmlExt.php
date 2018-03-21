<?php

namespace frontend\components;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

/**
 * Created by PhpStorm.
 * User: yj
 * Date: 14-1-19
 * Time: 下午2:31
 */
class CHtmlExt extends Html
{
    const ID_PREFIX = 'yt';
    public static $errorMessageCss = 'error';
    /**
     * @var string the CSS class for highlighting error inputs. Form inputs will be appended
     * with this CSS class if they have input errors.
     */
    public static $errorCss = 'error';
    /**
     * @var string the tag name for the error container tag. Defaults to 'div'.
     * @since 1.1.13
     */
    public static $errorContainerTag = 'p';

    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     * @param array $htmlOptions
     * @return string
     */
    public static function error($model, $attribute, $htmlOptions = array())
    {
        $attribute = static::getAttributeName($attribute);
        $error = $model->getFirstError($attribute);
        $tag = isset($options['tag']) ? $options['tag'] : 'div';
        $encode = !isset($options['encode']) || $options['encode'] !== false;
        unset($options['tag'], $options['encode']);
        return Html::tag($tag, $encode ? Html::encode($error) : $error, $options);
    }

    /**  validationError
     * @param \yii\base\Model $model
     * @param $attribute
     * @param $type "pass", "error", "load"
     * @return string
     */
    public static function validationEngineError($model, $attribute, $id = null, $type = 'error')
    {
        if (empty($id)) {
            /** @var TYPE_NAME $id */
            $id = self::getInputId($model, $attribute);
        }
        $error = $model->getFirstError($attribute);
        if ($error != null) {
            \Yii::$app->view->registerJs("$('#" . $id . "').validationEngine('showPrompt', '$error', '$type');", View::POS_READY, "$attribute");
        }
    }

//    public static function dropDownList($name, $selection = null, $items = [], $options = [])
//    {
//        if (!empty($options['multiple'])) {
//            return static::listBox($name, $selection, $items, $options);
//        }
//        $options['name'] = $name;
//        unset($options['unselect']);
//        $selectOptions = static::renderSelectOptions($selection, $items, $options);
//        return static::tag('select', "\n" . $selectOptions . "\n", $options);
//    }


    /**
     * @param string $name
     * @param null $selection
     * @param array $items
     * @param array $options
     * @return string
     */
    public static function dropDownList($name, $selection = null, $items = [], $options = [])
    {
        if (!empty($options['ajax'])) {
            unset($options['ajax']);
        }

        if (!empty($options['multiple'])) {
            return static::listBox($name, $selection, $items, $options);
        }
        $options['name'] = $name;
        unset($options['unselect']);
        $selectOptions = static::renderSelectOptions($selection, $items, $options);
        return static::tag('select', "\n" . $selectOptions . "\n", $options);
    }

    /** 有ajax下列列表
     * @param $name
     * @param null $selection
     * @param array $items
     * @param array $options
     * @return string
     */
    public static function dropDownListAjax($name, $selection = null, $items = [], $options = [])
    {
        if (!empty($options['multiple'])) {
            unset($options['unselect']);
            return static::listBox($name, $selection, $items, $options);
        }

        $options['name'] = $name;
        unset($options['unselect']);
        self::clientChange('change', $options);
        $selectOptions = static::renderSelectOptions($selection, $items, $options);

        if (!isset($options['id']))
            $options['id'] = self::getIdByName($name);
        elseif ($options['id'] === false)
            unset($options['id']);


        if (isset($options['defaultValue']) && $options['defaultValue']) {
            unset($options['defaultValue']);
        }
        $selectOptions = "\n" . $selectOptions;


        // add a hidden field so that if the option is not selected, it still submits a value
        return self::tag('select', $selectOptions, $options);
    }

    /**
     * @param $event
     * @param $htmlOptions
     */
    protected static function clientChange($event, &$htmlOptions)
    {
        if (!isset($htmlOptions['submit']) && !isset($htmlOptions['confirm']) && !isset($htmlOptions['ajax']))
            return;

//        if (isset($htmlOptions['live'])) {
//            $live = $htmlOptions['live'];
//            unset($htmlOptions['live']);
//        } else
//            $live = self::$liveEvents;

        if (isset($htmlOptions['return']) && $htmlOptions['return'])
            $return = 'return true';
        else
            $return = 'return false';

        if (isset($htmlOptions['on' . $event])) {
            $handler = trim($htmlOptions['on' . $event], ';') . ';';
            unset($htmlOptions['on' . $event]);
        } else
            $handler = '';

        if (isset($htmlOptions['id']))
            $id = $htmlOptions['id'];
        else
            $id = $htmlOptions['id'] = isset($htmlOptions['name']) ? $htmlOptions['name'] : self::ID_PREFIX . self::$count++;

        $cs = \Yii::$app->getView();

        if (isset($htmlOptions['ajax']))
            $handler .= self::ajax($htmlOptions['ajax']) . "{$return};";

//        if (isset($htmlOptions['confirm'])) {
//            $confirm = 'confirm(\'' . CJavaScript::quote($htmlOptions['confirm']) . '\')';
//            if ($handler !== '')
//                $handler = "if($confirm) {" . $handler . "} else return false;";
//            else
//                $handler = "return $confirm;";
//        }

        $cs->registerJs("jQuery('#$id').on('$event', function(){{$handler}});");
        unset($htmlOptions['params'], $htmlOptions['submit'], $htmlOptions['ajax'], $htmlOptions['confirm'], $htmlOptions['return'], $htmlOptions['csrf']);
    }

    /**
     * @param $options
     * @return string
     */
    public static function ajax($options)
    {

        if (!isset($options['url']))
            $options['url'] = new JsExpression('location.href');
        else
            $options['url'] = Url::to($options['url']);
        if (!isset($options['cache']))
            $options['cache'] = false;
        if (!isset($options['data']) && isset($options['type']))
            $options['data'] = new JsExpression('jQuery(this).parents("form").serialize()');
        foreach (array('beforeSend', 'complete', 'error', 'success') as $name) {
            if (isset($options[$name]) && !($options[$name] instanceof JsExpression))
                $options[$name] = new JsExpression($options[$name]);
        }
        if (isset($options['update'])) {
            if (!isset($options['success']))
                $options['success'] = new JsExpression('function(html){jQuery("' . $options['update'] . '").html(html)}');
            unset($options['update']);
        }
        if (isset($options['replace'])) {
            if (!isset($options['success']))
                $options['success'] = new JsExpression('function(html){jQuery("' . $options['replace'] . '").replaceWith(html)}');
            unset($options['replace']);
        }
        return 'jQuery.ajax(' . Json::encode($options) . ');';
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function getIdByName($name)
    {
        return str_replace(['[]', '][', '[', ']', ' ', '.'], ['', '-', '-', '', '-', '-'], $name);
    }


    /**
     * 定制校式下拉
     * @param $name
     * @param null $selection
     * @param array $items
     * @param array $options
     * @return string
     */
    public static function dropDownListCustomize($name, $selection = null, $items = [], $options = [])
    {
        if (!empty($options['multiple'])) {
            unset($options['unselect']);
            return static::listBox($name, $selection, $items, $options);
        }

        $options['name'] = $name;
        unset($options['unselect']);
        self::clientChange('change', $options);




        if (!isset($options['id']))
            $options['id'] = self::getIdByName($name);
        elseif ($options['id'] === false)
            unset($options['id']);


        $i = "<i></i>";
        $em = "<em>" . self::listExt($selection, $items, $options) . "</em>";
            unset($options['defaultValue']);
        $selectOptions = static::renderSelectOptions($selection, $items, $options);
        $selectOptions = "\n" . $selectOptions;

        $hidden = '';

        // add a hidden field so that if the option is not selected, it still submits a value
        return $i . $em . $hidden . self::tag('select', $selectOptions, $options);
    }

    /**
     * @param $selection
     * @param $listData
     * @param $htmlOptions
     * @return int|string
     */
    private static function listExt($selection, $listData, &$htmlOptions)
    {
        $content = '';
        if (isset($htmlOptions['prompt'])) {
                $content .= $content . static::encode($htmlOptions['prompt']) ;
        }


        $key = isset($htmlOptions['key']) ? $htmlOptions['key'] : 'primaryKey';
        if (is_array($selection)) {
            foreach ($selection as $i => $item) {
                if (is_object($item))
                    $selection[$i] = $item->$key;
            }
        } elseif (is_object($selection))
            $selection = $selection->$key;

        foreach ($listData as $key => $value) {
            if (is_array($value)) {
            } else {
                if (!is_array($selection) && empty($content)) {
                    $content = $value;
                    break;
                }
            }
        }

        foreach ($listData as $key => $value) {
            if (is_array($value)) {
            } else {

                if (!is_array($selection) && !strcmp($key, $selection) || is_array($selection) && in_array($key, $selection))
                    return $value;
            }
        }

        return $content;
    }

    public static function activeDropDownList($model, $attribute, $items, $options = [])
    {

        if (isset($options['ajax'])) {
            unset  ($options['ajax']);
        }

        if (empty($options['multiple'])) {
            return static::activeListInput('dropDownList', $model, $attribute, $items, $options);
        } else {
            return static::activeListBox($model, $attribute, $items, $options);
        }


    }

    public static function activeDropDownListAjax($model, $attribute, $items, $options = [])
    {
        return static::activeListInput('dropDownListAjax', $model, $attribute, $items, $options);
    }

    public static function activeDropDownListCustomize($model, $attribute, $items, $options = [])
    {
        return static::activeListInput('dropDownListCustomize', $model, $attribute, $items, $options);
    }
}