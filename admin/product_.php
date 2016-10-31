<?php
session_start();
require_once '../dbconnect.inc';

include("class.page_split.php");
$obj = new page_split();
$obj->_setPageSize(100);						
$obj->_setFile("product.php");		
$obj->_setPage($_GET['page']);		
if($_GET['page'] > 1){
	$f = 100*($_GET['page']- 1);
}

if($_SESSION['AUTH_PERMISSION_ID']=='') {
	header("Location:index.php");
}

if($_POST['btnSubmit2'] == 'Save Ranking'){
	
	if($_POST['hidden_new_id']){
		foreach ($_POST['hidden_new_id'] as $v) {

				$update_new_ranking = "UPDATE product_tb SET ranking = '".$_POST['new_ranking'][$v]."'  ";
				$update_new_ranking .= "WHERE pid = '".$_POST['hidden_new_id'][$v]."'";
				$update_new_ranking_result = @mysql_query($update_new_ranking, $connect);
				

		}
	}
}

if($_POST['btnSubmit3'] == 'Delete'){
	
	if($_POST['hidden_new_id']){
		foreach ($_POST['hidden_new_id'] as $v) {

					if($_POST['id_del'][$v] == '1'){

					$sql_delete_product = "DELETE FROM product_tb  WHERE pid = '".$_POST['hidden_new_id'][$v]."' ";
					@mysql_query($sql_delete_product, $connect);
			

					}


		}
	}
}



if($_GET['sAction'] == 'del'){
	$delete_howto = "DELETE FROM product_tb  WHERE pid = '".$_GET['id_del']."' ";
	@mysql_query($delete_howto, $connect);
?>		 
		<script>
			location.href='product.php'; //รีเฟสหน้า
		</script>
<?php
}

if($_POST['btnSubmit2'] == 'Submit'){
	
			foreach ($_POST['hidden_new_id'] as $v) {

					if($_POST['chk'][$v]){
					$update_new_ranking = "UPDATE product_tb SET branch_id = '".$_POST['branch_id']."'  ";
					$update_new_ranking .= "WHERE pid = '".$_POST['hidden_new_id'][$v]."'";
					$update_new_ranking_result = @mysql_query($update_new_ranking, $connect);
					
					//echo "<br>".$update_new_ranking;
					}
					
			}
?>
		  <script>
		  alert('ย้ายไปสาขาเรียบร้อยคะ');
		  window.location.href='product.php';
		  </script>
<?php

}

if($_POST['btnSubmit'] == 'Submit'){
	
move_uploaded_file($_FILES["fileCSV"]["tmp_name"],$_FILES["fileCSV"]["name"]); // Copy/Upload CSV



$objCSV = fopen($_FILES["fileCSV"]["name"], "r");



while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {

if($objArr[2] != ''){

	$strSQL = "INSERT INTO product_tb ";
	$strSQL .="(pid, p_category, p_code, p_color, p_size, name, name_eng, p_details, p_details_eng, p_overview, p_overview_eng";
	$strSQL .=", p_info, p_info_eng, p_stock, p_pre, p_spare, p_wornout, p_price, p_special, p_clearance, p_supplier, p_minimum, shoulder, breast, waist";
	$strSQL .=", hip, arm, alllength, waist_end, waist_crotch, shoulder_waist, shoulder_crotch, thigh, armlength, set_waist, set_hip, set_length";
	$strSQL .=", set_waist_skirts, set_hip_skirts, set_length_skirts, date_in) ";
	$strSQL .="VALUES ";
	$strSQL .="('".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[0]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[1]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[2]))."' ";
	$strSQL .=",'".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[3]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[4]))."','".ereg_replace('/','\/',ereg_replace(',','\,',iconv( 'TIS-620', 'UTF-8', $objArr[5])))."' ";
	$strSQL .=",'".ereg_replace('/','\/',ereg_replace(',','\,',iconv( 'TIS-620', 'UTF-8',$objArr[6])))."','".ereg_replace('/','\/',ereg_replace(',','\,',iconv( 'TIS-620', 'UTF-8',$objArr[7])))."','".ereg_replace('/','\/',ereg_replace(',','\,',iconv( 'TIS-620', 'UTF-8',$objArr[8])))."' ";
	$strSQL .=",'".ereg_replace('/','\/',ereg_replace(',','\,',iconv( 'TIS-620', 'UTF-8',$objArr[9])))."','".ereg_replace('/','\/',ereg_replace(',','\,',iconv( 'TIS-620', 'UTF-8',$objArr[10])))."','".ereg_replace('/','\/',ereg_replace(',','\,',iconv( 'TIS-620', 'UTF-8',$objArr[11])))."' ";
	$strSQL .=",'".ereg_replace('/','\/',ereg_replace(',','\,',iconv( 'TIS-620', 'UTF-8',$objArr[12])))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[13]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[14]))."' ";
	$strSQL .=",'".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[15]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[16]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[17]))."' ";
	$strSQL .=",'".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[18]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[19]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[20]))."'";
	$strSQL .=",'".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[21]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[22]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[23]))."'";
	$strSQL .=",'".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[24]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[25]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[26]))."'";
	$strSQL .=",'".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[27]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[28]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[29]))."'";
	$strSQL .=",'".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[30]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[31]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[32]))."'";
	$strSQL .=",'".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[33]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[34]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[35]))."'";
	$strSQL .=",'".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[36]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[37]))."','".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[38]))."'";
	$strSQL .=",'".ereg_replace('/','\/',ereg_replace(',','\,',$objArr[39]))."',NOW()) ";
	$objQuery = @mysql_query($strSQL,$connect);
}

}

fclose($objCSV);
@unlink($_FILES["fileCSV"]["name"]);


?>
		  <script>
		  alert('Import Done.');
		  window.location.href='product.php';
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
	<link rel="stylesheet" href="jquery_ui/development-bundle/demos/demos.css">
	<script>
	$(function() {
		$( "input:submit, a, button", ".demo" ).button();
		$( "a", ".demo" ).click(function() { return false; });
	});
	</script>
<!--//////////////////////////////////////Fancy Box//////////////////////////////////////-->
	<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>-->
	<script type="text/javascript" src="../js/fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
	<script type="text/javascript" src="../js/fancybox/jquery.fancybox-1.3.1.js"></script>
    <script type="text/javascript" src="../js/fancybox/fancybox-jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/fancybox/jquery.fancybox-1.3.1.css" media="screen" />
<!--//////////////////////////////////////Fancy Box//////////////////////////////////////--> 
<link href="cssstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../js/datepicker/css/ui-darkness/jquery-ui-1.10.3.custom.css" type="text/css">
<script type="text/javascript" src="../js/datepicker/js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript">
$(function(){

$('#datepicker2').datepicker({
	yearRange: "1950:+0",
	changeMonth: true,
	changeYear: true,
	dateFormat: 'yy-mm-dd'

});
	



});
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
<script type="text/javascript">
function processPopupLink(){
	$(document).ready(function() {
		$.fancybox({
				'href' : 'popup.php',
				'width'				: 800,
				'height'			: 500,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'transitionIn'	: 'fade',
				'transitionOut'	: 'fade',				
				'type'				: 'iframe',
			});
		});
}

function processPopupLink2(){
	$(document).ready(function() {
		$.fancybox({
				'href' : 'popup2.php',
				'width'				: 800,
				'height'			: 500,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'transitionIn'	: 'fade',
				'transitionOut'	: 'fade',				
				'type'				: 'iframe',
			});
		});
}



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
          <?php //include('mainmenu.php');?>
            <!--End Main Menu
            <div class="content_r">-->

                <!--Edit Navigator-->
               <div class="navigator">
                <a href="new_webboard.php">Home</a> |  <a href="product.php">Products</a>
                    
               </div>
               <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">Products</div>
                    </div>
                    <div class="block_style2_content">



                                   		<!--Coppy Module Clear-->
                                        <form action="product.php" method="post" enctype="multipart/form-data" name="form1">
                                        <div class="module_3">
                                            <div class="title">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                                <div class="t"><h2>
                                                  ไฟล์ข้อมูลเข้า 
                                                  <input name="fileCSV" type="file" id="fileCSV">
                                                  <input name="btnSubmit" type="submit" id="btnSubmit" value="Submit"><br /><br />
                                                </h2> </div>
                                                <div class="bt">
                                                	 
                                                </div>
                                            </div>
                                            
                                            <div class="title">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                                <div class="t" style="height:inherit; overflow:hidden; margin-bottom:5px;"><h2>
                                                  ค้นหาตามรหัส 
                                                  <input name="Search_code" type="text" id="Search_code" value="<?php echo $_POST['Search_code'];?>">&nbsp;&nbsp;
                                                  Date import 
                                                  <input type="text" name="date_in" id="datepicker2" value="<?php echo $_POST['date_in'];?>" />&nbsp;&nbsp;
                                                  <input name="SearchSubmit" type="submit" id="SearchSubmit" value="Search">
                                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                  <input type="checkbox" id="selecctall"/> Select All<br /><br /><br />
                                                </h2> </div>
                                                <div class="bt">
                                                	 
                                                </div>
                                            </div>
                                            
                                                                                        
                                            
                                            <div class="conten">
                                                <!--ใสข้อมูล ตรงนี้-->
                                                <!--ตาราง 3 Cell-->
                                   <div class="title-top" style="margin-top:10px;">
                                   <div class="right-title">
                                       
                                       <table width="100%" border="0" cellspacing="3" cellpadding="0">
                                         <tr>
                                           <td height="25" align="left" bgcolor="#F90">
                                           
                                           <a href="product_print.php" target="_blank"><strong>EXPORT HTML</strong></a>
                                           
                                           </td>
                                           <td height="25" align="left" bgcolor="#F90">
                                           
                                           <a href="#" onClick="processPopupLink();"><strong>เช็คสินค้าหมด</strong></a>
                                           
                                           </td>
                                           <td height="25" align="left" bgcolor="#F90">
                                           
                                           <a href="#" onClick="processPopupLink2();"><strong>สินค้า Spare(จอง)</strong></a>
                                           
                                           </td>
                                         </tr>
                                       </table>
                                   </div>
                                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                     <tr>
                                       <td bgcolor="#000000">
                                       <table width="100%" border="0" cellpadding="0" cellspacing="1" class="table_3cell" style="font-size:12px; font-weight:normal;">
                                         <tr>
                                           <td width="3%" height="40" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
                                           <td width="6%" height="40" align="center" bgcolor="#CCCCCC"><strong>Category</strong></td>
                                           <td width="7%" align="center" bgcolor="#CCCCCC">&nbsp;</td>
                                           <td width="6%" align="center" bgcolor="#CCCCCC"><strong>รหัสสินค้า</strong></td>
                                           <td width="5%" align="center" bgcolor="#CCCCCC"><strong>สี</strong></td>
                                           <td width="5%" align="center" bgcolor="#CCCCCC"><strong>size</strong></td>
                                           <td width="6%" align="center" bgcolor="#CCCCCC"><strong>In Stock</strong></td>
                                           <td width="7%" align="center" bgcolor="#CCCCCC"><strong>In Stock<br />
                                           (จอง)</strong></td>
                                           <td width="7%" align="center" bgcolor="#CCCCCC"><strong>Pre<br />
(พร้อมส่ง)</strong></td>
                                           <td width="7%" align="center" bgcolor="#CCCCCC"><strong>On hand</strong></td>
                                           <td width="6%" align="center" bgcolor="#CCCCCC"><strong>Pre-Order</strong></td>
                                           <td width="7%" align="center" bgcolor="#CCCCCC"><strong>Pre (จอง)</strong></td>
                                           <td width="6%" align="center" bgcolor="#CCCCCC"><strong>Spare</strong></td>
                                           <td width="8%" align="center" bgcolor="#CCCCCC"><strong>Spare (จอง)</strong></td>
                                           <td width="5%" align="center" bgcolor="#CCCCCC"><strong>Make</strong></td>
                                           <td width="11%" align="center" bgcolor="#CCCCCC"><strong>รวมสินค้า<br />
ที่ขายไปแล้ว</strong></td>
                                           <td width="11%" align="center" bgcolor="#CCCCCC"><strong>รวมสินค้า<br />
ทั้งหมด</strong></td>
                                           <td width="11%" align="center" bgcolor="#CCCCCC"><strong>Import</strong></td>
                                           <td width="11%" align="right" bgcolor="#CCCCCC"><!--<input type="hidden" name="save" value="1" />
                                        <input type="image" src="images/save_all.png" alt="Save Ranking" name="Submit" value="Save" title="Save Ranking" style="width:52px; height:16px;"/>-->
                                             <input name="btnSubmit2" type="submit" id="btnSubmit2" value="Save Ranking" /></td>
                                           <td width="5%" align="right" bgcolor="#CCCCCC">
                                           
                                           <input name="btnSubmit3" type="submit" id="btnSubmit3" value="Delete" onClick="javascript: if (confirm('Do you want to delete it. (yes/no)?')) this.form.submit();" /></td>
                                         </tr>
                                         <?php
										 
										if($_POST['Search_code'] != '' ){
										$sql_product = "SELECT * FROM product_tb where p_code like '%".$_POST['Search_code']."%' ";
										}elseif($_POST['date_in'] != '' && $_POST['Search_code'] != ''  ){
										$sql_product .= "AND date_in like '".$_POST['date_in']."%' ";
										}elseif($_POST['date_in'] != '' && $_POST['Search_code'] == ''){
										$sql_product .= "SELECT * FROM product_tb where date_in like '".$_POST['date_in']."%' ";
										}else{
										$sql_product = "SELECT * FROM product_tb";
										}
										$sql_product .= " ORDER BY pid desc";
										
										
										//echo $sql_product;
										$result_product =$obj->_query($sql_product, $connect);
										$num_product =@mysql_num_rows($result_product);
										
										for($i=1;$i<=intval($num_product);$i++){
										$data_product =@mysql_fetch_array($result_product);
										
										$chk_pic1 = "../images/products/".$data_product['p_code']."/".$data_product['p_color']."/s.jpg";
										
										?>
                                         <tr>
                                           <td height="25" align="center" bgcolor="#F5F5F5"><?php echo $f+$i;?></td>
                                           <td align="center" bgcolor="#F5F5F5"><?php echo $data_product['p_category']; ?></td>
                                           <td align="center" bgcolor="#F5F5F5"><img alt="<?php echo $data_product['p_name'];?>" title="<?php echo $data_product['p_name'];?>" src="<?php echo $chk_pic1;?>" height="80" /></td>
                                           <td align="center" bgcolor="#F5F5F5"><a href="stock.php?code=<?php echo $data_product['p_code'];?>&amp;color=<?php echo $data_product['p_color']; ?>" style="text-decoration:underline"> <?php echo $data_product['p_code'];?></a></td>
                                           <td align="center" bgcolor="#F5F5F5">
										   <?php 
                                           $sql_color = "select name from color_tb where c_code = '".$data_product['p_color']."' ";
                                           $result_color = @mysql_query($sql_color, $connect);
                                           $data_color =@mysql_fetch_array($result_color);
                                           
                                           echo $data_color['name'];?>
                                           </td>
                                           <td align="center" bgcolor="#F5F5F5"><?php echo $data_product['p_size']; ?></td>
                                           <td align="center" bgcolor="#F5F5F5"><?php echo $data_product['p_stock']; ?></td>
                                           <td align="center" bgcolor="#F5F5F5">
										   <?php
										   $product_send2 = 0;	 
										   $product_on_hand2 = 0;	
										    
										   $sql_count_sale = "select sum(product_number) as count_sale from temp_order_product where pid = '".$data_product['pid']."'";
										   $sql_count_sale .= " and buy_status = 'INSTOCK'";
										   $result_count_sale = @mysql_query($sql_count_sale, $connect);
										   $data_count_sale = @mysql_fetch_array($result_count_sale);
										   //echo $data_count_sale['count_sale'];
												
											$sql_order_product_hand2 = "SELECT * FROM order_product_tb WHERE pro_id = '".$data_product['pid']."' and order_type = 'IN' ";
											$result_order_product_hand2 =@mysql_query($sql_order_product_hand2, $connect);
											$num_order_product_hand2 =@mysql_num_rows($result_order_product_hand2);
											
											
											for ($o_h2=1; $o_h2<=$num_order_product_hand2; $o_h2++) {
												$data_order_product_hand2 =@mysql_fetch_array($result_order_product_hand2);
												
												if ($data_order_product_hand2['tracking_number'] != "") {
													$product_send2 = $product_send2 + $data_order_product_hand2['order_p_stock'];
												}

											}
											
											$product_on_hand2 = $data_count_sale['count_sale']- $product_send2;
											
											echo $product_on_hand2;
										   
										?></td>
                                           <td align="center" bgcolor="#F5F5F5">
										   <?php
                                            
                                            $sql_buy_preorder1 = "SELECT sum(product_recive) as count_revPreorder FROM temp_order_product";
											$sql_buy_preorder1 .= " where pid ='".$data_product['pid']."'";
                                            $sql_buy_preorder1 .= " AND buy_status = 'PREORDER' AND sent_status = 'READY'";
                                            $result_buy_preorder1 =@mysql_query($sql_buy_preorder1, $connect);
                                            $data_buy_preorder1 =@mysql_fetch_array($result_buy_preorder1);

                                            $sql_buy_spare1 = "SELECT sum(product_recive) as count_revSpare FROM temp_order_product";
											$sql_buy_spare1 .= " where pid ='".$data_product['pid']."'";
                                            $sql_buy_spare1 .= " AND buy_status = 'SPARE' AND sent_status = 'READY'";
                                            $result_buy_spare1 =@mysql_query($sql_buy_spare1, $connect);
                                            $data_buy_spare1 =@mysql_fetch_array($result_buy_spare1);
											
											//echo $data_buy_spare1['count_revSpare'];
											
											$productPre_on_hand2 = 0;
											$productPre_send2 = 0;
											
											$sql_order_preorder2 = "SELECT * FROM order_product_tb WHERE pro_id = '".$data_product['pid']."' and order_type = 'PRE'";
											$result_order_preorder2 =@mysql_query($sql_order_preorder2, $connect);
											$num_order_preorder2 =@mysql_num_rows($result_order_preorder2);
											
											
											for ($pre=1; $pre<=$num_order_preorder2; $pre++) {
												$data_order_preorder2 =@mysql_fetch_array($result_order_preorder2);
												
												if ($data_order_preorder2['tracking_number'] != "") {
													$productPre_send2 = $productPre_send2 + $data_order_preorder2['order_p_stock'];
												}

											}
											
											$productPre_on_hand2 = ($data_buy_preorder1['count_revPreorder']- $productPre_send2)+$data_buy_spare1['count_revSpare'];
											
											
											
											//echo $data_buy_preorder1['count_revPreorder']."<br>";
											//echo $productPre_send2."<br>";
											//echo $productPre_on_hand2."<br>";
											
                                            echo ($productPre_on_hand2 == '' ? "0" : $productPre_on_hand2);
                                            
                                            
                                            ?>
										   </td>
                                           <td align="center" bgcolor="#F5F5F5">
                                           
												<?php
												$sql_product_hand = "SELECT * FROM product_tb WHERE pid = '".$data_product['pid']."' ";
												$result_product_hand =@mysql_query($sql_product_hand, $connect);
												$data_product_hand =@mysql_fetch_array($result_product_hand);
												
												$product_stock = $data_product_hand['p_stock'];
												//echo "p_stock ".$data_product_hand['p_stock']."<br>";
												
												$product_temp_stock = 0;
												
												$sql_temp_order_hand = "SELECT * FROM temp_order_product WHERE pid = '".$data_product['pid']."' and buy_status = 'INSTOCK' ";
												$result_temp_order_hand =@mysql_query($sql_temp_order_hand, $connect);
												$num_temp_order_hand =@mysql_num_rows($result_temp_order_hand);
												
												
												for ($t_h=1; $t_h<=$num_temp_order_hand; $t_h++) {
													$data_temp_order_hand =@mysql_fetch_array($result_temp_order_hand);
													
													$product_temp_stock += $data_temp_order_hand['product_number'];
													
												}
												
												
												$product_temp_stock_pre = 0;
												$sql_temp_order_hand_pre = "SELECT * FROM temp_order_product WHERE pid = '".$data_product['pid']."' and buy_status = 'PREORDER' ";
												$sql_temp_order_hand_pre .= "AND sent_status = 'READY'";
												$result_temp_order_hand_pre =@mysql_query($sql_temp_order_hand_pre, $connect);
												$num_temp_order_hand_pre =@mysql_num_rows($result_temp_order_hand_pre);
												
												for ($t_h2=1; $t_h2<=$num_temp_order_hand_pre; $t_h2++) {
													$data_temp_order_hand_pre =@mysql_fetch_array($result_temp_order_hand_pre);
													
													$product_temp_stock_pre += $data_temp_order_hand_pre['product_number'];
													
												}


												$product_temp_stock_spare = 0;
												$sql_temp_order_hand_spare = "SELECT * FROM temp_order_product WHERE pid = '".$data_product['pid']."' and buy_status = 'SPARE' ";
												$sql_temp_order_hand_spare .= "AND sent_status = 'READY'";
												$result_temp_order_hand_spare =@mysql_query($sql_temp_order_hand_spare, $connect);
												$num_temp_order_hand_spare =@mysql_num_rows($result_temp_order_hand_spare);
												
												for ($t_h3=1; $t_h3<=$num_temp_order_hand_spare; $t_h3++) {
													$data_temp_order_hand_spare =@mysql_fetch_array($result_temp_order_hand_spare);
													
													$product_temp_stock_spare += $data_temp_order_hand_spare['product_number'];
													
												}
												
												//echo "product_temp_stock ".$product_temp_stock."<br>";
												
												$product_send = 0;
												
												$sql_order_product_hand = "SELECT * FROM order_product_tb WHERE "; //order_number = '".$data_update3['order_number']."'
												$sql_order_product_hand .= " pro_id = '".$data_product['pid']."' ";
												$result_order_product_hand =@mysql_query($sql_order_product_hand, $connect);
												$num_order_product_hand =@mysql_num_rows($result_order_product_hand);
												for ($o_h=1; $o_h<=$num_order_product_hand; $o_h++) {
													$data_order_product_hand =@mysql_fetch_array($result_order_product_hand);
													
													if ($data_order_product_hand['tracking_number'] != "") {
														$product_send += $data_order_product_hand['order_p_stock'];
													}

												}
												//echo "sql_order_product_hand ".$sql_order_product_hand."<br>";
												

													$product_on_hand = ($product_stock + $product_temp_stock + $product_temp_stock_pre + $product_temp_stock_spare) - $product_send;

												
												echo $product_on_hand;
                                           ?>
                                           
                                           </td>
                                           <td align="center" bgcolor="#F5F5F5"><?php echo $data_product['p_pre']; ?></td>
                                           <td align="center" bgcolor="#F5F5F5">
										   <?php
										   
											$sql_buy_preorder = "SELECT sum(product_number-product_recive) as count_buyPreorder FROM temp_order_product where pid ='".$data_product['pid']."'";
											$sql_buy_preorder .= " AND buy_status = 'PREORDER' AND sent_status = 'RESERVE'";
											$result_buy_preorder =@mysql_query($sql_buy_preorder, $connect);
											$data_buy_preorder =@mysql_fetch_array($result_buy_preorder);
										    echo ($data_buy_preorder['count_buyPreorder'] == '' ? "0" : $data_buy_preorder['count_buyPreorder']);
										   
										   
										?></td>
                                           <td align="center" bgcolor="#F5F5F5"><?php echo $data_product['p_spare']; ?></td>
                                           <td align="center" bgcolor="#F5F5F5"><?php
                                        $sql_buy_spare = "SELECT sum(product_number-product_recive) as count_buySpare FROM temp_order_product where pid ='".$data_product['pid']."'";
                                        $sql_buy_spare .= " AND buy_status = 'SPARE' AND sent_status = 'RESERVE'";
                                        $result_buy_spare =@mysql_query($sql_buy_spare, $connect);
                                        $data_buy_spare =@mysql_fetch_array($result_buy_spare);
										
										echo ($data_buy_spare['count_buySpare'] == '' ? "0" : $data_buy_spare['count_buySpare']);
										
                                        ?></td>
                                           <td align="center" bgcolor="#F5F5F5"><?php
										$realTotal = 0;
										


											$sql_manu = "SELECT num_product  FROM manufacture_tb where pid ='".$data_product['pid']."' and order_status = '0'";
											$result_manu =@mysql_query($sql_manu, $connect);
											$num_manu =@mysql_num_rows($result_manu);
											
											for($i3=1;$i3<=intval($num_manu);$i3++){
											$data_manu =@mysql_fetch_array($result_manu);
											
											$realTotal = $realTotal + $data_manu['num_product'];
											
											}

										
										echo $realTotal;
										$realTotal = 0;
										?></td>
                                           <td align="center" bgcolor="#F5F5F5">
											 <?php 
                                                       $product_send2 = 0;	 
                                                       $product_on_hand2 = 0;	
                                                        
                                                       $sql_count_sale = "select sum(product_number) as count_sale from temp_order_product where pid = '".$data_product['pid']."'";
                                                       $sql_count_sale .= " and buy_status = 'INSTOCK'";
                                                       $result_count_sale = @mysql_query($sql_count_sale, $connect);
                                                       $data_count_sale = @mysql_fetch_array($result_count_sale);
                                                       //echo $data_count_sale['count_sale'];
                                                            
                                                        $sql_order_product_hand2 = "SELECT * FROM order_product_tb WHERE pro_id = '".$data_product['pid']."' and order_type = 'IN' ";
                                                        $result_order_product_hand2 =@mysql_query($sql_order_product_hand2, $connect);
                                                        $num_order_product_hand2 =@mysql_num_rows($result_order_product_hand2);
                                                        
                                                        
                                                        for ($o_h2=1; $o_h2<=$num_order_product_hand2; $o_h2++) {
                                                            $data_order_product_hand2 =@mysql_fetch_array($result_order_product_hand2);
                                                            
                                                            if ($data_order_product_hand2['tracking_number'] != "") {
                                                                $product_send2 = $product_send2 + $data_order_product_hand2['order_p_stock'];
                                                            }
                                            
                                                        }
                                                        
                                                        $product_instock = $data_count_sale['count_sale']- $product_send2;
                                                        
                                                        $product_instock;
                                            
                                                        $sql_buy_preorder = "SELECT sum(product_number-product_recive) as count_buyPreorder FROM temp_order_product where pid ='".$data_product['pid']."'";
                                                        $sql_buy_preorder .= " AND buy_status = 'PREORDER' AND sent_status = 'RESERVE'";
                                                        $result_buy_preorder =@mysql_query($sql_buy_preorder, $connect);
                                                        $data_buy_preorder =@mysql_fetch_array($result_buy_preorder);
                                                        $product_on_pre = ($data_buy_preorder['count_buyPreorder'] == '' ? "0" : $data_buy_preorder['count_buyPreorder']);
                                                   
                                                        $total_all = $product_instock + $product_on_pre;
                                                        
                                                        echo $total_all;
                                                   
                                                   ?>                                          
                                           </td>
                                           <td align="center" bgcolor="#F5F5F5">
											<?php echo $total_all + $data_product['p_stock']; ?>                                           
                                           </td>
                                           <td align="center" bgcolor="#F5F5F5"><?php echo $data_product['date_in'];?></td>
                                           <td bgcolor="#F5F5F5">
                                           <div class="form2">
                                             <ul>
                                               <li><a href="new_review.php?pid=<?php echo $data_product['pid'];?>"><img alt="Edit" src="images/review.png" title="Review"/></a></li>
                                               <li><a href="edit_product.php?pid=<?php echo $data_product['pid'];?>" target="_blank"><img alt="Edit" src="images/1343377813_Modify.png" title="Edit"/></a></li>
                                               <li>Rank 
                                                 <input name="new_ranking[<?php echo $data_product['pid'];?>] " type="text" id="new_ranking " size="3" maxlength="3" value="<?php echo $data_product['ranking'];?>" />
                                                 <input name="hidden_new_id[<?php echo $data_product['pid'];?>] " type="hidden"  value="<?php echo $data_product['pid'];?>" />
                                               </li>
                                             </ul>
                                           </div></td>
                                           
                                           <td align="center" bgcolor="#F5F5F5">
                                           ลบ <input type="checkbox" class="checkbox1" name="id_del[<?php echo $data_product['pid'];?>]" value="1" />
                                           </td>
                                         </tr>
                                         <? } ?>
                                       </table></td>
                                     </tr>
                                   </table>
                                   </div>

                                   <!--End ตาราง 3 Cell-->

                                	<!-- -->
                                  	<div class="page_number">
                                    	<div class="page_number-right">
                                        <br />
                                            	<?php $obj->_displayPage(); ?>
                                    	</div>
                                    </div>   
                                    <!-- -->


                                            
                                          </div>
                                            <div class="bottom">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                            </div>
                                        </div>
										<!--End Coppy Module Clear--> </form>                                 



              </div>
                    <div class="block_style2_bottom">
                        <div class="block_style2_bottom-l"></div>
                        <div class="block_style2_bottom-r"></div>
                    </div>                    
          </div>
                <!-- End Block Frame-->

      <!--</div>-->
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
