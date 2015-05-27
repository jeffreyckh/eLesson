<?php
include "../inc/db_config.php";

if(isset($_POST['l_name'])){
	$l_name = $_POST['l_name'];
}

// If checking addition of new lessons
// Check if the name is already taken
$name_taken = false;
$select_lesson_query = "SELECT * FROM lesson";
$result_query = mysql_query($select_lesson_query, $link);
while($row = mysql_fetch_object($result_query)){
	$name = $row->lessonname;
	if(strcmp($l_name, $name) == 0){
		$name_taken = true;
		break;
	}
}

	if($name_taken==true){
		echo json_encode(1);
	}else{
		echo json_encode(0);
	}

?>
