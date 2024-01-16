<?php
    $cn = new mysqli('localhost','root','','php');
    $cn->set_charset("utf8");
    $edit_id = $_POST['txt-edit-id'];
    $title = $_POST['txt-item-name'];
    $des = $_POST['txt-des'];
    $img = $_POST['txt-photo'];
    $city_id = $_POST['txt-city'];
    $status = $_POST['txt-status'];
    $lang = $_POST['txt-lang'];
    if($edit_id == 0){
        $sql = "INSERT INTO tbl_city_item VALUES(null,'$title','$des','$img','$city_id','$status','$lang')";
         $cn->query($sql);
         $msg['id'] = $cn->insert_id;
         $msg['edit']=false;
    }else{
        $sql = "UPDATE tbl_city_item SET title='$title',des='$des',img='$img,city_id='$city_id', status ='$status',lang='$lang'
        WHERE id = $edit_id";
        $cn->query($sql);
        $msg['edit']=true;
    }
    
    echo json_encode($msg);
?>