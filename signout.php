<?php

// check if logout=1 i.e logout was pressed
if(isset($_GET["logout"])){ 
	ob_start();
	session_start();
	session_unset();
	session_regenerate_id(true);
	session_unset();
	session_destroy();
	session_write_close();
	setcookie(session_name(),'',0,'/');
	header("Location:SCROLL.php");
	exit;
}

?>