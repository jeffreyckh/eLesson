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
include 'adminNav.php';
require_once('../view/announcementView.php');
$announcement = new announcementView();
$m_id=intval($_REQUEST['taskid']);
$query="select taskname from announcement where taskid=$m_id";
$result=mysql_query($query);
while($m_rows=mysql_fetch_object($result))
{
    $m_taskname=$m_rows->taskname;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Delete Announcement</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" type="text/css" href="style.css">
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
    <li><a href="announcement.php">Announcement</a></li>
    <li class="active">Delete Announcement</li>
    </ol>

    <div class="alert alert-warning" role="alert">
      <strong>Are you sure you wan to delete this announcement?</strong>
      <br>
    <form action="?action=delannouncement?taskid=<?php echo $m_id ?>" method="POST">
    <input type="hidden" name="taskid" value="<?php echo $m_id ?>">
            <legend>Annoucement:</legend>
            <textarea name="taskname" id="taskname" rows="10" cols="80"><?php echo strip_tags($m_taskname); ?></textarea>
    <br>
    <input type="submit" class = "btn btn-default" name = "submit" value="Yes">
    <a class="btn btn-default" href="announcement.php">No</a>
      <?php
          $announcement->delAnnouncement()
      ?>
    </form>
    </div>
</body>
</html>