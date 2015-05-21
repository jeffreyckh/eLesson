<?php
include "../inc/db_config.php";

if(isset($_POST['c_name'])){
	$c_name = $_POST['c_name'];
}

// If checking addition of new lessons
// Check if the name is already taken
$name_taken = false;
$select_course_query = "SELECT * FROM course";
$result_query = mysql_query($select_course_query, $link);
while($row = mysql_fetch_object($result_query)){
	$name = $row->coursename;
	if(strcmp($c_name, $name) == 0){
		$name_taken = true;
		break;
	}
}

	if($name_taken==true){
		echo json_encode(1);
	}else{
		echo json_encode(0);
	}
	
	// echo $c_name;
	// echo "<script> alertFunction(); </script>";
?>
