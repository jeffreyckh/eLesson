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
$u_id=intval($_GET['uid']);
$urank = $_SESSION['rank'];
$query="select * from user where userid = $u_id";
$result=mysql_query($query);
$t = date("Y-m-d H:i:s");
$tnow = date_create ("$t");
                
while($a_rows=mysql_fetch_object($result))
    {
        $uname = $a_rows->username;
        $mailaddr = $a_rows->email;
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
      <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
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
  <!--breadcrumb-->
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="manageAccount.php">Manage Account</a></li>
    <li class="active">View Account Detail</li>
    </ol>
<?php
if($urank == 1)
{
  ?>
  <div id="lesson_container">
    <center>Password Change</center>
    <hr>
      <div class = "col-md-4">
      </div>
          <form action="" method="post">
        <table id="change-pass" class="change-pwd">
        <tr><td>Current Password :</td> <td><input type="password" name="cpassword"></td></tr>
        <tr><td>New Password :</td> <td><input type="password" name="npassword"></td></tr>
        <tr></tr>
        <tr><td>Re-type Password :</td> <td><input type="password" name="rpassword"></td></tr>
        </table>
        <br>
        <div align = "center" ><input  class="btn btn-default" name="submit" type="submit" value="Change">
          &nbsp&nbsp
          <input  class="btn btn-default" type="reset">
        </div>
      
      <?php
      if(isset($_POST['submit']))
      {
        $validquery = "SELECT password FROM user WHERE userid = $uid";
        $validresult = mysql_query($validquery) or die (mysql_error());
        $password = mysql_result($validresult,0);
        $input_cpass = $_POST['cpassword'];
        if ($input_cpass != "")
        {
          $curr_pass = MD5($input_cpass);
          if($curr_pass == $password)
          {
            $npassword = $_POST['npassword'];
            $rpassword = $_POST['rpassword'];
            if(!empty($npassword))
              {
                if(!empty($rpassword))
                  {
                    if (strlen($npassword) >= 6 && strlen($npassword) <=13 )
                      {
                        if ($npassword == $rpassword)
                        {
                          $newpassword = md5($npassword);
                          $uquery = "UPDATE user SET password = '$newpassword' WHERE userid = $uid";
                          $uresult = mysql_query($uquery) or die(mysql_error());
                          echo "<script type='text/javascript'>alert('Password changed successfully!')</script>";
                        }
                        else
                        {
                          echo "Password enetered is not same";
                        }
                      }
                      else
                      {
                        echo "The password must be 6 to 13 characters!";
                      }
                  }
                  else
                  {
                    echo "Re-type Password can not be empty!";
                  }
              }
              else
              {
                echo "New Password is empty";
              }
          }
          else
          {
            echo "You have entered wrong password";
          }
        }
        else
        {
          echo "Current password can not be empty!";
        }
      }
      ?>
    </form>
     </div>
    <?php
}
else
{
?>
  View Account Detail
  <hr>
  Username : <?php echo $uname; ?>
  <hr>
  <form action="" method="post">
  E-Mail : <?php echo $mailaddr; ?>
  <br><br>&emsp;* You can add in additional message into the Reminder Mail or leave it blank *<br>&emsp;<input type="text" name="xtraMailMsg">&emsp;&emsp;<input class="btn btn-default" type="submit" name="sendReminder" value="Send Reminder Mail">&emsp;
  <?php
    if(isset($_POST['sendReminder']))
    {
      echo 'Reminder E-mail Sent!';
    }
  ?></form>
  <hr>
      <table id = "user" class="table table-striped table-bordered" cellspacing="0">
        <thead>
            <th align="right">InComplete Lesson</th>
            <th align="right">Last View</th>
        </thead>
            <?php

                $query1="select * from user_to_lesson where userid = $u_id";
                $result1=mysql_query($query1);

                $lessonsNdate = "";

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
                              <td align="left" width="50%">
                                <?php
                                  if($days >= 7)
                                  {
                                    $temp = $diff->format("%d days, %h hours and %i minutes %s seconds ago");
                                    echo "<font color='red'>$temp</font>";
                                  }
                                  else
                                    echo $diff->format("%d days, %h hours and %i minutes %s seconds ago");
                                ?>
                              </a></td>
                            <?php
                            }
                            if($days >= 7)
                            {
                              $lessonsNdate .= " [ " . $lname . " = Last view on " . $diff->format("%d days") . " ago ]. ";
                            }
                            ?>
                            </tr>                
            <?php
                
                }
            ?>
            </tbody> 
    </table>
    <?php }?>
<script>
$(document).ready(function(){
    $('#user').DataTable(
        { 
            "dom": '<"left"l><"right"f>rt<"left"i><"right"p><"clear">'
        });
});
</script>
<?php
    if(isset($_POST['sendReminder']))
    {
      $sbj = 'Reminder of continue your lessons';
      $xtraMsg = $_POST['xtraMailMsg'];
      $msg = 'Hello, this is a gentle reminder to inform you still have uncompleted lesson. ' . $lessonsNdate . $xtraMsg . " This is an auto-generated email, please do not reply.";
      $dt = date("Y-m-d H:i:s");

      mail($mailaddr, $sbj, $msg, "From: e-Lesson");
      $mailInfo="INSERT INTO notification(type,receiver_id,date,receiver,message,readnotification,sender_id) values('Reminder','$u_id','$dt','$mailaddr','$msg','0','$uid')";
      if(!mysql_query($mailInfo))
      {
        die("Unable to store the mail into database.".mysql_error());
      }
    }
?>
</body>
</html>