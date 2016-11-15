<?php
session_start();
require_once '../dbconnect.inc';

if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) { 
	echo "<script>window.location.href='index.php'</script>";
}



if($_POST['Submit'] == 'CREATE'){
	$validate =  @mysql_query("select c_code from color_tb where c_code = '" . trim($_POST['c_code']) . "'", $connect);
	$num_validate =  @mysql_num_rows($validate);
	if($num_validate>0)
	{
		echo '<script language="javascript">';
		echo 'alert("Error : Code ' . $_POST['c_code']  . ' มีอยู่แล้วในระบบแล้ว!!")';
		echo '</script>';
	}
	else
	{
		$add_banner = "INSERT INTO color_tb (oid, c_code, name, color_code, ranking, date_in)";
		$add_banner .= "VALUES(NULL, '".$_POST['c_code']."', '".$_POST['name']."', '".$_POST['colorpickerField1']."', '0', NOW())";
		@mysql_query($add_banner, $connect);
	}
			
if($num_validate<=0)
	{
?><script>window.location.href='new_color.php';</script>
<?php 
	}
	} 


if($_POST['Submit'] == 'Edit'){
	$validate =  @mysql_query("select c_code from color_tb where c_code = '" . trim($_POST['c_code']) . "' and oid <> '".$_POST['oid']."'", $connect);
	$num_validate =  @mysql_num_rows($validate);
	if($num_validate>0)
	{
		echo '<script language="javascript">';
		echo 'alert("Error : Code ' . $_POST['c_code']  . ' มีอยู่แล้วในระบบแล้ว!!")';
		echo '</script>';
	}
	else
	{
	$add_banner = "UPDATE color_tb SET name = '".$_POST['name']."', c_code = '".$_POST['c_code']."' , color_code = '".$_POST['colorpickerField1']."' where oid = '".$_POST['oid']."'";
	@mysql_query($add_banner, $connect);
	}
			
if($num_validate<=0)
	{
?><script>window.location.href='new_color.php';</script>
<?php 
}	
} 


$sql_category = "select * from color_tb where oid = '".$_GET['oid']."'";
$result_category = @mysql_query($sql_category, $connect);
$data_category = @mysql_fetch_array($result_category);

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-Type" content="text/html; charset=utf-8" />
<title>::Crosstwelfth::</title>
<link href="cssstyle.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="color/css/colorpicker.css" type="text/css" />
	<script type="text/javascript" src="color/js/jquery.js"></script>
	<script type="text/javascript" src="color/js/colorpicker.js"></script>
    <script type="text/javascript" src="color/js/eye.js"></script>
    <script type="text/javascript" src="color/js/utils.js"></script>
    <script type="text/javascript" src="color/js/layout.js?ver=1.0.2"></script>
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
                <a href="new_color.php">Color</a> > <a href="#">Add <?php echo $banner_name;?></a>
           </div>
           <!--End Navigator-->            

            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">
                        Add Color
                        </div>
                    </div>
                    <div class="block_style2_content">

                     <!--Coppy Module Clear-->
                                   
                <form method="post" enctype="multipart/form-data" name="myform">
                <input type="hidden" name="oid" value="<?php echo $_GET['oid'];?>" />
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
                      <div class="title-top">&nbsp;
                          <div class="right-title">&nbsp;</div>
                      </div>
                                   
                      <div class="table_3cell">
                          <ul>
                                 <li>
                              		<div class="cell3-text">Code : </div>
                                    <div class="cell3-input"><input name="c_code" type="text" id="code" value="<?php echo $data_category['c_code'];?>" /></div>
                                </li>
                                 <li>
                              		<div class="cell3-text">Name : </div>
                                    <div class="cell3-input"><input name="name" type="text" id="name" value="<?php echo $data_category['name'];?>" /></div>
                                </li>
                                 <li>
                              		<div class="cell3-text">Color : </div>
                                    <div class="cell3-input" style="height:50px">
                                    <input type="text" name="colorpickerField1" maxlength="6" size="6" id="colorpickerField1" value="<?php echo ($data_category['color_code'] == '' ? "ffffff" :  $data_category['color_code']);?>" />
                                    <div style=" position:relative; width:50px; height:15px; background-color:#<?php echo $data_category['color_code'];?>; border:1px solid #000;"></div>
                                    </div>
                                </li>
                          <!--End Title-->
                                           
                           </ul>
                       </div>
                       <!--End ตาราง 3 Cell-->
                       </div>
                                           
                       </div>
					   <!--End Coppy Module Clear-->                                 
                                        
				</div>    
                                   
                <div class="demo">
                                                    
                <!--<button>Submit</button>-->                                   
				<?php if($_GET['sAction'] == 'Edit'){?>
                <input name="Submit" type="submit" class="borderfrom" style="width:80px" value="Edit">
				<?php }else{?>
                <input name="Submit" type="submit" class="borderfrom" style="width:80px" value="CREATE">
				<?php } ?>
                                                    
                </div>                                   
                	
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
            


		<?php include('footer.php');?>



        </div>
    </div>
</div>    
</body>
</html>
