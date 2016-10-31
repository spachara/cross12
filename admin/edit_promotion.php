<?php
session_start();
require_once '../dbconnect.inc';

if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) { 
	echo "<script>window.location.href='index.php'</script>";
}


if($_POST['Submit'] == 'UPDATE'){
	
	if($_POST['promotion_status'] != '1'){
		$promotion_status = 0;
	}else{
		$promotion_status = 1;
	}
		
	$edit_promotion = "UPDATE promotion_tb SET promotion_name = '".$_POST['promotion_name']."', promotion_pass = '".$_POST['promotion_pass']."' ";
	$edit_promotion .= " , promotion_dis = '".$_POST['promotion_dis']."', promotion_status = '".$promotion_status."' ";
	$edit_promotion .= " WHERE promotion_id = '".$_POST['promotion_id']."' ";
	@mysql_query($edit_promotion, $connect);
			
?><script>window.location.href='new_promotion.php';</script>
<?php } ?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
<title>Cross Twelfth</title>
	<link rel="stylesheet" href="jquery_ui/development-bundle/themes/base/jquery.ui.all.css">
	<script src="jquery_ui/development-bundle/jquery-1.7.2.js"></script>
	<script src="jquery_ui/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="jquery_ui/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="jquery_ui/development-bundle/ui/jquery.ui.button.js"></script>
	<link rel="stylesheet" href="jquery_ui/development-bundle/demos/demos.css">
	<script>
	$(function() {
		$( "input:submit, a, button", ".demo" ).button();
		$( "a", ".demo" ).click(function() { return false; });
	});
	</script>
<script language="javascript">
$(document).ready(function() {
	
	$('#uploadedfile1').after('<span class="pixels"></span>');
	
    var banner_id = $('#banner_id').val();
    var type_id = $('#type_id').val();
    var banner_type = $('#banner_type').val();
	

	pixels = "( 250 x 141 pixels )";

	//alert(banner_id);
	$('.pixels').text(pixels);
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
                <a href="new_promotion.php">Promotion CODE</a> > <a href="#">Edit Promotion</a>
           </div>
           <!--End Navigator-->            

            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">
                        Edit Promotion
                        </div>
                    </div>
                    <div class="block_style2_content">

                     <!--Coppy Module Clear-->
                                   
                <form method="post" enctype="multipart/form-data" name="myform">
                <input type="hidden" name="mid" value="<?php echo $_GET['member_id'];?>" />
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
                      <?php
                      $sql_promotion = "SELECT * FROM promotion_tb WHERE promotion_id = '".$_GET['promotion_id']."' ";
					  $result_p = @mysql_query($sql_promotion, $connect);
					  $data_p = @mysql_fetch_array($result_p);
					  ?>    
                      <div class="table_3cell">
                          <ul>
                                 <li>
                              		<div class="cell3-text">
                              		  <input type="checkbox" name="promotion_status" id="promotion_status" value="1" <?php echo ($data_p['promotion_status'] == '1' ? "checked=checked" : "" );?> />
                              		</div>
                                    <div class="cell3-input">ใช้งาน</div>
                                </li>
                                <li>
                              		<div class="cell3-text">ชื่อ : </div>
                                    <div class="cell3-input"><input name="promotion_name" type="text" id="promotion_name" value="<?php echo $data_p['promotion_name'];?>" /></div>
                                </li>
                                 <li>
                              		<div class="cell3-text">ส่วนลด : </div>
                                    <div class="cell3-input"><input name="promotion_dis" type="text" id="promotion_dis" value="<?php echo $data_p['promotion_dis'];?>" /> %</div>
                                </li>
                                 <li>
                              		<div class="cell3-text">Code : </div>
                                    <div class="cell3-input"><input name="promotion_pass" type="text" id="promotion_pass" value="<?php echo $data_p['promotion_pass'];?>" /></div>
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
                <input name="promotion_id" type="hidden" value="<?php echo $_GET['promotion_id']?>" />
                <input name="Submit" type="submit" class="borderfrom" style="width:80px" value="UPDATE">
                                                    
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
