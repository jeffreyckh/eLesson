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
include '../inc/header.php';
require_once('../view/questionView.php');
$question = new questionView();
$m_id = intval($_REQUEST['quesid']);
$query = "select * from question where questionid=$m_id";
$result = mysql_query($query);
while($m_rows=mysql_fetch_object($result))
{
	$m_content =$m_rows->content;
  $quizid = $m_rows->quizid;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Delete Question</title>
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
    <li><a href="view_question.php?qid=<?echo $quizid?>">Question List</a></li>
    <li class="active">Delete Question</li>
    </ol>
    <div class = "alert alert-warning" role="alert">
    	<strong>Are you sure you wan to delete this Question?</strong>
     	 <br>
     	 <form action="?action=deletequestion" method="POST">
    	<input type="hidden" name="quesid" value="<?php echo $m_id ?>">
    	<legend>Question</legend>
    	<textarea name="content" id="content" rows="10" cols="80"><?php echo strip_tags($m_content); ?></textarea>
    	 <br>
    	<input type="submit" class = "btn btn-default" name = "submit" value="Yes">
    	<a class="btn btn-default" href="courses_info.php?cid=<?php echo $courseid?>">No</a>
      <?php
          $question->delquizQuestion();
      ?>
    </form>
    </div>
</body>
</html>