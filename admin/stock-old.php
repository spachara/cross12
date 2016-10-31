<?php
session_start();
require_once '../dbconnect.inc';

include("class.page_split.php");
$obj = new page_split();
$obj->_setPageSize(100);						
$obj->_setFile("new_color.php");		
$obj->_setPage($_GET['page']);		
if($_GET['page'] > 1){
	$f = 100*($_GET['page']- 1);
}

if($_SESSION['AUTH_PERMISSION_ID']=='') {
	header("Location:index.php");
}


if($_POST['save'] == '1'){


			
		$edit_product2 = "UPDATE product_tb SET p_spare = '".$_POST['p_spare']."'";
		$edit_product2 .= " where p_code = '".$_POST['p_code']."' and p_color = '".$_POST['p_color']."'";
		@mysql_query($edit_product2, $connect);
		//echo $edit_product2;
		

?>		 
		<script>
			location.href='stock.php?code=<?php echo $_POST['p_code'];?>&color=<?php echo $_POST['p_color'];?>'; //รีเฟสหน้า
		</script>
<?php
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
          <?php include('mainmenu.php');?>
            <!--End Main Menu-->
            <div class="content_r">
            
                                	<!--Edit Navigator-->
                                   <div class="navigator">
                                     <a href="product.php">Product</a>
                                        
                                   </div>
                                   <!--End Navigator-->            
				<?php
                $sql_category2 = "SELECT * FROM product_tb where p_code ='".$_GET['code']."' AND p_color = '".$_GET['color']."'  ORDER BY ranking";
                $result_category2 =@mysql_query($sql_category2, $connect);
                $data_category2 =@mysql_fetch_array($result_category2);
                ?>
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t" style="color:#000">
						<?php 
						$product_color = "select name from color_tb where c_code = '".$data_category2['p_color']."' ";
						$result_productcolor = @mysql_query($product_color, $connect);
						$data_productcolor =@mysql_fetch_array($result_productcolor);
						
						echo $data_category2['p_category']." | ".$data_category2['p_code']." | ".$data_productcolor['name'];?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo "Supplier ".$data_category2['p_supplier']." สั่งขั้นต่ำ ".$data_category2['p_minimum'];?>
                        </div>
                    </div>
                    <div class="block_style2_content">



                                   		<!--Coppy Module Clear-->
                                        <form action="stock.php" method="post" enctype="multipart/form-data" name="form1">
                                        <input type="hidden" name="p_code" value="<?php echo $data_category2['p_code'];?>" />
                                        <input type="hidden" name="p_color" value="<?php echo $data_category2['p_color'];?>" />
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
                                        <li>
                                            <input type="hidden" name="save" value="1" />
                                            <input type="image" src="images/save_all.png" alt="Save" name="Submit" value="Save" title="Save" style="width:52px; height:16px;" /> </li>         
                                        </ul>
                                        
                                   </div>
                                   </div>
                                   
                                   </div>
                                        
                                        
                                        <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-color:#999">
                                          <tr>
                                            <td height="25" align="center">ลำดับ</td>
                                            <td align="center">Size</td>
                                            <td align="center">Color</td>
                                            <td align="center">พร้อมส่ง</td>
                                            <td align="center">Pre-Order</td>
                                            <td align="center">Pre Rev</td>
                                            <td align="center">Spare</td>
                                            <td align="center">Spare Rev</td>
                                            <td align="center">สั่งผลิต/รับสินค้า</td>
                                            <td align="center">ชำรุด</td>
                                          </tr>
                                            <?php
											$sql_category = "SELECT * FROM product_tb where p_code ='".$_GET['code']."' AND p_color = '".$_GET['color']."' ORDER BY ranking";
											$result_category =@mysql_query($sql_category, $connect);
											$num_category =@mysql_num_rows($result_category);
											
											for($i=1;$i<=intval($num_category);$i++){
											$data_category =@mysql_fetch_array($result_category);
											?>
                                            
                                          <tr>
                                            <td height="25" align="center"><?php echo $f+$i;?></td>
                                            <td align="center"><?php echo $data_category['p_size']; ?></td>
                                            <td align="center">
											
											<?php 
											$product_color2 = "select name from color_tb where c_code = '".$data_category['p_color']."' ";
											$result_productcolor2 = @mysql_query($product_color2, $connect);
											$data_productcolor2 =@mysql_fetch_array($result_productcolor2);

											
											echo $data_productcolor2['name']; 
											
											
											?>
                                            
                                            
                                            </td>
                                            <td align="center"><?php echo $data_category['p_stock']; ?></td>
                                            <td align="center"><?php echo $data_category['p_pre']; ?></td>
                                            <td align="center">
											<?php
                                            $sql_buy_preorder = "SELECT sum(product_number) as count_buyPreorder FROM temp_order_product where pid ='".$data_category['pid']."'";
                                            $sql_buy_preorder .= " AND buy_status = 'PREORDER' AND sent_status = 'RESERVE'";
                                            $result_buy_preorder =@mysql_query($sql_buy_preorder, $connect);
                                            $data_buy_preorder =@mysql_fetch_array($result_buy_preorder);
                                            echo $data_buy_preorder['count_buyPreorder'];
                                            ?>
                                            </td>
                                            <?php if($i == 1){?>
                                            <td rowspan="<?php echo $num_category;?>" align="center">
                                            <input name="p_spare" type="text" id="p_spare " style="width:30px; text-align:right;" value="<?php echo $data_category['p_spare'];?>">
                                            <input name="p_code" type="hidden"  value="<?php echo $data_category['p_code'];?>">
                                            </td>
                                            <?php } ?>
                                            <td  align="center">
											<?php
                                            $sql_buy_spare = "SELECT sum(product_number) as count_buySpare FROM temp_order_product where pid ='".$data_category['pid']."'";
                                            $sql_buy_spare .= " AND buy_status = 'SPARE' AND sent_status = 'RESERVE'";
                                            $result_buy_spare =@mysql_query($sql_buy_spare, $connect);
                                            $data_buy_spare =@mysql_fetch_array($result_buy_spare);
                                            echo $data_buy_spare['count_buySpare'];
                                            ?>
                                            </td>
                                            <td align="center"><a href="manufacture.php?pid=<?php echo $data_category['pid'];?>" ><img alt="Edit" src="images/1343378527_add1-.png" title="Review"/></a></td>
                                            <td align="center"><a href="wornout.php?pid=<?php echo $data_category['pid'];?>" ><img alt="Edit" src="images/1343378527_add1-.png" title="Review"/></a></td>
                                          </tr>
                                            <? } ?>
                                        </table>
                                	<!-- -->
                                  	<div class="page_number">
                                    	<div class="page_number-right">
                                        
                                            	
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
