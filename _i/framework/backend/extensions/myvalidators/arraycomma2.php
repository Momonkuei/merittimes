<?php

/*
 * 通常是多選欄位在使用的，並且加上頭尾兩個逗號
 * 把陣列改成用逗點分隔的方式來存
 */
class arraycomma2 extends CValidator
{
	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel $object the object being validated
	 * @param string $attribute the attribute being validated
	 */
	protected function validateAttribute($object,$attribute)
	{
		if(is_array($object->$attribute) and count($object->$attribute) > 0){
			$object->$attribute = ','.implode(',', $object->$attribute).',';
		} else {
			$object->$attribute = '';
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
