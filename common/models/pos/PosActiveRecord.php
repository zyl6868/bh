<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 15-6-30
 * Time: 上午10:46
 */

namespace common\models\pos;


use Yii;

class PosActiveRecord extends \yii\db\ActiveRecord
{


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {

                $db = ShTableSequence::getDb();
                $db->useMaster(function () {
                    if (ShTableSequence::updateAllCounters(['current_seq' => 1], 'table_name=:tableName', [':tableName' => static::tableName()])) {

                        $model = ShTableSequence::find()->where('table_name=:tableName', [':tableName' => static::tableName()])->limit(1)->one();
                        if ($model != null) {
                            $key = $this->primaryKey();
                            $this->setAttribute($key[0], $model->current_seq);
                        }
                    }
                }
                );
            } else {
                //update
            }
            return true;
        } else {
            return false;
        }
    }
//    public function behaviors()
//    {
//        return [
//            'timestamp' => [
//                'class' => 'yii\behaviors\AttributeBehavior',
//                'attributes' => [
//                    ActiveRecord::EVENT_BEFORE_INSERT => ['log_in_time' ],
//                    ActiveRecord::EVENT_BEFORE_UPDATE => ['log_in_time'],
//                ],
//                'value' => new Expression('NOW()'),
//            ],
//        ];
//    }


}