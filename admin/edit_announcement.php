<?php
session_start();
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
  <title>Edit Announcement</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
</head>
<body>
    <!--breadcrumb-->
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="announcement.php">Announcement</a></li>
    <li class="active">Edit Announcement</li>
    </ol>

    <form action="?action=editannouncement?taskid=<?php echo $m_id ?>" method="POST">
    <input type="hidden" name="taskid" value="<?php echo $m_id ?>">
            Annoucement: 
            <textarea name="taskname" id="taskname" rows="10" cols="80">
              <?php echo $m_taskname; ?>
            </textarea>
    <br></br>
    <input type="submit" class = "btn btn-default" name = "submit" value="Submit">
    <a class="btn btn-default" href="announcement.php">Return</a>
      <?php
          $announcement->editAnnouncement()
      ?>
    </form>
   <script>
      // Replace the <textarea id="editor1"> with a CKEditor
      // instance, using default configuration.
      CKEDITOR.replace( 'taskname' );
  </script>
</body>
</html>