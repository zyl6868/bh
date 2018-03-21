<?php

namespace common\models;
use Yii;

/**
 * This is the model class for table "sr_material".
 *
 * @property integer $id
 * @property string $name
 * @property string $matType
 * @property string $provience
 * @property string $city
 * @property string $country
 * @property string $gradeid
 * @property string $subjectid
 * @property string $versionid
 * @property string $kid
 * @property string $chapterId
 * @property string $contentType
 * @property string $school
 * @property string $tags
 * @property string $creator
 * @property string $createTime
 * @property string $updateTime
 * @property string $matDescribe
 * @property string $isDelete
 * @property string $url
 * @property string $disabled
 * @property string $readNum
 * @property string $downNum
 * @property string $chapKids
 * @property string $groupId
 * @property string $access
 * @property integer $favoriteNum
 * @property string $department
 * @property integer $isBoutique
 * @property string $illustration
 */
trait Material
{
    /**
     * 判断当前的备课文件是否是最近一周内创建的
     * @return bool
     */
    public function isNewFile(){
        $week_ago = strtotime('-1 week')*1000;
        if($this->createTime > $week_ago || $this->updateTime > $week_ago){
            return true;
        }
        return false;
    }

}
