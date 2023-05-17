<?php

/*
 * 2017-10-20
 * 這個是李哥做的
 */
class numericcodeutf8 extends CValidator
{
	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel $object the object being validated
	 * @param string $attribute the attribute being validated
	 */
	protected function validateAttribute($object,$attribute)
	{
		$object->$attribute = $this->numeric_code_utf8($object->$attribute);
	}

	//2017/10/13 增加特殊字元處理函式 by lota
	//http://blog.roodo.com/linpapa/archives/9731565.html
	//http://k79.com/unicode-character-set-map/special-chracters-codes-for-unicode-html.php?perpage=200&start=166632
	protected function numeric_code_utf8($utf8_string)
	{ 
		$out = ""; 
		$ns = strlen ($utf8_string); 
		for ($nn = 0; $nn < $ns; $nn++) { 
			$ch = $utf8_string[$nn]; 
			$ii = ord ($ch); 

			if ($ii < 128) 
		        $out .= $ch; 
			else if ($ii >>5 == 6) { //普通字
				$b1 = ($ii & 31); 
				$nn++; 
				$ch = $utf8_string [$nn]; 
				$ii = ord ($ch); 
				$b2 = ($ii & 63); 
				$ii = ($b1 * 64) + $b2; 
				$ent = sprintf ("&#%d;", $ii); 
				$ent = mb_convert_encoding($ent, 'UTF-8', 'HTML-ENTITIES');//為了用正常的字元寫入資料庫
				$out .= $ent; 				
			} 
			else if ($ii >>4 == 14) { //特殊字 I
				$b1 = ($ii & 31); 
				$nn++; 
				$ch = $utf8_string [$nn]; 
				$ii = ord ($ch); 
				$b2 = ($ii & 63); 
				$nn++; 
				$ch = $utf8_string [$nn]; 
				$ii = ord ($ch); 
				$b3 = ($ii & 63); 
				$ii = ((($b1 * 64) + $b2) * 64) + $b3; 
				$ent = sprintf ("&#%d;", $ii); 
				$ent = mb_convert_encoding($ent, 'UTF-8', 'HTML-ENTITIES');//為了用正常的字元寫入資料庫
				$out .= $ent; 				
			} 
			else if ($ii >>3 == 30) { //特殊字 II
				$b1 = ($ii & 31); 
				$nn++; 
				$ch = $utf8_string [$nn]; 
				$ii = ord ($ch); 
				$b2 = ($ii & 63); 
				$nn++; 
				$ch = $utf8_string [$nn]; 
				$ii = ord ($ch); 
				$b3 = ($ii & 63); 
				$nn++; 
				$ch = $utf8_string [$nn]; 
				$ii = ord ($ch); 
				$b4 = ($ii & 63); 
				$ii = ((((($b1 * 64) + $b2) * 64) + $b3) * 64) + $b4 - 4194304; //這邊是用計算機算出來的數字 4194304
				$ent = sprintf ("&#%d;", $ii); 
				//$ent = mb_convert_encoding($ent, 'UTF-8', 'HTML-ENTITIES'); //mb_convert_encoding 還沒辦法解譯這邊的字元
				$out .= $ent; 
			} 
		} 
		return $out; 
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
