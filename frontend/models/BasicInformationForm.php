<?php
namespace frontend\models;

use yii\base\Model;

/**\
 *基本信息的修改
 * Created by liuxing
 * User: Administrator
 * Date: 16-9-18
 * Time: 下午16:24
 */
class BasicInformationForm extends Model
{
    public $trueName;
    public $bindphone;
    public $phoneReg;
    public $sex;
    public $department;
    public $subjectID;
    public $textbookVersion;
    public $userId;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [[  'trueName','bindphone','phoneReg','sex','department','subjectID', 'textbookVersion','userId'], 'safe'],
        ];
    }


    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'trueName' => 'trueName',
            'bindphone' => 'bindphone',
            'phoneReg' => 'phoneReg',
            'sex' => 'sex',
            'department' => 'department',
            'subjectID' => 'subjectID',
            'textbookVersion' => 'textbookVersion',
            'userId' => 'userId'
        );
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex)
    {
        if ($sex==null){
            $this->sex=0;
        }else {
            $this->sex = $sex;
        }
    }

    /**
     *老师保存基本信息
     * @return bool
     */
    public function save()
    {
        $userModel = loginUser()->getModel();
        $userModel -> department = $this->department;
        $userModel -> subjectID = $this->subjectID;
        $userModel -> textbookVersion = $this->textbookVersion;
        $userModel -> sex = $this->sex;
        if($userModel->save(false)){
            return true;
        }
        return false;
    }

}