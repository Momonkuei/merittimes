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

//檔案上傳-資料夾判斷
$school=(!empty($_SESSION['member_data']['code'])?$_SESSION['member_data']['code']:'all_school');
//檔案上傳-路徑
$data_path='/_i/assets/upload/class/'.$school.'/'.$_SESSION['member_data']['class_id'];

if(!empty($_GET['vido_id'])){
	$text='修改';
	$_SESSION['class_10']=$this->cidb->where('id',$_GET['vido_id'])->get('class_vido')->row_array();
	$re_url='?vido_id='.$_GET['vido_id'];
}else{
	$text='新增';
	$re_url='';
	unset($_SESSION['class_10']);
}
if(!empty($_POST)){
	//圖片上傳
	$_SESSION['class_10']=$_POST;
	if(!empty($_FILES['file1']['name'])){
		//檔案上傳-資料夾判斷
		$school=(!empty($_SESSION['member_data']['code'])?$_SESSION['member_data']['code']:'all_school');
		if(!file_exists(_BASEPATH.'/assets/upload/class/'.$school)){
			mkdir(_BASEPATH.'/assets/upload/class/'.$school);
		}
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
						window.location.href='/class_".$this->data['ml_key']."_10.php".$re_url."';
					</script>";
				continue;
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
						window.location.href='/class_".$this->data['ml_key']."_10.php".$re_url."';
					</script>";
			}
			if(!move_uploaded_file($v["tmp_name"],$FileName)){//取得前面有檔案的陣列，並且做上傳的動作
				unset($_POST);
				echo "
					<meta http-equiv='content-type' content='text/html; charset=utf-8'>
					<script>
						alert('圖片上傳失敗，請重新上傳!');
						window.location.href='/class_".$this->data['ml_key']."_10.php".$re_url."';
					</script>";
			}
		}
	}
	$data_array=array(
		'class_id'=>$_SESSION['member_data']['class_id'],
		'name'=>$_POST['name'],
		'url1'=>$_POST['url1'],
		'other1'=>$_POST['other1'],
		'ml_key'=>'tw',
		'is_enable'=>$_POST['is_enable'],
		'create_time'=>(!empty($_POST['create_time'])?$_POST['create_time']:date('Y-m-d H:i:s')),
	);
	if(!empty($_FILES['file1']['name'])){
		$data_array['pic1']=$_FILES['file1']['name'];
	}
	if(!empty($_GET['vido_id'])){
		$this->cidb->where('id',$_GET['vido_id']);
		if($this->cidb->update('class_vido',$data_array)){
            $id=1;
        }
	}else{
		$this->cidb->insert('class_vido',$data_array); 
		$id = $this->cidb->insert_id();
	}
	
    if(!$id){
		unset($_POST);
        echo    
		"<meta http-equiv='content-type' content='text/html; charset=utf-8'>
		<script>
			alert('".$text."失敗，請從新填寫!');
			window.location.href='/class_".$this->data['ml_key']."_10.php".$re_url."';
		</script>";
    }else{
        unset($_POST);
		unset($_SESSION['class_10']);
		echo "
		<meta http-equiv='content-type' content='text/html; charset=utf-8'>
		<script>
			alert('".$text."成功!');
			window.location.href='/class_".$this->data['ml_key']."_4.php';
		</script>";
    }
}
?>

