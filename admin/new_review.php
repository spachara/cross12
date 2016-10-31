<?php
session_start();
require_once '../dbconnect.inc';

include("class.page_split.php");
$obj = new page_split();
$obj->_setPageSize(10);						
$obj->_setFile("new_review.php");		
$obj->_setPage($_GET['page']);		
if($_GET['page'] > 1){
	$f = 100*($_GET['page']- 1);
}

if($_SESSION['AUTH_PERMISSION_ID']=='') {
	header("Location:index.php");
}

$IMG_ROOT="../images/review/";

if($_POST['save'] == '1'){
	if($_POST['hidden_new_id']){
		foreach ($_POST['hidden_new_id'] as $v) {

				$update_new_ranking = "UPDATE review_tb SET ranking = '".$_POST['new_ranking'][$v]."'  ";
				$update_new_ranking .= "WHERE rid = '".$_POST['hidden_new_id'][$v]."'";
				$update_new_ranking_result = @mysql_query($update_new_ranking, $connect);
				
		}
	}
?>		 
		<script>
			location.href='new_review.php?pid=<?php echo $_POST['pid'];?>'; //รีเฟสหน้า
		</script>
<?php
}


if($_GET['sAction'] == 'del'){
	
	$edit_banner = "select picture from review_tb WHERE rid = '".$_GET['id_del']."'";
	$result_banner = @mysql_query($edit_banner, $connect);
	$data_banner =@mysql_fetch_array($result_banner);
	@unlink($IMG_ROOT.$data_banner['picture']);

	$delete_howto = "DELETE FROM review_tb  WHERE rid = '".$_GET['id_del']."' ";
	@mysql_query($delete_howto, $connect);
?>		 
		<script>
			location.href='new_review.php?pid=<?php echo $_GET['pid'];?>'; //รีเฟสหน้า
		</script>
<?php
}


$sql_product = "SELECT * FROM product_tb where pid='".$_GET['pid']."'";
$result_product =@mysql_query($sql_product, $connect);
$data_product =@mysql_fetch_array($result_product);

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
                                     <a href="product.php"><?php echo str_replace('+','',$data_product['name']);?></a> < <a href="new_review.php?rid=<?php echo $data_review['rid'];?>">Review</a>
                                        
                                   </div>
                                   <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t"><a href="product.php"><?php echo str_replace('+','',$data_product['name']);?></a> < Review</div>
                    </div>
                    <div class="block_style2_content">



                                   		<!--Coppy Module Clear-->
                                        <form action="new_review.php" method="post" enctype="multipart/form-data" name="form1">
                                        <div class="module_3">
                                            <div class="title">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                                <div class="t"><h2>
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
                                        <li><a href="add_review.php?pid=<?php echo $data_product['pid'];?>"><img alt="Add" src="images/1343378527_add1-.png" title="Add"/> <span style="position:relative; top:-3px;">Review </span></a></li>                                            
                                            <li><div style="height:20px; width:1px; background:#ccc;"></div></li>
                                        <li>
                                            <input type="hidden" name="pid" value="<?php echo $data_product['pid'];?>" />
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
                                           	  <div class="cell1">ลำดับ</div>
                                              <div class="cell2">Review</div>
                                              <div class="cell3">&nbsp;</div>
                                            </li>
                                            <!--End Title-->
                                            <?php
											$sql_review = "SELECT * FROM review_tb where pid='".$_GET['pid']."' ORDER BY ranking";
											$result_review =$obj->_query($sql_review, $connect);
											$num_review =@mysql_num_rows($result_review);
											
											for($i=1;$i<=intval($num_review);$i++){
											$data_review =@mysql_fetch_array($result_review);
											?>
                                            <li>
                                                <div class="cell1-slidehome" >
                                                    <?php echo $f+$i;?>
                                                </div>
                                               <div class="cell2" style="text-align:left;">
                                                <img src="<?php echo $IMG_ROOT;?><?php echo $data_review['picture'];?>" height="140"/>
                                                </div>	
                                                
                                                <div class="cell3-slidehome" >
                                                    <!--Form2-->
                                                   <div class="form2">
                                                        <ul>
                                                            <li><a href="add_review.php?rid=<?php echo $data_review['rid'];?>&pid=<?php echo $data_review['pid'];?>&amp;sAction=Edit"><img alt="Edit" src="images/1343377813_Modify.png" title="Edit"/></a></li>
                                                            <li><a href="new_review.php?pid=<?php echo $data_review['pid'];?>&id_del=<?php echo $data_review['rid'];?>&amp;sAction=del" onClick="return confirm('Do you want to delete it. (yes/no)')"><img alt="Delete" src="images/1343378039_23-Full Trash.png" title="Delete"/></a></li>
                                                            <li>Ranking</li>
                                                            <li><input name="new_ranking[<?php echo $data_review['rid'];?>] " type="text" id="new_ranking " size="3" maxlength="3" value="<?php echo $data_review['ranking'];?>">
                                                            <input name="hidden_new_id[<?php echo $data_review['rid'];?>] " type="hidden"  value="<?php echo $data_review['rid'];?>"></li>
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
