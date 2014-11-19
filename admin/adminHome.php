<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
//include 'adminNav.php';
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
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <li role="presentation" class="active"><a href="#viewAnnouncement" role="tab" data-toggle="tab">View Announcement</a></li>
    <li role="presentation"><a href="#createAnnouncement" role="tab" data-toggle="tab">Create Announcement</a></li>
  </ul>

  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="viewAnnouncement">
      <?php
            $query="select * from announcement order by taskdate";
            $result=mysql_query($query);
            while($a_rows=mysql_fetch_object($result))
            {
              
        
            echo "<fieldset>
               No: ".$a_rows->taskid." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               Posting Date:".$a_rows->taskdate."
               <br></br>
               Annoucement:".$a_rows->taskname."
               </fieldset>";
              echo "<hr>";
            }
      ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="createAnnouncement">
    <form action="" method="POST">
            Annoucement: 
            <textarea name="taskname" id="taskname" rows="10" cols="80">
            </textarea>
    <br></br>
    Posting Date: <input type="date" name="taskdate" id = "taskdate" style="width: 500px;" style = "height: 300px;" >
    <br></br>
    <input type="submit" name = "submit" value="Submit">
      <?php
          $announcement->addAnnouncement()
      ?>
    </form>
    </div>


  <script>
    $(function () {
      $('#myTab a[href="#viewAnnouncement"]').tab('show')
    })
  </script>
   <script>
      // Replace the <textarea id="editor1"> with a CKEditor
      // instance, using default configuration.
      CKEDITOR.replace( 'taskname' );
  </script>
</body>
</html>