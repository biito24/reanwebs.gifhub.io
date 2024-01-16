<?php
      $cn = new mysqli("localhost","root","","php");
      $cn->set_charset("utf8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="style/test1.css">
    <link rel="stylesheet" href="style/bootstrap.min.css">
</head>
<body>
    <div class='contanier-fluid bar1'>
        <div class='contanier'>
            <div class='row'>
                <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 menu'>
                    <ul>
                            <?php
                                $sql="SELECT city_name FROM tbl_city";
                                 $rs = $cn->query($sql);
                                while($row = $rs->fetch_array()){
                                    ?>
                                        <li>
                                            <a href=""><?php echo $row[0];?></a>
                                        </li> 
                                    <?php
                                }
                            ?>
                                              
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>