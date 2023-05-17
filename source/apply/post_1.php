<?php
if(empty($_SESSION['member_data'])){
	echo "<script>alert('請先登入');window.location.href='/guestlogin_".$this->data['ml_key'].".php';</script>";
}
if($_SESSION['member_data']['member_grade']!=1){
	echo "<script>alert('師生成員請至班級頁面操作');window.location.href='/class_".$this->data['ml_key']."_1.php';</script>";
}
//填寫計畫頁面	
if(empty($_POST)){
	$semester_array=$this->cidb->where('is_enable',1)->where('type','semester')->order_by('sort_id')->get('html')->result_array();
	foreach($semester_array as $k => $v){
		$have_sem=$this->cidb->where('is_enable',1)->where('semester',$v['id'])->where('member_id',$_SESSION['member_data']['id'])->get('writeplan')->row_array();
		if(!empty($have_sem)){
			$semester_array[$k]['have_sem']=1;
		}
	}
}else{
	$_SESSION['apply_1']=$_POST;
	$check_array=array('cars','president_name','landline','phone','description','course');
	foreach($check_array as $k => $v){
		if(empty($_POST[$v])){
			unset($_POST);
			echo "
				<meta http-equiv='content-type' content='text/html; charset=utf-8'>
				<script>
					alert('資料未填寫!');
					window.location.href='/apply_".$this->data['ml_key']."_1.php';
				</script>";
		}
	}
	$data_array=array(
		'name'=>$_SESSION['member_data']['school_name'],
		'member_id'=>$_SESSION['member_data']['id'],
	);
	$this->cidb->insert('writeplan',$data_array);
	$id = $this->cidb->insert_id();
	//檔案上傳
	// print_r($_FILES);die;
	if(!empty($_FILES)){
		
		$semester_data=$this->cidb->where('id',$_POST['cars'])->where('type','semester')->order_by('sort_id')->get('html')->row_array();
		//檔案上傳-資料夾判斷
		$school=(!empty($_SESSION['member_data']['code'])?$_SESSION['member_data']['code']:'all_school');
		if(!file_exists(_BASEPATH.'/assets/file/writeplan/'.$school.'/'.$semester_data['other1'])){
			mkdir(_BASEPATH.'/assets/file/writeplan/'.$school.'/'.$semester_data['other1']);
		}
		//檔案上傳-路徑
		$data_path=_BASEPATH.'/assets/file/writeplan/'.$school.'/'.$semester_data['other1'];

		$post_max_size=intval(ini_get('post_max_size'));//總和
		$upload_max_filesize=intval(ini_get('upload_max_filesize'));//單一
		$num_mb=min($post_max_size,$upload_max_filesize);
		$siaz=0;
		foreach($_FILES as $k => $v){
			if($v['size']>($num_mb*1024*1024)){
				unset($_POST);
				echo"
					<meta http-equiv='content-type' content='text/html; charset=utf-8'>
					<script>
						alert('檔案過大，檔案大小請小於".$num_mb."MB!');
						window.location.href='/apply_".$this->data['ml_key']."_1.php';
					</script>";
				continue;
			}
			$tmp=explode(".",$v['name']);	//把檔案名稱分割成檔名和副檔名
        	// $ExtName= end($tmp);	//取得陣列裡面的"副檔名"
        	// $FileExtName= $tmp[count($tmp)-2];	//取得陣列裡面的"檔名"
			$FileName=$data_path.'/'.$v['name'];
			move_uploaded_file($v["tmp_name"],$FileName);
			// if(!move_uploaded_file($v["tmp_name"],$FileName)){//取得前面有檔案的陣列，並且做上傳的動作
			// 	unset($_POST);
			// 	echo "
			// 		<meta http-equiv='content-type' content='text/html; charset=utf-8'>
			// 		<script>
			// 			alert('檔案上傳失敗，請重新上傳!');
			// 			window.location.href='/apply_".$this->data['ml_key']."_1.php';
			// 		</script>";
			// }
		}
	}	
	if(!empty($id)){
		$data_array=array(
			'name'=>$_SESSION['member_data']['school_name'],
			'member_id'=>$_SESSION['member_data']['id'],
			'ml_key'=>$this->data['ml_key'],
			'semester'=>$_POST['cars'],
			'president_name'=>$_POST['president_name'],
			'landline'=>$_POST['landline'],
			'extension'=>$_POST['extension'],
			'phone'=>$_POST['phone'],
			'email'=>$_POST['email'],
			'description'=>htmlspecialchars($_POST['description']),
			'implement_date'=>$_POST['implement_date'],
			'course'=>htmlspecialchars($_POST['course']),
			'remark'=>htmlspecialchars($_POST['remark']),
			'is_enable'=>1,
			'file1'=>(isset($_FILES['file1']['name']) && !empty($_FILES['file1']['name'])?$_FILES['file1']['name']:''),
			'file2'=>(isset($_FILES['file2']['name']) && !empty($_FILES['file2']['name'])?$_FILES['file2']['name']:''),
			'create_time'   =>date('Y-m-d H:i:s'),
		);
		$this->cidb->where('id',$id);
		$this->cidb->update('writeplan',$data_array);
		unset($_POST);
		unset($_SESSION['apply_1']);
		//增加申請次數
		$member_data=$this->cidb->where('id',$_SESSION['member_data']['id'])->get('customer')->row_array();
		$applications_num=$member_data['applications_num']+1;
		$this->cidb->where('id',$_SESSION['member_data']['id']);
		$this->cidb->update('customer',array('applications_num'=>$applications_num)); 
		
		echo "
			<meta http-equiv='content-type' content='text/html; charset=utf-8'>
			<script>
				alert('新增成功!');
				window.location.href='/apply_".$this->data['ml_key']."_2.php?writeplan_id=".$id."';
			</script>";
	}else{
		unset($_POST);
		echo "
			<meta http-equiv='content-type' content='text/html; charset=utf-8'>
			<script>
				alert('新增失敗，請從新填寫!');
				window.location.href='/apply_".$this->data['ml_key']."_1.php';
			</script>";
	}
}

?>

