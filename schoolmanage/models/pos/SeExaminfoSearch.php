<?php

namespace schoolmanage\models\pos;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\pos\SeExaminfo;

/**
 * SeExaminfoSearch represents the model behind the search form about `common\models\pos\SeExaminfo`.
 */
class SeExaminfoSearch extends SeExaminfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['examID'], 'integer'],
            [['classID', 'creatTime', 'creater', 'isDelete', 'evaluate', 'isChecked', 'classScore', 'examName', 'type', 'schoolYear', 'semester', 'disabled', 'learnSituation', 'commonPro', 'improveAdvise', 'isHavePaper', 'isHaveScore', 'isHaveCEva'], 'safe'],
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
        $query = SeExaminfo::find();

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
            'examID' => $this->examID,
        ]);

        $query->andFilterWhere(['like', 'classID', $this->classID])
            ->andFilterWhere(['like', 'creatTime', $this->creatTime])
            ->andFilterWhere(['like', 'creater', $this->creater])
            ->andFilterWhere(['like', 'isDelete', $this->isDelete])
            ->andFilterWhere(['like', 'evaluate', $this->evaluate])
            ->andFilterWhere(['like', 'isChecked', $this->isChecked])
            ->andFilterWhere(['like', 'classScore', $this->classScore])
            ->andFilterWhere(['like', 'examName', $this->examName])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'schoolYear', $this->schoolYear])
            ->andFilterWhere(['like', 'semester', $this->semester])
            ->andFilterWhere(['like', 'disabled', $this->disabled])
            ->andFilterWhere(['like', 'learnSituation', $this->learnSituation])
            ->andFilterWhere(['like', 'commonPro', $this->commonPro])
            ->andFilterWhere(['like', 'improveAdvise', $this->improveAdvise])
            ->andFilterWhere(['like', 'isHavePaper', $this->isHavePaper])
            ->andFilterWhere(['like', 'isHaveScore', $this->isHaveScore])
            ->andFilterWhere(['like', 'isHaveCEva', $this->isHaveCEva]);

        return $dataProvider;
    }
}
