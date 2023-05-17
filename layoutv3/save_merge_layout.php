<?php
// 這裡上面不要空行，不然captcha的圖片會出不來

/*
 * 這個是cig frontend平面化在使用的LayoutV3程式樣版
 */

/*
* 檢測連結是否是SSL連線
* @return bool
*/
session_name("BuyerlineWebsite");// 這邊設定不要跟預設的 PHPSESSID 名稱重複，避免無法做轉跳 2021-03-17 by lota
if(!function_exists('is_SSL')){
	function is_SSL(){
		if(!isset($_SERVER['HTTPS']))
			return FALSE;
		if($_SERVER['HTTPS'] === 1){  //Apache
			return TRUE;
		}elseif($_SERVER['HTTPS'] === 'on'){ //IIS
			return TRUE;
		}elseif($_SERVER['SERVER_PORT'] == 443){ //其他
			return TRUE;
		}
			return FALSE;
	}
}

if(is_SSL()){

	//設定cookie傳輸模式 by lota
	// $maxlifetime = ini_get('session.gc_maxlifetime');
	$secure = true; // if you only want to receive the cookie over HTTPS
	$httponly = true; // prevent JavaScript access to session cookie
	$samesite = 'None';

    if(PHP_VERSION_ID < 70300) {
        session_set_cookie_params(0, '/; samesite='.$samesite, str_replace('www','',$_SERVER['HTTP_HOST']), $secure, $httponly);
    } else {
        session_set_cookie_params([
            // 'lifetime' => $maxlifetime,
            'path' => '/',
            'domain' => str_replace('www','',$_SERVER['HTTP_HOST']),
            'secure' => $secure,
            'httponly' => $httponly,
            'samesite' => $samesite
        ]);
    }
}



// 這個是開發階段所使用的，如果開發完成，請註解
error_reporting(E_ALL);
ini_set("display_errors", 1);

//引入$web_folder
include_once '_i/config/web_folder.php';

/*
 * 【Ming 2017-05-12】關於「SEO - 網址討論結論」
 * parent/core.php
 */

// 為了支援200網站的使用習慣，上線後，可以把這裡mark掉
if($_SERVER['HTTP_HOST'] == '192.168.0.200'){
	$tmp = explode('/', $_SERVER["REQUEST_URI"]);
	header('Location: http://'.$tmp[1].'.web.buyersline.com.tw');
	die;
}


// 簡易安全機制範例，有需要在打開，記得正式上線後要移除
if(0 and $_SERVER['HTTP_HOST'] != '889.devel.gisanfu.idv.tw'){
	@session_start();
	if ($_SESSION['enter'] !== true){
		?>
		 <script language="javascript">
        location.href='login_demo.php';
        </script>           
        <?php
		exit;
	}
}


$tmp = $_SERVER['SCRIPT_NAME'];

// 為了要支援，在htaccess裡面寫規則，取代parent/core.php的前導程式
// 理論上平面化應該不會用到這裡，不過還是寫過來好了
if($tmp == '/parent_core.php'){
	$tmp = $_SERVER['REQUEST_URI'];
}
if(preg_match('/^(.*)\?/', $tmp, $matches)){
	$tmp = $matches[1];
}

$tmps = explode('_',$tmp);

if($tmps and count($tmps) == 2 and strlen(str_replace('.php','',$tmps[1])) == 2){
	@session_start();
	$_SESSION['web_ml_key'] = str_replace('.php','',$tmps[1]);
	$_SERVER['SCRIPT_NAME'] = $tmps[0].'.php';
}

/*
 * 這支程式，對於LayoutV3來說，是要預留給需要用的程式或架構，例如：MVC架構
 * layoutv3/yii/init.php
 */

// 不同Application，如果這裡有指定的話(例如"admin/"或是en/")，可以使用自己的group、view等，但是layoutv3資料夾還是共用一個
if(!isset($layoutv3_path)){
	$layoutv3_path = '';
}

// 下面的a.php，不需要用parent_path來判斷，因為不太一樣
if(!isset($layoutv3_parent_path)){
	$layoutv3_parent_path = '';
}

if(!defined('LAYOUTV3_IS_RUN_FIRST')){
	@session_start();

	// 每一種架構模式都會有這個屬於自己的常數 2018-01-15
	define('LAYOUTV3_STRUCT_MODE', 'cig_frontend');

	if(!isset($layoutv3_parent_path)){
		$layoutv3_parent_path = '';
	}

	// 不同Application，如果這裡有指定的話(例如"admin/"或是en/")，可以使用自己的group、view等，但是layoutv3資料夾還是共用一個
	if(!isset($layoutv3_path)){
		$layoutv3_path = '';
	}

	define('LAYOUTV3_PARENT_PATH', $layoutv3_parent_path); // 為了要讓連絡我們的動態網址能夠用
	define('LAYOUTV3_PATH', $layoutv3_path); // 為了要讓MVC架構也能使用，所以才用常數

	//$bbb = str_replace('.php','',$_SERVER['SCRIPT_NAME']);
	$bbb = str_replace('.php','',str_replace($web_folder,'',$_SERVER['SCRIPT_NAME']));//為了支援網站放在次目錄所處理的 by lota
	if(defined('LAYOUTV3_PARENT_PATH') and LAYOUTV3_PARENT_PATH != ''){
		$bbb = str_replace(LAYOUTV3_PARENT_PATH,'',$bbb);
	} elseif(defined('LAYOUTV3_PATH') and LAYOUTV3_PATH != ''){
		$bbb = str_replace(LAYOUTV3_PATH,'',$bbb);
	}
	$bbb = str_replace('/','',$bbb);

	define('LAYOUTV3_IS_RUN_FIRST', $bbb); // 這個變數，在render階段會用到，等同於功能名稱
	define('_BASEPATH', __DIR__.'/../../_i'); // /var/www/html/rwd_v3/_i

	//define('customer_public_path', '../'.$layoutv3_path.'assets/'); // 意思是jobs2裡面的assets，
	define('customer_public_path', 'assets/'); // 意思是jobs2裡面的assets，

	$vendors_dir = _BASEPATH.'/vendors';
	ini_set ('include_path',ini_get('include_path').PATH_SEPARATOR.$vendors_dir);

	include 'ci.php';	
	//include 'layoutv3/cig_frontend/ci.php';	

	// 要移出來，這樣子才不會有問題...吧 2018-01-31
	include 'layoutv3/cig/libs.php';	
	include 'layoutv3/cig_frontend/libs.php';	

	// dom5同下
	include 'standalone_simplehtmldom.php';

	// 從dom5.php那邊拉過來的
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

	class Foo {

		public $data;

		// 這是後台在用的
		// public $ignore_class_acl = array(
		// 	'login',
		// 	'captcha',
		// );

		// 只取得檔案列表
		protected function _getFiles($dir)
		{
		  $files = array();
		  if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && $file != '.svn' && $file != '.hg') {
					if(is_dir($dir.'/'.$file)){
						//$dir2 = $dir.'/'.$file;
						//$files[] = _getFilesFromDir($dir2);
						//$files[] = $dir2;
					}
					else {
						$files[] = $dir.'/'.$file;
					}
				}
			}   
			closedir($handle);
		  }

		  return $this->_array_flat($files);
		}

		// 只取得資料夾列表
		protected function _getDirs($dir)
		{
			$files = array();
			if ($handle = opendir($dir)) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != ".." && $file != '.svn' && $file != '.hg') {
						if(is_dir($dir.'/'.$file)){
							$dir2 = $dir.'/'.$file;
							//$files[] = _getFilesFromDir($dir2);
							$files[] = $dir2;
						}
						else {
							//$files[] = $dir.'/'.$file;
						}
					}
				}   
				closedir($handle);
			}

			return $this->_array_flat($files);
		}

		// 取得資料夾和檔案列表，包含子目錄
		protected function _getFilesFromDir($dir)
		{
			$files = array();
			if ($handle = opendir($dir)) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != ".." && $file != '.svn' && $file != '.hg') {
						if(is_dir($dir.'/'.$file)){
							$dir2 = $dir.'/'.$file;
							$files[] = $this->_getFilesFromDir($dir2);
						}
						else {
							$files[] = $dir.'/'.$file;
						}
					}
				}   
				closedir($handle);
			}

			return $this->_array_flat($files);
		}

		protected function _array_flat($array) {

			$tmp = array();
			foreach($array as $a) {
				if(is_array($a)) {
					$tmp = array_merge($tmp, $this->_array_flat($a));
				}   
				else {
					$tmp[] = $a; 
				}   
			}

			return $tmp;
		}

		protected function email_send_to($to, $subject, $body, $body_html,$cc_mail = NULL)
		{
			/*
			 * 寄信開始
			 */
			//$zend_dir =  dirname(__FILE__).'/../../framework/vendors';
			//ini_set ('include_path',ini_get('include_path').PATH_SEPARATOR.$zend_dir);
			require_once('Zend/Loader/Autoloader.php');
			$autoloader = Zend_Loader_Autoloader::getInstance();

			$Transport = new Zend_Mail_Transport_Smtp($this->data['email_config']['_server'], $this->data['email_config']);
			Zend_Mail::setDefaultTransport($Transport);

			//$mail->setFrom(aaa_smtp_from, '');

			$mail = new Zend_Mail('utf-8');
			$mail->setFrom($this->data['sys_configs']['smtp_from'], $this->data['sys_configs']['smtp_from_name']);
			$mail->addTo($to);
			if($cc_mail)
				$mail->addCc($cc_mail);
			
			$mail->setSubject($subject);
			$mail->setBodyText($body);
			$mail->setBodyHtml($body_html);

			$mail->send();
		}

		protected function email_send_to_api($to, $subject, $body, $body_html,$cc_mail = NULL)
		{
			$public_key = EIP_APIV1_PUBLICKEY;
			$private_key = EIP_APIV1_PRIVATEKEY;

			$server_ip = EIP_APIV1_DOMAIN;
			$url = 'index.php?r=api/emailsendto';

			/*
			 * $tmps = array(
			 * 	'ssl',
			 * 	'server',
			 * 	'port',
			 * 	'account',
			 * 	'login_password',
			 * 	'from',
			 * 	'from_name',
			 * 	'to',
			 * 	'cc',
			 * 	'subject',
			 * 	'body',
			 * 	'body_html',
			 * );
			 */
			$params = array(
				'ssl' => $this->data['sys_configs']['smtp_ssl'],
				'server' => $this->data['sys_configs']['smtp_server'],
				'port' => $this->data['sys_configs']['smtp_port'],
				'account' => $this->data['sys_configs']['smtp_account'],
				'login_password' => $this->data['sys_configs']['smtp_password'], 
				'from' => $this->data['sys_configs']['smtp_from'],
				'from_name' => $this->data['sys_configs']['smtp_from_name'],
				'to' => $to,
				'cc' => $cc_mail,
				'subject' => $subject,
				'body' => $body,
				//'body_html' => addslashes($body_html),
				'body_html' => $body_html,
			);

			// include 'eip_client.php';

			$postdata = http_build_query(
				array(
					'get_client_code' => '',
				)
			);
			$opts = array('http' =>
				array(
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => $postdata
				)
			);
			$context  = stream_context_create($opts);
			$code = file_get_contents($server_ip.'/apiv1/code.php', false, $context);

			$code = stripslashes($code);
			eval('?'.'>'.$code);

			// 這裡Debug才有需要打開…吧
			// if(isset($return)){
			// 	var_dump($return);
			// }
		}

		protected function email_send_to_by_sendmail($from = array()/*2層*/, $tos = array()/*3層*/, $subject, $body, $body_html,$cc_mail = NULL)
		{
			if(count($from) > 0 and isset($from['email']) and $from['email'] != ''
				and count($tos) > 0 and isset($tos[0]) and isset($tos[0]['email']) and $tos[0]['email'] != ''
			){
				/*
				 * 寄信開始
				 */
				//2016/12/19 lota Serverzoo 把 server2上的 mail()鎖定
				//require_once('Zend/Loader/Autoloader.php');
				//$autoloader = Zend_Loader_Autoloader::getInstance();
				//改用phpmailer
			
				//2017/5/26 更新Phpmailer為5.2.23，這邊要額外載入class.smtp.php才能動 by lota
				include_once("phpmailer/class.phpmailer.php");
				include_once("phpmailer/class.smtp.php");
		

				foreach($tos as $k => $v){
					$to = $v['email'];
					/*
					$mail = new Zend_Mail('utf-8');
					$mail->setFrom($from['email'],$from['name']);
					$mail->addTo($to);
					
					$mail->setSubject($subject);
					$mail->setBodyText($body);
					$mail->setBodyHtml($body_html);
					*/
					$mail = new PHPMailer();
					$mail->IsSMTP();                                      // set mailer to use SMTP			
					$mail->SMTPAuth = false;     // turn on SMTP authentication
					$mail->Host = 'localhost';  // specify main and backup server
					$mail->Port = 25;
					$mail->SMTPSecure = "";
					$mail->IsHTML(true);                                  // set email format to HTML
					$mail->CharSet = "utf-8";
					$mail->Encoding = "base64";
				
					$mail->From = $from['email'];
					$mail->FromName = $from['name'];
					$mail->AddAddress($to);
					$mail->Subject = $subject;
					$mail->Body = $body_html;


					$mail->send();
				}
				if($cc_mail){
					/*
					$mail = new Zend_Mail('utf-8');
					$mail->setFrom($from['email'],$from['name']);
					$mail->addTo($cc_mail);
					$mail->setSubject($subject);
					$mail->setBodyText($body);
					$mail->setBodyHtml($body_html);
					*/
					$mail = new PHPMailer();
					$mail->IsSMTP();                                      // set mailer to use SMTP			
					$mail->SMTPAuth = false;     // turn on SMTP authentication
					$mail->Host = 'localhost';  // specify main and backup server
					$mail->Port = 25;
					$mail->SMTPSecure = "";
					$mail->IsHTML(true);                                  // set email format to HTML
					$mail->CharSet = "utf-8";
					$mail->Encoding = "base64";
					
					$mail->From = $from['email'];
					$mail->FromName = $from['name'];
					$mail->AddAddress($cc_mail);
					$mail->Subject = $subject;
					$mail->Body = $body_html;


					$mail->send();
				}
			}
		}

		// 只是增加收件人的引數而以，然後寄件人改成陣列
		protected function email_send_to_v2($from = array()/*2層*/, $tos = array()/*3層*/, $subject, $body, $body_html,$cc_mail = NULL)
		{
			if(count($from) > 0 and isset($from['email']) and $from['email'] != ''
				and count($tos) > 0 and isset($tos[0]) and isset($tos[0]['email']) and $tos[0]['email'] != ''
			){
				/*
				 * 寄信開始
				 */
				//$zend_dir =  dirname(__FILE__).'/../../framework/vendors';
				//ini_set ('include_path',ini_get('include_path').PATH_SEPARATOR.$zend_dir);
				require_once('Zend/Loader/Autoloader.php');
				$autoloader = Zend_Loader_Autoloader::getInstance();

				$Transport = new Zend_Mail_Transport_Smtp($this->data['email_config']['_server'], $this->data['email_config']);
				Zend_Mail::setDefaultTransport($Transport);

				//$mail->setFrom(aaa_smtp_from, '');

				// 找一下寄件人有沒有設定
				//$rows = $this->db->createCommand()->from('html')->where('is_enable=1 and type=:type and ml_key=:ml_key',array(':type'=>'email',':ml_key'=>$this->data['ml_key']))->queryAll();

				foreach($tos as $k => $v){
					$to = $v['email'];

					$mail = new Zend_Mail('utf-8');
					$mail->setFrom($from['email'],$from['name']);
					$mail->addTo($to);
					
					$mail->setSubject($subject);
					$mail->setBodyText($body);
					$mail->setBodyHtml($body_html);

					// try {
						$mail->send();
					// } catch (Zend_Mail_Exception $e) {
					// 	return $tr->getConnection()->getLog();
					// }
				}
				if($cc_mail){
					$mail = new Zend_Mail('utf-8');
					$mail->setFrom($from['email'],$from['name']);
					$mail->addTo($cc_mail);
					$mail->setSubject($subject);
					$mail->setBodyText($body);
					$mail->setBodyHtml($body_html);

					$mail->send();
				}
			}
		}

		function __construct()
		{
			// include 'core.php';

			// 平面化沒有加上這個，最後會報錯
			$layoutv3_parent_path = '';

			date_default_timezone_set("Asia/Taipei");

			// 2014-01-02 TED建議，我設一小時
			// ini_set("session.gc_maxlifetime","3600");

			// debug
			//ini_set('memory_limit', '512M');

			define('DS', DIRECTORY_SEPARATOR);
			define('PS', PATH_SEPARATOR);

			function ds($path)
			{
				if(DIRECTORY_SEPARATOR == '/') return $path;
				return str_replace('/', DIRECTORY_SEPARATOR, $path);
			}

			if (!defined('__DIR__')) {
				define('__DIR__', ds(dirname(__FILE__)));
			}

			define('tmp_path', _BASEPATH.ds('/').'assets');

			include GGG_BASEPATH.'_i/config/domain.php';

			$host = array();
			foreach($hosts_app as $k => $v){
				if($_SERVER['SERVER_NAME'] == $v['name'] and $_SERVER['SERVER_PORT'] == $v['port']){
					$host = $v;
					break;
				}
			}
			//引入$web_folder
			include GGG_BASEPATH.'_i/config/web_folder.php';//引入$web_folder
			include GGG_BASEPATH.'_i/config/environment.php';
			include GGG_BASEPATH.'_i/config/db.php';
			include GGG_BASEPATH.'_i/config/email.php';
			include GGG_BASEPATH.'_i/config/shop.php';

			define('aaa_url', $host['name']);

			$Db_Server = aaa_dbhost;
			$Db_User = aaa_dbuser;
			$Db_Pwd = aaa_dbpass;
			$Db_Name = aaa_dbname;	

			$tmps = array(
				'dbdriver' => 'mysql',
				'username' => $Db_User,
				'password' => $Db_Pwd,
				'hostname' => $Db_Server,
				'port' => 3306,
				'database' => $Db_Name,
			);

			// $db = ggg_load_database("mysql://$Db_User:$Db_Pwd@$Db_Server/$Db_Name", true);
			$db = ggg_load_database($tmps, true);

			$this->cidb = $db;
			$_SESSION['cidb'] = $db;

			//$bbb = str_replace('.php','',$_SERVER['SCRIPT_NAME']);
			$bbb = str_replace('.php','',str_replace($web_folder,'',$_SERVER['SCRIPT_NAME']));//為了支援網站放在次目錄所處理的 by lota
			if(defined('LAYOUTV3_PARENT_PATH') and LAYOUTV3_PARENT_PATH != ''){
				$bbb = str_replace(LAYOUTV3_PARENT_PATH,'',$bbb);
			}
			if(defined('LAYOUTV3_PATH') and LAYOUTV3_PATH != ''){
				$bbb = str_replace(LAYOUTV3_PATH,'',$bbb);
			}
			// $bbb = str_replace('_'.$this->data['ml_key'],'',$bbb); // 前台才會用到
			$bbb = str_replace('/','',$bbb);

			// 向下支援
			$this->data['router_method'] = $bbb;
			$this->data['router_class'] = $bbb;
			$this->data['class_url'] = $bbb.'.php?action=';
			$this->data['current_url'] = $bbb.'.php?action=';
			$this->data['router_action'] = 'index';
			if(isset($_GET['action']) and $_GET['action'] != ''){
				$this->data['current_url'] = $bbb.'.php?action='.$_GET['action'];
				$this->data['router_action'] = $_GET['action'];
			}
			$this->data['router_param'] = '';
			if(isset($_GET['param']) and $_GET['param'] != ''){
				$this->data['current_url'] = $bbb.'.php?'; // action='.$_GET['action'].'&param='.$_GET['param'];
				if(isset($_GET['action']) and $_GET['action'] != ''){
					$this->data['current_url'] .= 'action='.$_GET['action'];
				}
				if(isset($_GET['param']) and $_GET['param'] != ''){
					$this->data['current_url'] .= 'param='.$_GET['param'];
				}

				$this->data['router_param'] = $_GET['param'];
			}
			$this->data['theme_lang'] = 'admin_lang_1';
			define('theme_lang', $this->data['theme_lang']);

			// 向下支援
			$this->data['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.str_replace('/','',LAYOUTV3_PATH);

			// 當下是否是運行平面化的架構
			$this->data['current_flattened'] = true;

			// 前後台共用的函式庫
			// include GGG_BASEPATH.'../cig/libs.php';	

			// 自己Application專用的函式庫
			// include 'libs.php';	

			$this->db = new yii_cdb($this->cidb);

			// 取得sys_config裡面的資料
			$rows = $this->cidb->get('sys_config')->result_array();
			$sys_configs = array();
			if(count($rows) > 0){
				foreach($rows as $k => $v){
					$sys_configs[$v['keyname']] = $v['keyval'];
					/*
					 * LayoutV3在使用的
					 * 開環境的程式會操控這個東西
					 */
					if(preg_match('/^function_constant_(.*)$/', $v['keyname'], $matches)){
						// 範例：define('NEWS_SHOW_TYPE',2)
						if(!defined(strtoupper($matches[1]))){
							if($v['keyval'] == '' or $v['keyval'] === null){
								define(strtoupper($matches[1]), '');
							} elseif(is_bool($v['keyval'])){
								eval('define(strtoupper($matches[1]), '.$v['keyval'].');');
							} elseif(is_int($v['keyval'])){
								eval('define(strtoupper($matches[1]), '.$v['keyval'].');');
							} elseif(preg_match('/^(true|false)$/', $v['keyval'])){
								eval('define(strtoupper($matches[1]), '.$v['keyval'].');');
							} else {
								define(strtoupper($matches[1]), $v['keyval']);
							}
						}
					}
				}
			}
			$this->data['sys_configs'] = $sys_configs;

			// 如果需要重新export片語，或是語系檔案不存在(language.js, language.php)，就重新匯出片語
			if((isset($sys_configs['_need_label_export']) and $sys_configs['_need_label_export'] == '1')
				//or !file_exists(Yii::app()->getRuntimePath() . DIRECTORY_SEPARATOR . 'language.php')
				or !file_exists(tmp_path.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'language.php')
				or !file_exists(tmp_path.DIRECTORY_SEPARATOR.'language.js')
			){
			} else {
				$ml = new Ml2($this->cidb);
				$ml->export();

				// 看一下他的片語值是否有存在
				// 存在的話，把值改成空白，不存在就放了它
				//if(count($this->db->createCommand()->from('sys_config')->where('keyname = :name', array(':name'=> '_need_label_export'))->queryAll())){
				//	$this->db->createCommand()->delete('sys_config', 'keyname = :name', array(':name'=> '_need_label_export'));
				//}
				if(count($this->cidb->where('keyname', '_need_label_export')->get('sys_config')->result_array())){
					$this->cidb->where('keyname', '_need_label_export')->delete('sys_config');
				}
			}

			// 載入多國語系
			$this->labels = G::l();

			$all_session = $_SESSION;

			$base64url = new base64url;
			$this->data['current_base64_url'] = $base64url->encode($_SERVER['REQUEST_URI']);

			// http://www.yiiframework.com/wiki/37/integrating-with-other-frameworks/
			// require_once 'Zend/Loader/Autoloader.php';
			// spl_autoload_register(array('Zend_Loader_Autoloader','autoload'));

			// 驗證使用者有沒有權限的開始準備工作
			// if(!in_array($this->data['router_method'], $this->ignore_class_acl)){
			// 	if(!isset($all_session['auth_admin_id']) or $all_session['auth_admin_id'] <= 0){
			// 		header('Location: login.php?current_base64_url='.base64url::encode($_SERVER['REQUEST_URI']));
			// 		die;
			// 	}
			// 	$acl = new Admin_acl($this->cidb);
			// 	$acl->start();
			// }

			/*
			 * 接下來，就要看要使用的Application，到底是前台、還是後台
			 */

			// 將驗證類的session值，傳給smarty
			foreach($all_session as $k => $v){
				if(preg_match('/^authw_(.*)$/', $k, $matches)){
					//echo $matches[1];
					// 加了一個w底線，為了要區分前台和後台的session變數群
					$this->data[$matches[1]] = $v;
				}
			}

			$ml_key = $host['ml_key'];
			$this->data['default_ml_key'] = $ml_key;

				/*
				 * 介面語系的優先權處理過程
				 */

				// 如果是空白，就取用使用者所選擇的語系
				if($ml_key == '' and isset($_SESSION['web_ml_key']) and $_SESSION['web_ml_key'] != ''){
					$ml_key = $_SESSION['web_ml_key'];
					$this->data['default_ml_key'] = $host['ml_key'];
				}

				// 如果還是空白，就取用系統的語系預設值
				if($ml_key == ''){
					$this->data['default_ml_key'] = $host['ml_key'];
					$ml_key = $host['ml_key'];
				} else {
					$this->data['default_ml_key'] = $host['ml_key'];
					//Yii::app()->language = $ml_key;
				}

				// 如果真的真的沒有，因為這裡位於台灣，所以最後還是使用繁體
				if($ml_key == ''){
					$ml_key = 'tw';
				}

				$_SESSION['web_ml_key'] = $ml_key;
				$this->data['ml_key'] = $ml_key;

			// 設定語系與抓取語系
			//$ml_key = Yii::app()->session['interface_ml_key'];
			$interface_ml_key = '';
			$ml_key = '';
			//echo $ml_key;

			// 取得後台用的語系列表
			$rows = $this->cidb->where('is_enable', 1)->like('interface', ',2,', 'both')->get('ml')->result_array();
			//$rows = $this->db->createCommand()->from('ml')->where('is_enable = 1')->where(array('like', 'interface', '%,1,%'))->order('sort_id')->queryAll();
			// $rows = $this->db->createCommand('select * from ml where is_enable=1 and interface like "%,1,%" order by sort_id')->queryAll();
			$mls = array();
			$mls_tmp = array();
			foreach($rows as $row){
				$tmp = $row['name'];
				$mls[$row['key']] = $tmp;
				$mls_tmp[] = $row['key'];
			}
			$this->data['mls'] = $mls;
			$this->data['mls_tmp'] = $mls_tmp;

			// 設定相對路徑
			$_SESSION['image_crop_path'] = customer_public_path.'crop'; // 擺放裁圖前的原圖  
			$_SESSION['image_thumb_path'] = customer_public_path.'thumb';
			$_SESSION['image_thumb_tmp_path'] = customer_public_path.'thumb';
			$_SESSION['image_upload_path'] = customer_public_path.'upload';
			$_SESSION['image_upload_tmp_path'] = customer_public_path.'file';
			$_SESSION['image_upload_static_path'] = customer_public_path.'static';
			$_SESSION['file_upload_path'] = customer_public_path.'upload_tmp';
			$_SESSION['file_upload_tmp_path'] = customer_public_path.'file_tmp';
			// $_SESSION['vir_path_c'] = vir_path_c; // 給kcfinder的config所使用

			// // 請注意，如果在httpd.conf裡面使用了VirtualDocumentRoot，那這裡會不一樣
			// if(virtualdocumentroot_fix != ''){
			// 	Yii::app()->session->add('vir_path_c', '/'.virtualdocumentroot_fix.'/'.vir_path_c); // 給kcfinder的config所使用
			// 
			//     if(preg_match('/^Apache\/2\.4/', apache_get_version())){
			//         $tmps = explode('/', $_SERVER['DOCUMENT_ROOT']);
			//         unset($tmps[count($tmps)-1]);
			//         unset($tmps[0]);
			//         $tmp = '/'.implode('/',$tmps);
			//         Yii::app()->session->add('fix_document_root', $tmp); // 給kcfinder的config所使用
			//     }
			// } else {
			// 	Yii::app()->session->add('vir_path_c', vir_path_c); // 給kcfinder的config所使用
			// }
			$_SESSION['customer_public_path'] = customer_public_path; // 給kcfinder的config所使用

			$_SESSION['tmp_path'] = tmp_path; // 給ckfinder的config所使用 2015-08-28 lota所發現

			$this->data['public_path'] = customer_public_path;

			$this->data['image_crop_path'] = customer_public_path.'crop';
			$this->data['image_thumb_path'] = customer_public_path.'thumb';
			$this->data['image_thumb_tmp_path'] = customer_public_path.'thumb_tmp';
			$this->data['image_upload_path'] = customer_public_path.'upload';
			$this->data['image_upload_tmp_path'] = customer_public_path.'upload_tmp';
			$this->data['file_upload_path'] = customer_public_path.'file';
			$this->data['file_upload_tmp_path'] = customer_public_path.'file_tmp';
			$this->data['tmp_path'] = customer_public_path.'tmp';

			/*
			 * 寄信相關設定
			 */

			//$tmp_email = array(
			//	'auth' => 'login',
			//	//'ssl' => 'tls',
			//	'port' => aaa_smtp_port,
			//	'username' => aaa_smtp_account,
			//	'password' => aaa_smtp_password,
			//	'_server' => aaa_smtp_server,
			//);
			//if(aaa_smtp_ssl != ''){
			//	$tmp_email['ssl'] = aaa_smtp_ssl;
			//}
			//$this->data['email_config'] = $tmp_email;

			$tmp = array('ssl','from','from_name','port','account','password','server');
			foreach($tmp as $k => $v){
				$run = <<<XXX01
// if(aaa_smtp_$v != ''){ // 舊的寫法
if(defined('aaa_smtp_$v')){
	\$sys_configs['smtp_$v'] = aaa_smtp_$v;
	\$this->data['sys_configs']['smtp_$v'] = aaa_smtp_$v;
}
XXX01;
				eval($run);
			}

			$tmp_email = array(
				'auth' => 'login',

				// 'ssl' => 'ssl',
				
				// 'port' => $sys_configs['smtp_port'],
				// 'username' => $sys_configs['smtp_account'],
				// 'password' => $sys_configs['smtp_password'],
				// '_server' => $sys_configs['smtp_server'],
			);

			if(isset($sys_configs['smtp_account']) and $sys_configs['smtp_account'] != '') $tmp_email['username'] = $sys_configs['smtp_account'];
			if(isset($sys_configs['smtp_password']) and $sys_configs['smtp_password'] != '') $tmp_email['password'] = $sys_configs['smtp_password'];
			if(isset($sys_configs['smtp_server']) and $sys_configs['smtp_server'] != '') $tmp_email['_server'] = $sys_configs['smtp_server'];

			if(isset($sys_configs['smtp_ssl']) and $sys_configs['smtp_ssl'] != ''){
				$tmp_email['ssl'] = $sys_configs['smtp_ssl'];
			} //else {
				// http://stackoverflow.com/questions/736964/how-to-use-zend-mail-transport-smtp-with-hosted-google-apps
				//$tmp_email['ssl'] = 'tls'; // tls就是tcp
			//}

			if(isset($sys_configs['smtp_port']) and $sys_configs['smtp_port'] != ''){
				// do nothing
			} else {
				$tmp_email['port'] = '25'; // 就算不填，zend mail預設值也是25
			}

			$this->data['email_config'] = $tmp_email;

			/*
			 * @name    例index _param_handle
			 * @path    例:source/crud/index(最後不用加上dot php) [母體]
			 * @current 例:company [子站]
			 *
			 * 因為source/xxx/??post??也會用到，而post是在libs之上的，所以才把函式移過來這裡放
			 */
			function layoutv3_inherit($name, $path, $current)
			{
				$result = null;

				// 先看子站有沒有
				$file_current = _BASEPATH.'/../'.LAYOUTV3_PATH.$current.'.php';
				if(file_exists($file_current)){
					$tmp = file_get_contents($file_current);
					if(preg_match('/\/\/\ '.$name.'---start\n(.*)\/\/\ '.$name.'---end/s',$tmp,$matches)){
						$result = $matches[1];
					}
				}
				
				if($result === null){
					$file_core = _BASEPATH.'/../'.LAYOUTV3_PATH.$path.'.php';
					$tmp = file_get_contents($file_core);
					if(preg_match('/\/\/\ '.$name.'---start\n(.*)\/\/\ '.$name.'---end/s',$tmp,$matches)){
						$result = $matches[1];
					}
				}
				return $result;
			}

			// 這是前台在使用的，先留著
			// // if(preg_match('/^(captcha|captcha2|ajax2|action|cssv3|facebook|google|fb|guestcheckemail|page|save|short|step1)$/', $bbb)){

			// 這裡應該不需要，因為Foo物件init結束後，我就己經把程式碼累加在下面了
			// if(defined('LAYOUTV3_PARENT_PATH') and LAYOUTV3_PARENT_PATH != ''){
			// 	//$file = _BASEPATH.'/../parent/'.$bbb.'.php';
			// 	$file = _BASEPATH.'/../'.LAYOUTV3_PARENT_PATH.$bbb.'.php';
			// 	//echo $file;die;
			// 	include $file;
			// } elseif(defined('LAYOUTV3_PATH') and LAYOUTV3_PATH != ''){ // 後台在用的
			// 	$file = _BASEPATH.'/../'.LAYOUTV3_PATH.$bbb.'.php';
			// 	include $file;
			// } else {
			// 	if(preg_match('/^(mbpanel2|translate|dom2|dom|captcha|captcha2|ajax2|action|cssv3|facebook|facebook_s|google|google_s|fb|guestcheckemail|page|save|short|step1|alert_win|alert_win2)$/', $bbb)){
			// 		$file = _BASEPATH.'/../'.$bbb.'.php';
			// 		include $file;
			// 	} else {
			// 		$file_old = _BASEPATH.'/../'.$bbb.'.php';
			// 		$file = _BASEPATH.'/../parent/'.$bbb.'.php'; //【Ming 2017-05-12】關於「SEO - 網址討論結論」
			// 		if(!file_exists($file)){
			// 			$file = $file_old;
			// 		}

			// 		if(defined('IS_STANDALONE') and IS_STANDALONE === true){
			// 			$file = _BASEPATH.'/../standalone.php';
			// 		}

			// 		include $file;
			// 	}
			// }

// 前半段到這裡就結束了哦
// 接下來YII的預設Controllers會重新載入程式，例如載入company.php
// 但是程式都會載入這支core.php，所以這支程式會被載入第二次
//

$page = array();
$data = array();

/*
 * $ID = layoutv3_next_data_id($layoutv3_struct, $ID);
 */
if(!function_exists('layoutv3_next_data_id')){
	function layoutv3_next_data_id($struct, $current){
		$point = false;
		foreach($struct as $k => $v){
			if($point){
				$tmp = explode('|', $v);
				return trim($tmp[0]);
			}
			if(preg_match('/^'.$current.'\|/', $v)){
				$point = true;
			}
		}
	}
}

if(!function_exists('layoutv3_struct_search')){
	function layoutv3_struct_search($array, $key, $value, $k = '')
	{
		$results = array();

		if (is_array($array)) {
			if (isset($array[$key]) && $array[$key] == $value) {
				$array['position'] = $k; // 這個是我後來加的
				$results[] = $array;
			}

			foreach ($array as $ggg => $subarray) {
				$results = array_merge($results, layoutv3_struct_search($subarray, $key, $value, $k.'-'.$ggg));
			}
		}

		return $results;
	}
}

// http://stackoverflow.com/questions/1252693/using-str-replace-so-that-it-only-acts-on-the-first-match
/*
 * 用法
 * echo str_replace_first('abc', '123', 'abcdef abcdef abcdef'); 
 * outputs '123def abcdef abcdef'
 */
// function layoutv3_str_replace_first($from, $to, $subject){
// 	$from = '/'.preg_quote($from, '/').'/';
// 	return preg_replace($from, $to, $subject, 1);
// }

// http://php.net/manual/en/function.rand.php
// @qtd 要產出的長度
if(!function_exists('layoutv3_hash')){
	function layoutv3_hash($qtd){
		//Under the string $Caracteres you write all the characters you want to be used to randomly generate the code.
		$Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
		$QuantidadeCaracteres = strlen($Caracteres);
		$QuantidadeCaracteres--;

		$Hash=NULL;
			for($x=1;$x<=$qtd;$x++){
				$Posicao = rand(0,$QuantidadeCaracteres);
				$Hash .= substr($Caracteres,$Posicao,1);
			}

		return $Hash; 
	}
}

// https://blog.longwin.com.tw/2009/03/php-object-to-array-json-reader-cli-2009/
//
// 使用方式
// $rows = $this->db->createCommand()->from('producttype')->where('is_enable=1 and ml_key=:ml_key',array(':ml_key'=>$this->data['ml_key']))->order('sort_id')->queryAll();
// $indexedItems = array();
// 
// foreach ($rows as $item) {
// 	$item['child'] = array();
// 	$indexedItems[$item['id']] = (object) $item;
// }
// 
// $topLevel = array();
// foreach ($indexedItems as $item) {
// 	if ($item->pid == 0) {
// 		$topLevel[] = $item;
// 	} else {
// 		$indexedItems[$item->pid]->child[] = $item;
// 	}
// }
// $tree = std_class_object_to_array($topLevel);
// var_dump($tree);
if(!function_exists('std_class_object_to_array')){
function std_class_object_to_array($stdclassobject)
{
	$_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;

	foreach ($_array as $key => $value) {
		$value = (is_array($value) || is_object($value)) ? std_class_object_to_array($value) : $value;
		$array[$key] = $value;
	}

	if(isset($array)){
		return $array;
	}
}
}

/*
 * 
 */
if(!function_exists('t')){
function t($text = '', $source = 'zh-TW', $target = '')
{
	$map = array(
		'tw' => 'zh-TW',
		'cn' => 'zh-CN',
		'jp' => 'ja',
	);

	// 這個一定有值
	if(isset($map[$source])){
		$source = $map[$source];
	}

	// 我打算給它預設值為當前語系
	if($target == ''){
		if(!isset($map[$_SESSION['web_ml_key']])){
			$target = $_SESSION['web_ml_key'];
		} else {
			$target = $map[$_SESSION['web_ml_key']];
		}
	}

	if($source == $target){
		return $text;
	} else {
		$url = FRONTEND_DOMAIN.'/translate.php';
		$post = array(
			'text' => $text,
			'source' => $source,
			'target' => $target,
		);

		$postdata = http_build_query($post);
		$ch = curl_init();
		$options = array(
			CURLOPT_URL => $url,
			CURLOPT_HEADER => 0,
			CURLOPT_VERBOSE => 0,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_USERAGENT => "Mozilla/4.0 (compatible;)",
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postdata,
		);
		curl_setopt_array($ch, $options);
		$code = curl_exec($ch); 
		curl_close($ch);

		return $code;
	}
}
}

/*
 * 還有優先權最高的post的程式
 * 還有合併好的$page
 */
//$AAAAAAAAAAAAAAAAAAAA=0;

$prefix = 'save';

$row = $_REQUEST;

// 可能是購物車在使用的
if(isset($row['_prefix'])){
	$prefix = $row['_prefix'];
}

if(isset($row['id'])){

	if($row['id'] == 'clear'){
		unset($_SESSION[$prefix]);
		echo 'clear';
		die;
	}
	//2017/7/3  這邊是購物車第二步的"自訂"模式，清除收件人資料 by lota
	if($row['id'] == 'member_form_2_clear'){
		foreach($_SESSION[$prefix]['member_form_2'] as $k => $v){
			$_SESSION[$prefix]['member_form_2'][$k] = '';
		}
		//unset($_SESSION[$prefix]['member_form_2']);
		$_SESSION[$prefix]['member_form_2']['select_recipient'] = 'custom';
		//echo 'clear';
		die;
	}

	$key = $row['id'];
	unset($row['id']);

	if(!isset($_SESSION[$prefix][$key])){
		$_SESSION[$prefix][$key] = array();
	}
	$primary_key = '';
	if(count($row) > 0){
		// 先找primary_key
		foreach($row as $k => $v){
			if($k == 'primary_key'){
				$primary_key = $v;
				unset($row['primary_key']);
				break;
			}
		}

		if($primary_key == ''){
			
			if(isset($_SESSION[$prefix][$key]) and count($_SESSION[$prefix][$key]) > 0){
				//$row = array_merge($row, $_SESSION[$prefix][$key]);
				foreach($row as $k => $v){
					$_SESSION[$prefix][$key][$k] = $v;
				}
			} else {
				$_SESSION[$prefix][$key] = $row;
			}
		} else {
			// 有primary key的，還多了可以處理amount的部份
			if(isset($row['amount']) and $row['amount'] > 0){
				if(!isset($_SESSION[$prefix][$key][$primary_key]['amount'])){
					$_SESSION[$prefix][$key][$primary_key]['amount'] = 0;
				}
				if(isset($row['_append'])){
					$_SESSION[$prefix][$key][$primary_key]['amount'] += $row['amount'];

					//Yii::app()->session[$prefix][$key][$primary_key]['amount'] += $row['amount'];
					//echo '456';
				} else {
					$_SESSION[$prefix][$key][$primary_key]['amount'] = $row['amount'];

					//Yii::app()->session[$prefix][$key][$primary_key]['amount'] = $row['amount'];
					//echo '123';
					//echo $_SESSION[$prefix][$key][$primary_key]['amount'];
				}
				unset($row['amount']);
			} 
			// 其餘就replace囉
			if(count($row) > 0){
				foreach($row as $k => $v){
					$_SESSION[$prefix][$key][$primary_key][$k] = $v;
					// Yii::app()->session[$prefix][$key][$primary_key][$k] = $v;
				}
			}
		}
	}
}

if(isset($_REQUEST['id']) and $_REQUEST['id'] == 'productinquiry'){
	if(isset($_REQUEST['_append'])){
		// 這裡是PHP回應
		$redirect_url = 'productinquiry_'.$this->data['ml_key'].'.php';
		G::alert_and_redirect(t('己加入詢問車'), $redirect_url, $this->data);
//		$return = <<<XXX
//<meta charset="UTF-8">
//<script type="text/javascript">
//alert('己加入詢問車');
//window.location.href = 'productinquiry.php';
//</script>
//XXX;
		//echo $return;
		die;
	} else {
		if($_REQUEST['amount'] == 0){
			$return = <<<XXX
<script type="text/javascript">
alert('Delete');
window.location.href = 'productinquiry_{$this->data['ml_key']}.php';
</script>
XXX;
			echo $return;
			die;
		} else {
			// 好像也不用refresh頁面 ㄏ又 ~
			// echo 'location.reload(true);';
		}
		die;
	}
} elseif(isset($_REQUEST['id']) and $_REQUEST['id'] == 'shop_filter_price'){
	$key = $_REQUEST['id'];
	$data_id = $_REQUEST['data_id'];//2017/7/3 增加依照目前類別去顯示資料 by lota
	// 如果預設值不是這樣子，請自己依照需求去修改！！
	// if(
	// 	isset($_SESSION['save'][$key]['min']) and $_SESSION['save'][$key]['min'] == $row['min']
	// 	and 
	// 	isset($_SESSION['save'][$key]['max']) and $_SESSION['save'][$key]['max'] == $row['max']
	// ){
	// 	// do nothing
	// } else {
	// }
	echo "window.location.href='shop_".$this->data['ml_key'].".php?id=$data_id';";
} elseif(isset($_REQUEST['id']) and $_REQUEST['id'] == 'select_physical'){
	// 因為選擇超商取貨付款的時候，在第二步驟就完成了，所以才需要在這邊做防呆
	// 避免Bug產生
	unset($_SESSION['save']['step3']['go_to_finish!!']);
}
die;

/*
 * 這裡的處理好、合併好的$page變數，放在上面，就是A的那個位置
 */

/*
 * 整理陣列
 * 把那些群組和Layout都給刪掉
 */
$tmps = explode("\n", var_export($page,true));
$groups = array();
if($tmps and count($tmps) > 0){
	foreach($tmps as $k => $v){
		if(preg_match('/\'\$(.*)\'/', $v, $matches)){
			$groups[] = $matches[1];
		}
	}
}
$group_tmp = array();
$group_result = array();
if($groups and count($groups) > 0){
	foreach($groups as $k => $v){
		$tmp = layoutv3_struct_search($page, 'file', '$'.$v);
		$group_tmp[] = $tmp;
	}
}

/*
array(6) {
  [0]=>
  array(1) {
    [0]=>
    array(2) {
      ["file"]=>
      string(6) "$head1"
      ["position"]=>
      string(27) "-0-hole-0_0-hole-0_0-hole-0"
    }
  }
  [1]=>
  array(1) {
    [0]=>
    array(2) {
      ["file"]=>
      string(8) "$header2"
      ["position"]=>
      string(34) "-0-hole-0_0-hole-0_0-hole-1-hole-0"
    }
  }
 */
if($group_tmp and count($group_tmp) > 0){
	foreach($group_tmp as $k => $v){
		foreach($v as $kk => $vv){
			$tmp = explode('-',$vv['position']);
			unset($tmp[0]);
			$node_string = '[\''.implode("']['",$tmp).'\']';
			$run = 'unset($page'.$node_string.');';
			eval($run);
		}
	}
}

/*
 * 將結構轉成PHP和HTML混合的程式碼
 * 在這個階段後，就沒有群組和區塊了
 * 己經將分散的檔案給組起來了
 */

//$run = layoutv3_section_recursive(0, $page, $this->data);

/*
 * 這裡要放View合併好的東西
 */
$run = <<<'XXX'
$BBBBBBBBBBBBBBBBBBBB=0;
XXX;

$layoutv3_pre_render_content = explode("\n",$run);

/*
 * 這裡要放Source合併好的東西
 */
$CCCCCCCCCCCCCCCCCCCC=0;

/*
 * pre_render.php結束
 */


/*
 * 這裡是自定程式碼，但這裡並不會去parser抓過來
 */

//include 'layoutv3/render.php';

/*
 * <?php if(0):?><!-- head_start -->
 * <script type="text/javascript">
 * // head start
 * </script>
 * <?php endif?><!-- head_start -->
 * 
 * <?php if(0):?><!-- head_end -->
 * <script type="text/javascript">
 * // head end 
 * </script>
 * <?php endif?><!-- head_end -->
 * 
 * <?php if(0):?><!-- body_start -->
 * <script type="text/javascript">
 * // body start
 * </script>
 * <?php endif?><!-- body_start -->
 * 
 * <?php if(0):?><!-- body_end -->
 * <script type="text/javascript">
 * // body end 
 * </script>
 * <?php endif?><!-- body_end -->
 */

$append = array();
$append['head_start'] = '';
$append['head_end'] = '';
$append['body_start'] = '';
$append['body_end'] = '';

$append_object['head_start'] = array();
$append_object['head_end'] = array();
$append_object['body_start'] = array();
$append_object['body_end'] = array();

$point = '';
foreach($layoutv3_pre_render_content as $k => $v){
	if(preg_match('/^\<\?php\ if\(0\)\:\?\>\<\!\-\-\ (head_start|head_end|body_start|body_end)\ \-\-\>$/', trim($v), $matches)){
		$point = $matches[1];
		unset($layoutv3_pre_render_content[$k]);
		continue;
	} elseif(preg_match('/^\<\?php\ endif\?\>\<\!\-\-\ (head_start|head_end|body_start|body_end)\ \-\-\>$/', trim($v), $matches)){
		$point = '';
		unset($layoutv3_pre_render_content[$k]);
		continue;
	}

	if($point != ''){
		$append[$point] .= $v."\n";
		unset($layoutv3_pre_render_content[$k]);
	}
}

// 因為模組的寫法，和Append的寫法不一樣，所以這裡切分開來寫 2017-06-27
$tag = '';
$module = '';
$tmp = '';
foreach($layoutv3_pre_render_content as $k => $v){
	if(preg_match('/^\<\?php\ if\(0\)\:\?\>\<\!\-\-\ (head_start|head_end|body_start|body_end)\:(.*)\ \-\-\>$/', trim($v), $matches)){
		$tag = $matches[1];
		$module = $matches[2];
		unset($layoutv3_pre_render_content[$k]);
		continue;
	} elseif(preg_match('/^\<\?php\ endif\?\>\<\!\-\-\ (head_start|head_end|body_start|body_end)\:(.*)\ \-\-\>$/', trim($v), $matches)){
		if(!isset($append_object[$matches[1]][$matches[2]])){
			$append_object[$matches[1]][$matches[2]] = $tmp;
		}
		$tag = '';
		$module = '';
		$tmp = '';
		unset($layoutv3_pre_render_content[$k]);
		continue;
	}
	if($tag != ''){
		$tmp .= $v."\n";
		unset($layoutv3_pre_render_content[$k]);
	}
}

// 為了解決footer的sitemap_type2(橫)換新行的問題而寫的新功能 2017-02-14
$other_function = array();
$point = '';
$check_tmp = array();
foreach($layoutv3_pre_render_content as $k => $v){
	if(preg_match('/^\<\!\-\-\ func\|start\|(.*)\ \-\-\>$/', trim($v), $matches)){
		$point = $matches[1];
		if(isset($check_tmp[$point])){
			$check_tmp[$point]++;
		} else {
			$check_tmp[$point] = 0;
		}
		//unset($layoutv3_pre_render_content[$k]);
		$layoutv3_pre_render_content[$k] = '<!-- func|result|'.$matches[1].'|'.$check_tmp[$point].' -->';
		continue;
	} elseif(preg_match('/^\<\!\-\-\ func\|end\|(.*)\ \-\-\>$/', trim($v), $matches)){
		$point = '';
		unset($layoutv3_pre_render_content[$k]);
		continue;
	}
	if($point != ''){
		if(!isset($other_function[$point])){
			$other_function[$point] = array();
		}
		if(!isset($other_function[$point][$check_tmp[$point]])){
			$other_function[$point][$check_tmp[$point]] = '';
		}
		$other_function[$point][$check_tmp[$point]] .= trim($v);
		unset($layoutv3_pre_render_content[$k]);
	}
}
//var_dump($other_function);die;

// DATA2資料流
foreach($layoutv3_pre_render_content as $k => $v){
	preg_match('/\<\!\-\-\ \/\/\ DATA2\:(SINGLE|MULTI)(\:\d+|)\ \-\-\>/', $v, $matches);
	if(isset($matches[0]) and $matches[0] != ''){
		$type = strtolower($matches[1]);
		$element = str_replace(':','',$matches[2]);
		if($element == ''){
			$layoutv3_pre_render_content[$k] = <<<XXX

<?php
if(!isset(\$data2_control)) \$data2_control = array();
if(!isset(\$data2_control[\$ID]['$type'])) \$data2_control[\$ID]['$type'] = -1;
if(isset(\$data2[\$ID]['$type'])){
	\$data2_control[\$ID]['$type']++;
	if(isset(\$data2[\$ID]['$type'][\$data2_control[\$ID]['$type']])){
		\$data[\$ID] = \$data2[\$ID]['$type'][\$data2_control[\$ID]['$type']];
	} else {
		\$data[\$ID] = array();
	}
}
?>

XXX;
		} else {
			$layoutv3_pre_render_content[$k] = <<<XXX

<?php
if(!isset(\$data2_control)) \$data2_control = array();
if(!isset(\$data2_control[\$ID]['$type'])) \$data2_control[\$ID]['$type'] = -1;
if(isset(\$data2[\$ID]['$type'][$element - 1])){
	\$data[\$ID] = \$data2[\$ID]['$type'][$element - 1];
} else {
	\$data[\$ID] = array();
}
?>

XXX;
		}
	}
}

foreach($layoutv3_pre_render_content as $k => $v){
	if(preg_match('/\/\/ killme/', $v, $matches)){
		unset($layoutv3_pre_render_content[$k]);
	}
}

$run = implode("\n", $layoutv3_pre_render_content);
//echo $run;die;
//var_dump($append_object);die;

if(count($append_object['head_start']) > 0){
	$tmp2 = '';
	foreach($append_object['head_start'] as $k => $v){
		$tmp2 .= $v."\n";
	}
	$append_object['head_start'] = $tmp2;
} else {
	$append_object['head_start'] = '';
}

if(count($append_object['head_end']) > 0){
	$tmp2 = '';
	foreach($append_object['head_end'] as $k => $v){
		$tmp2 .= $v."\n";
	}
	$append_object['head_end'] = $tmp2;
} else {
	$append_object['head_end'] = '';
}

if(count($append_object['body_start']) > 0){
	$tmp2 = '';
	foreach($append_object['body_start'] as $k => $v){
		$tmp2 .= $v."\n";
	}
	$append_object['body_start'] = $tmp2;
} else {
	$append_object['body_start'] = '';
}

if(count($append_object['body_end']) > 0){
	$tmp2 = '';
	foreach($append_object['body_end'] as $k => $v){
		$tmp2 .= $v."\n";
	}
	$append_object['body_end'] = $tmp2;
} else {
	$append_object['body_end'] = '';
}

$run = str_replace('##head_start##', $append_object['head_start']."\n".$append['head_start'], $run);
$run = str_replace('##head_end##', $append_object['head_end']."\n".$append['head_end'], $run);
$run = str_replace('##body_start##', $append_object['body_start']."\n".$append['body_start'], $run);
$run = str_replace('##body_end##', $append_object['body_end']."\n".$append['body_end'], $run);

if(isset($other_function) and count($other_function) > 0){
	foreach($other_function as $k => $v){
		if($k == 'remove_new_line'){
			foreach($v as $kk => $vv){
				$other_function[$k][$kk] = trim(preg_replace('/\s\s+/', ' ', $vv));
			}
		}
	}
}

if(isset($other_function) and count($other_function) > 0){
	foreach($other_function as $k => $v){
		foreach($v as $kk => $vv){
			$run = str_replace('<!-- func|result|'.$k.'|'.$kk.' -->', $vv, $run);
		}
	}
}

// debug用的，記得是看原始碼
// 當發生eval某一行的問題，就可以打開這裡，把行號填進去
// $tmps = explode("\n",$run);
// echo $tmps[1627-1];die;

// debug用的
// @mkdir(_BASEPATH.'/../'.LAYOUTV3_PATH.'_compile',0777,true);
// file_put_contents(_BASEPATH.'/../'.LAYOUTV3_PATH.'_compile/'.LAYOUTV3_IS_RUN_FIRST.'.php',$run);

// 編譯後的版型，也就是view，最後才會執行哦哦哦
// eval('?'.'>'.$run);

// include "layoutv3/dom5.php";
include "layoutv3/dom5_merge_layout.php";

		} // Foo __construct


	} // class foo

	$ggg = new Foo;
	die; // 第一階段到這裡結束
}


