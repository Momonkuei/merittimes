<?php

class ignoreall extends CValidator
{
	/**
		*  * Validates the attribute of the object.
		*   * If there is any error, the error message is added to the object.
		*    * @param CModel $object the object being validated
		*     * @param string $attribute the attribute being validated
		*      */
	protected function validateAttribute($object,$attribute)
	{
	}

	/**
	 * Returns the JavaScript needed for performing client-side validation.
	 * @param CModel $object the data object being validated
	 * @param string $attribute the name of the attribute to be validated.
	 * @return string the client-side validation script.
	 * @see CActiveForm::enableClientValidation
	 */
	// 因為我目前沒有要用到clientsite的屬性驗證，應該是搭配form yii元件在做的
	public function clientValidateAttribute($object,$attribute)
	{
		return;
	}
}
