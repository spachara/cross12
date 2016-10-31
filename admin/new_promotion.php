<?php
	session_start();
	require_once '../dbconnect.inc';
	include("class.page_split.php");
    $obj = new page_split();
	$obj->_setPageSize(100);						
	$obj->_setFile("new_user.php");		
	$obj->_setPage($_GET['page']);		
	if($_GET['page'] > 1){
		$f = 100*($_GET['page']- 1);
	}
	
	if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) { 
		echo "<script>location.href='index.php'</script>";
	}
	
	if($_POST['save'] == '1'){
		
			foreach ($_POST['hidden_new_id'] as $v) {

					$update_new_ranking = "UPDATE shipping_tb SET ship_ranking = '".$_POST['new_ranking'][$v]."'  ";
					$update_new_ranking .= "WHERE ship_id = '".$_POST[hidden_new_id][$v]."'";
					$update_new_ranking_result = @mysql_query($update_new_ranking, $connect);
					
			}

	}
	
	
	if($_GET['sAction'] == 'del'){

		
		$sql_delete = "DELETE FROM promotion_tb  WHERE promotion_id = '".$_GET['id_del']."' ";
		@mysql_query($sql_delete, $connect);
		
	?>		 <script>
					location.href='new_promotion.php'; //รีเฟสหน้า
			 </script>
	<?php
	}
	
	
	$sql_user = "SELECT * FROM promotion_tb ";
	$result_user =$obj->_query($sql_user, $connect);
	$num_user =@mysql_num_rows($result_user);


	$result_user2 =@mysql_query($sql_user, $connect);
	$num_user2 =@mysql_num_rows($result_user2);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
<title>::Crosstwelfth::</title>

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
                    <a href="new_user.php">Promotion CODE</a>
               </div>
               <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">Promotion CODE</div>
                    </div>
                    <div class="block_style2_content">



                            <!--Coppy Module Clear-->
                            <form method="post" name="myform" action="new_user.php">
                            <div class="module_3">
                                <div class="title">
                                    <div class="l"></div>
                                    <div class="r"></div>
                                    <div class="t">
                                      <h2>&nbsp;</h2> 
                                  </div>
                                    <div class="bt">
                                         
                                    </div>
                                </div>
                                <div class="conten">
                                    <!--ใสข้อมูล ตรงนี้-->
                                    <!--ตาราง 3 Cell-->
                                   <div class="title-top">
                                  &nbsp;
                                   <div class="right-title">
                                   <!--form3-->
                                   <div class="form3">
                                            
                                        <ul>                                        	
                                            <li>
                                                <a href="add_promotion.php">
                                                    <img alt="Add" src="images/1343378527_add1-.png" title="Add"/>
                                                    <span style="position:relative; top:-3px;">
                                                     Add Promotion
                                                    </span>
                                                </a>
                                             </li>
                                                                                    
                                            <!--<li><div style="height:20px; width:1px; background:#ccc;"></div></li>
                                            <li>
                                            <input type="hidden" name="save" value="1" />
                                            <input type="image" src="images/save_all_ranking.png" alt="Save Ranking" name="Submit" value="Save" title="Save Ranking" style="width:128px; height:16px;"/> </li> -->          
                                        </ul>
                                        
                                   </div>
                                   <!--END form3-->
                                   </div>
                                    

                                   
                                   </div>
                                   
                                   
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                    <td bgcolor="#000000"><table width="100%" border="0" cellpadding="0" cellspacing="1">
                                      <tr>
                                        <td width="25%" align="center" height="25" bgcolor="#F8F8F8">ชื่อ</td>
                                        <td width="25%" align="center" bgcolor="#F8F8F8">ส่วนลด</td>
                                        <td width="25%" align="center" bgcolor="#F8F8F8">CODE</td>
                                        <td width="25%" align="center" bgcolor="#F8F8F8">&nbsp;</td>
                                      </tr>
                                      <?php 
                                    
                                    for($u=1;$u<=intval($num_user);$u++){
                                    $data_user =@mysql_fetch_array($result_user);																					
                                    
                                    ?>
                                      <tr>
                                        <td height="25" bgcolor="#FFFFFF" align="center"><?php echo $data_user['promotion_name'];?></td>
                                        <td bgcolor="#FFFFFF" align="center"><?php echo $data_user['promotion_dis'];?> %</td>
                                        <td bgcolor="#FFFFFF" align="center"><?php echo $data_user['promotion_pass'];?></td>
                                        <td bgcolor="#FFFFFF" align="center"><div class="form2">
                                          <ul>
                                            <li><a href="new_promotion.php?id_del=<?php echo $data_user['promotion_id'];?>&amp;sAction=del" onClick="return confirm('Do you want to delete it. (yes/no)')"><img alt="Delete" src="images/1343378039_23-Full Trash.png" title="Delete"/></a></li>
                                            <li><a href="edit_promotion.php?promotion_id=<?php echo $data_user['promotion_id'];?>"><img alt="Edit" src="images/1343377813_Modify.png" title="Edit"/></a></li>
                                          </ul>
                                        </div></td>
                                      </tr>
                                      <?php } ?>
                                    </table></td>
                                    </tr>
                                    </table>

                                   <!--End ตาราง 3 Cell-->
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
