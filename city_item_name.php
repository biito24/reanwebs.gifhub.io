<?php
    $cn = new mysqli('localhost','root','','php');
    $sql = "SELECT id FROM tbl_city ORDER BY id DESC";
    $id = 1;
    $rs = $cn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/test1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="style/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="frm"> 
    <form class="upl">
        <input type="text" name="txt-edit-id" id="txt-edit-id" value="0">
            <div class="body">
                <label for="">ID</label>
                <input type="text" name="txt-id" id="txt-id" class="frm-control" value='<?php echo $id?>' readonly>
                <label for="">Lang (1=english,2=khmer)</label>
                <select name="txt-lang" id="txt-lang" class="frm-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
                <label for="">City</label>
                <select name="txt-city" id="txt-city" class="frm-control">
                    <option value="0">Selete city</option>
                        <?php
                            $sql="SELECT id,city_name FROM tbl_city";
                            $rs = $cn->query($sql);
                            while($row = $rs->fetch_array()){
                                ?>
                                    <option value="<?php echo $row[0];?>"><?php echo $row[1];?></option>
                                <?php
                            }
                        ?>
                </select>
                <label for="">City Name</label>
                <input type="text" name="txt-item-name" id="txt-item-name" class="frm-control">
                <label for="">Description</label>
                <textarea name="txt-des" id="txt-des" cols="30" rows="10" class="frm-control"></textarea>
                <label for="">status(1=enable,2=disable)</label>
                <select name="txt-status" id="txt-status" class="frm-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
                <label for="">Photo</label>  
                <div class="img-box">
                    
                    <input type="file" name="txt-file" id="txt-file">
                </div>      
                <input type="hidden" name="txt-photo" id="txt-photo">       
            </div>
            <div class="footer">
                <div class="btn-save">
                     <i class="fa-solid fa-floppy-disk"></i> Save Data
                </div>
            </div>
    </form>
    </div>

    <table id='tblData'>
        <tr>
            <th>ID</th>
            <th>City</th>
            <th>Title</th>
            <th>Discription</th>
            <th>Photo</th>
            <th>Status</th>
            <th>Lang</th>
            <th>Action</th>
        </tr>
                    <?php
                        // $sql = "SELECT * FROM tbl_city_item ORDER BY id DESC";
                        $sql = "SELECT tbl_city_item.id, tbl_city.city_name,
                         tbl_city_item.title, tbl_city_item.des,
                         tbl_city_item.img, tbl_city_item.status,
                         tbl_city_item.lang, tbl_city.id
                          FROM tbl_city_item INNER JOIN tbl_city ON tbl_city_item.city_id = tbl_city.id";
                        $rs = $cn->query($sql);
                        while($row = $rs->fetch_array()){
                            ?>
                            <tr>
                                <td><?php echo $row[0];?></td>
                                <td data-id="<?php echo $row[7];?>"><?php echo $row[1];?></td>
                                <td><?php echo $row[2];?></td>
                                <td><?php echo $row[3];?></td>
                                <td>
                                     <img src="img-box/<?php echo $row[4];?>" alt="<?php echo $row[4];?>">
                                </td>
                                <td><?php echo $row[5];?></td>
                                <td><?php echo $row[6];?></td>
                                <td>
                                    <i class="fa-solid fa-pen-to-square btn-edit"></i>
                                </td>
                                </tr>
                            <?php

                        }
                    ?>
        </table>
        <div style="height:200px;">
            
        </div>
</body>
<script>
    $(document).ready(function(){
        var tbl = $('#tblData');
        var trInd;
        var lastId = $('#txt-id').val();
        $('.btn-save').click(function(){          
            var eThis = $(this);
            var Parent = eThis.parents('.frm');
            var id = Parent.find('#txt-id');
            var lang = Parent.find('#txt-lang');
            var city = Parent.find('#txt-city');
            var name = Parent.find('#txt-item-name');
            var photo = Parent.find('#txt-photo');
            var des = Parent.find('#txt-des');
            var imgBox = Parent.find('.img-box');           
            var status = Parent.find('#txt-status'); 
            var frm = eThis.closest('form.upl');
            var frm_data = new FormData(frm[0]);
            if(city.val()==0){
                alert("Please select city");
                return;
            }else if(name.val()==''){
                alert("Please input city item name.");
                name.focus();
                return;
            }else if(des.val()==''){
                alert("Please input description.");
                des.focus();
                return;
            }else if(photo.val()==''){
                alert('Please select photo');
                return;
            }
    $.ajax({
	url:'save_city_item.php',
	type:'POST',
	data:frm_data,
	contentType:false,
	cache:false,
	processData:false,
	dataType:"json",
	beforeSend:function(){
        eThis.html('<i class="fa fa-spinner fa-spin"style="font-size:14px"></i> wait...'); 
        eThis.css({"pointer-events":"none"});
	},
	success:function(data){ 
        if(data.edit == true){
            $('#tblData').find('tr:eq('+trInd+') td:eq(1)').text(city.find('option:selected').text());
            $('#tblData').find('tr:eq('+trInd+') td:eq(1)').data("id",city.val());
            $('#tblData').find('tr:eq('+trInd+') td:eq(2)').text(name.val());
            $('#tblData').find('tr:eq('+trInd+') td:eq(3)').text(des.val());
            $('#tblData').find('tr:eq('+trInd+') td:eq(4) img').attr("src",`img-box/${photo.val()}`);
            $('#tblData').find('tr:eq('+trInd+') td:eq(4) img').attr(`${photo.val()}`);
            $('#tblData').find('tr:eq('+trInd+') td:eq(5)').text(status.val());
            $('#tblData').find('tr:eq('+trInd+') td:eq(6)').text(lang.val());
            $('#txt-edit-id').val(0);
            $('#txt-id').val(lastId);
        }else{
            var tr = `
            <tr>
                <td>${data['id']}</td>
                <td data-id='${city.val()}'>${city.find('option:selected').text()}</td>
                <td>${name.val()}</td>
                <td>${des.val()}</td>
                <td><img src='img-box/${photo.val()}' alt="${photo.val()}"></td>
                <td>${status.val()}</td>
                <td>${lang.val()}</td>
                <td>
                    <i class="fa-solid fa-pen-to-square btn-edit"></i>
                </td>
            </tr>
        `;
        tbl.append(tr);
        id.val(data.id+1);
        lastId = id.val();
        
        }
        name.val('');
        des.val('');
        photo.val('');
        $('#txt-file').val('');
        imgBox.css({"background-image":"url(style/img.jpg)"});
        name.focus();
        eThis.html('<i class="fa-solid fa-floppy-disk"></i> Save Data'); 
        eThis.css({"pointer-events":"auto"});
	}				
}); 
        });
         // upd img
         $('#txt-file').change(function(){
            var loading = "<div class='loading'</div>";
            var imgBox = $('.img-box');
            var eThis = $(this);
            var frm = eThis.closest('form.upl');
            var frm_data = new FormData(frm[0]);
    $.ajax({
	url:'upd_img.php',
	type:'POST',
	data:frm_data,
	contentType:false,
	cache:false,
	processData:false,
	dataType:"json",
	beforeSend:function(){
            imgBox.append(loading);
	},
	success:function(data){   
            $('.img-box').css({"background-image":"url(img-box/"+data['img_name']+")"}); 
            $('#txt-photo').val(data['img_name']);  
            imgBox.find(".loading").remove();
	}				
    }); 
    });
    // edit data

    tbl.on('click','tr .btn-edit',function(){
            var tr = $(this).parents('tr');   
            trInd = tr.index();   
            var id = tr.find('td:eq(0)').text();
            var city_id = tr.find('td:eq(1)').data("id");
            var name = tr.find('td:eq(2)').text();
            var des = tr.find('td:eq(3)').text();
            var photo = tr.find('td:eq(4) img').attr("alt");
            var status = tr.find('td:eq(5)').text();
            var lang= tr.find('td:eq(6)').text();
            
            $('#txt-edit-id').val(id);
            $('#txt-id').val(id);
            $('#txt-city').val(city_id);
            $('#txt-item-name').val(name);
            $('#txt-des').val(des);
            $('#txt-photo').val(photo);
            $('#txt-status').val(status);
            $('#txt-lang').val(lang);
            $('.img-box').css({"background-image":"url(img-box/"+photo+")"});;
        });
    });
</script>
</html>