<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
include 'adminNav.php';
$u_id=intval($_GET['uid']);
$query="select * from user where userid = $u_id";
$result=mysql_query($query);
$t = date("Y-m-d H:i:s");
$tnow = date_create ("$t");
                
while($a_rows=mysql_fetch_object($result))
    {
        $uname = $a_rows->username;
    }
//require_once('../view/announcementView.php');
//$announcement = new announcementView();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>View Account detail</title>
      <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../jscss/tablesorter/css/theme.blue.css">
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
    <li><a href="manageAccount.php">Manage Account</a></li>
    <li class="active">View Account Detail</li>
    </ol>
    <div align="right">
    </form>
  </div>
  View Account Detail
  <hr>
  Username : <?php echo $uname; ?>
  <hr>
      <table id = "user" class="table table-striped table-bordered" cellspacing="0">
        <thead>
            <th align="right">InComplete Lesson</th>
            <th align="right">Last View</th>
        </thead>
            <?php

                $query1="select * from user_to_lesson where userid = $u_id";
                $result1=mysql_query($query1);
                echo "<tbody>";
                while($u_rows=mysql_fetch_object($result1))
                {
                    $uid = $u_rows->userid;
                    $lid = $u_rows->lessonid;
                    $vdate = $u_rows->viewtime;
                    $vtime = date_create ("$vdate");

                    $diff=date_diff($vtime,$tnow);

                    echo "<tr>";
                    $lquery = "select * from lesson where lessonid = $lid";
                    $lresult = mysql_query($lquery);
                    while($l_rows = mysql_fetch_object($lresult))
                        {
                            $lname = $l_rows->lessonname;

                        
            ?>
                            
                            <td align="left" width="50%"><?php echo $lname ?></a></td>
                            <?php } ?>
                            <td align="left" width="50%"><?php echo $diff->format("%d days, %h hours and %i minuts ago" ) ?></a></td>
                            </tr>                
            <?php
                        
                }
            ?>
            </tbody> 
    </table>
<script>
$(document).ready(function(){
    $('#user').DataTable(
        { 
            "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">'
        });
});
</script>
</body>
</html>