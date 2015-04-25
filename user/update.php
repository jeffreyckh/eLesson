<?php
session_start();
include'../inc/db_config.php';
	$uid = $_POST['uid'];
	$qid = $_POST['qid'];
	$option = $_POST['option'];
	$quesid = $_POST['quesid'];
  	$updatequery = "UPDATE user_to_question SET answer = '$option',completed = '1' WHERE quizid = $qid and userid = $uid and questionid = $quesid"; 
	$updateresult = mysql_query($updatequery);


  ?>