<?php

namespace schoolmanage\models\pos;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\pos\SeTeachingGroup;
use yii\db\Query;

/**
 * SeTeachingGroupSearch represents the model behind the search form about `common\models\pos\SeTeachingGroup`.
 */
class SeTeachingGroupSearch extends SeTeachingGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'integer'],
            [['schoolID', 'groupName', 'brief', 'subjectID', 'creatorID', 'createTime', 'updateTime', 'isDelete', 'departmentID', 'bookVersionID', 'disabled'], 'safe'],
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
        $query = SeTeachingGroup::find();

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
            'ID' => $this->ID,
        ]);


        $query->andFilterWhere(['in','schoolID',(new Query())->select('schoolID')->from('se_schoolInfo')->andFilterWhere(['like', 'schoolName', $this->schoolID])])
            ->andFilterWhere(['like', 'groupName', $this->groupName])
            ->andFilterWhere(['like', 'brief', $this->brief])
            ->andFilterWhere(['like', 'subjectID', $this->subjectID])
            ->andFilterWhere(['like', 'creatorID', $this->creatorID])
            ->andFilterWhere(['like', 'createTime', $this->createTime])
            ->andFilterWhere(['like', 'updateTime', $this->updateTime])
            ->andFilterWhere(['like', 'isDelete', $this->isDelete])
            ->andFilterWhere(['like', 'departmentID', $this->departmentID])
            ->andFilterWhere(['like', 'bookVersionID', $this->bookVersionID])
            ->andFilterWhere(['like', 'disabled', $this->disabled]);

        return $dataProvider;
    }
}
