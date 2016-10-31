<?php
	session_start();
	require_once '../dbconnect.inc';
	include("fckeditor/fckeditor.php") ;
	require_once 'process_pic.php';
	
	if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) {
		echo "<script>location.href='index.php'</script>";
	}
	
	if($_POST['Submit'] == 'UPDATE'){
	
			$edit_order = "UPDATE order_tb SET  order_comment = '".$_POST['order_comment']."'";
			$edit_order .= " WHERE order_number = '".$_POST['n']."' ";
			@mysql_query($edit_order, $connect);
				
	?>
				  <script>
					location.href='order_comment.php?n=<?php echo $_POST['n'];?>';
				  </script>
	<?php
	
	}// END CREATE
	
	$sql_order = "SELECT * FROM order_tb WHERE order_number = '".$_GET['n']."' ";
	$result_order =@mysql_query($sql_order, $connect);
	$data_order =@mysql_fetch_array($result_order);
	
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<script language="javascript">
function chk_length(){
	if(document.myform.news_title.value.length > 30){
			var a = document.myform.news_title.value;
			var x = document.getElementById("head_news");
			x.innerHTML="<font color=red size=-1>ไม่ควรใส่อักษรเกิน 30 ตัว</font>";
			a = a.substr(0, 30);
			document.myform.news_title.value = a;
	}else{
			var x = document.getElementById("head_news");
			x.innerHTML="";
	}
}
</script>
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
                                        <a href="order_comment.php">Comment </a>
                                        >
                                        <a href="#"><?php echo $_GET['n'];?></a>
                                   </div>
                                   <!--End Navigator-->            
                                    <form method="post" enctype="multipart/form-data" name="myform">
                                    <!--Block Frame-->
                                    <div class="block_style2">
                                        <div class="block_style2_top">
                                            <div class="block_style2_top-l"></div>
                                            <div class="block_style2_top-r"></div>
                                            <div class="block_style2_top-t">แก้ไขกระทู้</div>
                                        </div>
                                        <div class="block_style2_content">
                                   	<div class="table_3cell">
                                     	<ul>
                                        	<!--Title-->

                                             <li>
                                            	<div class="cell3-text">Comment :</div>
                                                <?php
																											
														$oFCKeditor = new FCKeditor('order_comment');
														$oFCKeditor->BasePath	=  'fckeditor/' ;
														$oFCKeditor->Value		= $data_order['order_comment'] ;
														$oFCKeditor->Create() ;
												?>    
                                                
                                            </li>
                                        	
                                            <!--End Title-->
                                       
                                        </ul>
                                    </div>
                                   <!--End ตาราง 3 Cell-->
                                   
                                    <div class="demo">
                                    
                                    <!--<button>Submit</button>-->
                                    <input type="hidden" name="n" value="<?php echo $_GET['n'];?>"/>
                                   	
									<input name="Submit" type="submit" class="borderfrom" style="width:80px" value="UPDATE">
                                    
                                    </div>
                                    
                                                                       
                                            </div>
                                            <div class="bottom">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                            </div>
                                        </div>
										<!--End Coppy Module Clear-->                                 
                                        
                                      
                                    </form>
                
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
