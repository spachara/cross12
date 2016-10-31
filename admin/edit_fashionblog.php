<?php
session_start();
require_once '../dbconnect.inc';
require_once 'process_pic.php';
include_once("ckeditor/ckeditor.php");  
include_once("cke_config.php");  


if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) {
		echo "<script>location.href='index.php'</script>";
}

if($_POST['Submit'] == 'UPDATE'){
	
	$edit_fashionblog = "UPDATE fashionblog_tb SET fashionblog_name_th = '".$_POST['fashionblog_name_th']."', fashionblog_name_eng = '".$_POST['fashionblog_name_eng']."' ";
	$edit_fashionblog .= " , fashionblog_title_th = '".$_POST['fashionblog_title_th']."', fashionblog_title_eng = '".$_POST['fashionblog_title_eng']."' ";
	$edit_fashionblog .= " , fashionblog_detail_th = '".$_POST['fashionblog_detail_th']."', fashionblog_detail_eng = '".$_POST['fashionblog_detail_eng']."' ";
	
	$IMG_ROOT="../images/fashionblog/";
	$width_banner = "250";
	$height_banner = "250";

	$messages_not_uppic = $width_banner." x ".$height_banner." pixels";
	
	$realname1 = $_FILES['uploadedfile1']['name'];  
	
	$size1 = @getimagesize($_FILES['uploadedfile1']['tmp_name']);  // $file คือ ไฟล์ที่เราต้องการดูขนาด
	/*echo "กว้าง : ".$size[0]."<br>";
	echo "สูง : ".$size[1]."<br>";*/
	
	/*echo "ประเภท : ".$size[2]."<br>";
	echo "สูง : ".$size[3]."<br>";*/
	if ($realname1 != "" && $size1[0] <= $width_banner && $size1[1] <= $height_banner){
		
		@unlink($IMG_ROOT.$_POST['fashionblog_pic']);
		
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
		$name_pic1 = $name."-fashionblog.".$dot;
		
		$oldname = $IMG_ROOT."/".$_FILES['uploadedfile1']['name'];
		$newname =$IMG_ROOT."/".$name_pic1;
		//echo $oldname."<br>".$newname;
		rename($oldname,$newname); 

		$edit_fashionblog .= " , fashionblog_pic = '".$name_pic1."' ";
		
	}
	if($size1[0] > $width_banner){
		?>
		<script>
			alert('<?php echo $messages_not_uppic;?>');
			location.reload(true);
		</script>
		<?php
	}
	if($size1[1] > $height_banner){
		?>
		<script>
			alert('<?php echo $messages_not_uppic;?>');
			location.reload(true);
		</script>
		<?php
	}
	
	$edit_fashionblog .= " , fashionblog_vdo = '".$_POST['fashionblog_vdo']."', date_update = NOW() WHERE fashionblog_id = '".$_POST['fashionblog_id']."' ";
	@mysql_query($edit_fashionblog, $connect);
	//echo $edit_fashionblog;
	
	?><script>location.href='new_fashionblog.php';</script><?php
}

$sql_fashionblog = "SELECT * FROM fashionblog_tb WHERE fashionblog_id = '".$_GET['fashionblog_id']."' ";
$result_fashionblog =@mysql_query($sql_fashionblog, $connect);
$data_fashionblog =@mysql_fetch_array($result_fashionblog);
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
	<script type="text/javascript" src="cke_func.js"></script> 

	<link rel="stylesheet" href="jquery_ui/development-bundle/demos/demos.css">
	<script>
	$(function() {
		$( "input:submit, a, button", ".demo" ).button();
		$( "a", ".demo" ).click(function() { return false; });
	});
	
	$(function() {
		
		$( "#tabs" ).tabs();	
		$( "#tabs" ).bind('tabsselect', function(event, ui){
			if(ui.index == 0){
				$('#Youtube').text('วีดีโอ : ');
				$('#picture').text('รูปภาพ : ');
				$('#document').text('ไฟล์แนบ : ');
			}else if(ui.index == 1){
				$('#Youtube').text('VDO : ');
				$('#picture').text('Picture : ');
				$('#document').text('File : ');
			}
			
		});	
		
	});
	</script>

<link href="cssstyle.css" rel="stylesheet" type="text/css" />


<script language="javascript">
$(document).ready(function() {
	
	$('#uploadedfile1').after('( 250 x 250 pixels )');
	
	$('#uploadedfile2').after('( PDF, Word, Excel )');
    
	
});
</script>

</head>

<body> 
	<div class="page_container">
    <div class="shadow_l"></div>
	<div class="shadow_r"></div>  
    	<!--Header--> 
    	<div class="header">
        	<img alt="The tree txtSlide4 Co., Ltd." src="images/logo.png"  title="The tree txtSlide4 Co., Ltd." class="block_logo"/>
        </div>
        <!--Header-->
        <div class="container_content">
            <!--Main Menu-->
            <?php include('mainmenu.php');?>
            <!--End Main Menu-->
            <div class="content_r">
           
                                	<!--Edit Navigator-->
                                   <div class="navigator">
										<a href="new_fashionblog.php">Fashion blog</a> > <a href="#">Edit Fashion blog</a>
                                   </div>
                                   <!--End Navigator-->
                            <!--Block Frame-->
                            <div class="block_style2">
                                <div class="block_style2_top">
                                    <div class="block_style2_top-l"></div>
                                    <div class="block_style2_top-r"></div>
                                    <div class="block_style2_top-t">
                                    <?php  echo "Edit Fashion blog";?>
                                    </div>
                                </div>
                                <div class="block_style2_content">
                                   
                                   <form method="post" enctype="multipart/form-data" name="myform">
	                               <div class="page_conten_r">
                                   
                                <!--Coppy Module Clear-->
                                <div class="module_3">
                                   	<div class="table_3cell-no_border">
                                     	<ul>
                                        	
											<div id="tabs" style="padding-bottom:20px; overflow:hidden;">
                                            <ul>
                                                <li><a href="#th" id="type_th">THAI</a></li>
                                                <li><a href="#eng" id="type_eng">ENGLISH</a></li>
                                            </ul>
                                            <div id="th" class="content" style="border:none;">
                                            
                                                <div style="margin-bottom:25px;"></div>  
                                                
                                                <div class="cell3-text">ชื่อ : </div>
                                                <div class="cell3-input"><input name="fashionblog_name_th" type="text" value="<?php echo $data_fashionblog['fashionblog_name_th'];?>" /></div>
                                                <div class="clear"></div>

                                                <div class="cell3-text">บทนำ : </div>
                                                <div class="cell3-input_textarea"><textarea name="fashionblog_title_th" cols="30" rows="5"><?php echo $data_fashionblog['fashionblog_title_th'];?></textarea></div>
                                                <div class="clear"></div>
                                                
                                              <div style="margin-top:10px;">
                                                    <div class="cell3-text">รายละเอียด : </div>
                                                    <div class="clear"></div>
                                                      <div class="cell3-input_textarea2" style="margin-left:85px;"> 
                                                          <?php
                                                          $CKEditor = new CKEditor(); $config['toolbar'] = 'Full';
                                                          // คืนค่าสำหรับใช้งานร่วมกับ javascript
                                                          $events['instanceReady'] = 'function (evt) { 
                                                                  return editorObj=evt.editor;
                                                          }';	
                                                          // บรรทัดด้านล่าง เปรียบได้กับการสร้าง textarea ชื่อ editor1 
                                                          // ตัวแปรรับค่า เป็น $_POST['editor1'] หรือ $_GET['editor1'] ตามแต่กรณี
                                                          $CKEditor->editor("fashionblog_detail_th", $data_fashionblog['fashionblog_detail_th'],$config,$events);
                                                          ?>
                                                      </div>
												</div>
                                              </div>  
                                              
                                            <div id="eng" class="content" style="border:none;">
                                            
                                                <div style="margin-bottom:25px;"></div>
                                                
                                                <div class="cell3-text">Name : </div>
                                                <div class="cell3-input"><input name="fashionblog_name_eng" type="text" value="<?php echo $data_fashionblog['fashionblog_name_eng'];?>" /></div>
                                                <div class="clear"></div>

                                                <div class="cell3-text">Title : </div>
                                                <div class="cell3-input_textarea"><textarea name="fashionblog_title_eng" cols="30" rows="5" ><?php echo $data_fashionblog['fashionblog_title_eng'];?></textarea></div>
                                                <div class="clear"></div>
                                                <div style="margin-top:10px;">
                                                	<div class="cell3-text">Detail : </div>
                                                    <div class="clear"></div>
                                                    <div class="cell3-input_textarea2" style="margin-left:85px;"> 
														<?php
															$CKEditor = new CKEditor(); $config['toolbar'] = 'Full';
															// คืนค่าสำหรับใช้งานร่วมกับ javascript
															$events['instanceReady'] = 'function (evt) { 
																	return editorObj=evt.editor;
															}';	
															// บรรทัดด้านล่าง เปรียบได้กับการสร้าง textarea ชื่อ editor1 
															// ตัวแปรรับค่า เป็น $_POST['editor1'] หรือ $_GET['editor1'] ตามแต่กรณี
															$CKEditor->editor("fashionblog_detail_eng", $data_fashionblog['fashionblog_detail_eng'],$config,$events);
														?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="cell3-edit_banner" style="margin-top:5px; margin-left:175px; margin-bottom:20px;">
                                                <img src="../images/fashionblog/<?php echo $data_fashionblog['fashionblog_pic'];?>" title="slide" width="150"/>
                                            </div>
 
                                            <div class="height_space"></div>
                                            <div class="cell3-text" id="picture">รูป : </div>
                                            <div class="cell3-input"><input name="uploadedfile1" type="file" id="uploadedfile1" /></div>
                                            <div class="clear"></div>

                                            <div class="height_space"></div>
                                            <div class="cell3-text" id="Youtube">วีดีโอ : </div>
                                            <div class="cell3-input_textarea"><textarea name="fashionblog_vdo" cols="30" rows="5"><?php echo $data_fashionblog['fashionblog_vdo'];?></textarea></div>
                                            <div class="clear"></div>
                                       
                                       </div>
                                       
                                                                                        
                                       </ul>
                                       
                                    </div>
                                   <!--End ตาราง 3 Cell-->
                                            </div>
                                   <!--BUTTON-->         
                                   <div class="demo">
                                    
                                    <!--<button>Submit</button>-->
                                    <input name="fashionblog_id" type="hidden" value="<?php echo $_GET['fashionblog_id'];?>" />
                                    <input name="fashionblog_pic" type="hidden" value="<?php echo $data_fashionblog['fashionblog_pic'];?>" />
									<input name="Submit" type="submit" style="width:80px" value="UPDATE">
                                    
                                    </div> 
                                    <!--END BUTTON-->
                                            <div class="bottom">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                            </div>
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
