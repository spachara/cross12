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
	
		$sql_delete_webboard = "delete from webboard_tb  where webboard_id = '$_GET[id_del]' ";
		$result_delete_webboard = @mysql_query($sql_delete_webboard,$connect);
		
	?>		 <script>
					location.href='new_webboard.php'; //รีเฟสหน้า
			 </script>
	<?php
	}
	
	$sql_webboard = "SELECT * FROM webboard_tb ORDER BY webboard_pin desc, webboard_ranking ";
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
                                        <a href="new_webboard.php">เว็บบอร์ด</a>
                                        
                                   </div>
                                   <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">เว็บบอร์ด</div>
                    </div>
                    <div class="block_style2_content">



                                   		<!--Coppy Module Clear-->
                                        <form method="post" name="myform" action="">
                                        <div class="module_3">
                                            <div class="title">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                                <div class="t"><h2>
                                                <a href="new_webboard.php">เว็บบอร์ด</a> | 
                                                <a href="new_censor.php">กรองคำหยาบ</a>
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
                                        	<li><a href="add_webboard.php"><img alt="Add" src="images/1343378527_add1-.png" title="Add"/> <span style="position:relative; top:-3px;">เพิ่มกระทู้ </span></a></li>                                            
                                            <li><div style="height:20px; width:1px; background:#ccc;"></div></li>
                                            <li>
                                            <input type="hidden" name="save" value="1" />
                                            <input type="image" src="images/save_all_ranking.png" alt="Save Ranking" name="Submit" value="Save" title="Save Ranking" style="width:128px; height:16px;"/> </li>         
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
                                                <div class="cell2">
                                                    กระทู้
                                                </div>
                                                <div class="cell3">
                                                    
                                                </div>
                                            </li>
                                            <!--End Title-->
                                            <?php 
											for($i=1;$i<=intval($num_webboard);$i++){
											$data_webboard =@mysql_fetch_array($result_webboard);
											?>
                                            <li>
                                            	<div class="cell1-news">
                                                    <?php echo $f+$i;?>
                                                </div>
                                                <div class="cell2-news">
                                                    
                                                    <?php if($data_webboard['webboard_pin']=='1'){?>
														<img src="images/pin.png" width="16"/>
													<?php }?>
                                                    <b><?php echo $data_webboard['webboard_head'];?></b>
                                                    <br /><br /><br />
                                                    <?php echo $data_webboard['webboard_title'];?><br /><br />
                                                    <a href="detail.php?webboard_id=<?php echo $data_webboard['webboard_id'];?>&menu=news"><font color="#000000"><b>รายละเอียดกระทู้</b></font></a>
                                                    <!--<a href="detail_news.php?news_id=<?php echo $data_webboard['webboard_id'];?>"><font color="#FF0000">more>></font></a>-->
                                                </div>
                                                <div class="cell3-news">
                                                    <!--Form2-->
                                                   <div class="form2">
                                                        <ul>
                                                        	<li><a href="comment_webboard.php?webboard_id=<?php echo $data_webboard['webboard_id'];?>"><img src="images/1349669326_24-comment-square.png" width="18" /></a></li>
                                                            <li><a href="new_webboard.php?id_del=<?php echo $data_webboard['webboard_id'];?>&amp;sAction=del" onClick="return confirm('Do you want to delete it. (yes/no)')"><img alt="Delete" src="images/1343378039_23-Full Trash.png" title="Delete"/></a></li>
                                                            <li><a href="edit_webboard.php?webboard_id=<?php echo $data_webboard['webboard_id'];?>"><img alt="Edit" src="images/1343377813_Modify.png" title="Edit"/></a></li>
                                                            <li>Ranking</li>
                                                            <li><input name="new_ranking[<?php echo $data_webboard['webboard_id'];?>] " type="text" id="new_ranking " size="3" maxlength="3" value="<?php echo $data_webboard['webboard_ranking'];?>">
                       											<input name="hidden_new_id[<?php echo $data_webboard['webboard_id'];?>] " type="hidden"  value="<?php echo $data_webboard['webboard_id'];?>"></li>
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
