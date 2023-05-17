<?php
if(empty($_SESSION['member_data'])){
	echo "<script>alert('請先登入');window.location.href='/guestlogin_".$this->data['ml_key'].".php';</script>";
}
if($_SESSION['member_data']['member_grade']!=1){
	echo "<script>alert('師生成員請至班級頁面操作');window.location.href='/class_".$this->data['ml_key']."_1.php';</script>";
}
//截止日期
$end_data='';

//計畫資料
$writeplan_array_o=$this->cidb->where('member_id',$_SESSION['member_data']['id'])->where('is_enable',1);
if(isset($_GET['writeplan_id']) && !empty($_GET['writeplan_id'])){
	$writeplan_array_o=$writeplan_array_o->where('id',$_GET['writeplan_id']);
}
$writeplan_array_o=$writeplan_array_o->order_by('create_time desc')->get('writeplan')->result_array();

//學期資料
$semester_array=$this->cidb->where('is_enable',1)->where('type','semester')->order_by('sort_id')->get('html')->result_array();
if(!empty($semester_array)){
	foreach($semester_array as $k => $v){
		if(isset($_GET['writeplan_id']) && !empty($_GET['writeplan_id'])){
			//截止日期
			if($v['id']==$writeplan_array_o[0]['semester']){
				$end_data=$v['date1'];
			}
		}
		$semester[$v['id']]=$v['topic'];
	}
}
$writeplan_array=array();
$a=0;
foreach($writeplan_array_o as $k => $v){
	if($v['a_results']=='核可'){
		$writeplan_array[$a]=$v;
		$writeplan_array[$a]['semester_name']=$semester[$v['semester']];
		$a++;
	}
	
}

//抓已上傳檔案
if(isset($_GET['writeplan_id']) && !empty($_GET['writeplan_id'])){
	$fiel_list=$this->cidb->where('writeplan_id',$_GET['writeplan_id'])->where('ml_key',$this->data['ml_key'])->order_by('create_time desc')->get('writeplan_file')->result_array();
	//檔案上傳-路徑
	$school=(!empty($_SESSION['member_data']['code'])?$_SESSION['member_data']['code']:'all_school');
	$data_path='/_i/assets/file/writeplan/'.$school.'/'.$_GET['writeplan_id'];
	//檔案上傳-資料夾判斷
}	
// print_r($writeplan_array);die;
if(!empty($_POST)){
	if(empty($_POST['cars'])){
		unset($_POST);
		echo "
			<meta http-equiv='content-type' content='text/html; charset=utf-8'>
			<script>
				alert('請選擇學期!');
				window.location.href='/apply_".$this->data['ml_key']."_5.php';
			</script>";
		die;	
	}
	if(empty($_GET['writeplan_id']))$_GET['writeplan_id']=$_POST['cars'];
	//檔案上傳-資料夾判斷
	$school=(!empty($_SESSION['member_data']['code'])?$_SESSION['member_data']['code']:'all_school');
	if(!file_exists(_BASEPATH.'/assets/file/writeplan/'.$school.'/'.$_GET['writeplan_id'])){
		mkdir(_BASEPATH.'/assets/file/writeplan/'.$school.'/'.$_GET['writeplan_id']);
	};
	//檔案上傳-路徑
	$data_path=_BASEPATH.'/assets/file/writeplan/'.$school.'/'.$_GET['writeplan_id'];
	$upload_max_filesize=intval(ini_get('upload_max_filesize'))*1024*1024;//單一
	$writeplan_id=$_POST['cars'];
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
		//新增圖片用
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
						'file1'=>$v,
						'is_enable'=>1,
						'create_time'=>date('Y-m-d H:i:s'),
					);
					$this->cidb->insert('writeplan_file',$writeplan_file);
					$id = $this->cidb->insert_id();
				}else{
					unset($_POST);
					unset($_GET);
					echo "
						<meta http-equiv='content-type' content='text/html; charset=utf-8'>
						<script>
							alert('".$v."上傳失敗，請從該檔案開始重新上傳!');
							window.location.href='/apply_".$this->data['ml_key']."_5.php';
						</script>";
					die;
				}
			}	
		}
	}	
	unset($_POST);
	unset($_GET);
	echo "
		<meta http-equiv='content-type' content='text/html; charset=utf-8'>
		<script>
			alert('新增成功!');
			window.location.href='/apply_".$this->data['ml_key']."_5.php?writeplan_id=".$writeplan_id."';
		</script>";
	die;
}
?>

