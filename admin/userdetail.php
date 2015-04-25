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
<<<<<<< HEAD
  <form action="" method="post">
<<<<<<< HEAD
  E-Mail : <?php echo $mailaddr; ?>
  <br><br>&emsp;* You can add in extra message into the Reminder Mail or leave it blank *<br>&emsp;<input type="text" name="xtraMailMsg">&emsp;&emsp;<input class="btn btn-default" type="submit" name="sendReminder" value="Send Reminder Mail">&emsp;
=======
  E-Mail : <?php echo $mailaddr; ?>&emsp;&emsp;<input class="btn btn-default" type="submit" name="sendReminder" value="Send Reminder Mail">&emsp;
>>>>>>> origin/kit
  <?php
    if(isset($_POST['sendReminder']))
    {
      echo 'Reminder E-mail Sent!';
    }
  ?></form>
  <hr>
=======
>>>>>>> parent of 48a8759... lam sync test
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
                            $lessonsNdate .= " [ " . $l_rows->lessonname . " = ";
>>>>>>> origin/kit
=======

                        
>>>>>>> parent of 48a8759... lam sync test
            ?>
                            
                            <td align="left" width="50%"><?php echo $lname ?></a></td>
                            <?php }
                            $days = $diff->format("%d");
                            $hours = $diff->format("%h");
                            $minutes = $diff->format("%i");
                            if($days == 0)
                            {
                              if($hours == 0)
                              {
                            ?>
                            <td align="left" width="50%"><?php echo $diff->format("%i minutes %s seconds ago" ) ?></a></td>
                            <?php    
                              }
                              else
                              {
                            ?>
                                <td align="left" width="50%"><?php echo $diff->format("%h hours and %i minutes %s seconds ago" ) ?></a></td>
                            <?php
                              }
                            }
                            else
                            {
                            ?>
                              <td align="left" width="50%"><?php echo $diff->format("%d days, %h hours and %i minutes %s seconds ago" ) ?></a></td>
                            <?php
                            }
<<<<<<< HEAD
<<<<<<< HEAD
                            if($days > 7)
                            {
                              $lessonsNdate .= " [ " . $l_rows->lessonname . " = Last view on " . $diff->format("%d days") . " ago ]. ";
                            }
=======
                            $lessonsNdate .= "Last view on " . $diff->format("%d days") . " ago ]";
>>>>>>> origin/kit
=======
>>>>>>> parent of 48a8759... lam sync test
                            ?>
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
<<<<<<< HEAD
<?php
    if(isset($_POST['sendReminder']))
    {
      $sbj = 'Reminder of continue your lessons';
<<<<<<< HEAD
      $xtraMsg = $_POST['xtraMailMsg'];
      $msg = 'Hello, this is a gentle reminder to inform you still have uncompleted lesson. ' . $lessonsNdate . $xtraMsg . " This is an auto-generated email, please do not reply.";
=======
      //$msg = 'Hello, this is a gentle reminder to inform you still have uncompleted lesson, please continue your lessons\n'. $diff->format("%d days, %h hours and %i minutes %s seconds ago" ).' This is an auto generated e-mail, please do not reply.';
      $msg = 'Hello, this is a gentle reminder to inform you still have uncompleted lesson, ' . $lessonsNdate . ". This is an auto-generated email, please do not reply.";
>>>>>>> origin/kit
      $dt = date("Y-m-d H:i:s");

      mail($mailaddr, $sbj, $msg, "From: e-Lesson");
      $mailInfo="insert into email(date,receiver,message) values('$dt','$mailaddr','$msg')";
      if(!mysql_query($mailInfo))
      {
        die("Unable to store the mail into database.".mysql_error());
      }
    }
?>
=======
>>>>>>> parent of 48a8759... lam sync test
</body>
</html>