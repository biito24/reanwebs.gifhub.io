<?php
    $cn = new mysqli('localhost','root','','php');
    $sql = "SELECT id FROM tbl_city ORDER BY id DESC";
    $id = 1;
    $rs = $cn->query($sql);
    $num = $rs->num_rows;
    if( $num > 0 ){
        $row = $rs->fetch_array();
        $id = $row[0]+1;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
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
                <input type="text" name="txt-id" id="txt-id" class="frm-control" value="<?php echo $id; ?>" readonly>
                <label for="">City Name</label>
                <input type="text" name="txt-name" id="txt-name" class="frm-control">
                <label for="">Description</label>
                <textarea name="txt-des" id="txt-des" cols="30" rows="10" class="frm-control"></textarea>
                <label for="">OD</label>
                <input type="text" name="txt-od" id="txt-od" class="frm-control" value="<?php echo $id; ?>"> 
                <label for="">status(1=enable,2=disable)</label>
                <select name="txt-selete" id="txt-selete" class="frm-control">
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
    <table id="tblData">
        <tr class='trHead'>
            <th width="100">ID</th>
            <th width="200">City Name</th>
            <th>Description</th>
            <th width="100">Photo</th>
            <th width="100">OD</th>
            <th width="100">Action</th>
        </tr>
        <?php
            $sql = "SELECT * FROM tbl_city ORDER BY id DESC";
            $rs = $cn->query($sql);
            while($row = $rs->fetch_array()){
               ?>
                    <tr>
                        <td><?php echo $row[0];?></td>
                        <td><?php echo $row[1];?></td>
                        <td><?php echo $row[2];?></td>
                        <td>
                            <img src="img-box/<?php echo $row[3];?>" alt="<?php echo $row[3];?>">
                        </td>
                        <td><?php echo $row[4];?></td>
                        <td>
                            <input type="button" value="Edit" class='btn-edit'>
                            <input type="button" value="Delete" class='btn-delete'>
                        </td>                        
                    </tr>
               <?php 
            }
        ?>
    </table>
</body>
<script>
    $(document).ready(function(){
        var trInd = 0;
        var body = $('body');
            var popup = "<div class='popup'></div>";
            var msgBox = `<div class='popup'>
                         <div class='msg-box'>
                         <h1>Do you want to delete this record ?</h1>
                        <input type="button" value="Yes" id='btn-yes'>
                         <input type="button" value="No" id='btn-no'>
                     </div>
                    </div>`;
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
    // save data
        $('.btn-save').click(function(){
            var eThis = $(this);
            var Parent = eThis.parents('.frm');
            var id = Parent.find('#txt-id');
            var name = Parent.find('#txt-name');
            var des = Parent.find('#txt-des');
            var od = Parent.find('#txt-od');
            var photo = Parent.find('#txt-photo');
            var imgBox = Parent.find('.img-box');
            var file = Parent.find('#txt-file');
            if(name.val()==''){
            alert('Please input name.');
            name.focus();
            return;
        }else if(des.val()==''){
            alert('Please input description.');
            des.focus();
            return;
        }
            var frm = eThis.closest('form.upl');
            var frm_data = new FormData(frm[0]);
$.ajax({
	url:'save_city.php',
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
        if(data['edit']==true){
            $('#tblData').find('tr:eq('+trInd+') td:eq(1)').text(name.val());
            $('#tblData').find('tr:eq('+trInd+') td:eq(2)').text(des.val());
            $('#tblData').find('tr:eq('+trInd+') td:eq(3) img').attr("src",`img-box/${photo.val()}`);
            $('#tblData').find('tr:eq('+trInd+') td:eq(3) img').attr(`${photo.val()}`);
            $('#tblData').find('tr:eq('+trInd+') td:eq(4)').text(od.val());
        }else{
            var tr = `
            <tr>
                <td>${data['last_id']}</td>
                <td>${name.val()}</td>
                <td>${des.val()}</td>
                <td><img src='img-box/${photo.val()}' alt="${photo.val()}"></td>
                <td>${od.val()}</td>
                <td>
                    <input type="button" value="Edit" class='btn-edit'>
                    <input type="button" value="Delete" class='btn-edit'>
                </td>
            </tr>
        `;
        $('#tblData').find('.trHead').after(tr);
            id.val(data['last_id']+1);
            od.val(data['last_id']+1);
            name.val('');
            des.val('');
            name.focus();
            photo.val('');
            file.val('');
            imgBox.css({"background-image":"url(style/img.jpg)"});
        }
        
        eThis.html('<i class="fa-solid fa-floppy-disk"></i> Save Data'); 
        eThis.css({"pointer-events":"auto"});
	}				
    }); 
        });
        // edit data

        $('#tblData').on('click','.btn-edit',function(){
            var tr = $(this).parents('tr');    
            trInd = tr.index();   
            var id = tr.find('td:eq(0)').text();
            var name = tr.find('td:eq(1)').text();
            var des = tr.find('td:eq(2)').text();
            var img = tr.find('td:eq(3) img').attr("alt");
            var od = tr.find('td:eq(4)').text();
            $('#txt-edit-id').val(id);
            $('#txt-id').val(id);
            $('#txt-name').val(name);
            $('#txt-des').val(des);
            $('#txt-od').val(od);
            $('.img-box').css({"background-image":"url(img-box/"+img+")"});;
        });
        // delete data
        var delId;
        $('#tblData').on('click','.btn-delete',function(){
            var tr = $(this).parents('tr');  
            trInd = tr.index();   
            delId = tr.find('td:eq(0)').text();
                body.append(popup);
                body.find('.popup').append(msgBox);
        });
        // cancel delete
        body.on('click','.popup #btn-no',function(){
            $('.popup').remove();
        });
        // delete
        body.on('click','.popup #btn-yes',function(){
            
            $.ajax({
	        url:'delete_city.php',
            type:'POST',
	        data:{id:delId},
	        // contentType:false,
	        cache:false,
            // processData:false,
	        // dataType:"json",
	        beforeSend:function(){
                
	        },
	        success:function(data){   
            $('#tblData').find("tr").eq(trInd).remove();
            $('.popup').remove();
	        }				
        }); 
        });
    });
</script>
</html>