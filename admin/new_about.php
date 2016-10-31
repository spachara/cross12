<?php
	session_start();
	require_once '../dbconnect.inc';
	include("class.page_split.php");
	$obj = new page_split();
	$obj->_setPageSize(5);						
	$obj->_setFile("new_about.php");		
	$obj->_setPage($_GET['page']);		
	if($_GET['page'] > 1){
		$f = 5*($_GET['page']- 1);
	}
	
	if($_SESSION['AUTH_PERMISSION_ID']=='') {
		header("Location:index.php");
	}
	
	if($_POST['save'] == '1'){
		
			foreach ($_POST['hidden_new_id'] as $v) {

					$update_new_ranking = "UPDATE txt_tb SET txt_ranking = '".$_POST['new_ranking'][$v]."'  ";
					$update_new_ranking .= "WHERE txt_id = '".$_POST['hidden_new_id'][$v]."'";
					$update_new_ranking_result = @mysql_query($update_new_ranking, $connect);
					
			}

	}
	
	if($_POST['save'] == '2'){
		
			foreach ($_POST['hidden_new_id2'] as $v) {

					$update_new_ranking = "UPDATE gallery_tb SET gallery_ranking = '".$_POST['new_ranking2'][$v]."'  ";
					$update_new_ranking .= "WHERE gallery_id = '".$_POST[hidden_new_id2][$v]."'";
					$update_new_ranking_result = @mysql_query($update_new_ranking, $connect);
					
			}

	}
	
	if($_GET['sAction'] == 'del'){
		
		$sql_delete_txt = "DELETE FROM txt_tb  WHERE txt_id = '".$_GET['id_del']."' ";
		@mysql_query($sql_delete_txt, $connect);
		
	?>		 
			<script>
				location.href='new_about.php?txt_tb=<?php echo $_GET['txt_tb'];?>'; //รีเฟสหน้า
			 </script>
	<?php
	}
	
	if($_GET['sAction'] == 'del2'){
		
		$sql_gallery_del = "SELECT * FROM gallery_tb WHERE gallery_id = '".$_GET['id_del2']."' ";
		$result_gallery_del =@mysql_query($sql_gallery_del, $connect);
		$data_gallery_del =@mysql_fetch_array($result_gallery_del);
		//echo $data_gallery_del['gallery_pic1']."<br>".$data_gallery_del['gallery_pic2'];
		@unlink("../images/gallery_/about/".$data_gallery_del['gallery_pic1']);	
		@unlink("../images/gallery_/about/".$data_gallery_del['gallery_pic2']);	

		$sql_delete_gallery = "DELETE FROM gallery_tb  WHERE gallery_id = '".$_GET['id_del2']."' ";
		@mysql_query($sql_delete_gallery, $connect);
		
	?>		 
			<script>
				location.href='new_about.php?menu=gallery'; //รีเฟสหน้า
			 </script>
	<?php
	}
	

$sql_txt = "SELECT * FROM txt_tb WHERE type_name = '".$_GET['txt_tb']."'";
$result_txt =@mysql_query($sql_txt, $connect);
$data_txt =@mysql_fetch_array($result_txt);


if($_GET['txt_tb'] == 'deliveryproduct'){
	$title = "Delivery";
	$ab_text = "Delivery";
}elseif($_GET['txt_tb'] == 'return'){
	$title = "Return & Exchanges";
	$ab_text = "Return & Exchanges";
}elseif($_GET['txt_tb'] == 'Howto'){
	$title = "How to order";
	$ab_text = "How to order";
}elseif($_GET['txt_tb'] == 'Payment'){
	$title = "Payment & Delivery";
	$ab_text = "Payment & Delivery";
}elseif($_GET['txt_tb'] == 'Delivery'){
	$title = "Delivery";
	$ab_text = "Delivery";
}elseif($_GET['txt_tb'] == 'Banking'){
	$title = "Banking";
	$ab_text = "Banking";
}elseif($_GET['txt_tb'] == 'qa'){
	$title = "คำถามที่พบบ่อย";
	$ab_text = "คำถามที่พบบ่อย";
}elseif($_GET['txt_tb'] == 'event'){
	$title = "กิจกรรมส่วนลด สมาชิก";
	$ab_text = "กิจกรรมส่วนลด สมาชิก";
}elseif($_GET['txt_tb'] == 'Press'){
	$title = "สื่อประชาสัมพันธ์";
	$ab_text = "สื่อประชาสัมพันธ์";
}elseif($_GET['txt_tb'] == 'condition'){
	$title = "เงื่อนไงและข้อตกลง";
	$ab_text = "เงื่อนไงและข้อตกลง";
}elseif($_GET['txt_tb'] == 'careers'){
	$title = "ร่วมงานกับเรา";
	$ab_text = "ร่วมงานกับเรา";
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
	<script src="jquery_ui/development-bundle/ui/jquery.ui.tabs.js"></script>
	<link rel="stylesheet" href="jquery_ui/development-bundle/demos/demos.css">
	<script>
	$(function() {
		$( "input:submit, a, button", ".demo" ).button();
		$( "a", ".demo" ).click(function() { return false; });
	});
	$(function() {
		$( "#tabs" ).tabs();
		
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
                                        <a href="#"><?php echo $title;?></a>
                                        
                                   </div>
                                   <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r">                            
                        
                        <div style="width:130px; float:right; text-align:right;border:1 px solid #F00; position:relative; z-index:99999;top:5px; left:-20px;">
                                
                                <a href="edit_menu.php?type_name=<?php echo $_GET['txt_tb'];?>">
                                    <img src="images/1343377813_Modify.png" />
                                    <b>Edit</b>
                                </a>
                                
                         </div>
                        </div>
                        <div class="block_style2_top-t"><?php echo $ab_text;?></div>
                    </div>
                    <div class="block_style2_content">



                              <form method="post" enctype="multipart/form-data" name="myform">

	                               <div class="page_conten_r">
                                   
                                    <div class="module_3" >
                                   	<div class="table_3cell-no_border">
                                     	<ul>
                                        	
											<div id="tabs" style="overflow:hidden;">
                                            <ul>
                                                <li><a href="#th" id="type_th">THAI</a></li>
                                                <li><a href="#eng" id="type_eng">ENGLISH</a></li>
                                            </ul>
                                            <div id="th" class="content" style="border:none;">
                                              <div class="cell3-input_textarea2"> 
												<?php echo $data_txt['txt_detail_th'];?>
                                              </div>
                                            </div>
                                            <div id="eng" class="content" style="border:none;">

                                               <div class="cell3-input_textarea2"> 
												<?php echo $data_txt['txt_detail_eng'];?>
                                              </div>

                                       		</div>
                                                                                        
                                       </ul>
                                    </div>
                                   <!--End ตาราง 3 Cell-->
                                     </div>                                   
                                </div>
                                		<div class="bottom">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                       </div>
                                   <!--End Coppy Module Clear-->                                 
                                        
                                                                                                                                               
                                </form>

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
