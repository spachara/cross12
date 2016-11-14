<?php
session_start();
require_once '../dbconnect.inc';

include("class.page_split.php");
$obj = new page_split();
$obj->_setPageSize(100);						
$obj->_setFile("product.php");		
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

				$update_new_ranking = "UPDATE product_highlight_tb2 SET ranking = '".$_POST['new_ranking2'][$v]."'  ";
				$update_new_ranking .= ", highlight_status =  '".$_POST['new_ranking'][$v]."' WHERE highlight_id = '".$_POST['hidden_new_id'][$v]."'";
				$update_new_ranking_result = @mysql_query($update_new_ranking, $connect);

				
		}
	}
	
	
}
if($_GET['sAction'] == 'del'){
	
	$edit_status_newarrvial = "UPDATE product_highlight_tb2 SET highlight_status_show = 2, date_update = NOW() WHERE highlight_id = '".$_GET['id_del']."' ";
	@mysql_query($edit_status_newarrvial, $connect);
	
	?><script>location.href='new_arrival.php';</script><?php
	
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

$(document).ready(function() {
	$('.check_highlight').click(function(e) {
    	var p_id;
		$( "input:checked" ).each(function() {
			//alert($(this).val());
			p_id = p_id + "," + $(this).val();
			
			
		});
		//alert(p_id)
		$.ajax({
			type:'POST',
			url:"ajax_new_arrival.php",
			data: "id="+ p_id,
			success:function(data){
				//alert(data);
				//location.href='new_arrival.php';
			}
		});
			
    });    
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
                                     <a href="new_arrival.php">New Arrival</a>
                                        
                                   </div>
                                   <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">New Arrival</div>
                    </div>
                    <div class="block_style2_content">



                                   		<!--Coppy Module Clear-->
                                        <form action="new_arrival.php" method="post" enctype="multipart/form-data" name="form1">
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
                                   <div class="form3">
                                   		
                                        <ul>
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
                                           	  <div class="cell1"style="width:5%;">ลำดับ</div>
                                              <div class="cell2"style="width:11%;">Category</div>
                                              <div class="cell3"style="width:12%;">รหัสสินค้า</div>
                                              <div class="cell3"style="width:11%;">สี</div>
                                              <div class="cell3"style="width:8%;">size</div>
                                              <div class="cell3"style="width:25%;">Name</div>
                                              <div class="cell3"style="width:25%;">&nbsp;</div>
                                            </li>
                                            <!--End Title-->
                                            <?php
											if($_POST['Search_code'] != '' ){
												$sql_product = "SELECT * FROM product_tb where p_code like '".$_POST['Search_code']."%' GROUP BY p_code, p_color";
											}else{
												//$sql_product = "SELECT * FROM product_tb p, product_highlight_tb2 ph WHERE p.pid = ph.product_id ORDER BY p.date_in desc";
												$sql_product = "SELECT * FROM product_tb where ranking not in('','0')  GROUP BY p_code, p_color";
											}
											$result_product =@mysql_query($sql_product, $connect);
											$num_product =@mysql_num_rows($result_product);
											
											for($i=1;$i<=intval($num_product);$i++){
											$data_product =@mysql_fetch_array($result_product);
											
												$sql_product_h = "SELECT * FROM product_highlight_tb2 WHERE highlight_status_show = 1 and p_code = '".$data_product['p_code']."' and p_color = '".$data_product['p_color']."'  ";
												$result_product_h =@mysql_query($sql_product_h, $connect);
												$num_product_h =@mysql_num_rows($result_product_h);
												if ($num_product_h == 0) {													
													$add_product_h = "INSERT INTO  product_highlight_tb2 (highlight_id ,p_code ,p_color ,highlight_status ,ranking ,date_in ,date_update)
													VALUES (NULL ,  '".$data_product['p_code']."',  '".$data_product['p_color']."',  '0',  '',   NOW(), NOW())";													
													@mysql_query($add_product_h, $connect);
													
												} 
												
												
											}
												
											$sql_product_h2 = "SELECT * FROM product_highlight_tb2 WHERE highlight_status_show = 1 ORDER BY highlight_status DESC, date_in DESC,ranking DESC";
											
											$result_product_h2 =@mysql_query($sql_product_h2, $connect);
											$num_product_h2 =@mysql_num_rows($result_product_h2);
											$i3 = 0;
											for($i2=1;$i2<=intval($num_product_h2);$i2++){
											$data_product_h2 =@mysql_fetch_array($result_product_h2);
											
											
											$sql_product2 = "SELECT * FROM product_tb where ranking not in('','0') and p_code = '".$data_product_h2['p_code']."' and p_color = '".$data_product_h2['p_color']."' ";
											$result_product2 =@mysql_query($sql_product2, $connect);
											$num_product_h3 =@mysql_num_rows($result_product2);
											if ($num_product_h3 > 0) {	
											$data_product2 =@mysql_fetch_array($result_product2);
											
												$i3++;
											?>
                                            <li>
                                                <div class="cell1"style="width:5%;">
                                                    <?php echo $i3;?>
                                                </div>
                                                <div class="cell2"style="width:11%;">
													<?php echo $data_product2['p_category']; ?>
                                                </div>
                                              <div class="cell3"style="width:12%;">
                                                   <!--<a href="stock.php?code=<?php echo $data_product2['p_code'];?>&color=<?php echo $data_product2['p_color']; ?>" style="text-decoration:underline">-->
                                                    <?php echo $data_product2['p_code'];?><!--</a>-->
                                                </div>
                                                <div class="cell3"style="width:11%;">
												<?php 
                                                $product_color = "select name from color_tb where c_code = '".$data_product2['p_color']."' ";
                                                $result_productcolor = @mysql_query($product_color, $connect);
                                                $data_productcolor =@mysql_fetch_array($result_productcolor);
                                                
                                                echo $data_productcolor['name']; ?>  
												   
												
                                                </div>
                                              <div class="cell3" style="width:8%;">
                                                <?php echo $data_product2['p_size']; ?>
                                                </div>	
                                                    
                                              <div class="cell3" style="width:25%;">
                                                <?php echo str_replace('+','',str_replace('+ ','',$data_product2['name'])); ?>
                                                </div>	
                                                
                                                <div class="cell3"style="width:25%;">
                                                    <!--Form2-->
                                                   <div class="form2">
                                                        <ul>
                                                            <li>Highlight</li>
                                                            <li><input name="new_ranking[<?php echo $data_product_h2['highlight_id'];?>] " type="checkbox" id="new_ranking" value="1" class="check_highlight" <?php echo $data_product_h2['highlight_status'] == 1 ? "checked=\"checked\"" : "";?>>
                                                            </li>
                                                            <li>Ranking</li>
                                                            <li>
                                                            <input name="new_ranking2[<?php echo $data_product_h2['highlight_id'];?>]" type="text" size="3" maxlength="3" value="<?php echo $data_product_h2['ranking'];?>">
                                                            <input name="hidden_new_id[<?php echo $data_product_h2['highlight_id'];?>]" type="hidden"  value="<?php echo $data_product_h2['highlight_id'];?>"></li>
                                                            <li><a href="new_arrival.php?id_del=<?php echo $data_product_h2['highlight_id'];?>&sAction=del" onClick="return confirm('Do you want to delete it. (yes/no)')">ลบ</a></li>
                                                            
                                                        </ul>
                                                   </div>                                   
                                                   <!--End Form2-->

                                          </div>
                                            </li>
                                            <? } } ?>
                                        </ul>
                                    </div>
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