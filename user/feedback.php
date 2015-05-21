 <?php
    session_start();
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'userNav.php';
    $uid = $_SESSION['userid'];
    $query = " select * from user where userid = $uid";
    $result = mysql_query($query);
    while($rows=mysql_fetch_object($result))
    {
        $uname = $rows->username;
    }
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <title>Feedback Form</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../jscss/tablesorter/css/theme.blue.css">
    <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../jscss/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="../jscss/dist/js/bootstrap.min.js"></script>
     <script src="../jscss/datatable/jquery.dataTables.min.js"></script> 
     <script src="../jscss/datatable/jquery.dataTables.bootstrap.js"></script>   
</head>
<body>
    <ol class="breadcrumb">
    <li><a href="userHome.php">Home</a></li>
    <li class="active">Feedback</li>
    </ol>
    <div align = "right">
        <a id="submit-btn" href="feedbackform.php" class = " btn btn-default">
            <img src="../img/submitfeedback_white.png">
            Submit Feedback
        </a>
    </div>
    <hr>
    <div align = "center">

        <table id="feedback" class="table table-striped table-bordered" cellspacing="0" >
        <thead>    
        <th align="left">Type</th>
        <th align="left">Title</th>
        <th align="left">Date</th>
        </thead>
        <?php
        $fbquery= "SELECT * FROM feedback where sender_id = $uid and feedback_category != 'Reply'";
        $fbresult = mysql_query($fbquery) or die (mysql_error());
        while($fb_rows=mysql_fetch_object($fbresult))
        {
            $fbid= $fb_rows->feedbackid;
          $senderid = $fb_rows->sender_id;
          $username = $fb_rows->sender_name;
          $fbtype = $fb_rows->feedback_category;
          $fbtitle = $fb_rows->feedback_title;
          $fbdate = $fb_rows->date;
        ?>
        <tbody>
          <tr>
            <td><?php echo $fbtype; ?></td>
            <td align="left"><a href="feedbackdetail.php?fbid=<?php echo $fbid ?>&fbtitle=<?php echo $fbtitle ?>"><?php echo $fbtitle ?></a></td>
            <td><?php echo $fbdate?></td>
          </tr>
        </tbody>
        <?php
          }
          echo "</table>";
        ?>

</div>
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