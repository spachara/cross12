<?php
	session_start();
	require_once '../dbconnect.inc';

	if($_SESSION['AUTH_PERMISSION_ID']=='') {
		header("Location:index.php");
	}
	
	if($_POST['save'] == '1'){
		
			foreach ($_POST['hidden_new_id'] as $v) {

					$update_new_ranking = "UPDATE gallery_tb SET gallery_ranking = '".$_POST['new_ranking'][$v]."'  ";
					$update_new_ranking .= "WHERE gallery_id = '".$_POST[hidden_new_id][$v]."'";
					$update_new_ranking_result = @mysql_query($update_new_ranking, $connect);
					
			}
			?><script>location.href='new_gallery.php?gallery_type_id=<?php echo $_GET['gallery_type_id'];?>&gallery_type=<?php echo $_GET['gallery_type'];?>';</script><?php
	}

	
	if($_GET['sAction'] == 'del'){
		

		if ($_GET['gallery_type']=='fashionblog') { $gallery_type = "fashionblog";}
		
		$sql_gallery_del = "SELECT * FROM gallery_tb WHERE gallery_id = '".$_GET['id_del']."' ";
		$result_gallery_del =@mysql_query($sql_gallery_del, $connect);
		$data_gallery_del =@mysql_fetch_array($result_gallery_del);
		//echo $data_gallery_del['gallery_pic1']."<br>".$data_gallery_del['gallery_pic2'];
		@unlink("../images/gallery/".$gallery_type."/".$data_gallery_del['gallery_pic1']);	
		@unlink("../images/gallery/".$gallery_type."/".$data_gallery_del['gallery_pic2']);	
		//echo "<img src=../images/gallery/".$gallery_type."/".$data_gallery_del['gallery_pic1'].">";
		$sql_delete_gallery = "DELETE FROM gallery_tb  WHERE gallery_id = '".$_GET['id_del']."' ";
		@mysql_query($sql_delete_gallery, $connect);
		
	?>		 
			<script>
				location.href='new_gallery.php?gallery_type_id=<?php echo $_GET['gallery_type_id'];?>&gallery_type=<?php echo $_GET['gallery_type'];?>'; //รีเฟสหน้า
			 </script>
	<?php
	}
	
if ($_GET['gallery_type_id']=='') {
	$type_id = '1';
} else if ($_GET['gallery_type_id']!='') {
	$type_id = $_GET['gallery_type_id'];	
}
	
$sql_gallery = "SELECT * FROM gallery_tb WHERE gallery_type = '".$_GET['gallery_type']."' AND gallery_type_id = '".$type_id."' ORDER BY gallery_ranking ";
$result_gallery =@mysql_query($sql_gallery, $connect);
$num_gallery =@mysql_num_rows($result_gallery);

if ($_GET['gallery_type']=='fashionblog') {
	$type_name = "fashionblog"; //พาทที่อยู่รูป
	$nav_name = "Fashion blog";
	$nav_url = "new_fashionblog.php";
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

<!--Fancy Box-->
<!--<script type="text/javascript" src="../js/fancy_box/jquery-1.8.2.min.js"></script>-->
<script type="text/javascript" src="../js/fancy_box/jquery.fancybox.js"></script>
<link rel="stylesheet" type="text/css" href="../css/fancy_box/jquery.fancybox.css?v=2.1.2" media="screen" />
	
<link rel="stylesheet" type="text/css" href="../css/fancy_box/jquery.fancybox-buttons.css" />
<script type="text/javascript" src="../js/fancy_box/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="../js/fancy_box/button-helper.js"></script>
<style type="text/css">
	.fancybox-custom .fancybox-skin {
		box-shadow: 0 0 50px #222;
	}
</style>    
<!--End Fancy Box-->

<!-- TAB -->
<link rel="stylesheet" type="text/css" href="tab_css.css" />
<!--<script src="../js/tabify/jquery.js" type="text/javascript" charset="utf-8"></script>-->
<script src="../js/tabify/jquery.tabify.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	// <![CDATA[
		
	$(document).ready(function () {
		$('#menu').tabify();
		$('#menu2').tabify();
	});
			
	// ]]>
</script>
<!-- END TAB -->
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

                                        <a href="<?php echo $nav_url;?>"><?php echo $nav_name;?></a> > <a href="#">Gallery <?php echo $nav_name;?></a>

                                   </div>
                                   <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">Gallery <?php echo $nav_name;?></div>
                    </div>
                    <div class="block_style2_content">



                                   		<!--Coppy Module Clear-->
                                        <form method="post" name="myform" action="">
                                        <div class="module_3">
                                            <div class="title">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                                <div class="t">
                                                </div>
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
                                                <li>
                                                    <a href="add_gallery.php?gallery_type_id=<?php echo $_GET['gallery_type_id'];?>&gallery_type=<?php echo $_GET['gallery_type'];?>">
                                                        <img alt="Add" src="images/1343378527_add1-.png" title="Add"/>
                                                        <span style="position:relative; top:-3px;">
                                                                Add Gallery <?php echo $nav_name;?>
                                                        </span>
                                                    </a>
                                                </li>                                            
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
                                                    No.
                                                </div>
                                                <div class="cell2">
                                                    Gallery
                                                </div>
                                                <div class="cell3">
                                                    &nbsp;
                                                </div>
                                            </li>
                                            <!--End Title-->
                                            <?php for($b=1;$b<=intval($num_gallery);$b++){
														$data_gallery =@mysql_fetch_array($result_gallery);
											?>
                                            <li>
                                            	<div class="cell1-slidehome" style="height:200px;">
                                                    <?php echo $f+$b;?>
                                                </div>
                                                <div class="cell2" style="text-align:left; height:200px;">

                                                        <img src="../images/gallery/<?php echo $type_name;?>/<?php echo $data_gallery['gallery_pic1'];?>" width="100"/>
                                                        <img src="../images/gallery/<?php echo $type_name;?>/<?php echo $data_gallery['gallery_pic2'];?>"  height="170" />

                                              </div>
                                                <div class="cell3-slidehome" style="height:200px;">
                                                    <!--Form2-->
                                                   <div class="form2">
                                                        <ul>
                                                        
                                                        
                                                            <li><a href="new_gallery.php?id_del=<?php echo $data_gallery['gallery_id'];?>&sAction=del&gallery_type_id=<?php echo $_GET['gallery_type_id'];?>&gallery_type=<?php echo $_GET['gallery_type'];?>" onClick="return confirm('Do you want to delete it. (yes/no)')"><img alt="Delete" src="images/1343378039_23-Full Trash.png" title="Delete"/></a></li>

                                                            <!--<li><a href="edit_gallery.php?gallery_id=<?php echo $data_gallery['gallery_id'];?>&type_name=<?php echo $data_gallery['type_name'];?>&type_id=<?php echo $data_gallery['type_id'];?>"><img alt="Edit" src="images/1343377813_Modify.png" title="Edit"/></a></li>-->
                                                            
                                                            <li>Ranking</li>
                                                            <li><input name="new_ranking[<?php echo $data_gallery['gallery_id'];?>] " type="text" id="new_ranking " size="3" maxlength="3" value="<?php echo $data_gallery['gallery_ranking'];?>">
                       											<input name="hidden_new_id[<?php echo $data_gallery['gallery_id'];?>] " type="hidden"  value="<?php echo $data_gallery['gallery_id'];?>"></li>
                                                        </ul>
                                                   </div>                                   
                                                   <!--End Form2-->
                                                </div>
                                            </li>
                                            <?php } //for menu = ''?>
                                         
                                            
                                        </ul>
                                    </div>
   
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
