<?php
if(empty($_SESSION['member_data'])){
	echo "<script>alert('請先登入');window.location.href='/guestlogin_".$this->data['ml_key'].".php';</script>";
}
if($_SESSION['member_data']['member_grade']==1){
	echo "<script>alert('代表窗口請至總覽頁面操作');window.location.href='/apply_".$this->data['ml_key']."_4.php';</script>";
}
//截止日期
$end_data='';
//班級資料
$class_data=$this->cidb->where('id',$_SESSION['member_data']['class_id'])->get('writeplan_class')->row_array();

$class_data['writeplan_id']=rtrim(ltrim($class_data['writeplan_id'], ","), ",");
$class_data['writeplan_id']=explode(',',$class_data['writeplan_id']);
//計畫資料
$writeplan_array=$this->cidb->where_in('id',$class_data['writeplan_id'])->where('is_enable',1)->get('writeplan')->result_array();
//學期資料
$semester_array=$this->cidb->where('is_enable',1)->where('type','semester')->get('html')->result_array();
if(!empty($semester_array)){
	foreach($semester_array as $k => $v){
		if(isset($_GET['cars']) && !empty($_GET['cars'])){
			//截止日期
			$writeplan_array_o=$this->cidb->where('id',$_GET['cars'])->where('is_enable',1)->get('writeplan')->row_array();
			if(!empty($writeplan_array_o) && $v['id']==$writeplan_array_o['semester']){
				$end_data=$v['date1'];
			}
		}
		$semester[$v['id']]=$v['topic'];
	}
}

//班級學期資料
$class_semester_array=array();
foreach($writeplan_array as $k => $v){
	// print_r($writeplan_array);die;
	if($v['a_results']=='核可'){
		$writeplan_class=$this->cidb->like('writeplan_id',','.$v['id'].',')->like('other7',','.$v['semester'].',')->where('is_enable',1)->order_by('id desc')->get('writeplan_class')->result_array();
		if(!empty($writeplan_class)){
			foreach($writeplan_class as $kk => $vv){
				$class_semester_array[$v['id']]=$semester[$v['semester']];
			}
		}
	}
}

//檔案上傳-資料夾判斷
$school=(!empty($_SESSION['member_data']['code'])?$_SESSION['member_data']['code']:'all_school');
//檔案上傳-路徑
$data_path='/_i/assets/file/writeplan/'.$school.'/';

if(!empty($_POST)){
	if(empty($_POST['cars'])){
		unset($_POST);
		echo "
			<meta http-equiv='content-type' content='text/html; charset=utf-8'>
			<script>
				alert('請選擇學期!');
				window.location.href='/class_".$this->data['ml_key']."_6.php';
			</script>";
		die;	
	}
	//檔案上傳-資料夾判斷
	$school=(!empty($_SESSION['member_data']['code'])?$_SESSION['member_data']['code']:'all_school');
	if(!file_exists(_BASEPATH.'/assets/file/writeplan/'.$school.'/'.$_POST['cars'])){
		mkdir(_BASEPATH.'/assets/file/writeplan/'.$school.'/'.$_POST['cars']);
	};
	//檔案上傳-路徑
	$data_path=_BASEPATH.'/assets/file/writeplan/'.$school.'/'.$_POST['cars'];
	$upload_max_filesize=intval(ini_get('upload_max_filesize'))*1024*1024;//單一
	if(!empty($_FILES)){
		//舊圖上傳用
		foreach($_FILES as $k => $v){
			if($k!='files' && !empty($v['name'])){
				$field_id=str_replace('files','',$k);
				$tmp=explode(".",$v['name']);	//把檔案名稱分割成檔名和副檔名
				$ExtName= end($tmp);	//取得陣列裡面的"副檔名"
				$FileExtName= $tmp[count($tmp)-2];	//取得陣列裡面的"檔名"
				$FileName=$data_path.'/'.$v['name'];
				if(move_uploaded_file($v['tmp_name'],$FileName)){//取得前面有檔案的陣列，並且做上傳的動作
					$writeplan_file=array(
						'file1'=>$v['name'],
						'update_time'=>date('Y-m-d H:i:s'),
					);
					
					$this->cidb->where('id',$field_id);
					$this->cidb->update('writeplan_file',$writeplan_file);
				}else{
					unset($_POST);
					unset($_GET);
					echo "
						<meta http-equiv='content-type' content='text/html; charset=utf-8'>
						<script>
							alert('".$v['name']."上傳失敗，請從該檔案開始重新上傳!');
							window.location.href='/apply_".$this->data['ml_key']."_5.php';
						</script>";
					die;
				}
			}
		}
		//新圖上傳用
		foreach($_FILES['files']['name'] as $k => $v){
			if(!empty($v)){
				$tmp=explode(".",$v);	//把檔案名稱分割成檔名和副檔名
				$ExtName= end($tmp);	//取得陣列裡面的"副檔名"
				$FileExtName= $tmp[count($tmp)-2];	//取得陣列裡面的"檔名"
				$FileName=$data_path.'/'.$v;
				if(move_uploaded_file($_FILES['files']["tmp_name"][$k],$FileName)){//取得前面有檔案的陣列，並且做上傳的動作
					$writeplan_file=array(
						'writeplan_id'=>$_POST['cars'],
						'ml_key'=>$this->data['ml_key'],
						'member_id'=>$_SESSION['member_data']['id'],
						'class_id'=>$_SESSION['member_data']['class_id'],
						'file1'=>$v,
						'is_enable'=>1,
						'create_time'=>date('Y-m-d H:i:s'),
					);
					$this->cidb->insert('writeplan_file',$writeplan_file);
					$id = $this->cidb->insert_id();
				}else{
					unset($_POST);
					echo "
						<meta http-equiv='content-type' content='text/html; charset=utf-8'>
						<script>
							alert('".$v."上傳失敗，請從該檔案開始重新上傳!');
							window.location.href='/class_".$this->data['ml_key']."_6.php';
						</script>";
					die;
				}
			}	
		}
	}
	$cars=$_POST['cars'];
	unset($_POST);
	echo "
		<meta http-equiv='content-type' content='text/html; charset=utf-8'>
		<script>
			alert('上傳成功!');
			window.location.href='/class_".$this->data['ml_key']."_6.php?cars=".$cars."';
		</script>";
	die;
}
?>

