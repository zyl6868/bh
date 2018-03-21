<?php

namespace schoolmanage\models\pos;

use common\helper\StringHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\pos\SeClass;

/**
 * SeClassSearch represents the model behind the search form about `common\models\pos\SeClass`.
 */
class SeClassSearch extends SeClass
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['classID'], 'integer'],
            [['className', 'schoolID', 'createTime', 'updateTime', 'isDelete', 'ownStuList', 'joinYear', 'classNumber', 'gradeID', 'stuID', 'creatorID', 'department', 'disabled', 'logoUrl'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SeClass::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'classID' => $this->classID,
        ]);

        $query->andFilterWhere(['like', 'className', $this->className])

            ->andFilterWhere(['like', 'createTime', $this->createTime])

            ->andFilterWhere(['like', 'updateTime', $this->updateTime])
            ->andFilterWhere(['like', 'ownStuList', $this->ownStuList])
            ->andFilterWhere(['like', 'joinYear', $this->joinYear])
            ->andFilterWhere(['like', 'classNumber', $this->classNumber])
            ->andFilterWhere(['like', 'gradeID', $this->gradeID])
            ->andFilterWhere(['like', 'stuID', $this->stuID])
            ->andFilterWhere(['like', 'creatorID', $this->creatorID])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'disabled', $this->disabled])
            ->andFilterWhere(['like', 'logoUrl', $this->logoUrl]);


        if(!StringHelper::isempty($this->schoolID))
        {
            $query->andWhere(' schoolID in  (select schoolID from se_schoolInfo where schoolName like  :schoolName ) ',[':schoolName'=> $this->schoolID."%"]);
        }

        return $dataProvider;
    }
}
