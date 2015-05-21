 <?php
    session_start();
    include'../inc/db_config.php';
    include '../inc/header.php';
    include 'adminNav.php';
    $uid = $_SESSION['userid'];
    $uname = $_SESSION['username'];
    $fbid = $_GET['fbid'];
    $fbtitle = $_GET['fbtitle'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <title>Feedback Detail</title>
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
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="viewfeedback.php">Feedback</a></li>
    <li class="active">Feedback Detail</li>
    </ol>
    <table id="feedback" class="table table-striped table-bordered" cellspacing="0" >
        <thead>
        <th align="left">Sender</th>  
        <th align="left">Title</th>
        <th align="left">Content</th>
        <th align="left">Date</th>
        <th align="left">Action</th>
        </thead>
        <?php
        $fbquery= "SELECT * FROM feedback where sender_id = $uid and feedbackid = '$fbid' OR feedback_title = '$fbtitle'";
        $fbresult = mysql_query($fbquery) or die (mysql_error());
        while($fb_rows=mysql_fetch_object($fbresult))
        {
          $fbid= $fb_rows->feedbackid;
          $senderid = $fb_rows->sender_id;
          $username = $fb_rows->sender_name;
          $fbtype = $fb_rows->feedback_category;
          $fbtitle = $fb_rows->feedback_title;
          $fbcontent = $fb_rows->feedback_content;
          $fbdate = $fb_rows->date;
        ?>
        <tbody>
          <tr>
            <td align="left"><?php echo $username ?></td>
            <td align="left"><?php echo $fbtitle ?></td>
            <td><?php echo $fbcontent?></td>
            <td><?php echo $fbdate?></td>
            <?php 
            if($username == $uname)
            {
            ?>
            <td align="left" width="10%">
                       <input type="hidden" name="space">
            </td>
            <?php
            }
            else
            {
            ?>
            <td align="left" width="10%">
                        <a class="action-tooltip" href="reply.php?uid=<?php echo $senderid;?>&fbid=<?php echo $fbid?>&fbtitle=<?php echo $fbtitle ?>" title="Reply Feedback">
                            <img id="action-icon" src="../img/reply2.png">
                            <!-- Modify -->
                        </a>
            </td>
            <?php } ?>
          </tr>
        </tbody>
        <?php
          }
          echo "</table>";
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