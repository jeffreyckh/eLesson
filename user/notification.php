<?php
 session_start();
$urank = $_SESSION['rank'];
$uid = $_SESSION['userid'];
include'../inc/db_config.php';
include '../inc/header.php';
include 'userNav.php';
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
    <li><a href="userHome.php">Home</a></li>
    <li class="active">Notification</li>
    </ol>

  <table id="notification" class="table table-striped table-bordered" cellspacing="0" >
        <thead>    
        <th align="left">Type</th>
        <th align="left">Message</th>
        <th align="left">Date</th>
        </thead>
        <?php
        $nquery= "SELECT * FROM notification";
        $nresult = mysql_query($nquery) or die (mysql_error());
        while($n_rows=mysql_fetch_object($nresult))
        {
          $ntype = $n_rows->type;
          $ncontent = $n_rows->message;
          $ndate = $n_rows->date;
        ?>
        <tbody>
          <tr>
            <td><?php echo $ntype; ?></td> 
            <td><?php echo $ncontent?></td>
            <td><?php echo $ndate?></td>
          </tr>
        </tbody>
        <?php
          }
        ?>
<script>
$(document).ready(function(){
    $('#notification').DataTable(
        { 
            "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">'
        });
});
</script>        
</body>
</html>