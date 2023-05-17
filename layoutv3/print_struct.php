<meta charset="utf-8">
<?php

/*
 * 這個檔案有需要在使用
 */
$br = '<br />'."\n";

// 先簡化結構
$page_dbug = $page[0]['hole']['0_0']['hole']['0_0'];

echo '/* 結構圖'.$br;
new dBug($page_dbug);
echo '*/'.$br;

echo $br;

$return = '';
foreach($layoutv3_struct as $k => $v){
	$tmp = explode('|', $v);
	$return .= '&nbsp;*&nbsp;'.$tmp[0].' &nbsp;&nbsp;'.$tmp[1];
	if($tmp[1] == '-group'){
		$return .= ' ( node )';
	} else {
		$return .= '.php';
	}
	$return .= $br;
}
echo '/* 各檔案資料編號對照表'.$br;
echo $return;
echo '*/'.$br;


/*
 * 程式範例
 */

echo $br;

$return = <<<XXX
== Yii 的寫法 ==

// 通用資料表多筆
// \$data[\$ID] = \$this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>'請改我',':ml_key'=>\$this->data['ml_key']))->order('sort_id')->limit(3)->queryAll();
// \$data[\$ID] = \$this->cidb->where('is_enable',1)->where('type','請改我')->where('ml_key',\$this->data['ml_key'])->order_by('sort_id','asc')->limit(1)->get('html')->result_array();

// 一般資料表多筆
// \$data[\$ID] = \$this->db->createCommand()->from('請改我')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>\$this->data['ml_key']))->order('sort_id')->limit(3)->queryAll();
// \$data[\$ID] = \$this->cidb->where('is_enable',1)->where('ml_key',\$this->data['ml_key'])->order_by('sort_id','asc')->limit(1)->get('請改我')->result_array();

// 通用資料表單筆
// \$data[\$ID] = \$this->db->createCommand()->from('html')->where('is_enable=1 and id=:id',array(':id'=>'請改我'))->queryRow();
// \$data[\$ID] = \$this->cidb->where('is_enable',1)->where('id','請改我')->get('html')->row_array();

// 一般資料表單筆
// \$data[\$ID] = \$this->db->createCommand()->from('資料表')->where('is_enable=1 and id=:id',array(':id'=>'請改我'))->queryRow();
// \$data[\$ID] = \$this->cidb->where('is_enable',1)->where('id','請改我')->get('資料表')->row_array();

// 迴圈範例1
if(isset(\$data[\$ID]) and count(\$data[\$ID]) > 0){
	foreach(\$data[\$ID] as \$k => \$v){
	}
}

// 迴圈範例2
<?php if(isset(\$data[\$ID]) and count(\$data[\$ID]) > 0):?>
	<?php foreach(\$data[\$ID] as \$k => \$v):?>
	<?php endforeach?>
<?php endif?>

// 迴圈範例3
if(isset(\$rows) and count(\$rows) > 0){
	foreach(\$rows as \$k => \$v){
	}
}

// 迴圈範例4
<?php if(isset(\$rows) and count(\$rows) > 0):?>
	<?php foreach(\$rows as \$k => \$v):?>
	<?php endforeach?>
<?php endif?>

// 切割陣列，2個一組
array_chunk(\$input_array, 2)

== CIg (Codeigniter2) 的寫法 ==

== 寫入

\$save = array(
　'id' => 123,
　'name' => '456',
);
\$this->cidb->insert('html', \$save); 
\$id = \$this->cidb->insert_id();
// echo \$this->cidb->affected_rows();

== 更新

\$data = array(
　'title' => \$title,
　'name' => \$name,
　'date' => \$date
);

\$this->cidb->where('id', \$id);
\$this->cidb->update('mytable', \$data); 
// echo \$this->cidb->affected_rows();

== 刪除

\$this->cidb->delete('mytable', array('id' => \$id)); 
// echo \$this->cidb->affected_rows();

== 寫入 (orm)

// 跟後台功能的orm規則連動
\$admin_field_router_class = \$this->data['router_method'];
\$admin_field_section_id = 0;

include _BASEPATH.'/../source/include/admin_field_get.php';

\$savedata = \$_POST;

// 現在連絡我們表單的功能己經改成多語系
\$savedata['ml_key'] = \$this->data['ml_key'];

\$orm = new gorm(\$this->cidb, \$admin_def['empty_orm_data']);
\$orm->data(\$savedata);
\$status = \$orm->validate(); // 回傳true或false

if(\$status === false){
	// var_dump(\$orm->message());
	\$redirect_url = \$this->data['router_method'].'_'.\$this->data['ml_key'].'.php';
	G::alert_captcha(t('欄位資料驗證失敗'), \$redirect_url, \$this->data);
}

\$status = \$orm->insert(); // 回傳寫入狀態
// $id = \$this->cidb->insert_id();

if(\$status === false){
	\$redirect_url = \$this->data['router_method'].'_'.\$this->data['ml_key'].'.php';
	G::alert_captcha(t('寫入失敗'), \$redirect_url, \$this->data);
}

G::alert_captcha(t('寫入成功'), \$redirect_url, \$this->data);

== 更新 (orm)

// 跟後台功能的orm規則連動
\$admin_field_router_class = \$this->data['router_method'];
\$admin_field_section_id = 0;

include _BASEPATH.'/../source/include/admin_field_get.php';
unset(\$admin_def['empty_orm_data']['rules'][0]); // remove login_account, login_password

\$update = \$_POST;

\$orm = new gorm(\$this->cidb, \$admin_def['empty_orm_data']);
\$orm->data(\$update);
\$orm->find_by_id(\$this->data['admin_id']);
\$status = \$orm->validate(); // 回傳true或false

if(\$status === false){
	// var_dump(\$orm->message());
	\$redirect_url = $this->data['router_method'].'_'.\$this->data['ml_key'].'.php';
	G::alert_captcha(t('欄位資料驗證失敗'), \$redirect_url, \$this->data);
}

\$status = \$orm->update(); // 回傳寫入狀態
// \$id = \$db->insert_id();

if(\$status === false){
	\$redirect_url = \$this->data['router_method'].'_'.\$this->data['ml_key'].'.php';
	G::alert_captcha(t('寫入失敗'), \$redirect_url, \$this->data);
}

G::alert_captcha(t('修改成功'), \$redirect_url, \$this->data);

== 其它

// 用編號直接指定資料 (請參考上面的 "各檔案資料編號對照表" )
\$data['0-1-0-1'] = array('ggg','aaa');

// 想查詢某一編號是什麼東西
echo \$layoutv3_struct_map['0-1-0-1'];

/*
 * 想指定資料，但想要用檔案名稱而不想要用編號的寫法
 * 請看底下兩個範本
 */

// 一般區塊 - 資料指定 - 範本
\$view_file = 'news/type1_1';
if(isset(\$layoutv3_struct_map_keyname[\$view_file][0])){
	\$data[\$layoutv3_struct_map_keyname[\$view_file][0]] = array('ggg','aaa');
}

// 動態區塊 - 資料指定 - 範本
\$view_file = 'dynamic_third_party';
\$dynamic_view_file = 'sample';
if(isset(\$layoutv3_struct_map_keyname[\$view_file][0])){
	\$data[\$layoutv3_struct_map_keyname[\$view_file][0]][\$dynamic_view_file] = array('ggg','aaa');
}

// 2020-08-07
// 在程式碼透過規則來把資料流送出去給多個view

/*
 * 動態區塊使用條件
 */
// 1. view裡面，必需要有這一行 array('file' => 'dynamic_third_party'),
// 2. page_source必需要有，而且要載入這一行 'share-third_party_post',
// 3. view/third_party裡面，必需要有動態區塊的存在
// 4. 在主程式裡面，需要有這一行 \$third_party[] = 'sample'; // 這是範本
// 5. layoutv3的init，必需要有這一行，\$third_party = array();，而這一個是在\$page = array();和\$data = array();的底下 

/*
 * 在view裡面，想要載入某一支source程式的作法
 * 其中ggg代表資料流的名稱，看var_dump就可以明白了
 *
 * "V1第二版的無限層功能的v3_source資料流己有支援"
 */
<\?php // \$old_id=\$ID;\$ID='ggg';include 'source/menu/sub.php';\$ID=\$old_id?>
<\?php \$old_router_method=\$this->data['router_method'];\$this->data['router_method']='faq';\$old_id=\$ID;\$ID='faq';include 'source/faq/type.php';\$ID=\$old_id;\$this->data['router_method']=\$old_router_method?>
<\?php var_dump(\$data['ggg'])?>

XXX;
echo nl2br($return);

echo $br;

?>
== 在View裡面，想要把東西放到HTML的最上面、或是最下面地方的方式

<pre>

<？php \$\${CONNECT_A} = \$ID // 這一行，是要帶東西到底下的裡面去?>

<？php if(0):？><!-- head_start -->
< script type="text/javascript">
// head start
< /script>
<？php endif？><!-- head_start -->

<？php if(0):?><!-- head_end -->
< script type="text/javascript">
// head end 
< /script>
<？php endif？><!-- head_end -->

<？php if(0):?><!-- head_end:aaa -->
< script type="text/javascript">
// head end:aaa 
< /script>
<？php endif？><!-- head_end:aaa -->

<？php if(0):？><!-- body_start -->
< script type="text/javascript">
// body start
< /script>
<？php endif？><!-- body_start -->

<？php if(0):？><!-- body_end -->
< script type="text/javascript">
// body end 
var ggg_id = '<？php echo $${CONNECT_A}？>';
alert(ggg_id);
< /script>
<？php endif？><!-- body_end -->

<？php if(0):？><!-- body_end:bbb -->
< script type="text/javascript">
// body end:bbb
< /script>
<？php endif？><!-- body_end:bbb -->


<!-- func|start|remove_new_line -->
<div>
	<span>這裡是壓縮HTML</span>
</div>
<!-- func|end|remove_new_line -->

</pre>

<?php

echo $br;

$return = '';
foreach($layoutv3_struct as $k => $v){
	$tmp = explode('|', $v);
	$return .= '// '.$tmp[1].' 的程式請放這裡'.$br;
	if($tmp[1] == '-group'){
		$return .= '// 通常節點是沒有程式的'.$br;
	}
	if($k == 0){
		$aaa = <<<XXX
// \$data[\$ID] = array(
// &nbsp;&nbsp;array(
// &nbsp;&nbsp;&nbsp;&nbsp;'topic' => '123',
// &nbsp;&nbsp;&nbsp;&nbsp;'url' => 'http://www.google.com',
// &nbsp;&nbsp;&nbsp;&nbsp;'pic' => 'images/test.png',
// &nbsp;&nbsp;),
// &nbsp;&nbsp;array(
// &nbsp;&nbsp;&nbsp;&nbsp;'topic' => '123',
// &nbsp;&nbsp;&nbsp;&nbsp;'url' => 'http://www.google.com',
// &nbsp;&nbsp;&nbsp;&nbsp;'pic' => 'images/test.png',
// &nbsp;&nbsp;),
// );
XXX;
		$return .= nl2br($aaa);
		$return .= $br;
	}
	$return .= $br;

	// 如果是最後一筆，那就不用輸出這個了
	if(($k+1) != count($layoutv3_struct)){
		$return .= 'include "layoutv3/next_data_id.php";'.$br;
		$return .= $br;
	}
}

echo $return;

//include 'layoutv3/next_id.php';

class dBug {
	
	var $xmlDepth=array();
	var $xmlCData;
	var $xmlSData;
	var $xmlDData;
	var $xmlCount=0;
	var $xmlAttrib;
	var $xmlName;
	var $arrType=array("array","object","resource","boolean","NULL");
	var $bInitialized = false;
	var $bCollapsed = false;
	var $arrHistory = array();
	
	//constructor
	function dBug($var,$forceType="",$bCollapsed=false) {
		//include js and css scripts
		if(!defined('BDBUGINIT')) {
			define("BDBUGINIT", TRUE);
			$this->initJSandCSS();
		}
		$arrAccept=array("array","object","xml"); //array of variable types that can be "forced"
		$this->bCollapsed = $bCollapsed;
		if(in_array($forceType,$arrAccept))
			$this->{"varIs".ucfirst($forceType)}($var);
		else
			$this->checkType($var);
	}

	//get variable name
	function getVariableName() {
		$arrBacktrace = debug_backtrace();

		//possible 'included' functions
		$arrInclude = array("include","include_once","require","require_once");
		
		//check for any included/required files. if found, get array of the last included file (they contain the right line numbers)
		for($i=count($arrBacktrace)-1; $i>=0; $i--) {
			$arrCurrent = $arrBacktrace[$i];
			if(array_key_exists("function", $arrCurrent) && 
				(in_array($arrCurrent["function"], $arrInclude) || (0 != strcasecmp($arrCurrent["function"], "dbug"))))
				continue;

			$arrFile = $arrCurrent;
			
			break;
		}
		
		if(isset($arrFile)) {
			$arrLines = file($arrFile["file"]);
			$code = $arrLines[($arrFile["line"]-1)];
	
			//find call to dBug class
			preg_match('/\bnew dBug\s*\(\s*(.+)\s*\);/i', $code, $arrMatches);
			
			return $arrMatches[1];
		}
		return "";
	}
	
	//create the main table header
	function makeTableHeader($type,$header,$colspan=2) {
		if(!$this->bInitialized) {
			$header = $this->getVariableName() . " (" . $header . ")";
			$this->bInitialized = true;
		}
		$str_i = ($this->bCollapsed) ? "style=\"font-style:italic\" " : ""; 
		
		echo "<table cellspacing=2 cellpadding=3 class=\"dBug_".$type."\">
				<tr>
					<td ".$str_i."class=\"dBug_".$type."Header\" colspan=".$colspan." onClick='dBug_toggleTable(this)'>".$header."</td>
				</tr>";
	}
	
	//create the table row header
	function makeTDHeader($type,$header) {
		$str_d = ($this->bCollapsed) ? " style=\"display:none\"" : "";
		echo "<tr".$str_d.">
				<td valign=\"top\" onClick='dBug_toggleRow(this)' class=\"dBug_".$type."Key\">".$header."</td>
				<td>";
	}
	
	//close table row
	function closeTDRow() {
		return "</td></tr>\n";
	}
	
	//error
	function  error($type) {
		$error="Error: Variable cannot be a";
		// this just checks if the type starts with a vowel or "x" and displays either "a" or "an"
		if(in_array(substr($type,0,1),array("a","e","i","o","u","x")))
			$error.="n";
		return ($error." ".$type." type");
	}

	//check variable type
	function checkType($var) {
		switch(gettype($var)) {
			case "resource":
				$this->varIsResource($var);
				break;
			case "object":
				$this->varIsObject($var);
				break;
			case "array":
				$this->varIsArray($var);
				break;
			case "NULL":
				$this->varIsNULL();
				break;
			case "boolean":
				$this->varIsBoolean($var);
				break;
			default:
				$var=($var=="") ? "[empty string]" : $var;
				echo "<table cellspacing=0><tr>\n<td>".$var."</td>\n</tr>\n</table>\n";
				break;
		}
	}
	
	//if variable is a NULL type
	function varIsNULL() {
		echo "NULL";
	}
	
	//if variable is a boolean type
	function varIsBoolean($var) {
		$var=($var==1) ? "TRUE" : "FALSE";
		echo $var;
	}
			
	//if variable is an array type
	function varIsArray($var) {
		$var_ser = serialize($var);
		array_push($this->arrHistory, $var_ser);
		
		$this->makeTableHeader("array","array");
		if(is_array($var)) {
			foreach($var as $key=>$value) {
				$this->makeTDHeader("array",$key);
				
				//check for recursion
				if(is_array($value)) {
					$var_ser = serialize($value);
					if(in_array($var_ser, $this->arrHistory, TRUE))
						$value = "*RECURSION*";
				}
				
				if(in_array(gettype($value),$this->arrType))
					$this->checkType($value);
				else {
					$value=(trim($value)=="") ? "[empty string]" : $value;
					echo $value;
				}
				echo $this->closeTDRow();
			}
		}
		else echo "<tr><td>".$this->error("array").$this->closeTDRow();
		array_pop($this->arrHistory);
		echo "</table>";
	}
	
	//if variable is an object type
	function varIsObject($var) {
		$var_ser = serialize($var);
		array_push($this->arrHistory, $var_ser);
		$this->makeTableHeader("object","object");
		
		if(is_object($var)) {
			$arrObjVars=get_object_vars($var);
			foreach($arrObjVars as $key=>$value) {

				$value=(!is_object($value) && !is_array($value) && trim($value)=="") ? "[empty string]" : $value;
				$this->makeTDHeader("object",$key);
				
				//check for recursion
				if(is_object($value)||is_array($value)) {
					$var_ser = serialize($value);
					if(in_array($var_ser, $this->arrHistory, TRUE)) {
						$value = (is_object($value)) ? "*RECURSION* -> $".get_class($value) : "*RECURSION*";

					}
				}
				if(in_array(gettype($value),$this->arrType))
					$this->checkType($value);
				else echo $value;
				echo $this->closeTDRow();
			}
			$arrObjMethods=get_class_methods(get_class($var));
			foreach($arrObjMethods as $key=>$value) {
				$this->makeTDHeader("object",$value);
				echo "[function]".$this->closeTDRow();
			}
		}
		else echo "<tr><td>".$this->error("object").$this->closeTDRow();
		array_pop($this->arrHistory);
		echo "</table>";
	}

	//if variable is a resource type
	function varIsResource($var) {
		$this->makeTableHeader("resourceC","resource",1);
		echo "<tr>\n<td>\n";
		switch(get_resource_type($var)) {
			case "fbsql result":
			case "mssql result":
			case "msql query":
			case "pgsql result":
			case "sybase-db result":
			case "sybase-ct result":
			case "mysql result":
				$db=current(explode(" ",get_resource_type($var)));
				$this->varIsDBResource($var,$db);
				break;
			case "gd":
				$this->varIsGDResource($var);
				break;
			case "xml":
				$this->varIsXmlResource($var);
				break;
			default:
				echo get_resource_type($var).$this->closeTDRow();
				break;
		}
		echo $this->closeTDRow()."</table>\n";
	}

	//if variable is a database resource type
	function varIsDBResource($var,$db="mysql") {
		if($db == "pgsql")
			$db = "pg";
		if($db == "sybase-db" || $db == "sybase-ct")
			$db = "sybase";
		$arrFields = array("name","type","flags");	
		$numrows=call_user_func($db."_num_rows",$var);
		$numfields=call_user_func($db."_num_fields",$var);
		$this->makeTableHeader("resource",$db." result",$numfields+1);
		echo "<tr><td class=\"dBug_resourceKey\">&nbsp;</td>";
		for($i=0;$i<$numfields;$i++) {
			$field_header = "";
			for($j=0; $j<count($arrFields); $j++) {
				$db_func = $db."_field_".$arrFields[$j];
				if(function_exists($db_func)) {
					$fheader = call_user_func($db_func, $var, $i). " ";
					if($j==0)
						$field_name = $fheader;
					else
						$field_header .= $fheader;
				}
			}
			$field[$i]=call_user_func($db."_fetch_field",$var,$i);
			echo "<td class=\"dBug_resourceKey\" title=\"".$field_header."\">".$field_name."</td>";
		}
		echo "</tr>";
		for($i=0;$i<$numrows;$i++) {
			$row=call_user_func($db."_fetch_array",$var,constant(strtoupper($db)."_ASSOC"));
			echo "<tr>\n";
			echo "<td class=\"dBug_resourceKey\">".($i+1)."</td>"; 
			for($k=0;$k<$numfields;$k++) {
				$tempField=$field[$k]->name;
				$fieldrow=$row[($field[$k]->name)];
				$fieldrow=($fieldrow=="") ? "[empty string]" : $fieldrow;
				echo "<td>".$fieldrow."</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</table>";
		if($numrows>0)
			call_user_func($db."_data_seek",$var,0);
	}
	
	//if variable is an image/gd resource type
	function varIsGDResource($var) {
		$this->makeTableHeader("resource","gd",2);
		$this->makeTDHeader("resource","Width");
		echo imagesx($var).$this->closeTDRow();
		$this->makeTDHeader("resource","Height");
		echo imagesy($var).$this->closeTDRow();
		$this->makeTDHeader("resource","Colors");
		echo imagecolorstotal($var).$this->closeTDRow();
		echo "</table>";
	}
	
	//if variable is an xml type
	function varIsXml($var) {
		$this->varIsXmlResource($var);
	}
	
	//if variable is an xml resource type
	function varIsXmlResource($var) {
		$xml_parser=xml_parser_create();
		xml_parser_set_option($xml_parser,XML_OPTION_CASE_FOLDING,0); 
		xml_set_element_handler($xml_parser,array(&$this,"xmlStartElement"),array(&$this,"xmlEndElement")); 
		xml_set_character_data_handler($xml_parser,array(&$this,"xmlCharacterData"));
		xml_set_default_handler($xml_parser,array(&$this,"xmlDefaultHandler")); 
		
		$this->makeTableHeader("xml","xml document",2);
		$this->makeTDHeader("xml","xmlRoot");
		
		//attempt to open xml file
		$bFile=(!($fp=@fopen($var,"r"))) ? false : true;
		
		//read xml file
		if($bFile) {
			while($data=str_replace("\n","",fread($fp,4096)))
				$this->xmlParse($xml_parser,$data,feof($fp));
		}
		//if xml is not a file, attempt to read it as a string
		else {
			if(!is_string($var)) {
				echo $this->error("xml").$this->closeTDRow()."</table>\n";
				return;
			}
			$data=$var;
			$this->xmlParse($xml_parser,$data,1);
		}
		
		echo $this->closeTDRow()."</table>\n";
		
	}
	
	//parse xml
	function xmlParse($xml_parser,$data,$bFinal) {
		if (!xml_parse($xml_parser,$data,$bFinal)) { 
				   die(sprintf("XML error: %s at line %d\n", 
							   xml_error_string(xml_get_error_code($xml_parser)), 
							   xml_get_current_line_number($xml_parser)));
		}
	}
	
	//xml: inititiated when a start tag is encountered
	function xmlStartElement($parser,$name,$attribs) {
		$this->xmlAttrib[$this->xmlCount]=$attribs;
		$this->xmlName[$this->xmlCount]=$name;
		$this->xmlSData[$this->xmlCount]='$this->makeTableHeader("xml","xml element",2);';
		$this->xmlSData[$this->xmlCount].='$this->makeTDHeader("xml","xmlName");';
		$this->xmlSData[$this->xmlCount].='echo "<strong>'.$this->xmlName[$this->xmlCount].'</strong>".$this->closeTDRow();';
		$this->xmlSData[$this->xmlCount].='$this->makeTDHeader("xml","xmlAttributes");';
		if(count($attribs)>0)
			$this->xmlSData[$this->xmlCount].='$this->varIsArray($this->xmlAttrib['.$this->xmlCount.']);';
		else
			$this->xmlSData[$this->xmlCount].='echo "&nbsp;";';
		$this->xmlSData[$this->xmlCount].='echo $this->closeTDRow();';
		$this->xmlCount++;
	} 
	
	//xml: initiated when an end tag is encountered
	function xmlEndElement($parser,$name) {
		for($i=0;$i<$this->xmlCount;$i++) {
			eval($this->xmlSData[$i]);
			$this->makeTDHeader("xml","xmlText");
			echo (!empty($this->xmlCData[$i])) ? $this->xmlCData[$i] : "&nbsp;";
			echo $this->closeTDRow();
			$this->makeTDHeader("xml","xmlComment");
			echo (!empty($this->xmlDData[$i])) ? $this->xmlDData[$i] : "&nbsp;";
			echo $this->closeTDRow();
			$this->makeTDHeader("xml","xmlChildren");
			unset($this->xmlCData[$i],$this->xmlDData[$i]);
		}
		echo $this->closeTDRow();
		echo "</table>";
		$this->xmlCount=0;
	} 
	
	//xml: initiated when text between tags is encountered
	function xmlCharacterData($parser,$data) {
		$count=$this->xmlCount-1;
		if(!empty($this->xmlCData[$count]))
			$this->xmlCData[$count].=$data;
		else
			$this->xmlCData[$count]=$data;
	} 
	
	//xml: initiated when a comment or other miscellaneous texts is encountered
	function xmlDefaultHandler($parser,$data) {
		//strip '<!--' and '-->' off comments
		$data=str_replace(array("&lt;!--","--&gt;"),"",htmlspecialchars($data));
		$count=$this->xmlCount-1;
		if(!empty($this->xmlDData[$count]))
			$this->xmlDData[$count].=$data;
		else
			$this->xmlDData[$count]=$data;
	}

	function initJSandCSS() {
		echo <<<SCRIPTS
			<script language="JavaScript">
			/* code modified from ColdFusion's cfdump code */
				function dBug_toggleRow(source) {
					var target = (document.all) ? source.parentElement.cells[1] : source.parentNode.lastChild;
					dBug_toggleTarget(target,dBug_toggleSource(source));
				}
				
				function dBug_toggleSource(source) {
					if (source.style.fontStyle=='italic') {
						source.style.fontStyle='normal';
						source.title='click to collapse';
						return 'open';
					} else {
						source.style.fontStyle='italic';
						source.title='click to expand';
						return 'closed';
					}
				}
			
				function dBug_toggleTarget(target,switchToState) {
					target.style.display = (switchToState=='open') ? '' : 'none';
				}
			
				function dBug_toggleTable(source) {
					var switchToState=dBug_toggleSource(source);
					if(document.all) {
						var table=source.parentElement.parentElement;
						for(var i=1;i<table.rows.length;i++) {
							target=table.rows[i];
							dBug_toggleTarget(target,switchToState);
						}
					}
					else {
						var table=source.parentNode.parentNode;
						for (var i=1;i<table.childNodes.length;i++) {
							target=table.childNodes[i];
							if(target.style) {
								dBug_toggleTarget(target,switchToState);
							}
						}
					}
				}
			</script>
			
			<style type="text/css">
				table.dBug_array,table.dBug_object,table.dBug_resource,table.dBug_resourceC,table.dBug_xml {
					font-family:Verdana, Arial, Helvetica, sans-serif; color:#000000; font-size:12px;
				}
				
				.dBug_arrayHeader,
				.dBug_objectHeader,
				.dBug_resourceHeader,
				.dBug_resourceCHeader,
				.dBug_xmlHeader 
					{ font-weight:bold; color:#FFFFFF; cursor:pointer; }
				
				.dBug_arrayKey,
				.dBug_objectKey,
				.dBug_xmlKey 
					{ cursor:pointer; }
					
				/* array */
				table.dBug_array { background-color:#006600; }
				table.dBug_array td { background-color:#FFFFFF; }
				table.dBug_array td.dBug_arrayHeader { background-color:#009900; }
				table.dBug_array td.dBug_arrayKey { background-color:#CCFFCC; }
				
				/* object */
				table.dBug_object { background-color:#0000CC; }
				table.dBug_object td { background-color:#FFFFFF; }
				table.dBug_object td.dBug_objectHeader { background-color:#4444CC; }
				table.dBug_object td.dBug_objectKey { background-color:#CCDDFF; }
				
				/* resource */
				table.dBug_resourceC { background-color:#884488; }
				table.dBug_resourceC td { background-color:#FFFFFF; }
				table.dBug_resourceC td.dBug_resourceCHeader { background-color:#AA66AA; }
				table.dBug_resourceC td.dBug_resourceCKey { background-color:#FFDDFF; }
				
				/* resource */
				table.dBug_resource { background-color:#884488; }
				table.dBug_resource td { background-color:#FFFFFF; }
				table.dBug_resource td.dBug_resourceHeader { background-color:#AA66AA; }
				table.dBug_resource td.dBug_resourceKey { background-color:#FFDDFF; }
				
				/* xml */
				table.dBug_xml { background-color:#888888; }
				table.dBug_xml td { background-color:#FFFFFF; }
				table.dBug_xml td.dBug_xmlHeader { background-color:#AAAAAA; }
				table.dBug_xml td.dBug_xmlKey { background-color:#DDDDDD; }
			</style>
SCRIPTS;
	}

}


// 這裡會結束是正常的哦，不要拿掉
die;

