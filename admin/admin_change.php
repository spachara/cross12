<?php
	session_start();
	require_once '../dbconnect.inc';

	if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) {
		echo "<script>window.location.href='index.php'</script>";
	}
	
if($_POST['Submit'] == 'EDIT'){

$edit_admin = "UPDATE admin_login SET admin_name = '".$_POST['names_admins']."', admin_value = '".$_POST['pass_admins']."' where admin_id = '".$_POST['id']."' ";
$result_edit =@mysql_query($edit_admin,$connect);
?>		 
	<script>
		location.href='admin_change.php?id=<?php echo $_POST['id']; ?>'; //รีเฟสหน้า
	</script>
<?php
}

	$sql_admin = "SELECT * FROM admin_login where admin_id = '".$_SESSION['AUTH_PERMISSION_ID']."' ";
	$result_admin = @mysql_query($sql_admin,$connect);
	$data_admin =@mysql_fetch_array($result_admin);
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
<title>Smile Search</title>
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
                                   		<a href="admin_change.php?id=<?php echo $_GET['id'];?>">เปลี่ยนรหัสผ่าน</a> 
                                   </div>
                                   <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">เปลี่ยนรหัสผ่าน</div>
                    </div>
                    <div class="block_style2_content">



                                   		<!--Coppy Module Clear-->
                                        <form method="post" name="myform" action="">
                                        <input type="hidden" value="<?php echo $_GET['id'];?>" name="id" />
                                        <div class="module_3">
                                            <div class="title">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                                <div class="t"><h2><!--รูปสไลด์--></h2> </div>
                                                <div class="bt">
                                                	 
                                                </div>
                                            </div>
                                            <div class="conten">
                                                <!--ใสข้อมูล ตรงนี้-->
                                                <!--ตาราง 3 Cell-->
                                   <div class="title-top">
                                  &nbsp;
                                   <div class="right-title">
                                   <div class="form3">
                                   		
                                        <ul>
                                        	<li><!--<a href="add_team.php"><img alt="Add" src="images/1343378527_add1-.png" title="Add"/> <span style="position:relative; top:-3px;">Add Team</span></a>--></li>                                            
                                            <li><!--<div style="height:20px; width:1px; background:#ccc;"></div>--></li>
                                            <li>
                                            <!--<input type="hidden" name="save" value="1" />
                                            <input type="image" src="images/save_all_ranking.png" alt="Save Ranking" name="Submit" value="Save" title="Save Ranking" style="width:128px; height:16px;"/> --></li>         
                                        </ul>
                                        
                                   </div>
                                   </div>
                                   </div>
                                   
                                   <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
                                     <tr>
                                       <td width="30%">USER </td>
                                       <td><span class="cell3-input">
                                         <input name="names_admins" type="text" value="<?php echo $data_admin['admin_name'];?>" />
                                       </span></td>
                                     </tr>
                                     <tr>
                                       <td>PASSWORD </td>
                                       <td><span class="cell3-input">
                                         <input name="pass_admins" type="text" value="<?php echo $data_admin['admin_value'];?>" />
                                       </span></td>
                                     </tr>
                                     <tr>
                                       <td>&nbsp;</td>
                                       <td>&nbsp;</td>
                                     </tr>
                                   </table>
                                   
                                   
                                   

                                   
                                   <!--End ตาราง 3 Cell-->
                                            </div>
                                            <div class="bottom">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                            </div>
                                            <div class="demo">
                                        <input name="Submit" type="submit" class="borderfrom" style="width:80px" value="EDIT">
                                        </div>
                                        
                                </div>
										<!--End Coppy Module Clear--> </form>                                 



                    </div>
                    <div class="block_style2_bottom">
                        <div class="block_style2_bottom-l"></div>
                        <div class="block_style2_bottom-r"></div>
                    </div>                    
                </div>
                <!-- End Block Frame-->
                
                                	<!-- -->
                                  	<div class="page_number">
                                    	<div class="page_number-right">
                                            	<?php //$obj->_displayPage(); ?>
                                    	</div>
                                    </div>   
                                    <!-- -->
                
            </div>
            <div class="clear"></div>                        
		</div>            
            


		<?php include('footer.php');?>



        </div>
    </div>
</div>    
</body>
</html>
