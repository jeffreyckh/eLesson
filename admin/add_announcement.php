<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
require_once('../view/announcementView.php');
$announcement = new announcementView();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Home</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
</head>
<body>
    <!--breadcrumb-->
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="announcement.php">Announcement</a></li>
    <li class="active">Add Announcement</li>
    </ol>

    <form action="" method="POST">
            Annoucement: 
            <textarea name="taskname" id="taskname" rows="10" cols="80">
            </textarea>
    <br></br>
    <input type="submit" class = "btn btn-default" name = "submit" value="Submit">
    <a class="btn btn-default" href="announcement.php">Return</a>
      <?php
          $announcement->addAnnouncement()
      ?>
    </form>
   <script>
      // Replace the <textarea id="editor1"> with a CKEditor
      // instance, using default configuration.
      CKEDITOR.replace( 'taskname' );
  </script>
</body>
</html>