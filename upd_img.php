<?php
    $file = $_FILES['txt-file'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $img_name = rand(100000, 999999).'-'.time().'.'.$ext;
    $tmp_name = $file['tmp_name'];
    move_uploaded_file($tmp_name,'img-box/'.$img_name);
    $msg['img_name']=$img_name;
    echo json_encode($msg);
?>