<?php
session_start();
require_once '../dbconnect.inc';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_3cell" style="font-size:12px; font-weight:normal; font-family:Tahoma, Geneva, sans-serif;">
     <tr>
       <td width="16%" height="40" align="center" bgcolor="#CCCCCC"><strong>Category</strong></td>
       <td width="17%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
       <td width="28%" align="center" bgcolor="#CCCCCC"><strong>รหัสสินค้า</strong></td>
       <td width="14%" align="center" bgcolor="#CCCCCC"><strong>In Stock</strong></td>
       <td width="12%" align="center" bgcolor="#CCCCCC"><strong>ขายไปแล้ว</strong></td>
       <td width="13%" align="center" bgcolor="#CCCCCC"><strong>รวมทั้งสิ้น</strong></td>
     </tr>
     <?php
     
    $sql_product = "SELECT * FROM product_tb where pid = '".$_GET['id']."'";
    $sql_product .= " ORDER BY pid desc";
    $result_product =@mysql_query($sql_product, $connect);
    $num_product =@mysql_num_rows($result_product);
    
    for($i=1;$i<=intval($num_product);$i++){
    $data_product =@mysql_fetch_array($result_product);
    
    $chk_pic1 = "../images/products/".$data_product['p_code']."/".$data_product['p_color']."/s.jpg";
    
    ?>
     <tr>
       <td height="25" align="center" bgcolor="#F5F5F5"><?php echo $data_product['p_category']; ?></td>
       <td align="center" bgcolor="#F5F5F5"><img alt="<?php echo $data_product['p_name'];?>" title="<?php echo $data_product['p_name'];?>" src="<?php echo $chk_pic1;?>" height="80" /></td>
       <td align="center" bgcolor="#F5F5F5"><a href="stock.php?code=<?php echo $data_product['p_code'];?>&amp;color=<?php echo $data_product['p_color']; ?>" style="text-decoration:underline" target="_blank"> <?php echo $data_product['p_code'];?></a>
       &nbsp;&nbsp;
       <?php echo $data_product['p_size'];?>&nbsp;&nbsp;
       <?php 
		$sql_color = "select name from color_tb where c_code = '".$data_product['p_color']."' ";
		$result_color = @mysql_query($sql_color, $connect);
		$data_color =@mysql_fetch_array($result_color);
	   
	   echo $data_color['name'];?>
       </td>
       <td align="center" bgcolor="#F5F5F5"><?php echo $data_product['p_stock']; ?></td>
       <td align="center" bgcolor="#F5F5F5">
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
			
			$product_instock = $data_count_sale['count_sale']- $product_send2;
			
			$product_instock;

			$sql_buy_preorder = "SELECT sum(product_number-product_recive) as count_buyPreorder FROM temp_order_product where pid ='".$data_product['pid']."'";
			$sql_buy_preorder .= " AND buy_status = 'PREORDER' AND sent_status = 'RESERVE'";
			$result_buy_preorder =@mysql_query($sql_buy_preorder, $connect);
			$data_buy_preorder =@mysql_fetch_array($result_buy_preorder);
			$product_on_pre = ($data_buy_preorder['count_buyPreorder'] == '' ? "0" : $data_buy_preorder['count_buyPreorder']);
	   
			$total_all = $product_instock + $product_on_pre;
			
			echo $total_all;
	   
	   ?>
       
       
       </td>
       <td align="center" bgcolor="#F5F5F5"><?php echo $total_all + $data_product['p_stock']; ?></td>
     </tr>
     <? } ?>
   </table>
</body>
</html>
