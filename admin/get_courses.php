<?php
session_start();
$self_url = "get_courses.php";
include'../inc/db_config.php';
require_once('../view/userView.php');
// $user = new userView();
$m_id=intval($_REQUEST['uid']);

$rank = "";
if(isset($_GET['rank'])){
	$rank = $_GET['rank'];
}

if($rank == 2){
	$query1 = "SELECT * FROM course";
	$result1 = mysql_query($query1, $link);

	// echo "<tr>";

	echo "<td width=\"20%\">Course: </td>";
	echo "<td>";
	while($m_rows=mysql_fetch_object($result1))
	{

	 $cquery = "SELECT * from permission where courseid = $m_rows->courseid and userid = $m_id";
	 $cresult = mysql_query($cquery);
	 if (mysql_num_rows($cresult) == 0) 
	  {
	    echo "<input type=\"checkbox\" name=\"permCourse[]\" value=\"$m_rows->courseid\" />".$m_rows->coursename."</br>";
	  }
	else
	  {
	    echo "<input type=\"checkbox\" name=\"permCourse[]\" value=\"$m_rows->courseid\" checked/>".$m_rows->coursename."</br>";
	  }

	}
	echo "</td>";
}else{
	// Display nothing
}




// echo "</tr>";
?>

