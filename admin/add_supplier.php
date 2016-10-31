<?php
session_start();
require_once '../dbconnect.inc';

if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) { 
	echo "<script>window.location.href='index.php'</script>";
}


if($_POST['Submit'] == 'CREATE'){

	$add_banner = "INSERT INTO supplier_tb (sid, s_code, s_name, s_address, s_tel, ranking, date_in)";
	$add_banner .= "VALUES(NULL, '".$_POST['s_code']."', '".$_POST['s_name']."', '".$_POST['s_address']."', '".$_POST['s_tel']."', '0', NOW())";
	@mysql_query($add_banner, $connect);

?><script>window.location.href='new_supplier.php';</script>
<?php } 


if($_POST['Submit'] == 'Edit'){

	$add_banner = "UPDATE supplier_tb SET s_name = '".$_POST['s_name']."', s_code = '".$_POST['s_code']."' , s_address = '".$_POST['s_address']."' , s_tel = '".$_POST['s_tel']."' where sid = '".$_POST['sid']."'";
	@mysql_query($add_banner, $connect);
			

?><script>window.location.href='new_supplier.php';</script>
<?php } 


$sql_category = "select * from supplier_tb where sid = '".$_GET['sid']."'";
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
                <a href="new_supplier.php">Supplier</a> > <a href="#">Add <?php echo $banner_s_name;?></a>
           </div>
           <!--End Navigator-->            

            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">
                        Add Supplier
                        </div>
                    </div>
                    <div class="block_style2_content">

                     <!--Coppy Module Clear-->
                                   
                <form method="post" enctype="multipart/form-data" name="myform">
                <input type="hidden" name="sid" value="<?php echo $_GET['sid'];?>" />
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
                                    <div class="cell3-input"><input name="s_code" type="text" id="code" value="<?php echo $data_category['s_code'];?>" /></div>
                                </li>
                                 <li>
                              		<div class="cell3-text">Name : </div>
                                    <div class="cell3-input"><input name="s_name" type="text" id="s_name" value="<?php echo $data_category['s_name'];?>" /></div>
                                </li>
                                 <li>
                              		<div class="cell3-text">Tel : </div>
                                    <div class="cell3-input"><input name="s_tel" type="text" id="s_tel" value="<?php echo $data_category['s_tel'];?>" /></div>
                                </li>
                            <li>
                              		<div class="cell3-text">Address : </div>
                                    <div class="cell3-input" style="height:100px">
                                    <textarea name="s_address" rows="5"><?php echo $data_category['s_address'];?></textarea>
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
