<?php
	session_start();
	require_once '../dbconnect.inc';
	include("fckeditor/fckeditor.php") ;
	require_once 'process_pic.php';
	
	if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) {
		echo "<script>location.href='index.php'</script>";
	}
	
	if($_POST['Submit'] == 'CREATE'){
	
			$add_webboard = "INSERT INTO webboard_tb (webboard_id, webboard_pin, webboard_head, webboard_title, webboard_detail, date_in)";
			$add_webboard .= "VALUES(NULL, '".$_POST['webboard_pin']."', '".$_POST['webboard_head']."', '".$_POST['webboard_title']."', '".$_POST['webboard_detail']."', NOW() )";
			@mysql_query($add_webboard, $connect);
				
	?>
				  <script>
					location.href='new_webboard.php';
				  </script>
	<?php
	
	}// END CREATE
	
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
                                        <a href="new_webboard.php">เว็บบอร์ด</a>
                                        >
                                        <a href="#">เพิ่มกระทู้</a>
                                   </div>
                                   <!--End Navigator-->            
                                    <form method="post" enctype="multipart/form-data" name="myform">
                                    <!--Block Frame-->
                                    <div class="block_style2">
                                        <div class="block_style2_top">
                                            <div class="block_style2_top-l"></div>
                                            <div class="block_style2_top-r"></div>
                                            <div class="block_style2_top-t">เพิ่มกระทู้</div>
                                        </div>
                                        <div class="block_style2_content">
                                   	<div class="table_3cell">
                                     	<ul>
                                        	<!--Title-->
                                            <li>
                                            	<div class="cell3-text">ปักหมุด :</div>
                                                <div class="cell3-input">
                                                <input name="webboard_pin" type="radio" id="webboard_pin" value="0" checked="checked"/>ปิด
                                                <input name="webboard_pin" type="radio" id="webboard_pin" value="1" />เปิด
                                                </div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">ชื่อกระทู้ :</div>
                                                <div class="cell3-input"><input name="webboard_head" type="text" id="webboard_head"  /></div>
                                            </li>
                                         	<li>
                                            	<div class="cell3-text">หัวข้อกระทู้ :</div>
                                                <div class="cell3-input_textarea">
                                                  <textarea name="webboard_title" cols="30" rows="5" id="webboard_title"></textarea>
                                                  <span id="head_news"></span>
                                                </div>
                                            </li>
                                             <li>
                                            	<div class="cell3-text">รายละเอียดกระทู้ :</div>
                                                <?php
																											
														$oFCKeditor = new FCKeditor('webboard_detail');
														$oFCKeditor->BasePath	=  'fckeditor/' ;
														$oFCKeditor->Value		= $value ;
														$oFCKeditor->Create() ;
												?>    
                                                
                                            </li>
                                        	
                                            <!--End Title-->
                                       
                                        </ul>
                                    </div>
                                   <!--End ตาราง 3 Cell-->
                                   
                                    <div class="demo">
                                    
                                    <!--<button>Submit</button>-->
                                   	
									<input name="Submit" type="submit" class="borderfrom" style="width:80px" value="CREATE">
                                    
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
