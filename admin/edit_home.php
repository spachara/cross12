<?php
session_start();
require_once '../dbconnect.inc';
require_once 'process_pic.php';
include_once("ckeditor/ckeditor.php");  
include_once("cke_config.php");  


if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) {
		echo "<script>window.location.href='index.php'</script>";
}

$IMG_ROOT="../banner/";

if($_GET['delfile'] != '' ){
	$edit_banner = "UPDATE txt_tb SET txt_pic='' where txt_id='".$_GET['tid']."'";
	@mysql_query($edit_banner, $connect);
	@unlink($_GET['delfile']);
	?><script>window.location.href='add_banner.php?bid=<?php echo $_GET['bid'];?>&sAction=Edit';</script><?php
}

if($_POST['Submit'] == 'UPDATE'){

	$add_banner = "UPDATE txt_tb SET txt_url = '".$_POST['url']."', type_id = '".$_POST['type_id']."'";
	$realname = $_FILES['uploadedfile1']['name'];  
	
	if ($realname != ""){
	
	$target_path = $IMG_ROOT;
	
	$target_path = $target_path . basename( $_FILES['uploadedfile1']['name']); 
										
	if(move_uploaded_file($_FILES['uploadedfile1']['tmp_name'], $target_path)) {
		//echo "The file ".  basename( $_FILES['uploadedfile']['name']). " has been uploaded";
	} else{
		//echo "There was an error uploading the file, please try again!";
	}
		
	
	$type= $_FILES['uploadedfile1']['type'];  
	
	if($type=="image/pjpeg"){
		$dot = "jpg";
	}elseif($type=="image/jpeg"){
		$dot = "jpg";
	}elseif($type=="image/gif"){
		$dot = "gif";
	}elseif($type== "image/x-png"){
		$dot = "png";
	}elseif($type== "image/png"){
		$dot = "png";
	}
	sleep(1);
	
	@unlink($IMG_ROOT.$_POST['pic_hidden']);
	
	$name = date('Y').date('m').date('d')."-".date('H').date('i').date('s');
	
	//$IMG_ROOT="../images/gallery_/where_to_go/";
	
	$oldname = $IMG_ROOT."/".$_FILES['uploadedfile1']['name'];
	$newname =$IMG_ROOT."/".$name.".".$dot;
	//echo $oldname."<br>".$newname;
	rename($oldname,$newname); 
	
	$pic_name = $name.".".$dot;
	
	$add_banner .= ", txt_pic = '".$pic_name."'";
	}
	$add_banner .= " where type_name = '".$_POST['type_name']."'";
	@mysql_query($add_banner, $connect);
	//echo $add_banner;


?><script>window.location.href='home_banner.php?txt_tb=<?php echo $_POST['type_name'];?>';</script>
<?php } 


$sql_txt = "SELECT * FROM txt_tb WHERE type_name = '".$_GET['type_name']."' ";
$result_txt =@mysql_query($sql_txt, $connect);
$data_txt =@mysql_fetch_array($result_txt);


if($_GET['type_name'] == 'Promotion'){
	$menu_name = "Promotion banner";
}elseif($_GET['type_name'] == 'Arrivals'){
	$menu_name = "Arrivals banner";
}elseif($_GET['type_name'] == 'Discount'){
	$menu_name = "Discount banner";
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
<title>::Crosstwelfth::</title>
	<link rel="stylesheet" href="jquery_ui/development-bundle/themes/base/jquery.ui.all.css">
	<script src="jquery_ui/development-bundle/jquery-1.7.2.js"></script>
	<script src="jquery_ui/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="jquery_ui/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="jquery_ui/development-bundle/ui/jquery.ui.button.js"></script>
	<script src="jquery_ui/development-bundle/ui/jquery.ui.tabs.js"></script>
	<link rel="stylesheet" href="jquery_ui/development-bundle/demos/demos.css">
	<script>
	$(function() {
		$( "input:submit, a, button", ".demo" ).button();
		$( "a", ".demo" ).click(function() { return false; });
	});
	$(function() {
		$( "#tabs" ).tabs();
		
	});


	</script>

<link href="cssstyle.css" rel="stylesheet" type="text/css" />


<script language="javascript">
$(document).ready(function() {
	
	if ($('#type_name').val()=='category') {
		$('#uploadedfile1').after('( 340 x 120 pixels )');
	}

	
	$('#uploadedfile2').after('( PDF, Word, Excel )');
    
	
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    
	$('#district').change(function() {
        var district_value = $(this).val();
		$.ajax({
			type:'POST',
			url:"ajax_district.php",
			data: "district_id="+ district_value,
			success:function(data){
				$('#district_sub').html(data);				
			}
		});
    });
	
});
</script>
</head>

<body> 
	<div class="page_container">
    <div class="shadow_l"></div>
	<div class="shadow_r"></div>  
    	<!--Header--> 
    	<?php include('header.php');?>
        <!--Header-->
        <div class="container_content">
            <!--Main Menu-->
            <?php include('mainmenu.php');?>
            <!--End Main Menu-->
            <div class="content_r">
           
                                	<!--Edit Navigator-->
                                   <div class="navigator">
                                   <a href="new_about.php?txt_tb=<?php echo $_GET['type_name'];?>">
								   <?php echo $menu_name;?></a> > <a href="#">Edit <?php echo $menu_name;?></a> 
 
                                   
                                   
                                   </div>
                                   <!--End Navigator-->
                            <!--Block Frame-->
                            <div class="block_style2">
                                <div class="block_style2_top">
                                    <div class="block_style2_top-l"></div>
                                    <div class="block_style2_top-r"></div>
                                    <div class="block_style2_top-t">
                                    <?php echo $menu_name;?>
                                    </div>
                                </div>
                                <div class="block_style2_content">
                                   
                              <form method="post" enctype="multipart/form-data" name="myform">
                                   <input type="hidden" name="txt_id" value="<?php echo $_GET['txt_id'];?>" />
                                   <input type="hidden" name="txt_name_eng" value="<?php echo $_GET['cat'];?>" />
	                               <div class="page_conten_r">
                                   
                                   
                                    <div class="module_3" >
                                   	<div class="table_3cell-no_border">
                                     	<ul>
                                        	
                                         <li>
                                            <div class="cell3-text">Show : </div>
                                            <div class="cell3-input">
                                            <input type="checkbox" name="type_id" value="1" <?php echo ($data_txt['type_id'] == '1' ? "checked=checked" : "");?> />
                                            </div>
                                        </li>
                                         <li>
                                            <div class="cell3-text">URL : </div>
                                            <div class="cell3-input"><input name="url" type="text" id="url" value="<?php echo $data_txt['url'];?>" /></div>
                                        </li>
                                        <li>
                                          <div class="cell3-text">Picture Banner : </div>                                
                                          <div class="cell3-input"><input name="uploadedfile1" type="file" id="uploadedfile1" ></div>
                                        </li>
                                        <?php if($data_txt['txt_pic']){?>
                                         <li>
                                          <div class="cell3-text">Picture Banner : </div>                                
                                          <div class="cell3-slidehome">
                                          <img src="<?php echo $IMG_ROOT.$data_txt['txt_pic'];?>" width="160"/>
                                          <br />
                                          <a href="edit_home.php?tid=<?php echo $data_txt['txt_id'];?>&delfile=<?php echo $IMG_ROOT.$data_txt['txt_pic'];?>" onClick="return confirm('Do you want to delete it. (yes/no)')">[ DELETE PICTURE ]</a>
                                          </div>
                                        </li>
                                        <?php } ?>
                                                                                        
                                       </ul>
                                    </div>
                                   <!--End ตาราง 3 Cell-->
                                     </div>                                   
                                </div>
                                   <!--BUTTON-->         
                                    <div class="demo" style=" margin-top:20px; position:relative;">
                                    
                                    <!--<button>Submit</button>-->
                                   	<input name="type_name" type="hidden" value="<?php echo $data_txt['type_name'];?>" id="type_name" />
                                   	
									<input name="Submit" type="submit" style="width:80px" value="UPDATE">
                                    
                                    
                                    </div> 
                                    <!--END BUTTON-->
                                		<div class="bottom">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                       </div>
                                   <!--End Coppy Module Clear-->                                 
                                        
                                                                                                                                               
                                </form>

                    </div>
                    <div class="block_style2_bottom">
                        <div class="block_style2_bottom-l"></div>
                        <div class="block_style2_bottom-r"></div>
                    </div>                    
                </div>
                <!-- End Block Frame-->
                

                
            </div>
            <div class="clear"></div>                        
		</div>            
            





        </div>
    </div>
		<?php include('footer.php');?>
</div>    
</body>
</html>
