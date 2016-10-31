<?php
	session_start();
	require_once '../dbconnect.inc';
	
	include("class.page_split.php");
	$obj = new page_split();
	$obj->_setPageSize(1);						
	$obj->_setFile("comment_inbox.php");		
	$obj->_setPage($_GET['page']);		
	if($_GET['page'] > 1){
		$f = 1*($_GET['page']- 1);
	}
	
	include("fckeditor/fckeditor.php") ;
	
	if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) {
		echo "<script>location.href='index.php'</script>";
	}
	
	
	
	if($_POST['Submit']=='EDIT'){

		$sql_answer_webboard = "UPDATE inbox_answer_tb SET answer_detail = '".$_POST['webboard_detail']."'";
		$sql_answer_webboard .= " where answer_id = '".$_GET['ans_id']."'";
		@mysql_query($sql_answer_webboard, $connect);
		?>
		<script>location.href='comment_inbox.php?webboard_id=<?php echo $_GET['webboard_id'];?>';</script>
        <?php

	}

	if($_POST['Submit']=='ANSWER' && $_POST['webboard_detail']!=""){
		/*echo "<script>alert('ANSWER');</script>";*/
		
		$sql_answer_webboard = "INSERT INTO inbox_answer_tb (answer_id, webboard_id, u_id, answer_detail, date_in)";
		$sql_answer_webboard .= "VALUES(NULL, '".$_POST['webboard_id']."', '0', '".$_POST['webboard_detail']."', NOW() )";
		@mysql_query($sql_answer_webboard, $connect);
		
		$sql_webboard = "UPDATE inbox_tb SET webboard_title = '1'";
		$sql_webboard .= " where webboard_id = '".$_POST['webboard_id']."'";
		@mysql_query($sql_webboard, $connect);
		
		
		?>
		<script>location.href='comment_inbox.php?webboard_id=<?php echo $_GET['webboard_id'];?>';</script>
        <?php
	}
	
	
	if($_GET['sAction'] == 'del'){
	
		$sql_delete_slide = "delete from inbox_answer_tb  where answer_id = '$_GET[id_del]' ";
		$result_delete_slide = @mysql_query($sql_delete_slide,$connect);
		
	?>		 <script>
					location.href='new_inbox.php'; //รีเฟสหน้า
			 </script>
	<?php
	}
	
if ($_GET['webboard_id'] != "") {	
	$sql_answer = "SELECT * FROM inbox_answer_tb WHERE webboard_id = '".$_GET['webboard_id']."' ORDER BY answer_id desc";
} else if ($_GET['webboard_id'] == "") {
	$sql_answer_u = "SELECT * FROM inbox_answer_tb WHERE u_id = '".$_GET['u_id']."' ORDER BY answer_id desc";
	$result_answer_u =@mysql_query($sql_answer_u, $connect);
	$data_answer_u =@mysql_fetch_array($result_answer_u);
	
	$sql_answer = "SELECT * FROM inbox_answer_tb WHERE webboard_id = '".$data_answer_u['webboard_id']."' ORDER BY answer_id desc";
}
$result_answer =@mysql_query($sql_answer,$connect);
$num_answer =@mysql_num_rows($result_answer);

$result_answer2 =@mysql_query($sql_answer,$connect);
$data_answer2 =@mysql_fetch_array($result_answer2);


$sql_webboard = "SELECT * FROM inbox_tb WHERE webboard_id = '".$data_answer2['webboard_id']."' ";
$result_webboard =@mysql_query($sql_webboard, $connect);
$data_webboard =@mysql_fetch_array($result_webboard);


$sql_ans = "SELECT * FROM inbox_answer_tb WHERE answer_id = '".$_GET['ans_id']."' ";
$result_ans =@mysql_query($sql_ans, $connect);
$data_ans =@mysql_fetch_array($result_ans);
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
                                        <a href="new_inbox.php">Inbox</a> >
                                        <a href="#">ความคิดเห็นกระทู้ <?php echo $data_webboard['webboard_head'];?></a>
                                        
                                   </div>
                                   <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">ความคิดเห็นกระทู้ <?php echo $data_webboard['webboard_head'];?></div>
                    </div>
                    <div class="block_style2_content">



                                   		<!--Coppy Module Clear-->
                                        <form method="post" name="myform" action="">
                                        <input type="hidden" name="webboard_id" value="<?php echo $data_webboard['webboard_id'];?>" />
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

                                   </div>
                                   
                                   </div>
                                   <form name="form1" method="post">
                                   	<?php
																								
											$oFCKeditor = new FCKeditor('webboard_detail');
											$oFCKeditor->BasePath	=  'fckeditor/' ;
											$oFCKeditor->Value		= $data_ans['answer_detail'] ;
											$oFCKeditor->Create() ;
									?> 
                                    <div class="demo">
                                    <?php
                                    if($_GET['sAction'] =='EDIT'){
									?>
                                    	<input name="Submit" type="submit" class="borderfrom" style="width:80px" value="EDIT">
                                    <?php }else{ ?>
                                    	<input name="Submit" type="submit" class="borderfrom" style="width:80px" value="ANSWER">
                                    <?php } ?>
                                    </div>
                                    
                                    </form>
                                    <br />
                                        	<?php for($com=1;$com<=intval($num_answer);$com++){
														$data_answer =@mysql_fetch_array($result_answer);	
														$date = $data_answer['date_in'];
														$day = date('d',strtotime($date));
														$month = date('m',strtotime($date));
														$year = date('Y',strtotime($date));
														$hour = date('H',strtotime($date));
														$minute = date('i',strtotime($date));
														$second = date('s',strtotime($date));
														
														if($data_answer['u_id']!='0'){														
														$sql_user = "SELECT * FROM user_tb WHERE u_id = '".$data_answer['u_id']."' ";
														$result_user =@mysql_query($sql_user, $connect);
														$data_user =@mysql_fetch_array($result_user);
														
															$user = $data_user['u_fname']." ".$data_user['u_lname'];
														}
														if($data_answer['u_id']=='0'){
															$user = "ADMIN";
														}
											?>
                                    <div class="table_3cell" style="color:<?php echo $data_answer['u_id'] == 0 ? "#6CF;" : "#F9C;" ;?>">
                                     	<ul>
                                                <?php if($data_answer['u_id']== 0){?>
                                                <div class="edit">                                              
                                                <a href="comment_inbox.php?id_del=<?php echo $data_answer['answer_id'];?>&amp;sAction=del" onClick="return confirm('Do you want to delete it. (yes/no)')"><img alt="Delete" src="images/1343378039_23-Full Trash.png" title="Delete"/></a>
                                                </div>
                                                <div class="edit">
                                                <li><a href="comment_inbox.php?ans_id=<?php echo $data_answer['answer_id'];?>&webboard_id=<?php echo $_GET['webboard_id'];?>&amp;sAction=EDIT"><img alt="Edit" src="images/1343377813_Modify.png" title="Edit"/></a></li>
                                                </div><? } ?>
                                                <br />
                                                
                                            <?php 
												echo "<b>วันที่ ".$day."/".$month."/".$year." เวลา ".$hour.":".$minute.":".$second." น. </b><br><br>";
												echo "ความคิดเห็นจาก <b>".$user."</b><br><br>";
												echo $data_answer['answer_detail']."<br>&nbsp;";
											?>
                                        </ul>
                                    </div>    
                                            <?php }?>
                                        
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
