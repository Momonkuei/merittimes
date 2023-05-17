<?php

/*
 * 通常是多選欄位在使用的，把陣列改成用逗點分隔的方式來存
 */
class arraycomma extends CValidator
{
	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel $object the object being validated
	 * @param string $attribute the attribute being validated
	 */
	protected function validateAttribute($object,$attribute)
	{
		// 這裡新增的部份有點問題，記得要debug(應該OK了 2015/06/09)
		if(is_array($object->$attribute) and count($object->$attribute) > 0){
			foreach($object->$attribute as $row);
			// 有些時候不是在送出的時候使用validate()
			if(!is_array($row)){
				$object->$attribute = implode(',', $object->$attribute);
			}
		// 新增的時候會出現這種狀況
		} elseif(is_string($object->$attribute) and strlen($object->$attribute) > 0){
			// do nothing，直接寫進資料表
		} else {
			$object->$attribute = '';
		}
		//echo $object->$attribute;
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
