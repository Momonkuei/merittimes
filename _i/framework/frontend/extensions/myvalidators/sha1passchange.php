<?php

/*
 * SHA1密碼欄位所使用，有值的時候SHA1，沒有值的時候跳過
 */
class sha1passchange extends CValidator
{
	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel $object the object being validated
	 * @param string $attribute the attribute being validated
	 */
	protected function validateAttribute($object,$attribute)
	{
		if(strlen($object->$attribute) > 0){
			$object->$attribute = sha1($object->$attribute);
		} else {
			// 可以這樣刪除的理由，是因為，建立Object的那個地方：
			// framework/db/ar/CActiveRecord
			// 有寫__unset的method
			unset($object->$attribute);
		}
	}

	/**
	 * Returns the JavaScript needed for performing client-side validation.
	 * @param CModel $object the data object being validated
	 * @param string $attribute the name of the attribute to be validated.
	 * @return string the client-side validation script.
	 * @see CActiveForm::enableClientValidation
	 */
	// 因為我目前沒有要用到clientsite的屬性驗證，應該是搭配form yii元件在做的
	// 不回傳東西出來，吧...
	//public function clientValidateAttribute($object,$attribute)
	//{
	//	return;
	//}
}
