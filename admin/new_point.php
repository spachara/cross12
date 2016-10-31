<?php
session_start();
require_once '../dbconnect.inc';

if($_SESSION['AUTH_PERMISSION_ID']=='') {
	header("Location:index.php");
}



if($_GET['sAction'] == 'del'){
	

	
	$delete_howto = "DELETE FROM point_tb  WHERE id = '".$_GET['id_del']."' ";
	@mysql_query($delete_howto, $connect);
?>		 
		<script>
			location.href='new_point.php'; //รีเฟสหน้า
		</script>
<?php
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
                                     <a href="new_point.php">Point ID:<?php echo $_GET['member_id'];?></a>
                                        
                                   </div>
                                   <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">Point ID:<?php echo $_GET['member_id'];?></div>
                    </div>
                    <div class="block_style2_content">



                                   		<!--Coppy Module Clear-->
                                        <form action="new_point.php" method="post" enctype="multipart/form-data" name="form1">
                                        <div class="module_3">
                                            <div class="title">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                                <div class="t"><h2>
                                                </h2> </div>
                                                <div class="bt">
                                                	 
                                                </div>
                                            </div>
                                            <div class="conten">
                                                <!--ใสข้อมูล ตรงนี้-->
                                                <!--ตาราง 3 Cell-->
                                   <div class="title-top">
                                   <div class="right-title">
                                   <div class="form3">
                                   		
                                        <ul>
                                        <li><a href="add_point.php?member_id=<?php echo $_GET['member_id'];?>"><img alt="Add" src="images/1343378527_add1-.png" title="Add"/> <span style="position:relative; top:-3px;">Point </span></a></li>                                            
                                            <li><div style="height:20px; width:1px; background:#ccc;"></div></li>
                                        <li>
                                            <input type="hidden" name="save" value="1" />
                                            <input type="image" src="images/save_all_ranking.png" alt="Save Ranking" name="Submit" value="Save" title="Save Ranking" style="width:128px; height:16px;"/> </li>         
                                        </ul>
                                        
                                   </div>
                                   </div>
                                   
                                   </div>
                                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                     <tr>
                                       <td bgcolor="#000000"><table width="100%" border="0" cellpadding="0" cellspacing="1">
                                         <tr>
                                           <td width="9%" height="25" align="center" bgcolor="#F4F4F4"><strong>ลำดับ</strong></td>
                                           <td width="50%" align="center" bgcolor="#F4F4F4"><strong>Ref.</strong></td>
                                           <td width="32%" align="center" bgcolor="#F4F4F4"><strong>Point</strong></td>
                                           <td width="9%" bgcolor="#F4F4F4">&nbsp;</td>
                                         </tr>
                                         <?php
                                    $sql_size = "SELECT * FROM point_tb where m_id = '".$_GET['member_id']."' order by id desc";
                                    $result_size =@mysql_query($sql_size, $connect);
                                    $num_size =@mysql_num_rows($result_size);
                                    
                                    for($i=1;$i<=intval($num_size);$i++){
                                    $data_size =@mysql_fetch_array($result_size);
                                    ?>
                                         <tr>
                                           <td height="25" align="center" bgcolor="#FFFFFF"><?php echo $f+$i;?></td>
                                           <td align="center" bgcolor="#FFFFFF"><?php echo $data_size['p_ref']; ?></td>
                                           <td align="center" bgcolor="#FFFFFF"><?php echo $data_size['ppoint']; ?></td>
                                           <td bgcolor="#FFFFFF">
                                           <?php if($_SESSION['AUTH_PERMISSION_ID'] == '1'){?>
                                           <a href="new_point.php?id_del=<?php echo $data_size['id'];?>&amp;sAction=del" onclick="return confirm('Do you want to delete it. (yes/no)')">
                                           <img alt="Delete" src="images/1343378039_23-Full Trash.png" title="Delete"/></a>
                                           <?php } ?>
                                           </td>
                                         </tr>
                                         <?php } ?>
                                       </table></td>
                                     </tr>
                                   </table>
                                   <!-- -->
                                  	<div class="page_number">
                                    	<div class="page_number-right">
                                        
                                            	<?php $obj->_displayPage(); ?>
                                    	</div>
                                    </div>   
                                    <!-- -->


                                            
                                          </div>
                                            <div class="bottom">
                                                <div class="l"></div>
                                                <div class="r"></div>
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

      </div>
            <div class="clear"></div>                        
</div>            
            







        </div>
<!--Page Footer-->

<?php include('footer.php');?>

<!--End Page Footer-->        
    </div>
</div>    
</body>
</html>
