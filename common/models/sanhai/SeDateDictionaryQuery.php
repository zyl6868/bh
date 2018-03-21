<?php

namespace common\models\sanhai;
use yii\helpers\ArrayHelper;

/**
 * This is the ActiveQuery class for [[SeDateDictionary]].
 *
 * @see SeDateDictionary
 */
class SeDateDictionaryQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }

    /**
     * @inheritdoc
     * @return SeDateDictionary[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SeDateDictionary|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public  function   findNameByCode($code)
    {
        $this->andWhere('[[secondCode]]=code',['code'=>$code])->limit(1)->one();
    }

    public  function   findNameByStrCode($strCode,$sp=',')
    {
        if (empty($strCode))
        {
            return '';
        }

        $arr=  explode($sp,$strCode);

        if (empty($arr))
        {
            return '';
        }


        $result= $this->andWhere(['in','secondCode',$arr])->select('secondCodeValue')->asArray()->all();
        return implode($sp,  ArrayHelper::getColumn($result,'secondCodeValue'));
    }





}