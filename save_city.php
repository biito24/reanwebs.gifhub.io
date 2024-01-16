<?php
    $cn = new mysqli('localhost','root','','php');
    $cn->set_charset("utf8");
    $city_name = trim($_POST['txt-name']);
    $city_name = $cn->real_escape_string($city_name);
    $city_des = trim($_POST['txt-des']);
    $city_des = str_replace("\n","<br>",$city_des);
    $img = $_POST['txt-photo']; 
    $od = $_POST['txt-od'];
    $edit_id = $_POST['txt-edit-id'];
    $msg['edit']=false;
    if($edit_id==0){
        $sql = "INSERT INTO tbl_city VALUES(null,'$city_name','$city_des','$img',$od)";
        $cn->query($sql);
        $msg['last_id']=$cn->insert_id;
        
    }else{
        $sql = "UPDATE tbl_city SET city_name='$city_name',city_des='$city_des',img='$img',od='$od' WHERE id=$edit_id";
         $cn->query($sql);
         $msg['edit']=true;
    }
        
          
        echo json_encode($msg);
?>