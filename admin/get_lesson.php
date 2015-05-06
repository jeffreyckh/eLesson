<?php
session_start();
include'../inc/db_config.php';
	$self_url = "get_lesson.php";



	// if(!isset($_GET['c_id'])){
	// 	$course_id = " ";

	// 	show_lesson_selection($self_url);
	// }else{
	// 	if(isset($_GET['c_id'])){
	// 		$c_id = $_GET['c_id'];
	// 	}


	// }

	?>
	<!-- <select name = "sel_lesson" id = "sel_lesson" form="quizform"> -->
    	<option value='' disabled selected> --- Select a Lesson --- </option>
    	<?php
    	if(isset($_GET['c_id'])){
    		$c_id = $_GET['c_id'];
    		$select_query = "SELECT * FROM lesson WHERE direction_id=$c_id";
    		$result = mysql_query($select_query, $link);
    		while($row = mysql_fetch_object($result)){
    			?>
    			<option value="<?php echo $row->lessonid ?>,<?php echo $row->lessonname ?>">
    				<?php echo $row->lessonname ?>
    			</option>
    			<?php
    		}
    	}
    	?>
	<!-- </select> -->
	<?php

	
?>