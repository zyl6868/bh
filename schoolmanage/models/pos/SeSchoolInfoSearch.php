<?php

namespace schoolmanage\models\pos;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\pos\SeSchoolInfo;

/**
 * SeSchoolInfoSearch represents the model behind the search form about `common\models\pos\SeSchoolInfo`.
 */
class SeSchoolInfoSearch extends SeSchoolInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schoolID'], 'integer'],
            [['schoolName', 'nickName', 'department', 'lengthOfSchooling', 'createTime', 'updateTime', 'isDelete', 'schoolAddress', 'brief', 'provience', 'city', 'country', 'ispass', 'reason', 'creatorID', 'trainingSchool', 'logoUrl', 'newLenOfSch', 'newLenOfSchDate', 'disabled', 'newDepartment', 'isNeedReviewDepartment'], 'safe'],
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
        $query = SeSchoolInfo::find();

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
            'schoolID' => $this->schoolID,
        ]);

        $query->andFilterWhere(['like', 'schoolName', $this->schoolName])
            ->andFilterWhere(['like', 'nickName', $this->nickName])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'lengthOfSchooling', $this->lengthOfSchooling])
            ->andFilterWhere(['like', 'createTime', $this->createTime])
            ->andFilterWhere(['like', 'updateTime', $this->updateTime])
            ->andFilterWhere(['like', 'schoolAddress', $this->schoolAddress])
            ->andFilterWhere(['like', 'brief', $this->brief])
            ->andFilterWhere(['like', 'provience', $this->provience])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'ispass', $this->ispass])
            ->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'creatorID', $this->creatorID])
            ->andFilterWhere(['like', 'trainingSchool', $this->trainingSchool])
            ->andFilterWhere(['like', 'logoUrl', $this->logoUrl])
            ->andFilterWhere(['like', 'newLenOfSch', $this->newLenOfSch])
            ->andFilterWhere(['like', 'newLenOfSchDate', $this->newLenOfSchDate])
            ->andFilterWhere(['like', 'disabled', $this->disabled])
            ->andFilterWhere(['like', 'newDepartment', $this->newDepartment])
            ->andFilterWhere(['like', 'isNeedReviewDepartment', $this->isNeedReviewDepartment]);

        return $dataProvider;
    }
}
