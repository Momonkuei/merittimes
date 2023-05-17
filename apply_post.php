<?php
header("Content-Type:text/html; charset=utf-8");
include 'layoutv3/init.php';

if(!empty($_POST)){
    if($_POST['type']=='add_class'){
        //新增班級
        $writeplan_list=$this->cidb->where('id',$_POST['writeplan_id'])->get('writeplan')->row_array();
        if($writeplan_list['a_results']!='核可'){
            $check_array=array('class_name','student_num','teacher_name','email');
            foreach($check_array as $k => $v){
                if(empty($_POST[$v])){
                    unset($_POST);
                    echo "0@@資料未填寫!";
                    die;
                }
            }
            $data_array=array(
                'writeplan_id'  =>','.$_POST['writeplan_id'].',',
                'represent_id'  =>$_SESSION['member_data']['id'],
                'other7'        =>','.$_POST['semester'].',',
                'class_name'    =>$_POST['class_name'],
                'student_num'   =>$_POST['student_num'],
                'teacher_name'  =>$_POST['teacher_name'],
                'email'         =>$_POST['email'],
                'is_enable'     =>1,
                'create_time'   =>date('Y-m-d H:i:s'),
            );
            // if(preg_match("/^[1-9][0-9]*$/" ,$amount)){
            // die('是正整数');
            // }
            //抓預設報份
            $report_num=$this->cidb->where('type','report')->get('html')->row_array();
            if(!empty($report_num['other1']) && $report_num['other1']>0){
                $report_num=$report_num['other1'];
            }else{
                $report_num=$this->data['sys_configs']['report_'.$this->data['ml_key']];
            }
            $share=0;    

            $this->cidb->insert('writeplan_class',$data_array);
            $class_array=$this->cidb->like('writeplan_id',','.$_POST['writeplan_id'].',')->like('other7',','.$_POST['semester'].',')->where('is_enable',1)->get('writeplan_class')->result_array();
            echo '1@@';
            if(!empty($class_array)){
                $all_student_num=0;
                $all_class=0;
                foreach($class_array as $k => $v){
                    $all_class++;
                    $all_student_num+=$v['student_num'];
                    $share+=ceil($v['student_num']/$report_num);
                }

                
                $report_num=$share;
                $writeplan_up=array(
                    'class_name'   =>$all_class,
                    'student_name' =>$all_student_num,
                    'actual_num'   =>$report_num,
                    'update_time'  =>date('Y-m-d H:i:s'),
                );
                $this->cidb->where('id',$_POST['writeplan_id']);
                $this->cidb->update('writeplan',$writeplan_up);     
            }
        }else{
            unset($_POST);
            echo "0@@已通過審核，無法修改!";
            die; 
        }        
    }else if($_POST['type']=='del_class'){
        //抓預設報份
        $report_num=$this->cidb->where('type','report')->get('html')->row_array();
        if(!empty($report_num['other1']) && $report_num['other1']>0){
            $report_num=$report_num['other1'];
        }else{
            $report_num=$this->data['sys_configs']['report_'.$this->data['ml_key']];
        }

        //刪除班級
        $writeplan_list=$this->cidb->where('id',$_POST['writeplan_id'])->get('writeplan')->row_array();
        if($writeplan_list['a_results']!='核可'){
            //撈班級資料
            $class_data=$this->cidb->where('id',$_POST['data_id'])->get('writeplan_class')->row_array();
            $writeplan_up=array(
                'writeplan_id'  =>str_replace(','.$writeplan_list['id'].',',',',$class_data['writeplan_id']),
                'other7'        =>str_replace(','.$writeplan_list['semester'].',',',',$class_data['other7']),
                'update_time'   =>date('Y-m-d H:i:s'),
            );
            $this->cidb->where('id',$_POST['data_id']);
            $this->cidb->update('writeplan_class',$writeplan_up);    
            //重新確認班級資料 都是空的就刪除
            $class_data=$this->cidb->where('id',$_POST['data_id'])->get('writeplan_class')->row_array();
            if($class_data['writeplan_id']==',' || $class_data['other7']==','){
                $this->cidb->where('id',$class_data['id']);
                $this->cidb->delete('writeplan_class');     
            }
            //從新撈計畫資料
            
            $share=0;
            $writeplan_data=$this->cidb->where('id',$_POST['writeplan_id'])->get('writeplan')->row_array();
            $class_array=$this->cidb->like('writeplan_id',','.$writeplan_data['id'].',')->like('other7',','.$writeplan_data['semester'].',')->where('is_enable',1)->get('writeplan_class')->result_array();
            if(!empty($class_array)){
                $all_student_num=0;
                $all_class=0;
                foreach($class_array as $k => $v){
                    $all_class++;
                    $all_student_num+=$v['student_num'];
                    $share+=ceil($v['student_num']/$report_num);
                }
                $report_num=$share;
                
                $writeplan_up=array(
                    'class_name'   =>$all_class,
                    'student_name' =>$all_student_num,
                    'actual_num'   =>$report_num,
                    'update_time'  =>date('Y-m-d H:i:s'),
                );
                $this->cidb->where('id',$_POST['writeplan_id']);
                $this->cidb->update('writeplan',$writeplan_up);     
            }else{
                $writeplan_up=array(
                    'class_name'   =>0,
                    'student_name' =>0,
                    'actual_num'   =>0,
                    'update_time'  =>date('Y-m-d H:i:s'),
                );
                $this->cidb->where('id',$_POST['writeplan_id']);
                $this->cidb->update('writeplan',$writeplan_up);     
            }
        }else{
            unset($_POST);
            echo "0@@已通過審核，無法修改!";
            die; 
        }    
    }else if($_POST['type']=='del_allclass'){
        //刪除全部班級
        $writeplan_list=$this->cidb->where('id',$_POST['writeplan_id'])->get('writeplan')->row_array();
        if($writeplan_list['a_results']!='核可'){
            //搜尋該計畫的全部班級
            $all_class_list=$this->cidb->like('writeplan_id',','.$_POST['writeplan_id'].',')->get('writeplan_class')->result_array();
            if(!empty($all_class_list)){
                foreach($all_class_list as $k => $v){
                    $array=array(
                        'writeplan_id' =>str_replace(','.$writeplan_list['id'].',',',',$v['writeplan_id']),
                        'other7'       =>str_replace(','.$writeplan_list['semester'].',',',',$v['other7']),
                        'update_time'  =>date('Y-m-d H:i:s'),
                    );
                    $this->cidb->where('id',$v['id']);
                    $this->cidb->update('writeplan_class',$array);   
                    //重新確認班級資料 都是空的就刪除
                    $class_data=$this->cidb->where('id',$v['id'])->get('writeplan_class')->row_array();
                    if($class_data['writeplan_id']==',' || $class_data['other7']==','){
                        $this->cidb->where('id',$class_data['id']);
                        $this->cidb->delete('writeplan_class');     
                    }
                }
            }
            //清空計畫的班級數量+學生數量+報分數量
            $writeplan_up=array(
                'class_name'   =>0,
                'student_name' =>0,
                'actual_num'   =>0,
                'update_time'  =>date('Y-m-d H:i:s'),
            );
            $this->cidb->where('id',$_POST['writeplan_id']);
            $this->cidb->update('writeplan',$writeplan_up);   
        }else{
            unset($_POST);
            echo "0@@已通過審核，無法修改!";
            die; 
        }       
    }else if($_POST['type']=='pull_class'){
        //抓各別班級資料
        $writeplan_list=$this->cidb->where('id',$_POST['writeplan_id'])->get('writeplan')->row_array();
        if($writeplan_list['a_results']!='核可'){
            $class_array=$this->cidb->where('id',$_POST['data_id'])->get('writeplan_class')->row_array();
            echo json_encode($class_array);
        }else{
            unset($_POST);
            echo "0@@已通過審核，無法修改!";
            die; 
        }
    }else if($_POST['type']=='up_class'){
        //修改班級資料
        $writeplan_list=$this->cidb->where('id',$_POST['writeplan_id'])->get('writeplan')->row_array();
        if($writeplan_list['a_results']!='核可'){
            $check_array=array('class_name','student_num','teacher_name','email');
            foreach($check_array as $k => $v){
                if(empty($_POST[$v])){
                    unset($_POST);
                    echo "0@@資料未填寫!";
                    die;
                }
            }
            $data_array=array(
                'class_name'    =>$_POST['class_name'],
                'student_num'   =>$_POST['student_num'],
                'teacher_name'  =>$_POST['teacher_name'],
                'email'         =>$_POST['email'],
                'is_enable'     =>1,
                'update_time'   =>date('Y-m-d H:i:s'),
            );
            $this->cidb->where('id',$_POST['class_id']);
            $this->cidb->update('writeplan_class',$data_array);         

            //抓預設報份
            $report_num=$this->cidb->where('type','report')->get('html')->row_array();
            if(!empty($report_num['other1']) && $report_num['other1']>0){
                $report_num=$report_num['other1'];
            }else{
                $report_num=$this->data['sys_configs']['report_'.$this->data['ml_key']];
            }
            $share=0;
            $class_array=$this->cidb->like('writeplan_id',','.$_POST['writeplan_id'].',')->like('other7',','.$_POST['semester'].',')->where('is_enable',1)->get('writeplan_class')->result_array();
            echo '1@@';
            if(!empty($class_array)){
                $all_student_num=0;
                $all_class=0;
                foreach($class_array as $k => $v){
                    $all_class++;
                    $all_student_num+=$v['student_num'];
                    $share+=ceil($v['student_num']/$report_num);
                }
                
                $report_num=$share;
                // echo $all_student_num.'--'.$report_num;die;
                echo $all_class.'@@'.$all_student_num.'@@'.$report_num;

                $writeplan_up=array(
                    'class_name'   =>$all_class,
                    'student_name' =>$all_student_num,
                    'actual_num'   =>$report_num,
                    'update_time'  =>date('Y-m-d H:i:s'),
                );
                $this->cidb->where('id',$_POST['writeplan_id']);
                $this->cidb->update('writeplan',$writeplan_up);     
            }
        }else{
            unset($_POST);
            echo "0@@已通過審核，無法修改!";
            die;
        }    
    }else if($_POST['type']=='pull_alldata'){
        //送出計畫資料
        $writeplan_up=array(
            'apply_num'      =>$_POST['apply_num'],
            'submission_date'=>date('Y-m-d H:i:s'),
            'update_time'    =>date('Y-m-d H:i:s'),
        );
        $this->cidb->where('id',$_POST['writeplan_id']);
        $this->cidb->update('writeplan',$writeplan_up);     

        //抓預設報份
        $report_num=$this->cidb->where('type','report')->get('html')->row_array();
        if(!empty($report_num['other1']) && $report_num['other1']>0){
            $report_num=$report_num['other1'];
         }else{
            $report_num=$this->data['sys_configs']['report_'.$this->data['ml_key']];
        }
        $share=0;
        $class_array=$this->cidb->like('writeplan_id',','.$_POST['writeplan_id'].',')->where('is_enable',1)->order_by('create_time')->get('writeplan_class')->result_array();
        echo '1@@';
        if(!empty($class_array)){
            $all_student_num=0;
            $all_class=0;
            foreach($class_array as $k => $v){
                $all_class++;
                $all_student_num+=$v['student_num'];
                $share+=ceil($v['student_num']/$report_num);
                echo'<tr>
                        <td>'.$v['class_name'].'</td>
                        <td>'.$v['teacher_name'].'</td>
                        <td>'.$v['student_num'].'</td>
                        <td>'.$v['email'].'</td>
                    </tr>';
            }
            
            $report_num=$share;
            echo'@@'.$all_class.'@@'.$all_student_num.'@@'.$report_num;    
        }
    }else if($_POST['type']=='code_register'){
        //學校代碼檢測
        $school_data=$this->cidb->where('code',mb_strtoupper($_POST['the_code']))->where('is_enable',1)->get('customer')->row_array();
        if(!empty($school_data)){
            echo 1;
        }
    }else if($_POST['type']=='account_register'){
        //學校帳號檢測
        $account_data=$this->cidb->where('login_account',$_POST['account'])->get('customer')->row_array();
        if(!empty($account_data)){
            echo 1;
        }
    }else if($_POST['type']=='email_register'){
        //信箱檢測
        $email_data=$this->cidb->where('email',$_POST['email'])->where('is_enable',1)->get('customer')->row_array();
        if(!empty($email_data)){
            echo 1;
        }
    }else if($_POST['type']=='copy_cars'){
        //複製其他計畫班級
        $copy_writeplan=$this->cidb->where('member_id',$_SESSION['member_data']['id'])->where('semester',$_POST['semester'])->get('writeplan')->row_array();
        if(!empty($copy_writeplan)){
            $copy_data_array=$this->cidb->like('writeplan_id',','.$copy_writeplan['id'].',')->where('is_enable',1)->order_by('id')->get('writeplan_class')->result_array();
            if(!empty($copy_data_array)){
                $all_student_num=0;
                $all_class=0;
                //抓預設報份
                $report_num=$this->cidb->where('type','report')->get('html')->row_array();
                if(!empty($report_num['other1']) && $report_num['other1']>0){
                    $report_num=$report_num['other1'];
                }else{
                    $report_num=$this->data['sys_configs']['report_'.$this->data['ml_key']];
                }
                $share=0;
                foreach($copy_data_array as $k => $v){
                    $writeplan_id=explode(',',$v['writeplan_id']);
                    
                    if(!in_array($_POST['writeplan_id'],$writeplan_id)){
                        if(!empty($v['other7'])){
                            $semester_data=$v['other7'].$_POST['original_semester'].',';
                        }else{
                            $semester_data=$_POST['original_semester'];
                        }
                        $writeplan_id_list=$v['writeplan_id'].$_POST['writeplan_id'].',';
                        $all_class++;
                        $all_student_num+=$v['student_num'];
                        $share+=ceil($v['student_num']/$report_num);
                        $data_array=array(
                            'other7'  =>$semester_data,
                            'writeplan_id'=>$writeplan_id_list,
                            'update_time'   =>date('Y-m-d H:i:s'),
                        );
                        //新增學期至班級
                        $this->cidb->where('id',$v['id']);
                        $this->cidb->update('writeplan_class',$data_array);
                    }else{
                        echo "0@@請勿重複複製!";
                        die;  
                    }
                }                
                $report_num=$share;
                $writeplan_up=array(
                    'class_name'   =>$all_class,
                    'student_name' =>$all_student_num,
                    'actual_num'   =>$report_num,
                    'update_time'  =>date('Y-m-d H:i:s'),
                );
                $this->cidb->where('id',$_POST['writeplan_id']);
                $this->cidb->update('writeplan',$writeplan_up);     
                echo "1@@已複製班級資料!";
                die;
            }else{
                echo "0@@該計畫尚未填寫班級!";
                die; 
            }
        }else{
            echo "0@@查無此資料!";
            die;
        }
    }else if($_POST['type']=='up_writeplan'){
        //計畫修改送出
        if(!empty($_FILES)){
            //檔案上傳-資料夾判斷
            $school=(!empty($_SESSION['member_data']['code'])?$_SESSION['member_data']['code']:'all_school');
            if(!file_exists(_BASEPATH.'/assets/file/writeplan/'.$school.'/'.$_POST['writeplan_id'])){
                mkdir(_BASEPATH.'/assets/file/writeplan/'.$school.'/'.$_POST['writeplan_id']);
            }
            //檔案上傳-路徑
            $data_path=_BASEPATH.'/assets/file/writeplan/'.$school.'/'.$_POST['writeplan_id'];

            $post_max_size=intval(ini_get('post_max_size'))*1024*1024;//總和
            $upload_max_filesize=intval(ini_get('upload_max_filesize'))*1024*1024;//單一
            $siaz=0;
            foreach($_FILES as $k => $v){
                if(!empty($v['name'])){
                    if($v['size']>$upload_max_filesize){
                        unset($_POST);
                        echo "0@@檔案大小超過限制!";
                        die;
                    }
                    $tmp=explode(".",$v['name']);	//把檔案名稱分割成檔名和副檔名
                    // $ExtName= end($tmp);	//取得陣列裡面的"副檔名"
                    // $FileExtName= $tmp[count($tmp)-2];	//取得陣列裡面的"檔名"
                    $FileName=$data_path.'/'.$v['name'];
                    if(!move_uploaded_file($v["tmp_name"],$FileName)){//取得前面有檔案的陣列，並且做上傳的動作
                        unset($_POST);
                        echo "0@@檔案上傳失敗!";
                        die;
                    }
                } 
            }
        }
        $writeplan_up=array(
            'president_name'    =>(!empty($_POST['president_name'])?$_POST['president_name']:''),
            'landline'          =>(!empty($_POST['landline'])?$_POST['landline']:''),
            'extension'         =>(!empty($_POST['extension'])?$_POST['extension']:''),
            'phone'             =>(!empty($_POST['phone'])?$_POST['phone']:''),
            'email'             =>(!empty($_POST['email_p'])?$_POST['email_p']:''),
            'description'       =>(!empty($_POST['description'])?htmlspecialchars($_POST['description']):''),
            'implement_date'    =>(!empty($_POST['implement_date'])?$_POST['implement_date']:''),
            'course'            =>(!empty($_POST['course'])?htmlspecialchars($_POST['course']):''),
            'remark'            =>(!empty($_POST['remark'])?htmlspecialchars($_POST['remark']):''),
            'apply_num'         =>(!empty($_POST['apply_num'])?$_POST['apply_num']:''),
            'update_time'       =>date('Y-m-d H:i:s'),
            'submission_date'   =>date('Y-m-d H:i:s'),
        );
        if(isset($_FILES['file1']['name']) && !empty($_FILES['file1']['name'])){
            $writeplan_up['file1']=$_FILES['file1']['name'];
        }
        if(isset($_FILES['file2']['name']) && !empty($_FILES['file2']['name'])){
            $writeplan_up['file2']=$_FILES['file2']['name'];
        }
        $this->cidb->where('id',$_POST['writeplan_id']);
        if(!$this->cidb->update('writeplan',$writeplan_up)){
            echo "0@@新增失敗!";
        }else{
            echo "1@@";
        }
  
        
    }else if($_POST['type']=='addclass_account'){
        //新增班及帳號
        if(empty($_POST['is_enable']) && $_POST['is_enable']!=='0'){
            echo "0@@請選擇權限是否開啟!";
            die;
        }
        if(empty($_POST['member_grade'])){
            echo "0@@請選擇身分!";
            die;
        }
        if($_POST['login_password']!=$_POST['login_password2']){
            echo '0@再次輸入密碼欄位錯誤!';
            die;
        }
        $semesters=implode(',',$_POST['semesters']);
        $customer_up=array(
            'login_account'=>$_POST['login_account'],
            'code'=>$_SESSION['member_data']['code'],
            'class_id'=>$_POST['member_id'],
            'member_grade'=>$_POST['member_grade'],
            'name'=>$_POST['name'],
            'school_name'=>$_SESSION['member_data']['school_name'],
            'other7'=>','.$semesters.',',
            'other3'=>$_POST['other3'],
            'other6'=>$_POST['other6'],
            'login_password'=>md5($_POST['login_password']),
            'sms_text'=>$_POST['sms_text'],
            'is_enable'=>$_POST['is_enable'],
            'create_time'   =>date('Y-m-d H:i:s'),
        );
        $this->cidb->insert('customer',$customer_up);
	    $id = $this->cidb->insert_id();
        if(!$id){
            echo "0@@新增失敗!";
        }else{
            echo "1@@";
        } 
        die;
    }else if($_POST['type']=='del_account'){
        //刪除班級帳號
        $this->cidb->where('id',$_POST['data_id']);
        $this->cidb->delete('customer');     
        
    }else if($_POST['type']=='pull_account'){
        //抓班級帳號資料
        $sql="select a.*,b.class_name from customer as a 
                left join writeplan_class as b 
                    on a.other6=b.id
                where a.id='".$_POST['data_id']."'";
        $rs=$this->cidb->query($sql);
        $class_array=$rs->row_array();
        $class_array['other7']=rtrim(ltrim($class_array['other7'], ","),',');
        $other7=explode(',',$class_array['other7']);
        $semester_array=$this->cidb;
        foreach($other7 as $k => $v){
            $semester_array->like('other7',','.$v.',');
        }
        $semester_array=$this->cidb->where('is_enable',1)->get('writeplan_class')->result_array();
        if(!empty($semester_array)){
            $html='';
            foreach($semester_array as $k => $v){
                
                $html.='<option value="'.$v['id'].'" '.($class_array['other6']==$v['id']?'selected':'').'>'.$v['class_name'].'</option>';
            }
            $class_array['other6']=$html;
        }
        // print_r($class_array['other6']);die;
        echo json_encode($class_array);
    }else if($_POST['type']=='up_account'){
        //修改班級帳號資料
        $semesters=implode(',',$_POST['semesters']);
        $customer_up=array(
            'member_grade'=>$_POST['member_grade'],
            'name'=>$_POST['name'],
            'other7'=>$semesters,
            'other3'=>$_POST['other3'],
            'other6'=>$_POST['other6'],
            'sms_text'=>$_POST['sms_text'],
            'is_enable'=>$_POST['is_enable'],
            'create_time'   =>date('Y-m-d H:i:s'),
        );
        if(!empty($_POST['login_password']) && !empty($_POST['login_password2'])){
            if($_POST['login_password']==$_POST['login_password2']){
                $customer_up['login_password']=md5($_POST['login_password']);
            }else{
                echo "0@@密碼二次驗證失敗!";
            }
        }
        $this->cidb->where('id',$_POST['account_id']);
        if(!$this->cidb->update('customer',$customer_up)){
            echo "0@@修改失敗!";
        }else{
            $writeplan_class_data=array(
                'other7'=>','.$semesters.',',
            );
            $this->cidb->where('id',$_POST['other6']);
            $this->cidb->update('writeplan_class',$writeplan_class_data);
            echo "1@@";
        }
        die;
    }else if($_POST['type']=='slelect_class'){
        //自動抓班級資料
        $class_array=$this->cidb;
        $class_array->group_start();
        foreach($_POST['data_id'] as $k => $v){
            if($k==0){
                $class_array->like('other7',','.$v.',');
            }else{
                $class_array->or_like('other7',','.$v.',');
            }
            
        }
        $class_array->group_end();

        $class_array=$this->cidb->where('is_enable',1)->where('represent_id',$_SESSION['member_data']['id'])->get('writeplan_class')->result_array();
        if(!empty($class_array)){
            $html='';
            foreach($class_array as $k => $v){
                $html.='<option value="'.$v['id'].'" '.(((isset($_POST['class_id']) && !empty($_POST['class_id'])) && $_POST['class_id']==$v['id'])?'selected':'').'>'.$v['class_name'].'</option>';
            }
            echo "1@@".$html;
        }else{
            echo '0@@查無班級';
        }
        
        die;
    }else if($_POST['type']=='file_del'){
        $_POST['url']=str_replace('/_i/','',$_POST['url']);
            if($_POST['table']=='writeplan_file'){
                $this->cidb->where('id',$_POST['id']);
                $this->cidb->delete($_POST['table']);   
            }else{
                $this->cidb->where('id',$_POST['id']);
                $this->cidb->update($_POST['table'],array($_POST['field']=>''));   
            }
            echo '1';
            unlink(_BASEPATH.'/'.$_POST['url'].'/'.$_POST['name']);
            
        die;
    }else if($_POST['type']=='pic_del'){
        $_POST['url']=str_replace('/_i/','',$_POST['url']);
        if(file_exists(_BASEPATH.'/'.$_POST['url'].'/'.$_POST['name'])){
            $this->cidb->where('id',$_POST['id']);
            $this->cidb->update($_POST['table'],array($_POST['field']=>''));   
            unlink(_BASEPATH.'/'.$_POST['url'].'/'.$_POST['name']);
            echo '1';
        }else{
            echo '0@@刪除失敗，請重新整理';
        }
        die;    
    }else if($_POST['type']=='writeplan_del'){
        $_POST['url']=str_replace('/_i/','',$_POST['url']);
        if(file_exists(_BASEPATH.'/'.$_POST['url'].'/'.$_POST['name'])){
            $this->cidb->where('id',$_POST['id']);
            $this->cidb->update($_POST['class'],array('file3'=>''));
            unlink(_BASEPATH.'/'.$_POST['url'].'/'.$_POST['name']);
            echo '1';
        }else{
            echo '0@@刪除失敗，請重新整理';
        }
        die;
    }else if($_POST['type']=='get_file_list'){
        if(!empty($_POST['url'])){
            $url=str_replace('/_i/','',$_POST['url']);
            $url.=$_POST['writeplan_id'];
        }else{
            //檔案上傳-資料夾判斷
            $school=(!empty($_SESSION['member_data']['code'])?$_SESSION['member_data']['code']:'all_school');
            //檔案上傳-路徑
            $url='assets/file/writeplan/'.$school.'/'.$_POST['writeplan_id'];
        }
        //
        $end_data='';
        $writeplan_array=$this->cidb->select('a.*,b.date1')->from('writeplan as a')->where('a.id',$_POST['writeplan_id'])->where('a.is_enable',1)->join('html as b', 'a.semester = b.id', 'left')->get()->row_array();
        if(!empty($writeplan_array['date1'])){
            $end_data=$writeplan_array['date1'];
        }
        
        $data_list=$this->cidb->select('id,writeplan_id,member_id,file1')->where('writeplan_id',$_POST['writeplan_id']);
        if(isset($_POST['is_class']) && !empty($_POST['class_memberid'])){
            $data_list=$data_list->where('member_id',$_POST['class_memberid']);
        }
        $data_list=$data_list->order_by('create_time desc')->get('writeplan_file')->result_array();
        if(!empty($data_list)){
            $retur_txt='1@@';
            foreach($data_list as $k => $v){
                    $retur_txt.='<div class="col-12 col-md-6 col-lg-6">
                                        <div class="file-input '.(!empty($v['file1'])?' -chosen ':'').'">';
                                            if($end_data>date('Y-m-d') || $end_data=='0000-00-00'){
                                                $retur_txt.='
                                                <input name="files'.$v['id'].'" type="file"><span class="button">選擇檔案</span>
                                                <span class="label" data-js-label style="display:none">未選擇檔案</span>';
                                            }
                                            if(!empty($v['file1'])){
                                                $retur_txt.='<a class="filed-name" href="_i/'.$url.'/'.$v['file1'].'" target="_blank" style="color:red;">'.$v['file1'].'</a>';
                                                if($end_data>date('Y-m-d') || $end_data=='0000-00-00'){
                                                    $retur_txt.='<a href="javascript:;" class="delete-file" data-table="writeplan_file" data-field="file1" data-name="'.$v['file1'].'" data-id="'.$v['id'].'" onclick="dele_file(this)"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
                                                }
                                                
                                            }
                            $retur_txt.='</div>
                                </div>';
                               
            }
            if($end_data>date('Y-m-d') || $end_data=='0000-00-00'){
                $retur_txt.='@@big';
            } 
        }else{
            $retur_txt='0@@查無資料@@';
            if($end_data<=date('Y-m-d')){
                $retur_txt.='<div class="col-12 col-md-6 col-lg-6">
                                <div class="file-input">
                                    <input name="files[]" type="file">
                                    <span class="button">選擇檔案</span>
                                    <span class="label" data-js-label>未選擇檔案</span>
                                </div>
                            </div>';
            }
            if($end_data>date('Y-m-d') || $end_data=='0000-00-00'){
                $retur_txt.='@@big';
            } 

        }
        echo $retur_txt;die;
    }
}
if(isset($_REQUEST['bkmemberlogin'])){
    $row = $this->db->createCommand()->from('customer')
	->where('id=:id ', array(':id' => $_REQUEST['member_d']))
	->queryRow();
	if($row and isset($row['id'])){
        $redirect_url = 'guestlogin_'.$this->data['ml_key'].'.php';
		if($row['is_enable']=='1'){
			$_SESSION['member_data']=array(
				'id'=>$row['id'],
				'class_id'=>$row['other6'],
				'name'=>$row['name'],
				'school_name'=>$row['school_name'],
				'jobtitle'=>$row['jobtitle'],
				'code'=>$row['code'],
				'member_grade'=>$row['member_grade'],
			);
			$redirect_url = 'index_'.$this->data['ml_key'].'.php'; 
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
}
?>
