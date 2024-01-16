<?php
    $cn = new mysqli("localhost","root","","php");
    $cn->set_charset("utf8");
    $lang=1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="city_item_home1.css">   
</head>
<body>
    <div class="contanier">
            <?php
                include("file/menu.php");
            ?>
    </div>
    <div class='title'>
        <h1>Khmer Empire</h1>
        <p>Description</p>
    </div>
    <div class='new-contanier'>
        <?php
 
            include("file/item_menu.php");
        
        ?>
    </div>
</body>
</html>