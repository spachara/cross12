<?php
session_start();
require_once '../dbconnect.inc';

require_once 'process_pic.php';

if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) { 
	echo "<script>location.href='index.php'</script>";
}
	
if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { 
  $eol="\r\n"; 
} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { 
  $eol="\r"; 
} else { 
  $eol="\n"; 
}

if($_POST['CANCEL'] == 'Cancle'){
	
	
	$sql_order_score = "SELECT * FROM order_tb WHERE order_id = '".$_GET['order_id']."' ";
	$result_order_score =@mysql_query($sql_order_score, $connect);
	$data_order_score =@mysql_fetch_array($result_order_score);

		
		$sql_txt = "SELECT * FROM txt_tb WHERE txt_id = '23' ";
		$result_txt =@mysql_query($sql_txt, $connect);
		$data_txt =@mysql_fetch_array($result_txt);
		
		$edit_order = "UPDATE order_tb SET order_status = '0' WHERE order_id = '".$_GET['order_id']."' ";
		@mysql_query($edit_order, $connect);
		
		$messages = "เรียนคุณ ".$_POST['name_emp']."<br><br>";
		
		$messages .= "ระบบได้ทำการยกเลิก <b>ใบสั่งซื้อเลขที่ ".$_POST['order_number']."</b><br><br>";

		$messages .= $data_txt['txt_detail_th'];
		


		$emailto= $_POST['email_emp'];
		$email_from="Crosstwelfth<info@crosstwelfth.com>";
		$subject= "Order cancel";
		$header= 'MIME-Version: 1.0' . "\r\n";
		$header.= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$header.= 'From: '.$email_from. "\r\n";
		$header.= "Bcc: thippwan@hotmail.com, pitchaya@thetreedesign.com \r\n";
		
		if (mail($emailto,$subject,$messages,$header)) {
		
	?>
				  <script>
					location.href='edit_order.php?order_id=<?php echo $_GET['order_id'];?>';
				  </script>
	<?php
		}
	
	
}

if($_POST['GET_PAYMENT'] == 'Paid'){
	
	
	$sql_cal = "SELECT * FROM calculate_tb WHERE m_id = '".$_POST['u_id']."' and c_month = '".date('m')."' and c_year = '".date('Y')."'";
	$result_cal =@mysql_query($sql_cal, $connect);
	$num_cal = @mysql_num_rows($result_cal);
	$data_cal =@mysql_fetch_array($result_cal);
	
	if($num_cal){
	$total_pv = $data_cal['pv'] + $_POST['pv'];
	$total_sv = $data_cal['sv'] + $_POST['sv'];
		
	$edit_order = "UPDATE calculate_tb SET pv = '".$total_pv."' , sv = '".$total_sv."'";
	$edit_order .= " WHERE m_id = '".$_POST['u_id']."' and c_month = '".date('m')."' and c_year = '".date('Y')."' ";
	@mysql_query($edit_order, $connect);
	}else{
	$sql_insert = "INSERT INTO calculate_tb (id ,m_id ,c_month ,c_year ,pv ,sv ,date_update)";
	$sql_insert .= "VALUES (NULL ,  '".$_POST['u_id']."',  '".date('m')."',  '".date('Y')."',  '".$_POST['pv']."',  '".$_POST['sv']."', NOW())";
	@mysql_query($sql_insert, $connect);
	
	}
	
//echo $sql_insert;
	
	$sql_txt = "SELECT * FROM txt_tb WHERE txt_id = '22' ";
	$result_txt =@mysql_query($sql_txt, $connect);
	$data_txt =@mysql_fetch_array($result_txt);
	
	$edit_order = "UPDATE order_tb SET order_status = '2' ,payment_date = '".date('d')."-".date('m')."-".date('Y')."'";
	$edit_order .= " WHERE order_id = '".$_GET['order_id']."' ";
	@mysql_query($edit_order, $connect);
	
	
		$messages = "เรียนคุณ ".$_POST['name_emp']."<br><br>";
		$messages .= $data_txt['txt_detail_th'];
		

		
		$emailto= $_POST['email_emp'];
		$email_from="Crosstwelfth<info@crosstwelfth.com>";
		$subject= "ได้รับชำระเงิน";
		$header= 'MIME-Version: 1.0' . "\r\n";
		$header.= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$header.= 'From: '.$email_from. "\r\n";
		$header.= "Bcc: thippwan@hotmail.com, pitchaya@thetreedesign.com \r\n";
		
		if (mail($emailto,$subject,$messages,$header)) {

	?>
				  <script>
					location.href='edit_order.php?order_id=<?php echo $_GET['order_id'];?>';
				  </script>
	<?php
		}
	
}

if($_POST['Delivery'] == 'Delivery'){
	
	$edit_order = "UPDATE order_tb SET ems_date = '".$_POST['ems_date']."', order_status = '3' ";
	$edit_order .= " WHERE order_id = '".$_GET['order_id']."' ";
	@mysql_query($edit_order, $connect);
	
	$sql_txt = "SELECT * FROM txt_tb WHERE txt_id = '24' ";
	$result_txt =@mysql_query($sql_txt, $connect);
	$data_txt =@mysql_fetch_array($result_txt);
	
		$messages = "เรียนคุณ ".$_POST['name_emp']."<br><br>";
		
		$messages .= "สินค้าได้ถูกจัดส่ง เมื่อวันที่ ".$_POST['ems_date']."<br>";
		$messages .= $data_txt['txt_detail_th'];

		$emailto= $_POST['email_emp'];
		$email_from="Crosstwelfth<info@crosstwelfth.com>";
		$subject= "Order Delivery";
		$header= 'MIME-Version: 1.0' . "\r\n";
		$header.= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$header.= 'From: '.$email_from. "\r\n";
		$header.= "Bcc: thippwan@hotmail.com, pitchaya@thetreedesign.com \r\n";
		
		if (mail($emailto,$subject,$messages,$header)) {
	
	?>
				  <script>
					location.href='edit_order.php?order_id=<?php echo $_GET['order_id'];?>';
				  </script>
	<?php
		}
	
}



if($_POST['Complete'] == 'Complete'){
	
	$edit_order = "UPDATE order_tb SET order_status = '4'";
	$edit_order .= " WHERE order_id = '".$_GET['order_id']."' ";
	@mysql_query($edit_order, $connect);
	
	$sql_txt = "SELECT * FROM txt_tb WHERE txt_id = '25' ";
	$result_txt =@mysql_query($sql_txt, $connect);
	$data_txt =@mysql_fetch_array($result_txt);
	
		$messages = "เรียนคุณ ".$_POST['name_emp']."<br><br>";
		$messages .= $data_txt['txt_detail_th'];

		$emailto= $_POST['email_emp'];
		$email_from="Crosstwelfth<info@crosstwelfth.com>";
		$subject= "Order complete";
		$header= 'MIME-Version: 1.0' . "\r\n";
		$header.= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$header.= 'From: '.$email_from. "\r\n";
		$header.= "Bcc: thippwan@hotmail.com, pitchaya@thetreedesign.com \r\n";
		
		if (mail($emailto,$subject,$messages,$header)) {
	
	?>
				  <script>
					location.href='edit_order.php?order_id=<?php echo $_GET['order_id'];?>';
				  </script>
	<?php
		}
	
}

if($_POST['SENDSTATUS'] == 'แก้ไขสถานะ'){
	
	$edit_order = "UPDATE order_tb SET order_status = '".$_POST['edit_order_status']."' ";
	$edit_order .= " WHERE order_id = '".$_GET['order_id']."' ";
	@mysql_query($edit_order, $connect);
	?>
				  <script>
					location.href='edit_order.php?order_id=<?php echo $_GET['order_id'];?>';
				  </script>
	<?php
	
}


if($_POST['BACK'] == 'ย้อนกลับ'){
	
	?>
				  <script>
					location.href='new_order.php';
				  </script>
	<?php
	
}// END CREATE

	$sql_order = "SELECT * FROM order_tb WHERE order_id = '".$_GET['order_id']."' ";
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
        <div class="container_content">
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
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">แก้ไขสถานะใบสั่งซื้อ</div>
                    </div>
                    <div class="block_style2_content">

                     <!--Coppy Module Clear-->
                                   
                     <form method="post" enctype="multipart/form-data" name="myform">
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
                          <div class="right-title"><?php echo "เลขที่ใบสั่งซื้อ : ".$number;?></div>
                      </div>
                        <table width="800" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="400"><b>ที่อยู่ออกบิล</b> <br /><br />
                                                 <?php echo $data_order['order_address1'];?><br /><br /></td>
                            <td><b>ที่อยู่จัดส่ง</b> <br /><br />
                                                 <?php echo $data_order['order_address2'];?><br /> <br /></td>
                          </tr>
                        </table>

                         
                               

                        <b>วันที่สั่งซื้อ :</b> <?php echo str_date($data_order['date_in']);?><br />
                        <b>สถานะ :</b> <b>
                                                <?php 
		
													if($data_order['order_status']==0){
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
                        if($data_order['order_status']==3){?>
                        <b>หมายเลขพัสดุ :</b> <font color="#FF0000"><b><?php echo $data_order['ems_number'];?></b></font><br />
                        <b>วันที่ส่งสินค้า :</b> <font color="#FF0000"><b><?php echo $data_order['ems_date'];?></b></font>
                        <?php }
                        
                        if($data_order['order_group']!=''){?>
                        <b>จัดส่งพร้อมกับ :</b> <font color="#FF3300"><b><?php echo $data_order['order_group'];?></b></font><br />
                        <?php }?>
                        
                        <br /><br />
                        
                        
                        <table width="100%" border="0" cellspacing="1" cellpadding="0">
                          <tr>
                            <td width="17%" height="25" align="center" bgcolor="#CCCCCC">ชื่อสินค้า</td>
                            <td width="10%" align="center" bgcolor="#CCCCCC">จำนวน</td>
                            <td width="11%" align="center" bgcolor="#CCCCCC">ราคา</td>
                            <td width="16%" align="center" bgcolor="#CCCCCC">ราคารวม</td>
                            <td width="26%" align="center" bgcolor="#CCCCCC">Category</td>
                            <td width="20%" align="center" bgcolor="#CCCCCC">เลขที่ส่งของ</td>
                          </tr>
						<?php 
                            $sql_order_detail = "select * from order_product_tb where order_number = '".$data_order['order_number']."' and order_type = '".$data_order['order_type']."' and order_number_rank = '".$data_order['order_number_rank']."' ";
                            $result_order_detail =@mysql_query($sql_order_detail, $connect);
                            $num_order_detail =@mysql_num_rows($result_order_detail);
                        
                                for($od=1;$od<=intval($num_order_detail);$od++){
                            
                                $data_order_detail =@mysql_fetch_array($result_order_detail);
                                
                        ?>
                          <tr>
                            <td height="25" align="center" bgcolor="#F5F5F5"><?php echo str_replace('+','',$data_order_detail['pro_code']).($data_order_detail['order_p_size'] != '' ? "&nbsp;".$data_order_detail['order_p_size'] : "").($data_order_detail['order_p_color'] != '' ? "&nbsp;".$data_order_detail['order_p_color'] : "");?></td>
                            <td align="center" bgcolor="#F5F5F5"><?php echo $data_order_detail['order_p_stock'];?></td>
                            <td align="center" bgcolor="#F5F5F5"><?php echo number_format($data_order_detail['order_p_price']);?></td>
                            <td align="center" bgcolor="#F5F5F5"><?php echo number_format($data_order_detail['order_p_total']);?></td>
                            <td align="center" bgcolor="#F5F5F5"><?php echo $data_order_detail['order_p_type'];?></td>
                            <td align="center" bgcolor="#F5F5F5"><?php echo $data_order_detail['tracking_number'];?></td>
                          </tr>
                               <?php 
							   $total_all = $total_all + $data_order_detail['order_p_total'];
							   } ?>
                        </table>

                        <div style="text-align:right;">
                        
                        
                       <?php $tran = explode(':',$data_order['order_transport']);?>
                       
                       <?php if($total_all > 0){?>
                        ราคารวมสินค้าทั้งหมด <?php echo number_format($total_all);?> บาท<br />	
                       <?php } if($order_transport_status != '' ){?>	
                        ค่าขนส่ง <?php echo number_format($data_order['order_transport_status']);?> บาท<br />
                        <?php } ?>
                        รวมทั้งสิ้น <?php echo number_format($data_order['order_total']);?> บาท<br />
						<?php  if($order_type_pay != '' ){?>
                        วิธีการชำระเงิน <?php echo $data_order['order_type_pay']; }?>
                        </div>
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

                <input name="CANCEL" type="submit" class="borderfrom" value="Cancle" style="width:110px"
                <?php echo $data_order['order_status'] > '1' ? "disabled=disabled" : "" ;?> onClick="return confirm('คุณต้องการยกเลิกใบสั่งซื้อนี้ ?');">
                                
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
