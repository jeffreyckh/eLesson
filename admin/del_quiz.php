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
require_once('../view/quizView.php');
$quiz = new quizView();
$m_id=intval($_REQUEST['quizid']);
$query="select * from quiz where quizid=$m_id";
$result=mysql_query($query);
while($m_rows=mysql_fetch_object($result))
{
    $m_quizname=$m_rows->quizname;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Delete Announcement</title>
  <link rel="stylesheet" type="text/css" href="style.css">
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
    <li><a href="viewquiz.php">Quiz</a></li>
    <li class="active">Delete Quiz</li>
    </ol>

    <div class="alert alert-warning" role="alert">
      <strong>Are you sure you wan to delete this quiz?</strong>
      <br>
    <form action="?action=delquiz?quizid=<?php echo $m_id ?>" method="POST">
    <input type="hidden" name="quizid" value="<?php echo $m_id ?>">
            <legend>Annoucement:</legend>
            <textarea name="quizname" id="quizname"><?php echo strip_tags($m_quizname); ?></textarea>
    <br>
    <input type="submit" class = "btn btn-default" name = "submit" value="Yes">
    <a class="btn btn-default" href="viewquiz.php">No</a>
      <?php
          $quiz->delQuiz()
      ?>
    </form>
    </div>
</body>
</html>