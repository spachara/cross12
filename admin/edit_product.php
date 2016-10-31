<?php
	session_start();
	require_once '../dbconnect.inc';
	include("fckeditor/fckeditor.php") ;
	require_once 'process_pic.php';
	
	if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) {
		echo "<script>location.href='index.php'</script>";
	}
	
	if($_POST['Submit'] == 'UPDATE'){
	
			$edit_product = "UPDATE product_tb SET name = '".$_POST['name']."', name_eng = '".$_POST['name_eng']."' ";
			$edit_product .= " , p_category = '".$_POST['p_category']."', p_code = '".$_POST['p_code']."' ";
			$edit_product .= " , p_color = '".$_POST['p_color']."', p_size = '".$_POST['p_size']."' ";
			$edit_product .= " , p_details = '".$_POST['p_details']."', p_details_eng = '".$_POST['p_details_eng']."' ";
			$edit_product .= " , p_overview = '".$_POST['p_overview']."', p_overview_eng = '".$_POST['p_overview_eng']."' ";
			$edit_product .= " , p_info = '".$_POST['p_info']."', p_info_eng = '".$_POST['p_info_eng']."' ";
			$edit_product .= (isset($_POST['p_stock']) ? " , p_stock = '".$_POST['p_stock']."'" : "") . " , p_pre = '".$_POST['p_pre']."' "; 
			$edit_product .= " , p_wornout = '".$_POST['p_wornout']."' ";
			$edit_product .= (isset($_POST['p_price']) ? " , p_price = '".$_POST['p_price']."'" : "") . (isset($_POST['p_special']) ? " , p_special = '".$_POST['p_special']."' " : "");
			$edit_product .= " , p_clearance = '".$_POST['p_clearance']."', p_supplier = '".$_POST['p_supplier']."' ";
			$edit_product .= " , shoulder = '".$_POST['shoulder']."', breast = '".$_POST['breast']."' ";
			$edit_product .= " , waist = '".$_POST['waist']."', hip = '".$_POST['hip']."' ";
			$edit_product .= " , arm = '".$_POST['arm']."', alllength = '".$_POST['alllength']."' ";
			$edit_product .= " , waist_end = '".$_POST['waist_end']."', waist_crotch = '".$_POST['waist_crotch']."' ";
			$edit_product .= " , shoulder_waist = '".$_POST['shoulder_waist']."', shoulder_crotch = '".$_POST['shoulder_crotch']."' ";
			$edit_product .= " , thigh = '".$_POST['thigh']."' , armlength = '".$_POST['armlength']."'";
			$edit_product .= " , set_waist = '".$_POST['set_waist']."', set_hip = '".$_POST['set_hip']."', set_length = '".$_POST['set_length']."'";
			$edit_product .= " , set_waist_skirts = '".$_POST['set_waist_skirts']."', set_hip_skirts = '".$_POST['set_hip_skirts']."'";
			$edit_product .= " , set_length_skirts = '".$_POST['set_length_skirts']."' WHERE pid = '".$_POST['pid']."' ";
			@mysql_query($edit_product, $connect);
			//echo $edit_product."<br>";
			
			if($_POST['p_minimum'] != '' ){
				
			$edit_product2 = "UPDATE product_tb SET p_minimum = '".$_POST['p_minimum']."'";
			$edit_product2 .= "where p_code = '".$_POST['p_code']."' and   p_color = '".$_POST['p_color']."'";
			@mysql_query($edit_product2, $connect);
			//echo $edit_product2."<br>";
			}
                        
                        if (isset($_POST['chk_special']) && isset($_POST['p_special']) ) {
                            $edit_product3 = "UPDATE product_tb SET p_special = '".$_POST['p_special']."'";
                            $edit_product3 .= "where p_code = '".$_POST['p_code']."'";
                            @mysql_query($edit_product3, $connect);
                        }
																											
				
	?>
				  <script>
					location.href='edit_product.php?pid=<?php echo $_POST['pid'];?>';
				  </script>
	<?php
	
	}// END CREATE
	
	$sql_product = "SELECT * FROM product_tb WHERE pid = '".$_GET['pid']."' ";
	$result_product =@mysql_query($sql_product, $connect);
	$data_product =@mysql_fetch_array($result_product);
	
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
                                        <a href="product.php">Products</a>
                                        >
                                        <a href="#">แก้ไขสินค้า</a>
                                   </div>
                                   <!--End Navigator-->            
                                    <form method="post" enctype="multipart/form-data" name="myform">
                                    <input type="hidden" name="pid" value="<?php echo $_GET['pid'];?>" />
                                    <!--Block Frame-->
                                    <div class="block_style2">
                                        <div class="block_style2_top">
                                            <div class="block_style2_top-l"></div>
                                            <div class="block_style2_top-r"></div>
                                            <div class="block_style2_top-t">แก้ไขกระทู้</div>
                                        </div>
                                        <div class="block_style2_content">
                                   	<div class="table_3cell">
                                     	<ul>
                                        	<!--Title-->
                                            <li>
                                            	<div class="cell3-text">CATEGORY :</div>
                                                <div class="cell3-input">
                                                <input name="p_category" type="text" id="p_category" value="<?php echo $data_product['p_category'];?>"/>
                                                </div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">รหัสสินค้า :</div>
                                                <div class="cell3-input">
                                                <input name="p_code" type="text" id="p_code" value="<?php echo $data_product['p_code'];?>"/>
                                                </div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">สี :</div>
                                                <div class="cell3-input">
                                                <input name="p_color" type="text" id="p_color" value="<?php echo $data_product['p_color'];?>"/>
                                                </div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">Size :</div>
                                                <div class="cell3-input">
                                                <input name="p_size" type="text" id="p_size" value="<?php echo $data_product['p_size'];?>"/>
                                                </div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">ชื่อสินค้า TH :</div>
                                                <div class="cell3-input"><input name="name" type="text" id="name" value="<?php echo str_replace('+','',str_replace('+ ','',$data_product['name']));?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">ชื่อสินค้า Eng :</div>
                                                <div class="cell3-input"><input name="name_eng" type="text" id="name_eng" value="<?php echo $data_product['name_eng'];?>"/></div>
                                            </li>
                                         	<li>
                                            	<div class="cell3-text">Detail TH :</div>
                                                <div class="cell3-input_textarea">
                                                  <textarea name="p_details" cols="30" rows="5" id="p_details"><?php echo $data_product['p_details'];?></textarea>
                                                  <span id="head_news"></span>
                                                </div>
                                            </li>
                                         	<li>
                                            	<div class="cell3-text">Detail Eng :</div>
                                                <div class="cell3-input_textarea">
                                                  <textarea name="p_details_eng" cols="30" rows="5" id="p_details_eng"><?php echo $data_product['p_details_eng'];?></textarea>
                                                  <span id="head_news"></span>
                                                </div>
                                            </li>
                                         	<li>
                                            	<div class="cell3-text">Overview TH :</div>
                                                <div class="cell3-input_textarea">
                                                  <textarea name="p_overview" cols="30" rows="5" id="p_overview"><?php echo $data_product['p_overview'];?></textarea>
                                                  <span id="head_news"></span>
                                                </div>
                                            </li>
                                         	<li>
                                            	<div class="cell3-text">Overview Eng :</div>
                                                <div class="cell3-input_textarea">
                                                  <textarea name="p_overview_eng" cols="30" rows="5" id="p_overview_eng"><?php echo $data_product['p_overview_eng'];?></textarea>
                                                  <span id="head_news"></span>
                                                </div>
                                            </li>
                                         	<li>
                                            	<div class="cell3-text">INFO TH :</div>
                                                <div class="cell3-input_textarea">
                                                  <textarea name="p_info" cols="30" rows="5" id="p_info"><?php echo $data_product['p_info'];?></textarea>
                                                  <span id="head_news"></span>
                                                </div>
                                            </li>
                                         	<li>
                                            	<div class="cell3-text">INFO Eng :</div>
                                                <div class="cell3-input_textarea">
                                                  <textarea name="p_info_eng" cols="30" rows="5" id="p_info_eng"><?php echo $data_product['p_info_eng'];?></textarea>
                                                  <span id="head_news"></span>
                                                </div>
                                            </li>
                                            <?php if ($_SESSION['AUTH_PERMISSION_TYPE'] == 1) {?>
                                            <li>
                                            	<div class="cell3-text">Stock พร้อมส่ง :</div>
                                                <div class="cell3-input"><input name="p_stock" type="text" id="p_stock" value="<?php echo $data_product['p_stock'];?>"/></div>
                                            </li>
                                            <?php }?>
                                            <li>
                                            	<div class="cell3-text">Stock Pre-Order :</div>
                                                <div class="cell3-input"><input name="p_pre" type="text" id="p_pre" value="<?php echo $data_product['p_pre'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">Stock Spare :</div>
                                                <div class="cell3-input"><?php echo $data_product['p_spare'];?></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">Stock ชำรุด :</div>
                                                <div class="cell3-input"><?php echo $data_product['p_wornout'];?></div>
                                            </li>
                                            <?php if ($_SESSION['AUTH_PERMISSION_TYPE'] == 1) {?>
                                            <li>
                                            	<div class="cell3-text">ราคาขาย :</div>
                                                <div class="cell3-input"><input name="p_price" type="text" id="p_price" value="<?php echo $data_product['p_price'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">Special Price :</div>
                                                <div class="cell3-input"><input name="p_special" type="text" id="p_special" value="<?php echo $data_product['p_special'];?>"/>
                                                &nbsp; <input type="checkbox" name="chk_special" value="1" id="chk_special"/>Apply all <?php echo $data_product['p_code'];?> products.
                                                </div>
                                            </li>
                                            <?php }?>
                                            <li>
                                            	<div class="cell3-text">Clearance Price :</div>
                                                <div class="cell3-input"><input name="p_clearance" type="text" id="p_clearance" value="<?php echo $data_product['p_clearance'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">Supplier :</div>
                                                <div class="cell3-input"><input name="p_supplier" type="text" id="p_supplier" value="<?php echo $data_product['p_supplier'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">Minimum Order :</div>
                                                <div class="cell3-input"><input name="p_minimum" type="text" id="p_minimum" value="<?php echo $data_product['p_minimum'];?>"/></div>
                                            </li>
                                             <li>
                                            	<div class="cell3-text">ไหล่ :</div>
                                                <div class="cell3-input"><input name="shoulder" type="text" id="shoulder" value="<?php echo $data_product['shoulder'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">อก :</div>
                                                <div class="cell3-input"><input name="breast" type="text" id="breast" value="<?php echo $data_product['breast'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">เอว :</div>
                                                <div class="cell3-input"><input name="waist" type="text" id="waist" value="<?php echo $data_product['waist'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">สะโพก :</div>
                                                <div class="cell3-input"><input name="hip" type="text" id="hip" value="<?php echo $data_product['hip'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">รอบแขน :</div>
                                                <div class="cell3-input"><input name="arm" type="text" id="arm" value="<?php echo $data_product['arm'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">ความยาว (ทั้งชุด) :</div>
                                                <div class="cell3-input"><input name="alllength" type="text" id="alllength" value="<?php echo $data_product['alllength'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">เอว-ปลาย :</div>
                                                <div class="cell3-input"><input name="waist_end" type="text" id="waist_end" value="<?php echo $data_product['waist_end'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">เอว-เป้า :</div>
                                                <div class="cell3-input"><input name="waist_crotch" type="text" id="waist_crotch" value="<?php echo $data_product['waist_crotch'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">ไหล่-เอว :</div>
                                                <div class="cell3-input"><input name="shoulder_waist" type="text" id="shoulder_waist" value="<?php echo $data_product['shoulder_waist'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">ไหล่-เป้า :</div>
                                                <div class="cell3-input"><input name="shoulder_crotch" type="text" id="shoulder_crotch" value="<?php echo $data_product['shoulder_crotch'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">ต้นขา :</div>
                                                <div class="cell3-input"><input name="thigh" type="text" id="thigh" value="<?php echo $data_product['thigh'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">ความยาวแขน	:</div>
                                                <div class="cell3-input"><input name="armlength" type="text" id="armlength" value="<?php echo $data_product['armlength'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">set: เอว (กก) :</div>
                                                <div class="cell3-input"><input name="set_waist" type="text" id="set_waist" value="<?php echo $data_product['set_waist'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">set: สะโพก (กก) :</div>
                                                <div class="cell3-input"><input name="set_hip" type="text" id="set_hip" value="<?php echo $data_product['set_hip'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">set: ยาว (กก) :</div>
                                                <div class="cell3-input"><input name="set_length" type="text" id="set_length" value="<?php echo $data_product['set_length'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">set: เอว (กป) :</div>
                                                <div class="cell3-input"><input name="set_waist_skirts" type="text" id="set_waist_skirts" value="<?php echo $data_product['set_waist_skirts'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">set: สะโพก (กป) :</div>
                                                <div class="cell3-input"><input name="set_hip_skirts" type="text" id="set_hip_skirts" value="<?php echo $data_product['set_hip_skirts'];?>"/></div>
                                            </li>
                                            <li>
                                            	<div class="cell3-text">set: ยาว (กป) :</div>
                                                <div class="cell3-input"><input name="set_length_skirts" type="text" id="set_length_skirts" value="<?php echo $data_product['set_length_skirts'];?>"/></div>
                                            </li>
                                       	
                                            <!--End Title-->
                                       
                                        </ul>
                                    </div>
                                   <!--End ตาราง 3 Cell-->
                                   
                                    <div class="demo">
                                    
                                    <!--<button>Submit</button>-->
                                   	
									<input name="Submit" type="submit" class="borderfrom" style="width:80px" value="UPDATE">
                                    
                                    </div>
                                    
                                                                       
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
