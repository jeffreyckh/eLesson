<?php
session_start();
$urank = $_SESSION['rank'];
if ($urank == 3)
{
  echo '<script language="javascript">';
  echo 'alert("You have no permission to access here")';
  echo '</script>';
  
  header("Location: ../user/userHome.php");
  die();
}
include'../inc/db_config.php';
	$self_url = "get_lesson.php";



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