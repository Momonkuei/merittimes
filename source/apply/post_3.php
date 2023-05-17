<?php
if(empty($_SESSION['member_data'])){
	echo "<script>alert('請先登入');window.location.href='/guestlogin_".$this->data['ml_key'].".php';</script>";
}
if($_SESSION['member_data']['member_grade']!=1){
	echo "<script>alert('師生成員請至班級頁面操作');window.location.href='/class_".$this->data['ml_key']."_1.php';</script>";
}
//計畫資料
$writeplan_array=$this->cidb->where('a_results!="核可"')->where('is_enable',1)->where('member_id',$_SESSION['member_data']['id'])->order_by('create_time desc')->get('writeplan')->result_array();
//學期資料
$semester_array=$this->cidb->where('is_enable',1)->where('type','semester')->order_by('sort_id')->get('html')->result_array();
if(!empty($semester_array)){
	foreach($semester_array as $k => $v){
		$semester[$v['id']]=$v['topic'];
	}
}
$post_max_size=intval(ini_get('post_max_size'));//總和
$upload_max_filesize=intval(ini_get('upload_max_filesize'));//單一
$num_mb=min($post_max_size,$upload_max_filesize);
if(!empty($_FILES)){
	//檔案上傳-資料夾判斷
	$school=(!empty($_SESSION['member_data']['code'])?$_SESSION['member_data']['code']:'all_school');
	if(!file_exists(_BASEPATH.'/assets/file/writeplan/'.$school.'/'.$_POST['writeplan_id'])){
		mkdir(_BASEPATH.'/assets/file/writeplan/'.$school.'/'.$_POST['writeplan_id']);
	}
	//檔案上傳-路徑
	$data_path=_BASEPATH.'/assets/file/writeplan/'.$school.'/'.$_POST['writeplan_id'];

	if($_FILES['file3']['size']>($num_mb*1024*1024)){
		unset($_POST);
		echo"
			<meta http-equiv='content-type' content='text/html; charset=utf-8'>
			<script>
				alert('檔案過大，檔案大小請小於".$num_mb."MB!');
				window.location.href='/apply_".$this->data['ml_key']."_3.php';
			</script>";
			die;
	}
	$tmp=explode(".",$_FILES['file3']['name']);	//把檔案名稱分割成檔名和副檔名
    // $ExtName= end($tmp);	//取得陣列裡面的"副檔名"
    // $FileExtName= $tmp[count($tmp)-2];	//取得陣列裡面的"檔名"
	$FileName=$data_path.'/'.$_FILES['file3']['name'];
	if(!move_uploaded_file($_FILES['file3']["tmp_name"],$FileName)){//取得前面有檔案的陣列，並且做上傳的動作
		unset($_POST);
		echo "
			<meta http-equiv='content-type' content='text/html; charset=utf-8'>
			<script>
				alert('檔案上傳失敗，請重新上傳!');
				window.location.href='/apply_".$this->data['ml_key']."_3.php';
			</script>";
			die;
	}else{
		$writeplan_up=array(
			'file3'=>$_FILES['file3']['name'],
			'update_time'   =>date('Y-m-d H:i:s'),
		);
		$this->cidb->where('id',$_POST['writeplan_id']);
        $this->cidb->update('writeplan',$writeplan_up);   
		unset($_POST);
		echo "
			<meta http-equiv='content-type' content='text/html; charset=utf-8'>
			<script>
				alert('檔案上傳成功!');
				window.location.href='/apply_".$this->data['ml_key']."_3.php';
			</script>";
			die;	
	}
}
// print_r($semester);die;

?>

