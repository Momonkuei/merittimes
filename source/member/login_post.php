<?php

/*
 * 請注意，有兩個地方會使用這個檔案
 * 獨立頁的登入，和浮起來的視窗登入
 */
if(!empty($_POST)){
	$post = $_POST;
	$next = '';
	// if(isset($_GET['next']) and $_GET['next'] != ''){
	// 	$next = '?next='.$_GET['next'];
	// } elseif(isset($post['next']) and $post['next'] != ''){
	// 	$next = '?next='.$post['next'];
	// }//20221123 lin 註解 登入有錯誤時不返回帳密

	// 2019-07-31 新增gtoken的檢查，李哥說要加的
	// if(!isset($_POST['gtoken']) or $_POST['gtoken'] == '' or !isset(Yii::app()->session['gtoken']) or Yii::app()->session['gtoken'] == '' or Yii::app()->session['gtoken'] != $_POST['gtoken']){
	// 	$redirect_url = 'guestlogin_'.$this->data['ml_key'].'.php'.$next;
	// 	// G::alert_and_redirect(t('Incorrent token, please contact administrator','en'), $redirect_url, $this->data);
	// 	echo "<script>alert('".t('Incorrent token, please contact administrator','en')."');window.parent.location.href = '".$redirect_url."'</script>"; 

	// }

	if($this->data['router_method'] == 'guestlogin'){
		if($post['captcha'] != Yii::app()->session['captcha']){
			unset($_POST);
			$redirect_url = 'guestlogin_'.$this->data['ml_key'].'.php'.$next;
			G::alert_and_redirect(t('驗證碼錯誤！'), $redirect_url, $this->data);
			// G::alert_captcha(t('驗證碼錯誤'), $redirect_url, $this->data); // iframe sample
			die;
		}
		// 如果成功，就清session，很重要哦
		Yii::app()->session['captcha'] = '';
	} else {
		echo 'unknow error';die;
	}

	$login_password = $post['login_password'];

	unset($_constant);
	eval('$_constant = '.strtoupper('customer_password_encrypt_type').';');
	if($_constant == '0'){
		// do nothing
	} elseif($_constant == '1'){
		$login_password = sha1($login_password);
	} elseif($_constant == '2'){
		//註冊會員和舊會員區別
		//註冊會員會有salt值 舊會員為直接匯入地所以不會有這個值
		// 先找出salt
		$row2 = $this->db->createCommand()->select('salt')->from('customer')
		->where('login_account=:account ', array(':account' => $post['login_account']))
		->queryRow();
		// $company_member_result = $this->cidb->where('keyname','function_constant_company_member')->get('sys_config')->row_array();
		// $company_member_style=$company_member_result["keyval"];

		// if($company_member_style=="false"){
		// 	if(!$row2){
		// 		$redirect_url = 'guestlogin_'.$this->data['ml_key'].'.php'.$next;
		// 		// G::alert_and_redirect(t('帳號或密碼錯誤！'), $redirect_url, $this->data);
		// 		echo "<script>alert('".t('帳號或密碼錯誤！')."');window.parent.location.href = '".$redirect_url."'</script>"; 

		// 		die;
		// 	}
		// }
		// else{
		// 	if(!$row2){
		// 		$redirect_url = 'guestlogin_'.$this->data['ml_key'].'.php'.$next;
		// 		// G::alert_and_redirect(t('若是一般會員，請您輸入正確的帳號或密碼。若是企業會員，須審核通過才可以登入。'), $redirect_url, $this->data);
		// 		echo "<script>alert('".t('若是一般會員，請您輸入正確的帳號或密碼。若是企業會員，須審核通過才可以登入。')."');window.parent.location.href = '".$redirect_url."'</script>"; 

		// 		die;
		// 	}
		// }
		if(!empty($row2['salt'])){
			$login_password = '{GGG3AAA}'.str_replace('a','ɢ', sha1(G::utf8_strrev($login_password.$row2['salt'])));
		}else{
			$login_password=md5($login_password);
		}
		
	}
	// 找一下有沒有存在的帳號在資料庫裡面
	$row = $this->db->createCommand()->from('customer')
	->where('login_account=:account AND login_password=:password', array(':account' => $post['login_account'], ':password' => $login_password))
	->queryRow();
	if($row and isset($row['id'])){
		$redirect_url = 'index_'.$this->data['ml_key'].'.php'; 
		if($row['is_enable']=='1'){
			$_SESSION['member_data']=array(
				'id'=>$row['id'],
				'class_id'=>$row['other6'],
				'name'=>$row['name'],
				
				'jobtitle'=>$row['jobtitle'],
				'code'=>$row['code'],
				'member_grade'=>$row['member_grade'],
			);
			//帳號有分層級  主要帳號的學校名稱如修改  次層級不會修改 所以直接抓主要帳號的學校名稱
			if($_SESSION['member_data']['member_grade']!=1){
				$mainschool_data = $this->db->createCommand()->from('customer')->where('id=:account ', array(':account' => $row['class_id']))->queryRow();
				$_SESSION['member_data']['school_name']=$mainschool_data['school_name'];
			}else{
				$_SESSION['member_data']['school_name']=$row['school_name'];
			}
			if(isset($next) and $next != ''){
				$redirect_url = str_replace('?next=','',$next); // 2020-04-20
			}
			$_show_text = t('登入成功！');

			if($row['member_grade']==1){
				$redirect_url='apply_'.$this->data['ml_key'].'_1.php';
			}else{
				$class_data=$this->cidb->where('id',$row['other6'])->get('writeplan_class')->row_array();
				//班級資料
				if(!empty($class_data)){
					$_SESSION['member_data']['class_name']=$class_data['class_name'];
				}
				$redirect_url='class_'.$this->data['ml_key'].'_1.php';
			}
		}else{
			$_show_text='您尚未通過驗證 \n1.若您是學校代表窗口，請至信箱點擊驗證連結! \n2.若您是教師或學生，請洽貴校的學校代表窗口聯繫，謝謝!';
		}

		G::alert_and_redirect($_show_text, $redirect_url, $this->data, true); // 2020-03-17 如果沒有重導，請試試換成這行，會改用parent.location.href
		// G::alert_and_redirect(t('登入成功！'), $redirect_url, $this->data);
		//$this->redirect($url);
	} else {
		$redirect_url = 'guestlogin_'.$this->data['ml_key'].'.php'.$next;
		// G::alert_and_redirect(t('帳號或密碼錯誤！'), $redirect_url, $this->data);
		echo "<script>alert('".t('帳號或密碼錯誤！')."');window.parent.location.href = '".$redirect_url."'</script>"; 

	}
	die;
}

