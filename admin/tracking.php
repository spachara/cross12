<?php
session_start();
require_once '../dbconnect.inc';
include("class.page_split.php");
require("../class.phpmailer.php");

if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) {
	echo "<script>location.href='index.php'</script>";
}
	
if($_POST['submit'] == 'Save' ){
	
	$sql_txt = "SELECT txt_detail_th FROM txt_tb WHERE txt_id = '24' ";
	$result_txt =@mysql_query($sql_txt, $connect);
	$data_txt =@mysql_fetch_array($result_txt);
	$date_finish = $_POST['trancking_date'];
		if($_POST['trackingProId']){
			
		foreach ($_POST['trackingProId'] as $v) {

					if($_POST['tracking'][$v] != ''){
						
						
					$sql_update_payment = "UPDATE order_product_tb SET tracking_number = '".$_POST['tracking'][$v]."'";
					$sql_update_payment .= ", status_tracking = '2' , trancking_date = '".$date_finish."' WHERE order_p_id = '".$_POST['trackingProId'][$v]."'";
					@mysql_query($sql_update_payment, $connect);
					

					$sql_user2 = "select order_number,order_type from order_product_tb where order_p_id = '".$_POST['trackingProId'][$v]."'";
					$result_user2 = @mysql_query($sql_user2, $connect);
					$data_user2 =@mysql_fetch_array($result_user2);

					$order_number[] =  $data_user2['order_number']."-".$data_user2['order_type'];
					
					}
		}
		
		
		//print_r($order_number);
		$result = array_unique($order_number);
		foreach($result as $y){

		$exV = explode('-',$y);
		
		$sql_user = "select order_employee,order_number,order_type,date_in,order_email  from order_tb where order_number = '".$exV[0]."-".$exV[1]."' and order_type = '".$exV[2]."'";
		$result_user = @mysql_query($sql_user, $connect);
		$data_user =@mysql_fetch_array($result_user);
		
		
					$messages = "เรียนคุณ ".$data_user['order_employee']."<br><br>";
					$messages .= 'ทางร้านได้จัดส่งสินค้าให้ท่านแล้ว  ตามรายละเอียดด้านล่างนี้คะ<br><br>';

	
					$messages .= "เลขที่ออร์เดอร์ ".$data_user['order_number']."-".$data_user['order_type']."<br><br>";   
					$messages .= "สินค้าที่จัดส่ง  <br><br>"; 
					
					$sql_user3 = "select order_p_color,pro_code,order_p_size,order_p_stock,tracking_number from order_product_tb where order_number = '".$exV[0]."-".$exV[1]."' and order_type = '".$exV[2]."'";
					$sql_user3 .= " and trancking_date = '".$date_finish."'";
					$result_user3 = @mysql_query($sql_user3, $connect);
					$num_user3 = @mysql_num_rows($result_user3);
					
					for($t=1;$t<=intval($num_user3);$t++){
					$data_user3 = @mysql_fetch_array($result_user3);
					
					$product_color = "select name from color_tb where c_code = '".$data_user3['order_p_color']."' ";
					$result_productcolor = @mysql_query($product_color, $connect);
					$data_productcolor =@mysql_fetch_array($result_productcolor);

					$messages .= $data_user3['pro_code']." ".$data_productcolor['name']." ".$data_user3['order_p_size']." ".$data_user3['order_p_stock']." &nbsp;&nbsp;&nbsp;";   
					$messages .= "เลขพัสดุคือ :".$data_user3['tracking_number']."<br>";  
					
					}
					

					$messages .= "<br>สั่งซื้อเมื่อ :".$data_user['date_in']."<br>";   
					$messages .= "จัดส่งเมือ :".$_POST['trancking_date']."<br>";  
					
					
					

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
					$mail->Subject = "Cross Twelfth :: ได้จัดส่งสินค้าของท่านแล้ว"; // หัวข้อในการส่ง email นั้นๆ
					
					$body = $messages;
					$mail->MsgHTML($body);
					
					$mail->AddAddress($data_user['order_email'], $data_user['order_employee']); // ผู้รับคนที่หนึ่ง , ชื่อผู้รับ ** กรุณีผู้สองคุณ สามารถเพิ่มบรรทัดนี้อีกได้
					$mail->AddBCC("amanichanon@gmail.com", "Orm");
		
					$mail->Send();
					
					
		}
		
		}
		
		
		
		
		
	
?>		 
		<script>
			location.href='tracking.php'; //รีเฟสหน้า
		</script>
<?php

}
if($_POST['submit2'] == 'Save Done' ){
	
	if($_POST['chkDone']){
	
	foreach ($_POST['chkDone'] as $v) {
	
		if($_POST['chkDone'][$v] != ''){
	
		$sql_update_done = "UPDATE order_tb SET ems_date = '".date('d')."/".date('m')."/".date('Y')."',status_finish = '1', order_status ='3'";
		$sql_update_done .= " where order_number = '".$v."'";
		@mysql_query($sql_update_done, $connect);
		//echo $sql_update_done;
		} 
	} 
	} 
?>		 
		<script>
			location.href='tracking.php'; //รีเฟสหน้า
		</script>
<?php

}
if($_POST['capture'] == 'Capture' ){
    if($_POST['trackingProId']){
			
		foreach ($_POST['trackingProId'] as $v) {						
						
					$sql_update_tracking = "UPDATE order_product_tb SET capture = '".$_POST['tracking'][$v]."'";
					$sql_update_tracking .= " WHERE order_p_id = '".$_POST['trackingProId'][$v]."'";
					@mysql_query($sql_update_tracking, $connect);
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
<script src="jquery_ui/js/jquery-ui-1.8.22.custom.min.js"></script>
<link rel="stylesheet" href="jquery_ui/development-bundle/demos/demos.css">
<script>
$(function() {
    $( "input:submit, input:button, a, button", ".demo" ).button();
    $( "a", ".demo" ).click(function() { return false; });
    
    $( ".tabs" ).tabs();
});
function chKenable3(val){
	
	if( document.getElementById('enable3').checked){

    	document.getElementById('member_f_fname').disabled = false;
    	document.getElementById('member_f_lname').disabled = false;
    	document.getElementById('member_f_id').disabled = false;
    	document.getElementById('member_f_phone').disabled = false;
	
	}else{
		
    	document.getElementById('member_f_fname').disabled = true;
    	document.getElementById('member_f_lname').disabled = true;
    	document.getElementById('member_f_id').disabled = true;
    	document.getElementById('member_f_phone').disabled = true;

	}
}


function chKenable4(val){
	
	if( document.getElementById('enable4').checked){

    	document.getElementById('member_s_fname').disabled = false;
    	document.getElementById('member_s_lname').disabled = false;
    	document.getElementById('member_s_id').disabled = false;
    	document.getElementById('member_s_phone').disabled = false;
	
	}else{
		
    	document.getElementById('member_s_fname').disabled = true;
    	document.getElementById('member_s_lname').disabled = true;
    	document.getElementById('member_s_id').disabled = true;
    	document.getElementById('member_s_phone').disabled = true;

	}
}
$(document).ready(function() {
    $('#selecctall').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
    
});

</script>
<!--Fancy Box-->
<!--<script type="text/javascript" src="../js/fancy_box/jquery-1.8.2.min.js"></script>-->
<script type="text/javascript" src="js/fancy_box/jquery.fancybox.js"></script>
<link rel="stylesheet" type="text/css" href="css/fancy_box/jquery.fancybox.css?v=2.1.2" media="screen" />
	
<link rel="stylesheet" type="text/css" href="css/fancy_box/jquery.fancybox-buttons.css" />
<script type="text/javascript" src="js/fancy_box/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="js/fancy_box/button-helper.js"></script>
<style type="text/css">
	.fancybox-custom .fancybox-skin {
		box-shadow: 0 0 50px #222;
	}
</style>    
<!--End Fancy Box-->

<link href="cssstyle.css" rel="stylesheet" type="text/css" />

<!--<link rel="stylesheet" href="../js/datepicker/css/ui-darkness/jquery-ui-1.10.3.custom.css" type="text/css">-->
<script type="text/javascript" src="../js/datepicker/js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript">
$(function(){

	
	// Datepicker
	$('#date_begin').datepicker({
		yearRange: "1950:+0",
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		onSelect: function(dateText) {
			//alert(dateText);
			$('#save').attr('disabled', false);
		}
	});
	
	$('#date_to').datepicker({
		yearRange: "1950:+0",
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		
	});

	$('#datepicker2').datepicker({
		yearRange: "1950:+0",
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd'
	
	});
});
$(document).ready(function() {    
	$('#save').attr('disabled', true);
	
	$('#save').click(function() {
		var val_date = $('#date_begin').val();
		//alert(val_date);
		if ($('#date_begin').val() == "") {
			//alert("NOT OK");
			$('#save').attr('disabled', true);
		} else if ($('#date_begin').val() != "") {
			$('#save').attr('disabled', false);
			//$('#form1').submit();
			alert("OK");
		}
    });
});
</script>
</head>

<body> 
	<div class="page_container">
    <div class="shadow_l"></div>
	<div class="shadow_r"></div>  
    	<!--Header--> 
    	<div class="header">
    	<?php include('header.php');?>
        </div>
        <!--Header-->
        <div class="container_content">
            <!--Main Menu-->
            <?php include('mainmenu.php');?>
            <!--End Main Menu-->
            <div class="content_r">
            
                                	<!--Edit Navigator-->
                                   <div class="navigator">
                                        <a href="tracking.php">อัพเดท เลขพัสดุ</a>
                                        
                                   </div>
                                   <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">อัพเดท เลขพัสดุ</div>
                    </div>
                    <div class="block_style2_content">

                <form method="post" enctype="multipart/form-data" name="myform" id="form1">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Tahoma, Geneva, sans-serif; font-size:12px;">
                      <tr>
                        <td width="19%">วันที่ส่งสินค้า</td>
                        <td width="22%"><input type="text" name="order_date" id="datepicker2" value="<?php echo $_POST['order_date'];?>" /></td>
                        <td width="26%"><input type="submit" name="Search" id="Search" value="Search" /></td>
                        <td width="33%">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>                
                
                <div class="demo" style="text-align:right">
                <input type="text" name="trancking_date" id="date_begin"  value="" placeholder="กรุณาเลือกวันที่ส่งสินค้า"/>
                <input type="submit" name="submit" value="Save" id="save" />
                
                <input type="submit" name="submit2" value="Save Done" />
                
                
                <input type="submit" name="capture" value="Capture" />
                </div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td bgcolor="#000000"><table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_3cell">
                      <tr>
                        <td width="15%" height="25" align="center" bgcolor="#CCCCCC">ลำดับ</td>
                        <td width="16%" align="center" bgcolor="#CCCCCC">ใบสั่งซื้อ</td>
                        <td width="24%" align="center" bgcolor="#CCCCCC">ชื่อ</td>
                        <td width="45%" align="center" bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="2" cellpadding="0">
                          <tr>
                            <td width="25" bgcolor="#FFCC33">&nbsp;</td>
                            <td> &nbsp;วันที่ส่งสินค้า</td>
                            <td width="25" bgcolor="#6699FF">&nbsp;</td>
                            <td>&nbsp;วันที่ตัดstock</td>
                            <td><input type="checkbox" id="selecctall"/>
Selecct All</td>
                          </tr>
                        </table></td>
                      </tr>
                      <?php 



                                    $sql_order = "SELECT * FROM order_tb where payment_status in ('1','3') and status_finish <> '1'";

										 if($_POST['order_date'] != '' ){
											 
											 $sql_product = "select order_number from order_product_tb where  status_tracking <> '2' and ready_time = '".$_POST['order_date']."' ";
											 
										 $sql_order .= " AND order_number in (". $sql_product .")";
										 
										 }else{
											  
										 $sql_order .= " AND order_number in (select order_number from order_product_tb where ready_time <> '' and status_tracking <> '2')";

										 }
										 
									$sql_order .= " and order_status = '2' GROUP BY order_number ORDER BY date_in desc";
                                    $result_order =@mysql_query($sql_order, $connect);
                                    $num_order =@mysql_num_rows($result_order);

                                    for($i=1;$i<=intval($num_order);$i++){
                                    $data_order=@mysql_fetch_array($result_order);
                                    

                                    $sql_user = "SELECT * FROM user_tb where u_id = '".$data_order['u_id']."' ";
                                    $result_user2 =@mysql_query($sql_user, $connect);
                                    $data_user=@mysql_fetch_array($result_user2);
									
									
									$sql_order_product = "SELECT * FROM order_product_tb WHERE order_number = '".$data_order['order_number']."' ";
									$result_order_product =@mysql_query($sql_order_product, $connect);
									$data_order_product =@mysql_fetch_array($result_order_product);

                                    ?>
                      <tr>
                        <td height="25" align="center" valign="top" bgcolor="#F5F5F5"><?php echo $f+$i;?></td>
                        <td valign="top" bgcolor="#F5F5F5">
						<?php 
												
												
						$sql_insert_order2 = "select * from order_tb where order_number = '".$data_order['order_number']."' and status_finish <> '1'";
						$result_insert_order2 = @mysql_query($sql_insert_order2, $connect);
						$num_order2 = @mysql_num_rows($result_insert_order2);
						$data_order2= @mysql_fetch_array($result_insert_order2);
						
						if($num_order2 == 2){ 
							$val_order1 = $data_order2['order_number']."-IN";
							$val_order2 = $data_order2['order_number']."-PRE";
							
							$sql_order1 = "select * from order_tb where order_number = '".$data_order2['order_number']."' and order_type = 'IN' and status_finish <> '1'";
							$result_order1 = @mysql_query($sql_order1, $connect);
							$data_o1= @mysql_fetch_array($result_order1);
							
							$order_total1 = $data_o1['order_total'];
							$order_id1 = $data_o1['order_id'];
							$order_tran1 = $data_o1['order_transport_status'];
							$order_dis1 = $data_o1['order_promotion'];
							$order_comment = $data_order['order_comment'];
							
							

							$sql_order2 = "select * from order_tb where order_number = '".$data_order2['order_number']."' and  order_type = 'PRE' and status_finish <> '1'";
							$result_order2 = @mysql_query($sql_order2, $connect);
							$data_o2= @mysql_fetch_array($result_order2);
							
							$order_total2 = $data_o2['order_total'];
							$order_id2 = $data_o2['order_id'];
							$order_tran2 = $data_o2['order_transport_status'];
							$order_dis2 = $data_o2['order_promotion'];
							
							$total_order = $order_total1 + $order_total2;
							
							$discount = $total_order - ($total_order * $order_dis1 / 100);
							
							$total_price = $discount + $order_tran1 + $order_tran2;
							
							$sql_order_all_pro = "SELECT * FROM order_product_tb where order_number = '".$data_order2['order_number']."'";
							$result_order_all_pro =@mysql_query($sql_order_all_pro, $connect);
							$num_order_all_pro =@mysql_num_rows($result_order_all_pro);


							$sql_update2 = "select * from order_product_tb where order_number = '".$data_order2['order_number']."'";
							$sql_update2 .= " and  ready_sent = '1' ";
							$result_update2 = @mysql_query($sql_update2, $connect);
							$num_update2 =@mysql_num_rows($result_update2);
							
							for($i5=0;$i5<intval($num_update2);$i5++){
								
							$data_update2 =@mysql_fetch_array($result_update2);
							
								$arrProduct[$exV2][$i5] = $data_update2['pro_code'].":".$data_update2['order_p_color'].":".$data_update2['order_p_size'];
								
							}
							
							
							$sql_traking1 = "select * from order_product_tb where order_number = '".$data_order2['order_number']."'";
							$sql_traking1 .= " and tracking_number <> '' and  ready_sent = '1' ";
							$result_traking1 = @mysql_query($sql_traking1, $connect);
							$num_traking1 =@mysql_num_rows($result_traking1);
							
							
							for($i7=0;$i7<intval($num_traking1);$i7++){
								
								$data_traking1 =@mysql_fetch_array($result_traking1);
							
								$arrProduct2[$exV2][$i7] = $data_traking1['pro_code'].":".$data_traking1['order_p_color'].":".$data_traking1['order_p_size'];
								
							}

						}else{
							$val_order1 = $data_order2['order_number']."-".$data_order2['order_type'];
							$order_total1 = $data_order['order_total'];
							$order_id1 = $data_order['order_id'];
							$order_dis1 = $data_order['order_promotion'];
							$order_comment = $data_order['order_comment'];
							
							$discount = $order_total1 - ($order_total1 * $order_dis1 / 100);

							$val_order2 = '';
							$total_price = $discount  + $data_order2['order_transport_status'];
							
							$sql_update2 = "select * from order_product_tb where order_number = '".$data_order2['order_number']."'";
							$sql_update2 .= " and  ready_sent = '1' ";
							$result_update2 = @mysql_query($sql_update2, $connect);
							$num_update2 =@mysql_num_rows($result_update2);
							
							
							for($i5=0;$i5<intval($num_update2);$i5++){
								
							$data_update2 =@mysql_fetch_array($result_update2);
							
								$arrProduct[$exV2][$i5] = $data_update2['pro_code'].":".$data_update2['order_p_color'].":".$data_update2['order_p_size'];
								
							}
							$sql_order_all_pro = "SELECT * FROM order_product_tb where order_number = '".$data_order2['order_number']."'";
							$result_order_all_pro =@mysql_query($sql_order_all_pro, $connect);
							$num_order_all_pro =@mysql_num_rows($result_order_all_pro);

							


							$sql_traking1 = "select * from order_product_tb where order_number = '".$data_order2['order_number']."'";
							$sql_traking1 .= " and tracking_number <> '' and  ready_sent = '1' ";
							$result_traking1 = @mysql_query($sql_traking1, $connect);
							$num_traking1 =@mysql_num_rows($result_traking1);
							
							
							for($i7=0;$i7<intval($num_traking1);$i7++){
								
								$data_traking1 =@mysql_fetch_array($result_traking1);
							
								$arrProduct2[$exV2][$i7] = $data_traking1['pro_code'].":".$data_traking1['order_p_color'].":".$data_traking1['order_p_size'];
								
							}


						}

					
				  ?>
                          <a href="<?php echo $url_pic;?>/tmp/<?php echo $val_order1;?>.pdf" target="_blank"><?php echo $val_order1;?></a>
                          <?php if($val_order2 != '' ){?>
                          <div style="border-top:#ffffff 1px solid;"> <a href="<?php echo $url_pic;?>/tmp/<?php echo $val_order2;?>.pdf" target="_blank">
						  <?php echo $val_order2;?></a> </div>
                          <?php } ?></td>
                        <td align="left" valign="top" bgcolor="#F5F5F5"><?php echo $data_user['u_fname']." ".$data_user['u_lname'];?><br />
                          <?php echo $data_user['u_mobi'];?><br />
                          
                          <?php echo ($order_comment != '' ? "<font color=red>Comment : ".$order_comment."</font>" : "" );?>
                          </td>
                        <td align="left" valign="top" bgcolor="#F5F5F5">
						<?php 

                        $show  = 0;
                        $all_P = 0;
                        $done=0;
						foreach($arrProduct as $y){
							foreach($y as $g){
							
							$proEx = explode(':',$g);
							$sql_update3 = "select * from order_product_tb where order_number = '".$data_order['order_number']."'";
							$sql_update3 .= " and pro_code  = '".$proEx[0]."' and order_p_color  = '".$proEx[1]."' and order_p_size  = '".$proEx[2]."' ";
							$sql_update3 .= " and ready_sent = '1' ";
							$result_update3 = @mysql_query($sql_update3, $connect);
							$num_update3 =@mysql_num_rows($result_update3);
							$data_update3 =@mysql_fetch_array($result_update3);
							//echo $sql_update3;
							if($num_update3){
								if($data_update3['tracking_number'] == ''){
									$show  = $show + 1;
									$all_P = $all_P + 1;

								}else{
									$all_P = $all_P + 1;
									$done = $done+1;
								}

						 $product_color = "select name from color_tb where c_code = '".$data_update3['order_p_color']."' ";
						 $result_productcolor = @mysql_query($product_color, $connect);
						 $data_productcolor =@mysql_fetch_array($result_productcolor);
							
						 ?>
							<table width="100%" border="0" cellspacing="1" cellpadding="0">
							<tr>
                            <td width="19%" bgcolor="#FFCC33">
                            <?php echo $data_update3['ready_time'];?>
                            </td>

							<td width="36%" bgcolor="#FFFFFF">
							<?php 
							echo $data_update3['pro_code']." ".$data_productcolor['name']." ".$data_update3['order_p_size'];?>
							</td>
							<td width="26%" bgcolor="#FFFFFF">
                          	<input type="text" name="tracking[<?php echo $data_update3['order_p_id'];?>]" value="<?php echo ($data_update3['tracking_number'] != '' ? $data_update3['tracking_number'] : $data_update3['capture'] );?>" style="width:100px;" <?php echo ($data_update3['tracking_number'] != '' ? "disabled=disabled" : "" );?> />
                          	<input type="hidden" <?php echo ($data_update3['tracking_number'] != '' ? "disabled=disabled" : "" );?> name="trackingProId[<?php echo $data_update3['order_p_id'];?>]" value="<?php echo $data_update3['order_p_id'];?>"/>
                            </td>
                            <td width="19%" bgcolor="#6699FF">
                            <?php echo $data_update3['trancking_date'];?>
                            </td>
							</tr>
							</table>
                          <?php } } } unset($arrProduct);
											
						 if( ($done == $all_P  && ($done != 0 &&  $all_P != 0)) && $num_order_all_pro == $done){ ?>
                          <font color=#00CC00><center><b>
                            <input type="checkbox" class="checkbox1" name="chkDone[<?php echo $data_order['order_number'];?>]" value="<?php echo $data_order['order_number'];?>" />
                          DONE</b></center></font>
					      <?php
							 //echo "<a href=?done=".$data_order['order_number']."&trancking_date=".date('d')."/".date('m')."/".date('Y')."><font color=#00CC00><center><b>DONE</b></center></font>"; 
						 }
											 
						?>
                        </td>
                      </tr>
                      <?php $val_order2 == '' ;} ?>
                    </table></td>
                  </tr>
                </table>
                </form>
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
