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
            <?php include('mainmenu.php');?>
            <!--End Main Menu-->
            <div class="content_r">
            
                                	<!--Edit Navigator-->
                                   <div class="navigator">
                                        พิมพ์รายการจัดส่ง
                                   </div>
                                   <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">พิมพ์รายการจัดส่ง</div>
                    </div>
                    <div class="block_style2_content">

                <form method="post" enctype="multipart/form-data" name="myform" action="printsent.php">
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
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
			    <td bgcolor="#000000"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
			      <tr>
			        <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
			        <td align="center" bgcolor="#FFFFFF">จำนวนซองทั้งหมด</td>
			        <td align="center" bgcolor="#FFFFFF">EMS</td>
			        <td align="center" bgcolor="#FFFFFF">ลงทะเบียน</td>
			        <td align="center" bgcolor="#FFFFFF">สินค้าทั้งหมด</td>
			        <td align="center" bgcolor="#FFFFFF">Comment</td>
			        <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
			        </tr>
			      <?php 
			    
            for($i=1;$i<=intval($num_max);$i++){
			
			?>
			      <tr>
			        <td width="49" height="25" align="center" bgcolor="#FFFFFF">ครั้งที่ <?php echo $i;?></td>
			        <td width="132" align="center" bgcolor="#FFFFFF"><?php echo $count_tran[$i];?></td>
			        <td width="67" align="center" bgcolor="#FFFFFF"><?php echo $ems[$i];?></td>
			        <td width="74" align="center" bgcolor="#FFFFFF"><?php echo $normal[$i];?></td>
			        <td width="84" align="center" bgcolor="#FFFFFF"><?php echo  $count_num[$i];?></td>
			        <td width="315" align="center" bgcolor="#FFFFFF"><?php echo $comment[$i];?></td>
			        <td width="189" align="center" bgcolor="#FFFFFF">
                    [ <a href="printfile.php?r=<?php echo $i;?>&amp;d=<?php echo $ready_time_done[$i];?>" target="_blank">พิมพ์</a> ]&nbsp;&nbsp;&nbsp;
                    
                    <?php if($who_done[$i] != ''  ){ 
					echo "[ ".$who_done[$i]." ]";?>
                    <?php }else{?>
                    [ <a href="printsent.php?Done=Done&r=<?php echo $i;?>&amp;d=<?php echo $ready_time_done[$i];?>">Done</a> ]
                    <?php }?>
                    </td>
			        </tr>
			      <?php
            }
            ?>
		        </table></td>
		      </tr>
			  </table>
			<?php } ?> 


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
