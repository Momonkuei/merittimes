<?php
if(empty($_SESSION['member_data'])){
	echo "<script>alert('請先登入');window.location.href='/guestlogin_".$this->data['ml_key'].".php';</script>";
}
if($_SESSION['member_data']['member_grade']==1){
	echo "<script>alert('代表窗口請至總覽頁面操作');window.location.href='/apply_".$this->data['ml_key']."_4.php';</script>";
}
//班級資料
//填寫計畫頁面
$class_data=$this->cidb->where('id',$_SESSION['member_data']['class_id'])->get('writeplan_class')->row_array();

// if(empty($class_data['pic_name']) && isset($_SESSION['class_1_data']) && !empty($_SESSION['class_1_data']['pic_name'])){
// 	$class_data['pic_name']=$_SESSION['class_1_data']['pic_name'];
// }
// if(empty($class_data['pic_description']) && isset($_SESSION['class_1_data']) && !empty($_SESSION['class_1_data']['pic_description'])){
// 	$class_data['pic_description']=$_SESSION['class_1_data']['pic_description'];
// }
// if(empty($class_data['description']) && isset($_SESSION['class_1_data']) && !empty($_SESSION['class_1_data']['description'])){
// 	$class_data['description']=$_SESSION['class_1_data']['description'];
// }
//檔案上傳-資料夾判斷
$school=(!empty($_SESSION['member_data']['code'])?$_SESSION['member_data']['code']:'all_school');
//檔案上傳-路徑
$data_path='/_i/assets/upload/class/'.$school.'/'.$_SESSION['member_data']['class_id'];

if(!empty($_POST)){
	//圖片上傳
	// $_SESSION['class_1_data']=$_POST;
	if(!empty($_FILES['file1']['name'])){
		//檔案上傳-資料夾判斷
		$school=(!empty($_SESSION['member_data']['code'])?$_SESSION['member_data']['code']:'all_school');
		if(!file_exists(_BASEPATH.'/assets/upload/class/'.$school.'/'.$_SESSION['member_data']['class_id'])){
			mkdir(_BASEPATH.'/assets/upload/class/'.$school.'/'.$_SESSION['member_data']['class_id']);
		}
		//檔案上傳-路徑
		$data_path=_BASEPATH.'/assets/upload/class/'.$school.'/'.$_SESSION['member_data']['class_id'];
		
		$post_max_size=intval(ini_get('post_max_size'))*1024*1024;//總和
		$upload_max_filesize=intval(ini_get('upload_max_filesize'))*1024*1024;//單一
		$siaz=0;
		foreach($_FILES as $k => $v){
			if($v['size']>$upload_max_filesize){
				unset($_POST);
				echo"
					<meta http-equiv='content-type' content='text/html; charset=utf-8'>
					<script>
						alert('檔案過大，檔案大小請小於".ini_get('upload_max_filesize')."!');
						window.location.href='/class_".$this->data['ml_key']."_1.php';
					</script>";
					die;
			}
			$tmp=explode(".",$v['name']);	//把檔案名稱分割成檔名和副檔名
        	$ExtName= end($tmp);	//取得陣列裡面的"副檔名"
        	// $FileExtName= $tmp[count($tmp)-2];	//取得陣列裡面的"檔名"
			$FileName=$data_path.'/'.$v['name'];
			
			if($ExtName!='jpg' && $ExtName!='jpeg' && $ExtName!='png' && $ExtName!='gif' && $ExtName!='svg'){
				unset($_POST);
				echo "
					<meta http-equiv='content-type' content='text/html; charset=utf-8'>
					<script>
						alert('圖片格式錯誤!');
						window.location.href='/class_".$this->data['ml_key']."_1.php';
					</script>";
					die;
			}
			if(!move_uploaded_file($v["tmp_name"],$FileName)){//取得前面有檔案的陣列，並且做上傳的動作
				unset($_POST);
				echo "
					<meta http-equiv='content-type' content='text/html; charset=utf-8'>
					<script>
						alert('圖片上傳失敗，請重新上傳!');
						window.location.href='/class_".$this->data['ml_key']."_1.php';
					</script>";
					die;
			}
		}
	}
	$data_array=array(
		'pic_name'=>$_POST['pic_name'],
		'pic_description'=>$_POST['pic_description'],
		'description'=>$_POST['description'],
	);
	if(!empty($_FILES['file1']['name'])){
		$data_array['pic1']=$_FILES['file1']['name'];
	}
	$this->cidb->where('id',$_SESSION['member_data']['class_id']);
    if(!$this->cidb->update('writeplan_class',$data_array)){
		unset($_POST);
        echo    
		"<meta http-equiv='content-type' content='text/html; charset=utf-8'>
		<script>
			alert('修改失敗，請從新填寫!');
			history.back();
		</script>";
		die;
    }else{
        unset($_POST);
		// unset($_SESSION['class_1_data']);
		echo "
		<meta http-equiv='content-type' content='text/html; charset=utf-8'>
		<script>
			alert('修改成功!');
			window.location.href='/class_".$this->data['ml_key']."_1.php';
		</script>";
		die;
    }
}
?>

