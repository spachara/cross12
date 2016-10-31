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
       <td width="6%" height="40" align="center" bgcolor="#CCCCCC"><strong>Category</strong></td>
       <td width="7%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
       <td width="6%" align="center" bgcolor="#CCCCCC"><strong>รหัสสินค้า</strong></td>
       <td width="6%" align="center" bgcolor="#CCCCCC"><strong>In Stock</strong></td>
       <td width="6%" align="center" bgcolor="#CCCCCC"><strong>Pre-Order</strong></td>
       <td width="6%" align="center" bgcolor="#CCCCCC"><strong>Spare</strong></td>
       <td width="6%" align="center" bgcolor="#CCCCCC"><strong>Spare (จอง)</strong></td>
     </tr>
     <?php
	$sql_buy_spare = "SELECT * FROM temp_order_product where ";
	$sql_buy_spare .= " buy_status = 'SPARE' AND sent_status = 'RESERVE'";
	$result_buy_spare =@mysql_query($sql_buy_spare, $connect);
    $num_buy_spare =@mysql_num_rows($result_buy_spare);

    for($s=1;$s<=intval($num_buy_spare);$s++){
	$data_buy_spare =@mysql_fetch_array($result_buy_spare);
	
		
		$arr_pid[$data_buy_spare['pid']] = $data_buy_spare['pid'];

		if($arr_pid[$data_buy_spare['pid']]){
		$pNum[$data_buy_spare['pid']] = $pNum[$data_buy_spare['pid']] + $data_buy_spare['product_number'];
		}else{
		$pNum[$data_buy_spare['pid']] = $data_buy_spare['product_number'];
		}
		
		
		
	}
	
	
	foreach($arr_pid as $y){
		
    $sql_product = "SELECT * FROM product_tb where pid = '".$y."' ";
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
       <br />
       <?php echo $data_product['p_size'];?>&nbsp;&nbsp;
       <?php 
		$sql_color = "select name from color_tb where c_code = '".$data_product['p_color']."' ";
		$result_color = @mysql_query($sql_color, $connect);
		$data_color =@mysql_fetch_array($result_color);
	   
	   echo $data_color['name'];?>
       </td>
       <td align="center" bgcolor="#F5F5F5"><?php echo $data_product['p_stock']; ?></td>
       <td align="center" bgcolor="#F5F5F5"><?php echo $data_product['p_pre']; ?></td>
       <td align="center" bgcolor="#F5F5F5"><?php echo $data_product['p_spare']; ?></td>
       <td align="center" bgcolor="#F5F5F5"><?php echo $pNum[$y];?></td>
     </tr>
     <?php } } ?>
   </table>
</body>
</html>
