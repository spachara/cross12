<?php
	session_start();
	require_once '../dbconnect.inc';
	
	if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) {
		echo "<script>location.href='index.php'</script>";
	}
	
	include("class.page_split.php");
    $obj = new page_split();
	$obj->_setPageSize(100);						
	$obj->_setFile("new_inbox.php");		
	$obj->_setPage($_GET['page']);		
	if($_GET['page'] > 1){
		$f = 100*($_GET['page']- 1);
	}

	if($_POST['save'] == '1'){
		
		$update_pin = "UPDATE inbox_tb SET webboard_pin_show = 0 ";
		@mysql_query($update_pin, $connect);
		
			foreach ($_POST['new_ranking'] as $v) {

					$update_new_ranking = "UPDATE inbox_tb SET webboard_pin_show = '1'  ";
					$update_new_ranking .= "WHERE webboard_id = '".$_POST['new_ranking'][$v]."'";
					$update_new_ranking_result = @mysql_query($update_new_ranking, $connect);
					//echo $update_new_ranking."<br>";		
			}
		?><script>location.href="new_inbox.php";</script><?php
	}
	
	if($_GET['sAction'] == 'del'){
	
		$sql_delete_webboard = "delete from inbox_tb  where webboard_id = '$_GET[id_del]' ";
		$result_delete_webboard = @mysql_query($sql_delete_webboard,$connect);
		
	?>		 <script>
					location.href='new_inbox.php'; //รีเฟสหน้า
			 </script>
	<?php
	}
	
	//$sql_webboard = "SELECT * FROM inbox_tb i LEFT OUTER JOIN inbox_answer_tb a ON i.webboard_id = a.webboard_id GROUP BY i.webboard_id ORDER BY a.date_in DESC ";
if ($_POST['data_search'] != "") {

	$time_b = substr($_POST['data_search'], 6, 4)."-".substr($_POST['data_search'], 3, 2)."-".substr($_POST['data_search'], 0, 2)." 00:00:00";
	$time_e = substr($_POST['data_search'], 6, 4)."-".substr($_POST['data_search'], 3, 2)."-".substr($_POST['data_search'], 0, 2)." 23:59:59";

	if ($_POST['data_select'] == 1) {
		
		$sql_webboard = "SELECT * FROM inbox_tb i, inbox_answer_tb a, user_tb u WHERE i.webboard_id = a.webboard_id AND a.u_id = u.u_id ";
		$sql_webboard .= " AND u.u_fname LIKE '%".$_POST['data_search']."%' GROUP BY u.u_id ";
		
	} else if ($_POST['data_select'] == 2) {
		
		$sql_webboard = "SELECT * FROM inbox_tb WHERE date_update BETWEEN '".$time_b."' AND '".$time_e."' ORDER BY date_update DESC ";
		
	} else if ($_POST['data_select'] == 3) {
		
		$sql_webboard = "SELECT * FROM inbox_tb WHERE date_admin BETWEEN '".$time_b."' AND '".$time_e."' ORDER BY date_update DESC ";
	
	}
	
}else if ($_POST['data_search'] == "") {
	$sql_webboard = "SELECT * FROM inbox_tb ORDER BY webboard_pin_show DESC, date_update DESC";
}
$result_webboard =$obj->_query($sql_webboard, $connect);
$num_webboard =@mysql_num_rows($result_webboard);
	
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
		dateFormat : "dd-mm-yy"
	});
});
$(document).ready(function() {
    $('#l_box').change(function() {
		var val = $(this).val();
        if (val == 1) {
			location.href='new_inbox.php?type=1';
		} else if (val == 2) {
			location.href='new_inbox.php?type=2';
		} else if (val == 3) {
			location.href='new_inbox.php?type=3';
		}
    });
});
</script>

<link href="cssstyle.css" rel="stylesheet" type="text/css" />
<style>
.box_search {
	padding:5px 0;
}
.box_search li {
	float:left;
}
</style>
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
                                        <a href="new_inbox.php">Inbox พูดคุยกับทีมงาน</a>
                                        
                                   </div>
                                   <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">Inbox พูดคุยกับทีมงาน</div>
                    </div>
                    <div class="block_style2_content">



                                   		<!--Coppy Module Clear-->
                                        <!--<form method="post" name="myform" action="">-->
                                        <div class="module_3">
                                            <div class="title">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                                <div class="t">
                                                    <h2>
                                                        <a href="new_inbox.php">Inbox</a> | 
                                                        <a href="new_censor.php">กรองคำหยาบ</a>
                                                    </h2>
                                                </div>
                                                <div class="bt">
                                                	 
                                                </div>
                                            </div>
                                            <div class="conten">
                                                <!--ใสข้อมูล ตรงนี้-->
                                                <form method="post" name="myform" action="">
                                                <ul class="box_search">
                                                	<li>
                                                        <select id="l_box" name="data_select">
                                                            <option value="1" <?php echo $_GET['type'] == "" || $_GET['type'] == 1 ? "selected=\"selected\"" : "";?>>ชื่อ</option>
                                                            <option value="2" <?php echo $_GET['type'] == 2 ? "selected=\"selected\"" : "";?>>Member Update</option>
                                                            <option value="3" <?php echo $_GET['type'] == 3 ? "selected=\"selected\"" : "";?>>Admin Update</option>
                                                        </select>
                                                    </li>
                                                    <?php if ($_GET['type'] == "" || $_GET['type'] == 1) {?>
                                                        <li>
                                                            <input name="data_search" type="text" id="" class="box_normal" value="<?php echo $_POST['data_search'];?>" />
                                                        </li>
                                                    <?php } else if ($_GET['type'] == 2 || $_GET['type'] == 3) {?>
                                                        <li>
                                                            <input name="data_search" type="text" id="datepicker" class="box_date" value="<?php echo $_POST['data_search'];?>" />
                                                        </li>
                                                    <?php }?>
                                                    <li>
                                                        <input name="" type="submit" value="Search" />
                                                    </li>
                                                </ul>
                                                <div>&nbsp;</div>
                                                </form>
                                                <!--ตาราง 3 Cell-->
                                   <div class="title-top">
                                   <form method="post">
                                   <div class="right-title">
                                       <div class="form3">
                                            
                                            <ul>
                                                <!--<li><a href="add_webboard.php"><img alt="Add" src="images/1343378527_add1-.png" title="Add"/> <span style="position:relative; top:-3px;">เพิ่มกระทู้ </span></a></li>                                            
                                                <li><div style="height:20px; width:1px; background:#ccc;"></div></li>-->
                                                <li>
                                                <input type="hidden" name="save" value="1" />
                                                <input type="image" src="images/save_all.png" alt="Save Ranking" name="Submit" value="Save" title="Save Ranking" style="width:60px; height:16px;"/> </li>         
                                            </ul>
                                            
                                       </div>
                                   </div>
                                   
                                   </div>
                                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                     <tr>
                                       <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                                         <tr>
                                           <td width="10%" height="25" align="center" bgcolor="#FFD2D2">ลำดับ</td>
                                           <td width="16%" align="center" bgcolor="#FFD2D2">Member Update</td>
                                           <td width="16%" align="center" bgcolor="#FFD2D2">Admin Update</td>
                                           <td width="47%" align="center" bgcolor="#FFD2D2">ชื่อ</td>
                                           <td width="11%" bgcolor="#FFD2D2">&nbsp;</td>
                                         </tr>
                                         <?php 
											for($i=1;$i<=intval($num_webboard);$i++){
											$data_webboard =@mysql_fetch_array($result_webboard);
											
												if ($data_webboard['date_update'] != "") {
													$date_update = substr($data_webboard['date_update'], 8, 2)."-".substr($data_webboard['date_update'], 5, 2)."-".substr($data_webboard['date_update'], 0, 4)." ".substr($data_webboard['date_update'], 11, 8);
												} else {
													$date_update = "";	
												}
												
												if ($data_webboard['date_admin'] != "") {
													$date_admin = substr($data_webboard['date_admin'], 8, 2)."-".substr($data_webboard['date_admin'], 5, 2)."-".substr($data_webboard['date_admin'], 0, 4)." ".substr($data_webboard['date_admin'], 11, 8);
												} else {
													$date_admin = "";	
												}
												
												$sql_answer = "SELECT * FROM inbox_answer_tb WHERE webboard_id = '".$data_webboard['webboard_id']."' ";
												$sql_answer .= " ORDER BY date_in DESC ";
												$result_answer =@mysql_query($sql_answer, $connect);
												$num_answer =@mysql_num_rows($result_answer);
												$data_answer =@mysql_fetch_array($result_answer);
												
											?>
                                         <tr>
                                           <td bgcolor="#F5F5F5">
										   		<?php 
												echo $f+$i;
												if ($data_webboard['webboard_pin_show'] == 1) {
													echo "<img src=\"images/pin.png\" width=\"16\">";
												}
												?>
                                           </td>
                                           <td bgcolor="#F5F5F5"><?php echo $date_update;?></td>
                                           <td bgcolor="#F5F5F5"><?php echo $date_admin;?></td>
                                           <td bgcolor="#F5F5F5"><a href="comment_inbox.php?webboard_id=<?php echo $data_webboard['webboard_id'];?>"><?php
                                        
										$select_user = "SELECT * FROM user_tb WHERE u_id = '".$data_webboard['webboard_pin']."' ";
										$result_user =@mysql_query($select_user, $connect);
										$data_user =@mysql_fetch_array($result_user);
										echo $data_user['u_fname']." ".$data_user['u_lname'];
										?></a></td>
                                           <td bgcolor="#F5F5F5"><div class="form2">
                                             <ul>
                                               <li><a href="comment_inbox.php?webboard_id=<?php echo $data_webboard['webboard_id'];?>"><img src="images/1349669326_24-comment-square.png" width="18" /></a></li>
                                               <li>
                                               		<input name="new_ranking[<?php echo $data_webboard['webboard_id'];?>] " type="checkbox" value="<?php echo $data_webboard['webboard_id'];?>" <?php echo $data_webboard['webboard_pin_show'] == 1 ? "checked=\"checked\"" : "";?>>                       								
                                               </li>
                                               <li>
                                               		<?php 
													if ($data_answer['u_id'] == "0") {
														echo "<img src=\"images/Done.png\" width=\"16\"> ";
													}
													
													?>
                                               </li>
                                               <!--<li><a href="new_inbox.php?id_del=<?php echo $data_webboard['webboard_id'];?>&amp;sAction=del" onClick="return confirm('Do you want to delete it. (yes/no)')"><img alt="Delete" src="images/1343378039_23-Full Trash.png" title="Delete"/></a></li>
                                               <li><a href="edit_webboard.php?webboard_id=<?php echo $data_webboard['webboard_id'];?>"><img alt="Edit" src="images/1343377813_Modify.png" title="Edit"/></a></li>
                                                            <li>Ranking</li>
                                                            <li><input name="new_ranking[<?php echo $data_webboard['webboard_id'];?>] " type="text" id="new_ranking " size="3" maxlength="3" value="<?php echo $data_webboard['webboard_ranking'];?>">
                       											<input name="hidden_new_id[<?php echo $data_webboard['webboard_id'];?>] " type="hidden"  value="<?php echo $data_webboard['webboard_id'];?>"></li>-->
                                             </ul>
                                           </div></td>
                                         </tr>
                                         <? } ?>
                                       </table></td>
                                     </tr>
                                   </table>
                                   <!--End ตาราง 3 Cell-->

                                	<!-- -->
                                  	<div class="page_number">
                                    	<div class="page_number-right">
                                        
                                            	<?php $obj->_displayPage(); ?>
                                    	</div>
                                    </div>   
                                    <!-- -->
									</form>

                                            
                                            </div>
                                            <div class="bottom">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                            </div>
                                        </div>
										<!--End Coppy Module Clear--> <!--</form>-->                                 



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
