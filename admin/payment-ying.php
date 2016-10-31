<?php
session_start();
require_once '../dbconnect.inc';
include("class.page_split.php");
require("../class.phpmailer.php");

if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) {
	echo "<script>location.href='index.php'</script>";
}
if($_GET['sAction'] == 'del'){

	
	$sql_delete = "DELETE FROM payment_tb  WHERE id = '".$_GET['id_del']."' ";
	@mysql_query($sql_delete, $connect);
	
?>		 <script>
				location.href='payment.php'; //รีเฟสหน้า
		 </script>
<?php
}
	
	
if($_POST['submit'] == 'Save' ){
	
	$sql_txt = "SELECT * FROM txt_tb WHERE txt_id = '22' ";
	$result_txt =@mysql_query($sql_txt, $connect);
	$data_txt =@mysql_fetch_array($result_txt);

	$date_finish = $_POST['paid_date'];
	
	foreach ($_POST['hidden_id'] as $r) {
		

		$paymentArr1 = ereg_replace("-",":",$_POST['order_number'][$r]);

		$paymentArr = explode(" | ",$paymentArr1);
		
		foreach ($paymentArr as $v) {
					
					$exV =  explode(":",$v);
					
					if($_POST['tran'][$r] != '0' ){
						
						
					if($_POST['tran'][$r] == '2'){
						$order_status = 1;
					}else{
						$order_status = 2;
					}
					
					$sql_update = "UPDATE order_tb SET order_status = '".$order_status."', tranfer_status = '".$_POST['tran'][$r]."', payment_status = '".$_POST['tran'][$r]."'";
					$sql_update .= ", payment_date = '".$date_finish."' , tranfer_value = '".$_POST['tran_val'][$r]."'  where order_number = '".$exV[0]."-".$exV[1]."'";
					$sql_update .= " and order_type = '".$exV[2]."'";
					$result_update = @mysql_query($sql_update, $connect);
					

						
					$sql_update_payment = "UPDATE payment_tb SET payment_status = '".$_POST['tran'][$r]."', tranfer_value = '".$_POST['tran_val'][$r]."'";
					$sql_update_payment .= ", date_update = '".$date_finish."' where id = '".$_POST['hidden_id'][$r]."'";
					$result_update_payment = @mysql_query($sql_update_payment, $connect);
					
					
					$sql_select_payment = "select * from payment_tb where id = '".$_POST['hidden_id'][$r]."'";
					$result_select_payment = @mysql_query($sql_select_payment, $connect);
					$data_select_payment = @mysql_fetch_array($result_select_payment);


					$sql_user = "select * from order_tb where order_number = '".$exV[0]."-".$exV[1]."' and order_type = '".$exV[2]."'";
					$result_user = @mysql_query($sql_user, $connect);
					$data_user =@mysql_fetch_array($result_user);
					
					//echo "<br>".$data_user['order_email']."===".$data_user['order_employee']."<br>";

					if($_POST['tran'][$r] == '1' ){
						$mess = "โอนพอดี";	
					}elseif($_POST['tran'][$r] == '2' ){
						$mess = "โอนขาด";	
					}elseif($_POST['tran'][$r] == '3' ){
						$mess = "โอนเกิน";	
					}
					
					if($data_select_payment['payment_status'] == '0'){
					
					$messages = "เรียนคุณ ".$data_user['order_employee']."<br><br>";
					$messages .= 'ทางเราได้รับการชำระเงิน ออร์เดอร์ เลขที่ "'.$data_select_payment['order_number'].'" ของท่านแล้ว';
					
					if($_POST['tran'][$r] == '3' ){
					$messages .= '<font color="#00CC00">ยอดโอนของท่านเกินจำนวนที่ต้องชำระ เป็นจำนวน '.($_POST['tran_val'][$r] != '' ? $_POST['tran_val'][$r]." บาท" : "").' กรุณาติดต่อเจ้าหน้าที่ ';
					$messages .= 'เบอร์  081-3802212</font></b><br>';
					}

					if($_POST['tran'][$r] == '2' ){
					$messages .= '<font color="#00CC00">ยอดโอนของท่านเกินไม่ครบตามจำนวนที่ต้องชำระ เป็นจำนวน '.($_POST['tran_val'][$r] != '' ? $_POST['tran_val'][$r]." บาท" : "").'  กรุณาโอนเพิ่ม และติดต่อเจ้าหน้าที่ ';
					$messages .= 'เบอร์  081-3802212</font></b><br>';
					}
					
					$messages .= "สินค้าจะจัดส่งให้ท่านภายใน 3 วันทำการ  และสำหรับสินค้าพรีออเดอร์  จะจัดส่งให้ตามระยะเวลาที่แจ้งไว้ ค่ะ<br><br>";
	
					$messages .= "เลขที่ออร์เดอร์ ".$data_select_payment['order_number']."<br>";   
					$messages .= "วันที่สั่งซื้อ: ".$data_user['date_in']."<br>";  
					//$messages .= "วิธีการชำระเงิน".$data_select_payment['order_number']; 
					$messages .= "Bank name: ".$data_select_payment['bank_tranfer']."<br>";   
					$messages .= "จำนวน :".$data_select_payment['total_price']."<br>";   
					$messages .= "วันที่ :".$data_select_payment['payment_date']."<br>";   
					$messages .= "เวลา :".$data_select_payment['payment_time']."<br>";  

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
					$mail->Subject = "Cross Twelfth :: Confirm payment"; // หัวข้อในการส่ง email นั้นๆ
					
					$body = $messages;
					$mail->MsgHTML($body);
					
					$mail->AddAddress($data_user['order_email'], $data_user['order_employee']); // ผู้รับคนที่หนึ่ง , ชื่อผู้รับ ** กรุณีผู้สองคุณ สามารถเพิ่มบรรทัดนี้อีกได้
					$mail->AddBCC("amanichanon@gmail.com", "Orm");
					$mail->AddBCC("pakamon.sum@gmail.com", "Joy");
		
					$mail->Send();
					
					}
					
					} // ==0
	
		}
	
	}
?>		 
		<script>
			//location.href='payment.php'; //รีเฟสหน้า
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
<script src="jquery_ui/js/jquery-ui-1.8.22.custom.min.js"></script>
<link rel="stylesheet" href="jquery_ui/development-bundle/demos/demos.css">
<script>
$(function() {
    $( "input:submit, a, button", ".demo" ).button();
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
<link rel="stylesheet" href="../js/datepicker/css/ui-darkness/jquery-ui-1.10.3.custom.css" type="text/css">
<script type="text/javascript" src="../js/datepicker/js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript">
$(function(){

	
	
	// Datepicker
	$('#datepicker').datepicker({
		yearRange: "1950:+0",
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy'
	
	});
	
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
                                        <a href="#">แจ้งชำระเงิน</a>
                                        
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

<form method="post" enctype="multipart/form-data" name="myform">
<table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="116" height="25">ชื่อ</td>
    <td width="249"><input type="text" name="name_search" value="<?php echo $_POST['name_search'];?>" /></td>
    <td width="142" align="center">เลขที่ใบสั่งซื้อ</td>
    <td width="191"><input type="text" name="order_number_search" value="<?php echo $_POST['order_number_search'];?>" /></td>
    <td width="228" align="center"><font color="#FF0000">*ใส่เฉพาะตัวเลข ไม่ต้องใส่ -IN -PRE</font></td>
    </tr>
  <tr>
    <td height="25">วันเวลาที่โอน</td>
    <td><input name="payment_date" type="text" id="datepicker" value="<?php echo $_POST['payment_date'];?>" style="width:100px" /></td>
    <td align="center">ธนาคาร</td>
    <td><select name="bank_tranfer" class="validate[required]">
      <option value="" <?php echo ($_POST['bank_tranfer'] == '' ? "selected=selected" : "");?>></option>
    
	<?php
     
    $sql_bank2 = "SELECT * FROM bank_tb where ranking not in ('','0') ORDER BY ranking";
    $result_bank2 =@mysql_query($sql_bank2, $connect);
    $num_bank2 =@mysql_num_rows($result_bank2);
                        
    for($bk2=1;$bk2<=intval($num_bank2);$bk2++){
    $data_bank2 =@mysql_fetch_array($result_bank2);
    ?>
      <option value="<?php echo $data_bank2['name'];?>" <?php echo ($data_bank2['name'] == $_POST['bank_tranfer'] ? "selected=selected" : "");?>><?php echo $data_bank2['name'];?></option>
    <?php } ?>    
    
    </select></td>
    <td align="center"><input type="submit" name="Search" id="Search" value="Search" /></td>
    </tr>
</table>                
				<div class="demo" style="text-align:right">
				<input type="text" name="paid_date" id="date_begin"  value="" placeholder="กรุณาเลือกวันที่แจ้งชำระ"/>
                <input type="submit" name="submit" value="Save" />
          </div>                                   

<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" cellpadding="0" cellspacing="1" border="0">
      <tr class="title03">
        <td width="39" height="25" align="center" valign="middle" bgcolor="#CCCCCC" class="first">ลำดับ</td>
        <td  width="124" align="center" bgcolor="#CCCCCC">เลขที่ใบสั่งซื้อ</td>
        <td width="128" align="center" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="126" align="center" bgcolor="#CCCCCC">ชื่่อผู้ชำระ/เบอร์โทร</td>
        <td width="61" align="center" bgcolor="#CCCCCC">Point</td>
        <td width="74" align="center" bgcolor="#CCCCCC">ค่าขนส่ง</td>
        <td width="87" align="center" bgcolor="#CCCCCC">ส่วนลด(%)</td>
        <td width="103" align="center" bgcolor="#CCCCCC">ยอดที่ต้องชำระ</td>
        <td width="68" align="center" bgcolor="#CCCCCC">โอนจริง</td>
        <td width="73" align="center" bgcolor="#CCCCCC">วันที่/เวลา</td>
        <td width="64" align="center" bgcolor="#CCCCCC" class="last">ธนาคาร</td>
        <td width="49" align="center" bgcolor="#CCCCCC" class="last">อื่นๆ</td>
        <td width="111" align="center" bgcolor="#CCCCCC" class="last">&nbsp;</td>
        <td width="36" align="center" bgcolor="#CCCCCC" class="last">&nbsp;</td>
      </tr>
      <?php 
		$url_pic = "../tmp"; //พาทรูปภาพ
		
        
		if($_POST['Search'] == 'Search'){
			
			
		     $sql_check = "SELECT * FROM payment_tb where payment_status in ('0','2')";
			 
			 if($_POST['order_number_search'] != '' ){
				 
		     $sql_check .= " AND order_number like '%".$_POST['order_number_search']."%'";
			 
			 }
			 if($_POST['name_search'] != '' ){
				 
		     $sql_check .= " AND order_name like '%".$_POST['name_search']."%'";
			 
			 }
			 if($_POST['payment_date'] != '' ){
				 
		     $sql_check .= " AND payment_date like '%".$_POST['payment_date']."%'";
			 
			 }

			 if($_POST['bank_tranfer'] != '' ){
				 
		     $sql_check .= " AND bank_tranfer like '%".$_POST['bank_tranfer']."%'";
			 
			 }
			
		}else{
			$sql_check = "SELECT * FROM payment_tb where payment_status in ('0','2') order by id desc";
		}
		
		$result_check =@mysql_query($sql_check, $connect);
        $num_check =@mysql_num_rows($result_check);

        for($sub_main=1;$sub_main<=intval($num_check);$sub_main++){
			
        $data_check =@mysql_fetch_array($result_check);
		
			$arrCheck[$sub_main] = $data_check['order_number'];
			
			$u_id[$sub_main] = $data_check['u_id'];
			$order_number[$sub_main] = $data_check['order_number'];
			$order_name[$sub_main] = $data_check['order_name'];
			$real_price[$sub_main] = $data_check['real_price'];
			$total_price[$sub_main] = $data_check['total_price'];
			$payment_date[$sub_main] = $data_check['payment_date'];
			$payment_time[$sub_main] = $data_check['payment_time'];
			$bank_tranfer[$sub_main] = $data_check['bank_tranfer'];
			$more_bank[$sub_main] = $data_check['more_bank'];
			$id[$sub_main] = $data_check['id'];
			$payment_status[$sub_main] = $data_check['payment_status'];
			$tranfer_value[$sub_main] = $data_check['tranfer_value'];
			$tel[$sub_main] = $data_check['tel'];
		
		}
		$u=1;
		foreach($arrCheck as $key => $e){
			
			$ex_number =  explode(" | ",$e);
			$aad = explode('-',$ex_number[0]);

			
			$sql_order_tb = "SELECT order_number, order_status, order_promotion, SUM(order_point) as sum_order_point, SUM(order_transport_status) as sum_tran FROM order_tb ";
			$sql_order_tb .= "where order_number =  '".$aad[0]."-".$aad[1]."'";
			$result_order_tb =@mysql_query($sql_order_tb, $connect);
			$data_order_tb =@mysql_fetch_array($result_order_tb);
			
			
			if($data_order_tb['order_status'] != 0){
        ?>
      <tr>
        <td height="25" align="center" valign="top" bgcolor="#F5F5F5" class="first"><?php echo $u;?></td>
        <td align="center" valign="top" bgcolor="#F5F5F5">
		<?php 
					
					
					echo "<a href='edit_order.php?n=".$aad[0]."-".$aad[1]."' target='_blank'>".$ex_number[0]."</a>";
					if($ex_number[1]){
					echo "<br>";
					echo "<a href='edit_order.php?n=".$aad[0]."-".$aad[1]."' target='_blank'>".$ex_number[1]."</a>";
					}
					
					
					
					?></td>
        <td align="center" valign="top" bgcolor="#F5F5F5"><table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr height="20">
            <td bgcolor="#CCCCCC">รหัสสินค้า</td>
            <td align="center" bgcolor="#CCCCCC">ราคา</td>
          </tr>
          <?php 
											$sql_update2 = "select * from order_product_tb where order_number = '".$aad[0]."-".$aad[1]."'";
											$result_update2 = @mysql_query($sql_update2, $connect);
											$num_update2 =@mysql_num_rows($result_update2);
											
											for($i5=0;$i5<intval($num_update2);$i5++){
												
											$data_update2 =@mysql_fetch_array($result_update2);
											
												$arrProduct[$exV2][$i5] = $data_update2['pro_code'].":".$data_update2['order_p_color'].":".$data_update2['order_p_size'];
												
											}
											
											
                                            foreach($arrProduct as $y){
												
                                                foreach($y as $g){
                                                
                                                $proEx = explode(':',$g);
                                                $sql_update3 = "select * from order_product_tb where order_number = '".$aad[0]."-".$aad[1]."'";
                                                $sql_update3 .= " and pro_code  = '".$proEx[0]."' and order_p_size  = '".$proEx[2]."'";
												$sql_update3 .= " and order_p_color  = '".$proEx[1]."'";
                                                $result_update3 = @mysql_query($sql_update3, $connect);
                                                $num_update3 =@mysql_num_rows($result_update3);
                                                $data_update3 =@mysql_fetch_array($result_update3);

                                                if($num_update3 != 0){
                                                    
                                                $sql_color = "select name from color_tb where c_code = '".$data_update3['order_p_color']."' ";
                                                $result_color = @mysql_query($sql_color, $connect);
                                                $data_color =@mysql_fetch_array($result_color);
												
												$sql_product_hand = "SELECT * FROM product_tb WHERE pid = '".$data_update3['pro_id']."' ";
												$result_product_hand =@mysql_query($sql_product_hand, $connect);
												$data_product_hand =@mysql_fetch_array($result_product_hand);
												
                                            ?>
          <tr height="20">
            <td width="99" bgcolor="#FFFFFF"><?php echo $data_update3['pro_code']." ".$data_update3['order_p_size']." ".$data_color['name'].$data_product_hand['pro_code'];?></td>
            <td width="68" align="right" bgcolor="#FFFFFF"><span style="color:#FF9900; font-weight:bold;" ><?php echo $data_update3['order_p_price'];?></span></td>
          </tr>
          <tr>
            <input type="hidden" name="trackingProId[<?php echo $data_update3['order_p_id'];?>]" value="<?php echo $data_update3['order_p_id'];?>"/>
            <?php } }  }
												
												
												 unset($arrProduct);
												 
												
												 ?>
          </tr>
        </table></td>
       
        <td align="center" valign="top" bgcolor="#F5F5F5"><?php echo "<a href=comment_inbox.php?webboard_id=".$u_id[$key]." target=_blank>".$order_name[$key]."</a><br>Tel : ".$tel[$key];?></td>
        <td align="center" valign="top" bgcolor="#F5F5F5"><?php echo $data_order_tb['sum_order_point'];?></td>
        <td align="center" valign="top" bgcolor="#F5F5F5"><?php echo $data_order_tb['sum_tran'];?></td>
        <td align="center" valign="top" bgcolor="#F5F5F5"><?php echo $data_order_tb['order_promotion'];?></td>
        <td align="center" valign="top" bgcolor="#F5F5F5"><?php echo number_format($real_price[$key],2);?></td>
        <td align="center" valign="top" bgcolor="#F5F5F5"><?php echo number_format($total_price[$key],2);?></td>
        <td align="center" valign="top" bgcolor="#F5F5F5"><?php echo $payment_date[$key]."<br>".$payment_time[$key];?></td>
        <td align="center" valign="top" bgcolor="#F5F5F5"><?php echo $bank_tranfer[$key];?></td>
        <td align="center" valign="top" bgcolor="#F5F5F5"><p><?php echo $more_bank[$key];?></p></td>
        <td valign="top" bgcolor="#F5F5F5"><input type="hidden" name="hidden_id[<?php echo $id[$key];?>]" value="<?php echo $id[$key];?>" />
          <input type="hidden" name="order_number[<?php echo $id[$key];?>]" value="<?php echo $order_number[$key];?>" />
          <select name="tran[<?php echo $id[$key];?>]" >
            <option value="0" <?php echo ($payment_status[$key] == '0' ? "selected=selected" : "" );?> ></option>
            <option value="1" <?php echo ($payment_status[$key] == '1' ? "selected=selected" : "" );?>>โอนพอดี</option>
            <option value="2" <?php echo ($payment_status[$key] == '2' ? "selected=selected" : "" );?>>โอนขาด</option>
            <option value="3" <?php echo ($payment_status[$key] == '3' ? "selected=selected" : "" );?>>โอนเกิน</option>
          </select>
          <br />
          &nbsp;
          <input type="text" name="tran_val[<?php echo $id[$key];?>]" value="<?php echo $tranfer_value[$key];?>" style="width:50px;" />
          บาท </td>
        <td valign="top" bgcolor="#F5F5F5">
                                            <?php } ?>
                                        <a href="order_comment.php?n=<?php echo $data_order['order_number'];?>" target="_blank">  
                                        <?php if($data_order['order_comment'] == '' ){?>  
                                        <img src="images/1.png" width="14" height="14" />
                                        <?php }else{ ?>
                                        <img src="images/2.png" width="14" height="14" />
                                        <?php } ?>
                                        </a>
                                        
                                        </td>
                                      </tr>
									  <?php $val_order2 == '' ;} ?>
                                    </table>                                        </td>
                                      </tr>
                                    </table>

                                            

                                    
                                    <?php }?>
        <a href="payment.php?id_del=<?php echo $id[$key];?>&amp;sAction=del" onClick="return confirm('Do you want to delete it. (yes/no)')">
        <img alt="Delete" src="images/1343378039_23-Full Trash.png" title="Delete"/></a>
        </td>
      </tr>
      <?php $u++; } } //end status?>
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
                

                

            <div class="clear"></div>                        
		</div>            
            


		<?php include('footer.php');?>



        </div>
    </div>
</div>    
</body>
</html>
