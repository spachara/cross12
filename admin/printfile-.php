<?php
session_start();
require_once '../dbconnect.inc';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print</title>
<link href="cssstyle.css" rel="stylesheet" type="text/css" />
</head>

<body style="background:#fff;">
    <table width="980" height="150" border="0" align="left" cellpadding="0" cellspacing="0" style=" font-family: 'layiji_mahaniyom_v1.41regular'; font-size:20px;border:#333 1px solid; border-bottom:0px; border-right:0px; margin:0 auto; color:#000;">

		<?php

		
				$sql_update2 = "select * from order_product_tb where ready_time = '".$_GET['d']."' and round_update = '".$_GET['r']."'";
				$result_update2 = @mysql_query($sql_update2, $connect);
				$num_update2 =@mysql_num_rows($result_update2);
				
				for($i5=0;$i5<intval($num_update2);$i5++){
					
				$data_update2 =@mysql_fetch_array($result_update2);
				
					$arrProduct[$i5] = $data_update2['order_number'];
					
				}
						
			$arrProduct = array_unique( $arrProduct );
			$col=2;
			$a=0;
			foreach($arrProduct as $y => $key){

            $sql_order = "select * from order_tb where order_number = '".$key."' ";
			$result_order = @mysql_query($sql_order, $connect);
			$data_order =@mysql_fetch_array($result_order);
			?>
			<?php
			if($a==0)  echo "<tr>";
			$a++;
			if($a<=$col){        
			?>
            <td valign="top" width="490" style="border-bottom:#333 1px solid; border-right:#333 1px solid;">
            <div style="margin-left:10px; margin-top:10px; margin-bottom:10px;" >
            
            
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style=" font-family: 'layiji_mahaniyom_v1.41regular'; font-size:16px;">
			<tr><td width="60%">
			<span style="font-size:20px; line-height:1.2em;"><?php 
			$sql_update5 = "select * from order_product_tb where order_number = '".$key."' ";
			$sql_update5 .= "and ready_time = '".$_GET['d']."' and round_update = '".$_GET['r']."' and ready_sent <> '0' ";
			$result_update5 = @mysql_query($sql_update5, $connect);
			$num_update5 =@mysql_num_rows($result_update5);
			$order_to = '';

				for($i5=1;$i5<=intval($num_update5);$i5++){
				$data_update5 =@mysql_fetch_array($result_update5);
				    
					if($data_update5['order_type'] !=  $type){
					$type = $data_update5['order_type'];
					$order_to .= "Order number : ".$data_update5['order_number']."-".$data_update5['order_type']."<br>";
					}else{
					$order_to = "Order number : ".$data_update5['order_number']."-".$data_update5['order_type']."<br>";
					}
				}
			
			echo $order_to;
			$exName = explode('เบอร์โทรศัพท์',$data_order['order_address2']);
			
			echo ereg_replace('รหัสไปรษณีย์ : ','',ereg_replace('ชื่อ : ','',ereg_replace('ที่อยู่ : ','',ereg_replace('จังหวัด : ','',$exName[0]))));
			if($data_order['order_transport'] == 'ไปรษณีย์ส่งด่วน พิเศษ ( EMS )'){
				echo " ( EMS )<br>";
			}
			?></span>
            <td valign="top" style="border-left:#ccc 1px dotted; padding:0 10px;" width="40%">
            <span style="font-size:20px; display:table; margin:0px; font-weight:bold;">Shipped :</span>
            
            <?php
			$sql_update3 = "select * from order_product_tb where order_number = '".$key."' ";
			$sql_update3 .= "and ready_time = '".$_GET['d']."' and round_update = '".$_GET['r']."' and ready_sent <> '0' ";
			$result_update3 = @mysql_query($sql_update3, $connect);
			$num_update3 =@mysql_num_rows($result_update3);
			
				for($i=1;$i<=intval($num_update3);$i++){
				$data_update3 =@mysql_fetch_array($result_update3);
				
				
					
					$product_color = "select name from color_tb where c_code = '".$data_update3['order_p_color']."' ";
					$result_productcolor = @mysql_query($product_color, $connect);
					$data_productcolor =@mysql_fetch_array($result_productcolor);
				
					echo $i.". ".$data_update3['pro_code']." ".$data_productcolor['name']." ".$data_update3['order_p_size']." : ".$data_update3['order_p_stock']."<br>";
				
				} 
			 
            }?>
            </td></tr>
            </table>
            </div></td>
            <?php
            if ($a==$col){
            $a=0;
            ?>
            </tr>
            <?php
			}
			} #END foreach
			?>
            
    </table>

</body>
</html>
