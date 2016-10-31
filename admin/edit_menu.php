<?php
session_start();
require_once '../dbconnect.inc';
require_once 'process_pic.php';
include_once("ckeditor/ckeditor.php");  
include_once("cke_config.php");  


if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) {
		echo "<script>window.location.href='index.php'</script>";
}


if($_POST['Submit'] == 'UPDATE'){

	$edit_txt = "UPDATE txt_tb SET txt_detail_th = '".$_POST['txt_detail_th']."', txt_detail_eng = '".$_POST['txt_detail_eng']."'";
	$edit_txt .= " WHERE type_name = '".$_GET['type_name']."' ";
	@mysql_query($edit_txt, $connect);
	
	?>
    	<script>window.location.href='edit_menu.php?type_name=<?php echo $_GET['type_name'];?>';</script>                       
	<?php
}

$sql_txt = "SELECT * FROM txt_tb WHERE type_name = '".$_GET['type_name']."' ";
$result_txt =@mysql_query($sql_txt, $connect);
$data_txt =@mysql_fetch_array($result_txt);

if($_GET['type_name'] == 'deliveryproduct' ){
	$menu_name = "Delivery";	
}elseif($_GET['type_name'] == 'return' ){
	$menu_name = "Return & Exchanges";	
}elseif($_GET['type_name'] == 'Howto'){
	$menu_name = "How to order";
}elseif($_GET['type_name'] == 'Payment'){
	$menu_name = "Payment";
}elseif($_GET['type_name'] == 'Delivery'){
	$menu_name = "Delivery";
}elseif($_GET['type_name'] == 'qa'){
	$menu_name = "คำถามที่พบบ่อย";
}elseif($_GET['type_name'] == 'event'){
	$menu_name = "กิจกรรมส่วนลด สมาชิก";
}elseif($_GET['type_name'] == 'Press'){
	$menu_name = "สื่อประชาสัมพันธ์";
}elseif($_GET['type_name'] == 'condition'){
	$menu_name = "เงื่อนไงและข้อตกลง";
}elseif($_GET['type_name'] == 'careers'){
	$menu_name = "ร่วมงานกับเรา";
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
                                        	
											<div id="tabs" style="overflow:hidden;">
                                            <ul>
                                                <li><a href="#th" id="type_th">THAI</a></li>
                                                <li><a href="#eng" id="type_eng">ENGLISH</a></li>
                                            </ul>
                                            <div id="th" class="content" style="border:none;">
                                              <div class="cell3-input_textarea2"> 
                                                           
															<?php
                                                            $CKEditor = new CKEditor(); $config['toolbar'] = 'Full';
                                                            // คืนค่าสำหรับใช้งานร่วมกับ javascript
                                                            $events['instanceReady'] = 'function (evt) { 
                                                                    return editorObj=evt.editor;
                                                            }';	
                                                            // บรรทัดด้านล่าง เปรียบได้กับการสร้าง textarea ชื่อ editor1 
                                                            // ตัวแปรรับค่า เป็น $_POST['editor1'] หรือ $_GET['editor1'] ตามแต่กรณี
                                                            $CKEditor->editor("txt_detail_th", $data_txt['txt_detail_th'],$config,$events);
                                                            ?>
                                              </div>
                                            </div>
                                            <div id="eng" class="content" style="border:none;">

                                               <div class="cell3-input_textarea2"> 
															<?php
                                                            $CKEditor = new CKEditor(); $config['toolbar'] = 'Full';
                                                            // คืนค่าสำหรับใช้งานร่วมกับ javascript
                                                            $events['instanceReady'] = 'function (evt) { 
                                                                    return editorObj=evt.editor;
                                                            }';	
                                                            // บรรทัดด้านล่าง เปรียบได้กับการสร้าง textarea ชื่อ editor1 
                                                            // ตัวแปรรับค่า เป็น $_POST['editor1'] หรือ $_GET['editor1'] ตามแต่กรณี
                                                            $CKEditor->editor("txt_detail_eng", $data_txt['txt_detail_eng'],$config,$events);
                                                            ?>
                                              </div>

                                       		</div>
                                                                                        
                                       </ul>
                                    </div>
                                   <!--End ตาราง 3 Cell-->
                                     </div>                                   
                                </div>
                                   <!--BUTTON-->         
                                    <div class="demo" style=" margin-top:20px; position:relative;">
                                    
                                    <!--<button>Submit</button>-->
                                   	<input name="type_name" type="hidden" value="<?php echo $data_txt['type_name'];?>" id="type_name" />
                                   	<input name="type_id" type="hidden" value="<?php echo $data_txt['type_id'];?>" />
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
