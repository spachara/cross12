<?php
session_start();
require_once '../dbconnect.inc';

include("class.page_split.php");
$obj = new page_split();
$obj->_setPageSize(100);						
$obj->_setFile("best.php");		
$obj->_setPage($_GET['page']);		
if($_GET['page'] > 1){
	$f = 100*($_GET['page']- 1);
}

if($_SESSION['AUTH_PERMISSION_ID']=='') {
	header("Location:index.php");
}


if($_POST['save'] == '1'){
	
	if($_POST['hidden_new_id']){
		foreach ($_POST['hidden_new_id'] as $v) {

				$update_new_ranking = "UPDATE product_tb SET best = '".$_POST['new_ranking'][$v]."',best_ranking = '".$_POST['new_ranking2'][$v]."'  ";
				$update_new_ranking .= "WHERE p_color = '".$_POST['hidden_new_color'][$v]."' and p_code = '".$_POST['hidden_new_code'][$v]."'";
				$update_new_ranking_result = @mysql_query($update_new_ranking, $connect);
				
				//echo $update_new_ranking."<br><br>";
				
		}

	}
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
          <?php //include('mainmenu.php');?>
            <!--End Main Menu
            <div class="content_r">-->

                <!--Edit Navigator-->
               <div class="navigator">
                <a href="new_webboard.php">Home</a> |  <a href="best.php">Best Seller</a>
                    
               </div>
               <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">Best Seller</div>
                    </div>
                    <div class="block_style2_content">



                                   		<!--Coppy Module Clear-->
                                        <form action="best.php" method="post" enctype="multipart/form-data" name="form1">
                                        <div class="module_3">
                                            <div class="conten">
                                                <!--ใสข้อมูล ตรงนี้-->
                                                <!--ตาราง 3 Cell-->
                                   <div class="title-top">
                                   <div class="right-title">
                                   <div class="form3">
                                   		
                                        <ul><li>
                                            <input type="hidden" name="save" value="1" />
                                            <input type="image" src="images/save_all.png" alt="Save Ranking" name="Submit" value="Save" title="Save Ranking" style="width:56px; height:16px;"/> </li>         
                                        </ul>
                                        
                                   </div>
                                   </div>
                                   
                                   </div>
                                        
                                        

                                    <table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_3cell">
                                      <tr>
                                        <td width="14%" height="25" align="center" bgcolor="#CCCCCC">ลำดับ</td>
                                        <td width="17%" align="center" bgcolor="#CCCCCC">Category</td>
                                        <td width="17%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
                                        <td width="17%" align="center" bgcolor="#CCCCCC">รหัสสินค้า</td>
                                        <td width="18%" align="center" bgcolor="#CCCCCC">สี</td>
                                        <td width="17%" bgcolor="#CCCCCC">&nbsp;</td>
                                      </tr>
									<?php
                                    if($_POST['Search_code'] != '' ){
                                    $sql_product = "SELECT * FROM product_tb where ranking not in ('','0') and p_code like '".$_POST['Search_code']."%' GROUP BY p_color, p_code ORDER BY best desc, best_ranking desc, p_code asc";
                                    }else{
                                    $sql_product = "SELECT * FROM product_tb where ranking not in ('','0') GROUP BY p_color, p_code  ORDER BY best desc, best_ranking desc, p_code asc";
                                    }
                                    $result_product =$obj->_query($sql_product, $connect);
                                    $num_product =@mysql_num_rows($result_product);
                                    
                                    for($i=1;$i<=intval($num_product);$i++){
                                    $data_product =@mysql_fetch_array($result_product);
									
								    $chk_pic1 = "../images/products/".$data_product['p_code']."/".$data_product['p_color']."/s.jpg";
                                    ?>
                                      <tr>
                                        <td height="25" align="center" bgcolor="#F5F5F5"><?php echo $f+$i;?></td>
                                        <td align="center" bgcolor="#F5F5F5"><?php echo $data_product['p_category']; ?></td>
                                        <td align="center" bgcolor="#F5F5F5">
                                        <img alt="<?php echo $data_product['p_name'];?>" title="<?php echo $data_product['p_name'];?>" src="<?php echo $chk_pic1;?>" height="80" />
                                        </td>
                                        <td align="center" bgcolor="#F5F5F5"><a href="stock.php?code=<?php echo $data_product['p_code'];?>&color=<?php echo $data_product['p_color']; ?>" style="text-decoration:underline"><?php echo $data_product['p_code'];?></a></td>
                                        <td align="center" bgcolor="#F5F5F5">
										<?php 
										$product_color = "select name from color_tb where c_code = '".$data_product['p_color']."' ";
										$result_productcolor = @mysql_query($product_color, $connect);
										$data_productcolor =@mysql_fetch_array($result_productcolor);

										echo $data_productcolor['name']; ?></td>
                                        <td bgcolor="#F5F5F5">
                                        Best Seller
                                        <input name="new_ranking[<?php echo $data_product['pid'];?>] " type="checkbox" id="new_ranking" value="1" <?php echo ( $data_product['best'] ? "checked=checked" : "");?>>
                                        
                                        Ranking 
                                        <input name="new_ranking2[<?php echo $data_product['pid'];?>] " type="text" id="new_ranking2" size="3" maxlength="3" value="<?php echo $data_product['best_ranking'];?>">
                                        <input name="hidden_new_id[<?php echo $data_product['pid'];?>] " type="hidden"  value="<?php echo $data_product['pid'];?>">
                                        <input name="hidden_new_code[<?php echo $data_product['pid'];?>] " type="hidden"  value="<?php echo $data_product['p_code'];?>">
                                        <input name="hidden_new_color[<?php echo $data_product['pid'];?>] " type="hidden"  value="<?php echo $data_product['p_color'];?>">
                                        
                                        </li>
                                        </td>
                                      </tr>
                                            <? } ?>
                                    </table>
                                        
                                        
                                        
                                   <!--End ตาราง 3 Cell-->

                                	<!-- -->
                                  	<div class="page_number">
                                    	<div class="page_number-right">
                                        <br />
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

      <!--</div>-->
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
