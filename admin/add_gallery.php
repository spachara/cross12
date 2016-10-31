<?php
session_start();
require_once '../dbconnect.inc';
include_once("ckeditor/ckeditor.php");  
include_once("cke_config.php");  
if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) { 
	echo "<script>location.href='index.php'</script>";
}

if($_POST['Submit'] == 'CREATE'){
	
	if ($_POST['gallery_type'] == "fashionblog") {
		$IMG_ROOT="../images/gallery/fashionblog/";	
		$width_banner = "200";
		$height_banner = "200";
	}
		
	$messages_not_uppic = $width_banner." x ".$height_banner." pixels";
	
	$realname1 = $_FILES['uploadedfile1']['name'];  
	
	$size1 = @getimagesize($_FILES['uploadedfile1']['tmp_name']);  // $file คือ ไฟล์ที่เราต้องการดูขนาด
	/*echo "กว้าง : ".$size[0]."<br>";
	echo "สูง : ".$size[1]."<br>";*/
	
	/*echo "ประเภท : ".$size[2]."<br>";
	echo "สูง : ".$size[3]."<br>";*/
	if ($realname1 != "" && $size1[0] <= $width_banner && $size1[1] <= $height_banner){
		
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
		$name = date('d').date('m').date('Y')."-".date('H').date('i').date('s');
		
		//$IMG_ROOT="../images/gallery_/where_to_go/";
		$name_pic1 = $name."-gallery_small.".$dot;
		
		$oldname = $IMG_ROOT."/".$_FILES['uploadedfile1']['name'];
		$newname =$IMG_ROOT."/".$name_pic1;
		//echo $oldname."<br>".$newname;
		rename($oldname,$newname); 

	}
	if($size1[0] > $width_banner){
		?>
		<script>
			alert('<?php echo $messages_not_uppic;?>');
			location.href='add_gallery.php?gallery_type_id=<?php echo $_POST['gallery_type_id'];?>&gallery_type=<?php echo $_POST['gallery_type'];?>';
		</script>
		<?php
	}
	if($size1[1] > $height_banner){
		?>
		<script>
			alert('<?php echo $messages_not_uppic;?>');
			location.href='add_gallery.php?gallery_type_id=<?php echo $_POST['gallery_type_id'];?>&gallery_type=<?php echo $_POST['gallery_type'];?>';
		</script>
		<?php
	}

	$width_banner2 = "750";
	$height_banner2 = "750";
	
	$messages_not_uppic2 = $width_banner2." x ".$height_banner2." pixels";
	
	$realname2 = $_FILES['uploadedfile2']['name'];  
	
	$size2 = @getimagesize($_FILES['uploadedfile2']['tmp_name']);  // $file คือ ไฟล์ที่เราต้องการดูขนาด
	/*echo "กว้าง : ".$size[0]."<br>";
	echo "สูง : ".$size[1]."<br>";*/
	
	/*echo "ประเภท : ".$size[2]."<br>";
	echo "สูง : ".$size[3]."<br>";*/
	if ($realname2 != "" && $size2[0] <= $width_banner2 && $size2[1] <= $height_banner2){
		
		$target_path2 = $IMG_ROOT;
		
		$target_path2 = $target_path2 . basename( $_FILES['uploadedfile2']['name']); 
											
		if(move_uploaded_file($_FILES['uploadedfile2']['tmp_name'], $target_path2)) {
			//echo "The file ".  basename( $_FILES['uploadedfile']['name']). " has been uploaded";
		} else{
			//echo "There was an error uploading the file, please try again!";
		}
		
		$type2= $_FILES['uploadedfile2']['type'];  
		
		if($type2=="image/pjpeg"){
			$dot2 = "jpg";
		}elseif($type2=="image/jpeg"){
			$dot2 = "jpg";
		}elseif($type2=="image/gif"){
			$dot2 = "gif";
		}elseif($type2== "image/x-png"){
			$dot2 = "png";
		}elseif($type2== "image/png"){
			$dot2 = "png";
		}
		sleep(1);
		$name2 = date('d').date('m').date('Y')."-".date('H').date('i').date('s');
		
		//$IMG_ROOT="../images/gallery_/where_to_go/";
		$name_pic2 = $name2."-gallery_big.".$dot2;
		
		$oldname2 = $IMG_ROOT."/".$_FILES['uploadedfile2']['name'];
		$newname2 =$IMG_ROOT."/".$name_pic2;
		//echo $oldname."<br>".$newname;
		rename($oldname2,$newname2); 

	}
	if($size2[0] > $width_banner2){
		?>
		<script>
			alert('<?php echo $messages_not_uppic2;?>');
			location.href='add_gallery.php?gallery_type_id=<?php echo $_POST['gallery_type_id'];?>&gallery_type=<?php echo $_POST['gallery_type'];?>';
		</script>
		<?php
	}
	if($size2[1] > $height_banner2){
		?>
<script>
			alert('<?php echo $messages_not_uppic2;?>');
			location.href='add_gallery.php?gallery_type_id=<?php echo $_POST['gallery_type_id'];?>&gallery_type=<?php echo $_POST['gallery_type'];?>';
		</script>
		<?php
	}
	
	if ($_POST['gallery_type_id'] != "") {
		$gallery_type_id = $_POST['gallery_type_id'];
	} else if ($_POST['gallery_type_id'] == "") {
		$gallery_type_id = '1';
	}
	
	$add_gallery = "INSERT INTO gallery_tb (gallery_id, gallery_type, gallery_type_id, gallery_pic1, gallery_pic2, date_in)";
	$add_gallery .= "VALUES(NULL, '".$_POST['gallery_type']."', '".$gallery_type_id."', '".$name_pic1."', '".$name_pic2."', NOW())";
	@mysql_query($add_gallery, $connect);
	//echo $add_gallery;
	
	?><script>location.href='new_gallery.php?gallery_type_id=<?php echo $_POST['gallery_type_id'];?>&gallery_type=<?php echo $_POST['gallery_type'];?>';</script><?php

}// END CREATE

if ($_GET['gallery_type']=='fashionblog') {
	$type_name = "fashionblog"; //พาทที่อยู่รูป
	$nav_name = "Fashion blog";
	$nav_url = "new_fashionblog.php";
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
	<script src="jquery_ui/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<link rel="stylesheet" href="jquery_ui/development-bundle/demos/demos.css">
	<script>
	$(function() {
		$( "input:submit, a, button", ".demo" ).button();
		$( "a", ".demo" ).click(function() { return false; });
	});
	$(function() {
		$( "#datepicker" ).datepicker({
		  changeMonth: true,
		  changeYear: true
		});
	  });
	</script>

<link href="cssstyle.css" rel="stylesheet" type="text/css" />
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
                                   		<a href="<?php echo $nav_url;?>"><?php echo $nav_name;?></a> > 
                                        <a href="new_gallery.php?gallery_type_id=<?php echo $_GET['gallery_type_id'];?>&gallery_type=<?php echo $_GET['gallery_type'];?>">Gallery <?php echo $nav_name;?></a> > <a href="#">Add Gallery <?php echo $nav_name;?></a>
                                   </div>
                                   <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">Add Gallery <?php echo $nav_name;?></div>
                    </div>
                    <div class="block_style2_content">

                     <!--Coppy Module Clear-->
                                   
                     <form method="post" enctype="multipart/form-data" name="myform">
				<div class="page_conten_r">
                                   
                     <!--Coppy Module Clear-->
                      <div class="module_3">
                       		<div class="title">
                                <div class="l"></div>
                                <div class="r"></div>
                                <div class="t"><h2><!--เพิ่มรูปสไลด์--></h2> </div>                  
                      		</div>
                      <div class="conten">
                      <!--ใสข้อมูล ตรงนี้-->
                      <!--ตาราง 3 Cell-->
                      <div class="title-top">&nbsp;
                          <div class="right-title">&nbsp;</div>
                      </div>
                                   
                      <div class="table_3cell">
                        <ul>
                          <!--Title-->
                            

                          <li>
                            	<div class="cell3-text">Picture Small :</div>                                                                
                                <div class="cell3-input"><input name="uploadedfile1" type="file" id="uploadedfile1" > ( 200 x 200 pixels )</div>
                            </li>
                            <li>
                            	<div class="cell3-text">Picture Big :</div>                                                                
                                <div class="cell3-input"><input name="uploadedfile2" type="file" id="uploadedfile2" > ( maximum 750 x 750 pixels )</div>
                            </li>

                          <!--End Title-->
                        
                        </ul>
                       </div>
                       <!--End ตาราง 3 Cell-->
                       </div>
                                           
                  </div>
					   <!--End Coppy Module Clear-->                                 
                                        
				</div>    
                                   
                <div class="demo">
                                                    
                <!--<button>Submit</button>-->
                <input name="gallery_type" type="hidden" value="<?php echo $_GET['gallery_type'];?>" />
                <input name="gallery_type_id" type="hidden" value="<?php echo $_GET['gallery_type_id'];?>" />
                <input name="Submit" type="submit" class="borderfrom" style="width:80px" value="CREATE">
                                                    
                </div>                                   
                	
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
            


		<?php include('footer.php');?>



        </div>
    </div>
</div>    
</body>
</html>
