<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
require_once('../view/lessonView.php');
$lesson = new lessonView();
$m_id = intval($_REQUEST['lid']);
$query = "select * from lesson where lessonid=$m_id";
$result = mysql_query($query);
while($m_rows=mysql_fetch_object($result))
{
	$m_lessonname=$m_rows->lessonname;
  $courseid = $m_rows->direction_id;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Delete Lesson</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
</head>
<body>
    <!--breadcrumb-->
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="courses_info.php?cid=<?php echo $courseid?>">Course info</a></li>
    <li class="active">Delete Lesson</li>
    </ol>
    <div class = "alert alert-warning" role="alert">
    	<strong>Are you sure you wan to delete this Lesson?</strong>
     	 <br>
     	 <form action="?action=deletelesson?lid=<?php echo $m_id ?>" method="POST">
    	<input type="hidden" name="lid" value="<?php echo $m_id ?>">
    	<legend>Lesson</legend>
    	<textarea name="lessonname" id="lessonname" rows="10" cols="80"><?php echo strip_tags($m_lessonname); ?></textarea>
    	 <br>
    	<input type="submit" class = "btn btn-default" name = "submit" value="Yes">
    	<a class="btn btn-default" href="viewlesson.php">No</a>
      <?php
          $lesson->delviewLesson();
      ?>
    </form>
    </div>
</body>
</html>