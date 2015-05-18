<?php
 session_start();
$urank = $_SESSION['rank'];
$uid = $_SESSION['userid'];
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="FeedBack">
  <meta name="description" content="FeedbackPage">
  <title>Feedback</title>
  <link rel="stylesheet" href="../jscss/tablesorter/css/theme.blue.css">
  <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../jscss/datatable/jquery.dataTables.min.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="../jscss/dist/js/bootstrap.min.js"></script>
     <script src="../jscss/datatable/jquery.dataTables.min.js"></script> 
     <script src="../jscss/datatable/jquery.dataTables.bootstrap.js"></script>
</head>
<body>
  <!--breadcrumb-->
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li class="active">Feedback</li>
    </ol>

  <table id="feedback" class="table table-striped table-bordered" cellspacing="0" >
        <thead>    
        <th align="left">User</th>
        <th align="left">Type</th>
        <th align="left">Title</th>
        <th align="left">Content</th>
        <th align="left">Date</th>
        <th align="left">Action</th>
        </thead>
        <?php
        $fbquery= "SELECT * FROM feedback";
        $fbresult = mysql_query($fbquery) or die (mysql_error());
        while($fb_rows=mysql_fetch_object($fbresult))
        {
          $senderid = $fb_rows->sender_id;
          $username = $fb_rows->sender_name;
          $fbtype = $fb_rows->feedback_category;
          $fbtitle = $fb_rows->feedback_title;
          $fbcontent = $fb_rows->feedback_content;
          $fbdate = $fb_rows->date;
        ?>
        <tbody>
          <tr>
            <td><?php echo $username; ?></td>
            <td><?php echo $fbtype; ?></td>
            <td><?php echo $fbtitle; ?></td>
            <td><?php echo $fbcontent?></td>
            <td><?php echo $fbdate?></td>
            <td align="left" width="10%">
                        <a href="reply.php?uid=<?php echo $senderid;?>">
                            <img id="action-icon" src="../img/reply.png">
                            <!-- Modify -->
                        </a>
            </td>
          </tr>
        </tbody>
        <?php
          }
        ?>
        <script>
$(document).ready(function(){
    $('#feedback').DataTable(
        { 
            "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">'
        });
});
</script>
</body>
</html>