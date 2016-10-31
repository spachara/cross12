<?php
session_start();
require_once '../dbconnect.inc';

if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) { 
	echo "<script>window.location.href='index.php'</script>";
}



if($_POST['Submit'] == 'CREATE'){

	$add_admin = "INSERT INTO admin_login (admin_id, admin_name, admin_value, admin_email, admin_sys_name, admin_type, date_in, date_update)";
	$add_admin .= "VALUES(NULL, '".$_POST['admin_name']."', '".$_POST['admin_value']."', '".$_POST['admin_email']."', '".$_POST['admin_sys_name']."', '".$_POST['admin_type']."', NOW(), NOW())";
	@mysql_query($add_admin, $connect);
	//echo $add_admin;	

?><script>window.location.href='new_user_login.php';</script>
<?php } 


if($_POST['Submit'] == 'Edit'){

	$edit_admin = "UPDATE admin_login SET admin_name = '".$_POST['admin_name']."', admin_value = '".$_POST['admin_value']."' ";
	$edit_admin .= " , admin_email = '".$_POST['admin_email']."', admin_sys_name = '".$_POST['admin_sys_name']."' ";
	$edit_admin .= " , admin_type = '".$_POST['admin_type']."' ";
	$edit_admin .= " WHERE admin_id = '".$_POST['admin_id']."'";
	@mysql_query($edit_admin, $connect);
	//echo $edit_admin;	

?><script>window.location.href='new_user_login.php';</script>
<?php } 

if ($_GET['sAction'] == "Edit") {
	$sql_admin = "SELECT * FROM admin_login where admin_id = '".$_GET['admin_id']."'";
	$result_admin = @mysql_query($sql_admin, $connect);
	$data_admin = @mysql_fetch_array($result_admin);

	$nav_name = "แก้ไข";
} else {
	$nav_name = "เพิ่ม";
}	

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
<title>::Crosstwelfth::</title>
<link href="cssstyle.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="color/css/colorpicker.css" type="text/css" />
	<script type="text/javascript" src="color/js/jquery.js"></script>
	<script type="text/javascript" src="color/js/colorpicker.js"></script>
    <script type="text/javascript" src="color/js/eye.js"></script>
    <script type="text/javascript" src="color/js/utils.js"></script>
    <script type="text/javascript" src="color/js/layout.js?ver=1.0.2"></script>
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
                <a href="new_user_login.php">ผู้ใช้งาน</a> > <a href="#"><?php echo $nav_name;?>ผู้ใช้งาน</a>
           </div>
           <!--End Navigator-->            

            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">
                        <?php echo $nav_name;?>ผู้ใช้งาน
                        </div>
                    </div>
                    <div class="block_style2_content">

                     <!--Coppy Module Clear-->
                                   
                <form method="post" enctype="multipart/form-data" name="myform">
                <input type="hidden" name="oid" value="<?php echo $_GET['oid'];?>" />
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
                                 <li>
                              		<div class="cell3-text">User Type : </div>
                                    <div class="cell3-input">
                                    	<input name="admin_type" type="radio" value="1" <?php echo $data_admin['admin_type'] == 1 ? "checked" : "" ;?> /> Admin
                                    	<input name="admin_type" type="radio" value="2" <?php echo $data_admin['admin_type'] == 2 || $data_admin['admin_type'] == "" ? "checked" : "" ;?> /> Officer
                                    </div>
                                </li>
                                 <li>
                              		<div class="cell3-text">User : </div>
                                    <div class="cell3-input"><input name="admin_name" type="text" value="<?php echo $data_admin['admin_name'];?>" /></div>
                                </li>
                                 <li>
                              		<div class="cell3-text">Password : </div>
                                    <div class="cell3-input"><input name="admin_value" type="text" value="<?php echo $data_admin['admin_value'];?>" /></div>
                                </li>
                                 <li>
                              		<div class="cell3-text">E-mail : </div>
                                    <div class="cell3-input"><input name="admin_email" type="text" value="<?php echo $data_admin['admin_email'];?>" /></div>
                                </li>
								<li>
                              		<div class="cell3-text">Name : </div>
                                    <div class="cell3-input"><input name="admin_sys_name" type="text" value="<?php echo $data_admin['admin_sys_name'];?>" /></div>
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
				<?php if($_GET['sAction'] == 'Edit'){?>
				<input name="admin_id" type="hidden" value="<?php echo $data_admin['admin_id']?>" />
                <input name="Submit" type="submit" class="borderfrom" style="width:80px" value="Edit">
				<?php }else{?>
                <input name="Submit" type="submit" class="borderfrom" style="width:80px" value="CREATE">
				<?php } ?>
                                                    
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
