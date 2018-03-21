<?php
namespace frontend\models;
/**
 * Created by PhpStorm.
 * User: gaocailong
 * Date: 14-9-22
 * Time: 下午4:28
 */
class TopicModel
{
    private $data = array();

    function __construct($groupID, $userID)
    {

        $this->data = $this->getDate($groupID, $userID);
    }

    /**
     * 查询课题成员
     */
    public function getDate($groupID, $userID)
    {

        $result = new pos_TeachingGroupService();
        $modelList = $result->searchMemberFromGroup($groupID, $userID);
        if ($modelList->resCode == "000000") {
            return $modelList->data->memberList;

        }


    }


    /**
     * 调用静态方法
     * @param null $groupID
     * @param null $userID
     * @return TopicModel
     */
    public static function model($groupID = null, $userID = null)
    {
        $staticModel = new self($groupID, $userID);
        return $staticModel;
    }

}