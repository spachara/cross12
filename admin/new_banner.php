<?php
	session_start();
	require_once '../dbconnect.inc';
	include("class.page_split.php");
	$obj = new page_split();
	$obj->_setPageSize(5);						
	$obj->_setFile("new_banner.php?banner_type=".$_GET['banner_type']);		
	$obj->_setPage($_GET['page']);		
	if($_GET['page'] > 1){
		$f = 5*($_GET['page']- 1);
	}

	if($_SESSION['AUTH_PERMISSION_ID']=='') {
			echo "<script>window.location.href='index.php';</script>";
	}
	
	if($_POST['save'] == '1'){
		
			foreach ($_POST['hidden_new_id'] as $v) {

					$update_new_ranking = "UPDATE banner_tb SET ranking= '".$_POST['new_ranking'][$v]."'  ";
					$update_new_ranking .= "WHERE bid = '".$_POST[hidden_new_id][$v]."'";
					$update_new_ranking_result = @mysql_query($update_new_ranking, $connect);
					
			}
			
			

	}
	
	
	


	if($_GET['sAction'] == 'del'){

		$sql_banner_del = "SELECT * FROM banner_tb WHERE bid = '".$_GET['id_del']."' ";
		$result_banner_del =@mysql_query($sql_banner_del, $connect);
		$data_banner_del =@mysql_fetch_array($result_banner_del);

		@unlink("../banner/".$data_banner_del['picture']);	

		$sql_delete_banner = "DELETE FROM banner_tb  WHERE bid = '".$_GET['id_del']."' ";
		@mysql_query($sql_delete_banner, $connect);
		

	?><script>window.location.href='new_banner.php'; //รีเฟสหน้า</script><?
	
}
	$sql_banner = "SELECT * FROM banner_tb ORDER BY ranking";
	$result_banner =@mysql_query($sql_banner, $connect);
	$num_banner =@mysql_num_rows($result_banner);
		
	$IMG_ROOT="../banner/";
	$banner_name = "Header banner";
	


	
	

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

                                        <a href="new_banner.php"><?php echo $banner_name;?></a>

                                   </div>
                                   <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">
                        <?php echo $banner_name;?>
                        </div>
                    </div>
                    <div class="block_style2_content">



                                   		<!--Coppy Module Clear-->
                                        <form method="post" name="myform" action="">
                                        <div class="module_3">
                                            <div class="title">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                                <div class="t"><h2>&nbsp;</h2></div>
                                                <div class="bt">
                                                	 
                                                </div>
                                            </div>
                                            <div class="conten">
                                                <!--ใสข้อมูล ตรงนี้-->
                                                <!--ตาราง 3 Cell-->
                                   <div class="title-top">
                                  	Banner
                                   <div class="right-title">
                                   
                                   
                                   
                                   
                                       <div class="form3">
                                            
                                            <ul>                                        	
                                                <li>
                                                    <a href="add_banner.php">
                                                        <img alt="Add" src="images/1343378527_add1-.png" title="Add"/>
                                                        <span style="position:relative; top:-3px;">
                                                         Add Slide
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
                                                    Banner
                                                </div>
                                                <div class="cell3">
                                                    &nbsp;
                                                </div>
                                            </li>
                                            <!--End Title-->
                                            
                                            
                                              
                                            <?php 
											
											for($b=1;$b<=intval($num_banner);$b++){
											$data_banner =@mysql_fetch_array($result_banner);
											$id = $data_banner['bid'];
											?>
                                            
                                           
                                            <li>
                                            	<div class="cell1-slidehome" >
                                                    <?php echo $f+$b;?>
                                                </div>
                                                <div class="cell2" style="text-align:left;">
                                                <?php if($data_banner['picture']){?>
                                                
                                                <a class="fancybox-buttons" data-fancybox-group="button" href="<?php echo $IMG_ROOT;?><?php echo $data_banner['picture'];?>">
                                                	<img src="<?php echo $IMG_ROOT;?><?php echo $data_banner['picture'];?>" height="100"/>

                                                </a>
                                                <?php
												}
												
												
												echo "<br>URL : ".$data_banner['url'];
												
												?>
                                                </div>
                                                
                                                <div class="cell3-slidehome" >
                                                    <!--Form2-->
                                                   <div class="form2">
                                                        <ul>
                                                            
                                                           <li><a href="new_banner.php?id_del=<?php echo $data_banner['bid'];?>&sAction=del" onClick="return confirm('Do you want to delete it. (yes/no)')"><img alt="Delete" src="images/1343378039_23-Full Trash.png" title="Delete"/></a></li>
                                                             
                                                           <li><a href="add_banner.php?bid=<?php echo $data_banner['bid'];?>&amp;sAction=Edit"><img alt="Edit" src="images/1343377813_Modify.png" title="Edit"/></a></li>
                                                           
                                                            
                                                            <li>Ranking</li>
                                                            <li><input name="new_ranking[<?php echo $data_banner['bid'];?>] " type="text" id="new_ranking " size="3" maxlength="3" value="<?php echo $data_banner['ranking'];?>">
                                                            <input name="hidden_new_id[<?php echo $data_banner['bid'];?>] " type="hidden"  value="<?php echo $data_banner['bid'];?>"></li>
                                                        </ul>
                                                   </div>                                   
                                                   <!--End Form2-->
                                                </div>
                                            </li>
                                           
                                            <?php } ?>
                                            
                                            
                                            
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
<?php 

function date_from_db($date_db){
	
	$d_from = date('d',strtotime($date_db));
	$m_from = date('m',strtotime($date_db));
	$y_from = date('Y',strtotime($date_db))+543;
	$h_from = date('H',strtotime($date_db));
	$mm_from = date('i',strtotime($date_db));
	$s_from = date('s',strtotime($date_db));
	
	return $d_from."-".$m_from."-".$y_from." ".$h_from.":".$mm_from.":".$s_from;
}
?>