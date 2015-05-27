<?php
session_start();
include'../inc/db_config.php';
	$uid = $_POST['uid'];
	$urank = $_SESSION['rank'];
	if ($urank == 1)
	{
		$updatequery = "UPDATE notification SET readnotification = '1' WHERE receiver_id = 0"; 
		$updateresult = mysql_query($updatequery) or die(mysql_error());
		$updatequery2 = "UPDATE notification SET readnotification = '1' WHERE receiver_id = $uid"; 
		$updateresult2 = mysql_query($updatequery2) or die(mysql_error());
	}
	else
	{
		$updatequery = "UPDATE notification SET readnotification = '1' WHERE receiver_id = $uid"; 
		$updateresult = mysql_query($updatequery) or die(mysql_error());
	}
  	


  ?>