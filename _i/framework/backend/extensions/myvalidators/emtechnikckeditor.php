<?php

/*
 * 依特專屬的ckeditor處理方式
 *
 * <a href="../../../../assets/i/...">xxx</a>
 * 就是處理../../的東西，打算處理3, 4, 5層，處理成0層
 */
class emtechnikckeditor extends CValidator
{
	/**
		*  * Validates the attribute of the object.
		*   * If there is any error, the error message is added to the object.
		*    * @param CModel $object the object being validated
		*     * @param string $attribute the attribute being validated
		*      */
	protected function validateAttribute($object,$attribute)
	{
		if(strlen($object->$attribute) > 0){
			$return = '';
			$tmp = explode("\n", $object->$attribute);
			if(count($tmp) > 0){
				foreach($tmp as $k => $v){
					if(trim($v) == '') continue;
					$v = str_replace('"../../../../../', '"', $v);
					$v = str_replace('"../../../../', '"', $v);
					$v = str_replace('"../../../', '"', $v);
					$v = str_replace('"../../', '"', $v);
					$v = str_replace('"../', '"', $v);
					$tmp[$k] = $v;
				}
				$return = implode("\n", $tmp);
			}
			$object->$attribute = $return;
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
	//public function clientValidateAttribute($object,$attribute)
	//{
	//	return;
	//}
}
