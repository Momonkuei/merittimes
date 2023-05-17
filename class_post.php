<?php
header("Content-Type:text/html; charset=utf-8");
include 'layoutv3/init.php';

if(!empty($_POST)){
    if($_POST['type']=='del_billboard'){
        $this->cidb->where('id',$_POST['data_id']);
        $this->cidb->delete('class_billboard');
    }else if($_POST['type']=='del_pic'){
        $this->cidb->where('id',$_POST['data_id']);
        $this->cidb->delete('class_pic');
    }else if($_POST['type']=='del_vido'){
        $this->cidb->where('id',$_POST['data_id']);
        $this->cidb->delete('class_vido');
    }else if($_POST['type']=='switch_is_enable'){
        $data_array=$this->cidb->where('id',$_POST['data_id'])->get($_POST['table'])->row_array();
        if(!empty($data_array)){
            $is_show=($data_array['is_enable']==1?'0':'1');
        }else{
            echo '0@@查無該筆資料!';
            die;
        }
        $this->cidb->where('id',$_POST['data_id']);
        $this->cidb->update($_POST['table'],array('is_enable'=>$is_show));
        echo '1@@';
        die;
    }
}
?>
