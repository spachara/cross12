<?php
     require_once '../dbconnect.inc';
	 $pwd_sql = "SELECT *  FROM admin_login WHERE admin_value = '".$_GET['a_pass']."' AND admin_name = '".$_GET['a_user']."' ";
     $pwd_result = mysql_query($pwd_sql, $connect);
	 $pwd_num = mysql_num_rows($pwd_result);

	if($pwd_num) {
	        $pwd_data = mysql_fetch_array($pwd_result);
			session_start();
			session_register("AUTH_PERMISSION_ID"); 
			session_register("AUTH_PERMISSION_TYPE"); 
			session_register("AUTH_PERMISSION_NAME"); 
            $_SESSION['AUTH_PERMISSION_ID'] = $pwd_data['admin_id'];
            $_SESSION['AUTH_PERMISSION_TYPE'] = $pwd_data['admin_type'];
            $_SESSION['AUTH_PERMISSION_NAME'] = $pwd_data['admin_sys_name'];
            mysql_close($connect);
			echo "<script>window.location.href='home.php'</script>";
		}
		else {
			mysql_close($connect);
			echo "<script>window.location.href='index.php?login=failed'</script>";
	    }
		

?>
