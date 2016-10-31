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

		
		$sql_delete = "DELETE FROM user_tb  WHERE u_id = '".$_GET['id_del']."' ";
		@mysql_query($sql_delete, $connect);
		
	?>		 <script>
					location.href='new_user.php'; //รีเฟสหน้า
			 </script>
	<?php
	}
	
	
	//$sql_user = "SELECT * FROM user_tb where u_id <> '' ";
	
	$sql_user = "SELECT  `u_id` , SUM( order_total ) AS order_total FROM  `order_tb` GROUP BY  `u_id` ORDER BY SUM( order_total ) DESC ";
	
	/*if($_POST['name_search']){
		$sql_user .= " AND u_fname like '%".$_POST['name_search']."%'";
	}elseif($_POST['surname_search']){
		$sql_user .= " AND u_lname like '%".$_POST['surname_search']."%'";
	}elseif($_POST['email_search']){
		$sql_user .= " AND u_mail like '%".$_POST['email_search']."%'";
	}elseif($_POST['tel_search']){
		$sql_user .= " AND u_mobi like '".$_POST['tel_search']."%'";
	}*/
	
	//$sql_user .= " ORDER BY date_in desc ";
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
                    <a href="new_user_order.php">สมาชิกที่มียอดสั่งซื้อมากที่สุด</a>
               </div>
               <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">สมาชิกที่มียอดสั่งซื้อมากที่สุด</div>
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
                                   		
                                        <!--<ul>
                                        	<li > สมาชิกรวม ทั้งสิ้น <?php echo $num_user2;?>คน</li>         
                                        </ul>-->
                                        
                                   </div>
                                   <!--END form3-->
                                   </div>
                                    <!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                    <td width="12%">ชื่อ</td>
                                    <td width="28%"><input type="text" name="name_search"  value="<?php echo $_POST['name_search'];?>"/></td>
                                    <td width="15%">นามสกุล</td>
                                    <td width="27%"><input type="text" name="surname_search"  value="<?php echo $_POST['surname_search'];?>"/></td>
                                    <td width="18%"><input name="search" type="submit" class="borderfrom" value="ค้นหา" style="width:50px" /></td>
                                    </tr>
                                    <tr>
                                      <td>เบอร์โทร</td>
                                      <td><input type="text" name="tel_search"  value="<?php echo $_POST['tel_search'];?>"/></td>
                                      <td>Email</td>
                                      <td><input type="text" name="email_search"  value="<?php echo $_POST['email_search'];?>"/></td>
                                      <td>&nbsp;</td>
                                    </tr>
                                    </table>-->

                                   
                                   </div>
                                   
                                   
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                    <td bgcolor="#000000"><table width="100%" border="0" cellpadding="0" cellspacing="1">
                                      <tr>
                                        <td width="6%" height="25" bgcolor="#F8F8F8">ลำดับ</td>
                                        <td width="23%" bgcolor="#F8F8F8">ชื่อ-นามสกุล</td>
                                        <td width="19%" align="center" bgcolor="#F8F8F8">เบอร์โทรศัพท์</td>
                                        <td width="21%" align="center" bgcolor="#F8F8F8">อีเมล์</td>
                                        <td width="15%" align="center" bgcolor="#F8F8F8">จังหวัด</td>
                                        <td width="16%" align="center" bgcolor="#F8F8F8">ยอดเงิน</td>
                                        <!--<td width="15%" bgcolor="#F8F8F8">&nbsp;</td>-->
                                      </tr>
                                      <?php 
                                    
                                    for($u=1;$u<=100;$u++){
                                    $data_user =@mysql_fetch_array($result_user);																					
                                    
									$sql_user_show = "SELECT * FROM user_tb WHERE u_id = '".$data_user['u_id']."' ";
									$result_user_show =@mysql_query($sql_user_show, $connect);
									$data_user_show = @mysql_fetch_array($result_user_show);
									
                                    ?>
                                      <tr>
                                        <td height="25" bgcolor="#FFFFFF"><?php echo $f+$u;?></td>
                                        <td bgcolor="#FFFFFF"><?php echo "<a href=comment_inbox.php?u_id=".$data_user_show['u_id']." target=_blank><b>".$data_user_show['u_fname']." ".$data_user_show['u_lname']."</a></b>";?></td>
                                        <td bgcolor="#FFFFFF"><?php echo $data_user_show['u_mobi'];?></td>
                                        <td bgcolor="#FFFFFF"><?php echo $data_user_show['u_mail'];?></td>
                                        <td bgcolor="#FFFFFF"><?php echo $data_user_show['u_province'];?></td>
                                        <td bgcolor="#FFFFFF"><?php echo $data_user['order_total'];?></td>
                                        <!--<td bgcolor="#FFFFFF"><div class="form2">
                                          <ul>
                                            <li><a href="new_point.php?member_id=<?php echo $data_user_show['u_id'];?>" target="_blank">Point</a></li>
                                            <li><a href="new_user.php?id_del=<?php echo $data_user_show['u_id'];?>&amp;sAction=del" onClick="return confirm('Do you want to delete it. (yes/no)')"><img alt="Delete" src="images/1343378039_23-Full Trash.png" title="Delete"/></a></li>
                                            <li><a href="edit_user.php?u_id=<?php echo $data_user_show['u_id'];?>" target="_blank"><img alt="Edit" src="images/1343377813_Modify.png" title="Edit"/></a></li>
                                          </ul>
                                        </div></td>-->
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
