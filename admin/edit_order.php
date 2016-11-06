<?php
session_start();
require_once '../dbconnect.inc';
require("../class.phpmailer.php");

if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) { 
	echo "<script>location.href='index.php'</script>";
}



if($_POST['UPDATE'] == 'UPDATE'){
	
					if($_POST['tran'] != '0' ){
						
					if($_POST['tran'] == '2'){
						$order_status = 1;
					}else{
						$order_status = 2;
					}
					
					$sql_update = "UPDATE order_tb SET order_status = '".$order_status."', tranfer_status = '".$_POST['tran']."', payment_status = '".$_POST['tran']."'";
					$sql_update .= ", tranfer_value = '".$_POST['tran_val']."' where order_number = '".$_POST['order_number']."'";
					$result_update = @mysql_query($sql_update, $connect);
					
					

						
					$sql_update_payment = "UPDATE payment_tb SET payment_status = '".$_POST['tran']."', tranfer_value = '".$_POST['tran_val']."'";
					$sql_update_payment .= " where order_number like '".$_POST['order_number']."%'";
					$result_update_payment = @mysql_query($sql_update_payment, $connect);
	
					}
					
					?>
								  <script>
									location.href='edit_order.php?n=<?php echo $_POST['order_number'];?>';
								  </script>
					<?php
}

if($_POST['CANCEL'] == 'Cancel'){
	
		
		$sql_txt = "SELECT * FROM txt_tb WHERE txt_id = '23' ";
		$result_txt =@mysql_query($sql_txt, $connect);
		$data_txt =@mysql_fetch_array($result_txt);
		
		
		$sql_tmp = "SELECT * FROM temp_order_product WHERE order_number = '".$_POST['order_number']."' ";
		$result_tmp = @mysql_query($sql_tmp, $connect);
		$num_temp = @mysql_num_rows($result_tmp);
		
		for($t=1;$t<=intval($num_temp);$t++){
		$data_tmp = @mysql_fetch_array($result_tmp);
		

				if($data_tmp['buy_status'] == 'INSTOCK' && $data_tmp['sent_status'] == 'READY'){
					
					$update_product = "UPDATE product_tb SET p_stock = p_stock+".$data_tmp['product_number']." WHERE pid = '".$data_tmp['pid']."' ";
					@mysql_query($update_product, $connect);
					
				}elseif($data_tmp['buy_status'] == 'PREORDER' && $data_tmp['sent_status'] == 'READY'){
					
					$update_product = "UPDATE product_tb SET p_stock = p_stock+".$data_tmp['product_number']." WHERE pid = '".$data_tmp['pid']."' ";
					@mysql_query($update_product, $connect);

				}elseif($data_tmp['buy_status'] == 'PREORDER' && $data_tmp['sent_status'] == 'RESERVE'){
					
					$update_product = "UPDATE product_tb SET p_pre = p_pre+".$data_tmp['product_number']." WHERE pid = '".$data_tmp['pid']."' ";
					@mysql_query($update_product, $connect);
					 if($data_tmp['product_recive'] > 0)
					{
						$update_product = "UPDATE product_tb SET p_stock = p_stock+".$data_tmp['product_recive']." WHERE pid = '".$data_tmp['pid']."' ";
						@mysql_query($update_product, $connect);
					}

				}elseif($data_tmp['buy_status'] == 'SPARE' && $data_tmp['sent_status'] == 'RESERVE'){
					
					$update_product = "UPDATE product_tb SET p_spare = p_spare+".$data_tmp['product_number']." WHERE pid = '".$data_tmp['pid']."' ";
					@mysql_query($update_product, $connect);
					 if($data_tmp['product_recive'] > 0)
					{
						$update_product = "UPDATE product_tb SET p_stock = p_stock+".$data_tmp['product_recive']." WHERE pid = '".$data_tmp['pid']."' ";
						@mysql_query($update_product, $connect);
					}

				}elseif($data_tmp['buy_status'] == 'SPARE' && $data_tmp['sent_status'] == 'READY'){
					
					$update_product = "UPDATE product_tb SET p_stock = p_stock+".$data_tmp['product_number']." WHERE pid = '".$data_tmp['pid']."' ";
					@mysql_query($update_product, $connect);

				}
				
				
				
			$sql_delete_detail = "DELETE FROM temp_order_product WHERE temp_id = '".$data_tmp['temp_id']."' ";
			@mysql_query($sql_delete_detail, $connect);
		
		}
		
		
		
					$edit_order = "UPDATE order_tb SET order_status = '0', payment_status = '0', tranfer_status = 'NULL' WHERE order_number = '".$_POST['order_number']."' ";
					@mysql_query($edit_order, $connect);
		
					$messages = "เรียนคุณ ".$_POST['name_emp']."<br><br>";
					
					$messages .= 'อีเมลล์นี้เป็นการยืนยันว่าทางเราได้รับการยกเลิกออร์เดอร์ เลขที่ '.'"'.$_POST['val_number'].'" ของท่านแล้ว<br>';
					$messages .= "หากท่านมีความประสงค์ต้องการสินค้ารายการนี้  กรุณาทำรายการสั่งซื้อใหม่คะ<br>";
					$messages .= $data_txt['txt_detail_th'];
		

					//echo $messages;
					
					$mail = new PHPMailer();
					
					$body = "PHPMailer."; /// ใส่ข้อความข้อคุณ
					
					$mail->CharSet = "utf-8";
					$mail->IsSMTP(); // telling the class to use SMTP
					$mail->Host       = "smtp@gmail.com"; // SMTP server
					$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
															   // 1 = errors and messages
															   // 2 = messages only
					$mail->SMTPAuth   = true;                  // enable SMTP authentication
					$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
					$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
					$mail->Port       = 465;                   // set the SMTP port for the GMAIL server 465
					$mail->Username   = "cross12mail@gmail.com";  // GMAIL username
					$mail->Password   = "cross2014";            // GMAIL password
					
					$mail->SetFrom("cross12mail@gmail.com", "Cross Twelfth");
					$mail->AddReplyTo("cross12mail@gmail.com", "No-Reply");
					$mail->Subject = "Cross Twelfth :: Cancel Order"; // หัวข้อในการส่ง email นั้นๆ
					
					$body = $messages;
					$mail->MsgHTML($body);
					
					$mail->AddAddress($_POST['email_emp'], $_POST['name_emp']); // ผู้รับคนที่หนึ่ง , ชื่อผู้รับ ** กรุณีผู้สองคุณ สามารถเพิ่มบรรทัดนี้อีกได้
					$mail->AddBCC("amanichanon@gmail.com; cross12th@hotmail.com; crosstwelfth@yahoo.com; pitchaya@thetreedesign.com", "Orm");
		
					if($mail->Send()){
		
					?>
								  <script>
									location.href='edit_order.php?n=<?php echo $_POST['order_number'];?>';
								  </script>
					<?php
	
					}
}


	$sql_order = "SELECT * FROM order_tb WHERE order_number = '".$_GET['n']."' ";
	$result_order =@mysql_query($sql_order, $connect);
	$data_order=@mysql_fetch_array($result_order);
	
	
	if($data_order['ems_date'] != ''){
		$date2 = $data_order['ems_date'];
		$day_no2 = date('d',strtotime($date2));
		$month_no2 = date('m',strtotime($date2));
		$year2 = date('Y',strtotime($date2));
		$date_sum = $day_no2."/".$month_no2."/".$year2;
	}
	
	
	
	function times($p){
		$test = date($p);
		$y = date("Y",strtotime($test));
		$m = date("m",strtotime($test));
		$d = date("d",strtotime($test));
		$sum = $y."-".$m."-".$d;	
		return $sum;
	}
	function str_date($str_date){
		$date = $str_date;
		$day_no = date('w',strtotime($date));
		$day_th = array('อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์');
		//$day_th[$day_no];
		$month_no = date('n',strtotime($date))-1;
		$month_th = array('มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
		//$month_th[$month_no];
		$day = date('d',strtotime($date));
		$year = date('Y',strtotime($date))+543;
		/*$day_th[$day_no].", ".$day." ".$month_th[$month_no]." ".$year;*/	
		return "วัน".$day_th[$day_no]."ที่ ".$day." ".$month_th[$month_no]." พ.ศ.".$year;
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

<link href="css.css" rel="stylesheet" type="text/css" />
<link href="cssstyle.css" rel="stylesheet" type="text/css" />

<!--<link type="text/css" href="datepicker/css/blitzer/jquery-ui-1.8.22.custom.css" rel="stylesheet" />-->
<!--<script type="text/javascript" src="datepicker/js/jquery-1.7.2.min.js"></script>-->
<script type="text/javascript" src="datepicker/js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript">
			$(function(){

				/*// Datepicker
				$('#datepicker').datepicker({
					inline: true
				*/
				// Datepicker
				$('#datepicker').datepicker({
					yearRange: "1950:+0",
					changeMonth: true,
					changeYear: true,
					dateFormat: 'dd/mm/yy'

				});

				
				//hover states on the static widgets
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); },
					function() { $(this).removeClass('ui-state-hover'); }
				);

			});
</script>
<script language="JavaScript">
function number_only()
{
	key=event.keyCode
	if(key<48||key>57)
	event.returnValue = false;
}
</script>

<!--Fancy Box-->
<!--<script type="text/javascript" src="../js/fancy_box/jquery-1.8.2.min.js"></script>-->
<script type="text/javascript" src="../js/fancy_box/jquery.fancybox.js"></script>
<link rel="stylesheet" type="text/css" href="../css/fancy_box/jquery.fancybox.css?v=2.1.2" media="screen" />
	
<link rel="stylesheet" type="text/css" href="../css/fancy_box/jquery.fancybox-buttons.css" />
<script type="text/javascript" src="../js/fancy_box/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="../js/fancy_box/button-helper.js"></script>
<style type="text/css">
	.fancybox-custom .fancybox-skin {
		box-shadow: 0 0 50px #222;
	}
</style>    
<!--End Fancy Box-->
</head>

<body> 
	<div class="page_container">
    <div class="shadow_l"></div>
	<div class="shadow_r"></div>  
    	<!--Header--> 
    	<?php include('header.php');?>
        <!--Header-->
        <div class="container_content" style="width:auto !important;">
            <!--Main Menu-->
            <?php //include('mainmenu.php');?>
            <!--End Main Menu-->
            
                                	<!--Edit Navigator-->
                                   <div class="navigator">
                                       
                                        <a href="new_order.php">Order</a>
                                        >
                                        <a href="#">แก้ไขสถานะใบสั่งซื้อ</a>
                                        
                                   </div>
                                   <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2" >
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">แก้ไขสถานะใบสั่งซื้อ</div>
                    </div>
                    <div class="block_style2_content">

                     <!--Coppy Module Clear-->
                                   
                     <form method="post" enctype="multipart/form-data" name="myform">
                     <input type="hidden" name="order_number" value="<?php echo $data_order['data_order'];?>" />
				<div class="page_conten_r">
                                   
                     <!--Coppy Module Clear-->
                      <div class="module_3">
                       		<div class="title">

                                <div class="l"></div>
                                <div class="r"></div>
                                <div class="t"><h2><!--เพิ่มรูปสไลด์--></h2> </div>                  
                      		</div>
                      <div class="conten">
                      <!--ใสข้อมูล ตรงนี้-->
                      <!--ตาราง 3 Cell-->
                      <div class="title-top">&nbsp;<!--Impossible-->
                          <?php
						  $number = substr($data_order['order_number'],0,15);
						  ?>
                      </div>


                        <b>วันที่สั่งซื้อ :</b> <?php echo $data_order['date_in'];?><br />
                        <b>สถานะ :</b> <b>
                                                <?php 
													if($data_order['order_status']==5){
														echo "<font color=#00FF00>แจ้งโอนเงิน/รอเช็คยอดเงิน</font>";
													}elseif($data_order['order_status']==0){
														echo "<font color=#6600CC>ยกเลิกใบสั่งซื้อ</font>";
													}elseif($data_order['order_status']==1){
														echo "<font color=#000000>รอชำระค่าสินค้า</font>";
													}elseif($data_order['order_status']==2){
														echo "<font color=#FF0000>ได้รับชำระเงินแล้ว/รอจัดส่งสินค้า</font>";
													}elseif($data_order['order_status']==3){
														echo "<font color=#0000FF>จัดส่งสินค้าเรียบร้อยแล้ว</font>";
													}elseif($data_order['order_status']==4){
														echo "<font color=#00CC00>Complete</font>";
													}
												
												?>
                        </b><br />
                        <?php 
						if($data_order['order_status']==4){ echo "<b>วันที่ชำระเงิน </b> <font color=\"#FF0000\"><b>".$data_order['payment_date']."</b></font><br />"; }
                        //if($data_order['order_status']==3){?>
                        <!--<b>หมายเลขพัสดุ :</b> <font color="#FF0000"><b><?php echo $data_order['ems_number'];?></b></font><br />
                        <b>วันที่ส่งสินค้า :</b> <font color="#FF0000"><b><?php echo $data_order['ems_date'];?></b></font>-->
                       
                       <?php
						  $sql_payment = "select * from payment_tb";
						  $sql_payment .= " where order_number like '".$data_order['order_number']."%'";
						  $result_payment = @mysql_query($sql_payment, $connect);
						  $data_payment = @mysql_fetch_array($result_payment);
					   	
						  echo "<b>ยอดที่ชำระ : </b> ".number_format($data_payment['total_price'],2);
						  echo "<br><b>วันเวลาที่ชำระ : </b> ".$data_payment['payment_date']." เวลา ".$data_payment['payment_time'];
						  echo "<br><b>ธนาคาร : </b> ".$data_payment['bank_tranfer'];
					   
					   
					   ?>
                       
                       
                       <br />
                       
                        <?php //}
                        
                        if($data_order['order_group']!='' && $data_order['order_group']!='-PRE'){?>
                        <b>จัดส่งพร้อมกับ :</b> <font color="#FF3300"><b><?php echo $data_order['order_group'];?></b></font><br />
                        <?php }?>
                        
                        <b>สถานะโอนเงิน :</b>
                        
                        <select name="tran" >
                            <option value="0" <?php echo ($data_order['tranfer_status'] == '0' ? "selected=selected" : "" );?> ></option>
                            <option value="1" <?php echo ($data_order['tranfer_status'] == '1' ? "selected=selected" : "" );?>>โอนพอดี</option>
                            <option value="2" <?php echo ($data_order['tranfer_status'] == '2' ? "selected=selected" : "" );?>>โอนขาด</option>
                            <option value="3" <?php echo ($data_order['tranfer_status'] == '3' ? "selected=selected" : "" );?>>โอนเกิน</option>
                          </select>                        
                        
                        <input type="text" name="tran_val" value="<?php echo $data_order['tranfer_value'];?>" style="width:50px" />
						&nbsp;&nbsp;<b> บาท</b>
                        <input type="submit" name="UPDATE" value="UPDATE"  />
                        <br /><br />


    	<section class="paragraph">
            <hgroup class="titleModule">
                <h2>
				<?php                        
                $sql_insert_order3 = "select * from order_tb where order_number = '".$_GET['n']."'";
                $result_insert_order3 = @mysql_query($sql_insert_order3, $connect);
                $num_order3 = @mysql_num_rows($result_insert_order3);

			   for($p3=1;$p3<=intval($num_order3);$p3++){
			   $data_order3= @mysql_fetch_array($result_insert_order3);


					$sql_insert_order2 = "select * from order_tb where order_number = '".$data_order3['order_number']."'";
					$result_insert_order2 = @mysql_query($sql_insert_order2, $connect);
					$num_order2 = @mysql_num_rows($result_insert_order2);
					$data_order2= @mysql_fetch_array($result_insert_order2);
					
					if($num_order2 == 2){ 
						
						$val_order = $data_order2['order_number']."-IN | ".$data_order2['order_number']."-PRE";
					}else{
						$val_order = $data_order2['order_number']."-".$data_order2['order_type'];
					}
			   }
                ?>
                
                ORDER NUMBER <?php echo $val_order;?></h2>
            </hgroup>        
            <section class="paragraph03">
				<section class="blogOrder" style="width:auto !important; margin:0 20px !important; border-left:0px !important;">
			<?php
			
			$sql_insert_order4 = "select * from order_tb where order_number = '".$_GET['n']."'";
			$result_insert_order4 = @mysql_query($sql_insert_order4, $connect);
			$num_order4 = @mysql_num_rows($result_insert_order4);
			
			
			for($i=1;$i<=intval($num_order4);$i++){
			$data_order4= @mysql_fetch_array($result_insert_order4);
			
			if($data_order4['order_type'] == "IN"){ 
									
			
			?>
            <hgroup class="titleModule">
                <h2>IN-STOCK ITEM</h2>
            </hgroup>        
                	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                    	<tr class="titleTable_order">
                        	<td align="center" valign="middle"><p>Buying Item</p><span>รายการที่ซื้อ</span></td>
                        	<td width="150" align="center" valign="middle">Tracking No.<br />เลขที่ส่งของ</td>
                        	<td width="100" align="center" valign="middle"><p>Amount</p><span>จำนวน</span></td>
                        	<td width="150" align="center" valign="middle" ><p>Price/Unit</p><span>ราคาต่อหน่วย</span></td>
                        	<td width="150" align="center" valign="middle" >Total Price ราคารวม</td>
                       	</tr>
						<?php

						   $sql_insert_product = "select * from order_product_tb where order_number = '".$data_order4['order_number']."' and order_type = '".$data_order4['order_type']."'";
						   $result_insert_product = @mysql_query($sql_insert_product, $connect);
						   $num_product = @mysql_num_rows($result_insert_product);
						   
						   for($p=1;$p<=intval($num_product);$p++){
						   $data_order_product = @mysql_fetch_array($result_insert_product);
						   
						   $grand_total = $grand_total + ($data_order_product['order_p_price']*$data_order_product['order_p_stock']);
						   
						   $trancking_date = "";
							if ($data_order_product['trancking_date'] != "") {
						  	 $trancking_date = substr($data_order_product['trancking_date'], 8 , 2)."/".substr($data_order_product['trancking_date'], 5, 2)."/".substr($data_order_product['trancking_date'], 0, 4);
							}
                        ?>
                        <tr>
                        	<td align="center" valign="middle">
                        	  <strong><img alt="" title="" src="../images/products/<?php echo $data_order_product['pro_code'];?>/<?php echo $data_order_product['order_p_color'];?>/s.jpg" height="100" /><br />
                       	      #CODE :<?php echo $data_order_product['pro_code'];?> 
                              #SIZE : <?php echo $data_order_product['order_p_size'];?>
                              #Color : <?php 
								$sql_color = "select name from color_tb where c_code = '".$data_order_product['order_p_color']."' ";
								$result_color = @mysql_query($sql_color, $connect);
								$data_color =@mysql_fetch_array($result_color);
							  echo $data_color['name'];
							  
							  ?>
                               <?php echo $data_order_product['order_p_name'];?>
                              </strong></td>
                        	<td align="center" valign="middle"><?php echo $data_order_product['tracking_number']."<br>".$trancking_date;?></td>
                            <td align="center" valign="middle">
                            	<?php echo $data_order_product['order_p_stock'];?>
                            </td>
                            <td align="center" valign="middle">
                            	<strong><?php echo number_format($data_order_product['order_p_price']);?></strong>
                            </td>
                            <td align="center" valign="middle">
                            <strong><?php echo $data_order_product['order_p_stock'] * $data_order_product['order_p_price'];?></strong>
                            </td>
                        </tr>
						<?php }  ?>
                        <tr>
                        	<td colspan="3">&nbsp;
                        	  
                      	  </td>
                        	<td class="hilight" align="center" valign="middle">TOTAL</td>
                            <td class="hilight" align="center" valign="middle"><strong><?php echo number_format($grand_total);?></strong> <strong><?php echo ($_SESSION['sess_language'] == 'eng' ? "Baht" : "บาท");?></strong></td>
                        </tr>
                    </table>
            <br />
            <br />
			<?php $inStock = '1'; } 
			
			
			if($data_order4['order_type'] == "PRE"){ 

			?>       
            <hgroup class="titleModule">
                <h2>PRE-ORDER ITEM</h2>
            </hgroup>        
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                    	<tr class="titleTable_order">
                    	  <td align="center" valign="middle" style="border-left:#ebebeb 1px solid;"><p>Buying Item</p><span>รายการที่ซื้อ</span></td>
                    	  <td width="150" align="center" valign="middle">Tracking No.<br />เลขที่ส่งของ</td>
                       	  <td width="100" align="center" valign="middle"><p>Amount</p><span>จำนวน</span></td>
                          <td width="150" align="center" valign="middle" ><p>Price/Unit</p><span>ราคาต่อหน่วย</span></td>
                          <td width="150" align="center" valign="middle" >Total Price ราคารวม</td>
                        </tr>
						<?php

						   $sql_insert_product2 = "select * from order_product_tb where order_number = '".$data_order4['order_number']."' and order_type = '".$data_order4['order_type']."'";
						   $result_insert_product2 = @mysql_query($sql_insert_product2, $connect);
						   $num_product2 = @mysql_num_rows($result_insert_product2);
						   
						   for($p2=1;$p2<=intval($num_product2);$p2++){
						   $data_order_product2 = @mysql_fetch_array($result_insert_product2);
						   
						   $grand_total2 = $grand_total2 + ($data_order_product2['order_p_price']*$data_order_product2['order_p_stock']);

						   $trancking_date2 = "";						   
						   if ($data_order_product2['trancking_date'] != "") {
						  		 $trancking_date2 = substr($data_order_product2['trancking_date'], 8 , 2)."/".substr($data_order_product2['trancking_date'], 5, 2)."/".substr($data_order_product2['trancking_date'], 0, 4);
							}
                        ?>
                        <tr>
                    	  <td align="center" valign="middle" style="border-left:#ebebeb 1px solid;">
                    	    <strong><img alt="" title="" src="../images/products/<?php echo $data_order_product2['pro_code'];?>/<?php echo $data_order_product2['order_p_color'];?>/s.jpg" height="100" /><br />
               	          #CODE :<?php echo $data_order_product2['pro_code'];?> #SIZE : <?php echo $data_order_product2['order_p_size'];?> <?php echo $data_order_product2['order_p_name'];?></strong></td>
                    	  <td align="center" valign="middle"><?php echo $data_order_product2['tracking_number']."<br>".$trancking_date2;?></td>
                        	<td align="center" valign="middle">
                            	<?php echo $data_order_product2['order_p_stock'];?>
                            </td>
                            <td align="center" valign="middle">
                            	<strong><?php echo number_format($data_order_product2['order_p_price']);?></strong>
                            </td>
                            <td align="center" valign="middle">
							<strong><?php echo $data_order_product2['order_p_stock'] * $data_order_product2['order_p_price'];?></strong>
                            </td>
                        </tr>
						<?php }  ?>
                        <tr>
                          <td colspan="3">&nbsp;</td>
                          <td class="hilight" align="center" valign="middle">TOTAL</td>
                            <td class="hilight" align="center" valign="middle"><strong><?php echo number_format($grand_total2);?></strong> <strong><?php echo ($_SESSION['sess_language'] == 'eng' ? "Baht" : "บาท");?></strong></td>
                        </tr>
                    </table>  
                    <input type="hidden" name="product_total_pre" value="<?php echo $product_total_pre;?>" />
                    <input type="hidden" name="grand_total_pre" value="<?php echo $grand_total_pre;?>" />
                    
                    <br /><br />
                    
            <?php 
			 $preStock = '1';
			 }
			
			
			
			} // end for
			if ($inStock == '1') {

		   $sql_order_instock = "select * from order_tb where order_number = '".$_GET['n']."' and order_type = 'IN'";
		   $result_order_instock = @mysql_query($sql_order_instock, $connect);
		   $data_order_instock = @mysql_fetch_array($result_order_instock);
				
				if($data_order_instock['order_transport'] == "Express shipping ( EMS )"){
					$tran_eng = "Express shipping ( EMS )";
					$tran_thai = "พัสดุลงทะเบียน ด่วนพิเศษ";
				}else{
					$tran_eng = "Registered air mail";
					$tran_thai = "พัสดุลงทะเบียนธรรมดา";
				}
				
			?>
            <hgroup class="titleModule">
                <h2>IN-STOCK SHIPPING</h2>
            </hgroup>        
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    
                        <tr class="twoTable">

                        	<td width="48%" align="center" valign="middle">
                                <?php echo $data_order_instock['order_transport'];?>
                            </td>
                            <td width="52%" align="center" valign="middle">
                            	<strong>
                                <?php echo $data_order_instock['order_transport_status'];?>
                                </strong>
                          </td>
                        </tr>

                    </table>  
			<?php
			
			 }
            if ($preStock == '1') {


		   $sql_order_instock2 = "select * from order_tb where order_number = '".$_GET['n']."' and order_type = 'PRE'";
		   $result_order_instock2 = @mysql_query($sql_order_instock2, $connect);
		   $data_order_instock2 = @mysql_fetch_array($result_order_instock2);
				
				if($data_order_instock2['order_transport'] == "Express shipping ( EMS )"){
					$tran_eng2 = "Express shipping ( EMS )";
					$tran_thai2 = "พัสดุลงทะเบียน ด่วนพิเศษ";
				}else{
					$tran_eng2 = "Registered air mail";
					$tran_thai2 = "พัสดุลงทะเบียนธรรมดา";
				}

				 
			if ($data_order_instock['order_group'] != '') {?>
				<br /><br />
                 <font color="#FD8973" style="font-weight:bold">จัดส่งสินค้าทั้งหมดพร้อมกัน</font>
			<?php }  ?>
                    <br /><br />
                    <hgroup class="titleModule">
                        <h2>PRE-ORDER SHIPPING</h2>
                    </hgroup>        
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr class="twoTable">
                        	<td width="48%" align="center" valign="middle">
                                <?php echo $data_order_instock2['order_transport'];?>
                            </td>
                            <td width="52%" align="center" valign="middle">
                            	<strong>
                                <?php echo $data_order_instock2['order_transport_status'];?>
                                </strong>
                          </td>
                        </tr>
                  </table>  
                   <?php } ?>     
                    <br /><br />
                    
				   <?php   
                   $sql_order_address = "select * ,SUM(order_total) as total_order, SUM(order_transport_status) as sum_tran from order_tb where order_number = '".$_GET['n']."'";
                   $result_order_address = @mysql_query($sql_order_address, $connect);
                   $data_order_address = @mysql_fetch_array($result_order_address);
				   
					$GTotal =  $data_order_address['total_order'] + $data_order_address['sum_tran'] ;
					
					if($data_order_address['order_promotion'] != '' ){
					$GTotal =  $GTotal - ($GTotal * ($data_order_address['order_promotion']/100));
					}
					
					if($data_order_address['order_point'] != '' ){
					$GTotal =  $GTotal - $data_order_address['order_point'];
					}
				   
				   
				   
                   ?>
                    
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
					<?php
					 if($data_order_address['order_promotion'] != '' ){
					?>
                        <tr class="hilight">
                          <td class="hilight" align="center" valign="middle">
                          ได้รับส่วนลด
                          </td>
                          <td class="hilight" align="center" valign="middle"><?php echo $data_order_address['order_promotion'];?> %</td>
                        </tr>
                        <?php } ?>
                    <?php if($data_order_address['order_point'] != '' ){?>
                        <tr class="hilight">
                          <td class="hilight" align="center" valign="middle">ใช้แต้ม</td>
                          <td class="hilight" align="center" valign="middle"><?php echo $data_order_address['order_point'];?></td>
                        </tr>
                    <?php } ?>
                        <tr class="hilight">
                          <td width="48%" class="hilight" align="center" valign="middle">GRAND TOTAL</td>
                          <td width="52%" class="hilight" align="center" valign="middle">
                           <div id="tranCostPlus">
						  <?php
							  
						  echo number_format($GTotal);
						
						  ?>
                          </div>
                          
                          </td>
                        </tr>
                        
                    </table>  
                </section>
                <br /><br />

                    <table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr>
                        <td bgcolor="#EEEEEE" width="48%">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                <td><?php echo ($_SESSION['sess_language'] == 'eng' ? 'BILLING ADDRESS' : 'ที่อยู่ออกบิล');?></td>
                                </tr>
                                <tr>
                                <td><?php echo $data_order_address['order_address1'];?></td>
                                </tr>
                                </table>
                        </td>
                        <td bgcolor="#F5F5F5" width="52%">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                <td><?php echo ($_SESSION['sess_language']=='eng' ? 'SHIPPING ADDRESS' : 'ที่อยู่จัดส่ง' );?></td>
                                </tr>
                                <tr>
                                <td><?php echo $data_order_address['order_address2'];?></td>
                                </tr>
                                </table>
                        
                        </td>
                      </tr>
                    </table>
                        
                        	
                        	
          </section>
        </section>

                        
                       <!--End ตาราง 3 Cell-->                                              
                       <!--ตาราง 3 Cell-->
                      <div class="title-top"><!--Other-->&nbsp;
                          <div class="right-title">&nbsp;</div>
                      </div>
                                   
                      
                       </div>
                                           
                  </div>
					   <!--End Coppy Module Clear-->                                 
                                        
				</div> 
                
                <div class="demo">
                 <?php 

				 $real_amount = $total_all;
				 
				 ?>                                 

                <input name="number" type="hidden" value="<?php echo $number;?>" />

                <input name="pv" type="hidden" value="<?php echo $data_order['order_pv'];?>" />
                <input name="sv" type="hidden" value="<?php echo $data_order['order_sv'];?>" />
                <input name="u_id" type="hidden" value="<?php echo $data_order['u_id'];?>" />
                <input name="name_emp" type="hidden" value="<?php echo $data_order['order_employee'];?>" />
                <input name="email_emp" type="hidden" value="<?php echo $data_order['order_email'];?>" />                
                <input name="order_number" type="hidden" value="<?php echo $data_order['order_number'];?>" />                
                
                <!--<input name="GET_PAYMENT" type="submit" class="borderfrom" style="width:110px" value="Paid" 
				<?php echo ($data_order['order_status']!= '1' ? "disabled=disabled" : '' );?> />
                
                <!--<input name="Delivery" type="submit" class="borderfrom" style="width:110px" value="Delivery" 
				<?php //echo ($data_order['order_status']== '3' || $data_order['order_status']== '0' ? "disabled=disabled" : '' );?> />
                
                <input name="Complete" type="submit" class="borderfrom" style="width:110px" value="Complete" 
				<?php echo ($data_order['order_status']== '4' || $data_order['order_status']== '0' ? "disabled=disabled" : '' );?> />-->
				<input type="hidden" name="val_number" value="<?php echo $val_order;?>" />
                
                <?php if($_SESSION['AUTH_PERMISSION_ID'] == '1' || $_SESSION['AUTH_PERMISSION_ID'] == '5'){?>
                <input name="CANCEL" type="submit" class="borderfrom" value="Cancel" style="width:110px" onClick="return confirm('คุณต้องการยกเลิกใบสั่งซื้อนี้ ?');">
                <?php }else{ ?>
                <input name="CANCEL" type="submit" class="borderfrom" value="Cancel" style="width:110px"
                <?php echo $data_order['order_status'] > '1' || $data_order['order_status'] == '0' ? "disabled=disabled" : "" ;?> onClick="return confirm('คุณต้องการยกเลิกใบสั่งซื้อนี้ ?');">
                <?php } ?>
                                
                </div><br />                               
               
               
               
               <div class="demo">
               <!--วันที่ส่งสินค้า<span style="margin-left:5px;"></span> 
                  <input name="ems_date" type="text" style="position:relative;top:0;" id="datepicker" <?php echo $data_order['order_status']== '0' ? "disabled=disabled" : "" ;?>	
                  value="<?php echo $data_order['ems_date'];?>" size="" />
                  &nbsp;&nbsp;
                  <input name="Delivery" type="submit" class="borderfrom" style="width:160px" value="Delivery" 
				  <?php echo ($data_order['order_status']>= '3' || $data_order['order_status']== '0' ? "disabled=disabled" : '' );?>/>
                  
                  --><br />
                  <br />
                  <!--แก้ไขสถานะใบสั่งซื้อ : 
                  <select name="edit_order_status" id="select">
                  <option value="">--กรุณาเลือก--</option>
                  <option value="2" <?php// echo ($data_order['order_status']== '2' ? "selected=selected" : "" );?>>Paid</option>
                  </select>
                  <input name="SENDSTATUS" type="submit" class="borderfrom" style="width:160px" value="แก้ไขสถานะ" />-->
                </div>
               </form>


                    </div>
                    <div class="block_style2_bottom">
                        <div class="block_style2_bottom-l"></div>
                        <div class="block_style2_bottom-r"></div>
                    </div>                    
                </div>
                <!-- End Block Frame-->
                

                

            <div class="clear"></div>                        
		</div>            
            


		<?php include('footer.php');?>



        </div>
    </div>
</div>    
</body>
</html>
