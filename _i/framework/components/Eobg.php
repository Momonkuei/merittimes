<?php

// 這是類似G.php的Eob helper(Eobg)
class Eobg 
{
	/*
	 * XXXXXXXXXXXXXXXX => XXXX-XXXX-XXXX-XXXX
	 */
	public static function format_card($card_number = '')
	{
		if($card_number == '' or strlen($card_number) != 16){
			return;
		}
		$s1 = substr($card_number, 0, 4);
		$s2 = substr($card_number, 4, 4);
		$s3 = substr($card_number, 8, 4);
		$s4 = substr($card_number, 12, 4);
		return $s1.'-'.$s2.'-'.$s3.'-'.$s4;
	}

	// updatecontent專用
	public static function _echo($updatecontent, $field_name, $default_value = 0, $is_d = false, $return = false)
	{
		if(isset($updatecontent[$field_name])){
			if($return){
				return $updatecontent[$field_name];
			} else {
				echo $updatecontent[$field_name];
				return;
			}
		}

		if($return){
			return $default_value;
		} else {
			echo $default_value;
		}
		
	}

	// 因為改變架構，所以is_d的方式不用了，採用自動建欄位的方式來取代，但現在所說的是題外話
	public static function _echox($updatecontent, $field_name, $default_value = 0, $is_d = true, $return = false)
	{
		if($is_d == true){
			if(isset($updatecontent['d'][$field_name])){
				if($return){
					return $updatecontent['d'][$field_name];
				} else {
					echo $updatecontent['d'][$field_name];
					return;
				}
			}
		} else {
			if(isset($updatecontent['d'][$field_name])){
				if($return){
					return $updatecontent['d'][$field_name];
				} else {
					echo $updatecontent['d'][$field_name];
					return;
				}
			}
		}

		if($return){
			return $default_value;
		} else {
			echo $default_value;
		}
		
	}

}
