<?php

namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeQuestionResult]].
 *
 * @see SeQuestionResult
 */
class SeQuestionResultQuery extends \yii\db\ActiveQuery
{
	public function active()
	{
		$this->andWhere('[[isDelete]]=0');
		return $this;
	}

	/**
	 * @inheritdoc
	 * @return SeQuestionResult[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * @inheritdoc
	 * @return SeQuestionResult|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}