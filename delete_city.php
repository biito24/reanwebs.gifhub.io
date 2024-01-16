<?php
    $cn = new mysqli("localhost","root","","php");
    
    $id = $_POST['id'];
    $sql = "DELETE FROM tbl_city WHERE id = $id ";
    $cn->query($sql);
?>