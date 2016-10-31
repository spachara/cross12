<?php
session_start();
require_once '../dbconnect.inc';

include("class.page_split.php");
$obj = new page_split();
$obj->_setPageSize(100);						
$obj->_setFile("new_color.php");		
$obj->_setPage($_GET['page']);		
if($_GET['page'] > 1){
	$f = 100*($_GET['page']- 1);
}

if($_SESSION['AUTH_PERMISSION_ID']=='') {
	header("Location:index.php");
}


if($_GET['sAction'] == 'del'){
	$delete_howto = "DELETE FROM color_tb  WHERE oid = '".$_GET['id_del']."' ";
	@mysql_query($delete_howto, $connect);
?>		 
		<script>
			location.href='new_color.php'; //รีเฟสหน้า
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
                                     <a href="new_color.php">Color</a>
                                        
                                   </div>
                                   <!--End Navigator-->            
            
            	<!--Block Frame-->
            	<div class="block_style2">
                	<div class="block_style2_top">
                    	<div class="block_style2_top-l"></div>
                        <div class="block_style2_top-r"></div>
                        <div class="block_style2_top-t">Color</div>
                    </div>
                    <div class="block_style2_content">



                                   		<!--Coppy Module Clear-->
                                        <form action="new_color.php" method="post" enctype="multipart/form-data" name="form1">
                                        <div class="module_3">
                                            <div class="title">
                                                <div class="l"></div>
                                                <div class="r"></div>
                                                <div class="t"><h2>
                                                </h2> </div>
                                                <div class="bt">
                                                	 
                                                </div>
                                            </div>
                                            <div class="conten">
                                                <!--ใสข้อมูล ตรงนี้-->
                                                <!--ตาราง 3 Cell-->
                                   <div class="title-top">
                                   <div class="right-title">
                                   <div class="form3">
                                   		
                                        <ul>
                                        <li><a href="add_color.php"><img alt="Add" src="images/1343378527_add1-.png" title="Add"/> <span style="position:relative; top:-3px;">Color </span></a></li>                                            
                                        </ul>
                                        
                                   </div>
                                   </div>
                                   
                                   </div>
                                        
                                        
                                        
                                    <table width="400" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                    <td width="10%">ชื่อสี</td>
                                    <td width="30%"><input type="text" name="nameSearch" value="<?php echo $_POST['nameSearch'];?>" /></td>
                                    <td width="20%"><input type="submit" name="Search" id="Search" value="Search" /></td>
                                    </tr>
                                    </table><br />
    
                                        
                                        
                                   	<div class="table_3cell">
                                     	<ul>
                                        	<!--Title-->
                                        	<li class="bg-title">
                                           	  <div class="cell1" style="width:10%;">ลำดับ</div>
                                              <div class="cell2" style="width:20%; height:25px;">Code</div>
                                              <div class="cell3" style="width:20%; height:25px;">Name</div>
                                              <div class="cell3" style="width:20%; height:25px;">Color</div>
                                              <div class="cell3" style="width:20%;">&nbsp;</div>
                                            </li>
                                            <!--End Title-->
                                            <?php
											if($_POST['nameSearch'] != '' ){
											$sql_category = "SELECT * FROM color_tb WHERE name like '%".$_POST['nameSearch']."%' ORDER BY c_code asc";
											}else{
											$sql_category = "SELECT * FROM color_tb ORDER BY c_code asc";
											}
											$result_category =$obj->_query($sql_category, $connect);
											$num_category =@mysql_num_rows($result_category);
											
											for($i=1;$i<=intval($num_category);$i++){
											$data_category =@mysql_fetch_array($result_category);
											?>
                                            <li>
                                                <div class="cell1"style="width:10%;">
                                                    <?php echo $f+$i;?>
                                                </div>
                                                <div class="cell2" style="width:20%;">
                                                <?php echo $data_category['c_code']; ?>
                                                </div>	
                                                <div class="cell3" style="width:20%;">
                                                <?php echo $data_category['name']; ?>
                                                </div>	
                                                <div class="cell3" style="width:20%;">
                                                <div style=" margin-left:65px;width:50px; height:15px; background-color:#<?php echo $data_category['color_code'];?>; border:1px solid #000;"></div>
                                                </div>	
                                                
                                                <div class="cell3" style="width:20%;">
                                                    <!--Form2-->
                                                   <div class="form2">
                                                        <ul>
                                                            <li><a href="add_color.php?oid=<?php echo $data_category['oid'];?>&amp;sAction=Edit"><img alt="Edit" src="images/1343377813_Modify.png" title="Edit"/></a></li>
                                                            <li><a href="new_color.php?id_del=<?php echo $data_category['oid'];?>&amp;sAction=del" onClick="return confirm('Do you want to delete it. (yes/no)')"><img alt="Delete" src="images/1343378039_23-Full Trash.png" title="Delete"/></a></li>
                                                            <!--<li>Ranking</li>
                                                            <li><input name="new_ranking[<?php echo $data_category['oid'];?>] " type="text" id="new_ranking " size="3" maxlength="3" value="<?php echo $data_category['ranking'];?>">
                                                            <input name="hidden_new_id[<?php echo $data_category['oid'];?>] " type="hidden"  value="<?php echo $data_category['oid'];?>"></li>-->
                                                        </ul>
                                                   </div>                                   
                                                   <!--End Form2-->

                                          </div>
                                            </li>
                                            <? } ?>
                                        </ul>
                                    </div>
                                   <!--End ตาราง 3 Cell-->

                                	<!-- -->
                                  	<div class="page_number">
                                    	<div class="page_number-right">
                                        
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
