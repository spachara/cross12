<?php
	session_start();
	require_once '../dbconnect.inc';
	
	if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) {
		echo "<script>location.href='index.php'</script>";
	}
	
	include("class.page_split.php");
    $obj = new page_split();
	$obj->_setPageSize(10);						
	$obj->_setFile("new_webboard.php");		
	$obj->_setPage($_GET['page']);		
	if($_GET['page'] > 1){
		$f = 10*($_GET['page']- 1);
	}

	if($_POST['save'] == '1'){
		
			foreach ($_POST['hidden_new_id'] as $v) {

					$update_new_ranking = "UPDATE webboard_tb SET webboard_ranking = '".$_POST['new_ranking'][$v]."'  ";
					$update_new_ranking .= "WHERE webboard_id = '".$_POST[hidden_new_id][$v]."'";
					$update_new_ranking_result = @mysql_query($update_new_ranking, $connect);
					
			}

	}
	
	if($_GET['sAction'] == 'del'){
	
		$sql_delete_admin = "DELETE FROM admin_login  WHERE admin_id = '".$_GET['id_del']."' ";
		@mysql_query($sql_delete_admin,$connect);
		
	?>		 <script>
					location.href='new_user_login.php'; //รีเฟสหน้า
			 </script>
	<?php
	}
	
	$sql_admin = "SELECT * FROM admin_login WHERE admin_id NOT IN ('1') ORDER BY admin_id ";
	$result_admin =@mysql_query($sql_admin, $connect);
	$num_admin =@mysql_num_rows($result_admin);
	
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
                                        <a href="new_user_login.php">ผู้ใช้งาน</a>
                                        
                                   </div>
                                   <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">ผู้ใช้งาน</div>
                    </div>
                    <div class="block_style2_content">



                                   		<!--Coppy Module Clear-->
                                        <form method="post" name="myform" action="">
                                        <div class="module_3">
                                            <div class="title">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                                <div class="t"><h2>&nbsp;</h2> </div>
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
                                        	<li><a href="add_user_login.php"><img alt="Add" src="images/1343378527_add1-.png" title="Add"/> <span style="position:relative; top:-3px;">เพิ่มผู้ใช้งาน</span></a></li>                                            
                                            <!--<li><div style="height:20px; width:1px; background:#ccc;"></div></li>
                                            <li>
                                            <input type="hidden" name="save" value="1" />
                                            <input type="image" src="images/save_all_ranking.png" alt="Save Ranking" name="Submit" value="Save" title="Save Ranking" style="width:128px; height:16px;"/> </li>-->
                                        </ul>
                                        
                                   </div>
                                   </div>
                                   
                                   </div>
                                        
                                        
                                        
                                        
                                        
                                        
                                   	<div class="table_3cell">
                                     	<ul>
                                        	<!--Title-->
                                        	<li class="bg-title">
                                            	<div class="cell1">
                                                    ลำดับ
                                                </div>
                                                <div class="cell2" style="width:25%;">
													ชื่อผู้ใช้
                                                </div>
												<div class="cell3" style="width:20%;">
													User
                                                </div>
												<div class="cell3" style="width:20%;">
													Password
                                                </div>
                                                <div class="cell3">
                                                    
                                                </div>
                                            </li>
                                            <!--End Title-->
                                            <?php 
											for($i=1;$i<=intval($num_admin);$i++){
											$data_admin =@mysql_fetch_array($result_admin);
											?>
                                            <li>
                                            	<div class="cell1">
                                                    <?php echo $f+$i;?>
                                                </div>
                                                <div class="cell2" style="width:25%;">
                                                    <b><?php echo $data_admin['admin_sys_name'];?></b>
                                                </div>
												<div class="cell3" style="width:20%;">
                                                    <?php echo $data_admin['admin_name'];?>
                                                </div>
												<div class="cell3" style="width:20%;">
                                                    <?php echo $data_admin['admin_value'];?>
                                                </div>
                                                <div class="cell3">
                                                    <!--Form2-->
                                                   <div class="form2">
                                                        <ul>                                                        	
                                                            <li><a href="new_user_login.php?id_del=<?php echo $data_admin['admin_id'];?>&amp;sAction=del" onClick="return confirm('Do you want to delete it. (yes/no)')"><img alt="Delete" src="images/1343378039_23-Full Trash.png" title="Delete"/></a></li>
                                                            <li><a href="add_user_login.php?admin_id=<?php echo $data_admin['admin_id'];?>&sAction=Edit"><img alt="Edit" src="images/1343377813_Modify.png" title="Edit"/></a></li>                                                            
                                                        </ul>
                                                   </div>                                   
                                                   <!--End Form2-->
                                                </div>
                                            </li>
                                            <? } ?>
                                        </ul>
                                    </div>
                                   <!--End ตาราง 3 Cell-->

                                	<!-- -->
                                  	<div class="page_number">
                                    	<div class="page_number-right">
                                        
                                            	<?php //$obj->_displayPage(); ?>
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
