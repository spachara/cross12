<?php
session_start();
require_once '../dbconnect.inc';
include("class.page_split.php");


if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) {
	echo "<script>location.href='index.php'</script>";
}
	
			if($_POST['submit'] == 'Submit' ){
				$sql_max = "select ready_time,max(round_update) as max_round  from order_product_tb where ready_time = '".$_POST['date_begin']."'";
				$result_max = @mysql_query($sql_max, $connect);
												
			}else{
				$sql_max = "select ready_time,max(round_update) as max_round  from order_product_tb where ready_time = '".$_GET['d']."'";
				$result_max = @mysql_query($sql_max, $connect);
			}

			if($_GET['Done'] == 'Done' ){
				$sql_update2 = "UPDATE order_product_tb SET round_done = '".$_SESSION['AUTH_PERMISSION_NAME']."'";
				$sql_update2 .= " where ready_time = '".$_GET['d']."' and round_update = '".$_GET['r']."'";
				$result_update2 = @mysql_query($sql_update2, $connect);

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

<link href="cssstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../js/datepicker/css/ui-darkness/jquery-ui-1.10.3.custom.css" type="text/css">
<script type="text/javascript" src="../js/datepicker/js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript">
$(function(){

	
	// Datepicker
	$('#date_begin').datepicker({
		yearRange: "1950:+0",
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		
	});
	
	$('#date_to').datepicker({
		yearRange: "1950:+0",
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		
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
            <?php //include('mainmenu.php');?>
            <!--End Main Menu-->

            
                                	<!--Edit Navigator-->
                                   <div class="navigator">
                                        สรุปรายการส่งสินค้า
                                   </div>
                                   <!--End Navigator-->            
            
            	<!--Block Frame-->
       	  <div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">สรุปรายการส่งสินค้า</div>
                    </div>
            <div class="block_style2_content">

              <form method="post" enctype="multipart/form-data" name="myform" action="report_transport.php">
                <div class="demo" style="text-align:right"></div>                                   

         	<table width="500" border="0" align="center" cellpadding="0" cellspacing="1">
            	<tr class="title03">
                	<td width="16%" height="25" align="center" valign="middle" bgcolor="#F7F7F7" class="first">วันที่</td>
                    <td width="19%" align="center" bgcolor="#F7F7F7"><input type="text" name="date_begin" id="date_begin"  value="<?php echo $_POST['date_begin'];?>"/></td>
                    <td width="26%" align="center" bgcolor="#F7F7F7">
                    <input type="submit" name="submit" value="Submit" />
                    </td>
                </tr>
            </table>
         	<br />
         	<br />
            
			<?php 
            $data_max=@mysql_fetch_array($result_max);
			$num_max = $data_max['max_round'];  
			if($num_max >= 1){
				
				
            for($i2=1;$i2<=intval($num_max);$i2++){

					$sql_update2 = "select * from order_product_tb where ready_time = '".$data_max['ready_time']."' and round_update = '".$i2."'";
					$result_update2 = @mysql_query($sql_update2, $connect);
					$num_update2 =@mysql_num_rows($result_update2);
					
					for($i5=0;$i5<intval($num_update2);$i5++){
						
					$data_update2 =@mysql_fetch_array($result_update2);
					
						$arrProduct[$i5] = $data_update2['order_number'];
						$count_num[$i2] = $count_num[$i2] + $data_update2['order_p_stock'];
						$comment[$i2] = $data_update2['round_comment'];
						$ready_time_done[$i2] = $data_update2['ready_time'];
						$who_done[$i2] = $data_update2['round_done'];
					
					}
			
					$arrProduct = array_unique( $arrProduct );

					foreach($arrProduct as $y => $key){
		
					$sql_order = "select * from order_tb where order_number = '".$key."' ";
					$result_order = @mysql_query($sql_order, $connect);
					$data_order =@mysql_fetch_array($result_order);
					
							if($data_order['order_transport'] == 'ไปรษณีย์ส่งด่วน พิเศษ ( EMS )'){
								$ems[$i2] = $ems[$i2] + 1;
								$count_tran[$i2] = $count_tran[$i2] + 1;
							}else{
								$normal[$i2] = $normal[$i2] + 1;
								$count_tran[$i2] = $count_tran[$i2] + 1;
							}
					}
					unset($arrProduct);
			
			
			}

			?>

                
			      <?php 
			    
            for($i=1;$i<=intval($num_max);$i++){
			
			?>
                <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
			      <tr>
			        <td height="25" bgcolor="#FDD5CD">&nbsp;</td>
			        <td align="center" bgcolor="#FDD5CD">จำนวนซองทั้งหมด</td>
			        <td align="center" bgcolor="#FDD5CD">EMS</td>
			        <td align="center" bgcolor="#FDD5CD">ลงทะเบียน</td>
			        <td align="center" bgcolor="#FDD5CD">สินค้าทั้งหมด</td>
			        <td width="366" align="center" bgcolor="#FDD5CD">Comment</td>
			        </tr>
			      <tr>
			        <td width="49" height="25" align="center" bgcolor="#DEF4FC">ครั้งที่ <?php echo $i;?></td>
			        <td width="176" align="center" bgcolor="#DEF4FC"><?php echo $count_tran[$i];?></td>
			        <td width="225" align="center" bgcolor="#DEF4FC"><?php echo $ems[$i];?></td>
			        <td width="160" align="center" bgcolor="#DEF4FC"><?php echo $normal[$i];?></td>
			        <td width="175" align="center" bgcolor="#DEF4FC"><?php echo  $count_num[$i];?></td>
			        <td align="center" bgcolor="#DEF4FC"><?php echo $comment[$i];?></td>
			        </tr>
			      <tr>
 </table>
			      
<table width="100%" border="1" align="left" cellpadding="0" cellspacing="0">
			            
			            <?php
                                
                                
                                $sql_update7 = "select * from order_product_tb where ready_time = '".$ready_time_done[$i]."' and round_update = '".$i."'";
                                $result_update7 = @mysql_query($sql_update7, $connect);
                                $num_update7 =@mysql_num_rows($result_update7);

								unset($arrProduct2);
                                for($i5=0;$i5<intval($num_update7);$i5++){
                                
                                $data_update2 =@mysql_fetch_array($result_update7);
                                
                                $arrProduct2[$i5] = $data_update2['order_number'];
                                
                                }

								
                                $arrProduct2 = array_unique( $arrProduct2 );
                                $col=2;
                                $a=0;
								//print_r($arrProduct2);
                                foreach($arrProduct2 as $y2 => $key2){
                                
                                $sql_order = "select * from order_tb where order_number = '".$key2."' ";
                                $result_order = @mysql_query($sql_order, $connect);
                                $data_order =@mysql_fetch_array($result_order);
                                ?>
			            <tr>
                        <td width="32%" height="25" valign="top" bgcolor="#F9F9F9">
			                

			                    <?php 
                                $sql_update5 = "select * from order_product_tb where order_number = '".$key2."' ";
                                $sql_update5 .= "and ready_time = '".$ready_time_done[$i]."' and round_update = '".$i."' and ready_sent <> '0' ";
                                $result_update5 = @mysql_query($sql_update5, $connect);
                                $num_update5 =@mysql_num_rows($result_update5);
                                $order_to = '';
                                
                                for($i5=1;$i5<=intval($num_update5);$i5++){
                                $data_update5 =@mysql_fetch_array($result_update5);
                                
                                if($data_update5['order_type'] !=  $type){
                                $type = $data_update5['order_type'];
                                $order_to .= "Order number : ".$data_update5['order_number']."-".$data_update5['order_type']."<br>";
                                }else{
                                $order_to = "Order number : ".$data_update5['order_number']."-".$data_update5['order_type'];
                                }
                                }
                                
                                echo $order_to;
                                
                                if($data_order['order_transport'] == 'ไปรษณีย์ส่งด่วน พิเศษ ( EMS )'){
                                echo " ( EMS )";
                                }
                                echo "<br>";
                                
                                $exName = explode('เบอร์โทรศัพท์',$data_order['order_address2']);
                                
                                $exPhone = explode('อีเมล์',$exName[1]);
                                ?>
			                    <td width="36%" valign="top" bgcolor="#F9F9F9">
								<?php
                                $name = explode('ที่อยู่',$exName[0]);
								echo ereg_replace('ชื่อ : ','',$name[0]);
                                ?></td>
			                    <td width="32%" valign="top" bgcolor="#F9F9F9">
			                      <table width='100%'>
			                      <?php
                                $sql_update3 = "select * from order_product_tb where order_number = '".$key2."' ";
                                $sql_update3 .= "and ready_time = '".$ready_time_done[$i]."' and round_update = '".$i."' and ready_sent <> '0' ";
                                $result_update3 = @mysql_query($sql_update3, $connect);
                                $num_update3 =@mysql_num_rows($result_update3);
                                
                                for($i6=1;$i6<=intval($num_update3);$i6++){
                                $data_update3 =@mysql_fetch_array($result_update3);
                                
                                
                                
                                $product_color = "select name from color_tb where c_code = '".$data_update3['order_p_color']."' ";
                                $result_productcolor = @mysql_query($product_color, $connect);
                                $data_productcolor =@mysql_fetch_array($result_productcolor);
                                echo "<tr><td width='70%'>";
                                echo $i6.". ".$data_update3['pro_code']." ".$data_productcolor['name']." ".$data_update3['order_p_size']." : ".$data_update3['order_p_stock']."</td><td " .  ($data_update3['tracking_number'] == '' ? 'bgcolor="yellow"' : '') . ">" . $data_update3['tracking_number'];
                                 echo "</td></tr>";
                                } 
                                
                                ?>
                                </table>       
		                  </td>
			              </tr>
			            <?php
                                }
                                ?>
			            
			            </table>				  <?php

			}
            ?>
		       
                
                
                
                

			<?php } ?> 


                </form>
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
