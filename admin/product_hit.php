<?php
session_start();
require_once '../dbconnect.inc';
include("class.page_split.php");


if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) {
	echo "<script>location.href='index.php'</script>";
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
	
	$('#date_finish').datepicker({
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
                                        ความ Hit ของสินค้า
                                   </div>
                                   <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">ความ Hit ของสินค้า</div>
                    </div>
                    <div class="block_style2_content">

                <form method="post" enctype="multipart/form-data" name="myform">
                <div class="demo" style="text-align:right"></div>                                   

         	<table width="700" border="0" align="center" cellpadding="0" cellspacing="1">
            	<tr class="title03">
                	<td width="13%" height="25" align="center" valign="middle" bgcolor="#F7F7F7" class="first">วันที่</td>
                    <td width="22%" align="center" bgcolor="#F7F7F7"><input type="text" name="date_begin" id="date_begin"  value="<?php echo $_POST['date_begin'];?>"/></td>
                    <td width="21%" align="center" bgcolor="#F7F7F7">ถึง</td>
                    <td width="22%" align="center" bgcolor="#F7F7F7"><input type="text" name="date_finish" id="date_finish"  value="<?php echo $_POST['date_finish'];?>"/></td>
                    <td width="19%" align="center" bgcolor="#F7F7F7">
                    <input type="submit" name="submit" value="Submit" />
                    </td>
                </tr>
            </table>
         	<br />
         	<br />
            
			<?php 
			if($_POST['submit'] == 'Submit' ){
				
				
			$sql_max = "select  pro_id, pro_code, order_p_size, order_p_color, sum(order_p_stock) as stock from order_product_tb where date_in between ";
			$sql_max .= "'".$_POST['date_begin'] ."%'  AND '".$_POST['date_finish'] ."%' ";
			$sql_max .= " GROUP BY pro_code, order_p_size, order_p_color ORDER BY `stock` desc";
			$result_max = @mysql_query($sql_max, $connect);
			$num_max = @mysql_num_rows($result_max);;
            
			
			for($i2=1;$i2<=intval($num_max);$i2++){
			    $data_max=@mysql_fetch_array($result_max);
					
					$select_product = "select p_stock from product_tb where pid = '".$data_max['pro_id']."'";
					$result_product = @mysql_query($select_product, $connect);
			    	$data_product=@mysql_fetch_array($result_product);
					
					$arrProduct[$i2] = $data_max['stock'].":".$data_max['pro_code'].":".$data_max['order_p_size'].":".$data_max['order_p_color'].":".$data_product['p_stock'];

			}
			
			
			}
			
				
				

			?>
			<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
			    <td bgcolor="#000000"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
			      <tr>
			        <td height="25" align="center" bgcolor="#FFFFFF">รหัสสินค้า</td>
			        <td align="center" bgcolor="#FFFFFF">Size</td>
			        <td align="center" bgcolor="#FFFFFF">Color</td>
			        <td align="center" bgcolor="#FFFFFF">จำนวนที่สั่ง</td>
			        <td align="center" bgcolor="#FFFFFF">จำนวนคงเหลือ</td>
			        </tr>
			      <?php 

				foreach($arrProduct as $y => $key){
			
				$exPro = explode(':', $key);
			
				?>
			      <tr>
			        <td width="241" height="25" align="center" bgcolor="#FFFFFF"><?php echo $exPro[1];?></td>
			        <td width="256" align="center" bgcolor="#FFFFFF"><?php echo $exPro[2];?></td>
			        <td width="256" align="center" bgcolor="#FFFFFF"><?php echo $exPro[3];?></td>
			        <td width="256" align="center" bgcolor="#FFFFFF"><?php echo $exPro[0];?></td>
			        <td width="256" align="center" bgcolor="#FFFFFF"><?php echo $exPro[4];?></td>
			        </tr>
			      <?php
				  }
				  ?>
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
