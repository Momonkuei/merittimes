<?php
if(isset($_SESSION['returnx_defaultAction']) and $_SESSION['returnx_defaultAction'] != ''){
	$tmp01 = $_SESSION['returnx_defaultAction'];
	//echo $tmp01;
	//die;
	$tmp = <<<XXX
	class XXXXXXXX_A extends XXXXXXXX_B
	{
		public \$defaultAction = '$tmp01';
	}
XXX;
	eval($tmp);
} else {
	class XXXXXXXX_A extends XXXXXXXX_B
	{
	}
}
