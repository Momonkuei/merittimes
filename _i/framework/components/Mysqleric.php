<?php

/*
 * 使用方式
 *
 * ■ 這兩行是維一不一樣的地方：
 * $this->load->library('Mysqleric', array('table' => 'html'), 'mysqleric');
 * $db = $this->mysqleric;
 * 
 * ■ 底下用法一模一樣：
 * $qryField = '*';
 * $qryWhere = ' WHERE 1';
 * $db->getData($qryField, $qryWhere, 20);
 * $DataList = array();
 * if($db->total_row > 0) {
 * 	$DataCount = $db->total_row;
 * 	do{
 * 		$DataList[] = $db->row;
 * 	}while($db->row = $db->result->fetch_assoc());
 * 	$pageRecordInfo = $db->get_page_bar('/company/index-pg');
 * 	$pageBar = $db->record_info();
 * }
 * 
 * var_dump($DataList);
 * echo $pageRecordInfo;
 * echo $pageBar;
 * die;
 */

class Mysqleric
{
  var $rows_per_page;     // used in pagination
  var $start_page;
  var $total_page;
  var $row;               // fields in this table
  var $result;
  var $start_row;
  var $max_row;
  var $all_rows;
  var $total_row;         // 取出的資料總數
  var $table;
  var $backup;
  var $page_number;       // 分頁數量，預設10頁
  private $mysqli;

  protected $db_connect = null;
  
  //*** 建構子 */
  function __construct($params = array())  // (table name)
  {
	//$CI = &get_instance();
	$CI = get_instance();

	$this->db_connect = $CI->db->db_connect();

	//$this->db_connect = Yii::app()->db;

  	//global $db_connect;
  	
	//$arg  = func_get_args();
	//if(isset($arg[0]))
	//$this->table = $arg[0];

	if(isset($params['table']) and $params['table'] != ''){
		$this->table = $params['table'];
	}

	if($this->db_connect == null){
		//$db_connect = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
		$this->db_connect = $CI->db->db_connect();
	}
	$this->mysqli = $this->db_connect;
	
	$this->mysqli->query("SET NAMES 'utf8'");
	
	$this->backup = 0;
  }
  
  //*** 解構子 */
  function __destruct()
  {
  	//global $db_connect;
    if($this->result)
    $this->result->close();
	$this->mysqli->close();
	$this->db_connect = null;
  }

  /*** SQL QUERY */
  function query($str)
  {
   $result = $this->mysqli->query($str) or die($this->mysqli->error."<br>\n".$str);
  }

  function select_db($db_name)
  {
  	//global $db_connect;
	return mysqli_select_db($this->db_connect, $db_name);
  }

  function getMysqlResult()
  {
	  $str = 'select * from '.$this->table;
      $result = $this->mysqli->query($str);
	  //$result = mysql_query($this->db_connect, $str);
	  return $result;
  }
  
  //*** SELECT method
  function getData ($fieldname) // (field, [condition], [rows per page], [分頁數量])
  {
    $arg = func_get_args();

	if(isset($arg[3]) and $arg[3] != ''){
		$this->page_number = (int)$arg[3];
	} else {
		$this->page_number = 10;
	}
	
	// SQL條件式
	$condition = '';
	if(isset($arg[1]) && is_string($arg[1]))
	$condition = $arg[1];
		
	$queryString = sprintf("SELECT %s FROM %s %s", $fieldname, $this->table ,$condition);
	
	// 分頁處理
	if((isset($arg[1]) && is_int($arg[1])) || (isset($arg[2]) && is_int($arg[2])))
	{
	 $result = $this->mysqli->query($queryString);
	 if($result)
	 {
	  $this->all_rows = mysqli_num_rows($result);
	  $result->close();
	 }
	 else
	 {
	  $this->all_rows = 0;
	 }
	 
	 $this->start_page = 0;
	 
	 // 分辯變數為 condition or rows per page
	 if(isset($arg[1]) && is_int($arg[1]))
	 $this->rows_per_page = $arg[1];
	 else if(isset($arg[2]) && is_int($arg[2]))
	 $this->rows_per_page = $arg[2];

	 if(isset($_GET['current_page']))
	 $this->start_page = $_GET['current_page'] ;
	 
	 $this->total_page = 0;
	 // 計算總頁數
	 if($this->all_rows > 0)
		 $this->total_page =  ceil($this->all_rows / $this->rows_per_page);
	 
	 // 尾頁資料筆數
	 if($this->all_rows % $this->rows_per_page == 0)
	 $last_page_rows = $this->all_rows;
	 else
	 $last_page_rows = $this->all_rows % $this->rows_per_page ;
	 
	 // 防止頁數超出範圍
	 if($this->start_page <= 0){
	 	$this->start_page = 0;
	 }elseif($this->start_page > $this->total_page-1) {
	 	$this->start_page = $this->total_page-1;
	 }
	 
	 // 分頁起始筆數
	 $this->start_row = $this->start_page * $this->rows_per_page;

	 // jerry gisanfu 試著修修看
	 if($this->start_row < 0){
		 $this->start_row = 0;
	 }
	 
	 // 分頁結束筆數
	 $this->max_row =   $this->start_row + $this->rows_per_page;
	 
	 // 尾頁筆數
	 if($this->start_page == $this->total_page-1)
	 $this->max_row = $this->all_rows;
	 
	 $queryString = sprintf("%s LIMIT %d, %d",$queryString, $this->start_row, $this->rows_per_page);
	}
	
	$this->result = $this->mysqli->query($queryString) or die($this->mysqli->error."<br>\n".$queryString);
	
	if($this->result) {
	 $this->row     = $this->result->fetch_assoc();
	 $this->total_row = mysqli_num_rows($this->result);
	}
  }
  
  //*** INSERT method
  //*** (insert_data_array, gotoURL after insert, [get query string])
  function insertData ($info)
  {
	$arg = func_get_args();
	$qs  = 0;
	if(isset($arg[2]))
	$qs  = $arg[2];
	
	// 取得資料表所有field
	$fields = $this->get_table_field();
	
	$field_ary = array();
	$data_ary  = array();
	
	foreach($info as $key=>$value)
	{
	   if(in_array($key,$fields) && !empty($value))
	   {
		 $formated_val = $this->format_data($value);
		 $field_ary[] = $key;
		 $data_ary[]  = $formated_val;	 
	   }
	}
	
	if(in_array('create_date', $fields))
	{
//	     $formated_val = $this->format_data(date("Y-m-d H:i:s"));
	     $formated_val = 'NOW()';
		 $field_ary[] = 'create_date';
		 $data_ary[]  = $formated_val;
	}
	if(in_array('modify_date', $fields))
	{
	     $formated_val = 'NOW()';
		 $field_ary[] = 'modify_date';
		 $data_ary[]  = $formated_val;
	}
	
	$data = join(", ",$data_ary);
	
	$fieldname = join(", ",$field_ary);
	
	$queryString = sprintf("INSERT INTO %s (%s) VALUES (%s)",$this->table, $fieldname, $data);
	$result = $this->mysqli->query($queryString) or die($this->mysqli->error."<br>\n".$str);
	if($this->backup == 1){
		$restoreQuery = sprintf("DELETE FROM %s WHERE `id`=%s", $this->table, $this->get_insert_id());
		$this->db_backup('INSERT', $this->get_insert_id(), $restoreQuery, $queryString);
	}
	
    if(isset($arg[1]))
		$this->gotoURL($arg[1],$qs);	
  }
   
  //*** UPDATE method
  //*** (update_data_array, condition, gotoURL after update, [get query string])
  function updateData ($info, $condition) 
  {
    $arg  = func_get_args();
	$qs = 0;
	if(isset($arg[3]))   // $arg[3] 為_GET變數字串
	$qs = $arg[3];
	
	// 取得table所有field到$fields
	$fields = $this->get_table_field();
	
	$updateStrArray = array();
	
	foreach($info as $key=>$value)
	{
	   if(in_array($key,$fields)) {
		 $formated_val = $this->format_data($value);
		 
		 $updateStrArray[] = $key."=".$formated_val;
		 
		 $formated_val = $this->format_data($value);
	   } 
	}
	
	if(in_array('modify_date', $fields)) {
		 $updateStrArray[] = 'modify_date=NOW()';
	}
	
	$updateStr   = join(',',$updateStrArray);
	
	$queryString = sprintf("UPDATE %s SET %s %s", $this->table, $updateStr, $condition);
	
	if($this->backup == 1){
		$strFields = implode(',', $fields);
		$this->getData($strFields, $condition);
		if($this->total_row > 0){
			do{
				$restore_qry = '';
				foreach($this->row as $key=>$val){
					if($key == 'id') continue;
					if($restore_qry != '') $restore_qry .= ', ';
					$restore_qry .= ' `'.$key.'`='."'".$val."'";
				}
				$restore_qry = 'UPDATE '.$this->table.' SET '.$restore_qry.' WHERE `id`='.$this->row['id'];
				$this->db_backup('UPDATE', $this->row['id'], $restore_qry, $queryString);
			}while($this->row = $this->result->fetch_assoc());
		}
	}
	
	$this->mysqli->query($queryString) or die($this->mysqli->error."<br>\n".$queryString);
	
	if(isset($arg[2]))          // 欲前往的url
	$this->gotoURL($arg[2],$qs);
		
  }
  
   //*** DELETE method
   //*** (condition, gotoURL after delete, [get query string])
  function deleteData ($condition)
  {
	$arg  = func_get_args();
	$qs = 0;
	if(isset($arg[2]))
	$qs = $arg[2];
	
	$queryString = sprintf("DELETE FROM %s %s", $this->table, $condition);
	
	if($this->backup == 1){
		// 取得table所有field到$fields
		$fields = $this->get_table_field();
		$restore_qry = '';
		$strFields = implode(',', $fields);
		$this->getData($strFields, $condition);
		if($this->total_row > 0){
			do{
				foreach($this->row as $key=>$val){
					if($restore_qry != '') $restore_qry .= ', ';
					$restore_qry .= ' `'.$key.'`='."'".$val."'";
				}
				$restore_qry = 'INSERT INTO '.$this->table.' SET '.$restore_qry;
				$this->db_backup('DELETE', $this->row['id'], $restore_qry, $queryString);
			}while($this->row = $this->result->fetch_assoc());
		}
	}
	$this->mysqli->query($queryString) or die($this->mysqli->error."<br>\n".$queryString);
	
	if(isset($arg[1]))
	$this->gotoURL($arg[1],$qs);
  }
  
  //*** 資料型態處理
  function format_data($val)
  {
  	if( $val != 'NULL' && $val != 'NOW()' && (!empty($val)) ) {
		if(is_long($val)) {
		  $val = $this->GetSQLValueString($val, "bigint");
		} else if(is_double($val)) {
		  $val = $this->GetSQLValueString($val, "double");
		} else if(is_int($val)) {
		  $val = $this->GetSQLValueString($val, "int");
		} else {
		  $val = $this->GetSQLValueString($val, "text");
		}
  	}else{
  		$val = "''";
  	}
	return $val; 
  }
  
  //*** 取得table所有的field
  function get_table_field()
  {
    $col_name = array();
	$result = $this->mysqli->query("SHOW COLUMNS FROM ".$this->table);
	if (!$result) 
	{
     echo 'Could not run query: ' . mysqli_error();
     exit();
	}
	 if (mysqli_num_rows($result) > 0) 
	 {
       while ($row = mysqli_fetch_assoc($result)) 
	   {
        $col_name[] = $row['Field'];
       }
	   
	   return $col_name;
     }
  }

  //*** 取得資料庫中所有的table
  function get_tables()
  {
    $tbs = array();
	$result = $this->mysqli->query("SHOW TABLES");
	if (!$result) 
	{
     echo 'Could not run query: ' . mysqli_error();
     exit();
	}
	 if (mysqli_num_rows($result) > 0) 
	 {
       while ($row = mysqli_fetch_assoc($result)) {
        $tbs[] = $row['Tables_in_'.DB_DATABASE];
       }
	   
	   return $tbs;
     }
  }

  // executes the SQL commands from an external file.
  function execute_file ($file) {
  	global $ignoreNextChar;
	if (!file_exists($file)) {
		$this->last_error = "The file $file does not exist.";
		return false;
	}
	$str = file_get_contents($file);
	if (!$str) {
		$this->last_error = "Unable to read the contents of $file.";
		return false; 
	}
	// split all the queries into an array
	$quote = '';
	$line = '';
	$sql = array();
	for ($i = 0; $i < strlen($str); $i++) {
		$char = $str[$i];
		$line .= $char;
		if ( !$ignoreNextChar ) {
			if ($char == ';' && $quote == '') {
				$sql[] = $line;
				$line = '';
			} else if ( $char == '\\' ) {
				// Escape char; ignore the next char in the string
				$ignoreNextChar = TRUE;
			} else if ($char == '"' || $char == "'" || $char == '`') {
				if ( $quote == '' ) // Start of a new quoted string; ends with same quote char
					$quote = $char;
				else if ( $char == $quote ) // Current char matches quote char; quoted string ends
					$quote = '';
			}
		} else $ignoreNextChar = FALSE;
	}
	
	if ($quote != '') return false;

	foreach ($sql as $query) {
		if (!empty($query)) {
			$r = $this->query($query);
			if (!$r) {
				return false;
			}
		}
	}
	return true;
  }
    
  //*** 前往指定url
  function gotoURL($gotoURL, $qs)
  {
    $get_query   = '';
	if ($qs && isset($_SERVER['QUERY_STRING']))
	$get_query   = "?" . $_SERVER['QUERY_STRING'];
	
	header(sprintf('location:%s%s', $gotoURL, $get_query ));
  }
  
  //*** 資料集分頁
  function creat_page_bar($url_page)
  {
	$get_query = '';
	
	//第一頁
	$start_page = 0;
	
	//上一頁
	$per_page   = $this->start_page-1;
	if($per_page < 0)
	$per_page = 0;
	
	//下一頁
	$next_page  = $this->start_page+1;
	if($next_page  > $this->total_page-1)
	$next_page = $this->total_page-1;
	
	//最末頁
	$last_page  = $this->total_page-1;
	
	$arg  = func_get_args();
	
	$page_bar = '<a href ="'.$url_page.$start_page.'" title="第一頁"><img src="'.TPL_DIR.'images/firstPage.gif" border="0"/></a>
				 <a href ="'.$url_page.$per_page.'" title="上一頁"><img src="'.TPL_DIR.'images/previousPage.gif" border="0"/></a>
				 <a href ="'.$url_page.$next_page.'" title="下一頁"><img src="'.TPL_DIR.'images/nextPage.gif" border="0"/></a>
				 <a href ="'.$url_page.$last_page.'" title="最末頁"><img src="'.TPL_DIR.'images/lastPage.gif" border="0"/></a>';

	if($this->total_row > 0) return $page_bar;
	else return '';
  }

  /**
   * 分頁從0開始
   *
   * 這是我修過的版本，主要是把$_Language和$_SESSION拿掉
   * 不過HTML的部份是留著的
   */
  function get_page_bar($url_page, $sort_url = '') {
	$get_query = '';

	if($this->total_row == 0) return array();
	if($this->total_page <= 1) return array();

    $total_page = 1;
	if($this->total_page > 1)
	$total_page = $this->total_page;

	//$CI = &get_instance();

	// 建立基本元素
	$data['mysqleric'] = '1';
	$data['sort_url'] = $sort_url;
	$data['pagination']['current_start_record'] = $this->start_row+1;
	$data['pagination']['current_end_record'] = $this->max_row;
	$data['pagination']['total'] = $this->all_rows;
	$data['pagination']['control']['now'] = $this->start_page+1;
	$data['pagination']['control']['total'] = $total_page;

	//第一頁
	$start_page = 0;
	
	//上一頁
	$per_page   = $this->start_page-1;
	if($per_page < 0)
	$per_page = 0;
	
	//下一頁
	$next_page  = $this->start_page+1;
	if($next_page  > $this->total_page-1)
	$next_page = $this->total_page-1;
	
	//最末頁
	$last_page  = $this->total_page-1;
	//開始頁數
	$page_start = floor($this->start_page / $this->page_number) * $this->page_number;
	$per_ten_page = "";
	$next_ten_page = "";

	// 分頁的數量控制
	if($page_start >= $this->page_number)
	{
		$data['pagination']['control']['prevten'] = $url_page.($page_start-1);
	}
	//結束頁數
	$page_end = $page_start + $this->page_number;
	if($page_end >= $this->total_page)
	{
		$page_end = $this->total_page;
	}
	else 
	{
		$data['pagination']['control']['nextten'] = $url_page.($page_end);
	}
	
	$arg  = func_get_args();
	$page_bar = '<div class="pageNav">';

	if($this->start_page == $start_page){
		$data['pagination']['control']['first'] = '';
	} else {
		$data['pagination']['control']['first'] = $url_page.$start_page;
	}

	if($this->start_page == $start_page){
		$data['pagination']['control']['prev'] = '';
	} else {
		$data['pagination']['control']['prev'] = $url_page.$per_page;
	}

	$page_bar .= $per_ten_page;
	$num = array();
	for($i=$page_start ; $i<$page_end ; $i++)
	{
		$number_tmp = array(
			'name' => ($i+1),
			'link' => $url_page.$i,
		);
		$data['pagination']['number'][] = $number_tmp;
	}

	$page_bar .= $next_ten_page;

	if($this->start_page == $next_page){
		$data['pagination']['control']['next'] = '';
	} else {
		$data['pagination']['control']['next'] = $url_page.$next_page;
	}

	if($this->start_page == $last_page){
		$data['pagination']['control']['last'] = '';
	} else {
		$data['pagination']['control']['last'] = $url_page.$last_page;
	}

	// 例如/news/
	// 給Jump帶分頁進去所使用
	$data['pagination']['control']['jump'] = $url_page;
	$data['pagination']['control']['rows_per_page'] = $this->rows_per_page;
	
	//$page_bar .= '</div>';

    //if (is_array($data)){
    //    $CI->smarty_parser->assign(&$data);
    //}

	//return $CI->smarty_parser->fetch('template/default/includes/pagination.htm', null, null, false);
	return $data;
  }
  
  /**
   * 這是入賢的原始函式
   * 分頁從0開始
   */
  function get_page_bar_eric($url_page) {
  	global $_Language;
  	global $_SESSION;

	$get_query = '';
	
	if($this->total_row == 0) return "";
	if($this->total_page <= 1) return "";

	//第一頁
	$start_page = 0;
	
	//上一頁
	$per_page   = $this->start_page-1;
	if($per_page < 0)
	$per_page = 0;
	
	//下一頁
	$next_page  = $this->start_page+1;
	if($next_page  > $this->total_page-1)
	$next_page = $this->total_page-1;
	
	//最末頁
	$last_page  = $this->total_page-1;
	//開始頁數
	$page_start = floor($this->start_page/10) * 10;
	$per_ten_page = "";
	$next_ten_page = "";
	if($page_start >= 10)
	{
		$per_ten_page .= '<a href ="'.$url_page.($page_start-1).'">...'.$page_start.'</a> ';
	}
	//結束頁數
	$page_end = $page_start + 10;
	if($page_end >= $this->total_page)
	{
		$page_end = $this->total_page;
	}
	else 
	{
		$next_ten_page = '　<a href ="'.$url_page.($page_end).'">'.($page_end+1).'...</a>';
	}
	
	$arg  = func_get_args();
	$page_bar = '<div class="pageNav">';
	if($this->start_page == $start_page)
		$page_bar .= '<a class="first" title="'.$_Language[$_SESSION['SysLang']]['lbPageFirst'].'" hidefocus="Y">&nbsp;</a> ';
	else
		$page_bar .= '<a href ="'.$url_page.$start_page.'" class="first" title="'.$_Language[$_SESSION['SysLang']]['lbPageFirst'].'" hidefocus="Y">&nbsp;</a> ';
	if($this->start_page == $start_page)
		$page_bar .= '<a class="previous" title="'.$_Language[$_SESSION['SysLang']]['lbPagePrevious'].'" hidefocus="Y">&nbsp;</a>　';
	else
		$page_bar .= '<a href ="'.$url_page.$per_page.'" class="previous" title="'.$_Language[$_SESSION['SysLang']]['lbPagePrevious'].'" hidefocus="Y">&nbsp;</a>　';
	$page_bar .= $per_ten_page;
	$num = array();
	for($i=$page_start ; $i<$page_end ; $i++)
	{
		if($i > $page_start)
			$page_bar .= '　';
		if($this->start_page == $i)
			$page_bar .= '<span class="selected">'.($i+1).'</span>';
		else
			$page_bar .= '<a href="'.$url_page.$i.'">'.($i+1).'</a>';
	}
	$page_bar .= $next_ten_page;
	if($this->start_page == $next_page)
		$page_bar .= '　<a class="next" title="'.$_Language[$_SESSION['SysLang']]['lbPageNext'].'" hidefocus="Y">&nbsp;</a>';
	else
		$page_bar .= '　<a href ="'.$url_page.$next_page.'" class="next" title="'.$_Language[$_SESSION['SysLang']]['lbPageNext'].'" hidefocus="Y">&nbsp;</a>';
	if($this->start_page == $last_page)
		$page_bar .= ' <a class="last" title="'.$_Language[$_SESSION['SysLang']]['lbPageLast'].'" hidefocus="Y">&nbsp;</a>';
	else
		$page_bar .= ' <a href ="'.$url_page.$last_page.'" title="'.$_Language[$_SESSION['SysLang']]['lbPageLast'].'" class="last" hidefocus="Y">&nbsp;</a>';
	
	$page_bar .= '</div>';

	return $page_bar;
  }
    
  /*** 數字分頁bar */
  function creat_num_bar($curr_page = 'current_page')
  {
    $num = array();
	for($i=0 ; $i<$this->total_page ; $i++)
	{
	   $num[] = '<a href="?'.$curr_page.'='.$i.'">'.($i+1).'</a>';
	}
	
	$num_bar = join(" | ", $num);
	
	echo $num_bar;
  }
  
  //*** 顯示記錄計數
  function record_info() {
  	global $_Language;
  	global $_SESSION;
    $total_page = 1;
	if($this->total_page > 1)
	$total_page = $this->total_page;
	
	if($this->total_row > 0){
	  $spRecordInfo = '頁次 %s / %s , 本頁顯示 %s - %s 筆 , 全部共 %s 筆紀錄';
	  return sprintf($spRecordInfo, $this->start_page+1, $total_page, $this->start_row+1, $this->max_row, $this->all_rows);
	}
  }

  //*** 顯示記錄計數
  function get_record_info($unit="筆", $item="記錄")
  {
    $total_page = 1;
	if($this->total_row > 0)
		$total_page = $this->total_page;
	else return "";
	
	if($this->total_row > 0)
	$str = sprintf('第 %s - %s %s , 全部共 %s %s%s',
						$this->start_row+1, 
						$this->max_row,
						$unit,
						$this->all_rows,
						$unit,
						$item);
	return $str;
  }
  
  //*** 資料格式化處理 example : data => 'data'
  function GetSQLValueString($theValue, $theType, $theDefinedValue = '', $theNotDefinedValue = '') 
  {
    switch ($theType) {
     case "text":
	   $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
       $theValue = ($theValue != '') ? "'" . $theValue . "'" : 'NULL';
       break;    
     case "int":
       $theValue = ($theValue != '') ? intval($theValue) : 0;
       break;
     case "long":
       $theValue = ($theValue != '') ? $theValue : 0;
       break;
     case "double":
       $theValue = ($theValue != '') ? "'" . sprintf('%04f', doubleval($theValue)) . "'" : 0.0;
       break;
     case "defined":
	   $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
       $theValue = ($theValue != '') ? $theDefinedValue : $theNotDefinedValue;
       break;
   }
    return $theValue;
  }
  
  //*** 跳脫破壞性符號
  function quote($str)
  {	
   $str = (get_magic_quotes_gpc()) ? $str : addslashes($str);
   return $str;
  }
  
  //*** 鎖定table
  function lock_table($mode)
  {
    switch ($mode)
	{
	  case "w":
	  $mode = "LOW_PRIORITY WRITE";
	  break;
	}
	
	$this->mysqli->query('LOCK TABLES '.$this->table.' '.$mode);
  }
  
  //*** 解除鎖定table
  function unlock_table()
  {
    $this->mysqli->query('UNLOCK TABLES');
  }
  
  //*** get_insert_id
  function get_insert_id()
  {
    return $this->mysqli->insert_id;
  }
  
  function db_backup($qry_method, $seq_id, $restore_qry, $update_qry){
  	global $_SESSION;
  	global $ip;
  	
  	$app_user = 'Unknow';
  	if($_SESSION['auth']['logined'] > 0){
  		$app_user = $_SESSION['auth']['model'].':'.$_SESSION['auth']['user_name'].' ('.$_SESSION['auth']['user_id'].')';
  	}
  	
  	symbol_transcode($select_sql);
  	symbol_transcode($restore_qry);
  	symbol_transcode($update_qry);
  	
  	$queryString = 'INSERT INTO `db_backup` (`qry_method`, `table_name`, `seq_id`, `restore_sql`, `update_sql`, `ip_addr`, `app_user`, `create_date`, `modify_date`)';
  	$queryString .= " VALUES ('".$qry_method."', '".$this->table."', '".$seq_id."', '".$restore_qry."', '".$update_qry."', '".$ip['REMOTE_ADDR']."', '".$app_user."', NOW(), NOW() );";
  	$this->mysqli->query($queryString) or die($this->mysqli->error."<br>\n".$queryString);
//  	$this->backup_id = $this->mysqli->insert_id;
  }
  
  //自動調整順序ID
  function magic_sort_id($where_qry = ' AND `pid`=0')
  {
	// 取得資料表所有field
	$fields = $this->get_table_field();
	$whereStr = '';
	if($where_qry != '')
		$whereStr .= $where_qry;
	
	if(in_array('sort_id', $fields))
	{
		$this->getData('`id`', 'WHERE 1 '.$whereStr.' ORDER BY `sort_id` ASC');
		if($this->total_row > 0)
		{
			$i = 1;
			do{
				$query = 'UPDATE '.$this->table.' SET `sort_id`='.$i.' WHERE `id`='.$this->row["id"].' ;';
				$this->query($query);
				$i++;
			}while($this->row = $this->result->fetch_assoc());
		}
	}
  }
  
  //備份資料檔 .sql
  function dump_db($filePath='') {
	$sql_file = 'schema'.date('YmdHi').'.sql';
	ini_set('safe_mode', 'off');
	if($filePath == '') {
		$command=(@$_SERVER['SystemRoot'] == 'C:\WINDOWS')? 'S:/AppServ/MySQL/bin/mysqldump.exe '.DB_DATABASE.' -u'.DB_USER.' -p'.DB_PASSWORD.' --opt > '.ROOT_PATH.DS.'tmp'.DS.'backup'.DS.$sql_file : 'mysqldump --opt '.DB_DATABASE.' -h '.DB_HOST.' --user='.DB_USER.' --password='.DB_PASSWORD.' > '.ROOT_PATH.DS.'tmp'.DS.'backup'.DS.$sql_file;
		exec($command);
		if(is_file(ROOT_PATH.DS.'tmp'.DS.'backup'.DS.$sql_file)){
			header('Content-type: application/octetstream');
			header('Content-Disposition: attachment; filename="'.$sql_file.'"');
			readfile(ROOT_PATH.DS.'tmp'.DS.'backup'.DS.$sql_file);
			return;
	    }
	} else {
		$command=(@$_SERVER['SystemRoot'] == 'C:\WINDOWS')? 'S:/AppServ/MySQL/bin/mysqldump.exe '.DB_DATABASE.' -u'.DB_USER.' -p'.DB_PASSWORD.' --opt > '.$filePath.DS.$sql_file : 'mysqldump --opt '.DB_DATABASE.' -h '.DB_HOST.' --user='.DB_USER.' --password='.DB_PASSWORD.' > '.$filePath.DS.$sql_file;
		exec($command);
		if(is_file(ROOT_PATH.DS.'tmp'.DS.'backup'.DS.$sql_file)){
			return;
		}
	}
    return false;
  }
}
?>
