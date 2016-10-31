<?php
session_start();
require_once '../dbconnect.inc';

$edit_product_h = "UPDATE product_highlight_tb SET highlight_status = 0 ";
@mysql_query($edit_product_h, $connect);

//echo "ID : ".$_POST['id'];
$pro_id = explode(',', $_POST['id']);
//echo count($pro_id);

for ($p=1; $p<=count($pro_id) - 1; $p++) {
	
	$edit_product_h = "UPDATE product_highlight_tb SET highlight_status = 1 WHERE product_id = '".$pro_id[$p]."' ";
	@mysql_query($edit_product_h, $connect);
	
}

?>