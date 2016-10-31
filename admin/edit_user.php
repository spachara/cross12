<?php
	session_start();
	require_once '../dbconnect.inc';
	include("fckeditor/fckeditor.php") ;
	require_once 'process_pic.php';
	
	if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) {
		echo "<script>location.href='index.php'</script>";
	}
	
	if($_POST['Submit'] == 'UPDATE'){
			
			if($_POST['u_birth']!=''){
				$date_into = dete_into_db($_POST['u_birth']);
			}else{
				$date_into = '0000-00-00';	
			}
			
			if($_POST['u_discount_expire']!=''){
				$date_discount_expire = dete_into_db($_POST['u_discount_expire']);
			}else{
				$date_discount_expire = '0000-00-00';
			}
			
			if($_POST['u_score_expire']!=''){
				$date_score_expire = dete_into_db($_POST['u_score_expire']);
			}else{
				$date_score_expire = '0000-00-00';
			}
			
			/*echo $date_into."<br>";
			echo $date_discount_expire."<br>";
			echo $date_score_expire."<br>";
			echo $_POST['u_score_facebook']."<br>";*/
			
			$edit_user = "UPDATE user_tb SET u_fname = '".$_POST['u_fname']."', u_lname = '".$_POST['u_lname']."', u_tel = '".$_POST['u_tel']."', ";
			$edit_user .= " u_mobi = '".$_POST['u_mobi']."', u_fax = '".$_POST['u_fax']."', u_birth = '".$date_into."', u_mail = '".$_POST['u_mail']."', ";
			$edit_user .= " u_add = '".$_POST['u_add']."', u_province = '".$_POST['u_province']."',u_zipcode = '".$_POST['u_zipcode']."'";
			$edit_user .= ", u_user = '".$_POST['u_user']."', u_pass = '".$_POST['u_pass']."' ";
			$edit_user .= ", u_facebook = '".$_POST['u_facebook']."', line_id = '".$_POST['line_id']."', line_name = '".$_POST['line_name']."' ";
			$edit_user .= "WHERE u_id = '".$_POST['u_id']."' ";
			@mysql_query($edit_user, $connect);
			/*echo $date_score_expire."<br>";
			echo $_POST['u_score_expire'];*/
			
			//echo $edit_user;
	?>
				  <script>
					location.href='edit_user.php?u_id=<?php echo $_GET['u_id'];?>';
				  </script>
	<?php
	
	}// END CREATE
	
	$sql_user = "SELECT * FROM user_tb WHERE u_id = '".$_GET['u_id']."' ";
	$result_user =@mysql_query($sql_user, $connect);
	$data_user =@mysql_fetch_array($result_user);
	
	function date_from_db($date){
		$d_from = substr($date,8,2);
		$m_from = substr($date,5,2);
		$y_from = substr($date,0,4);
		return $d_from."/".$m_from."/".$y_from;
	}
	function dete_into_db($into){
		$d_into = substr($into,0,2);
		$m_into = substr($into,3,2);
		$y_into = substr($into,6,4);
		return $y_into."-".$m_into."-".$d_into;
	}
	
	if($data_user['u_discount_expire']!='' && $data_user['u_discount_expire']!='0000-00-00'){
		$discount_expire = date_from_db($data_user['u_discount_expire']);
	}else{
		$discount_expire = '';
	}
	
	if($data_user['u_score_expire']!='' && $data_user['u_score_expire']!='0000-00-00'){
		$score_expire = date_from_db($data_user['u_score_expire']);
	}else{
		$score_expire = '';
	}
    $today = date('Y')."-".date('m')."-".date('d');
	
	$expire_discount = $data_user['u_discount_expire'];
	$expire_score = $data_user['u_score_expire'];
	
	if($today <= $expire_score){ //วันปัจุบันน้อยกว่า วันหมดอายุ เท่ากับยังไม่หมดอายุ
		
		$total_score = $data_user['u_score'];
		$total_score +=$data_user['u_score_facebook'];
		
	}elseif($today > $expire_score){ //วันปัจุบันมากกว่า วันหมดอายุ เท่ากับยังหมดอายุ
		
		$total_score = $data_user['u_score'];
		
	}
	
	$sql_order = "SELECT * FROM order_tb WHERE u_id = '".$data_user['u_id']."' ";
	$result_order =@mysql_query($sql_order, $connect);
	$num_order =@mysql_num_rows($result_order);
	
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<script language="javascript">
function chk_length(){
	if(document.myform.news_title.value.length > 30){
			var a = document.myform.news_title.value;
			var x = document.getElementById("head_news");
			x.innerHTML="<font color=red size=-1>ไม่ควรใส่อักษรเกิน 30 ตัว</font>";
			a = a.substr(0, 30);
			document.myform.news_title.value = a;
	}else{
			var x = document.getElementById("head_news");
			x.innerHTML="";
	}
}
</script>
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

				$('#datepicker2').datepicker({
					yearRange: "any:c+100",
					changeMonth: true,
					changeYear: true,
					dateFormat: 'dd/mm/yy'
					
				});
				$('#datepicker3').datepicker({
					yearRange: "any:c+100",
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
                                        <a href="new_user.php">สมาชิก</a>
                                        >
                                        <a href="#">แก้ไขสมาชิก</a>
                                   </div>
                                   <!--End Navigator-->            
                                    <form method="post" enctype="multipart/form-data" name="myform">
                                    <!--Block Frame-->
                                    <div class="block_style2">
                                        <div class="block_style2_top">
                                            <div class="block_style2_top-l"></div>
                                            <div class="block_style2_top-r"></div>
                                            <div class="block_style2_top-t">แก้ไขสมาชิก</div>
                                        </div>
                                        <div class="block_style2_content">
                                   	<div class="table_3cell">
                                     	<ul>
                                        	<!--Title-->
                                            
                                            <li>
                                            	<div class="cell3-text">Username :</div>
                                                <div class="cell3-input"><input name="u_user" type="text" id="u_user" value="<?php echo $data_user['u_user'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">Password :</div>
                                                <div class="cell3-input"><input name="u_pass" type="text" id="u_pass" value="<?php echo $data_user['u_pass'];?>"/></div>
                                            </li>
                                            
                                            <li>
                                            	<div class="cell3-text">ชื่อ :</div>
                                                <div class="cell3-input"><input name="u_fname" type="text" id="u_fname" value="<?php echo $data_user['u_fname'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">นามสกุล :</div>
                                                <div class="cell3-input"><input name="u_lname" type="text" id="u_lname" value="<?php echo $data_user['u_lname'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">เบอร์มือถือ:</div>
                                                <div class="cell3-input"><input name="u_mobi" type="text" id="u_mobi" value="<?php echo $data_user['u_mobi'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">วันเกิด :</div>
                                                <div class="cell3-input"><input name="u_birth" type="text" id="datepicker" value="<?php echo date_from_db($data_user['u_birth']);?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">อีเมล์ :</div>
                                                <div class="cell3-input"><input name="u_mail" type="text" id="u_mail" value="<?php echo $data_user['u_mail'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">ที่อยู่ :</div>
                                                <div class="cell3-input_textarea">
                                                  <textarea name="u_add" cols="22" rows="5" id="u_add"><?php echo $data_user['u_add'];?></textarea>
                                                </div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">จังหวัด :</div>
                                                <div class="cell3-input"><input name="u_province" type="text" id="u_province" value="<?php echo $data_user['u_province'];?>"/></div>
                                        </li>
                                           <li>
                                            	<div class="cell3-text">รหัสไปรษณีย์์์ :</div>
                                                <div class="cell3-input"><input name="u_zipcode" type="text" id="u_zipcode" value="<?php echo $data_user['u_zipcode'];?>"/></div>
                                        </li>
                                            <li>
                                            	<div class="cell3-text">Facebook :</div>
                                                <div class="cell3-input"><input name="u_facebook" type="text" id="u_facebook" value="<?php echo $data_user['u_facebook'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">Line ID :</div>
                                                <div class="cell3-input"><input name="line_id" type="text" id="line_id" value="<?php echo $data_user['line_id'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">Line name :</div>
                                                <div class="cell3-input"><input name="line_name" type="text" id="line_name" value="<?php echo $data_user['line_name'];?>"/></div>
                                            </li>
                                       
                                        </ul>
                                    </div>
                                   <!--End ตาราง 3 Cell-->
                                   
                                    <div class="demo">
                                    
                                    <!--<button>Submit</button>-->
                                   	<input name="u_id" type="hidden" value="<?php echo $data_user['u_id'];?>" />
									<input name="Submit" type="submit" class="borderfrom" style="width:80px" value="UPDATE">
                                    
                                    </div>
                                <br /><br />
                                <table width="95%" border="0" cellspacing="0" cellpadding="0">
									  <tr>
									    <td bgcolor="#000000"><table width="100%" border="0" cellpadding="0" cellspacing="1">
									      <tr class="titleTable_order">
									        <td width="25%" align="center" valign="middle" bgcolor="#F8F8F8"><p>Order Number</p>
									          <span>เลขที่ใบสั่งซื้อ</span></td>
									        <td width="13%" align="center" valign="middle" bgcolor="#F8F8F8"><p>Price</p>
									          <span>ยอดรวม(บาท)</span></td>
									        <td width="24%" align="center" valign="middle" bgcolor="#F8F8F8"><p>Status<span></span> <br />
									          สถานะ</p></td>
									        <td width="22%" align="center" valign="middle" bgcolor="#F8F8F8" >สถานะการชำระเงิน</td>
									        <td width="12%" align="center" valign="middle" bgcolor="#F8F8F8" >&nbsp;</td>
									        <td width="4%" align="center" valign="middle" bgcolor="#F8F8F8" >&nbsp;</td>
								          </tr>
									      <!------------------------------------------>
									      <?php                        
                        $sql_insert_order = "select * from order_tb where u_id = '".$_GET['u_id']."' Group by order_number order by date_in desc ";
                        $result_insert_order = @mysql_query($sql_insert_order, $connect);
                        $num_order = @mysql_num_rows($result_insert_order);
						
						   for($p=1;$p<=intval($num_order);$p++){
						   $data_order= @mysql_fetch_array($result_insert_order);
						   
						   
								$sql_insert_order4 = "select * from order_tb where order_number = '".$data_order['order_number']."'";
								$result_insert_order4 = @mysql_query($sql_insert_order4, $connect);
								$num_order4 = @mysql_num_rows($result_insert_order4);
								$data_order4= @mysql_fetch_array($result_insert_order4);
								
								if($num_order4 == 2){ 
									
									$val_order = $data_order4['order_number']."-IN <br> ".$data_order4['order_number']."-PRE";
										
										$select_order4 = "SELECT SUM(order_total) as total_order, SUM(order_transport_status) as sum_tran, order_promotion, order_point FROM order_tb WHERE order_number = '".$data_order['order_number']."'";
										$result_order4 =@mysql_query($select_order4, $connect);
										$num_order4 =@mysql_num_rows($result_order4);
										$data_order4 =@mysql_fetch_array($result_order4);


										$total_order_show =  $data_order4['total_order'];
										
										if($data_order4['order_promotion'] != '' ){
										$total_order_show =  $total_order_show - ($total_order_show * ($data_order4['order_promotion']/100));
										}
										$total_order_show =  $total_order_show + $data_order4['sum_tran'];
										if($data_order4['order_point'] != '' ){
										$total_order_show =  $total_order_show - $data_order4['order_point'];
										}
								
								}else{
									$val_order = $data_order4['order_number']."-".$data_order4['order_type'];
											
										
										
										$select_order4 = "SELECT SUM(order_total) as total_order, SUM(order_transport_status) as sum_tran, order_promotion, order_point FROM order_tb WHERE order_number = '".$data_order['order_number']."'";
										$result_order4 =@mysql_query($select_order4, $connect);
										$num_order4 =@mysql_num_rows($result_order4);
										$data_order4 =@mysql_fetch_array($result_order4);
										$total_order_show =  $data_order['order_total'];
										
										$total_order_show =  $data_order4['total_order'];
										
										if($data_order4['order_promotion'] != '' ){
										$total_order_show =  $total_order_show - ($total_order_show * ($data_order4['order_promotion']/100));
										}
										$total_order_show =  $total_order_show + $data_order4['sum_tran'];
										if($data_order4['order_point'] != '' ){
										$total_order_show =  $total_order_show - $data_order4['order_point'];
										}
								}
						   
							   $tracking_number = "";
														
								$sql_check_order_status = "SELECT * FROM order_product_tb WHERE order_number = '".$data_order['order_number']."' ";
								$result_check_order_status =@mysql_query($sql_check_order_status, $connect);
								$num_check_order_status =@mysql_num_rows($result_check_order_status);
								for ($chk=1; $chk<=$num_check_order_status; $chk++) {
									$data_check_order_status =@mysql_fetch_array($result_check_order_status);
									
									if ($data_check_order_status['tracking_number'] != "") {
										$tracking_number[] = "T";
									} else {
										$tracking_number[] = "F";
									}
								}
								//print_r($tracking_number);
                        ?>
									      <tr>
									        <td height="40" align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $val_order;?></td>
									        <td align="center" valign="middle" bgcolor="#FFFFFF"><strong><?php echo number_format($total_order_show);?></strong></td>
									        <td align="center" valign="middle" bgcolor="#FFFFFF"><?php 
												if (in_array("T", $tracking_number, true) && in_array("F", $tracking_number, true)) {
														echo "<font color=#F90>ค้างส่งสินค้าบางรายการ</font>";
												} else {
													if($data_order['order_status']==0){
														echo "<font color=#FF0000>ยกเลิกใบสั่งซื้อ</font>";
													}elseif($data_order['order_status']==1){
														echo "<font color=#000000>รอชำระค่าสินค้า</font>";
													}elseif($data_order['order_status']==5){
														echo "<font color=#6600CC>แจ้งชำระเงินแล้ว/กำลังรอตรวจสอบ</font>";
													}elseif($data_order['order_status']==2){
														echo "<font color=#6600CC>ได้รับชำระเงินแล้ว/กำลังจัดส่งสินค้า</font>";
													}elseif($data_order['order_status']==3){
														echo "<font color=#0000FF>จัดส่งสินค้าเรียบร้อยแล้ว</font>";
													}elseif($data_order['order_status']==4){
														echo "<font color=#00CC00>Complete</font>";
													}
												}
												?></td>
									        <td align="center" valign="middle" bgcolor="#FFFFFF"><?php
								if($data_order['payment_status']==0){
									echo "<font color=#000000>ยังไม่ได้แจ้งขำระเงิน</font>";
								}else{
									echo "<font color=#6600CC>แจ้งชำระเงินแล้ว</font>";
								}
							?></td>
									        <td align="center" valign="middle" bgcolor="#FFFFFF"><?php 
								if($data_order['tranfer_status']==1){
									echo "<font color=#000000>โอนพอดี</font>";
								}elseif($data_order['tranfer_status']==2){
									echo "<font color=red>โอนขาด</font>:".$data_order['tranfer_value'];
								}elseif($data_order['tranfer_status']==3){
									echo "<font color=#FF6600>โอนเกิน</font>:".$data_order['tranfer_value'];
								}
							?></td>
									        <td align="center" valign="middle" bgcolor="#FFFFFF">
                                            
                                            <a href="edit_order.php?n=<?php echo $data_order['order_number'];?>" target="_blank"><img alt="" title="" src="images/icon-view.png" /></a>
                                            
                                            </td>
								          </tr>
									      <?php }?>
								        </table></td>
								      </tr>
									  </table>                                    
                                    
                                                                       
                                            </div>
                                            <div class="bottom">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                            </div>
                                        </div>
										<!--End Coppy Module Clear-->                                 
                                        
                                      
                                    </form>
                
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
