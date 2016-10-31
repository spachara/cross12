<?php
	session_start();
	require_once '../dbconnect.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Products</title>
</head>
<style>
table, td, th {    
    text-align: center;
}
</style>
<body>
<table width="100%" border="1" cellpadding="0" cellspacing="0" class="table_3cell" style="font-size:12px; font-weight:normal; font-family:Tahoma, Geneva, sans-serif;">
                                         <tr>
                                           <td width="3%" height="40" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
                                           <td width="6%" height="40" bgcolor="#CCCCCC"><strong>Category</strong></td>
                                           <td width="6%" bgcolor="#CCCCCC"><strong>รหัสสินค้า</strong></td>
                                           <td width="5%" bgcolor="#CCCCCC"><strong>สี</strong></td>
                                           <td width="5%" bgcolor="#CCCCCC"><strong>size</strong></td>
                                           <td width="6%" bgcolor="#CCCCCC"><strong>In Stock</strong></td>
                                           <td width="7%" bgcolor="#CCCCCC"><strong>In Stock<br />
                                           (จอง)</strong></td>
                                           <td width="7%" bgcolor="#CCCCCC"><strong>Pre<br />
(พร้อมส่ง)</strong></td>
                                           <td width="7%" bgcolor="#CCCCCC"><strong>On hand</strong></td>
                                           <td width="6%" bgcolor="#CCCCCC"><strong>Pre-Order</strong></td>
                                           <td width="7%" bgcolor="#CCCCCC"><strong>Pre (จอง)</strong></td>
                                           <td width="6%" bgcolor="#CCCCCC"><strong>Spare</strong></td>
                                           <td width="8%" bgcolor="#CCCCCC"><strong>Spare (จอง)</strong></td>
                                           <td width="5%" bgcolor="#CCCCCC"><strong>Make</strong></td>
                                           <td width="11%" bgcolor="#CCCCCC"><strong>รวมสินค้า<br />
ที่ขายไป� ล้ว</strong></td>
                                           <td width="11%" bgcolor="#CCCCCC"><strong>รวมสินค้า<br />
ทั้งหมด</strong></td>
                                           <td width="11%" bgcolor="#CCCCCC"><strong>Import</strong></td>
                                         </tr>
                                         <?php
										 

										$sql_product = "SELECT p_category,p_code,p_color,p_size,p_stock,pid,p_pre,p_spare,p_stock,date_in FROM product_tb where ranking <> 0 order by pid desc";
										$result_product =@mysql_query($sql_product, $connect);
										$num_product =@mysql_num_rows($result_product);
										
										$sql_color = "select c_code,name from color_tb";
									    $result_color = @mysql_query($sql_color, $connect);
									    $data_color =@mysql_num_rows($result_color);										
										   
										for ($o_c=1; $o_c<=$data_color; $o_c++) {
											$c =@mysql_fetch_array($result_color);
											$arr_color[$c['c_code']] = $c['name']; 
										}
										
										for($i=1;$i<=intval($num_product);$i++){
										$data_product =@mysql_fetch_array($result_product);
										
										?>
                                         <tr>
                                           <td height="25" ><?php echo $f+$i;?></td>
                                           <td ><?php echo $data_product['p_category']; ?></td>
                                           <td ><a href="stock.php?code=<?php echo $data_product['p_code'];?>&amp;color=<?php echo $data_product['p_color']; ?>" style="text-decoration:underline"> <?php echo $data_product['p_code'];?></a></td>
                                           <td >
										   <?php                                            
                                           echo $arr_color[$data_product['p_color']];?>
                                           </td>
                                           <td ><?php echo $data_product['p_size']; ?></td>
                                           <td ><?php echo $data_product['p_stock']; ?></td>
                                           <td >
										   <?php
										   $product_send2 = 0;	 
										   $product_on_hand2 = 0;	
										    
										   $sql_count_sale = "select sum(product_number) as count_sale from temp_order_product where pid = '".$data_product['pid']."'";
										   $sql_count_sale .= " and buy_status = 'INSTOCK'";
										   $result_count_sale = @mysql_query($sql_count_sale, $connect);
										   $data_count_sale = @mysql_fetch_array($result_count_sale);
												
											$sql_order_product_hand2 = "SELECT sum(order_p_stock) as count_sent FROM order_product_tb WHERE pro_id = '".$data_product['pid']."' and order_type = 'IN' and tracking_number <> '' ";
											$result_order_product_hand2 =@mysql_query($sql_order_product_hand2, $connect);
											$num_order_product_hand2 =@mysql_fetch_array($result_order_product_hand2);
											
											$product_on_hand2 = $data_count_sale['count_sale']- $num_order_product_hand2['count_sent'];
											
											echo $product_on_hand2;
										   
										?></td>
                                           <td >
										   <?php
                                            
                                            $sql_buy_preorder1 = "SELECT sum(product_recive) as count_revPreorder FROM temp_order_product";
											$sql_buy_preorder1 .= " where pid ='".$data_product['pid']."'";
                                            $sql_buy_preorder1 .= " AND (buy_status = 'PREORDER' OR buy_status = 'SPARE') AND sent_status = 'READY'";
                                            $result_buy_preorder1 =@mysql_query($sql_buy_preorder1, $connect);
                                            $data_buy_preorder1 =@mysql_fetch_array($result_buy_preorder1);
											
											$productPre_on_hand2 = 0;
											
											$sql_order_preorder2 = "SELECT sum(order_p_stock) as count_sent FROM order_product_tb WHERE pro_id = '".$data_product['pid']."' and order_type = 'PRE' and tracking_number <> ''";
											$result_order_preorder2 =@mysql_query($sql_order_preorder2, $connect);
											$num_order_preorder2 =@mysql_fetch_array($result_order_preorder2);
											
											$productPre_on_hand2 = $data_buy_preorder1['count_revPreorder']- $num_order_preorder2['count_sent'];
											
                                            echo ($productPre_on_hand2 == '' ? "0" : $productPre_on_hand2);
                                            
                                            
                                            ?>
										   </td>
                                           <td >
                                           
												<?php												
												$product_stock = ($data_product['p_stock'] == '' ? "0" : $data_product['p_stock']);
												
												$product_temp_stock = 0;
												
												$product_temp_stock = ($data_count_sale['count_sale'] == '' ? "0" : $data_count_sale['count_sale']);
												
												
												$product_temp_stock_pre = 0;
												$sql_temp_order_hand_pre = "SELECT sum(product_number) as product_number FROM temp_order_product WHERE pid = '".$data_product['pid']."' and (buy_status = 'PREORDER' or buy_status = 'SPARE')";
												$sql_temp_order_hand_pre .= "AND sent_status = 'READY'";
												$result_temp_order_hand_pre =@mysql_query($sql_temp_order_hand_pre, $connect);
												$num_temp_order_hand_pre =@mysql_fetch_array($result_temp_order_hand_pre);
												$product_temp_stock_pre = $num_temp_order_hand_pre['product_number'];

												
												$product_send = 0;
												
												$sql_order_product_hand = "SELECT  sum(order_p_stock) as order_p_stock FROM order_product_tb WHERE tracking_number <> '' AND"; //order_number = '".$data_update3['order_number']."'
												$sql_order_product_hand .= " pro_id = '".$data_product['pid']."' ";
												$result_order_product_hand =@mysql_query($sql_order_product_hand, $connect);
												$num_order_product_hand =@mysql_fetch_array($result_order_product_hand);
												$product_send = $num_order_product_hand['order_p_stock'];												
												

													$product_on_hand = ($product_stock + $product_temp_stock + $product_temp_stock_pre) - $product_send;

												
												echo $product_on_hand;
                                           ?>
                                           
                                           </td>
                                           <td ><?php echo $data_product['p_pre']; ?></td>
                                           <td >
										   <?php
										   
											$sql_buy_preorder = "SELECT sum(product_number-product_recive) as count_buyPreorder FROM temp_order_product where pid ='".$data_product['pid']."'";
											$sql_buy_preorder .= " AND buy_status = 'PREORDER' AND sent_status = 'RESERVE'";
											$result_buy_preorder =@mysql_query($sql_buy_preorder, $connect);
											$data_buy_preorder =@mysql_fetch_array($result_buy_preorder);
										    echo ($data_buy_preorder['count_buyPreorder'] == '' ? "0" : $data_buy_preorder['count_buyPreorder']);
										   
										   
										?></td>
                                           <td ><?php echo $data_product['p_spare']; ?></td>
                                           <td ><?php
                                        $sql_buy_spare = "SELECT sum(product_number-product_recive) as count_buySpare FROM temp_order_product where pid ='".$data_product['pid']."'";
                                        $sql_buy_spare .= " AND buy_status = 'SPARE' AND sent_status = 'RESERVE'";
                                        $result_buy_spare =@mysql_query($sql_buy_spare, $connect);
                                        $data_buy_spare =@mysql_fetch_array($result_buy_spare);
										
										echo ($data_buy_spare['count_buySpare'] == '' ? "0" : $data_buy_spare['count_buySpare']);
										
                                        ?></td>
                                           <td ><?php
											$sql_manu = "SELECT sum(num_product) as num_product  FROM manufacture_tb where pid ='".$data_product['pid']."' and order_status = '0'";
											$result_manu =@mysql_query($sql_manu, $connect);
											$num_manu =@mysql_fetch_array($result_manu);
										echo ($num_manu['num_product'] == '' ? "0" : $num_manu['num_product']);
										?></td>
                                           <td >
											 <?php 
                                                       $product_send2 = 0;	 
                                                       $product_on_hand2 = 0;	
                                                            
                                                        $sql_order_product_hand2 = "SELECT sum(order_p_stock) as order_p_stock FROM order_product_tb WHERE pro_id = '".$data_product['pid']."' and order_type = 'IN' and tracking_number <> ''";
                                                        $result_order_product_hand2 =@mysql_query($sql_order_product_hand2, $connect);
                                                        $num_order_product_hand2 =@mysql_fetch_array($result_order_product_hand2);
                                                        $product_send2 = $num_order_product_hand2['order_p_stock'];
                                                        
                                                        $product_instock = $data_count_sale['count_sale']- $product_send2;
                                            
                                                        $product_on_pre = ($data_buy_preorder['count_buyPreorder'] == '' ? "0" : $data_buy_preorder['count_buyPreorder']);
                                                   
                                                        $total_all = $product_instock + $product_on_pre;
                                                        
                                                        echo $total_all;
                                                   
                                                   ?>                                          
                                           </td>
                                           <td >
											<?php echo $total_all + $data_product['p_stock']; ?>                                           
                                           </td>
                                           <td ><?php echo $data_product['date_in'];?></td>
  </tr>
                                         <? } ?>
                                       </table>
                                       </body>
</html>