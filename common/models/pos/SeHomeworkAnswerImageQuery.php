<?php
/**
 * Created by PhpStorm.
 * User: gaoling
 * Date: 2015/11/20
 * Time: 13:51
 */


namespace common\models\pos;

/**
 * This is the ActiveQuery class for [[SeHomeworkAnswerImage]].
 *
 * @see SeHomeworkAnswerImage
 */
class SeHomeworkAnswerImageQuery extends \yii\db\ActiveQuery
{
	/*public function active()
	{
		$this->andWhere('[[status]]=1');
		return $this;
	}*/

	/**
	 * @inheritdoc
	 * @return SeHomeworkAnswerImage[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * @inheritdoc
	 * @return SeHomeworkAnswerImage|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}