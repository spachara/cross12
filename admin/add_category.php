<?php
session_start();
require_once '../dbconnect.inc';

if(isset($_SESSION['AUTH_PERMISSION_ID'])==false) { 
	echo "<script>window.location.href='index.php'</script>";
}



if($_POST['Submit'] == 'CREATE'){

	$add_banner = "INSERT INTO category_tb (cid, name, c_discount, ranking, date_in)";
	$add_banner .= "VALUES(NULL, '".$_POST['name']."', '".$_POST['c_discount']."', '0', NOW())";
	@mysql_query($add_banner, $connect);
			

?><script>window.location.href='category.php';</script>
<?php } 


if($_POST['Submit'] == 'Edit'){

	$add_banner = "UPDATE category_tb SET name = '".$_POST['name']."', c_discount = '".$_POST['c_discount']."' where cid = '".$_POST['cid']."'";
	@mysql_query($add_banner, $connect);
			

?><script>window.location.href='category.php';</script>
<?php } 


$sql_category = "select * from category_tb where cid = '".$_GET['cid']."'";
$result_category = @mysql_query($sql_category, $connect);
$data_category = @mysql_fetch_array($result_category);

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
<script language="javascript">
$(document).ready(function() {
	
	$('#uploadedfile1').after('<span class="pixels"></span>');
	
    var banner_id = $('#banner_id').val();
    var type_id = $('#type_id').val();
    var banner_type = $('#banner_type').val();
	

	pixels = "( 250 x 141 pixels )";

	//alert(banner_id);
	$('.pixels').text(pixels);
});
</script>
<link href="cssstyle.css" rel="stylesheet" type="text/css" />
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
                <a href="category.php">Category</a> > <a href="#">Add <?php echo $banner_name;?></a>
           </div>
           <!--End Navigator-->            

            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">
                        Add Category
                        </div>
                    </div>
                    <div class="block_style2_content">

                     <!--Coppy Module Clear-->
                                   
                <form method="post" enctype="multipart/form-data" name="myform">
                <input type="hidden" name="cid" value="<?php echo $_GET['cid'];?>" />
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
                              		<div class="cell3-text">Name : </div>
                                    <div class="cell3-input"><input name="name" type="text" id="name" value="<?php echo $data_category['name'];?>" /></div>
                                </li>
                                 <li>
                              		<div class="cell3-text">ส่วนลด : </div>
                                   <div class="cell3-input"><input name="c_discount" type="text" id="c_discount" value="<?php echo $data_category['c_discount'];?>" /> 
                                    &nbsp;%</div>
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
