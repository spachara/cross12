<?php
session_start();
require_once '../dbconnect.inc';

$sql_product = "SELECT * FROM product_tb where pid ='".$_GET['pid']."'";
$result_product =@mysql_query($sql_product, $connect);
$data_product =@mysql_fetch_array($result_product);

function getToken(){
  $token = sha1(mt_rand());
  if(!isset($_SESSION['tokens'])){
    $_SESSION['tokens'] = array($token => 1);
  }
  else{
    $_SESSION['tokens'][$token] = 1;
  }
  return $token;
}

/**
 * Check if a token is valid. Removes it from the valid tokens list
 * @param string $token The token
 * @return bool
 */
function isTokenValid($token){
  if(!empty($_SESSION['tokens'][$token])){
    unset($_SESSION['tokens'][$token]);
    return true;
  }
  return false;
}

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
	
	$sql_product2 = "INSERT INTO  manufacture_tb (id ,pid ,num_product, real_product ,order_date, expect_date, order_status, comment ,date_in)";
	$sql_product2 .= "VALUES (NULL ,  '".$_POST['pid']."',  '".$_POST['n_product']."',  '".$_POST['real_product']."',  '".$_POST['order_date']."'";
	$sql_product2 .= ",  '".$_POST['expect_date']."',  '0',  '".$_POST['comment']."',  NOW())";
	$resultproduct2 =@mysql_query($sql_product2, $connect);
	

	$sql_buy_spare = "SELECT sum(product_number) as count_buySpare FROM temp_order_product where pid ='".$_POST['pid']."'";
	$sql_buy_spare .= " AND buy_status = 'SPARE' AND sent_status = 'RESERVE'";
	$result_buy_spare =@mysql_query($sql_buy_spare, $connect);
	$data_buy_spare =@mysql_fetch_array($result_buy_spare);
	$num_buy_spare = @mysql_num_rows($result_buy_spare);

	$total_spare = $_POST['p_spare']-$_POST['n_product'];
	$total_pre = $_POST['p_pre']-$data_buy_spare['count_buySpare']+$_POST['n_product'];
	
	$sql_uu ="select * from product_tb where pid = '".$_POST['pid']."'";
	$result_uu =@mysql_query($sql_uu, $connect);
	$data_uu = @mysql_fetch_array($result_uu);
	
	
	$edit_product2 = "UPDATE product_tb SET p_spare = '".$total_spare."'";
	$edit_product2 .= " where p_code = '".$data_uu['p_code']."' and p_color = '".$data_uu['p_color']."'";
	@mysql_query($edit_product2, $connect);
	
	if($num_buy_spare){
	$edit_product3 = "UPDATE temp_order_product SET buy_status = 'PREORDER' ";
	$edit_product3 .= " where pid = '".$_POST['pid']."' and order_type = 'PRE' ";
	@mysql_query($edit_product3, $connect);
	}
	
	$edit_product4 = "UPDATE product_tb SET ";
	$edit_product4 .= " p_pre = '".$total_pre."' where pid = '".$_POST['pid']."'";
	@mysql_query($edit_product4, $connect);
	
	
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


if($_POST['Submit'] == 'EDIT'){
	
		$update_new_ranking = "UPDATE manufacture_tb SET num_product = '".$_POST['n_product']."', expect_date = '".$_POST['expect_date']."'";
		$update_new_ranking .= ", comment = '".$_POST['comment']."', real_product = '".$_POST['real_product_edit']."' WHERE id = '".$_POST['id']."'";
		$update_new_ranking_result = @mysql_query($update_new_ranking, $connect);
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

            <!--End Main Menu-->
            
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
						<?php 
						$product_color = "select name from color_tb where c_code = '".$data_product['p_color']."' ";
						$result_productcolor = @mysql_query($product_color, $connect);
						$data_productcolor =@mysql_fetch_array($result_productcolor);
						echo $data_product['p_category']." | ".$data_product['p_code']." | ".$data_productcolor['name']." | ".$data_product['p_size'];?>
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
            <form action="" method="post" enctype="multipart/form-data" name="form2" id="form2">
            
            <div style="width:200px; height:40px; margin-left:600px; margin-top:20px; position:absolute; left: 239px; top: 33px;"></div>
            <table cellspacing="1" cellpadding="0" border="0" style="font-family:Tahoma, Geneva, sans-serif; font-size:12px">
              <tr>
                <td width="93" align="center" bgcolor="#F7F7F7">In-Stock</td>
                <td width="93" align="center" bgcolor="#F7F7F7">In Stock(จอง)</td>
                <td width="93" align="center" bgcolor="#F7F7F7">Pre-Order</td>
                <td width="93" align="center" bgcolor="#F7F7F7">Pre (จอง)</td>
                <td width="93" align="center" bgcolor="#F7F7F7">Pre (พร้อมส่ง)</td>
                <td width="93" align="center" bgcolor="#F7F7F7">On hand</td>
                <td width="93" align="center" bgcolor="#F7F7F7">Make</td>
                <td width="93" align="center" bgcolor="#F7F7F7">Spare</td>
                <td width="93" align="center" bgcolor="#F7F7F7">Spare (จอง)</td>
                <td width="93" height="25" align="center" bgcolor="#FFCC66">Make</td>
                <td width="93" align="center" bgcolor="#FFCC66">ของเข้า</td>
                <td width="93" align="center" bgcolor="#FFCC66">Pre (จอง)</td>
                <td width="93" align="center" bgcolor="#FFCC66">Pre-Order</td>
                <td width="93" align="center" bgcolor="#FFCC66">In-Stock</td>
                <td width="93" align="center">&nbsp;</td>
                </tr>
                <tr>
                <td align="center" bgcolor="#F7F7F7"><input type="text" name="instock" id="instock" style="width:30px;" value="<?php echo $data_product['p_stock']; ?>"  /></td>
                <td align="center" bgcolor="#F7F7F7">
                
					<?php
				   $product_send2 = 0;	 
				   $product_on_hand2 = 0;
				   
				   $sql_count_sale = "select sum(product_number) as count_sale from temp_order_product where pid = '".$data_product['pid']."'";
				   $sql_count_sale .= " and buy_status = 'INSTOCK'";
				   $result_count_sale = @mysql_query($sql_count_sale, $connect);
				   $data_count_sale = @mysql_fetch_array($result_count_sale);
				   //echo $data_count_sale['count_sale'];
						
					$sql_order_product_hand2 = "SELECT * FROM order_product_tb WHERE pro_id = '".$data_product['pid']."' and order_type = 'IN' ";
					$result_order_product_hand2 =@mysql_query($sql_order_product_hand2, $connect);
					$num_order_product_hand2 =@mysql_num_rows($result_order_product_hand2);
					
					
					for ($o_h2=1; $o_h2<=$num_order_product_hand2; $o_h2++) {
						$data_order_product_hand2 =@mysql_fetch_array($result_order_product_hand2);
						
						if ($data_order_product_hand2['tracking_number'] != "") {
							$product_send2 = $product_send2 + $data_order_product_hand2['order_p_stock'];
						}

					}
					
					$product_on_hand2 = $data_count_sale['count_sale']- $product_send2;
					
					echo $product_on_hand2;
                    ?> 
                                   
                </td>
                <?php
                $sql_buy_instock = "SELECT sum(product_number) as count_buyInstock FROM temp_order_product where pid ='".$data_product['pid']."'";
                $sql_buy_instock .= " AND buy_status = 'INSTOCK'";
                $result_buy_instock =@mysql_query($sql_buy_instock, $connect);
                $data_buy_instock =@mysql_fetch_array($result_buy_instock);
                ?>
                <td align="center" bgcolor="#F7F7F7"><input type="text" name="preorder" id="preorder" style="width:30px;" value="<?php echo $data_product['p_pre']; ?>" /></td>
                <?php
                $sql_buy_preorder = "SELECT sum(product_number-product_recive) as count_buyPreorder FROM temp_order_product where pid ='".$data_product['pid']."'";
                $sql_buy_preorder .= " AND buy_status = 'PREORDER' AND sent_status = 'RESERVE'";
                $result_buy_preorder =@mysql_query($sql_buy_preorder, $connect);
                $data_buy_preorder =@mysql_fetch_array($result_buy_preorder);
                
                ?>
                <td align="center" bgcolor="#F7F7F7"><input type="text" name="buy_preorder" id="buy_preorder" style="width:30px;" value="<?php echo ($data_buy_preorder['count_buyPreorder'] == '' ? "0" : $data_buy_preorder['count_buyPreorder']);?>" /></td>
                <td align="center" bgcolor="#F7F7F7">
				<?php
                    
                    $sql_buy_preorder1 = "SELECT sum(product_recive) as count_revPreorder FROM temp_order_product";
                    $sql_buy_preorder1 .= " where pid ='".$data_product['pid']."'";
                    $sql_buy_preorder1 .= " AND buy_status = 'PREORDER' AND sent_status = 'READY'";
                    $result_buy_preorder1 =@mysql_query($sql_buy_preorder1, $connect);
                    $data_buy_preorder1 =@mysql_fetch_array($result_buy_preorder1);
                
                    $sql_buy_spare1 = "SELECT sum(product_recive) as count_revSpare FROM temp_order_product";
                    $sql_buy_spare1 .= " where pid ='".$data_product['pid']."'";
                    $sql_buy_spare1 .= " AND buy_status = 'SPARE' AND sent_status = 'READY'";
                    $result_buy_spare1 =@mysql_query($sql_buy_spare1, $connect);
                    $data_buy_spare1 =@mysql_fetch_array($result_buy_spare1);
                    
                    //echo $data_buy_spare1['count_revSpare'];
                    
                    $productPre_on_hand2 = 0;
                    $productPre_send2 = 0;
                    
                    $sql_order_preorder2 = "SELECT * FROM order_product_tb WHERE pro_id = '".$data_product['pid']."' and order_type = 'PRE'";
                    $result_order_preorder2 =@mysql_query($sql_order_preorder2, $connect);
                    $num_order_preorder2 =@mysql_num_rows($result_order_preorder2);
                    
                    
                    for ($pre=1; $pre<=$num_order_preorder2; $pre++) {
                        $data_order_preorder2 =@mysql_fetch_array($result_order_preorder2);
                        
                        if ($data_order_preorder2['tracking_number'] != "") {
                            $productPre_send2 = $productPre_send2 + $data_order_preorder2['order_p_stock'];
                        }
                
                    }
                    
                    $productPre_on_hand2 = ($data_buy_preorder1['count_revPreorder']- $productPre_send2)+$data_buy_spare1['count_revSpare'];

                    
                    echo ($productPre_on_hand2 == '' ? "0" : $productPre_on_hand2);
                    
                    
                ?>                
                </td>
                <td align="center" bgcolor="#F7F7F7">
					<?php
                    $sql_product_hand = "SELECT * FROM product_tb WHERE pid = '".$data_product['pid']."' ";
                    $result_product_hand =@mysql_query($sql_product_hand, $connect);
                    $data_product_hand =@mysql_fetch_array($result_product_hand);
                    
                    $product_stock = $data_product_hand['p_stock'];
                    //echo "p_stock ".$data_product_hand['p_stock']."<br>";
                    
                    $product_temp_stock = 0;
                    
                    $sql_temp_order_hand = "SELECT * FROM temp_order_product WHERE pid = '".$data_product['pid']."' and buy_status = 'INSTOCK' ";
                    $result_temp_order_hand =@mysql_query($sql_temp_order_hand, $connect);
                    $num_temp_order_hand =@mysql_num_rows($result_temp_order_hand);
                    
                    
                    for ($t_h=1; $t_h<=$num_temp_order_hand; $t_h++) {
                    $data_temp_order_hand =@mysql_fetch_array($result_temp_order_hand);
                    
                    $product_temp_stock += $data_temp_order_hand['product_number'];
                    
                    }
                    
                    
                    $product_temp_stock_pre = 0;
                    $sql_temp_order_hand_pre = "SELECT * FROM temp_order_product WHERE pid = '".$data_product['pid']."' and buy_status = 'PREORDER' ";
                    $sql_temp_order_hand_pre .= "AND sent_status = 'READY'";
                    $result_temp_order_hand_pre =@mysql_query($sql_temp_order_hand_pre, $connect);
                    $num_temp_order_hand_pre =@mysql_num_rows($result_temp_order_hand_pre);
                    
                    for ($t_h2=1; $t_h2<=$num_temp_order_hand_pre; $t_h2++) {
                    $data_temp_order_hand_pre =@mysql_fetch_array($result_temp_order_hand_pre);
                    
                    $product_temp_stock_pre += $data_temp_order_hand_pre['product_number'];
                    
                    }
                    
                    
                    $product_temp_stock_spare = 0;
                    $sql_temp_order_hand_spare = "SELECT * FROM temp_order_product WHERE pid = '".$data_product['pid']."' and buy_status = 'SPARE' ";
                    $sql_temp_order_hand_spare .= "AND sent_status = 'READY'";
                    $result_temp_order_hand_spare =@mysql_query($sql_temp_order_hand_spare, $connect);
                    $num_temp_order_hand_spare =@mysql_num_rows($result_temp_order_hand_spare);
                    
                    for ($t_h3=1; $t_h3<=$num_temp_order_hand_spare; $t_h3++) {
                    $data_temp_order_hand_spare =@mysql_fetch_array($result_temp_order_hand_spare);
                    
                    $product_temp_stock_spare += $data_temp_order_hand_spare['product_number'];
                    
                    }
                    
                    //echo "product_temp_stock ".$product_temp_stock."<br>";
                    
                    $product_send = 0;
                    
                    $sql_order_product_hand = "SELECT * FROM order_product_tb WHERE "; //order_number = '".$data_update3['order_number']."'
                    $sql_order_product_hand .= " pro_id = '".$data_product['pid']."' ";
                    $result_order_product_hand =@mysql_query($sql_order_product_hand, $connect);
                    $num_order_product_hand =@mysql_num_rows($result_order_product_hand);
                    for ($o_h=1; $o_h<=$num_order_product_hand; $o_h++) {
                    $data_order_product_hand =@mysql_fetch_array($result_order_product_hand);
                    
                    if ($data_order_product_hand['tracking_number'] != "") {
                        $product_send += $data_order_product_hand['order_p_stock'];
                    }
                    
                    }
                    //echo "sql_order_product_hand ".$sql_order_product_hand."<br>";
                    
                    
                    $product_on_hand = ($product_stock + $product_temp_stock + $product_temp_stock_pre + $product_temp_stock_spare) - $product_send;
                    
                    
                    echo $product_on_hand;
                    ?>
                  </td>
                <td align="center" bgcolor="#F7F7F7">
					<?php
                    $realTotal = 0;

                    $sql_manu = "SELECT num_product  FROM manufacture_tb where pid ='".$data_product['pid']."' and order_status = '0'";
                    $result_manu =@mysql_query($sql_manu, $connect);
                    $num_manu =@mysql_num_rows($result_manu);
                    
                    for($i3=1;$i3<=intval($num_manu);$i3++){
                    $data_manu =@mysql_fetch_array($result_manu);
                    
                    $realTotal = $realTotal + $data_manu['num_product'];
                    
                    }
                    
                    
                    echo $realTotal;
                    $realTotal = 0;
                    ?>
                </td>
                <td align="center" bgcolor="#F7F7F7"><input type="text" name="spare" id="spare" style="width:30px;"  value="<?php echo $data_product['p_spare']; ?>"/></td>
                <?php
                $sql_buy_spare = "SELECT sum(product_number-product_recive) as count_buySpare FROM temp_order_product where pid ='".$data_product['pid']."'";
                $sql_buy_spare .= " AND buy_status = 'SPARE' AND sent_status = 'RESERVE'";
                $result_buy_spare =@mysql_query($sql_buy_spare, $connect);
                $data_buy_spare =@mysql_fetch_array($result_buy_spare);
				$token = getToken();
                ?>
                <td align="center" bgcolor="#F7F7F7"><input type="text" name="buy_spare" id="buy_spare" style="width:30px;"  value="<?php echo ($data_buy_spare['count_buySpare'] == '' ? "0" : $data_buy_spare['count_buySpare']);?>"  /></td>
                <td align="center" bgcolor="#66FF33"><input type="text" name="make" id="make" style="width:30px;"  /></td>
                <td align="center" bgcolor="#FF0000"><input type="text" name="real_recive" id="real_recive" style="width:30px;"  /></td>
                <td align="center" bgcolor="#FFCCFF"><input type="text" name="preorder_in" id="preorder_in" style="width:30px;"  /></td>
                
                <td align="center" bgcolor="#FFCCFF"><input type="text" name="preorder_real" id="preorder_real" style="width:30px;"  /></td>
                <td align="center" bgcolor="#FFCCFF"><input type="text" name="gotoinstock" id="gotoinstock" style="width:30px;"  /></td>
                <td align="center"><input type="button" name="calculate" id="calculate" value="Calculate" onClick="calFunc();" /></td>
                </tr>

                <tr>
                  <td height="40" colspan="15" align="center">
                           <table width="300" border="0" cellpadding="0" cellspacing="1" id="showUpdate" style="display:none">
                            <tr >
                              <td align="center">
                              <br />
                              <font color="#FF0000">"กรุณากดปุ่ม Update เพื่อยืนยันการปรับปรุง Stock"</font><br />
							  <input type="hidden" name="token" value="<?php echo $token;?>"/>
                              <input type="submit" name="update" id="update" value="UPDATE" />
                              </td>
                            </tr>
            
                          </table>   
                  </td>
                </tr>

              </table>   
                <input type="hidden" name="pid" value="<?php echo $_GET['pid'];?>" />                                     
			</form>
            
            
            <?php
			$postedToken = filter_input(INPUT_POST, 'token');
			if(!empty($postedToken)){
			  if(isTokenValid($postedToken)){
					
            if($_POST['update'] == 'UPDATE' ){
				
				
						$sql_update_stock = "INSERT INTO  update_stock_tb (id, pid ,make , real_recive, date_in)";
						$sql_update_stock .= "VALUES (NULL ,  '".$_POST['pid']."',  '".$_POST['make']."',  '".$_POST['real_recive']."',  NOW())";
						$result_update_stock =@mysql_query($sql_update_stock, $connect);
				
						$sql_up_product = "UPDATE product_tb SET";
						$sql_up_product .= " p_pre = '".$_POST['preorder_real']."'";
						$sql_up_product .= ", p_stock = '".$_POST['gotoinstock']."'";						
						$sql_up_product .= " where pid = '".$_POST['pid']."'";
						
						@mysql_query($sql_up_product, $connect);
						//echo $sql_up_product."<br>";
						
						
						$sql_reserve = "SELECT * FROM temp_order_product where pid ='".$_POST['pid']."'";
						$sql_reserve .= " AND sent_status = 'RESERVE' order by date_in asc";
						$result_reserve =@mysql_query($sql_reserve, $connect);
						
						$num_reserve =@mysql_num_rows($result_reserve);
						
						$real_recive = $_POST['real_recive'];
						
						for($r=1;$r<=intval($num_reserve);$r++){
						
						$data_reserve =@mysql_fetch_array($result_reserve);
						
						//echo $data_reserve['temp_id']." ".$data_reserve['buy_status']." ".$data_reserve['sent_status']." ".$data_reserve['product_number']." = ";
						
						if($real_recive != '' ){
							
							$real_recive = $real_recive - $data_reserve['product_number']+$data_reserve['product_recive'];
							
							if($real_recive > 0){
								
								 $update_num = $data_reserve['product_number'];
								 $update_status = "READY";
								
							}else{
							$update_num = $data_reserve['product_number'] + $real_recive;
								if($update_num > 0){
										
								 $update_num = $update_num;
								 
								 if($update_num == $data_reserve['product_number']){
								 $update_status = "READY";
								 }else{
							 	 $update_status = "RESERVE";
								 }
								 
								 
								}else{
								 $update_num =0;
							 	 $update_status = "RESERVE";
								}
							}
							
						$update_product_number = "UPDATE temp_order_product SET product_recive = '".$update_num."', sent_status = '".$update_status."'";
						$update_product_number .= " where temp_id = '".$data_reserve['temp_id']."'";
						$result_product_number =@mysql_query($update_product_number, $connect);	
						//echo $update_product_number."<br>";
						}
						
						
						
						
						}
						$_POST['real_recive'] = 0;
				
				?>
							  <script>
								location.href='manufacture.php?pid=<?php echo $_POST['pid'];?>';
							  </script>
				<?php
			}
			
			  }
			}
			?>
                <script>
				function calFunc(){
					
					if(parseInt(document.getElementById('buy_preorder').value) > parseInt(document.getElementById('make').value)){
					//alert('1');
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
							
							var pReal2 = (parseInt(document.getElementById('preorder').value) + parseInt(document.getElementById('buy_preorder').value)) - document.getElementById('make').value;

								if(pReal2 <= 0){
									
								document.getElementById('preorder_real').value = 0;
								}else{
								document.getElementById('preorder_real').value = pReal2;
								
								}


						}else{
							
								if(pReal <= 0){
									
								document.getElementById('preorder_real').value = 0;
								}else{
								document.getElementById('preorder_real').value = pReal;
								
								}
						
						}
					}
					
					
					

					}
					
					
					var gotoin = document.getElementById('real_recive').value - document.getElementById('buy_preorder').value - document.getElementById('buy_spare').value + parseInt(document.getElementById('instock').value);
					
					if(gotoin <= 0 ){
					document.getElementById('gotoinstock').value = 0;
					}else{
					document.getElementById('gotoinstock').value = gotoin;
					}
					
					document.getElementById('showUpdate').style.display = "block";
				
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
                                    <table width="500" border="0" cellspacing="2" cellpadding="0">
                                      <tr>
                                        <td height="20" colspan="4" align="center" bgcolor="#CCCCCC"><strong>ตารางอัพเดทการนำสินค้าเข้า Stock</strong></td>
                                      </tr>
                                      <tr>
                                        <td width="88" height="20" align="center" bgcolor="#F7F7F7">ลำดับ</td>
                                        <td width="155" align="center" bgcolor="#F7F7F7">Make</td>
                                        <td width="99" align="center" bgcolor="#F7F7F7">ของเข้า</td>
                                        <td width="148" align="center" bgcolor="#F7F7F7">Date in</td>
                                      </tr>
                                      <?php 
                                      $sql_select_stock = "select * from update_stock_tb where pid = '".$_GET['pid']."' order by id desc";
                                      $result_select_stock = @mysql_query($sql_select_stock, $connect);
                                      $num_select_stock =@mysql_num_rows($result_select_stock);
                                      
                                      for ($u=1; $u<=$num_select_stock; $u++) {
                                          
                                          $data_select_stock = @mysql_fetch_array($result_select_stock);
                                          
                                      ?>
                                      
                                      <tr>
                                        <td height="20" align="center" bgcolor="#F7F7F7"><?php echo $u; ?></td>
                                        <td align="center" bgcolor="#F7F7F7"><?php echo $data_select_stock['make']; ?></td>
                                        <td align="center" bgcolor="#F7F7F7"><?php echo $data_select_stock['real_recive']; ?></td>
                                        <td align="center" bgcolor="#F7F7F7"><?php echo $data_select_stock['date_in']; ?></td>
                                      </tr>
                                      <?php 
                                      }
                                      ?>
                                      
                                    </table>                                        
                                        <br />                                        
                                        <br />
										<?php
                                        if($_GET['sAction'] == 'edit'){	
                                        $sql_sAction = "SELECT * FROM manufacture_tb where pid ='".$_GET['pid']."' AND id = '".$_GET['id']."' order by id desc";
                                        $result_sAction =@mysql_query($sql_sAction, $connect);
                                        $data_sAction =@mysql_fetch_array($result_sAction);
                                        ?>
                                        <table width="460" border="0" align="center" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td width="116" height="30">จำนวน</td>
                                            <td width="344">
                                            <input type="text" name="n_product" value="<?php echo $data_sAction['num_product'];?>"  />
                                            </td>
                                          </tr>
                                          <tr>
                                            <td height="30">วันที่สั่งผลิต</td>
                                            <td>
                                            <input type="text" name="order_date" id="datepicker"  value="<?php echo $data_sAction['order_date'];?>" />
                                            </td>
                                          </tr>
                                          <tr>
                                            <td height="30">วันที่คาดว่าจะเข้า</td>
                                            <td>
                                            <input type="text" name="expect_date" id="datepicker_ex"  value="<?php echo $data_sAction['expect_date'];?>"/>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td height="30">สินค้าเข้าจริง</td>
                                            <td>
                                            <input type="text" name="real_product_edit"  value="<?php echo $data_sAction['real_product'];?>"/>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td height="30" valign="top">Comment</td>
                                            <td><textarea name="comment" id="comment" cols="45" rows="5" ><?php echo $data_sAction['comment'];?></textarea></td>
                                          </tr>
                                          <tr>
                                            <td height="30">&nbsp;</td>
                                            <td>
                                            <div class="demo">
                                            
                                            <!--<button>Submit</button>-->

                                            <input type="hidden" name="pid" value="<?php echo $_GET['pid'];?>" />
                                            <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
                                            <input name="Submit" type="submit" class="borderfrom" style="width:80px" value="EDIT">

                                            </div>
                                    
                                            </td>
                                          </tr>
                                        </table>											
											
                                            <?php }elseif($data_product['p_spare'] == '0' || $data_product['p_spare'] == ''){
												echo "<font color=#FF0000><b>ไม่สามารถสั่งสินค้าได้ เนื่องจากสินค้าใน Spare หมด</b></font><br><br>";
											}else{

											?>
                                        <table width="460" border="0" align="center" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td width="116" height="30">จำนวน</td>
                                            <td width="344">
                                            <input type="text" name="n_product" value="<?php echo $data_sAction['num_product'];?>"  />
                                            </td>
                                          </tr>
                                          <tr>
                                            <td height="30">วันที่สั่งผลิต</td>
                                            <td>
                                            <input type="text" name="order_date" id="datepicker"  value="<?php echo $data_sAction['order_date'];?>" />
                                            </td>
                                          </tr>
                                          <tr>
                                            <td height="30">วันที่คาดว่าจะเข้า</td>
                                            <td>
                                            <input type="text" name="expect_date" id="datepicker_ex"  value="<?php echo $data_sAction['expect_date'];?>"/>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td height="30" valign="top">Comment</td>
                                            <td><textarea name="comment" id="comment" cols="45" rows="5" ><?php echo $data_sAction['comment'];?></textarea></td>
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
                                        </table>
										
										<?php } ?>
                                        <br />
                                        <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-color:#999">
                                          <tr>
                                            <td width="4%" height="25" align="center">ลำดับ</td>
                                            <td width="5%" align="center">จำนวน</td>
                                            <td width="13%" align="center">วันที่คาดว่าจะเข้า</td>
                                            <td width="10%" align="center">สินค้าเข้าจริง</td>
                                            <td width="8%" align="center">สินค้าขาด</td>
                                            <td width="9%" align="center">วันที่สั่งผลิต</td>
                                            <td width="27%" align="center">Comment</td>
                                            <td width="24%" align="center">&nbsp;</td>
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
                                            <td align="center" bgcolor="#66FF00"><?php echo $data_product['num_product']; ?></td>
                                            <td align="center"><?php echo $data_product['expect_date']; ?> &nbsp;
                                            <a href="manufacture.php?pid=<?php echo $data_product['pid'];?>&id=<?php echo $data_product['id'];?>&sAction=edit">
                                            <img alt="Edit" src="images/1343377813_Modify.png" title="Edit"/></a></td>
                                            <td align="center" bgcolor="#FF0000"><?php echo $data_product['real_product']; ?></td>
                                            <td align="center">
											<?php 
											
											$fTotal =  $data_product['num_product']-$data_product['real_product']; 
											
											
											if($fTotal != '0' && $data_product['real_product'] != ''){
												echo "<font color=#FF0000><b>".$fTotal."</b></font>";
											}
											?></td>
                                            <td align="center"><?php echo $data_product['order_date']; ?></td>
                                            <td align="center"><?php echo $data_product['comment']; ?></td>
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
