<?php
	
	include('../config/CONSTANTS.php');

	// Unset all of the session variables
	$_SESSION = array();

	//destroy all sessions
	session_destroy ( ) ;
	
	//redirect to login form
	header('Location:' . SITEURL . 'admin/login.php');

?>