<?php
session_start();
require_once '../dbconnect.inc';

$sql_product = "SELECT * FROM product_tb where pid ='".$_GET['pid']."'";
$result_product =@mysql_query($sql_product, $connect);
$data_product =@mysql_fetch_array($result_product);

if($_POST['Submit'] == 'ADD'){
	
$sql_spare = "SELECT p_spare FROM product_tb where pid ='".$_POST['pid']."'";
$result_spare =@mysql_query($sql_spare, $connect);
$data_spare =@mysql_fetch_array($result_spare);

	if($_POST['n_product'] > $data_spare['p_spare']){
		
	?>
				  <script>
					alert('ไม่สามารถสั่งผลิตได้เนื่องจากสั่งเกิน SPARE');
				  </script>
	<?php

	}else{
	
	$sql_product2 = "INSERT INTO  manufacture_tb (id ,pid ,num_product, real_product ,order_date, expect_date, order_status ,date_in)";
	$sql_product2 .= "VALUES (NULL ,  '".$_POST['pid']."',  '".$_POST['n_product']."',  '".$_POST['real_product']."',  '".$_POST['order_date']."',  '".$_POST['expect_date']."',  '0',  NOW())";
	$resultproduct2 =@mysql_query($sql_product2, $connect);
	

	$sql_buy_spare = "SELECT sum(product_number) as count_buySpare FROM temp_order_product where pid ='".$_POST['pid']."'";
	$sql_buy_spare .= " AND buy_status = 'SPARE' AND sent_status = 'RESERVE'";
	$result_buy_spare =@mysql_query($sql_buy_spare, $connect);
	$data_buy_spare =@mysql_fetch_array($result_buy_spare);

	
	$total_spare = $_POST['p_spare']-$_POST['n_product'];
	$total_pre = $_POST['p_pre']-$data_buy_spare['count_buySpare']+$_POST['n_product'];

	$edit_product2 = "UPDATE product_tb SET p_spare = '".$total_spare."'";
	$edit_product2 .= " , p_pre = '".$total_pre."' where pid = '".$_POST['pid']."'";
	@mysql_query($edit_product2, $connect);
	
	}
	
	?>
				  <script>
					location.href='manufacture.php?pid=<?php echo $_POST['pid'];?>';
				  </script>
	<?php
}

if($_POST['save'] == '1' && $_POST['n_product'] == ''){

	if($_POST['hidden_new_id']){
		
		
		foreach ($_POST['hidden_new_id'] as $v) {
			
			
				if($_POST['Submit'][$v] == 'Accept'){
					
				$update_new_ranking = "UPDATE manufacture_tb SET real_product = '".$_POST['real_product'][$v]."'  ";
				$update_new_ranking .= ", order_status = '1' , accept_date = '".$_POST['accept_date'][$v]."' WHERE id = '".$_POST['hidden_new_id'][$v]."'";
				$update_new_ranking_result = @mysql_query($update_new_ranking, $connect);
				
						/*if(($_POST['real_product'][$v] != $_POST['num_product'][$v]) ){
							$spare = $_POST['num_product'][$v] - $_POST['real_product'][$v];
							$total_spare = $_POST['p_spare']+$spare;
							$total_pre = 0;
						}else{
							$total_spare = $_POST['p_spare'];
							$pre = $_POST['real_product'][$v] - $_POST['p_reserve'];
							$total_pre = $_POST['p_pre'] - $pre;
						}
						
						if($_POST['real_product'][$v] >= $_POST['p_reserve']){
							$total_reserve = 0;
						}else{
							$total_reserve =  $_POST['p_reserve']-$_POST['real_product'][$v];
						}
						
						$real = $_POST['real_product'][$v] - $_POST['p_reserve'];
						$total_stock = $_POST['p_stock']+$real;
						
						$edit_product2 = "UPDATE product_tb SET p_reserve = '".$total_reserve."'";
						$edit_product2 .= ", p_pre = '".$total_pre."'";
						$edit_product2 .= ", p_stock = '".$total_stock."'";						
						$edit_product2 .= ", p_spare = '".$total_spare."'";
						
						$edit_product2 .= " where pid = '".$_POST['pid']."'";*/
						
						//@mysql_query($edit_product2, $connect);
						
						//echo $edit_product2;
					
				}
		}
		
	}
	?>
				  <script>
					location.href='manufacture.php?pid=<?php echo $_POST['pid'];?>';
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
<link rel="stylesheet" href="../js/datepicker/css/ui-darkness/jquery-ui-1.10.3.custom.css" type="text/css">
<script type="text/javascript" src="../js/datepicker/js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript">
$(function(){

	
	// Datepicker
	$('#datepicker').datepicker({
		yearRange: "1950:+0",
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy',
		
	});
	
	$('#datepicker_ex').datepicker({
		yearRange: "1950:+0",
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy',
		
	});
	
});
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
                 <a href="product.php">Product</a>
                </div>
                <!--End Navigator-->            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t" style="color:#000">
                        <a href="stock.php?code=<?php echo $data_product['p_code'];?>&color=<?php echo $data_product['p_color'];?>">
						<?php echo $data_product['p_category']." | ".$data_product['p_code']." | ".$data_product['p_color'];?>
                        </a>
                        </div>
                    </div>
                    <div class="block_style2_content">

                                   		<!--Coppy Module Clear-->

                                       
                                        <div class="module_3">
                                            <div class="title">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                                <div class="t"><a href="stock.php?code=<?php echo $data_product['p_code'];?>&color=<?php echo $data_product['p_color'];?>"><b>
                                                << กลับสู่หน้า Stock </b></a>
                                                <h2>
                                                </h2> </div>
                                                <div class="bt">
                                                	 
                                                </div>
                                            </div>
                                            <div class="conten">
            <form action="" method="post" enctype="multipart/form-data" name="form2">
            <table cellspacing="1" cellpadding="0" border="0" style="font-family:Tahoma, Geneva, sans-serif; font-size:12px">
                <tr>
                <td width="93" align="center" bgcolor="#F7F7F7">In-Stock</td>
                <td width="93" align="center" bgcolor="#F7F7F7">Pre-Order</td>
                <td width="93" align="center" bgcolor="#F7F7F7">จอง Pre-Order</td>
                <td width="93" align="center" bgcolor="#F7F7F7">Spare</td>
                <td width="93" align="center" bgcolor="#F7F7F7">จอง-Spare</td>
                <td width="93" height="25" align="center" bgcolor="#FFCC66">Make</td>
                <td width="93" align="center" bgcolor="#FFCC66">ของเข้า</td>
                <td width="93" align="center" bgcolor="#FFCC66">ของรอจอง</td>
                <td width="93" align="center" bgcolor="#FFCC66">Preเหลือ</td>
                <td width="93" align="center" bgcolor="#FFCC66">Instock</td>
                <td width="93" align="center">&nbsp;</td>
                </tr>
                <tr>
                <td align="center" bgcolor="#F7F7F7"><input type="text" name="instock" id="instock" style="width:30px;" value="<?php echo $data_product['p_stock']; ?>"  /></td>
                <?php
                $sql_buy_instock = "SELECT sum(product_number) as count_buyInstock FROM temp_order_product where pid ='".$data_product['pid']."'";
                $sql_buy_instock .= " AND buy_status = 'INSTOCK'";
                $result_buy_instock =@mysql_query($sql_buy_instock, $connect);
                $data_buy_instock =@mysql_fetch_array($result_buy_instock);
                ?>
                <td align="center" bgcolor="#F7F7F7"><input type="text" name="preorder" id="preorder" style="width:30px;" value="<?php echo $data_product['p_pre']; ?>" /></td>
                <?php
                $sql_buy_preorder = "SELECT sum(product_number) as count_buyPreorder FROM temp_order_product where pid ='".$data_product['pid']."'";
                $sql_buy_preorder .= " AND buy_status = 'PREORDER' AND sent_status = 'RESERVE'";
                $result_buy_preorder =@mysql_query($sql_buy_preorder, $connect);
                $data_buy_preorder =@mysql_fetch_array($result_buy_preorder);
                
                ?>
                <td align="center" bgcolor="#F7F7F7"><input type="text" name="buy_preorder" id="buy_preorder" style="width:30px;" value="<?php echo ($data_buy_preorder['count_buyPreorder'] == '' ? "0" : $data_buy_preorder['count_buyPreorder']);?>" /></td>
                <td align="center" bgcolor="#F7F7F7"><input type="text" name="spare" id="spare" style="width:30px;"  value="<?php echo $data_product['p_spare']; ?>"/></td>
                <?php
                $sql_buy_spare = "SELECT sum(product_number) as count_buySpare FROM temp_order_product where pid ='".$data_product['pid']."'";
                $sql_buy_spare .= " AND buy_status = 'SPARE' AND sent_status = 'RESERVE'";
                $result_buy_spare =@mysql_query($sql_buy_spare, $connect);
                $data_buy_spare =@mysql_fetch_array($result_buy_spare);
                ?>
                <td align="center" bgcolor="#F7F7F7"><input type="text" name="buy_spare" id="buy_spare" style="width:30px;"  value="<?php echo ($data_buy_spare['count_buySpare'] == '' ? "0" : $data_buy_spare['count_buySpare']);?>"  /></td>
                <td align="center" bgcolor="#FF0000"><input type="text" name="make" id="make" style="width:30px;"  /></td>
                <td align="center" bgcolor="#FF0000"><input type="text" name="real_recive" id="real_recive" style="width:30px;"  /></td>
                <td align="center" bgcolor="#FFCCFF"><input type="text" name="preorder_in" id="preorder_in" style="width:30px;"  /></td>
                
                <td align="center" bgcolor="#FFCCFF"><input type="text" name="preorder_real" id="preorder_real" style="width:30px;"  /></td>
                <td align="center" bgcolor="#FFCCFF"><input type="text" name="gotoinstock" id="gotoinstock" style="width:30px;"  /></td>
                <td align="center"><input type="button" name="calculate" id="calculate" value="Calculate" onclick="calFunc();" /></td>
                </tr>

                <tr>
                  <td height="40" colspan="11" align="center"><input type="submit" name="update" id="update" value="UPDATE" /></td>
                  </tr>
                </table>   
                <input type="hidden" name="pid" value="<?php echo $_GET['pid'];?>" />                                     
			</form>
            
            
            <?php
            if($_POST['update'] == 'UPDATE' ){
				
						$sql_up_product = "UPDATE product_tb SET";
						$sql_up_product .= " p_pre = '".$_POST['preorder_real']."'";
						$sql_up_product .= ", p_stock = '".$_POST['gotoinstock']."'";						
						$sql_up_product .= " where pid = '".$_POST['pid']."'";
						
						@mysql_query($sql_up_product, $connect);
						
						$sql_reserve = "SELECT * FROM temp_order_product where pid ='".$_POST['pid']."'";
						$sql_reserve .= " AND sent_status = 'RESERVE' order by date_in asc";
						$result_reserve =@mysql_query($sql_reserve, $connect);
						
						$num_reserve =@mysql_num_rows($result_reserve);
						
						$real_recive = $_POST['real_recive'];
						
						for($r=1;$r<=intval($num_reserve);$r++){
						
						$data_reserve =@mysql_fetch_array($result_reserve);
						
						//echo $data_reserve['temp_id']." ".$data_reserve['buy_status']." ".$data_reserve['sent_status']." ".$data_reserve['product_number']." = ";
						
						if($real_recive != '' ){
							
							$real_recive = $real_recive - $data_reserve['product_number'];
							
							if($real_recive > 0){
							 $update_num = $data_reserve['product_number'];
							 $update_status = "READY";
							}else{
							$update_num = $data_reserve['product_number'] + $real_recive;
								if($update_num > 0){	
								 $update_num = $update_num;
								 $update_status = "RESERVE";
								}else{
								 $update_num =0;
							 	 $update_status = "RESERVE";
								}
							}
							
							
						}
						$update_product_number = "UPDATE temp_order_product SET product_recive = '".$update_num."', product_recive = '".$update_status."'";
						$update_product_number .= " where temp_id = '".$data_reserve['temp_id']."'";
						$result_product_number =@mysql_query($update_product_number, $connect);
						
						//echo $update_product_number."<br>";
						
						
						}
				
				?>
							  <script>
								location.href='manufacture.php?pid=<?php echo $_POST['pid'];?>';
							  </script>
				<?php
			}
			?>
                <script>
				function calFunc(){
					
					if(parseInt(document.getElementById('buy_preorder').value) > parseInt(document.getElementById('make').value)){
					alert('1');
					var preIn = document.getElementById('buy_preorder').value - document.getElementById('real_recive').value;
					
					if(preIn <= 0 || preIn == '' ){
					document.getElementById('preorder_in').value = 0;
					}else{
					document.getElementById('preorder_in').value = preIn;
					}
					
					//var pReal = (document.getElementById('buy_preorder').value - document.getElementById('make').value) + parseInt(document.getElementById('preorder_in').value);
					
					var pReal = document.getElementById('preorder').value;
					
					if(pReal <= 0 ){
					document.getElementById('preorder_real').value = 0;
					}else{
					document.getElementById('preorder_real').value = pReal;
					}

					
					}else{

					var preIn = document.getElementById('buy_preorder').value - document.getElementById('real_recive').value;
					

					if(preIn <= 0 || preIn == '' ){
					document.getElementById('preorder_in').value = 0;
					}else{
					document.getElementById('preorder_in').value = preIn;
					}


					var pReal = document.getElementById('preorder').value - document.getElementById('make').value;
					
					
					if(preIn == 0  || preIn == '' ){
						document.getElementById('preorder_real').value = document.getElementById('preorder').value;
					}else{
						if(pReal <= 0 ){
						document.getElementById('preorder_real').value = (parseInt(document.getElementById('preorder').value) + parseInt(document.getElementById('buy_preorder').value)) - document.getElementById('make').value;
						}else{
						document.getElementById('preorder_real').value = pReal;
						}
					}
					
					
					

					}
					
					
					var gotoin = document.getElementById('real_recive').value - document.getElementById('buy_preorder').value - document.getElementById('buy_spare').value + parseInt(document.getElementById('instock').value);
					
					if(gotoin <= 0 ){
					document.getElementById('gotoinstock').value = 0;
					}else{
					document.getElementById('gotoinstock').value = gotoin;
					}
				
				}
				</script>
                                            
                                        <form action="" method="post" enctype="multipart/form-data" name="form1">
                                        <input type="hidden" name="p_code" value="<?php echo $data_product['p_code'];?>" />
                                        <input type="hidden" name="p_color" value="<?php echo $data_product['p_color'];?>" />
                                        <input type="hidden" name="p_spare" value="<?php echo $data_product['p_spare'];?>" />
                                        <input type="hidden" name="p_reserve" value="<?php echo $data_product['p_reserve'];?>" />
                                        <input type="hidden" name="p_pre" value="<?php echo $data_product['p_pre'];?>" />
                                        <input type="hidden" name="p_stock" value="<?php echo $data_product['p_stock'];?>" />
                                        
                                        
                                                <!--ใสข้อมูล ตรงนี้-->
                                                <!--ตาราง 3 Cell-->
                                   <div class="title-top">
                                   <div class="right-title">
                                   <div class="form3">
                                   		
                                        <ul>
                                        <li>
                                            <input type="hidden" name="pid" value="<?php echo $_GET['pid']; ?>" /> 
                                            <input type="hidden" name="save" value="1" />
<!--                                           
                                            <input type="image" src="images/save_all.png" alt="Save" name="Submit" value="Save" title="Save" style="width:52px; height:16px;" /> </li>         
-->                                        </ul>
                                        
                                   </div>
                                   </div>
                                   
                                   </div>
                                        
                                        
                                        <br />
                                            <?php
                                            if($data_product['p_spare'] == '0' || $data_product['p_spare'] == ''){
												echo "<font color=#FF0000><b>ไม่สามารถสั่งสินค้าได้ เนื่องจากสินค้าใน Stock กลางหมด</b></font><br><br>";
											}else{
											?>                                        
                                        <table width="460" border="0" align="center" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td width="116" height="30">จำนวน</td>
                                            <td width="344">
                                            <input type="text" name="n_product" value=""/>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td height="30">วันที่สั่งผลิต</td>
                                            <td>
                                            <input type="text" name="order_date" id="datepicker"  value=""/>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td height="30">วันที่คาดว่าจะเข้า</td>
                                            <td>
                                            <input type="text" name="expect_date" id="datepicker_ex"  value=""/>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td height="30">&nbsp;</td>
                                            <td>
                                            <div class="demo">
                                            
                                            <!--<button>Submit</button>-->

                                            <input name="Submit" type="submit" class="borderfrom" style="width:80px" value="ADD">
                                            
                                            </div>
                                    
                                            </td>
                                          </tr>
                                        </table><?php } ?>
                                        <br />
                                        <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-color:#999">
                                          <tr>
                                            <td width="6%" height="25" align="center">ลำดับ</td>
                                            <td width="8%" align="center">จำนวน</td>
                                            <td width="15%" align="center">วันที่คาดว่าจะเข้า</td>
                                            <td width="12%" align="center">สินค้าเข้าจริง</td>
                                            <td width="11%" align="center">สินค้าขาด</td>
                                            <td width="14%" align="center">วันที่สั่งผลิต</td>
                                            <td width="34%" align="center">&nbsp;</td>
                                          </tr>
                                            <?php
											$sql_category = "SELECT * FROM manufacture_tb where pid ='".$_GET['pid']."' order by id desc";
											$result_category =@mysql_query($sql_category, $connect);
											$num_category =@mysql_num_rows($result_category);
											
											for($i=1;$i<=intval($num_category);$i++){
											$data_product =@mysql_fetch_array($result_category);
											?>
										  <script type="text/javascript">
                                            $(function(){
                                            
                                                
                                                // Datepicker
                                                $('#datepicker<?php echo $i;?>').datepicker({
                                                    yearRange: "1950:+0",
                                                    changeMonth: true,
                                                    changeYear: true,
                                                    dateFormat: 'dd/mm/yy',
                                                    
                                                });
                                                
                                            });
                                            </script>
                                          <tr>
                                            <td height="25" align="center"><?php echo $i;?></td>
                                            <td align="center"><?php echo $data_product['num_product']; ?></td>
                                            <td align="center"><?php echo $data_product['expect_date']; ?></td>
                                            <td align="center"><?php echo $data_product['real_product']; ?></td>
                                            <td align="center">
											<?php 
											
											$fTotal =  $data_product['num_product']-$data_product['real_product']; 
											
											
											if($fTotal != '0' && $data_product['real_product'] != ''){
												echo "<font color=#FF0000><b>".$fTotal."</b></font>";
											}
											?></td>
                                            <td align="center"><?php echo $data_product['order_date']; ?></td>
                                            <td align="center">
                                            
                                            
                                            <?php if($data_product['order_status'] == '0' ){?>
                                            <input type="hidden" name="num_product[<?php echo $data_product['id'];?>]" value="<?php echo $data_product['num_product'];?>" />
                                            <input type="hidden" name="hidden_new_id[<?php echo $data_product['id'];?>]" value="<?php echo $data_product['id'];?>" />
                                            
                                            เข้าจริง
                                            <input type="text" name="real_product[<?php echo $data_product['id'];?>]" value="<?php echo $data_order2['num_product']; ?>" style="width:50px"/>
                                            วันที่รับ 
                                            <input type="text" name="accept_date[<?php echo $data_product['id'];?>]" id="datepicker<?php echo $i;?>"  value="" style="width:50px"/>
                                            <input name="Submit[<?php echo $data_product['id'];?>]" type="submit" class="borderfrom" style="width:60px" value="Accept">
                                            <?php }else{ 
                                            		echo "<font color=#66CC00><b>สินค้าเข้าแล้ว</b></font> วันที่ ".$data_product['accept_date'];
                                            } ?>
                                            </td>
                                          </tr>
                                            <? } ?>
                                        </table>
                                	<!-- -->
                                    
                                    </form>   
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
										<!--End Coppy Module Clear-->                               



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
