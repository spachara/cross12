<?php
	session_start();
	require_once '../dbconnect.inc';
	
	
	include("class.page_split.php");
	$obj = new page_split();
	$obj->_setPageSize(5);						
	$obj->_setFile("new_fashionblog.php");		
	$obj->_setPage($_GET['page']);		
	if($_GET['page'] > 1){
		$f = 5*($_GET['page']- 1);
	}
	
	if($_SESSION['AUTH_PERMISSION_ID']=='') {
		header("Location:index.php");
	}
	
	if($_POST['save'] == '1'){
		
		if ($_POST['hidden_new_id']) {
			foreach ($_POST['hidden_new_id'] as $v) {

					$update_new_ranking = "UPDATE fashionblog_tb SET fashionblog_ranking = '".$_POST['new_ranking'][$v]."'  ";
					$update_new_ranking .= "WHERE fashionblog_id = '".$_POST[hidden_new_id][$v]."'";
					$update_new_ranking_result = @mysql_query($update_new_ranking, $connect);
					
			}
		}
		?><script>location.href='new_fashionblog.php';</script><?php
	}
	
	if($_GET['sAction'] == 'del'){
		
		$sql_fashionblog_del = "SELECT * FROM fashionblog_tb WHERE fashionblog_id = '".$_GET['id_del']."' ";
		$result_fashionblog_del =@mysql_query($sql_fashionblog_del, $connect);
		$data_fashionblog_del =@mysql_fetch_array($result_fashionblog_del);
		
		//echo $data_fashionblog_del['fashionblog_name_th']."<img src=\"../images/news/".$data_fashionblog_del['fashionblog_pic']."\"><br>";
		
		@unlink('../images/news/'.$data_fashionblog_del['fashionblog_pic']);
		
		$sql_gallery_del = "SELECT * FROM gallery_tb WHERE gallery_type = 'news' AND gallery_type_id = '".$data_fashionblog_del['fashionblog_id']."' ";
		$result_gallery_del =@mysql_query($sql_gallery_del, $connect);
		$num_gallery_del =@mysql_num_rows($result_gallery_del);
		
		for ($g=1; $g<=$num_gallery_del; $g++) {
			$data_gallery_del =@mysql_fetch_array($result_gallery_del);
			
			/*echo "<img src=\"../images/gallery/news/".$data_gallery_del['gallery_pic1']."\"><br>";
			echo "<img src=\"../images/gallery/news/".$data_gallery_del['gallery_pic2']."\"><br>";*/
			
			@unlink('../images/gallery/news/'.$data_gallery_del['gallery_pic1']);
			@unlink('../images/gallery/news/'.$data_gallery_del['gallery_pic2']);
			
			$delete_gallery = "DELETE FROM gallery_tb WHERE gallery_id = '".$data_gallery_del['gallery_id']."' ";
			@mysql_query($delete_gallery);
		}
		
		$delete_news = "DELETE FROM fashionblog_tb WHERE fashionblog_id = '".$data_fashionblog_del['fashionblog_id']."' ";
		@mysql_query($delete_news, $connect);
		
		?><script>location.href='new_fashionblog.php'; //รีเฟสหน้า</script><?php
		
	}
		
	$sql_news = "SELECT * FROM fashionblog_tb ORDER BY fashionblog_ranking ";
	$result_news =@mysql_query($sql_news, $connect);
	$result_news2 =@mysql_query($sql_news, $connect);
	$num_news2 =@mysql_num_rows($result_news2);
	$num_news =@mysql_num_rows($result_news);
	
	if ($_GET['lag']=='th' || $_GET['lag']=='') { $fashionblog_name = "fashionblog_name_th"; $fashionblog_title = "fashionblog_title_th";}
	if ($_GET['lag']=='eng') { $fashionblog_name = "fashionblog_name_eng"; $fashionblog_title = "fashionblog_title_eng";}

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
                    <a href="new_fashionblog.php">Fashion blog</a>
               </div>
               <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">Fashion blog</div>
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
                                   
                                   <div class="right-title">
                                       <div class="form3">
                                            
                                            <ul>                                        	
                                                <li>
                                                    <a href="add_fashionblog.php">
                                                        <img alt="Add" src="images/1343378527_add1-.png" title="Add"/>
                                                        <span style="position:relative; top:-3px;">
                                                                Add Fashion blog
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
                                   <!-- TAB Language -->
                                   <!--<div style="height:30px; text-align:right;">
                                    	<a href="<?php echo $url_type;?>"><strong><?php echo $add_type;?></strong> <img src="images/1343378527_add1-.png" title=""/></a>
                                    </div>-->
                                    <?php if ($_GET['menu']=='') {?>
                                   <div id="tabs" >
                                   
                                          <ul>
                                              <li><a href="#th">THAI</a></li>
                                              <li><a href="#eng">ENG</a></li>
                                          </ul>      
                                                                        
                                   <?php }?>
                                   <!-- END TAB Language -->
                                   
                                   <div id="th" class="content">
                                   	<div class="table_3cell">

                                     	<ul>
                                        	<!--Title-->
                                        	<li class="bg-title">
                                            	<div class="cell1">
                                                    No.
                                                </div>
                                                <div class="cell2" style="width:60%;">
                                                    Fashion blog
                                              </div>
                                                <div class="cell3" style="width:29%;">
                                                    &nbsp;
                                                </div>
                                            </li>
                                            <!--End Title-->
                                            <?php 
											
											for($t=1;$t<=intval($num_news);$t++){
											$data_news =@mysql_fetch_array($result_news);

											?>
                                            
                                            <li>
                                            	<div class="cell1-slidehome" style="height:125px;">
                                                    <?php echo $f+$t;?>
                                                </div>
                                                <!--CELL2-->
                                                <div class="cell2" style="text-align: left; width:60%; height:125px;">
                                                
                                                	<div style="float:left; width:188px; margin-left:10px;">
                                                		<!--<a class="fancybox-buttons" data-fancybox-group="button" href="../images/news/events/<?php echo $data_news['fashionblog_pic'];?>">-->
                                                			<img src="../images/fashionblog/<?php echo $data_news['fashionblog_pic'];?>" width="100" />
                                                		<!--</a>-->
                                                	</div>
                                                    <div style="float:left; margin-left:5px; width:250px;">
                                                    	<span style="font-size:12px;"><?php echo $data_news['fashionblog_name_th'];?></span><br />

                                                    </div>
                                                </div>
                                                <!--END CELL2-->
                                                <div class="cell3-slidehome" style="height:125px; width:29%;">
                                                    <!--Form2-->
                                                   <div class="form2">
                                                        <ul>
                                                        	<li><a href="new_gallery.php?gallery_type_id=<?php echo $data_news['fashionblog_id'];?>&gallery_type=fashionblog"><img alt="Delete" src="images/uimage.jpg" title="Delete"/></a></li>
                                                        
                                                            <li><a href="new_fashionblog.php?id_del=<?php echo $data_news['fashionblog_id'];?>&sAction=del" onClick="return confirm('Do you want to delete it. (yes/no)')"><img alt="Delete" src="images/1343378039_23-Full Trash.png" title="Delete"/></a></li>

                                                            <li><a href="edit_fashionblog.php?fashionblog_id=<?php echo $data_news['fashionblog_id'];?>"><img alt="Edit" src="images/1343377813_Modify.png" title="Edit"/></a></li>
                                                            
                                                            <li>Ranking</li>
                                                            <li><input name="new_ranking[<?php echo $data_news['fashionblog_id'];?>] " type="text" id="new_ranking " size="3" maxlength="3" value="<?php echo $data_news['fashionblog_ranking'];?>">

                       											<input name="hidden_new_id[<?php echo $data_news['fashionblog_id'];?>] " type="hidden"  value="<?php echo $data_news['fashionblog_id'];?>"></li>
                                                        </ul>
                                                   </div>                                   
                                                   <!--End Form2-->
                                                </div>
                                            </li>
                                            <?php } //for show fashionblog_tb ?>
                                        </ul>
                                    </div>
                                    
                                    </div>

                                   <div id="eng" class="content">
                                   	<div class="table_3cell">

                                     	<ul>
                                        	<!--Title-->
                                        	<li class="bg-title">
                                            	<div class="cell1">
                                                    No.
                                                </div>
                                                <div class="cell2" style="width:60%;">
                                                    Fashion blog
                                              </div>
                                                <div class="cell3" style="width:29%;">
                                                    &nbsp;
                                                </div>
                                            </li>
                                            <!--End Title-->
                                            <?php 
											
											for($t2=1;$t2<=intval($num_news);$t2++){
											$data_news2 =@mysql_fetch_array($result_news2);

											?>
                                            
                                            <li>
                                            	<div class="cell1-slidehome" style="height:125px;">
                                                    <?php echo $f+$t2;?>
                                                </div>
                                                <!--CELL2-->
                                                <div class="cell2" style="text-align: left; width:60%; height:125px;">
                                                	<div style="float:left; width:188px; margin-left:10px;">
                                                		<a class="fancybox-buttons" data-fancybox-group="button" href="../images/news/events/<?php echo $data_news2['fashionblog_pic'];?>">
                                                			<img src="../images/fashionblog/<?php echo $data_news2['fashionblog_pic'];?>" width="100" />
                                                		</a>
                                                	</div>
                                                    <div style="float:left; margin-left:5px; width:250px;">
                                                    	<span style="font-size:12px;"><?php echo $data_news2['fashionblog_name_eng'];?></span><br />
                                                    </div>
                                                </div>
                                                <!--END CELL2-->
                                                <div class="cell3-slidehome" style="height:125px; width:29%;">
                                                    <!--Form2-->
                                                   <div class="form2">
                                                        <ul>
                                                            <!--<li><a href="new_fashionblog.php?id_del=<?php echo $data_news2['fashionblog_id'];?>&sAction=del" onClick="return confirm('Do you want to delete it. (yes/no)')"><img alt="Delete" src="images/1343378039_23-Full Trash.png" title="Delete"/></a></li>-->

                                                            <li><a href="edit_fashionblog.php?fashionblog_id=<?php echo $data_news2['fashionblog_id'];?>"><img alt="Edit" src="images/1343377813_Modify.png" title="Edit"/></a></li>
                                                            
                                                            <!--<li>Ranking</li>
                                                            <li><input name="new_ranking[<?php echo $data_news2['fashionblog_id'];?>] " type="text" id="new_ranking " size="3" maxlength="3" value="<?php echo $data_news2['fashionblog_ranking'];?>">

                       											<input name="hidden_new_id[<?php echo $data_news2['fashionblog_id'];?>] " type="hidden"  value="<?php echo $data_news2['fashionblog_id'];?>"></li>-->
                                                        </ul>
                                                   </div>                                   
                                                   <!--End Form2-->
                                                </div>
                                            </li>
                                            <?php } //for show fashionblog_tb ?>
                                        </ul>
                                    </div>
                                    
                                    </div>
                                                                                                            
                                   <!--End ตาราง 3 Cell-->
                                  </div> <!--END TAP-->

                                   
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
                        <div class="page_number">
                            <div class="page_number-right">
                                    <?php //$obj->_displayPage(); ?>
                            </div>
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
